jQuery(function ($) {
  const selectors = {
    button: ".wishlist-btn",
    popup: "#wishlistDrawer",
    popupContent: "#wishlistDrawerContent",
    popupClose: ".button-close, .body-overlay",
    removeItem: ".remove-wishlist-item",
  };

  const $popup = $(selectors.popup);
  const $popupContent = $(selectors.popupContent);

  function openPopup() {
    $popup.addClass("is-open").attr("aria-hidden", "false");
    $("body").addClass("body-overflow");
    $(".body-overlay").addClass('is-visible');
  }

  function closePopup() {
    $popup.removeClass("is-open").attr("aria-hidden", "true");
    $("body").removeClass("body-overflow");
    $(".body-overlay").removeClass('is-visible');
  }

  function setPopupLoading() {
    $popupContent.html(
      `<div class="wishlist-loading">${wishlist_params.texts.loading}</div>`
    );
  }

  function setPopupError() {
    $popupContent.html(
      `<div class="wishlist-error">${wishlist_params.texts.error}</div>`
    );
  }

  function renderPopupContent(html) {
    $popupContent.html(html || "");
  }

  function syncWishlistButtons(productId, isAdded) {
    const $buttons = $(`${selectors.button}[data-product-id="${productId}"]`);
    $buttons.toggleClass("is-added", isAdded);
    const iconHtml = isAdded 
    ? `<svg xmlns="http://www.w3.org/2000/svg" width="16" height="14" viewBox="0 0 16 14" fill="none" aria-hidden="true">
        <path d="M8 13.4C7.85 13.4 7.71 13.35 7.6 13.25L2.18 8.24C0.78 6.95 0 5.82 0 4.33C0 1.86 1.79 0 4.16 0C5.65 0 7.05 0.69 8 1.87C8.95 0.69 10.35 0 11.84 0C14.21 0 16 1.86 16 4.33C16 5.82 15.22 6.95 13.82 8.24L8.4 13.25C8.29 13.35 8.15 13.4 8 13.4Z" fill="currentColor"/>
      </svg>`
    : `<svg xmlns="http://www.w3.org/2000/svg" width="16" height="14" viewBox="0 0 16 14" fill="none">
        <path d="M14.9252 2.98931C14.8384 2.64973 14.7045 2.32398 14.5274 2.02157C14.3572 1.70697 14.1396 1.42046 13.8822 1.1721C13.509 0.800206 13.0672 0.504396 12.5811 0.301137C11.6028 -0.100379 10.5057 -0.100379 9.52735 0.301137C9.06796 0.495587 8.6459 0.768473 8.28004 1.10759L8.22628 1.1721L7.52735 1.87103L6.82843 1.1721L6.77466 1.10759C6.40881 0.768473 5.98674 0.495587 5.52735 0.301137C4.54902 -0.100379 3.45191 -0.100379 2.47359 0.301137C1.98755 0.504396 1.54566 0.800206 1.17251 1.1721C0.662151 1.6687 0.300869 2.29815 0.129502 2.98931C0.0383356 3.3403 -0.00506651 3.70198 0.000469976 4.06458C0.000469976 4.40544 0.0434807 4.74522 0.129502 5.07533C0.219646 5.40871 0.349614 5.73002 0.516599 6.03232C0.696938 6.34308 0.917478 6.6287 1.17251 6.88178L7.52735 13.2366L13.8822 6.88178C14.137 6.63124 14.3553 6.34415 14.5274 6.03232C14.8766 5.43566 15.0586 4.75592 15.0542 4.06458C15.0598 3.70198 15.0164 3.34029 14.9252 2.98931ZM13.8499 4.742C13.7211 5.23331 13.4653 5.68204 13.108 6.04307L7.50585 11.6345L1.9037 6.04307C1.72114 5.85922 1.56221 5.65333 1.43058 5.43017C1.30671 5.20939 1.20927 4.9748 1.14025 4.73124C1.08516 4.48772 1.05632 4.23898 1.05423 3.98931C1.05569 3.7325 1.08453 3.47657 1.14025 3.22587C1.20725 2.98161 1.30479 2.74678 1.43058 2.52694C1.55961 2.30114 1.71875 2.09684 1.9037 1.91404C2.17993 1.64151 2.50444 1.42273 2.86068 1.26888C3.57855 0.9817 4.37938 0.9817 5.09724 1.26888C5.45208 1.41619 5.77251 1.63232 6.04348 1.90329L7.50585 3.37641L8.96821 1.90329C9.23899 1.63184 9.5605 1.41628 9.91445 1.26888C10.6323 0.9817 11.4331 0.9817 12.151 1.26888C12.5069 1.42264 12.8317 1.642 13.108 1.91404C13.2951 2.09146 13.4521 2.29791 13.5704 2.52694C13.8194 2.96615 13.9492 3.4629 13.9467 3.9678C13.9613 4.22761 13.9396 4.48819 13.8822 4.742H13.8499Z" fill="currentColor"/>
      </svg>`;
    $buttons.each(function () {
      const $button = $(this);
      const label = isAdded
        ? wishlist_params.texts.browse
        : wishlist_params.texts.add;

      $button.attr("aria-label", label);

      $button.find(".button-icon").html(iconHtml);
    });
  }

  function loadWishlistPopup() {
    setPopupLoading();
    openPopup();

    $.ajax({
      url: wishlist_params.ajax_url,
      type: "POST",
      dataType: "json",
      data: {
        action: "get_wishlist_popup",
        nonce: wishlist_params.nonce,
      },
      success: function (response) {
        if (!response || !response.success || !response.data) {
          setPopupError();
          return;
        }

        renderPopupContent(response.data.html);
      },
      error: function () {
        setPopupError();
      },
    });
  }

  $(document).on("click", selectors.button, function (event) {
    event.preventDefault();

    const $button = $(this);

    if ($button.hasClass("is-loading")) {
      return;
    }

    const productId = parseInt($button.attr("data-product-id"), 10);
    const nonce = $button.attr("data-nonce") || wishlist_params.nonce;

    if (!productId) {
      return;
    }

    if ($button.hasClass("is-added")) {
      loadWishlistPopup();
      return;
    }

    $button.addClass("is-loading");

    $.ajax({
      url: wishlist_params.ajax_url,
      type: "POST",
      dataType: "json",
      data: {
        action: "toggle_wishlist",
        product_id: productId,
        nonce: nonce,
      },
      success: function (response) {
        if (!response || !response.success || !response.data) {
          return;
        }

        syncWishlistButtons(productId, true);
        renderPopupContent(response.data.html);
        openPopup();
      },
      complete: function () {
        $button.removeClass("is-loading");
      },
    });
  });

  $(document).on("click", selectors.popupClose, function (event) {
    event.preventDefault();
    closePopup();
  });

  $(document).on("click", selectors.removeItem, function (event) {
    event.preventDefault();

    const $button = $(this);

    if ($button.hasClass("is-loading")) {
      return;
    }

    const productId = parseInt($button.attr("data-product-id"), 10);

    if (!productId) {
      return;
    }

    $button.addClass("is-loading");

    $.ajax({
      url: wishlist_params.ajax_url,
      type: "POST",
      dataType: "json",
      data: {
        action: "remove_wishlist_item",
        product_id: productId,
        nonce: wishlist_params.nonce,
      },
      success: function (response) {
        if (!response || !response.success || !response.data) {
          return;
        }

        syncWishlistButtons(productId, false);
        renderPopupContent(response.data.html);
      },
      complete: function () {
        $button.removeClass("is-loading");
      },
    });
  });

  $(document).on("keyup", function (event) {
    if (event.key === "Escape") {
      closePopup();
    }
  });
});