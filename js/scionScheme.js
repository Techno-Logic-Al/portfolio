import { animateSection } from './animationHelper.js';

export function animateScionSchemeText() {
  animateSection({
    rootSelector: '.scion-scheme-content',
    itemSelector: 'h1, p, li',
  });
}
