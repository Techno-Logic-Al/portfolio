export function initScrollAnimations() {
  const projectCards = document.querySelectorAll(".project");
  const contactSection = document.querySelector(".contact-info");
  const elements = [...projectCards, contactSection].filter(Boolean);

  if (elements.length === 0 || typeof anime === "undefined") return;

  const observer = new IntersectionObserver((entries) => {
    entries.forEach((entry) => {
      if (entry.isIntersecting) {
        anime({
          targets: entry.target,
          opacity: [0, 1],
          translateY: [100, 0],
          duration: 1000,
          easing: "easeOutQuad",
        });
      } else {
        entry.target.style.opacity = 0;
        entry.target.style.transform = "translateY(100px)";
      }
    });
  }, { threshold: 0.1 });

  elements.forEach((el) => {
    el.style.opacity = 0;
    observer.observe(el);
  });
}
