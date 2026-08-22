/**
 * Bomflor — Delivery Date Constraints
 *
 * Allowed weekdays and blackout dates are configured in the woo-delivery plugin's
 * settings screen and reach us as data-attributes on #bomflor_delivery_date
 * (see bomflor_get_delivery_date_rules() in functions.php).
 *
 * flatpickr comes along with that plugin, so when it is there we swap in a picker that
 * greys the closed days out. Without it we keep the native date input and just bounce a
 * bad pick. Either way woocommerce_checkout_process re-checks server-side.
 */
(function () {
  'use strict';

  const LOCALE_ES = {
    weekdays: {
      shorthand: ['Dom', 'Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb'],
      longhand:  ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado']
    },
    months: {
      shorthand: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
      longhand:  ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto',
                  'Septiembre', 'Octubre', 'Noviembre', 'Diciembre']
    },
    rangeSeparator: ' a '
  };

  const BLOCKED_MSG = 'No realizamos entregas ese día. Elige otra fecha.';

  function parseList(raw) {
    try {
      const parsed = JSON.parse(raw);
      return Array.isArray(parsed) ? parsed : [];
    } catch (e) {
      return [];
    }
  }

  /* 'YYYY-MM-DD' → local midnight. new Date(string) would parse it as UTC and can slip a day. */
  function toLocalDate(value) {
    const parts = /^(\d{4})-(\d{2})-(\d{2})$/.exec(value);
    return parts ? new Date(+parts[1], +parts[2] - 1, +parts[3]) : null;
  }

  function toISO(date) {
    const pad = (n) => (n < 10 ? '0' + n : '' + n);
    return date.getFullYear() + '-' + pad(date.getMonth() + 1) + '-' + pad(date.getDate());
  }

  function setError(input, message) {
    const row = input.closest('.form-row') || input.parentNode;
    let note = row.querySelector('.bf-date-error');
    if (!note) {
      note = document.createElement('span');
      note.className = 'bf-date-error';
      note.setAttribute('role', 'alert');
      row.appendChild(note);
    }
    note.textContent = message;
  }

  function clearError(input) {
    const row  = input.closest('.form-row') || input.parentNode;
    const note = row.querySelector('.bf-date-error');
    if (note) note.remove();
  }

  function init() {
    const input = document.getElementById('bomflor_delivery_date');
    if (!input || input.dataset.bfDateReady === '1') return;
    input.dataset.bfDateReady = '1';

    const disabledWeekdays = parseList(input.getAttribute('data-disabled-weekdays'));
    const offDates         = parseList(input.getAttribute('data-off-dates'));
    const minDate          = input.getAttribute('min') || null;
    const maxDate          = input.getAttribute('max') || null;
    const weekStart        = parseInt(input.getAttribute('data-week-start'), 10) || 0;
    const altFormat        = input.getAttribute('data-alt-format') || 'j F, Y';

    if (typeof window.flatpickr === 'function') {
      LOCALE_ES.firstDayOfWeek = weekStart;

      window.flatpickr(input, {
        dateFormat:     'Y-m-d',
        altInput:       true,
        altFormat:      altFormat,
        altInputClass:  'input-text bf-date-alt',
        minDate:        minDate,
        maxDate:        maxDate,
        disableMobile:  true, // the native picker cannot grey out weekdays
        locale:         LOCALE_ES,
        disable: offDates.concat([
          (date) => disabledWeekdays.indexOf(date.getDay()) !== -1
        ]),
        onChange: () => clearError(input)
      });
      return;
    }

    /* Fallback: native input, so an invalid day can only be caught after the fact. */
    input.addEventListener('change', function () {
      if (!input.value) {
        clearError(input);
        return;
      }
      const picked = toLocalDate(input.value);
      if (!picked) return;

      if (disabledWeekdays.indexOf(picked.getDay()) !== -1 || offDates.indexOf(toISO(picked)) !== -1) {
        input.value = '';
        setError(input, BLOCKED_MSG);
        return;
      }
      clearError(input);
    });
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }

  // The delivery card sits outside #order_review so AJAX refreshes leave it alone, but
  // re-running init() is cheap and guarded.
  if (window.jQuery) {
    window.jQuery(document.body).on('updated_checkout', init);
  }
})();
