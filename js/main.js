import { toggleSidebar } from "./sidebar.js";
import { toggleBurgerMenu, initBannerParticles, animateBannerText } from "./banner.js";
import { animateAboutMeText } from "./aboutMe.js";
import { animateCodingExamplesText } from "./codingExamples.js";
import { animateScionSchemeText } from "./scionScheme.js";
import { validateContactForm } from "./formValidation.js";
import { initScrollAnimations } from "./scrollAnimations.js";

document.addEventListener("DOMContentLoaded", () => {
  const toggleBtn = document.querySelector("#sidebarToggle");
  const sidebar = document.querySelector("#sidebar");

  if (toggleBtn) {
    toggleBtn.addEventListener("click", () => toggleSidebar(sidebar));
  }

  toggleBurgerMenu();
  initBannerParticles();
  animateBannerText();
  animateAboutMeText();
  animateCodingExamplesText();
  animateScionSchemeText();
  initScrollAnimations();

  const form = document.querySelector(".contact-box");

  if (form) {
    const statusMessageEl = form.querySelector(".form-message");
    const submitButton = form.querySelector(".contact-button");
    const requiredFields = ["name", "email", "telephone", "message"];
    const optionalFields = ["company"];
    let showErrors = false;
    let hasJustSent = false;

    const formatList = (items) => {
      if (items.length === 1) return items[0];
      if (items.length === 2) return `${items[0]} and ${items[1]}`;
      return `${items.slice(0, -1).join(", ")} and ${items[items.length - 1]}`;
    };

    const buildFormMessage = (errors) => {
      const errorEntries = Object.entries(errors);
      if (!errorEntries.length) return "";

      const missingFields = [];
      const otherIssues = [];

      const missingFieldNames = {
        name: "your name",
        email: "email",
        telephone: "telephone number",
        message: "message",
      };

      for (const [, error] of errorEntries) {
        if (error.type === "missing") continue;
        otherIssues.push(error.message);
      }

      const parts = [];

      requiredFields.forEach((fieldName) => {
        const error = errors[fieldName];
        if (error && error.type === "missing") {
          const displayName = missingFieldNames[fieldName] || error.label;
          missingFields.push(displayName);
        }
      });

      if (missingFields.length) {
        const list = formatList(missingFields);
        parts.push(`Please complete: ${list}.`);
      }

      if (otherIssues.length) {
        const uniqueIssues = [...new Set(otherIssues)];
        const validityPattern = /^Please enter a valid (.+?)(?:\.)?$/;
        const validIssues = [];
        const remainingIssues = [];

        uniqueIssues.forEach((message) => {
          const match = message.match(validityPattern);
          if (match) {
            validIssues.push(match[1]);
          } else {
            remainingIssues.push(message);
          }
        });

        if (validIssues.length === 1) {
          remainingIssues.unshift(`Please enter a valid ${validIssues[0]}.`);
        } else if (validIssues.length > 1) {
          const list = formatList(validIssues.map((field) => `a valid ${field}`));
          remainingIssues.unshift(`Please enter ${list}.`);
        }

        if (remainingIssues.length) {
          parts.push(remainingIssues.join(" "));
        }
      }

      return parts.join(" ");
    };

    const updateFieldStyles = (fieldStatus) => {
      if (submitButton) {
        submitButton.classList.remove("button-error", "button-success");
      }

      requiredFields.forEach((name) => {
        const field = form.elements[name];
        if (!field) return;
        field.classList.remove("field-valid", "field-invalid");
        if (fieldStatus[name] === "valid") {
          field.classList.add("field-valid");
        } else if (fieldStatus[name] === "invalid") {
          field.classList.add("field-invalid");
        }
      });

      optionalFields.forEach((name) => {
        const field = form.elements[name];
        if (!field) return;
        field.classList.remove("field-valid", "field-invalid");
        if (field.value.trim().length > 0) {
          field.classList.add("field-valid");
        }
      });

      if (submitButton) {
        const anyInvalid = requiredFields.some((name) => fieldStatus[name] === "invalid");
        const allValid =
          requiredFields.length > 0 &&
          requiredFields.every((name) => fieldStatus[name] === "valid");

        if (anyInvalid) {
          submitButton.classList.add("button-error");
        } else if (allValid) {
          submitButton.classList.add("button-success");
        }
      }
    };

    const applyStatusMessage = (errors) => {
      if (!statusMessageEl) return;

      if (!showErrors) {
        return;
      }

      const messageText = buildFormMessage(errors);
      statusMessageEl.textContent = messageText;

      if (messageText) {
        statusMessageEl.classList.add("has-error");
        statusMessageEl.classList.remove("success");
      } else {
        statusMessageEl.classList.remove("has-error");
      }
    };

    form.setAttribute("novalidate", "");

    form.addEventListener("submit", async (event) => {
      event.preventDefault();

      showErrors = true;

      const { isValid, errors, fieldStatus } = validateContactForm(form);

      updateFieldStyles(fieldStatus);

      if (!isValid) {
        applyStatusMessage(errors);
      } else {
        if (statusMessageEl) {
          statusMessageEl.textContent = "";
          statusMessageEl.classList.remove("has-error", "success");
        }

        try {
          const formData = new FormData(form);
          const response = await fetch("index.php", {
            method: "POST",
            headers: {
              "X-Requested-With": "XMLHttpRequest",
            },
            body: formData,
          });

          const result = await response.json();

          if (!result.ok) {
            if (result.fieldStatus && result.errors) {
              updateFieldStyles(result.fieldStatus);
              applyStatusMessage(result.errors);
              showErrors = true;
            } else if (statusMessageEl && result.message) {
              statusMessageEl.textContent = result.message;
              statusMessageEl.classList.add("has-error");
              statusMessageEl.classList.remove("success");
              showErrors = true;
            }

            return;
          }

          form.reset();

          requiredFields.forEach((name) => {
            const field = form.elements[name];
            if (field) {
              field.classList.remove("field-valid", "field-invalid");
            }
          });

          optionalFields.forEach((name) => {
            const field = form.elements[name];
            if (field) {
              field.classList.remove("field-valid", "field-invalid");
            }
          });

          if (submitButton) {
            submitButton.classList.remove("button-error", "button-success");
          }

          if (statusMessageEl) {
            statusMessageEl.textContent = result.message || "message sent!";
            statusMessageEl.classList.remove("has-error");
            statusMessageEl.classList.add("success");
          }

          showErrors = false;
          hasJustSent = true;
        } catch (error) {
          if (statusMessageEl) {
            statusMessageEl.textContent =
              "There was a problem sending your message. Please try again later.";
            statusMessageEl.classList.add("has-error");
            statusMessageEl.classList.remove("success");
          }
        }
      }
    });

    form.addEventListener("input", (event) => {
      const target = event.target;
      if (
        !target.name ||
        (!requiredFields.includes(target.name) && !optionalFields.includes(target.name))
      ) {
        return;
      }

      // Clear any existing status message (including "message sent!") 
      // when the user starts editing again.
      if (statusMessageEl && statusMessageEl.textContent) {
        statusMessageEl.textContent = "";
        statusMessageEl.classList.remove("success", "has-error");
        hasJustSent = false;
      }

      const { errors, fieldStatus } = validateContactForm(form);
      updateFieldStyles(fieldStatus);

      if (showErrors) {
        applyStatusMessage(errors);
      }
    });

    form.addEventListener("focusin", () => {
      if (statusMessageEl && statusMessageEl.textContent) {
        statusMessageEl.textContent = "";
        statusMessageEl.classList.remove("success", "has-error");
        hasJustSent = false;
      }
    });
  }
});
