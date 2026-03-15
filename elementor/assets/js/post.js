( function( $ ) {
    "use strict";

    const ajaxHandler = ( paramObject ) => {
        const {
            page = 1, 
            settings = {}, 
            layout = 1,
            wrapper = '',
            action = '',
            catSlug = ''
        } = paramObject;

        let data = {
            action: 'load_posts', 
            page: page,
            settings: settings,
            layout: layout,
            _ajax_nonce: MindverseAjax.nonce
        }

        if( action === 'filter' ) {
            data.cat_slug = catSlug;
        }

        $.ajax({
            url: MindverseAjax.ajaxurl, 
            type: 'POST',
            data: data,
            success: function(response) {
                if( response.data ) {
                    const gridHtml = response.data.grid_html;
                    const paginationHtml = response.data.pagination_html;
                    if( wrapper.length ) {
                        if( action === 'load_more' ) {
                            wrapper.find('.grid-inner').append(gridHtml);
                            return;
                        }
                        wrapper.find('.grid-inner').html(gridHtml);
                        wrapper.find('.grid-pagination').replaceWith(paginationHtml)
                    }
                }
            },
            complete: function() {
                if( wrapper.length ) {
                    wrapper.removeClass('is-loading');
                }
            }
        });
    }

    function ajaxPagination() {        
        $(document.body).off('click', '.grid-pagination.ajax a').on('click', '.grid-pagination.ajax a', function(e) {
            e.preventDefault();
            const $btn = $(this);
            const page = $btn.attr('href').replace('#', '');
            const $parent = $btn.closest('.grid');
            const settings = $parent.data('settings');
            const layout = $parent.data('layout');
            $parent.addClass('is-loading');
            $('html, body').animate({
                scrollTop: $parent.offset().top - 100
            }, 1000);
            ajaxHandler({
                page : page,
                settings : settings,
                layout : layout,
                wrapper: $parent,
                action: 'pagination',
            })
        });
    }

    function ajaxLoadMore() {
        $(document.body).off('click', '.grid-load-more.ajax .button-load-more').on('click', '.grid-load-more.ajax .button-load-more', function(e) {
            e.preventDefault();
            const $btn = $(this);   
            const $parent = $btn.closest('.grid');
            const currentPage = parseInt( $btn.data('current-page') ) || 1;
            const nextPage = currentPage + 1;
            const settings = $parent.data('settings');
            const layout = $parent.data('layout');
            $parent.addClass('is-loading');
            ajaxHandler({
                page : nextPage,
                settings : settings,
                layout : layout,
                wrapper: $parent,
                action: 'load_more',
            });
            $parent.data('current-page', nextPage);
        });
    }

    function ajaxFilter() {
        $(document.body).off('click', '.post-filter-button .filter-button').on('click', '.post-filter-button .filter-button', function(e) {
            e.preventDefault();
            const $btn = $(this);
            const trigger = $btn.closest('.post-filter-button').data('trigger');
            const $trigger = $(trigger);
            if( ! $trigger.length ) {
                return;
            }
            const filterValue = $btn.data('filter');
            const cleanValue = filterValue.replace('.', '');
            const settings = $trigger.data('settings');
            const layout = $trigger.data('layout');

            const postType = settings[0].post_type || 'post';
            const taxonomy = (postType === 'post') ? 'category' : postType + '_category';

            if (cleanValue !== '' && cleanValue !== '*') {
                settings[0].tax_query = [
                    {
                        'taxonomy': taxonomy,
                        'field': 'slug',
                        'terms': [cleanValue], 
                        'operator': 'IN'
                    }
                ];
            } else {
                delete settings[0].tax_query;
            }

            $trigger.addClass('is-loading');
            $('html, body').animate({
                scrollTop: $trigger.offset().top - 100
            }, 1000);

            $btn.addClass('is-active').siblings().removeClass('is-active');

            ajaxHandler({
                settings : settings,
                layout : layout,
                wrapper: $trigger,
                action: 'filter',
                catSlug: cleanValue
            })
        });
    }

    
    $( window ).on( 'elementor/frontend/init', function() {
        ajaxPagination();
        ajaxLoadMore();
        ajaxFilter();
    });
    

} )( jQuery );