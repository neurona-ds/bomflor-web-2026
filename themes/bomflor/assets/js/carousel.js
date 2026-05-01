/**
 * Bomflor — Lightweight Swipe Carousel
 * No dependencies. Touch + mouse drag. Snap to nearest item.
 */
(function () {
  'use strict';

  function initCarousel(wrapper) {
    var track     = wrapper.querySelector('[data-carousel-track]');
    var items     = wrapper.querySelectorAll('[data-carousel-item]');
    var dotsWrap  = wrapper.querySelector('[data-carousel-dots]');
    var autoLoop  = wrapper.getAttribute('data-carousel-auto') === 'true';
    var autoDelay = parseInt(wrapper.getAttribute('data-carousel-delay'), 10) || 4000;

    if (!track || items.length === 0) return;

    var current    = 0;
    var startX     = 0;
    var isDragging = false;
    var dragOffset = 0;
    var autoTimer  = null;

    /* ── Dots ────────────────────────────────────────────────────── */
    var dots = [];
    if (dotsWrap) {
      items.forEach(function (_, i) {
        var dot = document.createElement('button');
        dot.setAttribute('aria-label', 'Slide ' + (i + 1));
        dot.className = 'bf-carousel-dot' + (i === 0 ? ' active' : '');
        dot.addEventListener('click', function () { goTo(i); });
        dotsWrap.appendChild(dot);
        dots.push(dot);
      });
    }

    function updateDots() {
      dots.forEach(function (d, i) {
        d.classList.toggle('active', i === current);
      });
    }

    function goTo(index) {
      current = Math.max(0, Math.min(index, items.length - 1));
      var offset = current * -100;
      track.style.transform = 'translateX(' + offset + '%)';
      updateDots();
    }

    function next() { goTo(current < items.length - 1 ? current + 1 : 0); }
    function prev() { goTo(current > 0 ? current - 1 : items.length - 1); }

    /* ── Auto loop ───────────────────────────────────────────────── */
    function startAuto() {
      if (!autoLoop) return;
      autoTimer = setInterval(next, autoDelay);
    }
    function stopAuto() {
      clearInterval(autoTimer);
    }

    startAuto();

    /* ── Touch ───────────────────────────────────────────────────── */
    wrapper.addEventListener('touchstart', function (e) {
      startX    = e.touches[0].clientX;
      isDragging = true;
      stopAuto();
    }, { passive: true });

    wrapper.addEventListener('touchend', function (e) {
      if (!isDragging) return;
      var diff = startX - e.changedTouches[0].clientX;
      if (Math.abs(diff) > 40) {
        diff > 0 ? next() : prev();
      }
      isDragging = false;
      startAuto();
    }, { passive: true });

    /* ── Mouse drag ──────────────────────────────────────────────── */
    wrapper.addEventListener('mousedown', function (e) {
      startX     = e.clientX;
      isDragging = true;
      dragOffset = 0;
      stopAuto();
      e.preventDefault();
    });

    window.addEventListener('mousemove', function (e) {
      if (!isDragging) return;
      dragOffset = e.clientX - startX;
    });

    window.addEventListener('mouseup', function () {
      if (!isDragging) return;
      if (Math.abs(dragOffset) > 40) {
        dragOffset < 0 ? next() : prev();
      }
      isDragging = false;
      dragOffset = 0;
      startAuto();
    });

    /* ── Pause on hover ──────────────────────────────────────────── */
    wrapper.addEventListener('mouseenter', stopAuto);
    wrapper.addEventListener('mouseleave', startAuto);
  }

  function init() {
    document.querySelectorAll('[data-carousel]').forEach(initCarousel);
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }

})();
