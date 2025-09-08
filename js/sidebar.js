export function toggleSidebar(sidebarEl) {
  if (!sidebarEl) {
    console.warn("Sidebar element not found!");
    return;
  }

  if (sidebarEl.classList.contains("show")) {
    sidebarEl.classList.remove("show");
    setTimeout(() => {
      sidebarEl.classList.add("hidden");
    }, 400);
  } else {
    sidebarEl.classList.remove("hidden");
    requestAnimationFrame(() => {
      sidebarEl.classList.add("show");
    });
  }
}
