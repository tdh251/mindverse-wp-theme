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

    function moveToTargetOnScroll() {
        const $selector = $('.image-move-on');
        if (!$selector.length || $(window).width() < 1400 ) return;

        function getCenter($el) {
            const rect = $el[0].getBoundingClientRect();
            return {
                x: rect.left + rect.width / 2 + window.pageXOffset,
                y: rect.top + rect.height / 2 + window.pageYOffset
            };
        }

        const $smoothContent = $('#smooth-content');
        const offset = $selector.offset();
        
        const $clone = $selector.clone(false, false).addClass('is-clone wow fadeIn').css({
            position: 'absolute',
            top: offset.top,
            left: offset.left,
            width: $selector.outerWidth(),
            height: $selector.outerHeight(),
            zIndex: 9999,
            pointerEvents: 'none',
            transformOrigin: 'center center' 
        });

        ($smoothContent.length ? $smoothContent : $('body')).append($clone);

        const settings = $selector.data('settings') ?? [];
        if (!settings.length) return;

        $selector.css('opacity', 0);

        let prevCenter = getCenter($clone);
        let totalDistance = 0;

        const tl = gsap.timeline({
            scrollTrigger: {
                trigger: $selector[0],
                start: 'center center',
                scrub: 1,
                invalidateOnRefresh: true,
                end: () => `+=${totalDistance}`,
                markers: false
            }
        });

        settings.forEach((setting) => {
            const $target = $(setting.target);
            if (!$target.length) return;
            
            $target.css('opacity', 0);
            
            const scale = setting.scale || 1;
            const flipX = setting.flipX ?? false;
            
            // Tính toán tọa độ tâm của target hiện tại
            const targetCenter = getCenter($target);

            // Tính độ chênh lệch so với điểm trước đó để dùng += trong GSAP
            const dx = targetCenter.x - prevCenter.x;
            const dy = targetCenter.y - prevCenter.y;

            const distance = Math.abs(dy) || 200; 
            totalDistance += distance;

            tl.to($clone, {
                x: `+=${dx}`,
                y: `+=${dy}`,
                scale: scale,
                // Nếu flipX true, lật ngược bằng cách nhân âm giá trị scale
                scaleX: flipX ? -scale : scale,
                ease: 'none',
                duration: distance 
            });

            // Cập nhật lại tâm điểm để tính cho target tiếp theo
            prevCenter = targetCenter;
        });
    }

    // function moveOn( ) {
    //     const $selectors = $('.image-move-on');
    //     if( ! $selectors.length ) {
    //         return;
    //     }
    //     $selectors.find('img').imagesLoaded().done( function( instance ) {  
    //         $selectors.each(function() {
    //             const $selector = $(this);
                
    //             const offset = $selector.offset();
    //             const width = $selector.outerWidth();
    //             const height = $selector.outerHeight();
    
    //             const $clone = $selector.clone().css({
    //                 position: 'absolute',
    //                 top: offset.top,
    //                 left: offset.left,
    //                 width: width,
    //                 height: height,
    //                 margin: 0,
    //                 zIndex: 9999,
    //                 // pointerEvents: 'none' 
    //             });
    
    //             $('body').append($clone);
    //         })
    //     })
    // }
    
    $( window ).on( 'elementor/frontend/init', function() {
        // moveToTargetOnScroll();
        // moveOn()
        elementorFrontend.hooks.addAction('frontend/element_ready/container', animation);
        elementorFrontend.hooks.addAction('frontend/element_ready/widget', animation);

    });
    
} )( jQuery );