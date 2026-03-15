(function ($) {
    "use strict";

    function svgEffect1($scope) {
        const $svgs = $scope.find('.svg-effect-1, .svg-effect-2');
        if (!$svgs.length) return;
        $svgs.each(function () {
            const $svg = $(this);
            const duration = $svg.data('animation_duration') || 5;
            const $linePath = $svg.find('.line');
            const $moveHighlight = $svg.find('.moving-highlight');

            if (!$linePath.length || !$moveHighlight.length) return;

            gsap.to($moveHighlight[0], {
                duration: duration,
                repeat: -1,
                ease: "none",
                motionPath: {
                    path: $linePath[0],
                    align: $linePath[0],
                    autoRotate: 180,
                    alignOrigin: [0.5, 0.5]
                }
            });
        });
    }

    function svgEffect5( $scope ) {
        const $svgs = $scope.find('.svg-effect-5');
        if ( !$svgs.length ) {
            return;
        };

        function getClosestProgressOnPath(pathEl, x, y) {
            if (!pathEl || !pathEl.getTotalLength) return 0;

            const totalLen = pathEl.getTotalLength();
            const samples = 200;
            let best = {len: 0, dist2: Infinity};

            for (let i = 0; i <= samples; i++) {
                const frac = i / samples;
                const pt = pathEl.getPointAtLength(frac * totalLen);
                const dx = pt.x - x;
                const dy = pt.y - y;
                const d2 = dx * dx + dy * dy;
                if (d2 < best.dist2) {
                    best = {len: frac * totalLen, dist2: d2};
                }
            }

            let refineRange = totalLen / samples; 
            for (let iter = 0; iter < 6; iter++) { 
                const start = Math.max(0, best.len - refineRange);
                const end = Math.min(totalLen, best.len + refineRange);
                const steps = 20;
                for (let s = 0; s <= steps; s++) {
                    const len = start + (s / steps) * (end - start);
                    const pt = pathEl.getPointAtLength(len);
                    const dx = pt.x - x;
                    const dy = pt.y - y;
                    const d2 = dx * dx + dy * dy;
                    if (d2 < best.dist2) {
                        best = {len: len, dist2: d2};
                    }
                }
                refineRange = refineRange / 4; 
            }

            return Math.max(0, Math.min(1, best.len / totalLen));
        }

        $svgs.each(function () {
            const $svg = $(this);
            
            let widgetId = $svg.parent('.elementor-element').data('id');
            
            const $path1 = $svg.find('#path_1_' + widgetId);
            const $path2 = $svg.find('#path_2_' + widgetId);
            const $path4 = $svg.find('#path_4_' + widgetId);

            const $dot1 = $svg.find('#dot_1_' + widgetId);
            const $dot2 = $svg.find('#dot_2_' + widgetId);
            const $dot3 = $svg.find('#dot_3_' + widgetId);
            const $dot4 = $svg.find('#dot_4_' + widgetId);
            const $dot5 = $svg.find('#dot_5_' + widgetId);
            const $dot6 = $svg.find('#dot_6_' + widgetId);
            const $dot7 = $svg.find('#dot_7_' + widgetId);

            if (!$path1.length || !$path2.length || !$path4.length) {
                console.warn('GSAP: Không tìm thấy SVG paths cho widget ' + widgetId);
                return;
            }

            // gsap.registerPlugin(MotionPathPlugin);

            const masterTimeline = gsap.timeline();

            function createDotTween(dotEl, pathEl, duration, delayOffset = 0, reverse = false) {
                if (!dotEl || !pathEl) return;

                const bbox = dotEl.getBBox ? dotEl.getBBox() : null;
                let cx = null, cy = null;
                if (dotEl.tagName.toLowerCase() === 'circle') {
                    cx = parseFloat(dotEl.getAttribute('cx')) || (bbox ? bbox.x + bbox.width / 2 : 0);
                    cy = parseFloat(dotEl.getAttribute('cy')) || (bbox ? bbox.y + bbox.height / 2 : 0);
                } else {
                    // fallback: lấy center bbox
                    if (bbox) {
                        cx = bbox.x + bbox.width / 2;
                        cy = bbox.y + bbox.height / 2;
                    } else {
                        cx = 0; cy = 0;
                    }
                }

                const startProgress = getClosestProgressOnPath(pathEl, cx, cy);


                let motionStart = startProgress;
                let motionEnd = startProgress + 1;

                // if (reverse) {
                //     motionEnd = startProgress - 1;
                // }

                gsap.set(dotEl, { 
                    x: 0,
                    y: 0
                });

                const tween = gsap.to(dotEl, {
                    motionPath: {
                        path: pathEl,
                        align: pathEl,
                        alignOrigin: [0.5, 0.5],
                        start: motionStart,
                        end: motionEnd
                    },
                    duration: duration,
                    ease: "none",
                    repeat: -1,
                    delay: delayOffset
                });

                return tween;
            }

            const path1_duration = 15; 
            const path1_dots = [$dot1[0], $dot2[0], $dot3[0]];
            path1_dots.forEach((dot, index) => {
                if (!dot) return;
                const delay = (path1_duration / path1_dots.length) * index;
                const reverse = false; 
                const tween = createDotTween(dot, $path1[0], path1_duration, 0, reverse);
                if (tween) masterTimeline.add(tween, 0);
            });

            const path4_duration = 15;
            const path4_dots = [$dot4[0], $dot5[0], $dot6[0]];
            path4_dots.forEach((dot, index) => {
                if (!dot) return;
                const delay = (path4_duration / path4_dots.length) * index;
                const reverse = (index % 2 === 1);
                const tween = createDotTween(dot, $path4[0], path4_duration, 0, reverse);
                if (tween) masterTimeline.add(tween, 0);
            });

            if ($dot7.length) {
                const tween7 = createDotTween($dot7[0], $path2[0], 10, 0, false);
                if (tween7) masterTimeline.add(tween7, 0);
            }

        });
    }

    function typingHandler( $scope ) {
        let $selectors = $scope.find('[data-effect="typing"]');
        if ( !$selectors.length ){
            return
        }
        $selectors.each(function () {
            let $el = $(this);
            let textData = $el.data('text');
            if (!textData) return;

            let textArray = textData.split(',').map(t => t.trim());
            let typingDelay = 150;
            let erasingDelay = 80;
            let newTextDelay = 1500;
            let textArrayIndex = 0;
            $el.text(textArray[textArrayIndex]);
            
            let charIndex = textArray[textArrayIndex].length;
            function type() {
                if (charIndex < textArray[textArrayIndex].length) {
                    $el.text($el.text() + textArray[textArrayIndex].charAt(charIndex));
                    charIndex++;
                    setTimeout(type, typingDelay);
                } else {
                    setTimeout(erase, newTextDelay);
                }
            }

            function erase() {
                if (charIndex > 0) {
                    $el.text(textArray[textArrayIndex].substring(0, charIndex - 1));
                    charIndex--;
                    setTimeout(erase, erasingDelay);
                } else {
                    textArrayIndex++;
                    if (textArrayIndex >= textArray.length) textArrayIndex = 0;
                    setTimeout(type, typingDelay + 300);
                }
            }
            setTimeout(type, 500);
        });
    }

    function typingHandler2( $scope ) {
        let $selectors = $scope.find('[data-effect="typing-2"]');
        if ( !$selectors.length ) {
            return;
        }

        $selectors.each(function() {
            const $el = $(this);
            const textData = $el.data("text");
            if (!textData) {
                return;
            }

            const words = textData.split(",").map(w => w.trim());
            const $word = $el.find('.dynamic-word')

            function getTextWidth(text, refEl) {
                const $temp = $("<span>").css({
                    position: "absolute",
                    visibility: "hidden",
                    whiteSpace: "nowrap",
                    font: refEl.css("font")
                }).text(text).appendTo("body");
                const width = $temp.outerWidth();
                $temp.remove();
                return width;
            }

            let index = 0;
            const initWidth = getTextWidth(words[0], $word) + 16;
            $el.css({
                width: initWidth + "px",
            });

            function changeWord() {
                gsap.to($el[0], {
                    width: 4,
                    duration: 1,
                    ease: "power2.out",
                    transformOrigin: "left center",
                    onComplete: () => {
                        index = (index + 1) % words.length;
                        $word.text(words[index]);
                        requestAnimationFrame(() => {
                            const newWidth = getTextWidth(words[index], $word) + 16;
                            gsap.fromTo($el[0],
                                { width: 4 },
                                {
                                    width: newWidth,
                                    duration: 1,
                                    ease: "power2.out",
                                    transformOrigin: "left center",
                                }
                            );
                        });
                    }
                });
            }

            function loop() {
                changeWord();
                gsap.delayedCall(3.5, loop);
            }
            setTimeout(loop, 3500)
        });
    }

    function particles( $scope, $ ) {
        const $els = $scope.find('.particles');
        if (!$els.length) {
            return;
        }
        const getParticleConfig = (settings) => {
            return {
                "particles": {
                    "number": {
                        "value": settings.number || 30,
                        "density": {
                            "enable": true,
                            "value_area": 800 
                        }
                    },
                    "color": {
                        "value": settings.color || '#ffffff'
                    },
                    "shape": {
                        "type": settings.shape.type || 'circle', 
                        "stroke": {
                            "width": 0,
                            "color": "#000000"
                        },
                        "polygon": {
                            "nb_sides": 5 
                        },
                        "image": {
                            "src": settings.shape.image.src || '',
                            "width": parseInt( settings.shape.image.width ) || 50,
                            "height": parseInt( settings.shape.image.height ) || 50
                        }
                    },
                    "opacity": {
                        "value": 1,
                        "random": true,
                        "anim": {
                            "enable": true,
                            "speed": 1,
                            "opacity_min": 0,
                            "sync": false
                        }
                    },
                    "size": {
                        "value": settings.size || 3, 
                        "random": true,
                        "anim": {
                            "enable": false,
                            "speed": 4,
                            "size_min": 0.3,
                            "sync": false
                        }
                    },
                    "line_linked": {
                        "enable": false
                    },
                    "move": {
                        "enable": true,
                        "speed": 1.5,
                        "direction": settings.dir ?? 'none',
                        "random": true,
                        "straight": false,
                        "out_mode": "out",
                        "bounce": false
                    }
                },
                "interactivity": {
                    "detect_on": "canvas",
                    "events": {
                        "onhover": {
                            "enable": false
                        },
                        "onclick": {
                            "enable": false
                        },
                        "resize": true
                    }
                },
                "retina_detect": true
            };
        }

        $els.each(function () {
            const $this = $(this);
            const id = $this.attr('id');
            const settings = $this.data('settings') || {};
            
            if (typeof particlesJS !== 'undefined') {
                particlesJS(id, getParticleConfig(settings));
            } else {
                console.error('particles.js library not loaded.');
            }
        });
    }

    function imageRandomTransition( $scope, $ ) {
        setTimeout(() => {
            const $wrappers = $scope.find('[data-effect="random-transition"]')
            if( !$wrappers.length ) {
                return;
            }
    
            const allDirections = [
                { x: "100%", y: "0%" },  
                { x: "-100%", y: "0%" },  
                { x: "0%", y: "100%" },   
                { x: "0%", y: "-100%" } 
            ]
    
            $wrappers.each(function () {  
                const $wrapper = $(this);
                const $imgs = $wrapper.find('.image-random-transition');
                if ( !$imgs.length ) {
                    return;
                };
                let directionBag = [];
                const getUniqueDirection = () => {
                    if (directionBag.length === 0) {
                        directionBag = gsap.utils.shuffle([...allDirections]);
                    }
                    return directionBag.pop();
                };
                const tl = gsap.timeline({ repeat: -1 });
                $imgs.each(function(index, img) {
                    const startPos = getUniqueDirection(); 
                    const endPos = getUniqueDirection();
                    if( index !== 0 ) {
                    }
                    gsap.set(img, { 
                        x: startPos.x, 
                        y: startPos.y, 
                    })
                    tl.fromTo(img, 
                        { 
                            x: startPos.x, 
                            y: startPos.y, 
                            autoAlpha: 0 
                        },
                        { 
                            duration: 1.5, 
                            x: "0%", 
                            y: "0%", 
                            autoAlpha: 1, 
                            ease: "power2.out" 
                        }
                    )
                    .to(img, {
                        duration: 1.5, 
                        x: "0%", 
                        y: '0%',
                    }) 
                    .to(img, {
                        duration: 1.5,
                        x: endPos.x,
                        y: endPos.y,
                        autoAlpha: 0,
                        ease: "power2.in",
                    });
                });
            })
        }, 2000)
    }

    $(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction('frontend/element_ready/mindverse_svg_effects.default', function ($scope) {
            svgEffect1( $scope );
            svgEffect5( $scope );
        });
        elementorFrontend.hooks.addAction('frontend/element_ready/mindverse_heading.default', function ($scope) {
            typingHandler($scope);  
            typingHandler2($scope);
        });
        elementorFrontend.hooks.addAction('frontend/element_ready/mindverse_text_edit.default', function ($scope) {
            typingHandler($scope);  
            typingHandler2($scope);
        });
        elementorFrontend.hooks.addAction('frontend/element_ready/mindverse_particles.default', particles);
        elementorFrontend.hooks.addAction('frontend/element_ready/mindverse_image.default', imageRandomTransition);
    });

})(jQuery);