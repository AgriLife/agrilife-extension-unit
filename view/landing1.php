<?php
/**
 * Template Name: Landing Page 1
 */

// Remove post content
remove_action( 'genesis_entry_content', 'genesis_do_post_content' );

// Remove title
remove_action( 'genesis_entry_header', 'genesis_do_post_title' );

// Remove post meta
add_action( 'genesis_entry_content', 'extension_home_top' );

// Add custom content
add_action( 'genesis_entry_content', 'extension_home_content' );

// Add program units
add_action( 'genesis_entry_footer', 'extension_home_programs');


// Start the function definition for extension_home_top()
function extension_home_top()
{
    // Check if 'show_slider' field exists in database using get_field() function
    if ( get_field( 'show_slider' ) ) : ?>

        <!-- If 'show_slider' exists, start an HTML section -->
        <section class="featured-content clearfix">

        <?php
            // Set a variable $slider_object using the get_field() function to retrieve the value of 'select_slider' field from the database
            $slider_object = get_field( 'select_slider' );
            
            // Set another variable $slider equal to the post_name of $slider_object
            $slider = $slider_object->post_name;
            
            // Check if 'soliloquy_slider()' function exists, and if it does, call it and pass the $slider variable as its parameter
            if ( function_exists( 'soliloquy_slider' ) )
                soliloquy_slider( $slider );
        ?>

        <!-- End the HTML section -->
        </section>

    <?php endif;
}

function extension_home_content()
{
    ?>
    <div class="home-content">
        <section id="content" role="main">
            <?php
            if ( get_field( 'welcome_text' ) ) {
                load_template( dirname( __FILE__ ) . '/landing1-welcome.php'); // Load the landing1-welcome.php template if welcome_text field exists
            }
            ?>

        </section><!-- /end #content -->
    </div>
    <?php
}

/**
 * Check if program units exist, load the landing1-programs.php file if true 
 */
function extension_home_programs() {
    if ( get_field( 'program_units' ) ) { // Check if program units exist
        load_template( dirname( __FILE__ ) . '/landing1-programs.php'); // Load the landing1-programs.php file
    }
}

genesis();
