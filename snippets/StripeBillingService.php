    protected function syncCreditPackCheckout(array $session, ?User $user = null): array
    {
        $user ??= $this->resolveUserFromCheckoutSession($session);

        if ($user === null || (string) ($session['payment_status'] ?? '') !== 'paid') {
            return [
                'credits_added' => 0,
                'credited_now' => false,
            ];
        }

        $offerKey = $this->normalizeCreditPackKey(
            (string) (data_get($session, 'metadata.offer') ?: data_get($session, 'metadata.plan'))
        );

        if ($offerKey === null) {
            return [
                'credits_added' => 0,
                'credited_now' => false,
            ];
        }

        $credits = max(
            0,
            (int) (config("billing.credit_packs.{$offerKey}.credits")
                ?: data_get($session, 'metadata.credits'))
        );
        $sessionId = (string) ($session['id'] ?? '');

        if ($credits === 0 || $sessionId === '') {
            return [
                'credits_added' => 0,
                'credited_now' => false,
            ];
        }

        $creditedNow = DB::transaction(function () use ($credits, $offerKey, $session, $sessionId, $user): bool {
            $existingPurchase = CreditPurchase::query()
                ->where('stripe_checkout_session_id', $sessionId)
                ->first();

            if ($existingPurchase !== null) {
                return false;
            }

            $lockedUser = User::query()
                ->lockForUpdate()
                ->findOrFail($user->getKey());

            try {
                CreditPurchase::query()->create([
                    'user_id' => $lockedUser->getKey(),
                    'offer_key' => $offerKey,
                    'credits_granted' => $credits,
                    'stripe_checkout_session_id' => $sessionId,
                    'stripe_payment_intent_id' => is_string($session['payment_intent'] ?? null)
                        ? $session['payment_intent']
                        : null,
                    'stripe_customer_id' => is_string(data_get($session, 'customer')) ? data_get($session, 'customer') : null,
                    'stripe_price_id' => config("billing.credit_packs.{$offerKey}.stripe_price_id"),
                    'amount_total' => is_numeric($session['amount_total'] ?? null) ? (int) $session['amount_total'] : null,
                    'currency' => is_string($session['currency'] ?? null) ? strtolower((string) $session['currency']) : null,
                    'status' => is_string($session['payment_status'] ?? null) ? $session['payment_status'] : null,
                ]);
            } catch (QueryException) {
                return false;
            }

            $lockedUser->credit_balance = $lockedUser->creditBalance() + $credits;

            $customerId = data_get($session, 'customer');

            if (is_string($customerId) && $customerId !== '') {
                $lockedUser->stripe_customer_id = $customerId;
            }

            $lockedUser->save();

            return true;
        });

        return [
            'credits_added' => $credits,
            'credited_now' => $creditedNow,
        ];
    }