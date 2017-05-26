<?php

namespace AgriLife\Extension;

class CustomFields {

    public function __construct() {

        // Load ACF fields
        if ( class_exists( 'Acf' ) ) {
            require_once(AG_EXTUNIT_DIR_PATH . 'fields/landing1-details.php');
        }

        // Add ACF fields to Flexible Columns field group
        add_filter('acf/load_field/key=field_57d2d8238a3ef', array( $this, 'aer_acf_load_extras' ) );
    }

    /**
     * Adds fields to the Flexible Columns ACF field group
     * @param  array $field The target field group
     * @return array        The target field group
     */
    public function aer_acf_load_extras($field) {

        // This function interferes with saving field groups
        // so prevent from running if on the ACF edit field group screen
        $screen = get_current_screen();
        if($screen->post_type == 'acf-field-group')
            return $field;

        // Only change if on page edit screen
        $buttoncolors = array (
            'key' => 'field_5928304c8373b',
            'label' => 'Color',
            'name' => 'color',
            '_name' => 'color',
            'type' => 'select',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array (
                'width' => '',
                'class' => '',
                'id' => '',
            ),
            'choices' => array (
                'default' => 'Default',
                'maroon' => 'Maroon',
                'darkgray' => 'Dark Gray',
                'darkblue' => 'Dark Blue',
            ),
            'default_value' => array (
                0 => 'default',
            ),
            'allow_null' => 0,
            'multiple' => 0,
            'ui' => 0,
            'ajax' => 0,
            'return_format' => 'value',
            'placeholder' => '',
        );

        // Add button color field to button attributes
        $field['sub_fields'][] = $buttoncolors;

        return $field;

    }
}
