( function( $ ) {
    "use strict";

    function initCounter( $scope ) {
        let $els = $scope.find('[data-effect="counter"]');
        if (!$els.length) {
            return;
        }
        $els.each(function () {
            let $this = $(this);
            let delimiter = $this.attr('data-delimiter') || '';

            let endingNumber = String($this.data('ending_number') || '1').trim();
            let startingNumber = parseInt($this.data('starting_number')) || 0;

            if (!endingNumber) {
                console.warn('Counter: Missing data-target-number for element:', this);
                return;
            }

            let numberOnly = endingNumber.replace(/[^0-9.,]/g, '');
            let normalized = numberOnly;

            if (numberOnly.lastIndexOf(',') > numberOnly.lastIndexOf('.')) {
                normalized = numberOnly.replace(/\./g, '').replace(/,/g, '.');
            } else {
                normalized = numberOnly.replace(/,/g, '');
            }

            let targetValue = parseFloat(normalized);
            let decimalPlace = countDecimals(targetValue);

            if (isNaN(targetValue)) {
                console.warn('Counter: Invalid number format in data-target-number:', endingNumber);
                return;
            }
            let snapValue = Math.pow(10, -decimalPlace);
            gsap.fromTo(
                this,
                { innerText: startingNumber },
                {
                    innerText: targetValue,
                    duration: 3,
                    scrollTrigger: {
                        trigger: $this[0],
                        markers: false,
                        start: 'center bottom',
                        end: 'bottom bottom',
                        toggleActions: 'play none play reset'
                    },
                    snap: { innerText: snapValue }, 
                    onUpdate: function () {
                        let current = parseFloat($this[0].innerText);
                        if (!isNaN(current)) {
                            $this[0].innerText = formatNumber(current, decimalPlace, delimiter);
                        }
                    }
                }
            );
        });

        function countDecimals(val) {
            if (Math.floor(val) === val) return 0;
            let parts = val.toString().split('.');
            return parts[1] ? parts[1].length : 0;
        }

        function formatNumber(value, decimals, delimiter) {
            if (delimiter === '') return parseFloat(value).toFixed(decimals);
            let locale = 'en-US'; 
            let options = {
                minimumFractionDigits: decimals,
                maximumFractionDigits: decimals,
                useGrouping: true
            };
            if (delimiter === '.') {
                locale = 'de-DE'; 
            } else if (delimiter === ' ') {
                locale = 'fr-FR'; 
            }
            return new Intl.NumberFormat(locale, options).format(value);
        }
    }
    $( window ).on( 'elementor/frontend/init', function() {
        elementorFrontend.hooks.addAction('frontend/element_ready/mindverse_counter.default', initCounter );
        elementorFrontend.hooks.addAction('frontend/element_ready/mindverse_counter_box.default', initCounter );
        elementorFrontend.hooks.addAction('frontend/element_ready/mindverse_progress_bar.default', initCounter );
    });
} )( jQuery );