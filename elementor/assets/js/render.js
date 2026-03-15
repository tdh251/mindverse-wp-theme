( function( $ ) {
    "use strict";


    function renderDef() {
        if( $('[fill="url(#paint0_linear_2277_2881)"]').length ) {
            $(document.body).append(`
                <svg class="svg-render">
                    <defs>
                        <linearGradient id="paint0_linear_2277_2881" x1="0" y1="5.99968" x2="16" y2="5.99968" gradientUnits="userSpaceOnUse">
                        <stop stop-color="#EA580C"/>
                        <stop offset="0.5" stop-color="#F97316"/>
                        <stop offset="1" stop-color="#F59E0B"/>
                        </linearGradient>
                    </defs>
                </svg>`
            )
        }
        if( $('[fill="url(#paint0_linear_2292_2420)"]').length ) {
            $(document.body).append(`
                <svg class="svg-render">
                    <defs>
                        <linearGradient id="paint0_linear_2292_2420" x1="14.9822" y1="-6.92762" x2="-4.4107" y2="-2.42996" gradientUnits="userSpaceOnUse">
                            <stop offset="0.0028" stop-color="#01E5E5"/>
                            <stop offset="1" stop-color="#008787"/>
                        </linearGradient>
                    </defs>
                </svg>`
            )
        }
        if( $('[fill="url(#paint0_linear_2326_1751)"]').length ) {
            $(document.body).append(`
                <svg class="svg-render">
                    <defs>
                        <linearGradient id="paint0_linear_2326_1751" x1="11.3779" y1="-178.117" x2="-0.65296" y2="-178.075" gradientUnits="userSpaceOnUse">
                        <stop offset="0.1362" stop-color="#434AFF"/>
                        <stop offset="0.6388" stop-color="#47B2FF"/>
                        <stop offset="0.9161" stop-color="#39EDAC"/>
                        </linearGradient>
                    </defs>
                </svg>`
            )
            
        }
        if( $('[fill="url(#paint0_linear_2326_1751)"]').length ) {
            $(document.body).append(`
                <svg class="svg-render">
                    <defs>
                        <linearGradient id="paint0_linear_2326_1751" x1="11.3779" y1="-178.117" x2="-0.65296" y2="-178.075" gradientUnits="userSpaceOnUse">
                        <stop offset="0.1362" stop-color="#434AFF"/>
                        <stop offset="0.6388" stop-color="#47B2FF"/>
                        <stop offset="0.9161" stop-color="#39EDAC"/>
                        </linearGradient>
                    </defs>
                </svg>`
            )
        }
        if( $('[fill="url(#paint0_linear_2333_5957)"]').length ) {
            $(document.body).append(`
                <svg class="svg-render">
                    <defs>
                        <linearGradient id="paint0_linear_2333_5957" x1="0" y1="11" x2="22" y2="11" gradientUnits="userSpaceOnUse">
                        <stop stop-color="#C96CFF"/>
                        <stop offset="0.5" stop-color="#5F21F2"/>
                        <stop offset="1" stop-color="#2C8FFF"/>
                        </linearGradient>
                    </defs>
                </svg>`
            )
        }
        if( $('[fill="url(#mask0_4309_2005)"]').length ) {
            $(document.body).append(`
                <svg class="svg-render">
                    <mask id="mask0_4309_2005" style="mask-type:luminance" maskUnits="userSpaceOnUse" x="0" y="-1" width="26" height="27">
                </svg>`
            )
        }

        if( $('[fill="url(#paint0_linear_2367_23810)"]').length ) {
            $(document.body).append(`
                <svg class="svg-render">
                    <linearGradient id="paint0_linear_2367_23810" x1="21" y1="11.8634" x2="-9.39034e-08" y2="11.8634" gradientUnits="userSpaceOnUse">
                        <stop stop-color="#851ADC"/>
                        <stop offset="0.693333" stop-color="#DF2398"/>
                        <stop offset="1" stop-color="#FF8FC2"/>
                    </linearGradient>
                </svg>`
            )
        }

        if( $('[fill="url(#paint0_linear_2333_2183)"]').length ) {
            $(document.body).append(`
                <svg class="svg-render">
                    <linearGradient id="paint0_linear_2333_2183" x1="0" y1="4.47427" x2="12" y2="4.47427" gradientUnits="userSpaceOnUse">
                        <stop stop-color="#C96CFF"/>
                        <stop offset="0.5" stop-color="#5F21F2"/>
                        <stop offset="1" stop-color="#2C8FFF"/>
                    </linearGradient>
                </svg>`
            )
        }
    }
        

    $( window ).on( 'elementor/frontend/init', function() {
        renderDef();
        if ( typeof elementor !== 'undefined' ) {
            elementor.hooks.addAction( 'panel/open_editor/widget', renderDef );
            elementor.on( 'preview:loaded', renderDef );
        }
    });

} )( jQuery );