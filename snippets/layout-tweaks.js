// requestAnimationFrame-throttled layout syncing (wide screens only)
let raf = 0;

export function syncPanels(assignmentsEl, previewEl) {
  const run = () => {
    raf = 0;
    if (window.matchMedia("(min-width: 992px)").matches) {
      previewEl.style.minHeight = `${assignmentsEl.offsetHeight}px`;
    } else {
      previewEl.style.minHeight = "";
    }
  };

  const schedule = () => {
    if (raf) return;
    raf = requestAnimationFrame(run);
  };

  window.addEventListener("resize", schedule);
  window.addEventListener("scroll", schedule, { passive: true });
  schedule();
}

