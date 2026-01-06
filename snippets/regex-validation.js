// Basic email validation
const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

export function validateContactForm(form) {
  const errors = {};
  const fieldStatus = {};

  const checks = {
    name: (value) => {
      const trimmed = value.trim();
      if (!trimmed) return { valid: false, type: "missing", message: "Please enter your name." };
      return { valid: true };
    },
    email: (value) => {
      const trimmed = value.trim();
      if (!trimmed) return { valid: false, type: "missing", message: "Please enter your email address." };
      if (!emailPattern.test(trimmed)) {
        return { valid: false, type: "invalid", message: "Please enter a valid email address." };
      }
      return { valid: true };
    },
    telephone: (value) => {
      const trimmed = value.trim();
      if (!trimmed) return { valid: false, type: "missing", message: "Please enter your telephone number." };
      if (trimmed.replace(/\D/g, "").length < 10) {
        return { valid: false, type: "invalid", message: "Please enter a valid telephone number." };
      }
      return { valid: true };
    },
    message: (value) => {
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
  };

  Object.entries(checks).forEach(([name, check]) => {
    const field = form.elements[name];
    if (!field) return;

    const result = check(field.value);
    fieldStatus[name] = result.valid ? "valid" : "invalid";
    if (!result.valid) errors[name] = { label: name, type: result.type, message: result.message };
  });

  return { isValid: Object.keys(errors).length === 0, errors, fieldStatus };
}
