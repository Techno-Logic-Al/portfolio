import { animateSection } from './animationHelper.js';

export function animateCodingExamplesText() {
  animateSection({
    rootSelector: '.coding-examples-content',
    itemSelector: 'h1, h2, img, p',
  });
}
