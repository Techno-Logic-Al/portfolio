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
    form.setAttribute("novalidate", "");

    form.addEventListener("submit", (event) => {
      event.preventDefault();

      const { isValid, errors } = validateContactForm(form);

      form.querySelectorAll(".error").forEach((el) => el.remove());

      if (!isValid) {
        for (const [field, message] of Object.entries(errors)) {
          const input = form.elements[field];
          const error = document.createElement("span");
          error.className = "error";
          error.textContent = message;
          input.insertAdjacentElement("afterend", error);
        }
      } else {
        alert("Form submitted successfully!");
        form.reset();
      }
    });
  }
});
