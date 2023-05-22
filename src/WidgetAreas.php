<?php

namespace AgriLife\Extension;

/**
 * WidgetAreas class.
 *
 * @since 1.0
 */
class WidgetAreas {

    /**
     * Constructor.
     *
     * @since 1.0
     */
    public function __construct() {
        add_filter( 'genesis_setup', array( $this, 'register_widget_areas' ), 11 );
    }

    /**
     * Register Extension Widget Areas
     *
     * @since 1.0
     */
    public function register_widget_areas() {
        genesis_register_widget_area(
            array(
                'id'               => 'footer-center',
                'name'             => __( 'Footer Center', 'agrilife_extension_unit' ),
                'description'      => __( 'This is the footer widget area. It appears above the required links. This widget area is not equipped to display any widget, and works best with the Simple Social widget', 'agrilife_extension_unit' ),
                '_genesis_builtin' => false,
            )
        );

        genesis_register_widget_area(
            array(
                'id'               => 'home-sidebar',
                'name'             => __( 'Home Sidebar', 'agrilife_extension_unit' ),
                'description'      => __( 'This is the Home sidebar widget area. It appears in the right column of the home page. This widget area is not equipped to display any widget, and works best with menus and Genesis Featured Posts', 'agrilife_extension_unit' ),
                '_genesis_builtin' => false,
            )
        );
    }
}
