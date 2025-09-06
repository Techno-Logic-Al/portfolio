export function toggleBurgerMenu() {
  const burgerBtn = document.querySelector(".header-btn");
  if (!burgerBtn) return;
  burgerBtn.addEventListener("click", () => {
    burgerBtn.classList.toggle("active");
  });
}
