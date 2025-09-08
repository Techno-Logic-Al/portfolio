export function animateSection({ rootSelector, itemSelector, stagger = 100 }) {
  const section = document.querySelector(rootSelector);
  if (!section || typeof anime === 'undefined') return;

  const items = section.querySelectorAll(itemSelector);
  const observer = new IntersectionObserver((entries, obs) => {
    entries.forEach((entry) => {
      if (entry.isIntersecting) {
        anime
          .timeline({ easing: 'easeOutExpo' })
          .add({
            targets: items,
            translateY: [50, 0],
            opacity: [0, 1],
            delay: anime.stagger(stagger),
          });
        obs.disconnect();
      }
    });
  });

  observer.observe(section);
}
