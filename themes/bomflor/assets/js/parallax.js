/**
 * Bomflor — Passive Scroll Parallax
 * No dependencies. Deferred. requestAnimationFrame throttled.
 */
(function () {
  'use strict';

  var elements = [];
  var ticking  = false;

  function collect() {
    elements = Array.from(document.querySelectorAll('[data-parallax]')).map(function (el) {
      return {
        el:    el,
        speed: parseFloat(el.getAttribute('data-parallax-speed')) || 0.3,
      };
    });
  }

  function update() {
    var scrollY = window.scrollY || window.pageYOffset;
    elements.forEach(function (item) {
      var rect   = item.el.getBoundingClientRect();
      var center = rect.top + rect.height / 2;
      var offset = (center - window.innerHeight / 2) * item.speed;
      item.el.style.transform = 'translateY(' + offset.toFixed(2) + 'px)';
    });
    ticking = false;
  }

  function onScroll() {
    if (!ticking) {
      requestAnimationFrame(update);
      ticking = true;
    }
  }

  function init() {
    collect();
    if (elements.length === 0) return;

    // Respect prefers-reduced-motion
    var mq = window.matchMedia('(prefers-reduced-motion: reduce)');
    if (mq.matches) return;

    window.addEventListener('scroll', onScroll, { passive: true });
    window.addEventListener('resize', collect, { passive: true });
    update();
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }

})();
