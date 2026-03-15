(function ($) {
    "use strict";

    function tabsHandler( $scope, $ ) {
        const $selectors = $scope.find('.tabs .tab-button');
        if( !$selectors.length ) {
            return;
        }
        $selectors.each(function() {
            const $button = $(this);
            if( $button.hasClass('is-active') ) {
                const index = $button.index();
                const tabKey = $(this).closest('.tabs').data('key') ?? '';
                const $tab = $(`.tabs[data-key=${tabKey}]`);
                const $contents = $tab.find('.tab-content');
                const $images = $tab.find('.image');
                if( $contents.length ) {
                    const $contentActive = $($contents[index]);
                    $contents.removeClass('is-active').each(function() {
                        $(this).css('height', 0)
                    });
                    if( $contentActive.length ) {
                        $contentActive.addClass('is-active')
                        $contentActive.css('height', $contentActive.prop('scrollHeight'));
                    }
                }
                if( $images.length ) {
                    $images.removeClass('is-active');
                    $($images[index]).addClass('is-active')
                }
            }
        })
        $selectors.on('click', function(e) {
            e.preventDefault();
            const $button = $(this);
            if( $button.hasClass('is-active') ) {
                return;
            }
            const index = $button.index();
            const tabKey = $(this).closest('.tabs').data('key') ?? '';
            const $tab = $(`.tabs[data-key=${tabKey}]`);
            const $contents = $tab.find('.tab-content');
            const $images = $tab.find('.image');
            if( $contents.length ) {
                const $contentActive = $($contents[index]);
                $contents.removeClass('is-active').each(function() {
                    $(this).css('height', 0)
                });
                if( $contentActive.length ) {
                    $contentActive.addClass('is-active')
                    $contentActive.css('height', $contentActive.prop('scrollHeight'));
                }
            }
            if( $images.length ) {
                $images.removeClass('is-active');
                $($images[index]).addClass('is-active')
            }
            $selectors.removeClass('is-active');
            $button.addClass('is-active ')
        })
    }

    $(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction('frontend/element_ready/mindverse_tabs.default', tabsHandler);
    });

})(jQuery);
