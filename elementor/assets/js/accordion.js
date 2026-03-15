(function ($) {
    "use strict";

    function accordionHandler( $scope ) {
        const $selectors = $scope.find('.accordion');
        if( !$selectors.length ) {
            return;
        }

        $selectors.each(function () {  
            const $selector = $(this);
            const $items = $selector.find('.accordion-item');
            const mode = $selector.data('mode');

            $items.each(function () {
                const $item = $(this);
                const $content = $item.find('.accordion-content');
                if ($item.hasClass('is-active')) {
                    $content.css('height', $content.prop('scrollHeight'));
                }
            });

            $items.on('click', function (e) {  
                // if(mode === 'multiple') {

                // }
                const $item = $(this);
                const $content = $item.find('.accordion-content');
                if( $item.hasClass('is-active') ) {
                    $item.removeClass('is-active')
                    $content.css('height', 0);
                    return;
                }
                $items.removeClass('is-active').each(function () {
                    $(this).find('.accordion-content').css('height', 0);
                });
                $item.addClass('is-active');
                $content.css('height', $content.prop('scrollHeight'));

                $(document.body).trigger('scrolltrigger_refresh');
            })
        })
    }

    $(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction('frontend/element_ready/mindverse_accordion.default', accordionHandler);
    });

})(jQuery);
