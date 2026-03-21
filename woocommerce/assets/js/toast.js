(function ($) {
  const $toast = $('#siteToast');
  const $title = $('#siteToastTitle');
  const $message = $('#siteToastMessage');
  const $close = $('#siteToastClose');

  let toastTimer = null;

  function resetToastClass() {
    $toast.removeClass('is-success is-error is-warning is-info');
  }

  window.showToast = function (options = {}) {
    const {
      title = 'Notification',
      message = '',
      type = 'success',
      duration = 3000
    } = options;

    clearTimeout(toastTimer);

    resetToastClass();
    $toast.addClass('is-' + type);

    $title.text(title);
    $message.text(message);

    $toast.addClass('show');

    if (duration > 0) {
      toastTimer = setTimeout(function () {
        $toast.removeClass('show');
      }, duration);
    }
  };

  window.hideToast = function () {
    clearTimeout(toastTimer);
    $toast.removeClass('show');
  };

  $close.on('click', function () {
    window.hideToast();
  });

})(jQuery);