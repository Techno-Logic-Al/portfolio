const validationRules = {
  firstName: {
    test: /^[A-Za-z\s\-']{2,}$/,
    message: "First name must be at least 2 letters and contain only letters, spaces, hyphens or apostrophes.",
  },
  lastName: {
    test: /^[A-Za-z\s\-']{2,}$/,
    message: "Last name must be at least 2 letters and contain only letters, spaces, hyphens or apostrophes.",
  },
  email: {
    test: /^[^\s@]+@[^\s@]+\.[^\s@]+$/,
    message: "Please enter a valid email address.",
  },
  subject: {
    test: (value) => value.length >= 3,
    message: "Subject must be at least 3 characters.",
  },
  textArea: {
    test: (value) => value.length >= 1 && value.length <= 1000,
    message: "Message must be between 1 and 1000 characters.",
  },
};

export function validateContactForm(form) {
  const errors = {};
  for (const [field, rule] of Object.entries(validationRules)) {
    const value = form.elements[field].value.trim();
    const valid = rule.test instanceof RegExp ? rule.test.test(value) : rule.test(value);
  if (!valid) {
    errors[field] = rule.message;
    }
  }
  return { isValid: Object.keys(errors).length === 0, errors };
}
