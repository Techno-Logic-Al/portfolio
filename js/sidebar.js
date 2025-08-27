const sidebar = document.querySelector("#sidebar");

export function getRandomNumber() {
  const randomNumber = Math.floor(Math.random() * 6) + 1;
  return randomNumber;
}

export function toggleSidebar() {
  if (!sidebar) {
    console.warn("Sidebar element not found!");
    return;
  }

  if (sidebar.classList.contains("show")) {
    sidebar.classList.remove("show");
    setTimeout(() => {
      sidebar.classList.add("hidden");
    }, 400);
  } else {
    sidebar.classList.remove("hidden");
    requestAnimationFrame(() => {
      sidebar.classList.add("show");
    });
  }
}
