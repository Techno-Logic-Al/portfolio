export function validateContactForm(form) {
  const firstName = form.elements["firstName"].value.trim();
  const lastName = form.elements["lastName"].value.trim();
  const email = form.elements["email"].value.trim();
  const subject = form.elements["subject"].value.trim();
  const message = form.elements["textArea"].value.trim();

  let isValid = true;
  let errors = [];

  if (!/^[A-Za-z\s\-']{2,}$/.test(firstName)) {
    isValid = false;
    errors.push(
      "First name must be at least 2 letters and contain only letters, spaces, hyphens, or apostrophes.",
    );
  }

  if (!/^[A-Za-z\s\-']{2,}$/.test(lastName)) {
    isValid = false;
    errors.push(
      "Last name must be at least 2 letters and contain only letters, spaces, hyphens, or apostrophes.",
    );
  }

  if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
    isValid = false;
    errors.push("Please enter a valid email address.");
  }

  if (subject.length < 3) {
    isValid = false;
    errors.push("Subject must be at least 3 characters.");
  }

  if (message.length < 1 || message.length > 1000) {
    isValid = false;
    errors.push("Message must be between 1 and 1000 characters.");
  }

  return { isValid, errors };
}
