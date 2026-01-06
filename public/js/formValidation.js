const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

const validationConfig = {
  name: {
    label: "your name",
    validate(value) {
      const trimmed = value.trim();
      if (!trimmed) {
        return {
          valid: false,
          type: "missing",
          message: "Please enter your name.",
        };
      }
      return { valid: true };
    },
  },
  email: {
    label: "your email",
    validate(value) {
      const trimmed = value.trim();
      if (!trimmed) {
        return {
          valid: false,
          type: "missing",
          message: "Please enter your email address.",
        };
      }
      if (!emailPattern.test(trimmed)) {
        return {
          valid: false,
          type: "invalid",
          message: "Please enter a valid email address.",
        };
      }
      return { valid: true };
    },
  },
  telephone: {
    label: "your telephone number",
    validate(value) {
      const trimmed = value.trim();
      if (!trimmed) {
        return {
          valid: false,
          type: "missing",
          message: "Please enter your telephone number.",
        };
      }
      const digitCount = trimmed.replace(/\D/g, "").length;
      if (digitCount < 10) {
        return {
          valid: false,
          type: "invalid",
          message: "Please enter a valid telephone number.",
        };
      }
      return { valid: true };
    },
  },
  message: {
    label: "message",
    validate(value) {
      const trimmed = value.trim();
      if (!trimmed) {
        return {
          valid: false,
          type: "missing",
          message: "Please enter a message.",
        };
      }
      if (trimmed.length < 5) {
        return {
          valid: false,
          type: "invalid",
          message: "Message must be at least 5 characters.",
        };
      }
      if (trimmed.length > 1000) {
        return {
          valid: false,
          type: "invalid",
          message: "Message must be 1000 characters or fewer.",
        };
      }
      return { valid: true };
    },
  },
};

export function validateContactForm(form) {
  const errors = {};
  const fieldStatus = {};

  for (const [fieldName, config] of Object.entries(validationConfig)) {
    const field = form.elements[fieldName];
    if (!field) continue;

    const value = field.value;
    const result = config.validate(value);

    if (result.valid) {
      fieldStatus[fieldName] = "valid";
    } else {
      fieldStatus[fieldName] = "invalid";
      errors[fieldName] = {
        label: config.label,
        type: result.type,
        message: result.message,
      };
    }
  }

  return { isValid: Object.keys(errors).length === 0, errors, fieldStatus };
}
