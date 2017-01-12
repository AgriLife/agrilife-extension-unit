<?php
/**
 * Template Name: Landing Page 1
 */

// Remove post content
remove_action( 'genesis_entry_content', 'genesis_do_post_content' );

// Remove title
remove_action( 'genesis_entry_header', 'genesis_do_post_title' );

add_action( 'genesis_entry_content', 'extension_home_top' );

add_action( 'genesis_entry_content', 'extension_home_content' );

add_action( 'genesis_entry_footer', 'extension_home_programs');


function extension_home_top()
{
    if ( get_field( 'show_slider' ) ) : ?>

        <section class="featured-content clearfix">

        <?php
            $slider_object = get_field( 'select_slider' );
            $slider = $slider_object->post_name;
            if ( function_exists( 'soliloquy_slider' ) )
                soliloquy_slider( $slider );
        ?>

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
                load_template( dirname( __FILE__ ) . '/landing1-welcome.php');
            }
            ?>

        </section><!-- /end #content -->
    </div>
<?php
}

function extension_home_programs()
{
        if ( get_field( 'program_units' ) ) {
            load_template( dirname( __FILE__ ) . '/landing1-programs.php');
        }
}


genesis();
