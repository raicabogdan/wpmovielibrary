<?php
/**
 * WPMovieLibrary Config Settings definition
 *
 * @package   WPMovieLibrary
 * @author    Charlie MERLAND <charlie@caercam.org>
 * @license   GPL-3.0
 * @link      http://www.caercam.org/
 * @copyright 2014 Charlie MERLAND
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) )
	wp_die();

$wpmoly_config = array(

	// 'wpmoly' General settings section
	array(
		'icon'    => 'wpmolicon icon-cogs',
		'title'   => __( 'General', 'wpmovielibrary' ),
		'heading' => __( 'General options', 'wpmovielibrary' ),
		'fields'  => array(
		)
	),

	// 'wpmoly-movies' Movies settings subsection
	array(
		'icon'    => 'wpmolicon icon-movie',
		'title'   => __( 'Movies', 'wpmovielibrary' ),
				'desc' => __( 'WPMovieLibrary handles movies as regular WordPress posts, but you can define some specific behaviours movies only should have.', 'wpmovielibrary'),
		'subsection' => true,
		'fields'  => array(

			// Add movies to the main loop
			'frontpage' => array(
				'id'       => 'wpmoly-frontpage',
				'type'     => 'switch',
				'title'    => __( 'Show Movies in Home Page', 'wpmovielibrary' ),
				'desc'     => __( 'If enabled, movies will appear among other Posts in the Home Page.', 'wpmovielibrary' ),
				'on'       => __( 'Enabled', 'wpmovielibrary' ),
				'off'      => __( 'Disabled', 'wpmovielibrary' ),
				'default'  => 1
			),

			// Add movies to the main loop
			'search' => array(
				'id'       => 'wpmoly-search',
				'type'     => 'switch',
				'title'    => __( 'Movies in search results', 'wpmovielibrary' ),
				'desc'     => __( 'If enabled, the standard WordPress Search will return every movie matching the search in addition to regular posts. Search will include all available meta fields. Examples: a search with keywork <code>Sean Penn</code> will add the movies <em>Into The Wild</em> and <em>The Secret Life of Walter Mitty</em> to the search results; a search with keywork <code>Taiwan</code> will add the movie <em>Life of Pi</em>.', 'wpmovielibrary' ),
				'on'       => __( 'Enabled', 'wpmovielibrary' ),
				'off'      => __( 'Disabled', 'wpmovielibrary' ),
				'default'  => 0
			),

			// Replace excerpt by overview
			'excerpt' => array(
				'id'       => 'wpmoly-excerpt',
				'type'     => 'switch',
				'title'    => __( 'Replace excerpt by overview', 'wpmovielibrary' ),
				'desc'     => __( 'Replace movie excerpts by the movie overview if available. <a href="http://codex.wordpress.org/Excerpt">Learn more about Excerpt</a>.', 'wpmovielibrary' ),
				'on'       => __( 'Enabled', 'wpmovielibrary' ),
				'off'      => __( 'Disabled', 'wpmovielibrary' ),
				'default'  => 1
			),

			// Replace excerpt by overview
			'excerpt-length' => array(
				'id'       => 'wpmoly-excerpt-length',
				'type'     => 'text',
				'title'    => __( 'Excerpt overview length', 'wpmovielibrary' ),
				'desc'     => __( 'Excerpt overview default number of words. This will override WordPress and Themes or Plugins default values for movies only.', 'wpmovielibrary' ),
				'default'  => '75',
				'required' => array( 'wpmoly-excerpt', "=", 1 ),
				'indent'   => true
			),

			// Replace excerpt by overview
			'vintage-content' => array(
				'id'       => 'wpmoly-vintage-content',
				'type'     => 'switch',
				'title'    => __( 'Use old metadata view', 'wpmovielibrary' ),
				'desc'     => __( 'If enabled, movies will use the old metadata display from WPMovieLibrary 1.x instead of the WPMovieLibrary 2.0 movie header.', 'wpmovielibrary' ),
				'on'       => __( 'Enabled', 'wpmovielibrary' ),
				'off'      => __( 'Disabled', 'wpmovielibrary' ),
				'default'  => 0
			)
		)
	),

	// 'wpmoly-meta' Meta settings subsection
	array(
		'icon'    => 'wpmolicon icon-meta',
		'title'   => __( 'Metadata', 'wpmovielibrary' ),
		'heading' => __( 'Metadata settings', 'wpmovielibrary' ),
		'subsection' => true,
		'fields'  => array(

			'meta-start' => array(
				'id'       => 'meta-start',
				'type'     => 'section',
				'title'    => __( 'Movies metadata', 'wpmovielibrary'),
				'subtitle' => __( 'Metadata give you useful information about your movies: director, release date, runtime, prouction, actors, languages…', 'wpmovielibrary'),
				'indent'   => true
			),

			// Show movie meta in posts
			'show-meta' => array(
				'id'       => 'wpmoly-show-meta',
				'type'     => 'select',
				'title'    => __( 'Show metadata', 'wpmovielibrary' ),
				'desc'     => __( 'Add metadata to posts&rsquo; content: director, genres, runtime…', 'wpmovielibrary' ),
				'options'  => array(
					'everywhere' => __( 'Everywhere', 'wpmovielibrary' ),
					'posts_only' => __( 'Only In Post Read', 'wpmovielibrary' ),
					'nowhere'    => __( 'Don&rsquo;t Show', 'wpmovielibrary' ),
				),
				'default'  => 'posts_only'
			),

			'meta-links' => array(
				'id'       => 'wpmoly-meta-links',
				'type'     => 'select',
				'title'    => __( 'Add links to meta', 'wpmovielibrary' ),
				'desc'     => __( 'If enabled, metadata will appear as links to meta pages.', 'wpmovielibrary' ),
				'options'  => array(
					'everywhere' => __( 'Everywhere', 'wpmovielibrary' ),
					'posts_only' => __( 'Only In Post Read', 'wpmovielibrary' ),
					'nowhere'    => __( 'Don&rsquo;t Show', 'wpmovielibrary' ),
				),
				'default'  => 'posts_only',
				'required' => array( 'wpmoly-show-meta', "!=", 'nowhere' ),
			),

			// Default movie meta to show
			'sort-meta' => array(
				'id'       => 'wpmoly-sort-meta',
				'type'     => 'sorter',
				'title'    => __( 'Movie metadata', 'wpmovielibrary' ),
				'desc'     => __( 'Which metadata to display in posts: director, genres, runtime, rating…', 'wpmovielibrary' ),
				//'callback' => 'sorted_markup_fields',
				'compiler' => 'true',
				'options'  => array(
					'used' => array(
						'director'     => __( 'Director', 'wpmovielibrary' ),
						'runtime'      => __( 'Runtime', 'wpmovielibrary' ),
						'release_date' => __( 'Release date', 'wpmovielibrary' ),
						'genres'       => __( 'Genres', 'wpmovielibrary' ),
						'overview'     => __( 'Overview', 'wpmovielibrary' )
					),
					'available' => array(
						'title'                => __( 'Title', 'wpmovielibrary' ),
						'original_title'       => __( 'Original Title', 'wpmovielibrary' ),
						'production_companies' => __( 'Production', 'wpmovielibrary' ),
						'production_countries' => __( 'Country', 'wpmovielibrary' ),
						'spoken_languages'     => __( 'Languages', 'wpmovielibrary' ),
						'producer'             => __( 'Producer', 'wpmovielibrary' ),
						'photography'          => __( 'Director of Photography', 'wpmovielibrary' ),
						'composer'             => __( 'Original Music Composer', 'wpmovielibrary' ),
						'author'               => __( 'Author', 'wpmovielibrary' ),
						'writer'               => __( 'Writer', 'wpmovielibrary' ),
						'cast'                 => __( 'Actors', 'wpmovielibrary' ),
						'certification'        => __( 'Certification', 'wpmovielibrary' ),
						'budget'               => __( 'Budget', 'wpmovielibrary' ),
						'revenue'              => __( 'Revenue', 'wpmovielibrary' ),
						'tagline'              => __( 'Tagline', 'wpmovielibrary' ),
						'imdb_id'              => __( 'IMDb Id', 'wpmovielibrary' ),
						'adult'                => __( 'Adult', 'wpmovielibrary' ),
						'homepage'             => __( 'Homepage', 'wpmovielibrary' )
					)
				),
				'required' => array( 'wpmoly-show-meta', "!=", 'nowhere' ),
				'indent'   => true
			),

			'meta-end' => array(
				'id'     => 'meta-end',
				'type'   => 'section',
				'indent' => false,
			)
		)
	),

	// 'wpmoly-details' Details settings subsection
	array(
		'icon'    => 'wpmolicon icon-details',
		'title'   => __( 'Details', 'wpmovielibrary' ),
		'heading' => __( 'Details settings', 'wpmovielibrary' ),
		'subsection' => true,
		'fields'  => array(

			'details-start' => array(
				'id'       => 'details-start',
				'type'     => 'section',
				'title'    => __( 'Movie details', 'wpmovielibrary'),
				'subtitle' => __( 'Details are a different way to manage your movies. You can specify and filter movies by rating, media, status, language, subtitles…', 'wpmovielibrary'),
				'indent'   => true
			),

			// Show movie details in posts
			'show-details' => array(
				'id'       => 'wpmoly-show-details',
				'type'     => 'select',
				'title'    => __( 'Show details', 'wpmovielibrary' ),
				'desc'     => __( 'Add details to posts&rsquo; content: movie status, media…', 'wpmovielibrary' ),
				'options'  => array(
					'everywhere'  => __( 'Everywhere', 'wpmovielibrary' ),
					'posts_only'  => __( 'Only In Post Read', 'wpmovielibrary' ),
					'nowhere'     => __( 'Don&rsquo;t Show', 'wpmovielibrary' )
				),
				'default' => 'posts_only'
			),

			// Show movie details as icons
			'details-icons' => array(
				'id'       => 'wpmoly-details-icons',
				'type'     => 'switch',
				'title'    => __( 'Details as icons', 'wpmovielibrary' ),
				'desc'     => __( 'If enabled, movie details will appear in the form of icons rather than default colored labels.', 'wpmovielibrary' ),
				'on'       => __( 'Enabled', 'wpmovielibrary' ),
				'off'      => __( 'Disabled', 'wpmovielibrary' ),
				'default'  => 1,
				'required' => array( 'wpmoly-show-details', "!=", 'nowhere' ),
				'indent'   => true
			),

			// Default movie detail to show
			'sort-details' => array(
				'id'       => 'wpmoly-sort-details',
				'type'     => 'sorter',
				'title'    => __( 'Movie details', 'wpmovielibrary' ),
				'desc'     => __( 'Which detail to display in posts: movie status, media…', 'wpmovielibrary' ),
				'compiler' => 'true',
				'options'  => array(
					'used' => array(
						'media'  => __( 'Media', 'wpmovielibrary' ),
						'status' => __( 'Status', 'wpmovielibrary' ),
						'rating' => __( 'Rating', 'wpmovielibrary' )
					),
					'available'  => array(
						'language'  => __( 'Language', 'wpmovielibrary' ),
						'subtitles' => __( 'Subtitles', 'wpmovielibrary' ),
						'format'    => __( 'Format', 'wpmovielibrary' )
					)
				),
				'required' => array( 'wpmoly-show-details', "!=", 'nowhere' ),
				'indent'   => true
			),

			'details-end' => array(
				'id'     => 'details-end',
				'type'   => 'section',
				'indent' => false,
			),
		)
	),

	// 'wpmoly-format' Formatting settings subsection
	array(
		'icon'    => 'wpmolicon icon-format',
		'title'   => __( 'Formatting', 'wpmovielibrary' ),
		'heading' => __( 'Formatting settings', 'wpmovielibrary' ),
		'subsection' => true,
		'fields'  => array(

			// Release date formatting
			'format-date' => array(
				'id'       => 'wpmoly-format-date',
				'type'     => 'text',
				'title'    => __( 'Release date format', 'wpmovielibrary' ),
				'desc'     => __( 'Apply a custom date format to movies\' release dates. Leave empty to use the default API format. Check the <a href="http://codex.wordpress.org/Formatting_Date_and_Time">documentation on date and time formatting</a>.', 'wpmovielibrary' ),
				'default'  => 'j F Y'
			),

			// Release date formatting
			'format-time' => array(
				'id'       => 'wpmoly-format-time',
				'type'     => 'text',
				'title'    => __( 'Runtime format', 'wpmovielibrary' ),
				'desc'     => __( 'Apply a custom time format to movies\' runtimes. Leave empty to use the default API format.', 'wpmovielibrary' ),
				'default'  => 'G \h i \m\i\n'
			),

			// Release date formatting
			'format-rating' => array(
				'id'       => 'wpmoly-format-rating',
				'type'     => 'select',
				'title'    => __( 'Rating format', 'wpmovielibrary' ),
				'desc'     => __( 'Should ratings be displayed using 5 or 10 stars.', 'wpmovielibrary' ),
				'options'  => array(
					'5'  => __( '5 stars', 'wpmovielibrary' ),
					'10' => __( '10 stars', 'wpmovielibrary' )
				),
				'default'  => '5'
			),
		),
	),

	// 'wpmoly-archive' Builtin Pages settings subsection
	/*array(
		'icon'    => 'wpmolicon icon-edit-page',
		'title'   => __( 'Archive Pages', 'wpmovielibrary' ),
		'heading' => __( 'Builtin Archive Pages settings', 'wpmovielibrary' ),
		'desc'    => __( 'This section allow you to define custom pages to display taxonomies and movies archives.', 'wpmovielibrary' ),
		'subsection' => true,
		'fields'  => array(

			// Movies Archive Page
			'movies-archive-page' => array(
				'id'       => 'wpmoly-movies-archive-page',
				'type'     => 'select',
				'data'     => 'pages',
				'title'    => __( 'Movies Archive Page', 'wpmovielibrary' ),
				'desc'     => __( 'Choose a page to use to display movies archives.', 'wpmovielibrary' ),
				'default'  => ''
			),

			// Collections Archive Page
			'collections-archive-page' => array(
				'id'       => 'wpmoly-collections-archive-page',
				'type'     => 'select',
				'data'     => 'pages',
				'title'    => __( 'Collections Archive Page', 'wpmovielibrary' ),
				'desc'     => __( 'Choose a page to use to display collections archives.', 'wpmovielibrary' ),
				'default'  => '',
				'required' => array( 'wpmoly-enable-collection', "=", 1 ),
			),

			// Actors Archive Page
			'actors-archive-page' => array(
				'id'       => 'wpmoly-actors-archive-page',
				'type'     => 'select',
				'data'     => 'pages',
				'title'    => __( 'Actors Archive Page', 'wpmovielibrary' ),
				'desc'     => __( 'Choose a page to use to display actors archives.', 'wpmovielibrary' ),
				'default'  => '',
				'required' => array( 'wpmoly-enable-actor', "=", 1 ),
			),

			// Collections Archive Page
			'genres-archive-page' => array(
				'id'       => 'wpmoly-genres-archive-page',
				'type'     => 'select',
				'data'     => 'pages',
				'title'    => __( 'Collections Archive Page', 'wpmovielibrary' ),
				'desc'     => __( 'Choose a page to use to display genres archives.', 'wpmovielibrary' ),
				'default'  => '',
				'required' => array( 'wpmoly-enable-genre', "=", 1 ),
			)
		),
	),*/

	// 'wpmoly-images' Images and Posters section
	array(
		'icon'    => 'wpmolicon icon-image',
		'title'   => __( 'Images', 'wpmovielibrary' ),
		'heading' => __( 'Images and Posters options', 'wpmovielibrary' ),
		'fields'  => array(
		)
	),

	// 'wpmoly-posters' Posters settings subsection
	array(
		'icon'    => 'wpmolicon icon-poster',
		'title'   => __( 'Posters', 'wpmovielibrary' ),
		'heading' => __( 'Posters settings', 'wpmovielibrary' ),
		'subsection' => true,
		'fields'  => array(

			// Use posters as featured images
			'poster-featured' => array(
				'id'       => 'wpmoly-poster-featured',
				'type'     => 'switch',
				'title'    => __( 'Posters as Thumbnails', 'wpmovielibrary' ),
				'desc'     => __( 'Using posters as movies thumbnails will automatically import new movies&rsquo; poster and set them as post featured image. This setting doesn’t affect movie import by list where posters are automatically saved and set as featured image.', 'wpmovielibrary' ),
				'on'       => __( 'Enabled', 'wpmovielibrary' ),
				'off'      => __( 'Disabled', 'wpmovielibrary' ),
				'default' => 1
			),

			// Movie posters size
			'poster-size' => array(
				'id'       => 'wpmoly-poster-size',
				'type'     => 'select',
				'title'    => __( 'Posters Default Size', 'wpmovielibrary' ),
				'desc'     => __( 'Movie Poster size. Default is TMDb&rsquo;s original size.', 'wpmovielibrary' ),
				'options'  => array(
					'xx-small' => __( 'Invisible (~100px)', 'wpmovielibrary' ),
					'x-small'  => __( 'Tiny (~150px)', 'wpmovielibrary' ),
					'small'    => __( 'Small (~200px)', 'wpmovielibrary' ),
					'medium'   => __( 'Medium (~350px)', 'wpmovielibrary' ),
					'large'    => __( 'Large (~500px)', 'wpmovielibrary' ),
					'full'     => __( 'Full (~800px) ', 'wpmovielibrary' ),
					'original' => __( 'Original', 'wpmovielibrary' )
				),
				'default'  => 'original'
			),

			// Delete posters when deleting movies
			'posters-delete' => array(
				'id'       => 'wpmoly-posters-delete',
				'type'     => 'switch',
				'title'    => __( 'Delete posters with movies', 'wpmovielibrary' ),
				'desc'     => __( 'Enable this if you want to delete posters along with movies.', 'wpmovielibrary' ),
				'on'       => __( 'Enabled', 'wpmovielibrary' ),
				'off'      => __( 'Disabled', 'wpmovielibrary' ),
				'default'  => 0
			),

			// Poster attachment title
			'poster-title' => array(
				'id'       => 'wpmoly-poster-title',
				'type'     => 'text',
				'title'    => __( 'Posters image title', 'wpmovielibrary' ),
				'desc'     => __( 'Title for the imported posters images.', 'wpmovielibrary' ),
				'validate' => 'no_html',
				'default'  => sprintf( '%s "{title}"', __( 'Poster for the movie', 'wpmovielibrary' ) )
			),

			// Poster attachment description
			'poster-description' => array(
				'id'       => 'wpmoly-poster-description',
				'type'     => 'text',
				'title'    => __( 'Posters image description', 'wpmovielibrary' ),
				'desc'     => __( 'Description text for the imported posters images.', 'wpmovielibrary' ),
				'validate' => 'no_html',
				'default'  => sprintf( '© {year} {production} − %s', __( 'All right reserved.', 'wpmovielibrary' ) )
			)
		)
	),

	// 'wpmoly-images' Images settings subsection
	array(
		'icon'    => 'wpmolicon icon-images',
		'title'   => __( 'Images', 'wpmovielibrary' ),
		'heading' => __( 'Images settings', 'wpmovielibrary' ),
		'subsection' => true,
		'fields'  => array(

			// Images size
			'images-size' => array(
				'id'       => 'wpmoly-images-size',
				'type'     => 'select',
				'title'    => __( 'Images Default Size', 'wpmovielibrary' ),
				'desc'     => __( 'Movie Image size. Default is TMDb&rsquo;s original size.', 'wpmovielibrary' ),
				'options'  => array(
					'small'    => __( 'Small (~200px)', 'wpmovielibrary' ),
					'medium'   => __( 'Medium (~350px)', 'wpmovielibrary' ),
					'full'     => __( 'Full (~800px) ', 'wpmovielibrary' ),
					'original' => __( 'Original', 'wpmovielibrary' )
				),
				'default'  =>'original'
			),

			// Maximum number of image to show
			'images-delete' => array(
				'id'       => 'wpmoly-images-delete',
				'type'     => 'switch',
				'title'    => __( 'Delete images with movies', 'wpmovielibrary' ),
				'desc'     => __( 'Enable this if you want to delete all imported images along with movies. Handy if you have a great number of movies to delete and possibly dozens of images attached.', 'wpmovielibrary' ),
				'on'       => __( 'Enabled', 'wpmovielibrary' ),
				'off'      => __( 'Disabled', 'wpmovielibrary' ),
				'default'  => 0
			),

			// Image attachment title
			'image-title' => array(
				'id'       => 'wpmoly-image-title',
				'type'     => 'text',
				'title'    => __( 'Images title', 'wpmovielibrary' ),
				'desc'     => __( 'Title for the imported movie images.', 'wpmovielibrary' ),
				'validate' => 'no_html',
				'default'  => sprintf( '%s "{title}"', __( 'Image from the movie', 'wpmovielibrary' ) )
			),

			// Image attachment description
			'image-description' => array(
				'id'       => 'wpmoly-image-description',
				'type'     => 'text',
				'title'    => __( 'Images description', 'wpmovielibrary' ),
				'desc'     => __( 'Description text for the imported movie images.', 'wpmovielibrary' ),
				'validate' => 'no_html',
				'default'  => sprintf( '© {year} {production} − %s', __( 'All right reserved.', 'wpmovielibrary' ) )
			)
		),
	),

	// 'wpmoly-taxonomies' Taxonomies section
	array(
		'icon'    => 'wpmolicon icon-tags',
		'title'   => __( 'Taxonomies', 'wpmovielibrary' ),
		'heading' => __( 'Built-in Taxonomies configuration', 'wpmovielibrary' ),
		'fields'  => array(
		)
	),

	// 'wpmoly-taxonomies' general settings subsection
	array(
		'icon'    => 'wpmolicon icon-folder',
		'title'   => __( 'General', 'wpmovielibrary' ),
		'heading' => __( 'General settings', 'wpmovielibrary' ),
		'subsection' => true,
		'fields'  => array(

			// Notice
			array(
                            'id'     => 'wpmoly-taxonomies-notice',
                            'type'   => 'info',
                            'notice' => true,
                            'style'  => 'critical',
                            'icon'   => 'wpmolicon icon-warning',
                            'title'  => __( 'Experimental', 'wpmovielibrary' ),
                            'desc'   => __( 'Enabling Categories and Post tags for movies will result in your movies appearing in Categories and Post Tags archive pages, among regular WordPress Posts. This could also interfer with other plugins/themes dealing with Categories/Post Tags. Use it carefully.', 'wpmovielibrary' )
                        ),

			// Enable Categories
			'enable-categories' => array(
				'id'       => 'wpmoly-enable-categories',
				'type'     => 'switch',
				'title'    => __( 'Enable Categories', 'wpmovielibrary' ),
				'description' => __( 'Allow movies to use regular WordPress Categories.', 'wpmovielibrary' ),
				'on'       => __( 'Enabled', 'wpmovielibrary' ),
				'off'      => __( 'Disabled', 'wpmovielibrary' ),
				'default'  => 0
			),

			// Enable Post Tags
			'enable-tags' => array(
				'id'       => 'wpmoly-enable-tags',
				'type'     => 'switch',
				'title'    => __( 'Enable Post Tags', 'wpmovielibrary' ),
				'description' => __( 'Allow movies to use regular WordPress Post Tags.', 'wpmovielibrary' ),
				'on'       => __( 'Enabled', 'wpmovielibrary' ),
				'off'      => __( 'Disabled', 'wpmovielibrary' ),
				'default'  => 0
			)
		)
	),

	// 'wpmoly-collections' collections settings subsection
	array(
		'icon'    => 'wpmolicon icon-collection',
		'title'   => __( 'Collections', 'wpmovielibrary' ),
		'heading' => __( 'Collections settings', 'wpmovielibrary' ),
		'subsection' => true,
		'fields'  => array(

			// Enable Collections Taxonomy
			'enable-collection' => array(
				'id'       => 'wpmoly-enable-collection',
				'type'     => 'switch',
				'title'    => __( 'Enable Collections', 'wpmovielibrary' ),
				'description' => __( 'Enable Collections Custom Taxonomy. Collections work for movies as Categories work for Posts: a hierarchical taxonomy to group your movies coherently. The default behavior is to use Collections to group movies by director, but you can use them differently at your will.', 'wpmovielibrary' ),
				'on'       => __( 'Enabled', 'wpmovielibrary' ),
				'off'      => __( 'Disabled', 'wpmovielibrary' ),
				'default'  => 1
			),

			// Enable Collections Autocomplete
			'collection-autocomplete' => array(
				'id'       => 'wpmoly-collection-autocomplete',
				'type'     => 'switch',
				'title'    => __( 'Add Collections automatically', 'wpmovielibrary' ),
				'desc'     => __( 'Automatically add custom taxonomies when adding/importing movies. If enabled, each added/imported movie will be automatically added to the collection corresponding to its director(s).', 'wpmovielibrary' ),
				'on'       => __( 'Enabled', 'wpmovielibrary' ),
				'off'      => __( 'Disabled', 'wpmovielibrary' ),
				'default'  => 1,
				'required' => array( 'wpmoly-enable-collection', "=", 1 ),
				'indent'   => true
			),

			// Enable Collections for regular WordPress Posts
			'collection-posts' => array(
				'id'       => 'wpmoly-collection-posts',
				'type'     => 'switch',
				'title'    => __( 'Posts Collections support', 'wpmovielibrary' ),
				'desc'     => __( '<strong>Experimental</strong>: if enabled, allow regular WordPress Posts to use collection taxonomy.', 'wpmovielibrary' ),
				'on'       => __( 'Enabled', 'wpmovielibrary' ),
				'off'      => __( 'Disabled', 'wpmovielibrary' ),
				'default'  => 0,
				'required' => array( 'wpmoly-enable-collection', "=", 1 ),
				'indent'   => true
			)
		)
	),

	// 'wpmoly-genres' Genres settings subsection
	array(
		'icon'    => 'wpmolicon icon-tag',
		'title'   => __( 'Genres', 'wpmovielibrary' ),
		'heading' => __( 'Genres settings', 'wpmovielibrary' ),
		'subsection' => true,
		'fields'  => array(

			// Enable Genres Taxonomy
			'enable-genre' => array(
				'id'       => 'wpmoly-enable-genre',
				'type'     => 'switch',
				'title'    => __( 'Enable Genres', 'wpmovielibrary' ),
				'desc'     => __( 'Enable Genres Custom Taxonomy. Genres work for movies as Tags work for Posts: a non-hierarchical taxonomy to improve movies management.', 'wpmovielibrary' ),
				'on'       => __( 'Enabled', 'wpmovielibrary' ),
				'off'      => __( 'Disabled', 'wpmovielibrary' ),
				'default'  => 1
			),

			// Enable Genres Autocomplete
			'genre-autocomplete' => array(
				'id'       => 'wpmoly-genre-autocomplete',
				'type'     => 'switch',
				'title'    => __( 'Add Genres automatically', 'wpmovielibrary' ),
				'desc'     => __( 'Automatically add Genres when adding/importing movies.', 'wpmovielibrary' ),
				'on'       => __( 'Enabled', 'wpmovielibrary' ),
				'off'      => __( 'Disabled', 'wpmovielibrary' ),
				'default'  => 1,
				'required' => array( 'wpmoly-enable-genre', "=", 1 ),
				'indent'   => true
			),

			// Enable Collections for regular WordPress Posts
			'genre-posts' => array(
				'id'       => 'wpmoly-genre-posts',
				'type'     => 'switch',
				'title'    => __( 'Posts Genres support', 'wpmovielibrary' ),
				'desc'     => __( '<strong>Experimental</strong>: if enabled, allow regular WordPress Posts to use genre taxonomy.', 'wpmovielibrary' ),
				'on'       => __( 'Enabled', 'wpmovielibrary' ),
				'off'      => __( 'Disabled', 'wpmovielibrary' ),
				'default'  => 0,
				'required' => array( 'wpmoly-enable-genre', "=", 1 ),
				'indent'   => true
			)
		)
	),

	// 'wpmoly-actors' Actors settings subsection
	array(
		'icon'    => 'wpmolicon icon-actor',
		'title'   => __( 'Actors', 'wpmovielibrary' ),
		'heading' => __( 'Actors settings', 'wpmovielibrary' ),
		'subsection' => true,
		'fields'  => array(

			// Enable Actors Taxonomy
			'enable-actor' => array(
				'id'       => 'wpmoly-enable-actor',
				'type'     => 'switch',
				'title'    => __( 'Enable Actors', 'wpmovielibrary' ),
				'desc'     => __( 'Enable Actors Custom Taxonomy. Actors work for movies as Tags work for Posts: a non-hierarchical taxonomy to improve movies management. WPMovieLibrary stores Actors in a custom order, the most important actors appearing in the top of the list, then the supporting roles, and so on.', 'wpmovielibrary' ),
				'on'       => __( 'Enabled', 'wpmovielibrary' ),
				'off'      => __( 'Disabled', 'wpmovielibrary' ),
				'default'  => 1
			),

			// Enable Actors Autocomplete
			'actor-autocomplete' => array(
				'id'       => 'wpmoly-actor-autocomplete',
				'type'     => 'switch',
				'title'    => __( 'Add Actors automatically', 'wpmovielibrary' ),
				'desc'     => __( 'Automatically add Actors when adding/importing movies.', 'wpmovielibrary' ),
				'on'       => __( 'Enabled', 'wpmovielibrary' ),
				'off'      => __( 'Disabled', 'wpmovielibrary' ),
				'default'  => 1,
				'required' => array( 'wpmoly-enable-actor', "=", 1 ),
				'indent'   => true
			),

			// Enable Actors Autocomplete
			'actor-limit' => array(
				'id'       => 'wpmoly-actor-limit',
				'type'     => 'text',
				'title'    => __( 'Actors limit', 'wpmovielibrary' ),
				'desc'     => __( 'Limit the number of actors per movie. This is useful if you\'re dealing with big libraries and don\'t want to have massive lists of actors created. Limiting the Actors will result in keeping only the most famous/important actors as taxonomies, while the complete list of actors will remained stored as a regular metadata. Set to 0 to disable.', 'wpmovielibrary' ),
				'default'  => 0,
				'validate' => 'numeric',
				'required' => array( 'wpmoly-enable-actor', "=", 1 ),
				'indent'   => true
			),

			// Enable Collections for regular WordPress Posts
			'actor-posts' => array(
				'id'       => 'wpmoly-actor-posts',
				'type'     => 'switch',
				'title'    => __( 'Posts Actors support', 'wpmovielibrary' ),
				'desc'     => __( '<strong>Experimental</strong>: if enabled, allow regular WordPress Posts to use actor taxonomy.', 'wpmovielibrary' ),
				'on'       => __( 'Enabled', 'wpmovielibrary' ),
				'off'      => __( 'Disabled', 'wpmovielibrary' ),
				'default'  => 0,
				'required' => array( 'wpmoly-enable-actor', "=", 1 ),
				'indent'   => true
			)
		),
	),

	// 'wpmoly-translate' Languages
	array(
		'icon'    => 'wpmolicon icon-language',
		'title'   => __( 'Languages', 'wpmovielibrary' ),
		'heading' => __( 'Languages Support', 'wpmovielibrary' ),
		'fields'  => array(
		)
	),

	// 'wpmoly-translate' Translation settings subsection
	array(
		'icon'    => 'wpmolicon icon-flag',
		'title'   => __( 'Translation', 'wpmovielibrary' ),
		'heading' => __( 'Translation settings', 'wpmovielibrary' ),
		'subsection' => true,
		'fields'  => array(

			'translate-countries' => array(
				'id'       => 'wpmoly-translate-countries',
				'type'     => 'switch',
				'title'    => __( 'Translate Countries', 'wpmovielibrary' ),
				'desc'     => __( 'If enabled, countries names will be translated to the current WordPress language.', 'wpmovielibrary' ),
				'on'       => __( 'Enabled', 'wpmovielibrary' ),
				'off'      => __( 'Disabled', 'wpmovielibrary' ),
				'default'  => 1
			),

			'countries-format' => array(
				'id'       => 'wpmoly-countries-format',
				'type'     => 'select',
				'multi'    => true,
				'sortable' => true,
				'title'    => __( 'Country names format', 'wpmovielibrary' ),
				'desc'     => sprintf( __( 'How production countries should be appear in your movies. Default is <code>Flag + translation</code> showing something like <code>%s</code>.', 'wpmovielibrary' ), sprintf( '<span class="flag flag-ir"></span> %s', __( 'Ireland', 'wpmovielibrary-iso' ) ) ),
				'options'  => array(
					'flag'        => __( 'Flag', 'wpmovielibrary' ),
					'original'    => __( 'Original', 'wpmovielibrary' ),
					'translated'  => __( 'Translation', 'wpmovielibrary' ),
					'ptranslated' => sprintf( '(%s)', __( 'Translation', 'wpmovielibrary' ) ),
					'poriginal'   => sprintf( '(%s)', __( 'Original', 'wpmovielibrary' ) )
				),
				'default'  => array(
					'flag',
					'translated'
				),
				'required' => array( 'wpmoly-translate-countries', "=", 1 ),
			),

			'translate-languages' => array(
				'id'       => 'wpmoly-translate-languages',
				'type'     => 'switch',
				'title'    => __( 'Translate Languages', 'wpmovielibrary' ),
				'desc'     => __( 'If enabled, languages names will be translated to the current WordPress language.', 'wpmovielibrary' ),
				'on'       => __( 'Enabled', 'wpmovielibrary' ),
				'off'      => __( 'Disabled', 'wpmovielibrary' ),
				'default'  => 1
			),

			'languages-format' => array(
				'id'       => 'wpmoly-languages-format',
				'type'     => 'select',
				'multi'    => true,
				'sortable' => true,
				'title'    => __( 'Languages names format', 'wpmovielibrary' ),
				'desc'     => __( 'How spoken languages should be appear in your movies. Default is translated.', 'wpmovielibrary' ),
				'options'  => array(
					'original'    => __( 'Original', 'wpmovielibrary' ),
					'translated'  => __( 'Translation', 'wpmovielibrary' ),
					'ptranslated' => sprintf( '(%s)', __( 'Translation', 'wpmovielibrary' ) ),
					'poriginal'   => sprintf( '(%s)', __( 'Original', 'wpmovielibrary' ) ),
					'atranslated' => __( 'Abbreviated translation', 'wpmovielibrary' ),
					'aoriginal'   => __( 'Abbreviated original', 'wpmovielibrary' )
				),
				'default'  => array(
					'translated'
				),
				'required' => array( 'wpmoly-translate-languages', "=", 1 ),
			),
		)
	),

	// 'wpmoly-rewrite' Permalinks settings subsection
	array(
		'icon'    => 'wpmolicon icon-link',
		'title'   => __( 'Permalinks', 'wpmovielibrary' ),
		'heading' => __( 'Rewrite rules & Permalinks', 'wpmovielibrary' ),
		'desc' => __( 'You can adapt the plugin’s permalinks to your local language.', 'wpmovielibrary'),
		'subsection' => true,
		'fields'  => array(

			// Movie URL Rewrite Rule
			'rewrite-enable' => array(
				'id'       => 'wpmoly-rewrite-enable',
				'type'     => 'switch',
				'title'    => __( 'Translate permalinks', 'wpmovielibrary' ),
				'desc'     => __( 'Although it can be very tempting to customize your URLs, <strong>beware</strong>: you probably shouldn\'t modify this more than once if your site relies on search engines; changing URLs too often will could badly affect your site’s referencing.', 'wpmovielibrary' ),
				'on'       => __( 'Enabled', 'wpmovielibrary' ),
				'off'      => __( 'Disabled', 'wpmovielibrary' ),
				'default'  => 1,
				'indent'   => true
			),

			// Movie URL Rewrite Rule
			'rewrite-movie' => array(
				'id'       => 'wpmoly-rewrite-movie',
				'type'     => 'text',
				'title'    => __( 'Movies URL Rewrite', 'wpmovielibrary' ),
				'desc'     => __( 'URL Rewrite Rule to apply on movies. Default is <code>movies</code>, resulting in URL like <code>http://yourblog/movies/fight-club</code>. You can use this field to translate URLs to your language.', 'wpmovielibrary' ),
				'validate_callback' => 'WPMOLY_Utils::permalinks_changed',
				'default'  => 'movies',
				'required' => array( 'wpmoly-rewrite-enable', "=", 1 ),
				'indent'   => true
			),

			// Collections URL Rewrite Rule
			'rewrite-collection' => array(
				'id'       => 'wpmoly-rewrite-collection',
				'type'     => 'text',
				'title'    => __( 'Collections URL Rewrite', 'wpmovielibrary' ),
				'desc'     => __( 'URL Rewrite Rule to apply on collections. Default is <code>collection</code>, resulting in URL like <code>http://yourblog/collection/david-fincher</code>. You can use this field to translate URLs to your language.', 'wpmovielibrary' ),
				'validate_callback' => 'WPMOLY_Utils::permalinks_changed',
				'default'  => 'collection',
				'required' => array(
					array( 'wpmoly-rewrite-enable', "=", 1 ),
					array( 'wpmoly-enable-collection', "=", 1 )
				),
				'indent'   => true
			),

			// Genres URL Rewrite Rule
			'rewrite-genre' => array(
				'id'       => 'wpmoly-rewrite-genre',
				'type'     => 'text',
				'title'    => __( 'Genres URL Rewrite', 'wpmovielibrary' ),
				'desc'     => __( 'URL Rewrite Rule to apply on genres. Default is <code>genre</code>, resulting in URL like <code>http://yourblog/genre/thriller</code>. You can use this field to translate URLs to your language.', 'wpmovielibrary' ),
				'validate_callback' => 'WPMOLY_Utils::permalinks_changed',
				'default'  => 'genre',
				'required' => array(
					array( 'wpmoly-rewrite-enable', "=", 1 ),
					array( 'wpmoly-enable-genre', "=", 1 )
				),
				'indent'   => true
			),

			// Actors URL Rewrite Rule
			'rewrite-actor' => array(
				'id'       => 'wpmoly-rewrite-actor',
				'type'     => 'text',
				'title'    => __( 'Actors URL Rewrite', 'wpmovielibrary' ),
				'desc'     => __( 'URL Rewrite Rule to apply on actors. Default is <code>actor</code>, resulting in URL like <code>http://yourblog/actor/brad-pitt</code>. You can use this field to translate URLs to your language.', 'wpmovielibrary' ),
				'validate_callback' => 'WPMOLY_Utils::permalinks_changed',
				'default'  => 'actor',
				'required' => array(
					array( 'wpmoly-rewrite-enable', "=", 1 ),
					array( 'wpmoly-enable-actor', "=", 1 )
				),
				'indent'   => true
			),

			// Movie URL Rewrite Rule
			/*'rewrite-details' => array(
				'id'       => 'wpmoly-rewrite-details',
				'type'     => 'switch',
				'title'    => __( 'Movie Details URL Rewrite', 'wpmovielibrary' ),
				'desc'     => __( 'Use localized URLs for Movie Details. Enable this to have URLs like <code>http://yourblog/films/disponible</code> for French rather than the default <code>http://yourblog/movies/available</code>.', 'wpmovielibrary' ),
				'on'       => __( 'Enabled', 'wpmovielibrary' ),
				'off'      => __( 'Disabled', 'wpmovielibrary' ),
				'validate_callback' => 'WPMOLY_Utils::permalinks_changed',
				'default'  => 0,
				'required' => array( 'wpmoly-rewrite-enable', "=", 1 ),
				'indent'   => true
			),*/

		)

	),

	// 'wpmoly-cache' Caching
	array(
		'icon'    => 'wpmolicon icon-cache',
		'title'   => __( 'Cache', 'wpmovielibrary' ),
		'heading' => __( 'Caching', 'wpmovielibrary' ),
		'fields'  => array(

			// Results caching
			'enable' => array(
				'id'       => 'wpmoly-enable-cache',
				'type'     => 'switch',
				'title'    => __( 'Enable Caching', 'wpmovielibrary' ),
				'desc'     => __( 'If enabled, WPMovieLibrary will cache movie related data to prevent too frequent queries to the database. <strong>This feature is experimental!</strong> Enabling this could generate <strong>huge</strong> amounts of entries in your database. It is recommended to use this feature sparingly, ideally not in production. <a href="http://wpmovielibrary.com/documentation/performance">Learn more about caching</a>.', 'wpmovielibrary' ),
				'on'       => __( 'Enabled', 'wpmovielibrary' ),
				'off'      => __( 'Disabled', 'wpmovielibrary' ),
				'default'  => 0
			),

			// Results caching
			'user' => array(
				'id'       => 'wpmoly-user-cache',
				'type'     => 'switch',
				'title'    => __( 'User Caching', 'wpmovielibrary' ),
				'desc'     => __( 'If enabled, caching will be activated for logged in users as well as guests.', 'wpmovielibrary' ),
				'on'       => __( 'Enabled', 'wpmovielibrary' ),
				'off'      => __( 'Disabled', 'wpmovielibrary' ),
				'default'  => 0,
				'required' => array( 'wpmoly-enable-cache', "=", 1 ),
				'indent'   => true
			),

			// Caching delay
			'expire' => array(
				'id'       => 'wpmoly-cache-expire',
				'type'     => 'text',
				'title'    => __( 'Caching Time', 'wpmovielibrary' ),
				'desc'     => __( 'Time of validity for cached data, in seconds. Default is 3600 (one hour)', 'wpmovielibrary' ),
				'validate' => 'numeric',
				'default'  => 3600,
				'required' => array( 'wpmoly-enable-cache', "=", 1 ),
				'indent'   => true
			)
		)
	),

	// 'wpmoly-legacy' Legacy
	array(
		'icon'    => 'wpmolicon icon-legacy',
		'title'   => __( 'Legacy', 'wpmovielibrary' ),
		'heading' => __( 'Compatibility settings for WPMovieLibrary 1.x', 'wpmovielibrary' ),
		'fields'  => array(

			// Results caching
			'legacy-mode' => array(
				'id'       => 'wpmoly-legacy-mode',
				'type'     => 'switch',
				'title'    => __( 'Enable Legacy mode', 'wpmovielibrary' ),
				'subtitle' => __( 'WPMovieLibrary 1.x compatibility mode', 'wpmovielibrary' ),
				'description' => __( 'If enabled, WPMovieLibrary will automatically update all movies to the new metadata format introduced by version 1.3. Each time a metadata is access, the plugin will look for obsolete metadata and will update it if needed. Once all movies are updated the plugin will stop looking, but you should deactivate this anyway. <a href="http://wpmovielibrary.com/development/release-notes/#version-1.3">Learn more about this change</a>.', 'wpmovielibrary' ),
				'on'       => __( 'Enabled', 'wpmovielibrary' ),
				'off'      => __( 'Disabled', 'wpmovielibrary' ),
				'default'  => 0
			),

			// Delete deprecated safety
			'legacy-safety' => array(
				'id'       => 'wpmoly-legacy-safety',
				'type'     => 'switch',
				'title'    => __( 'Enable Legacy Safety mode', 'wpmovielibrary' ),
				'subtitle' => __( 'WPMovieLibrary 1.x compatibility safety mode', 'wpmovielibrary' ),
				'description' => __( 'If enabled, WPMovieLibrary will update deprecated metadata to the new format but will <em>not</em> delete the deprecated metadata for safety.', 'wpmovielibrary' ),
				'on'       => __( 'Enabled', 'wpmovielibrary' ),
				'off'      => __( 'Disabled', 'wpmovielibrary' ),
				'default'  => 1,
				'required' => array( 'wpmoly-legacy-mode', '=', 1 )
			)
		)
	),

	// 'wpmoly-api' API Settings
	array(
		'icon'    => 'wpmolicon icon-api',
		'title'   => __( 'API', 'wpmovielibrary' ),
		'heading' => __( 'TheMovieDB API settings', 'wpmovielibrary' ),
		'fields'  => array(

			// API internal mode
                        'personnal' => array(
				'id'       => 'wpmoly-api-internal',
				'type'     => 'switch',
				'title'    => __( 'Personnal API Key', 'wpmovielibrary' ),
				'subtitle' => __( 'Optional: use your own TMDb API key', 'wpmovielibrary' ),
				'desc'     => __( 'A valid TMDb API key is required to fetch informations on the movies you add to WPMovieLibrary. Leave deactivated if you do not have a personnal API key. <a href="http://tmdb.caercam.org/">Learn more</a> about the API key or <a href="https://www.themoviedb.org/">get your own</a>.', 'wpmovielibrary' ) . ' ' . __( 'If you do not have an API key or do not want to use yours right now, WPMovieLibrary will use just its own.', 'wpmovielibrary' ),
				'on'       => __( 'Enabled', 'wpmovielibrary' ),
				'off'      => __( 'Disabled', 'wpmovielibrary' )
                        ),

			// API Key
			'api_key' => array(
				'id'       => 'wpmoly-api-key',
				'type'     => 'text',
				'title'    => __( 'API Key', 'wpmovielibrary' ),
				'subtitle' => __( 'Set up your own API key', 'wpmovielibrary' ),
				'desc'     => __( 'Using your own API key is a more privacy-safe choice as it will avoid WPMovieLibrary to filter queries sent to the API through its own relay server at tmdb.caercam.org. You will also be able to access statistics on your API usage in your TMDb user account.', 'wpmovielibrary' ), 
				'validate' => 'no_special_chars',
				'validate_callback' => array( 'WPMOLY_TMDb', 'check_api_key' ),
				'default'  => null,
				'required' => array( 'wpmoly-api-internal', "=", 1 ),
				'indent'   => true
			),

			// API Scheme
			'scheme' => array(
				'id'       => 'wpmoly-api-scheme',
				'type'     => 'select',
				'title'    => __( 'API Scheme', 'wpmovielibrary' ),
				'desc'     => __( 'Default scheme used to contact TMDb API. Default is HTTPS.', 'wpmovielibrary' ),
				'options'  => array(
					'http'  => __( 'HTTP', 'wpmovielibrary' ),
					'https' => __( 'HTTPS', 'wpmovielibrary' )
				),
				'default' => 'https'
			),

			// API Language
			'language' => array(
				'id'       => 'wpmoly-api-language',
				'type'     => 'select',
				'title'    => __( 'API Language', 'wpmovielibrary' ),
				'desc'     => __( 'Default language to use when fetching informations from TMDb. Default is english. You can always change this manually when add a new movie.', 'wpmovielibrary' ),
				'options'  => $wpmoly_supported_languages,
				'default' => 'en'
			),

			// API Country
			'country' => array(
				'id'       => 'wpmoly-api-country',
				'type'     => 'select',
				'title'    => __( 'API Country', 'wpmovielibrary' ),
				'desc'     => __( 'Default country to use when fetching release informations from TMDb. Default is United States. This is mostly used to get movie certifications corresponding to your country.', 'wpmovielibrary' ),
				'options'  => $wpmoly_supported_countries,
				'default' => 'US'
			),

			// API Alternative Country
			'country-alt' => array(
				'id'       => 'wpmoly-api-country-alt',
				'type'     => 'select',
				'title'    => __( 'API Alternative Country', 'wpmovielibrary' ),
				'desc'     => __( 'You can select an alternative country to use when fetching release informations from TMDb. If primary country leaves empty results, the alternative country will be used to fill the blank.', 'wpmovielibrary' ),
				'options'  => $wpmoly_supported_countries,
				'default' => 'US'
			),
		)
	),

	// Divider
	array(
		'type' => 'divide',
	),

	// 'wpmoly-deactivate' What to do on deactivation
	array(
		'icon'    => 'wpmolicon icon-deactivate',
		'title'   => __( 'Deactivate', 'wpmovielibrary' ),
		'heading' => __( 'Deactivation options', 'wpmovielibrary' ),
		'fields'  => array(

			'movies' => array(
				'id'       => 'wpmoly-deactivate-movies',
				'type'     => 'select',
				'title'    => __( 'Movie Post Type', 'wpmovielibrary' ),
				'desc'     => __( 'How to handle Movies when WPMovieLibrary is deactivated.', 'wpmovielibrary' ),
				'options'  => array(
					'conserve' => __( 'Conserve (recommended)', 'wpmovielibrary' ),
					'convert'  => __( 'Convert to Posts', 'wpmovielibrary' ),
					'remove'   => __( 'Delete (irreversible)', 'wpmovielibrary' ),
					'delete'   => __( 'Delete Completely (irreversible)', 'wpmovielibrary' ),
				),
				'default' => 'conserve'
			),

			'collections' => array(
				'id'       => 'wpmoly-deactivate-collections',
				'type'     => 'select',
				'title'    => __( 'Collections Taxonomy', 'wpmovielibrary' ),
				'desc'     => __( 'How to handle Collections Taxonomy when WPMovieLibrary is deactivated.', 'wpmovielibrary' ),
				'options'  => array(
					'conserve' => __( 'Conserve (recommended)', 'wpmovielibrary' ),
					'convert'  => __( 'Convert to Categories', 'wpmovielibrary' ),
					'delete'   => __( 'Delete (irreversible)', 'wpmovielibrary' ),
				),
				'default'  => 'conserve'
			),

			'genres' => array(
				'id'       => 'wpmoly-deactivate-genres',
				'type'     => 'select',
				'title'    => __( 'Genres Taxonomy', 'wpmovielibrary' ),
				'desc'     => __( 'How to handle Genres Taxonomy when WPMovieLibrary is deactivated.', 'wpmovielibrary' ),
				'options'  => array(
					'conserve' => __( 'Conserve (recommended)', 'wpmovielibrary' ),
					'convert'  => __( 'Convert to Tags', 'wpmovielibrary' ),
					'delete'   => __( 'Delete (irreversible)', 'wpmovielibrary' ),
				),
				'default'  => 'conserve'
			),

			'actors' => array(
				'id'       => 'wpmoly-deactivate-actors',
				'type'     => 'select',
				'title'    => __( 'Actors Taxonomy', 'wpmovielibrary' ),
				'desc'     => __( 'How to handle Actors Taxonomy when WPMovieLibrary is deactivated.', 'wpmovielibrary' ),
				'options'  => array(
					'conserve' => __( 'Conserve (recommended)', 'wpmovielibrary' ),
					'convert'  => __( 'Convert to Tags', 'wpmovielibrary' ),
					'delete'   => __( 'Delete (irreversible)', 'wpmovielibrary' ),
				),
				'default'  => 'conserve'
			),

			'cache'       => array(
				'id'       => 'wpmoly-deactivate-cache',
				'type'     => 'select',
				'title'    => __( 'Cache', 'wpmovielibrary' ),
				'desc'     => __( 'How to handle Cached data when WPMovieLibrary is deactivated.', 'wpmovielibrary' ),
				'options'  => array(
					'conserve' => __( 'Conserve', 'wpmovielibrary' ),
					'empty'    => __( 'Empty (recommended)', 'wpmovielibrary' ),
				),
				'default'  => 'empty'
			)
		)
	),

	// 'wpmoly-uninstall' What to do on uninstallation
	array(
		'icon'    => 'wpmolicon icon-no',
		'title'   => __( 'Uninstall', 'wpmovielibrary' ),
		'heading' => __( 'Uninstallation options', 'wpmovielibrary' ),
		'fields'  => array(

			'movies' => array(
				'id'       => 'wpmoly-uninstall-movies',
				'type'     => 'select',
				'title'    => __( 'Movie Post Type', 'wpmovielibrary' ),
				'desc'     => __( 'How to handle Movies when WPMovieLibrary is uninstalled.', 'wpmovielibrary' ),
				'options'  => array(
					'conserve' => __( 'Conserve', 'wpmovielibrary' ),
					'convert'  => __( 'Convert to Posts (recommended)', 'wpmovielibrary' ),
					'delete'   => __( 'Delete Completely (irreversible)', 'wpmovielibrary' ),
				),
				'default'  => 'convert'
			),

			'collections' => array(
				'id'       => 'wpmoly-uninstall-collections',
				'type'     => 'select',
				'title'    => __( 'Collections Taxonomy', 'wpmovielibrary' ),
				'desc'     => __( 'How to handle Collections Taxonomy when WPMovieLibrary is uninstalled.', 'wpmovielibrary' ),
				'options'  => array(
					'conserve' => __( 'Conserve', 'wpmovielibrary' ),
					'convert'  => __( 'Convert to Categories (recommended)', 'wpmovielibrary' ),
					'delete'   => __( 'Delete (irreversible)', 'wpmovielibrary' ),
				),
				'default'  => 'convert'
			),

			'genres' => array(
				'id'       => 'wpmoly-uninstall-genres',
				'type'     => 'select',
				'title'    => __( 'Genres Taxonomy', 'wpmovielibrary' ),
				'desc'     => __( 'How to handle Genres Taxonomy when WPMovieLibrary is uninstalled.', 'wpmovielibrary' ),
				'options'  => array(
					'conserve' => __( 'Conserve', 'wpmovielibrary' ),
					'convert'  => __( 'Convert to Tags (recommended)', 'wpmovielibrary' ),
					'delete'   => __( 'Delete (irreversible)', 'wpmovielibrary' ),
				),
				'default'  => 'convert'
			),

			'actors' => array(
				'id'       => 'wpmoly-uninstall-actors',
				'type'     => 'select',
				'title'    => __( 'Actors Taxonomy', 'wpmovielibrary' ),
				'desc'     => __( 'How to handle Actors Taxonomy when WPMovieLibrary is uninstalled.', 'wpmovielibrary' ),
				'options'  => array(
					'conserve' => __( 'Conserve', 'wpmovielibrary' ),
					'convert'  => __( 'Convert to Tags (recommended)', 'wpmovielibrary' ),
					'delete'   => __( 'Delete (irreversible)', 'wpmovielibrary' ),
				),
				'default'  => 'convert'
			),

			'cache' => array(
				'id'       => 'wpmoly-uninstall-cache',
				'type'     => 'select',
				'title'    => __( 'Cache', 'wpmovielibrary' ),
				'desc'     => __( 'How to handle Cached data when WPMovieLibrary is uninstalled.', 'wpmovielibrary' ),
				'options'  => array(
					'conserve' => __( 'Conserve', 'wpmovielibrary' ),
					'empty'    => __( 'Empty (recommended)', 'wpmovielibrary' ),
				),
				'default'  => 'empty'
			)
		)
	),

	// 'wpmoly-import-export' Import/Export
	array(
		'icon'    => 'wpmolicon icon-update',
		'title'   => __( 'Import / Export', 'wpmovielibrary' ),
		'heading' => __( 'Import and Export your settings and movies from file, text or URL.', 'wpmovielibrary' ),
		'fields'  => array(

			'import-export' => array(
				'id'         => 'wpmoly-import-export',
				'type'       => 'import_export',
				'title'      => 'Import Export',
				'subtitle'   => 'Save and restore your settings',
				'full_width' => false,
			)

		),
	),

	// Divider
	/*array(
		'type' => 'divide',
	),*/

	// 'wpmoly-about' About Plugin
	/*array(
		'icon'   => 'wpmolicon icon-info',
		'title'  => __( 'Information', 'wpmovielibrary' ),
		'desc'   => __( '<p class="description">This is the Description. Again HTML is allowed</p>', 'wpmovielibrary' ),
		'fields' => array(
			array(
				'id'      => 'wpmoly-raw-info',
				'type'    => 'raw',
				'content' => '',
			)
		),
	)*/
);

$legacy_config = array(
	'tmdb' => array(
		'apikey'       => 'wpmoly-api-key',
		'internal_api' => 'wpmoly-api-internal',
		'lang'         => 'wpmoly-api-language',
		'scheme'       => 'wpmoly-api-scheme'
	),
	'wpml' => array(
		'show_in_home'          => 'wpmoly-frontpage',
		'movie_rewrite'         => 'wpmoly-rewrite-movie',
		'meta_in_posts'         => 'wpmoly-show-meta',
		'details_in_posts'      => 'wpmoly-show-details',
		'details_as_icons'      => 'wpmoly-details-icons',
		'date_format'           => 'wpmoly-format-date',
		'time_format'           => 'wpmoly-format-time'
	),
	'images' => array(
		'poster_featured' => 'wpmoly-poster-featured',
		'poster_size'     => 'wpmoly-poster-size',
		'images_size'     => 'wpmoly-images-size',
		'delete_images'   => 'wpmoly-images-delete',
		'delete_posters'  => 'wpmoly-posters-delete'
	),
	'taxonomies' => array(
		'enable_collection'       => 'wpmoly-enable-collection',
		'collection_rewrite'      => 'wpmoly-rewrite-collection',
		'collection_autocomplete' => 'wpmoly-collection-autocomplete',
		'enable_genre'            => 'wpmoly-enable-genre',
		'genre_rewrite'           => 'wpmoly-rewrite-genre',
		'genre_autocomplete'      => 'wpmoly-genre-autocomplete',
		'enable_actor'            => 'wpmoly-enable-actor',
		'actor_rewrite'           => 'wpmoly-rewrite-actor',
		'actor_autocomplete'      => 'wpmoly-actor-autocomplete',
		'actor_limit'             => 'wpmoly-actor-limit'
	),
	'deactivate' => array(
		'movies'      => 'wpmoly-deactivate-movies',
		'collections' => 'wpmoly-deactivate-collections',
		'genres'      => 'wpmoly-deactivate-genres',
		'actors'      => 'wpmoly-deactivate-actors',
		'cache'       => 'wpmoly-deactivate-cache'
	),
	'uninstall' => array(
		'movies'      => 'wpmoly-uninstall-movies',
		'collections' => 'wpmoly-uninstall-collections',
		'genres'      => 'wpmoly-uninstall-genres',
		'actors'      => 'wpmoly-uninstall-actors',
		'cache'       => 'wpmoly-uninstall-cache'
	),
	'cache' => array(
		'caching'      => 'wpmoly-enable-cache',
		'user_caching' => 'wpmoly-user-cache',
		'caching_time' => 'wpmoly-cache-expire'
	)
);