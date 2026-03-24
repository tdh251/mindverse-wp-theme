;(function($) {
    'use strict';

    const Mindverse = {};

    let windowWidth = $(window).width();
    let windowHeight = $(window).height();
    let resizeTimeout;
    let lastScrollTop = 0;
    

    function getSafeObjectData($element, key) {
        const data = $element.data(key);
        return data && typeof data === 'object' ? { ...data } : {};
    }

    function hasGSAP() {
        return typeof gsap !== 'undefined';
    }

    function hasScrollTrigger() {
        return typeof ScrollTrigger !== 'undefined';
    }
    $( window ).on('resize', function() {
        windowWidth = $(window).width();
        windowHeight = $(window).height();
        clearTimeout(resizeTimeout);
        resizeTimeout = setTimeout(function() {
            $(document.body).trigger('scrolltrigger_refresh');
        }, 500);
    });

    $( window ).on( 'load', function() {
        windowWidth = $(window).width();
        windowHeight = $(window).height();
        setTimeout(function () {  
            Mindverse.events.initSmoothScroll();
            Mindverse.events.textAnimation();
            Mindverse.interactions.sticky();
        }, 300)
        $('body').imagesLoaded().done( function( instance ) {
            Mindverse.interactions.scrollingEffects();
            setTimeout(() => {
                $(document.body).trigger('scrolltrigger_refresh');
            }, 500)
        })
    });

    $( window ).on('scroll', function() {
        let scrollTop = $(this).scrollTop();

        windowWidth = $(window).width();
        windowHeight = $(window).height();
        let $blurBottotmSite = $('.blur-bottom-site');
        let $backToTop = $('.back-to-top');
        let $headerSticky = $('#header-sticky');
        // Blur Bottom Site
        if( $blurBottotmSite.length ) { 
            if($(this).scrollTop() + windowHeight >= $(document).height() - 10) {
                $blurBottotmSite.css('opacity', 0);
            }else {
                $blurBottotmSite.css('opacity', 1);
            }
        }
        // Back to top
        if( $backToTop.length ) {
            if ($(this).scrollTop() > 300) { 
                $backToTop.addClass('is-show');
            } else {
                $backToTop.removeClass('is-show');
            }
        }
        // Header Sticky
        if ($headerSticky.length) {
            const directionType = $headerSticky.data('scroll');

            if (scrollTop > 150 && windowWidth >= 1200) {
                if (scrollTop > lastScrollTop) {
                    // Cuộn xuống
                    $('.header-sticky[data-scroll="down"]').addClass('is-active');
                    $('.header-sticky[data-scroll="up"]').removeClass('is-active');
                } else {
                    // Cuộn lên
                    $('.header-sticky[data-scroll="up"]').addClass('is-active');
                    $('.header-sticky[data-scroll="down"]').removeClass('is-active');
                }
            } 
            else if (scrollTop < 100 && windowWidth >= 1200) {
                // Trở về đầu trang thì ẩn hết
                $('.header-sticky').removeClass('is-active');
            }
            
            lastScrollTop = scrollTop <= 0 ? 0 : scrollTop;
        }
    });

    /** Library */
    Mindverse.library = {
        init: function(){
            this.initWow();
        },
        initWow: function() {
            var wow = new WOW({
                boxClass:     'wow',      // animated element css class (default is wow)
                animateClass: 'animated', // animation css class (default is animated)
                offset:      50,          // distance to the element when triggering the animation (default is 0)
                mobile:       true,       // trigger animations on mobile devices (default is true)
                live:         true,       // act on asynchronously loaded content (default is true)
                callback:     function(box) {
                    // the callback is fired every time an animation is started
                    // the argument that is passed in is the DOM node being animated
                },
                scrollContainer: null,    // optional scroll container selector, otherwise use window,
                resetAnimation: true,     // reset animation on end (default is true)
            });
            wow.init();
        },
    }

    /** Ultils */
    Mindverse.utils = {
        visibleBodyOverlay: function() {
            const $bodyOverlay = $('.body-overlay');
            if( $bodyOverlay.hasClass('is-visible') ) {
                return;
            }
            $bodyOverlay.addClass('is-visible');
        },
        hideBodyOverlay: function() {
            const $bodyOverlay = $('.body-overlay');
            $bodyOverlay.removeClass('is-visible');
        },
        mouseenterActive: function( parent, selector ) {
            const $parent = $(parent);
            if(!$parent.length) {
                return;
            }
            $parent.each(function() {
                const $this = $(this);
                $this.on('mouseenter', selector, function () {  
                    $this.find(selector).removeClass('is-active');
                    $(this).addClass('is-active');
                });
            });
        },
    }

    /** Navigation */
    Mindverse.navigation  = {
        init: function() {
            this.handleSubmenu();
            this.toggleSubmenuMobile();
        },
        handleSubmenu: function() {
            const $subMenus = $('.header-menu .sub-menu');
            $subMenus.each(function() {
                const $this = $(this);
                if($this.offset().left + $this.outerWidth() > windowWidth) {
                    $this.addClass('submenu-reverse')
                }
            })
        },
        toggleSubmenuMobile: function() {
            $('.header-navigation').on('click', '.menu-link-icon--mobile', function(e) {
                e.preventDefault();
                e.stopPropagation();

                const $this = $(this);
                const $parent = $this.closest('li.menu-item');
                const $submenu = $parent.find('> .sub-menu, > .pxl-mega-menu');

                if (!$submenu.length) return;

                // slideToggle tự động tính toán chiều cao và animation
                // 300 là tốc độ (ms), cậu có thể chỉnh nhanh chậm tùy ý
                $submenu.slideToggle(300, function() {
                    // Sau khi chạy xong animation, jQuery sẽ set display: block hoặc none
                    // Nếu muốn thêm class để đổi icon icon-plus thành icon-minus chẳng hạn:
                    $parent.toggleClass('is-open');
                });

                // Nếu muốn đóng các menu khác cùng cấp (Accordion style) thì thêm dòng này:
                // $parent.siblings('.menu-item.is-open').find('> .sub-menu, > .pxl-mega-menu').slideUp(300).parent().removeClass('is-open');
            });
        }
    }

    /** Interactions */
    Mindverse.interactions  = {
        init: function() {
            this.playVideoPopup();
            this.triggerSubmitForm();
            this.togglePanel();
            this.anchor();
            this.backToTop();
            this.priceCardActive();
            this.activePreviewShowCase();
        },
        // Active & unactive panel 
        togglePanel: function() {
            let currentPanel = '';
            $(document.body).on('click', '.button-toggle, .button-hamburger', function(e) {
                e.preventDefault();
                const $this = $(this);
                let panel = $this.attr('href') ? $this.attr('href') : $this.data('target');
                if( !$(panel).length ) {
                    return;
                }
                $('.body-overlay').addClass('is-visible');
                $('body').addClass('body-overflow');
                $(panel).addClass('is-active');
                currentPanel = panel;
            })
            $(document.body).on('click', '.button-close, .body-overlay', function(e) {
                e.preventDefault();
                if (!currentPanel) return;
                $('.body-overlay').removeClass('is-visible');
                $('body').removeClass('body-overflow');
                $(currentPanel).removeClass('is-active');
                currentPanel = '';
            });
        },
        // Popup Video & Play Video
        playVideoPopup: function() {
            const getEmbedUrl = function(url) {
                let embedUrl = null;
                
                const youtubeRegex = /(?:[?&]v=([^&]+)|youtu\.be\/([^?]+))/;
                let ytMatch = url.match(youtubeRegex);
                
                if (ytMatch) {
                    const videoId = ytMatch[1] || ytMatch[2]; 
                    embedUrl = `https://www.youtube.com/embed/${videoId}?autoplay=1&rel=0`;
                    return embedUrl;
                }

                const vimeoRegex = /vimeo\.com\/(?:video\/)?(\d+)/;
                let vimeoMatch = url.match(vimeoRegex);
                
                if (vimeoMatch) {
                    const videoId = vimeoMatch[1];
                    embedUrl = `https://player.vimeo.com/video/${videoId}?autoplay=1`;
                    return embedUrl;
                }

                if (url.endsWith('.mp4')) {
                    return `<video controls autoplay src="${url}"></video>`;
                }
                return null;
            }

            const closeVideoPopup = function() {
                const $overlay = $('.body-overlay');
                const $popup = $('.video-popup');

                if (!$popup.length) return;

                $overlay.removeClass('is-visible');
                $popup.removeClass('is-visible');
                $('body').removeClass('body-overflow');

                $popup.one('transitionend webkitTransitionEnd oTransitionEnd', function() {
                    $popup.remove();
                });
            }
            $(document.body).on('click', '.button[data-type="play"]', function(e) {
                e.preventDefault();
                
                const videoUrl = $(this).attr('href');
                if (!videoUrl) return;

                const embedContent = getEmbedUrl(videoUrl);
                
                if (!embedContent) {
                    console.error('Unable to recognize video link:', videoUrl);
                    return;
                }

                let playerHtml = embedContent.startsWith('<video') 
                    ? embedContent 
                    : `<iframe src="${embedContent}" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>`;

                const modalHtml = `
                    <div class="video-popup">
                    <div class="video-popup-inner">
                        <button class="button button-close" aria-label="Close">
                            <span class="icon-X"></span>
                        </button>
                            ${playerHtml}
                        </div>
                    </div>
                `;

                const $overlay = $('.body-overlay');
                
                const $popup = $(modalHtml);

                $('body').append($popup).addClass('body-overflow');

                setTimeout(function() {
                    $overlay.addClass('is-visible'); 
                    $popup.addClass('is-visible');    
                }, 10);
            });
            $(document.body).on('click', '.body-overlay.is-visible', function() {
                closeVideoPopup();
            });

            $(document.body).on('click', '.video-popup .button-close', function() {
                closeVideoPopup();
            });
        },

        // Trigger submit form to contact form 7
        triggerSubmitForm: function() {
            $(document.body).on('click', '.button[data-type="submit"]', function(e) {
                e.preventDefault();
                const target = $(this).data('target');
                const $form = $('form.wpcf7-form-' + target);
                if ($form.length) {
                    $(this).addClass('is-loading')
                    $form.addClass('is-loading')
                    if (typeof wpcf7 !== 'undefined' && typeof wpcf7.submit === 'function') {
                        wpcf7.submit($form[0]);    
                    } else {
                        $form.trigger('submit');  
                    }
                } else {
                    $(this).removeClass('is-loading');
                    console.warn('Target not found.');
                }
            });
            $(document).on('wpcf7submit', function (e) {  
                const formId = e.detail.contactFormId;
                const $buttonSubmit = $(`[data-target="${formId}"]`);
                const $form = $('form.wpcf7-form-' + formId);
                if( $form.length && $form.hasClass('is-loading') ) {
                    $form.removeClass('is-loading');
                }
                if( $buttonSubmit.length && $buttonSubmit.hasClass('is-loading') ) {
                    $buttonSubmit.removeClass('is-loading');
                }
            })

            $(document).on('change', '#your-cv', function() {
                const $input = $(this);
                const $container = $input.closest('.field-upload-control');
                
                let $fileNameDisplay = $container.find('.file-name-display');
                if ($fileNameDisplay.length === 0) {
                    $fileNameDisplay = $('<span class="file-name-display"></span>');
                    $container.append($fileNameDisplay);
                }

                if (this.files && this.files.length > 0) {
                    $fileNameDisplay.text(this.files[0].name).show();
                } else {
                    $fileNameDisplay.hide();
                }
            });

            $(document).on('wpcf7mailsent', function() {
                $('.file-name-display').hide().text('');
            });
        },

        anchor: function() {
            $(document).on('click', '[data-type="anchor"]', function(e) {
                e.preventDefault(); 

                let targetSelector = $(this).data('target') ?? '';
                let offsetData = parseFloat( $(this).data('offset') ?? 0 );

                let targetPosition = $(targetSelector).offset().top;

                $('html, body').animate({
                    scrollTop: targetPosition - offsetData
                }, 1000); 
            });
        },
        backToTop: function() {
            $('.back-to-top').on('click', function(e) {
                e.preventDefault();
                $('html, body').animate({ scrollTop: 0 });
            })
        },
        scrollingEffects: function () {
            const $selectors = $('[data-scrolling-effects]');
            if ( !$selectors.length ) {
                return;
            }
            $selectors.each(function () {
                const $selector = $(this);
                let settings = {};
                let customSettings = $selector.data('scrolling-effects') ?? {};
                
                let triggerType = customSettings.type ?? 'from';
                delete customSettings.type;
                const screen = customSettings.breakOn ?? 0;
                gsap.set( $selector, { visibility: 'visible' } )
                if( typeof customSettings !== 'object' || breakOnScreen( screen ) ) {
                    return;
                }
                delete customSettings.breakOn;

                let defaultSettings = {
                    scrollTrigger: {
                        trigger: $selector[0],
                        markers: false,
                        start: '50px 100%',
                        end: `100% 100%`,
                        toggleActions: "play none none reverse",
                        scrub: true,
                    },
                    ease: "none",
                };

                if (customSettings.name) {
                    const $container = $selector.parent();
                    const selectorWidth = $selector.outerWidth();
                    const containerWidth = $container.outerWidth();
                    const distanceX = selectorWidth - containerWidth;

                    if (distanceX <= 0) {
                        delete customSettings.name;
                        customSettings.x = 0;
                    } else {
                        if (customSettings.name === 'moveToLeft') {
                            customSettings.x = -distanceX;
                        } else if (customSettings.name === 'moveToRight') {
                            customSettings.x = distanceX;
                        }
                        delete customSettings.name;
                    }
                }

                if( customSettings.scrollTrigger ) {
                    defaultSettings.scrollTrigger.start = customSettings.scrollTrigger.start;
                    defaultSettings.scrollTrigger.end = customSettings.scrollTrigger.end;
                    delete customSettings.scrollTrigger;
                }
                if( customSettings.perspective && customSettings.perspective > 0 ) {
                    gsap.set( $selector, {
                        transformOrigin: 'center center',
                        transformStyle: "preserve-3d",
                        willChange: "transform",
                        transformPerspective: customSettings.perspective,
                    })
                    delete customSettings.perspective;
                }
                if( $selector.hasClass('is-sticky') ) {
                    const stickySettings = $selector.data('sticky-settings') ?? {};
                    const screen = stickySettings.breakOn ?? 0;
                    if( breakOnScreen( screen ) ) {
                        return;
                    }
                    const offset = stickySettings.offset;
                    const position = stickySettings.position ?? 'top';
                    defaultSettings.scrollTrigger.scrub = 1;
                    defaultSettings.scrollTrigger.start = `top top+=${offset}px`;
                    defaultSettings.scrollTrigger.end = `+=${$selector.outerHeight()}`;
                    if( position == 'bottom' ) {
                        defaultSettings.scrollTrigger.start = `bottom bottom-=${offset}`;
                    }
                    settings = { ...customSettings, ...defaultSettings };
                    triggerType = customSettings.type ?? 'to';
                    if( triggerType === 'to' ) {
                        gsap.to($selector, settings);
                    }else {
                        gsap.from($selector, settings);
                    }
                    return;
                }
                settings = { ...customSettings, ...defaultSettings };
                if( triggerType === 'to' ) {
                    gsap.to($selector, settings);
                }else {
                    gsap.from($selector, settings);
                }
            });
        },

        // Init Sticky with Pin Scroll Trigger
        sticky: function() {
            const $selectors = $('.is-sticky');
            if (!$selectors.length) {
                return;
            }
            let isNumberString = (value) => {
                return value !== '' && !isNaN(value);
            } 
            let handler = ( $elements ) => {
                $elements.each(function() {
                    const $selector = $(this);
                    const settings = $selector.data('sticky-settings') ?? {};
                    const $parent = ( settings.trigger && settings.trigger !== '' ) ? $(settings.trigger) : $selector.parent();
                    const screen = settings.breakOn ?? 0;
                    if( breakOnScreen( screen ) ) {
                        return;
                    }
                    let getScrollDistance = () => {
                        if( isNumberString(settings.trigger) ) {
                            return parseFloat(settings.trigger);
                        }
                        const parentPaddingBottom = parseFloat($parent.css('padding-bottom')) || 0;
                        const selectorTop = $selector.offset().top;
                        const parentTop   = $parent.offset().top;
                        return $parent.outerHeight() 
                            - $selector.outerHeight() 
                            - (selectorTop - parentTop) - parentPaddingBottom;
                    };
                    let position = settings.position ?? 'top';
                    let offset = settings.offset ?? 30;
                    let triggerObj = {
                        trigger: $selector,   
                        start: `top top+=${offset}px`,     
                        end: () => `+=${getScrollDistance()}`,
                        pin: true,             
                        pinSpacing: settings.spacing ?? false,      
                        markers: false,         
                        invalidateOnRefresh: true,
                        scub: 2,
                    }
                    if( position == 'bottom' ) {
                        triggerObj.start = `bottom bottom-=${offset}`;
                        triggerObj.end = `bottom bottom-=${offset}`;
                        triggerObj.endTrigger = $parent
                    }
                    ScrollTrigger.create(triggerObj)
                });
            }
            if( $selectors.find('img').length ) {
                $($selectors).imagesLoaded().done( function( instance ) { 
                    handler( $selectors )
                })
                return;
            }
            handler( $selectors );
        },
        priceCardActive: function() {
            $('.price-table').on('mouseenter', '.grid-item', function() {
                const $currentItem = $(this);
                
                const classList = $currentItem.attr('class').split(/\s+/);
                
                const filterClass = classList.find(cls => 
                    cls !== 'grid-item' && 
                    cls !== 'filter-item' && 
                    cls !== 'elementor-repeater-item'
                );

                if (filterClass) {
                    const $container = $currentItem.closest('.grid-inner');
                    const $sameGroupItems = $container.find('.' + filterClass);
                    
                    $sameGroupItems.find('.price').removeClass('is-active');
                    $currentItem.find('.price').addClass('is-active');
                }
            });
        },

        // Translate Image Preview by Hover Button
        activePreviewShowCase: function() {
            const $selectors = $('.show-case[data-layout="2"]');

            if (!$selectors.length) {
                return;
            }

            $selectors.each(function() {
                const $selector = $(this);
                const $images = $selector.find('.show-case-image');
                const $buttons = $selector.find('.show-case-button');

                if (!$images.length) {
                    return;
                }

                $selector.on('mouseenter', '.show-case-button', function() {
                    const index = $buttons.index($(this));

                    $images.removeClass('is-active');
                    // $buttons.removeClass('is-active');

                    $images.eq(index).addClass('is-active');
                    // $(this).addClass('is-active');
                    
                });
            });
        }
    }

    /** Event */
    Mindverse.events  = {
        init: function() {
            this.setMainContentMinHeight()
            this.scrollTriggerRefresh();
            this.updateTranslateZTo3DFlip();
            this.initNiceSelect();
        },

        setMainContentMinHeight: function() {
            const headerHeight = $('#header-desktop:not(.header-transparent)').length ? $('#header-desktop:not(.header-transparent)').outerHeight(true) : 0;
            const footerHeight = $('.footer').length ? $('.footer').outerHeight(true) : 0;
            const heroSectionHeight = $('.hero-section').length ? $('.hero-section').outerHeight(true) : 0;
            let mainContentHeight = windowHeight - (headerHeight + footerHeight + heroSectionHeight);
            if(mainContentHeight > 0) {
                $('#main').css('min-height', `${mainContentHeight}px`)
            }
        },
        scrollTriggerRefresh: function() {
            $(document.body).on('scrolltrigger_refresh', function() {
                if (typeof ScrollTrigger !== 'undefined') {
                    // ScrollTrigger.getAll().forEach(t => t.refresh());
                    ScrollTrigger.refresh();
                }
            });
        },

        initSmoothScroll: function() {
            const $smoothWrapper = $( '#smooth-wrapper' );
            if( !$smoothWrapper.length ){
                return;
            }
            gsap.registerPlugin(ScrollTrigger, ScrollSmoother);
            ScrollSmoother.create({
                wrapper: "#smooth-wrapper", // This element might not exist or be incorrectly selected
                content: "#smooth-content",
                smooth: 1.5, // how long (in seconds) it takes to "catch up" to the native scroll position
                effects: true, // looks for data-speed and data-lag attributes on elements
                smoothTouch: 0.1, // much shorter smoothing time on touch devices (default is NO smoothing on touch devices)
            });
        },
        initNiceSelect: function () {
            if (typeof $.fn.niceSelect !== 'function') {
                return;
            }

            const $selectors = $('select:not(#billing_country):not(#billing_state):not(#shipping_state):not(#shipping_country)');

            if (!$selectors.length) {
                return;
            }

            $selectors.each(function () {
                const $select = $(this);

                if ($select.next('.nice-select').length) {
                    return;
                }

                $select.niceSelect();
            });
        },
        updateTranslateZTo3DFlip: function() {
            const $selectors = $('[data-hover="text-flip-3d"]');
            if(!$selectors.length) {
                return
            }
            $selectors.each(function() {
                let height = $(this).height();
                $(this).css({'--mv-translate-z': `${height / 2}px`})
            })
        },
        textAnimation: function () {
            if (typeof SplitText === 'undefined' || !hasGSAP()) {
                return;
            }

            const $selectors = $('[data-text-animation]');

            if (!$selectors.length) {
                return;
            }

            const runAnimation = function () {
                $selectors.each(function (_i, selector) {
                    const $selector = $(selector);

                    if ($selector.data('text-animation-initialized')) {
                        return;
                    }

                    const customSettings = getSafeObjectData($selector, 'text-animation');
                    const animation = customSettings.animation || '';
                    const splitType = customSettings.splitType || 'lines';
                    const staggerEach = customSettings.staggerEach ?? 0.015;
                    const staggerFrom = customSettings.staggerFrom || 'start';
                    const scrub = customSettings.scrub ?? false;
                    const toggleActionEnd = customSettings.toggleActions || 'none';

                    let rawSettings = {};
                    let splitSettings = {
                        autoSplit: true,
                        type: splitType,
                        linesClass: 'line++',
                        wordsClass: 'word++',
                        charsClass: 'char++',
                    };

                    if (splitType === 'chars') {
                        splitSettings.type = 'words, chars';
                    } else if (splitType === 'words') {
                        splitSettings.type = 'lines, words';
                    } else {
                        splitSettings.type = 'lines';
                    }

                    const defaultSettings = {
                        force3D: true,
                        duration: 1,
                        stagger: {
                            each: staggerEach,
                            from: staggerFrom,
                        },
                        scrollTrigger: {
                            trigger: $selector[0],
                            start: 'top 90%',
                            end: 'top 10%',
                            toggleActions: `play none none ${toggleActionEnd}`,
                            scrub: scrub,
                            markers: false,
                        },
                    };

                    const split = SplitText.create($selector[0], splitSettings);
                    const targets = split[splitType];

                    if (!targets || !targets.length) {
                        return;
                    }

                    gsap.set($selector, { visibility: 'visible' });

                    switch (animation) {
                        case 'fadeIn':
                            rawSettings.opacity = scrub ? 0.025 : 0;
                            break;

                        case 'fadeInUp':
                            rawSettings.opacity = 0;
                            rawSettings.y = 50;
                            break;

                        case 'fadeInRight':
                            rawSettings.opacity = 0;
                            rawSettings.x = 50;
                            break;

                        case 'fadeInDown':
                            rawSettings.opacity = 0;
                            rawSettings.y = -50;
                            break;

                        case 'fadeInLeft':
                            rawSettings.opacity = 0;
                            rawSettings.x = -50;
                            break;

                        case 'slideUp':
                            rawSettings.yPercent = 100;

                            if (splitType === 'chars') {
                                gsap.set(split.words, { overflow: 'hidden' });
                            } else if (splitType === 'words') {
                                gsap.set(split.lines, { overflow: 'hidden' });
                            } else {
                                const wrapSplit = SplitText.create($selector[0], {
                                    autoSplit: true,
                                    type: 'lines',
                                    linesClass: 'line-wrap++',
                                });
                                gsap.set(wrapSplit.lines, { overflow: 'hidden' });
                            }
                            break;

                        case 'slideDown':
                            rawSettings.yPercent = -100;

                            if (splitType === 'chars') {
                                gsap.set(split.words, { overflow: 'hidden' });
                            } else if (splitType === 'words') {
                                gsap.set(split.lines, { overflow: 'hidden' });
                            } else {
                                const wrapSplit = SplitText.create($selector[0], {
                                    autoSplit: true,
                                    type: 'lines',
                                    linesClass: 'line-wrap++',
                                });
                                gsap.set(wrapSplit.lines, { overflow: 'hidden' });
                            }
                            break;

                        case 'flyFlipX':
                            gsap.set($selector, { perspective: 800 });
                            rawSettings = {
                                opacity: 0.25,
                                rotationX: -105,
                                transformOrigin: 'top center -65',
                            };
                            break;

                        case 'flipX':
                            rawSettings.rotationX = 90;
                            break;

                        case 'flipY':
                            rawSettings.rotationY = -90;
                            break;

                        case 'fadeRotateInRight':
                            rawSettings = {
                                rotate: 10,
                                opacity: 0,
                                x: 50,
                            };
                            break;

                        default:
                            rawSettings = { ...customSettings };
                            break;
                    }

                    delete rawSettings.animation;
                    delete rawSettings.splitType;
                    delete rawSettings.staggerEach;
                    delete rawSettings.staggerFrom;
                    delete rawSettings.toggleActions;
                    delete rawSettings.scrub;

                    if (!rawSettings || typeof rawSettings !== 'object' || Object.keys(rawSettings).length === 0) {
                        return;
                    }

                    const settings = {
                        ...defaultSettings,
                        ...rawSettings,
                        scrollTrigger: {
                            ...defaultSettings.scrollTrigger,
                        },
                    };

                    gsap.from(targets, settings);
                    $selector.data('text-animation-initialized', true);
                });
            }
            if (document.fonts && document.fonts.ready) {
                document.fonts.ready.then(runAnimation);
            } else {
                runAnimation();
            }
        },
    }

    Mindverse.init = function() {
        Mindverse.library.init();
        Mindverse.navigation.init();
        Mindverse.events.init();
        Mindverse.interactions.init();
        $(document).ajaxComplete(function(event, xhr, settings){
            if (typeof elementorFrontend !== 'undefined') {
                elementorFrontend.init();
            }
            $(document.body).trigger('scrolltrigger_refresh');
        });
    };

    $( document ).ready(Mindverse.init);


    // Ultils
    window.breakOnScreen = function( screen ) {
        let screenWidth = 0;
        if (screen === 'widescreen') {
            screenWidth = 2400;
        } else if (screen === 'desktop') {
            screenWidth = 1920;
        } else if (screen === 'laptop') {
            screenWidth = 1400;
        } else if (screen === 'tablet_extra') {
            screenWidth = 1200;
        } else if (screen === 'tablet') {
            screenWidth = 992;
        } else if (screen === 'mobile_extra') {
            screenWidth = 768;
        } else if (screen === 'mobile') {
            screenWidth = 576;
        }
        return windowWidth < screenWidth;
    }

})(jQuery);