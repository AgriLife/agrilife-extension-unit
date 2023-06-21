<?php
/**
 * Created by PhpStorm.
 * User: travis
 * Date: 1/28/15
 * Time: 11:44 AM
 */
?>
<div class="welcome">

	<?php if ( '' != get_field( 'page_title' ) ) : ?>
        <h2 class="page-title"><?php echo the_field('page_title') ?></h2>
    <?php endif; ?>

    <p class="welcome-text"><?php echo the_field( 'welcome_text' ); ?></p>
</div>