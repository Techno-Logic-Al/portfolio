import { validateContactForm } from "./formValidation.js";

function setTheme(theme) {
  document.documentElement.dataset.theme = theme;
  localStorage.setItem("mode", theme);
}

function toggleTheme() {
  const current = document.documentElement.dataset.theme === "dark" ? "dark" : "light";
  setTheme(current === "dark" ? "light" : "dark");
}

function updateThemeToggleUI(button) {
  if (!button) return;
  const label = button.querySelector(".theme-toggle__label");
  if (!label) return;

  const current = document.documentElement.dataset.theme === "dark" ? "dark" : "light";
  label.textContent = current === "dark" ? "Granite mode" : "Groovy mode";
}

function initThemeToggle() {
  const button = document.querySelector("#themeToggle");
  if (!button) return;
  updateThemeToggleUI(button);
  button.addEventListener("click", () => {
    toggleTheme();
    updateThemeToggleUI(button);
  });
}

function initHeaderAndDockAutohide() {
  const header = document.querySelector(".site-header");
  const dock = document.querySelector(".dock");
  if (!header && !dock) return;

  const root = document.documentElement;
  const className = "is-hidden";
  const minScrollYToToggle = 96;
  const minDelta = 6;

  let lastScrollY = Math.max(0, window.scrollY || 0);
  let rafId = 0;

  const hasFocusWithin = (element) => {
    if (!element) return false;
    try {
      return element.matches(":focus-within");
    } catch {
      return false;
    }
  };

  const showHeader = () => header?.classList.remove(className);
  const showDock = () => dock?.classList.remove(className);
  const hideHeader = () => header?.classList.add(className);
  const hideDock = () => dock?.classList.add(className);

  const setHeaderHeightVar = () => {
    if (!header) return;
    const height = Math.ceil(header.getBoundingClientRect().height);
    if (height > 0) root.style.setProperty("--site-header-h", `${height}px`);
  };

  const update = () => {
    rafId = 0;

    const currentScrollY = Math.max(0, window.scrollY || 0);
    const delta = currentScrollY - lastScrollY;

    if (Math.abs(delta) < minDelta) {
      lastScrollY = currentScrollY;
      return;
    }

    if (currentScrollY <= minScrollYToToggle) {
      showHeader();
      hideDock();
      lastScrollY = currentScrollY;
      return;
    }

    if (delta > 0) {
      if (header && !hasFocusWithin(header)) hideHeader();
      showDock();
    } else {
      showHeader();
      if (dock && !hasFocusWithin(dock)) hideDock();
    }

    lastScrollY = currentScrollY;
  };

  const onScroll = () => {
    if (rafId) return;
    rafId = window.requestAnimationFrame(update);
  };

  setHeaderHeightVar();
  if (dock) hideDock();

  if (header) {
    if ("ResizeObserver" in window) {
      const observer = new ResizeObserver(() => setHeaderHeightVar());
      observer.observe(header);
    } else {
      window.addEventListener("resize", setHeaderHeightVar, { passive: true });
    }
  }

  header?.addEventListener("focusin", showHeader);
  dock?.addEventListener("focusin", showDock);

  window.addEventListener("keydown", (event) => {
    if (event.key === "Tab") {
      showHeader();
      showDock();
    }
  });

  window.addEventListener("scroll", onScroll, { passive: true });
}

function initProjectsCascade() {
  const wrapper = document.querySelector("[data-projects-cascade]");
  const track = wrapper?.querySelector("[data-projects-track]");
  if (!wrapper || !track) return;

  const originalCards = Array.from(track.querySelectorAll("[data-project-card]"));
  if (originalCards.length < 2) return;

  const centerKeys = ["admin-station", "netmatters", "pick-a-pick"];
  const speedPxPerSecond = 40;

  const makeClones = () => {
    const alreadyCloned = track.querySelector("[data-project-clone]");
    if (alreadyCloned) return;

    originalCards.forEach((card) => {
      const clone = card.cloneNode(true);
      clone.dataset.projectClone = "true";
      clone.setAttribute("aria-hidden", "true");
      clone.querySelectorAll("a, button, input, select, textarea, summary").forEach((el) => {
        el.setAttribute("tabindex", "-1");
        el.setAttribute("aria-hidden", "true");
      });
      track.appendChild(clone);
    });
  };

  const compute = () => {
    const cards = Array.from(track.querySelectorAll("[data-project-card]:not([data-project-clone])"));
    if (cards.length < 2) return;

    const firstCenter = cards.find((card) => card.dataset.projectKey === centerKeys[0]);
    const lastCenter = cards.find((card) => card.dataset.projectKey === centerKeys[2]);
    if (!firstCenter || !lastCenter) return;

    const styles = window.getComputedStyle(track);
    const gap = Number.parseFloat(styles.gap || styles.columnGap || "0") || 0;

    let loopWidth = gap * cards.length;
    cards.forEach((card) => {
      loopWidth += card.getBoundingClientRect().width;
    });

    if (loopWidth <= 0) return;

    const groupLeft = firstCenter.offsetLeft;
    const groupRight = lastCenter.offsetLeft + lastCenter.offsetWidth;
    const groupCenter = (groupLeft + groupRight) / 2;
    const viewportCenter = wrapper.clientWidth / 2;

    let startX = viewportCenter - groupCenter;
    while (startX > 0) startX -= loopWidth;
    while (startX <= -loopWidth) startX += loopWidth;

    const durationSeconds = Math.max(20, loopWidth / speedPxPerSecond);

    wrapper.classList.remove("is-ready");
    track.style.setProperty("--projects-start-x", `${startX}px`);
    track.style.setProperty("--projects-loop-width", `${loopWidth}px`);
    track.style.setProperty("--projects-duration", `${durationSeconds}s`);

    track.style.animation = "none";
    track.getBoundingClientRect();
    track.style.animation = "";
    wrapper.classList.add("is-ready");
  };

  makeClones();

  const scheduleCompute = () => window.requestAnimationFrame(compute);

  window.addEventListener("load", scheduleCompute, { once: true });
  scheduleCompute();

  if ("ResizeObserver" in window) {
    const observer = new ResizeObserver(scheduleCompute);
    observer.observe(wrapper);
  } else {
    window.addEventListener("resize", scheduleCompute, { passive: true });
  }
}

function initReveals() {
  const items = Array.from(document.querySelectorAll("[data-reveal]"));
  if (!items.length) return;

  if (!("IntersectionObserver" in window)) {
    items.forEach((el) => el.classList.add("is-visible"));
    return;
  }

  const observer = new IntersectionObserver(
    (entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          entry.target.classList.add("is-visible");
          observer.unobserve(entry.target);
        }
      });
    },
    { threshold: 0.15 }
  );

  items.forEach((el) => observer.observe(el));
}

function initCodeCopyButtons() {
  document.querySelectorAll(".code-block").forEach((block) => {
    const button = block.querySelector("[data-copy]");
    const code = block.querySelector("pre code");
    if (!button || !code) return;

    button.addEventListener("click", async () => {
      const text = code.textContent ?? "";
      try {
        await navigator.clipboard.writeText(text);
        const original = button.textContent;
        button.textContent = "Copied";
        button.disabled = true;
        window.setTimeout(() => {
          button.textContent = original;
          button.disabled = false;
        }, 900);
      } catch {
        button.textContent = "Copy failed";
        window.setTimeout(() => (button.textContent = "Copy"), 900);
      }
    });
  });
}

function initContactForm() {
  const form = document.querySelector("[data-contact-form]");
  if (!form) return;

  const statusMessageEl = form.querySelector(".form-message");
  const submitButton = form.querySelector('button[type="submit"]');
  const requiredFields = ["name", "email", "telephone", "message"];
  const optionalFields = ["company"];
  let showErrors = false;

  const formatList = (items) => {
    if (items.length === 1) return items[0];
    if (items.length === 2) return `${items[0]} and ${items[1]}`;
    return `${items.slice(0, -1).join(", ")} and ${items[items.length - 1]}`;
  };

  const buildFormMessage = (errors) => {
    const errorEntries = Object.entries(errors);
    if (!errorEntries.length) return "";

    const missingFields = [];
    const otherIssues = [];

    const missingFieldNames = {
      name: "your name",
      email: "email",
      telephone: "telephone number",
      message: "message",
    };

    for (const [, error] of errorEntries) {
      if (error.type === "missing") continue;
      otherIssues.push(error.message);
    }

    const parts = [];

    requiredFields.forEach((fieldName) => {
      const error = errors[fieldName];
      if (error && error.type === "missing") {
        const displayName = missingFieldNames[fieldName] || error.label;
        missingFields.push(displayName);
      }
    });

    if (missingFields.length) {
      parts.push(`Please complete: ${formatList(missingFields)}.`);
    }

    if (otherIssues.length) {
      parts.push([...new Set(otherIssues)].join(" "));
    }

    return parts.join(" ");
  };

  const updateFieldStyles = (fieldStatus) => {
    requiredFields.forEach((name) => {
      const field = form.elements[name];
      if (!field) return;
      field.classList.remove("field-valid", "field-invalid");
      if (fieldStatus[name] === "valid") field.classList.add("field-valid");
      if (fieldStatus[name] === "invalid") field.classList.add("field-invalid");
    });

    optionalFields.forEach((name) => {
      const field = form.elements[name];
      if (!field) return;
      field.classList.remove("field-valid", "field-invalid");
      if (field.value.trim()) field.classList.add("field-valid");
    });
  };

  const applyStatusMessage = (errors) => {
    if (!statusMessageEl || !showErrors) return;
    const messageText = buildFormMessage(errors);
    statusMessageEl.textContent = messageText;
    statusMessageEl.classList.toggle("has-error", Boolean(messageText));
    statusMessageEl.classList.remove("success");
  };

  form.setAttribute("novalidate", "");

  form.addEventListener("submit", async (event) => {
    event.preventDefault();
    showErrors = true;

    const { isValid, errors, fieldStatus } = validateContactForm(form);
    updateFieldStyles(fieldStatus);

    if (!isValid) {
      applyStatusMessage(errors);
      return;
    }

    if (submitButton) submitButton.disabled = true;
    if (statusMessageEl) {
      statusMessageEl.textContent = "";
      statusMessageEl.classList.remove("has-error", "success");
    }

    try {
      const response = await fetch(form.action || window.location.href, {
        method: "POST",
        headers: { "X-Requested-With": "XMLHttpRequest" },
        body: new FormData(form),
      });

      const result = await response.json();

      if (!result.ok) {
        if (result.fieldStatus && result.errors) {
          updateFieldStyles(result.fieldStatus);
          applyStatusMessage(result.errors);
        } else if (statusMessageEl && result.message) {
          statusMessageEl.textContent = result.message;
          statusMessageEl.classList.add("has-error");
          statusMessageEl.classList.remove("success");
        }
        return;
      }

      form.reset();
      requiredFields.forEach((name) => form.elements[name]?.classList.remove("field-valid", "field-invalid"));
      optionalFields.forEach((name) => form.elements[name]?.classList.remove("field-valid", "field-invalid"));

      if (statusMessageEl) {
        statusMessageEl.textContent = result.message || "Message sent!";
        statusMessageEl.classList.remove("has-error");
        statusMessageEl.classList.add("success");
      }

      showErrors = false;
    } catch {
      if (statusMessageEl) {
        statusMessageEl.textContent = "There was a problem sending your message. Please try again later.";
        statusMessageEl.classList.add("has-error");
        statusMessageEl.classList.remove("success");
      }
    } finally {
      if (submitButton) submitButton.disabled = false;
    }
  });

  form.addEventListener("input", (event) => {
    const target = event.target;
    if (!target?.name) return;
    if (![...requiredFields, ...optionalFields].includes(target.name)) return;

    const { errors, fieldStatus } = validateContactForm(form);
    updateFieldStyles(fieldStatus);
    applyStatusMessage(errors);
  });
}

document.addEventListener("DOMContentLoaded", () => {
  initThemeToggle();
  initHeaderAndDockAutohide();
  initProjectsCascade();
  initReveals();
  initCodeCopyButtons();
  initContactForm();
});
