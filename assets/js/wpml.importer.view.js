
$ = $ || jQuery;

wpml = wpml || {};

	wpml.importer = {};
	
		wpml.importer.view = wpml_import_view = {

			timer: undefined,
			delay: 500,

			select: '#the-list input[type=checkbox]',
			select_all: '#the-list-header #cb-select-all-1, #the-list-header #cb-select-all-2',
		};

			/**
			 * Init Events
			 */
			wpml.importer.view.init = function() {

				$( wpml_import_view.select_all ).unbind( 'click' ).on( 'click', function( e ) {
					wpml.reinit_checkboxes_all( e, $( this ) );
				});

				$( wpml_import_view.select ).unbind( 'click' ).on( 'click', function( e ) {
					wpml.reinit_checkboxes( e, $( this ) );
				});
			};

			/**
			 * Reload the movie table. Used when new movies are imported or
			 * when browsing through the table.
			 */
			wpml.importer.view.reload = function( data, list ) {

				if ( 'queued' == list ) {
					var _selector = '#wpml_import_queue',
					    _rows = '.wp-list-table',
					    _data = {
						action: 'wpml_fetch_queued_movies',
						wpml_fetch_queued_movies_nonce: $( '#wpml_fetch_queued_movies_nonce' ).val(),
					};
				}
				else {
					var _selector = '#wpml_imported',
					    _rows = '.wp-list-table tbody',
					    _data = {
						action: 'wpml_fetch_imported_movies',
						wpml_fetch_imported_movies_nonce: $( '#wpml_fetch_imported_movies_nonce' ).val(),
					};
				}

				var data = $.extend( _data, data );

				wpml._get({
					data: data,
					error: function( response ) {
						wpml_state.clear();
						$.each( response.responseJSON.errors, function() {
							wpml_state.set( this, 'error' );
						});
					},
					success: function( response ) {

						if ( response.data.rows.length )
							$(_rows, _selector).html( response.data.rows );
						if ( response.data.column_headers.length )
							$( 'thead tr, tfoot tr', _selector ).html( response.data.column_headers );
						if ( response.data.pagination.bottom.length )
							$( '.tablenav.top .tablenav-pages', _selector ).html( $(response.data.pagination.top).html() );
						if ( response.data.pagination.top.length )
							$( '.tablenav.bottom .tablenav-pages', _selector ).html( $(response.data.pagination.bottom).html() );

						if ( 'queued' == list )
							wpml_import_view.update_count( 'import_queue', response.data.total_items, response.i18n.total_items_i18n );
						else
							wpml_import_view.update_count( 'imported', response.data.total_items, response.i18n.total_items_i18n );
					}
				});
			};

			/**
			 * Navigate through the table pages using navigation arrow links
			 * 
			 * @param    object    Link HTML Object
			 */
			wpml.importer.view.navigate = function( link ) {
				var query = link.search.substring( 1 );
				var data = {
					paged: wpml.http_query_var( query, 'paged' ) || '1',
					order: wpml.http_query_var( query, 'order' ) || 'asc',
					orderby: wpml.http_query_var( query, 'orderby' ) || 'title'
				};
				wpml_import_view.reload( data );
			};

			/**
			 * Navigate through the table pages using pagination input
			 */
			wpml.importer.view.paginate = function() {
				var data = {
					paged: parseInt( $( 'input[name=paged]' ).val() ) || '1',
					order: $( 'input[name=order]' ).val() || 'asc',
					orderby: $( 'input[name=orderby]' ).val() || 'title'
				};

				window.clearTimeout( wpml_import_view.timer );
				wpml_import_view.timer = window.setTimeout( function() {
					wpml_import_view.reload( data );
				}, wpml_import_view.delay );
			};

			/**
			 * Update the menu badges containing movies counts.
			 * 
			 * @param    string    Which menu, queued or imported?
			 * @param    int       Increment or decrement?
			 */
			wpml.importer.view.update_count = function( wot, i, i_i18n ) {
				
				var wot = ( 'import_queue' == wot ? wot : 'imported' ),
				    i = ( i >= 0 ? i : '0' ),
				    $span = $( '#_wpml_' + wot + ' span' );

				$span.text( '' + i );

				if ( 'import_queue' == wot ) {
					$( '.displaying-num', wpml_queue.queued_list ).text( i_i18n );
					$( '#_queued_left', wpml_queue.queued_list ).text( i );
				}
			};

			wpml.importer.view.toggle_button = function() {

				if ( $( wpml_import_view.select + ':checked' ).length != $( wpml_import_view.select ).length )
					$( wpml_import_view.select_all ).prop( 'checked', false );
				else
					$( wpml_import_view.select_all ).prop( 'checked', true );
			};

			wpml.importer.view.toggle_inputs = function() {

				if ( ! $( wpml_import_view.select_all ).prop('checked') )
					$( wpml_import_view.select ).prop( 'checked', false );
				else
					$( wpml_import_view.select ).prop( 'checked', true );
			};