<?php

namespace MobileImg;

class Core {

	protected $prefix = 'mobileimg-';

	protected $image_sizes = array();

	public static function get_instance() {

        static $instance = null;

        if ( null === $instance )
			$instance = new static();

        return $instance;
    }

	private function __clone(){}

    private function __wakeup(){}

	protected function __construct() {
		add_filter( 'wp_calculate_image_srcset', array( $this, 'filter_srcset_mobile_featured_image' ), 10, 5 );
	}

	/**
	 * Adds a custom featured image for small sizes through srcset
	 *
	 * @param  array  $sources       Array of image sources for the srcset attribute
	 * @param  array  $sizes         Array of the screen sizes attribute for the image
	 * @param  string $image_src     The original image URL
	 * @param  array  $image_meta    The image attachment's meta information
	 * @param  int    $attachment_id The post id of the attachment
	 * @return array                 Modified sources with mobile image swapped in
	 */
	public function filter_srcset_mobile_featured_image( $sources, $sizes, $image_src, $image_meta, $attachment_id ) {

		// If this isn't a single post or page, abort
		if ( ! is_single() && ! is_page() ) {
			return $sources;
		}

		// If this isn't the current post's thumbnail, abort
		if ( get_post_thumbnail_id() != $attachment_id ) {
			return $sources;
		}

		$meta_key = $this->prefix . 'mobile-thumbnail_id';

		return $this->filter_srcset_mobile_image( $sources, $meta_key );
	}

	/**
	 * Filter an image srcset array, adding a different image for small sizes
	 * @param  array  $sources  WordPress-formatted array of sources
	 * @param  string $meta_key The meta key of an attachment id for the current post
	 * @return array            Modified sources with mobile image swapped in
	 */
	public function filter_srcset_mobile_image( $sources, $meta_key ) {

		$mobile_thumb_id = get_post_meta( get_the_ID(), $meta_key, true );

		// If we don't have an attachment ID, abort
		if ( ! $mobile_thumb_id || get_post_type( $mobile_thumb_id ) != 'attachment' ) {
			return $sources;
		}

		// Loop through the sources.
		// Change the URLs for any sources that are smaller than 980
		foreach ( $sources as $value => $source ) {
			$val = intval( $value );

			if ( 980 < $val ) {
				continue;
			}

			$size = $this->get_image_size( $val );

			$sources[ $value ]['url'] = wp_get_attachment_image_url( $mobile_thumb_id, $size );
		}

		// Add a 980w source
		// This is a good breakpoint between iPhone 6+ and iPad (typical devices)
		$sources['980'] = array(
			'url'        => wp_get_attachment_image_url( $mobile_thumb_id, 'large' ),
			'descriptor' => 'w',
			'value'      => 980,
			);

		return $sources;
	}

	/**
	 * If we're on a very small breakpoint,
	 * use the medium size image (300x300 default)
	 * Otherwise, use the medium_large size
	 * @param  int    $val The screen width
	 * @return string      Most appropriate image size to match
	 */
	protected function get_image_size( $val ) {
		if ( 360 < $val ) {
			$size = 'medium_large';
		} else {
			$size = 'medium';
		}

		return $size;
	}
}

Core::get_instance();
