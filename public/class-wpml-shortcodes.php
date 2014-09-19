<?php
/**
 * WPMovieLibrary Shortcodes Class extension.
 *
 * @package   WPMovieLibrary
 * @author    Charlie MERLAND <charlie@caercam.org>
 * @license   GPL-3.0
 * @link      http://www.caercam.org/
 * @copyright 2014 Charlie MERLAND
 */

if ( ! class_exists( 'WPML_Shortcodes' ) ) :

	class WPML_Shortcodes extends WPML_Module {

		/**
		 * Shortcodes
		 * 
		 * @since    1.1
		 * @var      array
		 */
		protected $shortcodes;

		/**
		 * Constructor
		 *
		 * @since    1.1
		 */
		public function __construct() {

			$this->init();
		}

		/**
		 * Initializes variables
		 *
		 * @since    1.1
		 */
		public function init() {

			$this->shortcodes = WPML_Settings::get_available_shortcodes();

			$this->register_shortcodes();
		}

		/**
		 * Register all shortcodes
		 * 
		 * Shortcodes can have their own callback or handle aliases.
		 *
		 * @since    1.1
		 */
		private function register_shortcodes() {

			if ( ! is_array( $this->shortcodes ) || empty( $this->shortcodes ) )
				return false;

			foreach ( $this->shortcodes as $slug => $shortcode ) {

				$callback = array( __CLASS__, 'default_shortcode' );

				if ( ! is_null( $shortcode['callback'] ) && method_exists( __CLASS__, $shortcode['callback'] ) )
					$callback = array( __CLASS__, $shortcode['callback'] );
				else if ( method_exists( __CLASS__, "{$slug}_shortcode" ) )
					$callback = array( __CLASS__, "{$slug}_shortcode" );

				if ( ! is_null( $shortcode['aliases'] ) )
					foreach ( $shortcode['aliases'] as $alias )
						add_shortcode( $alias, $callback );

				add_shortcode( $slug, $callback );
			}
		}

		/**
		 * Default shortcodes' callback method
		 *
		 * @since    1.1
		 * 
		 * @param    array     Shortcode attributes
		 * @param    string    Shortcode content
		 * 
		 * @return   string    Shortcode display
		 */
		public static function default_shortcode( $atts = array(), $content = null ) {

			return $content;
		}

		/**
		 * Movies shortcode. Display a list of movies with various sorting
		 * and display options.
		 *
		 * @since    1.1
		 * 
		 * @param    array     Shortcode attributes
		 * @param    string    Shortcode content
		 * 
		 * @return   string    Shortcode display
		 */
		public static function movies_shortcode( $atts = array(), $content = null ) {

			$default_fields = WPML_Settings::get_supported_movie_meta();
			$atts = self::filter_shortcode_atts( 'movies', $atts );

			// Caching
			$name = apply_filters( 'wpml_cache_name', 'movies_shortcode', $atts );
			$content = WPML_Cache::output( $name, function() use ( $atts, $content ) {

				extract( $atts );

				$query = array(
					'post_type=movie',
					'post_status=publish',
					'posts_per_page=' . $count
				);
	
				if ( ! is_null( $order ) )
					$query[] = 'order=' . $order;
	
				if ( ! is_null( $orderby ) ) {
					if ( 'rating' == $orderby ) {
						$query[] = 'orderby=meta_value_num';
						$query[] = 'meta_key=_wpml_movie_rating';
					}
					else {
						$query[] = 'orderby=' . $orderby;
					}
				}
	
				if ( ! is_null( $collection ) )
					$query[] = 'collection=' . $collection;
				elseif ( ! is_null( $genre ) )
					$query[] = 'genre=' . $genre;
				elseif ( ! is_null( $actor ) )
					$query[] = 'actor=' . $actor;
	
				$query = implode( '&', $query );
				$query = new WP_Query( $query );
	
				$movies = WPML_Shortcodes::prepare_movies( $query, $atts );
				$attributes = array( 'movies' => $movies );
	
				$content = WPMovieLibrary::render_template( 'shortcodes/movies.php', $attributes, $require = 'always' );

				return $content;

			}, $echo = false );

			return $content;
		}

		/**
		 * Movie shortcode. Display a single movie with various display
		 * options.
		 *
		 * @since    1.1
		 * 
		 * @param    array     Shortcode attributes
		 * @param    string    Shortcode content
		 * 
		 * @return   string    Shortcode display
		 */
		public static function movie_shortcode( $atts = array(), $content = null ) {

			$atts = self::filter_shortcode_atts( 'movie', $atts );

			$movie_id = WPML_Shortcodes::find_movie_id( $atts['id'], $atts['title'] );
			if ( is_null( $movie_id ) )
				return $content;

			$atts['movie_id'] = $movie_id;

			// Caching
			$name = apply_filters( 'wpml_cache_name', 'movie_shortcode', $atts );
			$content = WPML_Cache::output( $name, function() use ( $atts, $content ) {

				extract( $atts );

				if ( ! is_null( $id ) )
					$select = 'p=' . $id;
				else if ( ! is_null( $title ) )
					$select = 'name=' . sanitize_title_with_dashes( remove_accents( $title ) );

				$query = 'post_type=movie&post_status=publish&' . $select;
				$query = new WP_Query( $query );

				$movies = WPML_Shortcodes::prepare_movies( $query, $atts );

				$attributes = array( 'movies' => $movies );

				$content = WPMovieLibrary::render_template( 'shortcodes/movies.php', $attributes, $require = 'always' );

				return $content;

			}, $echo = false );

			return $content;
		}

		/**
		 * Movie Meta shortcode. Display various movie metas with or 
		 * without label. This shortcode supports aliases.
		 *
		 * @since    1.1
		 * 
		 * @param    array     Shortcode attributes
		 * @param    string    Shortcode content
		 * @param    string    Shortcode tag name
		 * 
		 * @return   string    Shortcode display
		 */
		public static function movie_meta_shortcode( $atts = array(), $content = null, $tag = null ) {

			// Is this an alias?
			if ( ! is_null( $tag ) && "{$tag}_shortcode" != __FUNCTION__ ) {
				$tag = apply_filters( 'wpml_filter_movie_meta_aliases', $tag );
				$atts['key'] = str_replace( 'movie_', '', $tag );
			}

			$atts = self::filter_shortcode_atts( 'movie_meta', $atts );

			$movie_id = WPML_Shortcodes::find_movie_id( $atts['id'], $atts['title'] );
			if ( is_null( $movie_id ) )
				return $content;

			$atts['movie_id'] = $movie_id;

			// Caching
			$name = apply_filters( 'wpml_cache_name', 'movie_meta_shortcode', $atts );
			$content = WPML_Cache::output( $name, function() use ( $atts, $content ) {

				extract( $atts );

				$meta = wpml_get_movie_meta( $movie_id, $key );
				$meta = apply_filters( "wpml_format_movie_$key", $meta );
				$meta = apply_filters( "wpml_format_movie_field", $meta );

				$view = 'shortcodes/metadata.php';
				$attributes = array( 'key' => $key, 'meta' => $meta );
				if ( $label ) {
					$_meta = WPML_Settings::get_supported_movie_meta();
					$attributes['title'] = __( $_meta[ $key ]['title'], 'wpmovielibrary' );
					$view = 'shortcodes/metadata-label.php';
				}

				$content = WPMovieLibrary::render_template( $view, $attributes, $require = 'always' );

				return $content;

			}, $echo = false );

			return $content;
		}

		/**
		 * Movie Runtime shortcode. This shortcode supports aliases.
		 *
		 * @since    1.2
		 * 
		 * @param    array     Shortcode attributes
		 * @param    string    Shortcode content
		 * @param    string    Shortcode tag name
		 * 
		 * @return   string    Shortcode display
		 */
		public static function movie_release_date_shortcode( $atts = array(), $content = null, $tag = null ) {

			// Is this an alias?
			if ( ! is_null( $tag ) && "{$tag}_shortcode" != __FUNCTION__ )
				$tag = apply_filters( 'wpml_filter_movie_meta_aliases', $tag );

			$atts = self::filter_shortcode_atts( 'movie_release_date', $atts );

			$movie_id = WPML_Shortcodes::find_movie_id( $atts['id'], $atts['title'] );
			if ( is_null( $movie_id ) )
				return $content;

			$atts['movie_id'] = $movie_id;

			// Caching
			$name = apply_filters( 'wpml_cache_name', 'movie_release_date_shortcode', $atts );
			$content = WPML_Cache::output( $name, function() use ( $atts, $content ) {

				extract( $atts );

				$release_date = wpml_get_movie_meta( $movie_id, 'release_date' );
				$release_date = apply_filters( "wpml_format_movie_release_date", $release_date, $format );

				$view = 'shortcodes/metadata.php';
				$attributes = array( 'meta' => $release_date );
				if ( $label ) {
					$attributes['title'] = __( 'Release Date', 'wpmovielibrary' );
					$view = 'shortcodes/metadata-label.php';
				}

				$content = WPMovieLibrary::render_template( $view, $attributes, $require = 'always' );

				return $content;

			}, $echo = false );

			return $content;
		}

		/**
		 * Movie Runtime shortcode. This shortcode does not support aliases.
		 *
		 * @since    1.2
		 * 
		 * @param    array     Shortcode attributes
		 * @param    string    Shortcode content
		 * 
		 * @return   string    Shortcode display
		 */
		public static function movie_runtime_shortcode( $atts = array(), $content = null ) {

			$atts = self::filter_shortcode_atts( 'movie_runtime', $atts );

			$movie_id = WPML_Shortcodes::find_movie_id( $atts['id'], $atts['title'] );
			if ( is_null( $movie_id ) )
				return $content;

			$atts['movie_id'] = $movie_id;

			// Caching
			$name = apply_filters( 'wpml_cache_name', 'movie_runtime_shortcode', $atts );
			$content = WPML_Cache::output( $name, function() use ( $atts, $content ) {

				extract( $atts );

				$runtime = wpml_get_movie_meta( $movie_id, 'runtime' );
				$runtime = apply_filters( "wpml_format_movie_runtime", $runtime, $format );

				$view = 'shortcodes/metadata.php';
				$attributes = array( 'meta' => $runtime );
				if ( $label ) {
					$attributes['title'] = __( 'Runtime', 'wpmovielibrary' );
					$view = 'shortcodes/metadata-label.php';
				}

				$content = WPMovieLibrary::render_template( $view, $attributes, $require = 'always' );

				return $content;

			}, $echo = false );

			return $content;
		}

		/**
		 * Movie Actors shortcode. This shortcode supports aliases.
		 *
		 * @since    1.1
		 * 
		 * @param    array     Shortcode attributes
		 * @param    string    Shortcode content
		 * @param    string    Shortcode tag name
		 * 
		 * @return   string    Shortcode display
		 */
		public static function movie_actors_shortcode( $atts = array(), $content = null, $tag = null ) {

			// Is this an alias?
			if ( ! is_null( $tag ) && "{$tag}_shortcode" != __FUNCTION__ )
				$atts['key'] = str_replace( 'movie_', '', $tag );

			$atts = self::filter_shortcode_atts( 'movie_actors', $atts );

			$movie_id = WPML_Shortcodes::find_movie_id( $atts['id'], $atts['title'] );
			if ( is_null( $movie_id ) )
				return $content;

			$atts['movie_id'] = $movie_id;

			// Caching
			$name = apply_filters( 'wpml_cache_name', 'movie_actors_shortcode', $atts );
			$content = WPML_Cache::output( $name, function() use ( $atts, $content ) {

				extract( $atts );

				$actors = wpml_get_movie_meta( $movie_id, 'cast' );
				$actors = apply_filters( "wpml_format_movie_actors", $actors );

				if ( ! is_null( $count ) ) {
					$actors = explode( ', ', $actors );
					$actors = array_splice( $actors, 0, $count );
					$actors = implode( ', ', $actors );
				}

				$view = 'shortcodes/actors.php';
				$attributes = array( 'actors' => $actors );
				if ( $label ) {
					$attributes['title'] = __( 'Actors', 'wpmovielibrary' );
					$view = 'shortcodes/actors-label.php';
				}

				$content = WPMovieLibrary::render_template( $view, $attributes, $require = 'always' );

				return $content;

			}, $echo = false );

			return $content;
		}

		/**
		 * Movie Genres shortcode.
		 *
		 * @since    1.1
		 * 
		 * @param    array     Shortcode attributes
		 * @param    string    Shortcode content
		 * 
		 * @return   string    Shortcode display
		 */
		public static function movie_genres_shortcode( $atts = array(), $content = null ) {

			$atts = self::filter_shortcode_atts( 'movie_genres', $atts );

			$movie_id = WPML_Shortcodes::find_movie_id( $atts['id'], $atts['title'] );
			if ( is_null( $movie_id ) )
				return $content;

			$atts['movie_id'] = $movie_id;

			// Caching
			$name = apply_filters( 'wpml_cache_name', 'movie_genres_shortcode', $atts );
			$content = WPML_Cache::output( $name, function() use ( $atts, $content ) {

				extract( $atts );

				$genres = wpml_get_movie_meta( $movie_id, 'genres' );
				$genres = apply_filters( "wpml_format_movie_genres", $genres, $movie_id );

				if ( ! is_null( $count ) ) {
					$genres = explode( ', ', $genres );
					$genres = array_splice( $genres, 0, $count );
					$genres = implode( ', ', $genres );
				}

				$view = 'shortcodes/genres.php';
				$attributes = array( 'genres' => $genres );
				if ( $label ) {
					$attributes['title'] = __( 'Genres', 'wpmovielibrary' );
					$view = 'shortcodes/genres-label.php';
				}

				$content = WPMovieLibrary::render_template( $view, $attributes, $require = 'always' );

				return $content;

			}, $echo = false );

			return $content;
		}

		/**
		 * Movie Poster shortcode.
		 *
		 * @since    1.1
		 * 
		 * @param    array     Shortcode attributes
		 * @param    string    Shortcode content
		 * 
		 * @return   string    Shortcode display
		 */
		public static function movie_poster_shortcode( $atts = array(), $content = null ) {

			$atts = self::filter_shortcode_atts( 'movie_poster', $atts );

			$movie_id = WPML_Shortcodes::find_movie_id( $atts['id'], $atts['title'] );
			if ( is_null( $movie_id ) )
				return $content;

			$atts['movie_id'] = $movie_id;

			// Caching
			$name = apply_filters( 'wpml_cache_name', 'movie_posters_shortcode', $atts );
			$content = WPML_Cache::output( $name, function() use ( $atts, $content ) {

				extract( $atts );

				if ( ! has_post_thumbnail( $movie_id ) )
					return $content;

				$poster = array(
					'thumbnail' => wp_get_attachment_image_src( get_post_thumbnail_id( $movie_id ), $size ),
					'full'      => wp_get_attachment_image_src( get_post_thumbnail_id( $movie_id ), 'full' )
				);
				$attributes = array( 'size' => $size, 'movie_id' => $movie_id, 'poster' => $poster );

				$content = WPMovieLibrary::render_template( 'shortcodes/poster.php', $attributes, $require = 'always' );

				return $content;

			}, $echo = false );

			return $content;
		}

		/**
		 * Movie Poster shortcode.
		 *
		 * @since    1.1
		 * 
		 * @param    array     Shortcode attributes
		 * @param    string    Shortcode content
		 * 
		 * @return   string    Shortcode display
		 */
		public static function movie_images_shortcode( $atts = array(), $content = null ) {

			$atts = self::filter_shortcode_atts( 'movie_images', $atts );

			$movie_id = WPML_Shortcodes::find_movie_id( $atts['id'], $atts['title'] );
			if ( is_null( $movie_id ) )
				return $content;

			$atts['movie_id'] = $movie_id;

			// Caching
			$name = apply_filters( 'wpml_cache_name', 'movie_images_shortcode', $atts );
			$content = WPML_Cache::output( $name, function() use ( $atts, $content ) {

				extract( $atts );

				$images = '';

				$args = array(
					'post_type'   => 'attachment',
					'orderby'     => 'title',
					'numberposts' => -1,
					'post_status' => null,
					'post_parent' => $movie_id,
					'exclude'     => get_post_thumbnail_id( $movie_id )
				);

				$attachments = get_posts( $args );
				$images = array();
				$content = '';
				
				if ( $attachments ) {

					if ( ! is_null( $count ) )
						$attachments = array_splice( $attachments, 0, $count );

					foreach ( $attachments as $attachment )
						$images[] = array(
							'thumbnail' => wp_get_attachment_image_src( $attachment->ID, $size ),
							'full'      => wp_get_attachment_image_src( $attachment->ID, 'full' )
						);

					$content = WPMovieLibrary::render_template( 'shortcodes/images.php', array( 'size' => $size, 'movie_id' => $movie_id, 'images' => $images ), $require = 'always' );
				}

				return $content;

			}, $echo = false );

			return $content;
		}

		/**
		 * Movie Detail shortcode. This shortcode supports aliases.
		 *
		 * @since    1.1
		 * 
		 * @param    array     Shortcode attributes
		 * @param    string    Shortcode content
		 * @param    string    Shortcode tag name
		 * 
		 * @return   string    Shortcode display
		 */
		public static function movie_detail_shortcode( $atts = array(), $content = null, $tag = null ) {

			// Is this an alias?
			if ( ! is_null( $tag ) && "{$tag}_shortcode" != __FUNCTION__ )
				$atts['key'] = str_replace( 'movie_', '', $tag );

			$atts = self::filter_shortcode_atts( 'movie_detail', $atts );

			$movie_id = WPML_Shortcodes::find_movie_id( $atts['id'], $atts['title'] );
			if ( is_null( $movie_id ) )
				return $content;

			$atts['movie_id'] = $movie_id;

			// Caching
			$name = apply_filters( 'wpml_cache_name', 'movie_detail_shortcode', $atts );
			$content = WPML_Cache::output( $name, function() use ( $atts, $content ) {

				extract( $atts );

				if ( ! function_exists( "wpml_get_movie_{$key}" ) )
					return $content;

				$content = call_user_func( "wpml_get_movie_{$key}", $movie_id );

				$format = ( ! $raw ? 'html' : 'raw' );
				$content = apply_filters( "wpml_format_movie_{$key}", $content, $format );

				return $content;

			}, $echo = false );

			return $content;
		}

		/**
		 * Prepare movies for Movies and Movie shortcodes.
		 *
		 * @since    1.1
		 * 
		 * @param    object    WP_Query object
		 * @param    acrray    Shortcode attributes
		 * 
		 * @return   array    Usable data for Shortcodes
		 */
		private static function prepare_movies( $query, $atts ) {

			if ( ! $query->have_posts() )
				return array();

			extract( $atts );

			$movies = array();
			$default_fields = WPML_Settings::get_supported_movie_meta();

			while ( $query->have_posts() ) {

				$query->the_post();

				$movies[ $query->current_post ] = array(
					'id'      => get_the_ID(),
					'title'   => get_the_title(),
					'url'     => get_permalink(),
					'poster'  => null,
					'meta'    => null,
					'details' => null
				);

				if ( ! is_null( $poster ) && has_post_thumbnail( get_the_ID() ) )
					$movies[ $query->current_post ]['poster'] = get_the_post_thumbnail( get_the_ID(), $poster );

				/* 
				 * Meta are passed to the template as an array of values and titles
				 * This gives more freedom to adapt the template
				 */
				if ( ! is_null( $meta ) ) {

					if ( ! is_array( $meta ) )
						$meta = array( $meta );

					$_meta = wpml_get_movie_meta( get_the_ID(), 'data' );
					$_meta = wpml_filter_undimension_array( $_meta );

					$metadata = array();

					foreach ( $_meta as $slug => $m ) {
						if ( in_array( $slug, $meta ) ) {
							$title = __( $default_fields[ $slug ]['title'], 'wpmovielibrary' );
							$value = $_meta[ $slug ];
							if ( has_filter( "wpml_format_movie_{$slug}" ) )
								$value = apply_filters( "wpml_format_movie_{$slug}", $value );
							$value = apply_filters( 'wpml_format_movie_field', $value );
							$metadata[ array_search( $slug, $meta ) ] = array( 'title' => $title, 'value' => $value );
						}
					}

					ksort( $metadata );

					$movies[ $query->current_post ]['meta'] = $metadata;
				}

				/* 
				 * Details are passed to the template as a string
				 * This is simpler because formatting is already
				 * done via filters
				 */
				if ( ! is_null( $details ) ) {

					$movies[ $query->current_post ]['details'] = '';

					if ( ! is_array( $details ) )
						$details = array( $details );

					foreach ( $details as $detail ) {
						$value = call_user_func( "wpml_get_movie_{$detail}", get_the_ID() );
						$movies[ $query->current_post ]['details'] .= apply_filters( "wpml_format_movie_$detail", $value );
					}
				}
			}
			wp_reset_postdata();

			return $movies;
		}

		/**
		 * Find the Movie ID the Shortcode needs. If an ID is passed and
		 * corresponds to a valid movie, use it; else, check if a movie
		 * exists with the title passed and return its ID. If we still
		 * don't have an ID, return the current movie ID.
		 *
		 * @since    1.1
		 * 
		 * @param    object    $id Submitted id
		 * @param    array     $title Submitted title
		 * 
		 * @return   int|null  Movie ID if available, null else
		 */
		public static function find_movie_id( $id = null, $title = null ) {

			$movie_id = null;

			if ( ! is_null( $id ) && 'movie' == get_post_type( $id ) ) {
				$movie_id = $id;
			}
			else if ( ! is_null( $title ) ) {
				$movie_id = get_page_by_title( $title, OBJECT, 'movie' );
				if ( ! is_null( $movie_id ) )
					$movie_id = $movie_id->ID;
			}
			else if ( 'movie' == get_post_type() ){
				$movie_id = get_the_ID();
			}

			return $movie_id;
		}

		/**
		 * Filter an array of Shortcode attributes.
		 * 
		 * Shortcodes have limited attributes and possibly limited values
		 * for some attributes. This method matches each submitted attr
		 * to its limited values if available, and apply a filter to the
		 * value before returning the array.
		 * 
		 * @since    1.1.0
		 * 
		 * @param    string    $shortcode Shortcode's ID
		 * @param    array     $atts Attributes to filter
		 * 
		 * @return   array    Filtered Attributes
		 */
		private static function filter_shortcode_atts( $shortcode, $atts = array() ) {

			if ( ! is_array( $atts ) )
				$atts = array( $atts );

			$defaults = WPML_Settings::get_available_shortcodes();
			$defaults = $defaults[ $shortcode ][ 'atts' ];

			$attributes = array();

			// Loop through the Shortcode's attributes
			foreach ( $defaults as $slug => $default ) {

				if ( isset( $atts[ $slug ] ) ) {

					$attr = $atts[ $slug ];

					// Attribute is not null
					if ( is_null( $attr ) ) {
						$attributes[ $slug ] = $default[ 'default' ];
					}
					else if ( ! is_null( $attr ) ) {

						$value = $attr;

						// Attribute has limited values
						if ( ! is_null( $default[ 'values' ] ) ) {

							// Value should be boolean
							if ( 'boolean' == $default[ 'values' ] && in_array( strtolower( $attr ), array( 'true', 'false', 'yes', 'no' ) ) ) {
								$value = wpml_is_boolean( $attr );
							}
							// Value is array
							else if ( is_array( $default[ 'values' ] ) ) {
								// multiple values
								if ( false !== strpos( $attr, '|' ) ) {
									$value = str_replace( 'actors', 'cast', $attr );
									$value = explode( '|', $value );
									foreach ( $value as $i => $v )
										if ( ! in_array( $v, $default[ 'values' ] ) )
											unset( $value[ $i ] );

									array_unique( $value );
								}
								// single value
								else if ( in_array( strtolower( $attr ), $default[ 'values' ] ) )
									$value = $attr;
							}
						}

						// Attribute has a valid filter
						if ( is_string( $value ) && function_exists( $default[ 'filter' ] ) && is_callable( $default[ 'filter' ] ) )
							$value = call_user_func( $default[ 'filter' ], $value );

						$attributes[ $slug ] = $value;
					}
				}
				else
					$attributes[ $slug ] = $default[ 'default' ];
			}

			return $attributes;
		}

		/**
		 * Register callbacks for actions and filters
		 * 
		 * @since    1.1
		 */
		public function register_hook_callbacks() {}

		/**
		 * Prepares sites to use the plugin during single or network-wide activation
		 *
		 * @since    1.1
		 *
		 * @param bool $network_wide
		 */
		public function activate( $network_wide ) {}

		/**
		 * Rolls back activation procedures when de-activating the plugin
		 *
		 * @since    1.1
		 */
		public function deactivate() {}

		/**
		 * Set the uninstallation instructions
		 *
		 * @since    1.1
		 */
		public static function uninstall() {}

	}

endif;