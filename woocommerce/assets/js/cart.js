;(function ($) {
    $(function () {
        const FORM_SELECTOR = "form.cart";
        const BUTTON_SELECTOR = ".single_add_to_cart_button";

        function submitMindverseCart($form, $button) {
            if (!$form.length || $form.data("isSubmitting")) {
                return;
            }

            $form.data("isSubmitting", true);

            const data = {};
            const formArray = $form.serializeArray();

            $.each(formArray, function (_, field) {
                if (data[field.name] !== undefined) {
                    if (!Array.isArray(data[field.name])) {
                        data[field.name] = [data[field.name]];
                    }
                    data[field.name].push(field.value);
                } else {
                    data[field.name] = field.value;
                }
            });

            const productId =
                $form.find('[name="add-to-cart"]').val() ||
                $button.val();

            if (!productId) {
                $form.data("isSubmitting", false);
                return;
            }

            // Do not send add-to-cart again
            data.product_id = productId;
            data.quantity = parseInt(data.quantity, 10) || 1;

            $.ajax({
                type: "POST",
                url: mindverse_cart_params.wc_ajax_url,
                data: data,
                dataType: "json",
                beforeSend: function () {
                    $button.addClass("loading");
                },
                success: function (response) {
                    if (response && response.fragments) {
                        $.each(response.fragments, function (selector, html) {
                            $(selector).replaceWith(html);
                        });

                        $(document.body).trigger("added_to_cart", [
                            response.fragments,
                            response.cart_hash,
                            $button
                        ]);
                    }
                },
                error: function (xhr) {
                    console.error("Add to cart failed:", xhr);
                },
                complete: function () {
                    $button.removeClass("loading");
                    $form.data("isSubmitting", false);
                }
            });
        }

        // Bind directly to existing forms/buttons, not delegated on document
        $(FORM_SELECTOR).each(function () {
            const form = this;
            const $form = $(form);
            const $button = $form.find(BUTTON_SELECTOR).first();

            if (!$button.length) {
                return;
            }

            // Remove jQuery handlers on this form/button
            $form.off("submit");
            $button.off("click");

            // Native capture phase: block other bubbling handlers
            form.addEventListener(
                "submit",
                function (e) {
                    e.preventDefault();
                    e.stopPropagation();
                    submitMindverseCart($form, $button);
                },
                true
            );

            $button[0].addEventListener(
                "click",
                function (e) {
                    e.preventDefault();
                    e.stopPropagation();
                    submitMindverseCart($form, $button);
                },
                true
            );
        });

        $(document.body).on("added_to_cart", function (event, fragments) {
            if (fragments) {
                $.each(fragments, function (selector, html) {
                    $(selector).replaceWith(html);
                });
            }

            $("#cartDrawer").addClass("is-open").attr("aria-hidden", "false");
            $("body").addClass("body-overflow");
            $(".body-overlay").addClass("is-visible");
        });

        $(document).on("click", "#cartDrawer .button-close, .body-overlay", function () {
            $("#cartDrawer").removeClass("is-open").attr("aria-hidden", "true");
            $("body").removeClass("body-overflow");
            $(".body-overlay").removeClass("is-visible");
        });
    });
})(jQuery);