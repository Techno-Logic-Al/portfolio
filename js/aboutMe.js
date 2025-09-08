import { animateSection } from './animationHelper.js';

export function animateAboutMeText() {
  animateSection({
    rootSelector: '.about-me-content',
    itemSelector: 'h1, p',
    stagger: 200,
  });
}
