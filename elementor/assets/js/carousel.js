(function ($) {
    "use strict";

    function initSwiperCarousel($scope) {
        const $carousels = $scope.find('.swiper');
        if (!$carousels.length) {
            return;
        }

        $carousels.each(function () {
            const $carousel = $(this);

           if ($carousel.hasClass('swiper-initialized')) {
                return;
            }

            const params = $carousel.data('swiper') ?? {};

            let navigation = {
                prevEl: $carousel.find('.carousel-button-prev')[0],
                nextEl: $carousel.find('.carousel-button-next')[0],
            };

            if (params['navigation'] != false && params['navigation']) {
                const $navPrev = $(params['navigation'].prevEl);
                const $navNext = $(params['navigation'].nextEl);

                if ($navPrev.length) {
                    navigation.prevEl = $navPrev[0];
                }
                if ($navNext.length) {
                    navigation.nextEl = $navNext[0];
                }
            }

            let settings = {
                slidesPerGroup: 1,
                slidesPerView: 'auto',
                spaceBetween: params['spaceBetween'] ?? 0,
                wrapperClass: 'swiper-wrapper',
                slideClass: 'swiper-slide',
                watchSlidesProgress: true,
                watchSlidesVisibility: true,
                observer: true,
                observeParents: true,
                touchRatio: params['touchRatio'] ?? 1,
                allowTouchMove: params['allowTouchMove'],
                centeredSlides: params['centeredSlides'],
                direction: params['direction'],
                autoplay: params['autoplay'],
                freeMode: params['freeMode'],
                initialSlide: params['initialSlide'],
                loop: params['loop'],
                mousewheel: params['mousewheel'],
                grid: {
                    rows: params['rows'] || 1,
                    fill: 'row'
                },
                navigation: navigation,
                pagination: params['pagination'] === '' || !params['pagination']
                    ? false
                    : {
                        el: $carousel.find('.carousel-pagination')[0],
                        type: params['pagination'],
                        clickable: true,
                        bulletClass: 'bullet',
                        bulletActiveClass: 'is-active',
                    },
                scrollbar: !params['scrollbar']
                    ? false
                    : {
                        el: $carousel.find('.carousel-scrollbar')[0],
                    },

                speed: params['speed'],
                grabCursor: true,
                effect: "slide",
                breakpoints: params['direction'] !== 'vertical' ? {
                    0: {
                        slidesPerView: params['slides_per_view_xs'] ?? 1,
                    },
                    576: {
                        slidesPerView: params['slides_per_view_sm'] ?? 1,
                    },
                    768: {
                        slidesPerView: params['slides_per_view_md'] ?? 2,
                    },
                    992: {
                        slidesPerView: params['slides_per_view_lg'] ?? 2,
                    },
                    1200: {
                        slidesPerView: params['slides_per_view_xl'] ?? 3,
                    },
                    1400: {
                        slidesPerView: params['slides_per_view_xxl'] ?? 3,
                    },
                } : {},
                on: {
                    init: function() {
                        const swiper = this;
                        const $carousel = $(swiper.el);

                        // 👉 CLICK THUMB -> MAIN
                        if ($carousel.closest('#horizontalCarousel').length) {
                            const mainSwiper = $('.custom-product-gallery .swiper')[0]?.swiper;
                            if (!mainSwiper) return;

                            $(swiper.slides).each(function (index, slide) {
                                $(slide).on('click', function () {
                                    const realIndex = slide.dataset.swiperSlideIndex !== undefined
                                        ? parseInt(slide.dataset.swiperSlideIndex, 10)
                                        : index;

                                    mainSwiper.slideTo(realIndex);
                                });
                            });
                        }
                    },

                    slideChange: function() {
                        const swiper = this;
                        const $carousel = $(swiper.el);

                        if ($carousel.hasClass('swiper-boxshadow')) {
                            $(swiper.slides).css('opacity', '0');
                            $(swiper.slides).filter('.swiper-slide-visible').css('opacity', '1');
                        }
                    },

                    transitionEnd: function() {
                        const swiper = this;
                        const $carousel = $(swiper.el);

                        if ($carousel.hasClass('swiper-boxshadow')) {
                            $(swiper.slides).css('opacity', '0');
                            $(swiper.slides).filter('.swiper-slide-visible').css('opacity', '1');
                        }
                    }
                }
            };

            new Swiper($carousel[0], settings);
        });
    }

    function carouselHandler($scope, $) {
        initSwiperCarousel($scope);
    }

    // Elementor
    $(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction('frontend/element_ready/mindverse_feature_card_carousel.default', carouselHandler);
        elementorFrontend.hooks.addAction('frontend/element_ready/mindverse_step_carousel.default', carouselHandler);
        elementorFrontend.hooks.addAction('frontend/element_ready/mindverse_testimonial_carousel.default', carouselHandler);
        elementorFrontend.hooks.addAction('frontend/element_ready/mindverse_icon_box_carousel.default', carouselHandler);
        elementorFrontend.hooks.addAction('frontend/element_ready/mindverse_image_carousel.default', carouselHandler);
    });

    // Ngoài Elementor
    $(document).ready(function () {
        initSwiperCarousel($(document));
    });

})(jQuery);