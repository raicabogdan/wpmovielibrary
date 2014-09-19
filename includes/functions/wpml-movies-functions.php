<?php
/**
 * WPMovieLibrary Movies functions.
 * 
 * 
 * @since     1.3
 * 
 * @package   WPMovieLibrary
 * @author    Charlie MERLAND <charlie.merland@gmail.com>
 * @license   GPL-3.0
 * @link      http://www.caercam.org/
 * @copyright 2014 CaerCam.org
 */

if ( ! defined( 'ABSPATH' ) )
	exit;

/**
 * Return Movie's stored TMDb data.
 *
 * @since    1.0.0
 * 
 * @param    int    Movie Post ID
 *
 * @return   array|string    WPML Movie TMDb data if stored, empty string else.
 */
function wpml_get_movie_meta( $post_id = null, $meta = 'data' ) {
	return WPML_Movies::get_movie_meta( $post_id, $meta );
}

/**
 * Return Movie's Status.
 *
 * @since    1.0.0
 * 
 * @param    int    Movie Post ID
 *
 * @return   array|string    WPML Movie Status if stored, empty string else.
 */
function wpml_get_movie_status( $post_id = null ) {
	return WPML_Movies::get_movie_meta( $post_id, 'status' );
}

/**
 * Return Movie's Media.
 *
 * @since    1.0.0
 * 
 * @param    int    Movie Post ID
 *
 * @return   array|string    WPML Movie Media if stored, empty string else.
 */
function wpml_get_movie_media( $post_id = null ) {
	return WPML_Movies::get_movie_meta( $post_id, 'media' );
}

/**
 * Return Movie's Rating.
 *
 * @since    1.0.0
 * 
 * @param    int    Movie Post ID
 *
 * @return   array|string    WPML Movie Rating if stored, empty string else.
 */
function wpml_get_movie_rating( $post_id = null ) {
	return WPML_Movies::get_movie_meta( $post_id, 'rating' );
}