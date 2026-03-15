( function( $ ) {
    "use strict";

    function backgroundParallax( $scope, $ ) {
        const $selectors = $scope.find('.background-parallax');
        if( !$selectors.length || $(window).width() < 768 ) {
            return;
        }
        $selectors.each(function(i, selector) {
            const $selector = $(selector);
            const $parent = $selector.closest('.e-con.elementor-element');
            const settings = $selector.data('custom-settings') ?? {};
            const x = parseFloat(settings.x) ?? 0;
            const y = parseFloat(settings.y) ?? 0;
            const rotate = parseFloat(settings.rotate) ?? 0;
            const scale = parseFloat(settings.scale) ?? 1;
            gsap.set($parent, {overflow: 'hidden'})
            if (x > 0) {
                gsap.set( $selector, { left: -x });
            } 
            if (x < 0) {
                gsap.set( $selector, { right: x });
            }
            if (y > 0) {
                gsap.set( $selector, { top: -y });
            }
            if (y < 0) {
                gsap.set( $selector, { bottom: y });  
            }
            gsap.to( $selector, {
                x: x,
                y: y,
                rotate: rotate,
                scale: scale,
                scrollTrigger: {
                    trigger: $parent[0],
                    start: 'top 90%',
                    end: 'bottom 10%',
                    scrub: true,
                }
            })
        })
    }

    
    $( window ).on( 'elementor/frontend/init', function() {
        elementorFrontend.hooks.addAction('frontend/element_ready/container', backgroundParallax);
    });
    

} )( jQuery );