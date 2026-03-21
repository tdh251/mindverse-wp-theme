( function( $ ) {
    "use strict";

    /**
     * Element Animation
     */
    function animation( $scope, $ ) {
        $scope.find('img').imagesLoaded().done( function( instance ) {  
            const $selectors = $scope.find('.carousel-item, .accordion-item, .step-item, .grid-item',);
            const $carousel = $scope.find('> .swiper');
            let swiper;
            let carouselAutoPlay = false;
            const finalState = {
                x: 0,
                y: 0,
                z: 0,
                rotation: 0,
                rotationX: 0,
                rotationY: 0,
                scale: 1,
                scaleX: 1,
                scaleY: 1,
                opacity: 1,
                filter: "blur(0px)", 
                force3D: true        
            };
            if( !$scope.is('[data-gsap-animation]') ) {
                return;
            }
            if( $carousel.length && $carousel[0].swiper ) {
                swiper = $carousel[0].swiper;
                swiper.autoplay.stop();
                carouselAutoPlay = true;
            }
            let customSettings = $scope.data('gsap-animation');
            const {
                animation = '',
                stagger =  0.25,
            } = customSettings;
            let defaultSettings = {
                scrollTrigger: {
                    trigger: $scope[0],
                    start: '30px bottom',
                    end: `bottom bottom`,
                    toggleActions: "play none none none",
                    scrub: 3,
                    markers: false,
                },
                ease: "power2.out",
            };
            if( animation === 'fadeIn' ) {
                customSettings = { opacity: 0 };
            } else if( animation === 'fadeInUp' ) {
                customSettings = { y: 100, opacity: 0 };
            } else if( animation === 'fadeInRight' ) {
                customSettings = { x: 100, opacity: 0 };
            } else if( animation === 'fadeInDown' ) {
                customSettings = { y: -100, opacity: 0 };
            } else if( animation === 'fadeInLeft' ) {
                customSettings = { x: -100, opacity: 0 };
            } else if( animation === 'zoomIn' ) {
                customSettings = { 
                    scale: 0,
                }
                if( !$selectors.length || $scope.hasClass('e-con') ) {
                    const curXPercent = gsap.getProperty($scope[0], "xPercent"); 
                    const curYPercent = gsap.getProperty($scope[0], "yPercent");
                    customSettings = { 
                        scale: 0,
                        xPercent: curXPercent,
                        yPercent: curYPercent,
                    }
                }
            } else {
                if( customSettings.perspective && customSettings.perspective > 0 ) {
                    gsap.set( $scope, {
                        transformOrigin: 'center center',
                        transformStyle: "preserve-3d",
                        willChange: "transform",
                        transformPerspective: customSettings.perspective,
                    })
                    delete customSettings.perspective;
                }
            }
            gsap.set( $scope, {visibility:"visible"} );
            let settings = { ...defaultSettings, ...customSettings };
            if( !$selectors.length || $scope.hasClass('e-con') ) {
                gsap.from($scope, settings);
                return;
            }
            const $targetsToSet = $selectors.filter(function() {
                const $el = $(this);
                if ($el.hasClass('carousel-item')) {
                    return $el.is('.swiper-slide-fully-visible, .swiper-slide-active, .swiper-slide-visible');
                }
                return true;
            });

            gsap.set($targetsToSet, customSettings);

            ScrollTrigger.batch($selectors, {
                onEnter: elements => {
                    let targetsToAnimate = elements.filter(el => {
                        const $el = $(el);
                        if ($el.hasClass('carousel-item')) {
                            return $el.is('.swiper-slide-fully-visible, .swiper-slide-active, .swiper-slide-visible');
                        }
                        return true;
                    });

                    if (targetsToAnimate.length === 0) return;

                    gsap.to(targetsToAnimate, {
                        ...finalState,
                        duration: 1,
                        stagger: stagger,
                        overwrite: "auto",
                        onCompleteAll: () => {
                            if (swiper && typeof swiper.update === 'function') {
                                swiper.update();
                            }
                            if (carouselAutoPlay && swiper.autoplay) {
                                setTimeout(() => {
                                    swiper.autoplay.start();
                                }, 1500);
                            }
                        }
                    });
                },
                once: true
            });
        })
    }
    
    $( window ).on( 'elementor/frontend/init', function() {
        elementorFrontend.hooks.addAction('frontend/element_ready/container', animation);
        elementorFrontend.hooks.addAction('frontend/element_ready/widget', animation);

    });
    
} )( jQuery );