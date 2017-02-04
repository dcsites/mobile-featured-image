<?php

namespace MobileImg;

class Admin extends Core {

	public static function get_instance() {
        static $instance = null;

        if ( null === $instance ) {
            $instance = new static();
        }

        return $instance;
    }

    private function __clone(){}

    private function __wakeup(){}

	protected function __construct() {

		parent::__construct();

        // Maybe Include CMB2
        $this->maybe_include_cmb2();

        add_action( 'cmb2_init',  array( $this, 'add_metaboxes' ) );

	}

    /**
     * Include the CMB2 framework
     * only if not already loaded
     */
    private function maybe_include_cmb2() {
        if ( file_exists( MOBILE_IMG_PATH . '/lib/cmb2/init.php' ) ) {
            require_once MOBILE_IMG_PATH . '/lib/cmb2/init.php';
        }
    }

    /**
     * Create our metabox for adding the mobile featured image
     */
    public function add_metaboxes() {

        $post_types = $this->get_post_types_with_thumbnails();

        $cmb = new_cmb2_box( array(
            'id'      => $this->prefix . 'extra-images',
            'title'   => __( 'Extra Images', 'mobileimg' ),
            'context' => 'side',
            'priority' => 'low',
            'object_types' => $post_types,
        ) );

        $cmb->add_field( array(
            'id'   => $this->prefix . 'mobile-thumbnail',
            'name' => __( 'Mobile Featured Image', 'mobileimg' ),
            'desc' => __( 'Choose the image you want to use for small screens', 'mobileimg' ),
            'type' => 'file',
            ) );
    }

    /**
     * Get all post types that are public and support thumbnails
     * @return array Post type names
     */
    protected function get_post_types_with_thumbnails() {
        $args = array( 'public'   => true );

        $all_types = get_post_types( $args );

        $post_types = array();

        foreach( $all_types as $type ) {
            if ( post_type_supports( $type, 'thumbnail' ) ) {
                $post_types[] = $type;
            }
        }

        return $post_types;
    }
}

Admin::get_instance();
