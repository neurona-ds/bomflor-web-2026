/**
 * Bomflor — Navigation & Mobile Cart Bar
 * No dependencies. Deferred.
 */
(function () {
  'use strict';

  /* ── Hamburger Drawer ─────────────────────────────────────────── */
  const hamburger = document.querySelector('.bf-nav__hamburger');
  const drawer    = document.querySelector('.bf-nav__drawer');
  const menuIcon  = document.querySelector('.bf-hamburger-icon--menu');
  const closeIcon = document.querySelector('.bf-hamburger-icon--close');

  function openDrawer() {
    drawer.classList.add('open');
    hamburger.setAttribute('aria-expanded', 'true');
    if (menuIcon)  menuIcon.style.display  = 'none';
    if (closeIcon) closeIcon.style.display = 'block';
    document.body.style.overflow = 'hidden';
  }

  function closeDrawer() {
    drawer.classList.remove('open');
    hamburger.setAttribute('aria-expanded', 'false');
    if (menuIcon)  menuIcon.style.display  = 'block';
    if (closeIcon) closeIcon.style.display = 'none';
    document.body.style.overflow = '';
  }

  if (hamburger && drawer) {
    hamburger.addEventListener('click', function () {
      const isOpen = drawer.classList.contains('open');
      isOpen ? closeDrawer() : openDrawer();
    });

    // Close on link click
    drawer.querySelectorAll('a').forEach(function (link) {
      link.addEventListener('click', closeDrawer);
    });

    // Close on outside click
    document.addEventListener('click', function (e) {
      if (
        drawer.classList.contains('open') &&
        !drawer.contains(e.target) &&
        !hamburger.contains(e.target)
      ) {
        closeDrawer();
      }
    });

    // Close on Escape
    document.addEventListener('keydown', function (e) {
      if (e.key === 'Escape' && drawer.classList.contains('open')) {
        closeDrawer();
      }
    });
  }

  /* ── Search Overlay ──────────────────────────────────────────── */
  const searchBtn     = document.getElementById('bf-search-btn');
  const searchOverlay = document.getElementById('bf-search-overlay');
  const searchInput   = searchOverlay && searchOverlay.querySelector('.bf-search-overlay__input');
  const searchClose   = searchOverlay && searchOverlay.querySelector('.bf-search-overlay__close');

  function openSearch() {
    if (!searchOverlay) return;
    searchOverlay.classList.add('open');
    document.body.style.overflow = 'hidden';
    if (searchInput) setTimeout(function () { searchInput.focus(); }, 50);
    if (typeof lucide !== 'undefined') lucide.createIcons();
  }

  function closeSearch() {
    if (!searchOverlay) return;
    searchOverlay.classList.remove('open');
    document.body.style.overflow = '';
  }

  if (searchBtn && searchOverlay) {
    searchBtn.addEventListener('click', openSearch);

    if (searchClose) searchClose.addEventListener('click', closeSearch);

    searchOverlay.addEventListener('click', function (e) {
      if (e.target === searchOverlay) closeSearch();
    });

    document.addEventListener('keydown', function (e) {
      if (e.key === 'Escape' && searchOverlay.classList.contains('open')) closeSearch();
    });
  }

  /* ── Account Panel ────────────────────────────────────────────── */
  const accountBtn     = document.getElementById('bf-account-btn');
  const accountPanel   = document.getElementById('bf-account-panel');
  const accountClose   = document.getElementById('bf-account-close');
  const accountOverlay = document.getElementById('bf-account-overlay');

  function openAccountPanel() {
    if (!accountPanel) return;
    accountPanel.classList.add('open');
    accountPanel.setAttribute('aria-hidden', 'false');
    if (accountOverlay) accountOverlay.classList.add('visible');
    if (accountBtn) accountBtn.setAttribute('aria-expanded', 'true');
    document.body.style.overflow = 'hidden';
    if (typeof lucide !== 'undefined') lucide.createIcons();
  }

  function closeAccountPanel() {
    if (!accountPanel) return;
    accountPanel.classList.remove('open');
    accountPanel.setAttribute('aria-hidden', 'true');
    if (accountOverlay) accountOverlay.classList.remove('visible');
    if (accountBtn) accountBtn.setAttribute('aria-expanded', 'false');
    document.body.style.overflow = '';
  }

  if (accountBtn && accountPanel) {
    accountBtn.addEventListener('click', function () {
      accountPanel.classList.contains('open') ? closeAccountPanel() : openAccountPanel();
    });

    if (accountClose) accountClose.addEventListener('click', closeAccountPanel);
    if (accountOverlay) accountOverlay.addEventListener('click', closeAccountPanel);

    document.addEventListener('keydown', function (e) {
      if (e.key === 'Escape' && accountPanel.classList.contains('open')) closeAccountPanel();
    });

    // Password show/hide toggles
    accountPanel.querySelectorAll('.bf-pw-toggle').forEach(function (btn) {
      btn.addEventListener('click', function () {
        var input = btn.closest('.bf-pw-wrap').querySelector('input');
        if (!input) return;
        var isPassword = input.type === 'password';
        input.type = isPassword ? 'text' : 'password';
        var icon = btn.querySelector('i[data-lucide]');
        if (icon) {
          icon.setAttribute('data-lucide', isPassword ? 'eye-off' : 'eye');
          if (typeof lucide !== 'undefined') lucide.createIcons();
        }
      });
    });
  }

  /* ── AJAX Login ───────────────────────────────────────────────── */
  var loginForm   = document.getElementById('bf-login-form');
  var loginSubmit = document.getElementById('bf-login-submit');
  var loginError  = document.getElementById('bf-login-error');

  if (loginForm) {
    loginForm.addEventListener('submit', function (e) {
      e.preventDefault();

      var cfg = window.bomflorLogin || {};
      if (!cfg.ajaxUrl) return;

      var data = new FormData(loginForm);
      data.append('action', 'bf_ajax_login');
      data.append('nonce', cfg.nonce);

      if (loginSubmit) {
        loginSubmit.disabled    = true;
        loginSubmit.textContent = 'Iniciando…';
      }
      if (loginError) loginError.hidden = true;

      fetch(cfg.ajaxUrl, { method: 'POST', body: data })
        .then(function (r) { return r.json(); })
        .then(function (res) {
          if (res && res.success) {
            window.location.href = (res.data && res.data.redirect) || window.location.href;
          } else {
            if (loginError) {
              loginError.textContent = (res && res.data && res.data.message) || 'Error al iniciar sesión.';
              loginError.hidden = false;
            }
            if (loginSubmit) {
              loginSubmit.disabled    = false;
              loginSubmit.textContent = 'Iniciar Sesión';
            }
          }
        })
        .catch(function () {
          if (loginError) {
            loginError.textContent = 'Error de conexión. Inténtalo de nuevo.';
            loginError.hidden = false;
          }
          if (loginSubmit) {
            loginSubmit.disabled    = false;
            loginSubmit.textContent = 'Iniciar Sesión';
          }
        });
    });
  }

  /* ── Mobile Cart Bar ──────────────────────────────────────────── */
  const cartBar   = document.querySelector('.bf-cart-bar');
  const cartCount = document.querySelector('.bf-cart-bar__count-num');
  const cartTotal = document.querySelector('.bf-cart-bar__total');

  function isCartOrCheckout() {
    return (
      document.body.classList.contains('woocommerce-cart') ||
      document.body.classList.contains('woocommerce-checkout')
    );
  }

  function updateCartBar() {
    if (!cartBar) return;
    if (isCartOrCheckout()) {
      cartBar.classList.remove('visible');
      return;
    }

    var data = window.bomflorCart || {};
    var count = parseInt(data.count, 10) || 0;

    if (count > 0) {
      if (cartCount) cartCount.textContent = count;
      if (cartTotal) cartTotal.innerHTML = data.total || '';
      cartBar.classList.add('visible');
    } else {
      cartBar.classList.remove('visible');
    }
  }

  // Update on WC fragments refresh (AJAX add-to-cart)
  document.addEventListener('wc_fragments_refreshed', updateCartBar);
  document.addEventListener('added_to_cart', updateCartBar);
  document.addEventListener('removed_from_cart', updateCartBar);

  updateCartBar();

  /* ── Nav cart badge ───────────────────────────────────────────── */
  function updateNavBadge() {
    var badge = document.querySelector('.bf-cart-badge');
    if (!badge) return;
    var data  = window.bomflorCart || {};
    var count = parseInt(data.count, 10) || 0;
    if (count > 0) {
      badge.textContent = count > 99 ? '99+' : count;
      badge.classList.add('visible');
    } else {
      badge.classList.remove('visible');
    }
  }
  document.addEventListener('wc_fragments_refreshed', updateNavBadge);
  updateNavBadge();

})();
