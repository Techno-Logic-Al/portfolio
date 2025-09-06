import { toggleSidebar } from "./sidebar.js";
import { toggleBurgerMenu } from "./banner.js";
import { validateContactForm } from "./formValidation.js";

document.addEventListener("DOMContentLoaded", () => {
  const toggleBtn = document.querySelector("#sidebarToggle");

  if (toggleBtn) {
    toggleBtn.addEventListener("click", toggleSidebar);
  }

  toggleBurgerMenu();

  const form = document.querySelector(".contact-box");

  if (form) {
    form.setAttribute("novalidate", "");

    form.addEventListener("submit", (event) => {
      event.preventDefault();

      const { isValid, errors } = validateContactForm(form);

      if (!isValid) {
        alert(errors.join("\n"));
      } else {
        alert("Form submitted successfully!");
        form.reset();
      }
    });
  }
});
