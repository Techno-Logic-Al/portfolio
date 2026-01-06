# Portfolio

Personal portfolio site built with PHP, vanilla JS, and custom CSS (glass UI + animated background video).

## Requirements

- PHP 8.0+
- A web server that can run PHP (Apache recommended for `.htaccess` rewrite rules)
- Optional: Composer (for SMTP email via PHPMailer)
- Optional: MySQL/MariaDB (to store contact form submissions)

## Setup

1. Clone the repo and point your web server docroot to `public/` (recommended).
   - Apache: set your VirtualHost `DocumentRoot` to this repoâ€™s `public/` directory.
2. If you want outbound email from the contact form, install PHP dependencies:
   - `composer install --no-dev --optimize-autoloader`
3. Create your `.env` from `.env.example` and fill in values (see below).
4. Update profile details in `config/profile.php`.

## Local development (PHP built-in server)

From the repo root:

- `php -S localhost:8000 -t public public/router.php`

## `.env` configuration

This project reads environment variables from a plain text `.env` file in the project root (the file is intentionally gitignored).

Start from `.env.example`, then set:

### Database (contact form storage)

- `DB_HOST` (default `localhost`)
- `DB_PORT` (default `3306`)
- `DB_NAME`
- `DB_USER`
- `DB_PASS`
- `DB_CHARSET` (default `utf8mb4`)

The contact form stores submissions in a `contact_messages` table. Minimal schema:

```sql
CREATE TABLE contact_messages (
  id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  company VARCHAR(150) NULL,
  email VARCHAR(255) NOT NULL,
  telephone VARCHAR(30) NOT NULL,
  message TEXT NOT NULL,
  status VARCHAR(20) NOT NULL DEFAULT 'new',
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);
```

### SMTP (optional email notifications)

If PHPMailer is installed (via Composer) and all SMTP values are present, the contact form can also send an email notification.

- `SMTP_HOST` (default `smtp.office365.com`)
- `SMTP_PORT` (default `587`)
- `SMTP_USER`
- `SMTP_PASS`
- `SMTP_ENCRYPTION` (default `tls`)
- `SMTP_FROM` (defaults to `SMTP_USER` if unset)
- `SMTP_TO` (defaults to `SMTP_USER` if unset)

## Notes

- Pretty URLs are configured via `public/.htaccess`. If you deploy on Nginx, youâ€™ll need equivalent rewrite rules.
- This is a PHP site (not compatible with static hosts like GitHub Pages).

