// Particle Explosion Reveal for Banner

function lerp(a, b, t) {
  return a + (b - a) * t;
}

function drawWithTracking(ctx, text, x, y, letterSpacingPx) {
  if (!text || letterSpacingPx === 0) {
    ctx.fillText(text, x, y);
    return ctx.measureText(text).width;
  }
  const chars = Array.from(text);
  let currX = x;
  for (let i = 0; i < chars.length; i++) {
    const ch = chars[i];
    ctx.fillText(ch, currX, y);
    const w = ctx.measureText(ch).width;
    currX += w + letterSpacingPx;
  }
  return currX - x;
}

function easeOutCubic(t) {
  return 1 - Math.pow(1 - t, 3);
}
function clamp(n, min, max) {
  return Math.max(min, Math.min(max, n));
}

function createParticlesFromText(ctx, textLines, options) {
  const {
    gap = 6,
    offsetY = 0,
    fontFamily = "'Zen Dots', sans-serif",
    lineHeight = 1.1,
    maxWidth,
  } = options;

  const metrics = [];
  ctx.textAlign = "center";
  ctx.textBaseline = "middle";

  // Measure and draw to an offscreen canvas to sample pixels
  const temp = document.createElement("canvas");
  temp.width = ctx.canvas.width;
  temp.height = ctx.canvas.height;
  const tctx = temp.getContext("2d");
  tctx.clearRect(0, 0, temp.width, temp.height);

  const cx = temp.width / 2;
  let totalHeight = 0;

  // Decide font sizes responsive to width
  // Title large, subtitle smaller
  const baseW = temp.width;
  const titleSize = clamp(Math.floor(baseW * 0.12), 42, 160); // responsive
  const subtitleSize = Math.max(Math.floor(titleSize * 0.35), 20);

  const fontSizes = [titleSize, subtitleSize];

  textLines.forEach((line, i) => {
    tctx.font = `700 ${fontSizes[i]}px ${fontFamily}`;
    const m = tctx.measureText(line);
    metrics.push({ width: m.width, size: fontSizes[i] });
    totalHeight += fontSizes[i] * lineHeight;
  });

  let startY = (temp.height - totalHeight) / 2 + offsetY;

  // Draw with a glow to get thicker strokes for sampling
  tctx.fillStyle = "rgba(235, 230, 227, 0.706)";
  tctx.shadowColor = "rgba(235, 230, 227, 0.706)";
  tctx.shadowBlur = 18;

  let y = startY;
  textLines.forEach((line, i) => {
    tctx.font = `700 ${fontSizes[i]}px ${fontFamily}`;
    tctx.fillText(line, cx, y + fontSizes[i] * 0.4);
    y += fontSizes[i] * lineHeight;
  });

  // Sample pixels
  const img = tctx.getImageData(0, 0, temp.width, temp.height).data;
  const particles = [];
  for (let y = 0; y < temp.height; y += gap) {
    for (let x = 0; x < temp.width; x += gap) {
      const idx = (y * temp.width + x) * 4;
      const alpha = img[idx + 3];
      if (alpha > 80) {
        // Target is (x,y). Start near the center (explosion outward)
        const angle = Math.random() * Math.PI * 2;
        const radius = Math.random() * 20 + 5;
        const startX = cx + Math.cos(angle) * radius;
        const startY = temp.height / 2 + Math.sin(angle) * radius;

        particles.push({
          x: startX,
          y: startY,
          tx: x + (Math.random() * 2 - 1), // slight jitter
          ty: y + (Math.random() * 2 - 1),
          size: Math.random() * 1.6 + 0.8,
          life: 0,
          ttl: 1.4 + Math.random() * 0.3, // seconds to reach target
        });
      }
    }
  }
  return particles;
}

function runBannerExplosion() {
  const banner = document.querySelector(".banner");
  const titleEl = document.querySelector("#bannerTitle");
  const subtitleEl = document.querySelector("#bannerSubtitle");
  const canvas = document.getElementById("bannerCanvas");
  if (!banner || !canvas || !titleEl || !subtitleEl) return;

  // Safety: ensure can always reveal text if anything goes wrong
  function safeReveal() {
    banner.classList.add("reveal-headline");
    titleEl.classList.remove("headline-hidden");
    subtitleEl.classList.remove("headline-hidden");
    if (canvas) {
      canvas.classList.add("fade-out");
    }
  }

  // Ensure DOM text exists (so users without canvas still see it after reveal)
  const tText =
    titleEl.dataset.text || titleEl.textContent.trim() || "Alastair Grandison";
  const sText =
    subtitleEl.dataset.text || subtitleEl.textContent.trim() || "Web Developer";
  const tLines = tText.split(/\s+/);
  titleEl.textContent = tLines.join("\n");
  titleEl.style.whiteSpace = "pre-line";
  subtitleEl.textContent = sText;
  titleEl.classList.add("headline-hidden");
  subtitleEl.classList.add("headline-hidden");

  const ctx = canvas.getContext("2d");
  const dpr = Math.min(window.devicePixelRatio || 1, 2);

  function resize() {
    const rect = banner.getBoundingClientRect();
    canvas.width = Math.max(1, Math.floor(rect.width * dpr));
    canvas.height = Math.max(1, Math.floor(rect.height * dpr));
    canvas.style.width = rect.width + "px";
    canvas.style.height = rect.height + "px";
    ctx.setTransform(1, 0, 0, 1, 0, 0); // draw in device pixels directly
  }

  // Utility: get actual visual lines from an element
  function getDOMLines(el) {
    const tn = Array.from(el.childNodes).find(
      (n) => n.nodeType === Node.TEXT_NODE,
    );
    const content = el.textContent || "";
    if (!tn || !tn.length) {
      const r = el.getBoundingClientRect();
      return [{ text: content.trim(), rect: r }];
    }
    const rs = document.createRange();
    let prevTop = null;
    let start = 0;
    const bounds = [];
    for (let i = 1; i <= tn.length; i++) {
      rs.setStart(tn, 0);
      rs.setEnd(tn, i);
      const rects = rs.getClientRects();
      if (!rects.length) continue;
      const lastTop = rects[rects.length - 1].top;
      if (prevTop === null) prevTop = lastTop;
      if (Math.abs(lastTop - prevTop) > 0.5) {
        bounds.push({ start, end: i - 1 });
        start = i - 1;
        prevTop = lastTop;
      }
    }
    bounds.push({ start, end: tn.length });
    const out = [];
    for (const b of bounds) {
      const rr = document.createRange();
      rr.setStart(tn, b.start);
      rr.setEnd(tn, b.end);
      const r = rr.getBoundingClientRect();
      const t = content.slice(b.start, b.end).trim();
      if (t.length) out.push({ text: t, rect: r });
    }
    return out;
  }

  function totalTrackedWidth(context, text, ls) {
    const chars = Array.from(text);
    let total = 0;
    for (let i = 0; i < chars.length; i++) {
      total += context.measureText(chars[i]).width;
      if (i < chars.length - 1) total += ls;
    }
    return total;
  }

  function createParticlesAligned() {
    // Temporarily remove hidden transforms for accurate measurements
    titleEl.style.visibility = "hidden";
    subtitleEl.style.visibility = "hidden";
    titleEl.classList.remove("headline-hidden");
    subtitleEl.classList.remove("headline-hidden");

    const rectBanner = banner.getBoundingClientRect();
    const csTitle = getComputedStyle(titleEl);
    const csSub = getComputedStyle(subtitleEl);

    const titleSizeCSS = parseFloat(csTitle.fontSize) || 64;
    const subSizeCSS =
      parseFloat(csSub.fontSize) || Math.max(20, titleSizeCSS * 0.35);
    const fontFamilyTitle = csTitle.fontFamily || "'Zen Dots', sans-serif";
    const fontFamilySub = csSub.fontFamily || "sans-serif";
    const fontWeightTitle = csTitle.fontWeight || "700";
    const fontWeightSub = csSub.fontWeight || "600";
    const lsTitle = (parseFloat(csTitle.letterSpacing) || 0) * dpr;
    const lsSub = (parseFloat(csSub.letterSpacing) || 0) * dpr;

    const nudgeXTitle =
      parseFloat(csTitle.getPropertyValue("--particle-nudge-x")) || 0;
    const nudgeYTitle =
      parseFloat(csTitle.getPropertyValue("--particle-nudge-y")) || 0;
    const nudgeXSub =
      parseFloat(csSub.getPropertyValue("--particle-nudge-x")) || 0;
    const nudgeYSub =
      parseFloat(csSub.getPropertyValue("--particle-nudge-y")) || 0;

    const titleLines = getDOMLines(titleEl);
    const subLines = getDOMLines(subtitleEl);

    // Restore hidden state
    titleEl.classList.add("headline-hidden");
    subtitleEl.classList.add("headline-hidden");
    titleEl.style.visibility = "";
    subtitleEl.style.visibility = "";

    // Offscreen canvases
    const temp = document.createElement("canvas");
    temp.width = canvas.width;
    temp.height = canvas.height;
    const tctx = temp.getContext("2d");
    tctx.textAlign = "left";
    tctx.textBaseline = "alphabetic";
    tctx.fillStyle = "#ffffff";
    tctx.shadowColor = "#ffffff";
    tctx.shadowBlur = 8;

    // Draw one line: measure on scratch canvas, adjust vertical center empirically, then draw onto temp
    function drawLineCentered(
      text,
      centerX,
      centerY,
      font,
      letterSpacing,
      nudgeX = 0,
      nudgeY = 0,
    ) {
      const scratch = document.createElement("canvas");
      scratch.width = temp.width;
      scratch.height = temp.height;
      const sctx = scratch.getContext("2d");
      sctx.textAlign = "left";
      sctx.textBaseline = "alphabetic";
      sctx.fillStyle = "#ffffff";
      sctx.shadowColor = "#ffffff";
      sctx.shadowBlur = 8;
      sctx.font = font;

      const total = totalTrackedWidth(sctx, text, letterSpacing);

      let startX = centerX - total / 2 + nudgeX * dpr;

      // Prepass on scratch to find vertical extents
      drawWithTracking(sctx, text, startX, centerY, letterSpacing);

      const margin = Math.max(4, Math.floor(8 * dpr));
      const x0 = Math.max(0, Math.floor(startX - margin));
      const x1 = Math.min(scratch.width, Math.ceil(startX + total + margin));
      const img = sctx.getImageData(x0, 0, x1 - x0, scratch.height).data;
      let minY = scratch.height,
        maxY = -1;
      for (let y = 0; y < scratch.height; y++) {
        for (let x = 0; x < x1 - x0; x++) {
          const a = img[(y * (x1 - x0) + x) * 4 + 3];
          if (a > 32) {
            if (y < minY) minY = y;
            if (y > maxY) maxY = y;
          }
        }
      }
      let baselineY = centerY;
      if (maxY >= minY) {
        const drawnCenter = (minY + maxY) / 2;
        const diff = centerY - drawnCenter;
        baselineY = centerY + diff;
      }
      // Optional offsets supplied via parameters
      baselineY += nudgeY * dpr;
      // Prevent baseline from shifting outside the canvas
      baselineY = Math.max(0, Math.min(temp.height, baselineY));

      // Draw final into temp (accumulate)
      tctx.font = font;
      drawWithTracking(tctx, text, startX, baselineY, letterSpacing);
    }

    // Draw title lines (multi-line aware)
    tctx.font = `${fontWeightTitle} ${titleSizeCSS * dpr}px ${fontFamilyTitle}`;
    for (const line of titleLines) {
      const cx =
        ((line.rect.left + line.rect.right) / 2 - rectBanner.left) * dpr;
      const cy =
        ((line.rect.top + line.rect.bottom) / 2 - rectBanner.top) * dpr;
      drawLineCentered(
        line.text,
        cx,
        cy,
        `${fontWeightTitle} ${titleSizeCSS * dpr}px ${fontFamilyTitle}`,
        lsTitle,
        nudgeXTitle,
        nudgeYTitle,
      );
    }

    // Draw subtitle lines
    tctx.font = `${fontWeightSub} ${subSizeCSS * dpr}px ${fontFamilySub}`;
    for (const line of subLines) {
      const cx =
        ((line.rect.left + line.rect.right) / 2 - rectBanner.left) * dpr;
      const cy =
        ((line.rect.top + line.rect.bottom) / 2 - rectBanner.top) * dpr;
      drawLineCentered(
        line.text,
        cx,
        cy,
        `${fontWeightSub} ${subSizeCSS * dpr}px ${fontFamilySub}`,
        lsSub,
        nudgeXSub,
        nudgeYSub,
      );
    }

    // Sample pixels to targets
    const data = tctx.getImageData(0, 0, temp.width, temp.height).data;
    const gap = Math.max(4, Math.floor(6 * dpr));
    const parts = [];
    const cxDev = canvas.width / 2;
    const cyDev = canvas.height / 2;
    for (let y = 0; y < temp.height; y += gap) {
      for (let x = 0; x < temp.width; x += gap) {
        const idx = (y * temp.width + x) * 4;
        if (data[idx + 3] > 80) {
          const ang = Math.random() * Math.PI * 2;
          const rad = Math.random() * 40 * dpr + 10 * dpr;
          const sx = cxDev + Math.cos(ang) * rad;
          const sy = cyDev + Math.sin(ang) * rad;
          parts.push({
            x: sx,
            y: sy,
            tx: x,
            ty: y,
            size: (Math.random() * 1.6 + 0.8) * dpr,
            life: 0,
            ttl: 1.4 + Math.random() * 0.3,
          });
        }
      }
    }
    return parts;
  }

  let particles = [];
  let raf = null;
  let finished = false;
  let startTime = 0;
  let fallbackTimer = null;
  const LOOP_DELAY = 1500;

  function start() {
    cancelAnimationFrame(raf);
    clearTimeout(fallbackTimer);
    resize();
    try {
      particles = createParticlesAligned();
    } catch (e) {
      console.error("createParticlesAligned failed:", e);
      safeReveal();
      return;
    }
    startTime = performance.now();
    finished = false;
    if (!particles || particles.length < 50) {
      safeReveal();
      return;
    }
    fallbackTimer = setTimeout(() => {
      if (!banner.classList.contains("reveal-headline")) safeReveal();
    }, 4000);
    animate();
  }

  function animate(now) {
    raf = requestAnimationFrame(animate);
    ctx.clearRect(0, 0, canvas.width, canvas.height);

    let allArrived = true;
    for (let p of particles) {
      const progress = Math.max(0, Math.min(1, p.life / p.ttl));
      const e = 1 - Math.pow(1 - progress, 3);
      const nx = p.x + (p.tx - p.x) * e;
      const ny = p.y + (p.ty - p.y) * e;

      ctx.globalAlpha = 0.5 * (1 - progress);
      ctx.beginPath();
      ctx.moveTo(p.x, p.y);
      ctx.lineTo(nx, ny);
      ctx.lineWidth = p.size * 0.6;
      ctx.strokeStyle = "rgba(235, 230, 227, 0.706)";
      ctx.stroke();
      ctx.globalAlpha = 1;

      ctx.beginPath();
      ctx.arc(nx, ny, p.size, 0, Math.PI * 2);
      ctx.fillStyle = "rgba(235, 230, 227, 0.706)";
      ctx.fill();

      p.life += 1 / 60;
      if (progress < 1) allArrived = false;
    }

    if (!finished && allArrived) {
      finished = true;
      canvas.classList.add("fade-out");
      banner.classList.add("reveal-headline");
      titleEl.classList.remove("headline-hidden");
      subtitleEl.classList.remove("headline-hidden");
      cancelAnimationFrame(raf);
      setTimeout(() => {
        banner.classList.remove("reveal-headline");
        titleEl.classList.add("headline-hidden");
        subtitleEl.classList.add("headline-hidden");
        canvas.classList.remove("fade-out");
        start();
      }, LOOP_DELAY);
    }
  }

  window.addEventListener("resize", start, { passive: true });
  try {
    start();
  } catch (err) {
    console.error("Banner explosion error:", err);
    safeReveal();
  }
}

export function bannerExplosion() {
  runBannerExplosion();
}

export function toggleBurgerMenu() {
  const burgerBtn = document.querySelector(".header-btn");
  if (!burgerBtn) return;
  burgerBtn.addEventListener("click", () => {
    burgerBtn.classList.toggle("active");
  });
}
