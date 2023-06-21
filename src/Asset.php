<?php

namespace AgriLife\Extension;

class Asset {

	public function __construct() {

        $this->add_image_sizes();

        // Register global styles used in the theme
        add_action( 'wp_enqueue_scripts', array( $this, 'register_extunit_styles' ) );

        // Enqueue extension styles
        add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_extunit_styles' ) );

        // Dequeue global styles
        add_action( 'wp_print_styles', array( $this, 'dequeue_global_styles'), 5 );

	}

    /**
     * Add the required image sizes
     * @return void
     */
    public function add_image_sizes() {

        add_image_size( 'content-full-width', 760, 570, true );
        add_image_size( 'programs-feature', 248, 186, true );
        add_image_size( 'program-solution_single', 560, 315, true );
        add_image_size( 'post-thumbnail', 75, 75, true );
        add_image_size( 'home-hero', 750, 347, true );
        add_image_size( 'home-featured', 350, 197, true);

    }

    /**
     * Registers all styles used within the plugin
     * @since 1.0
     * @return void
     */
	public function register_extunit_styles() {

		wp_register_style(
			'extension-styles',
			AF_THEME_DIRURL . '/css/ext-unit.css',
			array(),
			'',
			'screen'
		);

	}

    /**
     * Enqueues extension styles
     * @since 1.0
     * @global $wp_styles
     * @return void
     */
    public function enqueue_extunit_styles() {

        wp_enqueue_style( 'extension-styles' );

    }

    /**
     * Dequeues global styles
     * @since 1.0
     * @global $wp_styles
     * @return void
     */
    public function dequeue_global_styles() {

        wp_dequeue_style( 'default-styles' );

    }

}