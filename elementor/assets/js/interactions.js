(function ($) {
    "use strict";

    function initializePriceTableFilter( $scope, $ ) {
        const $filterHeader = $scope.find('.price-table.filter .filter-header');
        if( !$filterHeader.length ) {
            return;
        }
        
        const gridFilter = ( filterVal ) => {
            filterVal += ', .all';
            const $grids = $scope.closest('.e-con.e-parent').find('.price-table.filter .grid .grid-inner'); 
            if (!$grids.length) {
                return;
            }
            $grids.each(function() {
                const $grid = $(this); 
                if ($grid.length) {
                    $grid.isotope({
                        itemSelector: '.grid-item',
                        layoutMode: 'fitRows',
                        transitionDuration: '0.5s',
                        resize: true,
                        filter: filterVal
                    });
                }
            });
        }
        gridFilter('*');
        
        const $buttons = $filterHeader.find('.filter-button');
        const $input = $filterHeader.find('.check-switch');

        $buttons.filter('.is-active').each(function() {
            const $button = $(this);
            const $wrapper = $button.closest('.price-table.filter');
            
            let filterVal = $button.data('filter') ?? '*';

            let isChecked = $buttons.index( $button ) === 1;
            if( $input.length ) { 
                $input.prop('checked', isChecked)
            }

            $wrapper.find('.filter-button').removeClass('is-active');
            $button.addClass('is-active');

            if (filterVal !== '*' && !filterVal.startsWith('.')) {
                filterVal = '.' + filterVal.trim();
            }
            gridFilter( filterVal )
        });

        $filterHeader.on('click', '.filter-button', function (e) {  
            e.preventDefault(); 
            const $button = $(this);
            const $wrapper = $button.closest('.price-table.filter');
            
            let filterVal = $button.data('filter') ?? '*';

            let isChecked = $buttons.index( $button ) === 1;
            if( $input.length ) { 
                $input.prop('checked', isChecked)
            }

            $wrapper.find('.filter-button').removeClass('is-active');
            $button.addClass('is-active');

            if (filterVal !== '*' && !filterVal.startsWith('.')) {
                filterVal = '.' + filterVal.trim();
            }
            gridFilter( filterVal )
            ScrollTrigger.refresh();

        })

        $input.on('change', function() {
            const buttonIndex = $(this).prop('checked') ? 1 : 0;
            const $button = $($buttons[buttonIndex]);
            $button.trigger('click')
        })
    }

    function hoverFillByTransformAnimation( $scope, $ ) {
        let $selectors = $scope.find('[data-hover="transition-fill-animation"], [data-hover="rotation-fill-animation"]');
        if( !$selectors.length ) {
            return
        };
        const directions = { 0: 'top', 1: 'right', 2: 'bottom', 3: 'left' };
        const getDirectionKey = (ev, $node) => {
            const rect = $node[0].getBoundingClientRect();
            const l = ev.clientX - rect.left;
            const t = ev.clientY - rect.top;
            const width = $node.outerWidth();
            const height = $node.outerHeight();
            const x = (l - (width / 2) * (width > height ? (height / width) : 1));
            const y = (t - (height / 2) * (height > width ? (width / height) : 1));
            return Math.round(Math.atan2(y, x) / 1.57079633 + 5) % 4;
        };

        const getHorizontalKey = (ev, $node) => {
            const offset = $node.offset();
            const width = $node.outerWidth();
            const l = ev.pageX - offset.left;
            const x = l - width / 2;
            return x < 0 ? 3 : 1;
        };

        const getVerticalKey = (ev, $node) => {
            const offset = $node.offset();
            const height = $node.outerHeight();
            const t = ev.pageY - offset.top; 
            const y = t - height / 2; 
            return y < 0 ? 0 : 2;
        };
        
        class Item {
            constructor( $selector ) {
                this.$selector = $selector;
                this.activeClass = ''; 
                if( !this.$selector.hasClass( 'pxl-onepage-active' ) ) {
                    this.$selector.on('mouseenter', (ev) => this.update(ev, 'in'));
                    this.$selector.on('mouseleave', (ev) => this.update(ev, 'out'));
                }
            }
            update(ev, prefix) {
                // if( this.$selector.hasClass('is-active') ) {
                //     return;
                // }
                let itemHover = this.$selector.find('.direction-item').first();
                
                if( !itemHover.length ) {
                    const $inner = this.$selector.find('.menu-link-inner');
                    itemHover = $('<span class="direction-item"></span>');
                    if(  $inner.length ) {
                        $inner.prepend(itemHover);
                    }else {
                        this.$selector.prepend(itemHover);
                    }
                }
                const effectType = this.$selector.is('[data-hover="rotation-fill-animation"]') ? 'rotation-fill' : 
                                   this.$selector.is('[data-hover="transition-fill-animation"]') ? 'transition-fill' : '';
                if (!effectType) return;
                let direction = this.$selector.data('hover_direction') || '';
                let directionClass = `${effectType}-${prefix}-${directions[getDirectionKey(ev, this.$selector)]}`;
                if(direction === 'horizontal') {
                    directionClass = `${effectType}-${prefix}-${directions[getHorizontalKey(ev, this.$selector)]}`
                }
                if(direction === 'vertical') {
                    directionClass = `${effectType}-${prefix}-${directions[getVerticalKey(ev, this.$selector)]}`
                }

                if (this.activeClass) {
                    this.$selector.removeClass(this.activeClass); 
                }
                this.activeClass = directionClass;
                this.$selector.addClass(this.activeClass); 
            }
        }

        $selectors.each(function () {
            new Item($(this));
        });
    }

    function hoverSpotlightFill( $scope, $ ) {
        let $selectors = $scope.find('[data-hover="spotlightFill"]');
        if(!$selectors.length) {
            return
        };
        const update = (e, isMouseenter) => {
            let item = $(e.currentTarget).find('.spotlight-item').first();
            const { left, top, width, height } = e.currentTarget.getBoundingClientRect();
            const mouseX = e.clientX - left;
            const mouseY = e.clientY - top;
            const distToCorners = [
                Math.hypot(mouseX, mouseY), 
                Math.hypot(mouseX - width, mouseY), 
                Math.hypot(mouseX, mouseY - height),
                Math.hypot(mouseX - width, mouseY - height) 
            ];
            const maxRadius = Math.max(...distToCorners);
    
            gsap.to(item, {
                x: mouseX,
                y: mouseY,
                ease: "none",
                duration: 0.3,
                scale: isMouseenter ? (maxRadius / 10) + 0.2 : 0, 
            });
        };
        $selectors.each(function(i, selector) {
            if( !$(selector).find('.spotlight-item').length ) {
                const item = $('<span class="spotlight-item"></span>');
                $(selector).prepend(item);
            }
            $(selector).on('mouseenter', (e) => update(e, true));
            $(selector).on('mouseleave', (e) => update(e, false));
        })
    }

    /**
     * Image Parallax
     */ 
    function hoverImageParallax( $scope, $ ) {
        const $selectors = $scope.find('img[data-hover=parallax]');
        if ( !$selectors.length ){
            return;
        };
        $selectors.each(function(i, selector) {
            let $image = $(selector);
            let $trigger = $image;
            let isTrigger = true;
            const customSettings = $image.data('parallax_settings') ?? {};
            const {
                trigger = '',
                intensity = 125,
                scale = 1.15
            } = customSettings;
            if( $(trigger).length ) {
                $trigger = $(trigger);
                isTrigger = false;
                $image.closest('.image').css('overflow', 'visible');
            } 
            $trigger.on({
                mousemove(e) {
                    const $box = (isTrigger) ? $(this).parent() : $(this);
                    const rect = $box[0].getBoundingClientRect();
                    const x = e.clientX - rect.left;
                    const y = e.clientY - rect.top;
                    const moveX = (x - rect.width / 2) * ( intensity / 1000 );
                    const moveY = (y - rect.height / 2) * ( intensity / 1000 );
                    gsap.to($image, {
                        x: moveX,
                        y: moveY,
                        scale: scale,
                        duration: 0.3,
                        ease: "none",
                    });
                },
                mouseleave() {
                    gsap.to($image, {
                        x: 0,
                        y: 0,
                        scale: 1,
                        duration: 0.3,
                        ease: "none",
                    });
                },
            });
        })
    }

    /**
     * Tilt  
     */ 
    function hoverTilt( $scope, $ ) {
        const $selectors = $scope.find('[data-hover="tilt"]');
        if( !$selectors.length ) {
            return;
        }
        $selectors.each(function(i, selector) {
            const $selector = $(selector);
            const $parent = $selector.parent();
            $parent.tilt({
                speed: 0,
                maxTilt: 5
            })
        })
    }

    /** 
     * Image Distortion Transition
     */ 
    function hoverImageDistortionTransition( $scope, $ ) {
        const $selectors = $scope.find('[data-hover="distortionTransition"]');
        if( !$selectors.length ) {
            return
        }
        $selectors.each(function(i, selector) {
            const $image = $(selector);
            const $box = $image.closest('.image');
            const imageSrc = $image.attr('src');
            const displacementImage = $image.data('displacement');
            $image.imagesLoaded().done( function( instance ) { 
                const imageWidth = $image.attr('width') ?? parseInt($image.width());
                const imageHeight = $image.attr('height') ?? parseInt($image.height());
                new hoverEffect({
                    parent: $box[0],
                    intensity: 0.3,
                    image1: imageSrc,
                    image2: imageSrc,
                    displacementImage: displacementImage,
                    imagesRatio: imageHeight/imageWidth,
                });
            })
        })
    }

    /**
     * Follow Cursor (GSAP)
     */
    function hoverFollowCursor( $scope, $ ) {
        const $selectors = $scope.find('[data-hover="followCursor"]');

        if ( !$selectors.length ) {
            return
        };

        $selectors.each(function ( i, selector ) {
            const $button = $(selector);
            const $parent = $button.closest('.play-video');

            if ( !$parent.length ) {
                return
            };

            let bounds = null;

            const measure = () => {
                const pr = $parent[0].getBoundingClientRect();
                const br = $button[0].getBoundingClientRect();

                const maxX = Math.max(0, (pr.width  - br.width)  / 2);
                const maxY = Math.max(0, (pr.height - br.height) / 2);

                bounds = {
                    pr,
                    maxX,
                    maxY,
                    clampX: gsap.utils.clamp(-maxX, maxX),
                    clampY: gsap.utils.clamp(-maxY, maxY),
                };
            };

            const onMouseMove = (e) => {
                if (!bounds) {
                    measure();
                }

                const pr = bounds.pr;
                const cx = pr.left + pr.width / 2;
                const cy = pr.top  + pr.height / 2;

                let dx = e.clientX - cx;
                let dy = e.clientY - cy;

                dx = bounds.clampX(dx);
                dy = bounds.clampY(dy);

                gsap.to( $button[0], {
                    x: dx, 
                    y: dy,
                    duration: 0.3,
                    delay: 0.05,
                    ease: "power1.out",
                    overwrite: "auto",
                });
            };

            const onMouseEnter = () => {
                measure(); 
                $parent.on("mousemove.followCursor", onMouseMove);
            };

            const onMouseLeave = () => {
                $parent.off("mousemove.followCursor", onMouseMove);
                gsap.to($button[0], {
                    x: 0,
                    y: 0,
                    duration: 0.3,
                    ease: "power1.out",
                    overwrite: true, 
                })
            };

            $parent.on("mouseenter.followCursor", onMouseEnter);
            $parent.on("mouseleave.followCursor", onMouseLeave);

            $(window).on("resize.followCursor", () => {
                bounds = null;
            });
        });
    }

    /**
     * Button Icon Reverse Position
     */
    function hoverButtonIconRerversePosition( $scope, $ ) {
        const $button = $scope.find('.button[data-hover="iconReversePosition"]');
        const $buttonIcon = $button.find('.button-icon:not(.clone)');
        const $buttonText = $button.find('.button-text');
        const $buttonIconClone = $button.find('.button-icon.clone');
        if( !$button.length || !$buttonIcon.length || !$buttonText ) {
            return;
        }
        const iconWidth = $buttonIcon.outerWidth() + 'px';
        const buttonGap = $button.css('gap');
        let moveDistance = `calc( ${iconWidth} + ${buttonGap} )`;
        const iconPositon = $button.css('flex-direction');
        if( iconPositon === 'row-reverse' ) {
            $buttonIconClone.css({
                right: $button.css('padding-right'),
                transformOrigin: 'right center',
            })
            moveDistance = `calc( -1 * ( ${iconWidth} + ${buttonGap} ) )`;
        }else {
            $buttonIconClone.css('left', $button.css('padding-left'));
        }
        $button.on('mouseenter', function() {
            $buttonIcon.css('transform', `translateX(${moveDistance})`);
            $buttonText.css('transform', `translateX(${moveDistance})`);
        }).on('mouseleave', function() {
            $buttonIcon.css('transform', 'translateX(0)');
            $buttonText.css('transform', 'translateX(0)');
        });
    }

    function hoverFlowmapDeformation( $scope, $ ) {
        $scope.imagesLoaded().done( function( instance ) {
            let $selector = $scope.find('[data-hover="flowmapDeformation"]');
            if( !$selector.length ) {
                return
            }
            const handler = (el) => {
                const elWidth =  $(el).parent('.image').outerWidth();
                const elHeight =  $(el).parent('.image').outerHeight();
                const trigger = $(el).data('hover_trigger') ?? '';
                const imgSize = [elWidth, elHeight];
                const vertex = `
                    attribute vec2 uv;
                    attribute vec2 position;
                    varying vec2 vUv;
                    void main() {
                            vUv = uv;
                            gl_Position = vec4(position, 0, 1);
                    }
                `;
                const fragment = `
                    precision highp float;
                    precision highp int;
                    uniform sampler2D tWater;
                    uniform sampler2D tFlow;
                    uniform float uTime;
                    varying vec2 vUv;
                    uniform vec4 res;
    
                    void main() {
                        // R and G values are velocity in the x and y direction
                        // B value is the velocity length
                        vec3 flow = texture2D(tFlow, vUv).rgb;
                        vec2 uv = .5 * gl_FragCoord.xy / res.xy ;
                        vec2 myUV = (uv - vec2(0.5))*res.zw + vec2(0.5);
                        myUV -= flow.xy * 0.25;
                        vec2 myUV2 = (uv - vec2(0.5))*res.zw + vec2(0.5);
                        myUV2 -= flow.xy * 0.15;
                        vec2 myUV3 = (uv - vec2(0.5))*res.zw + vec2(0.5);
                        myUV3 -= flow.xy * 0.05;
                        vec3 tex = texture2D(tWater, myUV).rgb;
                        vec3 tex2 = texture2D(tWater, myUV2).rgb;
                        vec3 tex3 = texture2D(tWater, myUV3).rgb;
                        gl_FragColor = vec4(tex.r, tex2.g, tex3.b, 1.0);
                    }
                `;
                const renderer = new ogl.Renderer({ dpr: 2 });
                const gl = renderer.gl;
                let imgUrl = null;
                if($(el).is('img')) {
                    $(el).after(gl.canvas);  
                    imgUrl = $(el).attr('src');  
                } else {
                    $(el).append(gl.canvas);  
                    imgUrl = $(el).attr('data-image-url') || null;
                }
                
                let aspect = 1;
                const mouse = new ogl.Vec2(-1);
                const velocity = new ogl.Vec2();
                function resize() {
                    const elRect = $(el).get(0).getBoundingClientRect();
                    const elWidth = elRect.width;
                    const elHeight = elRect.height;
                    let a1, a2;
                    var imageAspect = imgSize[1] / imgSize[0];
                    if (elHeight / elWidth < imageAspect) {
                        a1 = 1;
                        a2 = elHeight / elWidth / imageAspect;
                    } else {
                        a1 = (elWidth / elHeight) * imageAspect;
                        a2 = 1;
                    }
                    mesh.program.uniforms.res.value = new ogl.Vec4(
                        elWidth,
                        elHeight,
                        a1,
                        a2
                    );
                    renderer.setSize(elWidth, elHeight);
                    aspect = elWidth / elHeight;
                }
                const flowmap = new ogl.Flowmap(gl);
                const geometry = new ogl.Geometry(gl, {
                    position: {
                        size: 2,
                        data: new Float32Array([-1, -1, 3, -1, -1, 3])
                    },
                    uv: { size: 2, data: new Float32Array([0, 0, 2, 0, 0, 2]) }
                });
                const texture = new ogl.Texture(gl, {
                    minFilter: gl.LINEAR,
                    magFilter: gl.LINEAR
                });
                const img = new Image();
                img.onload = () => (texture.image = img);
                img.crossOrigin = "Anonymous";
                img.src = imgUrl;
            
                let a1, a2;
                var imageAspect = imgSize[1] / imgSize[0];
                if (elHeight / elWidth < imageAspect) {
                    a1 = 1;
                    a2 = elHeight / elWidth / imageAspect;
                } else {
                    a1 = (elWidth / elHeight) * imageAspect;
                    a2 = 1;
                }
            
                const program = new ogl.Program(gl, {
                    vertex,
                    fragment,
                    uniforms: {
                    uTime: { value: 0 },
                    tWater: { value: texture },
                    res: {
                        value: new ogl.Vec4(elWidth, elHeight, a1, a2)
                    },
                    img: { value: new ogl.Vec2(elWidth, elHeight) },
                        tFlow: flowmap.uniform
                    }
                });
                const mesh = new ogl.Mesh(gl, { geometry, program });
        
                window.addEventListener("resize", resize, false);
                resize();
                const isTouchCapable = "ontouchstart" in window;
                if (isTouchCapable) {
                    if( $(trigger).length ) {
                        $(trigger).on("touchstart", updateMouse);
                        $(trigger).on("touchmove", updateMouse);
                    }else {
                        $(el).on("touchstart", updateMouse);
                        $(el).on("touchmove", updateMouse);
                    }
                } else {
                    if( $(trigger).length ) {
                        $(trigger).on("mousemove", updateMouse);
                    }else {
                        $(el).on("mousemove", updateMouse);
                    }
                }
                  
                let lastTime;
                const lastMouse = new ogl.Vec2();
    
                function updateMouse(e) {
                    e.preventDefault();
                    let mouseX, mouseY;
                
                    if (e.changedTouches && e.changedTouches.length) { 
                        e.x = e.changedTouches[0].pageX;
                        e.y = e.changedTouches[0].pageY;
                    }
                
                    if (e.x === undefined) {
                        e.x = e.pageX;
                        e.y = e.pageY;
                    }
                
                    const rect = $(el).get(0).getBoundingClientRect();  
                
                    mouseX = e.pageX - (rect.left + window.scrollX);
                    mouseY = e.pageY - (rect.top + window.scrollY);
                
                    mouse.set(mouseX / rect.width, 1.0 - (mouseY / rect.height));
                
                    if (!lastTime) {
                        lastTime = performance.now();
                        lastMouse.set(e.x, e.y);
                    }
                    const deltaX = e.x - lastMouse.x;
                    const deltaY = e.y - lastMouse.y;
                    lastMouse.set(e.x, e.y);
                    let time = performance.now();
                    let delta = Math.max(10.4, time - lastTime);
                    lastTime = time;
                    velocity.x = deltaX / delta;
                    velocity.y = deltaY / delta;
                    velocity.needsUpdate = true;
                }
                
                
                requestAnimationFrame(update);
                function update(t) {
                    requestAnimationFrame(update);
                    if (!velocity.needsUpdate) {
                        mouse.set(-1);
                        velocity.set(0);
                    }
                    velocity.needsUpdate = false;
                    flowmap.aspect = aspect;
                    flowmap.mouse.copy(mouse);
                    flowmap.velocity.lerp(velocity, velocity.len ? 0.15 : 0.1);
                    flowmap.update();
                    program.uniforms.uTime.value = t * 0.01;
                    renderer.render({ scene: mesh });
                }
            }
    
            handler( $selector[0] )
        })
    }

    function hoverFlowmapDeformation2( $scope, $ ) {
        $scope.imagesLoaded().done( function( instance ) {
            let $selector = $scope.find('[data-hover="flowmapDeformation2"]');
            if( !$selector.length ) {
                return
            }
            const handler = (el) => {
                const elWidth = $(el).attr('width') ?? $(el).outerWidth();
                const elHeight = $(el).attr('height') ?? $(el).outerHeight();
                const imgSize = [elWidth, elHeight];
                const trigger = $(el).data('hover_trigger') ?? '';
                const vertex = `
                    attribute vec2 uv;
                    attribute vec2 position;
                    varying vec2 vUv;
                    void main() {
                            vUv = uv;
                            gl_Position = vec4(position, 0, 1);
                    }
                `;
                const fragment = `
                    precision highp float;
                    precision highp int;
                    uniform sampler2D tWater;
                    uniform sampler2D tFlow;
                    uniform float uTime;
                    varying vec2 vUv;
                    uniform vec4 res;
    
                    void main() {
                        // R and G values are velocity in the x and y direction
                        // B value is the velocity length
                        vec3 flow = texture2D(tFlow, vUv).rgb;
                        vec2 uv = .5 * gl_FragCoord.xy / res.xy ;
                        vec2 myUV = (uv - vec2(0.5))*res.zw + vec2(0.5);
                        myUV -= flow.xy * (0.15 * 0.7);
                        vec2 myUV2 = (uv - vec2(0.5))*res.zw + vec2(0.5);
                        myUV2 -= flow.xy * (0.125 * 0.7);
                        vec2 myUV3 = (uv - vec2(0.5))*res.zw + vec2(0.5);
                        myUV3 -= flow.xy * (0.10 * 0.7);
                        vec3 tex = texture2D(tWater, myUV).rgb;
                        vec3 tex2 = texture2D(tWater, myUV2).rgb;
                        vec3 tex3 = texture2D(tWater, myUV3).rgb;
                        gl_FragColor = vec4(tex.r, tex2.g, tex3.b, 1.0);
                    }
                `;
    
                const renderer = new ogl.Renderer({ dpr: 2 });
                const gl = renderer.gl;
                let imgUrl = null;
                if($(el).is('img')) {
                    $(el).after(gl.canvas);  
                    imgUrl = $(el).attr('src');  
                } else {
                    $(el).append(gl.canvas);  
                    imgUrl = $(el).attr('data-image-url') || null;
                }
    
    
                // Variable inputs to control flowmap
                let aspect = 1;
                const mouse = new ogl.Vec2(-1);
                const velocity = new ogl.Vec2();
                function resize() {
                    const elRect = $(el).get(0).getBoundingClientRect();
                    const elWidth = elRect.width;
                    const elHeight = elRect.height;
                    let a1, a2;
                    var imageAspect = imgSize[1] / imgSize[0];
                    if (elHeight / elWidth < imageAspect) {
                        a1 = 1;
                        a2 = elHeight / elWidth / imageAspect;
                    } else {
                        a1 = (elWidth / elHeight) * imageAspect;
                        a2 = 1;
                    }
                    mesh.program.uniforms.res.value = new ogl.Vec4(
                        elWidth,
                        elHeight,
                        a1,
                        a2
                    );
                    renderer.setSize(elWidth, elHeight);
                    aspect = elWidth / elHeight;
                }
                const flowmap = new ogl.Flowmap(gl, {
                    falloff: 1.0, // size of the stamp, percentage of the size
                    alpha: 0.3, // opacity of the stamp
                    dissipation: 0.94 // affects the speed that the stamp fades. Closer to 1 is slower
                });
                    // Triangle that includes -1 to 1 range for 'position', and 0 to 1 range for 'uv'.
                const geometry = new ogl.Geometry(gl, {
                    position: {
                        size: 2,
                        data: new Float32Array([-1, -1, 3, -1, -1, 3])
                    },
                    uv: { size: 2, data: new Float32Array([0, 0, 2, 0, 0, 2]) }
                });
                const texture = new ogl.Texture(gl, {
                    minFilter: gl.LINEAR,
                    magFilter: gl.LINEAR
                });
                const img = new Image();
                img.onload = () => (texture.image = img);
                img.crossOrigin = "Anonymous";
                img.src = imgUrl;
              
                let a1, a2;
                var imageAspect = imgSize[1] / imgSize[0];
                if (elHeight / elWidth < imageAspect) {
                    a1 = 1;
                    a2 = elHeight / elWidth / imageAspect;
                } else {
                    a1 = (elWidth / elHeight) * imageAspect;
                    a2 = 1;
                }
              
                const program = new ogl.Program(gl, {
                    vertex,
                    fragment,
                    uniforms: {
                        uTime: { value: 0 },
                        tWater: { value: texture },
                        res: {
                            value: new ogl.Vec4(elWidth, elHeight, a1, a2)
                        },
                        img: { value: new ogl.Vec2(elWidth, elHeight) },
                        // Note that the uniform is applied without using an object and value property
                        // This is because the class alternates this texture between two render targets
                        // and updates the value property after each render.
                        tFlow: flowmap.uniform
                    }
                });
                const mesh = new ogl.Mesh(gl, { geometry, program });
              
                window.addEventListener("resize", resize, false);
                resize();
              
                // Create handlers to get mouse position and velocity
                const isTouchCapable = "ontouchstart" in window;

                if (isTouchCapable) {
                    if( $(trigger).length ) {
                        $(trigger).on("touchstart", updateMouse);
                        $(trigger).on("touchmove", updateMouse);
                    }else {
                        $(el).on("touchstart", updateMouse);
                        $(el).on("touchmove", updateMouse);
                    }
                } else {
                    if( $(trigger).length ) {
                        $(trigger).on("mousemove", updateMouse);
                    }else {
                        $(el).on("mousemove", updateMouse);
                    }
                }

                let lastTime;
                const lastMouse = new ogl.Vec2();
                function updateMouse(e) {
                    e.preventDefault();
                    let mouseX, mouseY;
                
                    if (e.changedTouches && e.changedTouches.length) { 
                        e.x = e.changedTouches[0].pageX;
                        e.y = e.changedTouches[0].pageY;
                    }
                
                    if (e.x === undefined) {
                        e.x = e.pageX;
                        e.y = e.pageY;
                    }
                
                    const rect = $(el).get(0).getBoundingClientRect();  
                
                    mouseX = e.pageX - (rect.left + window.scrollX);
                    mouseY = e.pageY - (rect.top + window.scrollY);
                    mouse.set(mouseX / rect.width, 1.0 - (mouseY / rect.height));
                
                    if (!lastTime) {
                        lastTime = performance.now();
                        lastMouse.set(e.x, e.y);
                    }
                    const deltaX = e.x - lastMouse.x;
                    const deltaY = e.y - lastMouse.y;
                    lastMouse.set(e.x, e.y);
                    let time = performance.now();
                    // Avoid dividing by 0
                    let delta = Math.max(10.4, time - lastTime);
                    lastTime = time;
                    velocity.x = deltaX / delta;
                    velocity.y = deltaY / delta;
                    // Flag update to prevent hanging velocity values when not moving
                    velocity.needsUpdate = true;
                }
                requestAnimationFrame(update);
                function update(t) {
                    requestAnimationFrame(update);
                    // Reset velocity when mouse not moving
                    if (!velocity.needsUpdate) {
                        mouse.set(-1);
                        velocity.set(0);
                    }
                    velocity.needsUpdate = false;
                    // Update flowmap inputs
                    flowmap.aspect = aspect;
                    flowmap.mouse.copy(mouse);
                    // Ease velocity input, slower when fading out
                    flowmap.velocity.lerp(velocity, velocity.len ? 0.15 : 0.1);
                    flowmap.update();
                    program.uniforms.uTime.value = t * 0.01;
                    renderer.render({ scene: mesh });
                }
            }
    
            handler( $selector[0] )
        })

    }


    $(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction('frontend/element_ready/mindverse_price_table.default', initializePriceTableFilter );
        elementorFrontend.hooks.addAction('frontend/element_ready/mindverse_price_table.default', hoverFillByTransformAnimation );

        elementorFrontend.hooks.addAction('frontend/element_ready/mindverse_navigation_menu.default', hoverFillByTransformAnimation );
        
        elementorFrontend.hooks.addAction('frontend/element_ready/mindverse_tabs.default', hoverFillByTransformAnimation );
        // Image
        elementorFrontend.hooks.addAction('frontend/element_ready/mindverse_image.default', hoverImageParallax );
        elementorFrontend.hooks.addAction('frontend/element_ready/mindverse_image.default', hoverTilt );
        elementorFrontend.hooks.addAction('frontend/element_ready/mindverse_image.default', hoverImageDistortionTransition );
        elementorFrontend.hooks.addAction('frontend/element_ready/mindverse_image.default', hoverFlowmapDeformation );
        elementorFrontend.hooks.addAction('frontend/element_ready/mindverse_image.default', hoverFlowmapDeformation2 );

        // Image Carousel
        elementorFrontend.hooks.addAction('frontend/element_ready/mindverse_image_carousel.default', hoverImageParallax );
        elementorFrontend.hooks.addAction('frontend/element_ready/mindverse_image_carousel.default', hoverTilt );
        elementorFrontend.hooks.addAction('frontend/element_ready/mindverse_image_carousel.default', hoverImageDistortionTransition );
        // Team
        elementorFrontend.hooks.addAction('frontend/element_ready/mindverse_team_grid.default', hoverImageParallax );
        elementorFrontend.hooks.addAction('frontend/element_ready/mindverse_team_grid.default', hoverImageDistortionTransition );
        // Post
        elementorFrontend.hooks.addAction('frontend/element_ready/mindverse_post_grid.default', hoverImageParallax );
        elementorFrontend.hooks.addAction('frontend/element_ready/mindverse_post_grid.default', hoverImageDistortionTransition );
        // Button
        elementorFrontend.hooks.addAction('frontend/element_ready/mindverse_button.default', hoverSpotlightFill );
        elementorFrontend.hooks.addAction('frontend/element_ready/mindverse_button.default', hoverButtonIconRerversePosition );
        // Play Video
        elementorFrontend.hooks.addAction('frontend/element_ready/mindverse_play_video.default', hoverSpotlightFill );
        elementorFrontend.hooks.addAction('frontend/element_ready/mindverse_play_video.default', hoverFollowCursor );
        // Show Case
        elementorFrontend.hooks.addAction('frontend/element_ready/mindverse_show_case.default', hoverTilt );

        // Categories Grid
        elementorFrontend.hooks.addAction('frontend/element_ready/mindverse_categories_grid.default', hoverImageParallax );
        elementorFrontend.hooks.addAction('frontend/element_ready/mindverse_categories_grid.default', hoverImageDistortionTransition );
    });
})(jQuery);