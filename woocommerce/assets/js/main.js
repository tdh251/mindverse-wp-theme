;(function ($) {
    $(function () {
        $(document.body).on('click', '.quantity .quantity-icon', function () {
            const $btn = $(this);
            const $input = $btn.siblings('input[type="number"].qty');
    
            if (!$input.length) {
                return;
            }
    
            let currentVal = parseFloat($input.val()) || 0;
            const step = parseFloat($input.attr('step')) || 1;
            const min = parseFloat($input.attr('min')) || 0;
            const max = parseFloat($input.attr('max')) || Infinity;
    
            if ($btn.hasClass('icon-minus')) {
                let newVal = currentVal - step;
                newVal = Math.max(newVal, min);
                $input.val(newVal);
            } else {
                let newVal = currentVal + step;
                newVal = Math.min(newVal, max);
                $input.val(newVal);
            }
    
            $input.trigger('change');
        });

    });
})(jQuery);