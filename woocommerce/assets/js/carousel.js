;(function ($) {
    
    function initVerticalCarousel($carousel) {
        const $viewport = $carousel.find('.vc-viewport');
        const $track = $carousel.find('.vc-track');
        const $items = $track.find('.vc-item');

        if (!$carousel.length || !$viewport.length || !$track.length || !$items.length) {
            return;
        }

        const $carouselSibling = $carousel.siblings('.carousel');
        const $swiper = $carouselSibling.find('.swiper');

        const viewportEl = $viewport[0];
        const trackEl = $track[0];

        const visibleItems = 3;
        const gap = 18;
        const duration = 220;
        const thresholdRatio = 0.15;
        const clickThreshold = 6;

        const totalItems = $items.length;
        const maxIndex = Math.max(0, totalItems - visibleItems);

        let currentIndex = 0;
        let currentTranslate = 0;
        let startY = 0;
        let startTranslate = 0;
        let isDragging = false;
        let isAnimating = false;
        let rafId = null;

        let itemHeight = 0;
        let step = 0;
        let maxTranslate = 0;

        let pointerStartTarget = null;
        let hasMoved = false;

        let resizeObserver = null;

        function clamp(val, min, max) {
            return Math.max(min, Math.min(max, val));
        }

        function render(y) {
            trackEl.style.transform = `translate3d(0, ${y}px, 0)`;
        }

        function queueRender(y) {
            if (rafId) {
                cancelAnimationFrame(rafId);
            }

            rafId = requestAnimationFrame(function () {
                render(y);
                rafId = null;
            });
        }

        function recalc() {
            const viewportHeight = viewportEl.clientHeight;

            if (!viewportHeight || viewportHeight <= 0) {
                return false;
            }

            const totalGap = gap * (visibleItems - 1);
            const nextItemHeight = Math.floor((viewportHeight - totalGap) / visibleItems);

            if (nextItemHeight <= 0) {
                return false;
            }

            itemHeight = nextItemHeight;
            step = itemHeight + gap;
            maxTranslate = -(step * maxIndex);

            $items.css('height', itemHeight + 'px');

            currentTranslate = clamp(-(currentIndex * step), maxTranslate, 0);
            render(currentTranslate);

            return true;
        }

        function recalcWhenReady(retries = 20) {
            let count = 0;

            function run() {
                const done = recalc();
                count++;

                if (!done && count < retries) {
                    requestAnimationFrame(run);
                }
            }

            requestAnimationFrame(run);
        }

        function stopAnimation() {
            isAnimating = false;
        }

        function animateTo(target) {
            target = clamp(target, maxTranslate, 0);

            const from = currentTranslate;
            const to = target;

            if (from === to) {
                currentTranslate = to;
                render(currentTranslate);
                return;
            }

            stopAnimation();
            isAnimating = true;

            const startTime = performance.now();

            function easeOutCubic(t) {
                return 1 - Math.pow(1 - t, 3);
            }

            function tick(now) {
                if (!isAnimating) {
                    return;
                }

                const elapsed = now - startTime;
                const progress = Math.min(elapsed / duration, 1);
                const eased = easeOutCubic(progress);

                currentTranslate = from + (to - from) * eased;
                render(currentTranslate);

                if (progress < 1) {
                    requestAnimationFrame(tick);
                } else {
                    currentTranslate = to;
                    render(currentTranslate);
                    isAnimating = false;
                }
            }

            requestAnimationFrame(tick);
        }

        function setTranslate(val, animate) {
            const next = clamp(val, maxTranslate, 0);

            if (animate) {
                animateTo(next);
            } else {
                stopAnimation();
                currentTranslate = next;
                queueRender(currentTranslate);
            }
        }

        function handleItemClick(target) {
            const item = target.closest('.vc-item');
            if (!item) {
                return;
            }

            const index = $(item).index();
            if ($swiper.length && $swiper[0].swiper) {
                $swiper[0].swiper.slideTo(index);
            }
        }

        function dragStart(e) {
            if (isDragging || totalItems <= visibleItems) {
                return;
            }

            isDragging = true;
            hasMoved = false;
            pointerStartTarget = e.target;

            stopAnimation();

            startY = e.clientY;
            startTranslate = currentTranslate;

            $viewport.addClass('is-dragging');

            if (viewportEl.setPointerCapture) {
                viewportEl.setPointerCapture(e.pointerId);
            }
        }

        function dragMove(e) {
            if (!isDragging) {
                return;
            }

            const delta = e.clientY - startY;

            if (Math.abs(delta) > clickThreshold) {
                hasMoved = true;
            }

            const next = startTranslate + delta;
            currentTranslate = clamp(next, maxTranslate, 0);
            queueRender(currentTranslate);

            if (hasMoved) {
                e.preventDefault();
            }
        }

        function dragEnd() {
            if (!isDragging) {
                return;
            }

            const moved = currentTranslate - startTranslate;
            const threshold = itemHeight * thresholdRatio;

            if (!hasMoved || Math.abs(moved) < clickThreshold) {
                isDragging = false;
                $viewport.removeClass('is-dragging');
                setTranslate(-(currentIndex * step), true);

                if (pointerStartTarget) {
                    handleItemClick(pointerStartTarget);
                }

                pointerStartTarget = null;
                return;
            }

            if (moved < -threshold && currentIndex < maxIndex) {
                currentIndex += 1;
            } else if (moved > threshold && currentIndex > 0) {
                currentIndex -= 1;
            }

            isDragging = false;
            $viewport.removeClass('is-dragging');
            pointerStartTarget = null;

            setTranslate(-(currentIndex * step), true);
        }

        viewportEl.addEventListener('pointerdown', dragStart);
        viewportEl.addEventListener('pointermove', dragMove, { passive: false });
        viewportEl.addEventListener('pointerup', dragEnd);
        viewportEl.addEventListener('pointercancel', dragEnd);
        viewportEl.addEventListener('lostpointercapture', dragEnd);

        $carousel.on('dragstart selectstart', function (e) {
            e.preventDefault();
        });

        recalcWhenReady();

        $(window).on('load', function () {
            recalcWhenReady();
        });

        // resize window
        $(window).on('resize', function () {
            recalcWhenReady();
        });

        if (window.ResizeObserver) {
            resizeObserver = new ResizeObserver(function () {
                recalcWhenReady();
            });

            resizeObserver.observe(viewportEl);
        }

        if ($swiper.length && $swiper[0].swiper) {
            $swiper[0].swiper.on('init resize update', function () {
                recalcWhenReady();
            });
        }
    }

    $(document).ready(function () {
        const $carousel = $('#verticalCarousel');

        if (!$carousel.length) {
            return;
        }

        $carousel.imagesLoaded().done(function () {
            initVerticalCarousel($carousel);
        });
    });
})(jQuery);