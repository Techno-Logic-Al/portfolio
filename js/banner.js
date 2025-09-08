import { animateSection } from './animationHelper.js';

export function toggleBurgerMenu() {
  const burgerBtn = document.querySelector(".header-btn");
  if (!burgerBtn) return;
  burgerBtn.addEventListener("click", () => {
    burgerBtn.classList.toggle("active");
  });
}

export function initBannerParticles() {
  const container = document.querySelector(".banner-particles");
  if (!container || typeof particlesJS === "undefined") return;
  const id = container.id || "banner-particles";
  container.id = id;

  particlesJS(id, {
    particles: {
      number: { value: 200, density: { enable: true, value_area: 800 } },
      color: { value: "#ebe6e3" },
      shape: { type: "circle" },
      opacity: { value: 0.5, random: true },
      size: { value: 20, random: true },
      line_linked: {
        enable: false, //Disables or enables joining lines between the particles//
        distance: 150,
        color: "#ebe6e3",
        opacity: { value: 0.5, random: true },
        width: { value: 1, random: true },
      },
      move: { enable: true, speed: 3 },
    },
    interactivity: {
      events: {
        onhover: { enable: true, mode: "repulse" },
      },
      modes: {
        repulse: { distance: 100 },
      },
    },
    retina_detect: true,
  });
}

export function animateBannerText() {
  animateSection({
    rootSelector: '.banner-message',
    itemSelector: '.banner-line, .banner-pic',
  });
}
