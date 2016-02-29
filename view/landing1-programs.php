<?php
/**
 * Created by PhpStorm.
 * User: travis
 * Date: 1/27/15
 * Time: 12:00 PM
 */
?>
<div class="programs">
    <div class="program-head">
    	<h2 class="program-header"><?php the_field( 'program_header' ); ?></h2>
    </div>
    <div class="program-list">
        <?php $i = 1; ?>
        <?php $programs = array_chunk( get_field( 'program_units' ), 3 );
        foreach ( $programs as $chunk ) : ?>
            <div class="program-row"><?php echo agriflex_display_programs( $chunk ); ?> </div><!-- .program-row -->
        <?php endforeach; ?>
    </div>
</div>


<?php

function agriflex_display_programs( $chunk ) {

    ob_start();
    foreach ( $chunk as $program ) : ?>


        <div class="single-program">
            <a href="<?php echo $program['program_page']; ?>">
                <?php	$image = $program['program_image']; ?>
                <img src="<?php echo $image['sizes']['programs-feature']; ?>" alt="<?php echo $image['alt']; ?>" class="program-image" />
                <h3 class="program-name">
                    <?php echo $program['program_name']; ?>
                </h3>
            </a>

            <?php echo $program['program_description']; ?>

        </div>

    <?php endforeach;
    $output = ob_get_clean();

    return $output;

}

?>