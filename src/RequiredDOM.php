<?php
namespace AgriLife\Extension;

class RequiredDOM {

	public function __construct() {

		// Alter header title
		add_filter( 'genesis_seo_title', array( $this, 'seo_title' ), 10, 3 );

        add_filter( 'genesis_seo_title', array( $this, 'logo_title' ), 9, 3 );

        // Remove Site Description
        remove_action( 'genesis_site_description', 'genesis_seo_site_description' );

        // Add Extension Body Class
        add_filter( 'body_class', array( $this, 'ext_body_class') );

        // Add Page Slug to Body Class
        add_filter( 'body_class', array( $this, 'slug_body_class') );

        // Modify Header Text
        add_filter( 'genesis_seo_description', array($this, 'filter_tagline') );

        // Render the footer
        add_action( 'genesis_header', array($this, 'add_extension_footer_content') ) ;

	}

    /**
     * Adds logos to the header title
     *
     * @param $title The title text
     * @param $inside
     * @param $wrap
     *
     * @return string
     */
    public function logo_title( $title, $inside, $wrap ) {

        // Replace h1 with div for SEO
        $wrap = 'div';

        // Add extension logo
        $logos = sprintf( '<a href="%s" title="%s"><span>%s</span></a>',
            esc_attr( get_bloginfo('url') ),
            esc_attr( get_bloginfo('name') ),
            get_bloginfo( 'name' ) );

        // Add other logos
        $exttype = get_field( 'ext_type', 'option' );
        $agency = get_field( 'agency_top', 'option' );
        if($agency == 'research' || (is_array($agency) && in_array('research', $agency))){
            $logos = sprintf( '<a href="%s" class="%s-logo" title="%s"><span>%s</span></a>', 'http://agriliferesearch.tamu.edu/', 'research-extension', 'Research and Extension', 'Research and Extension' );
        }
        if($exttype == 'tce' || (is_array($exttype) && in_array('tce', $exttype))){
            $logos .= sprintf( '<a href="%s" class="%s-logo" title="%s"><span>%s</span></a>', 'http://www.pvamu.edu/cahs/cooperative-extension-program-cep/', 'tce', 'County TCE Office', 'County TCE Office' );
        }

        // Combine logos
        $title = sprintf( '<%s class="site-title" itemprop="headline">%s</%s>',
            $wrap,
            $logos,
            $wrap
        );

        // Add secondary logo container
        $logos = '<%s class="site-secondary-logo%s">%s</%s>';
        $logo = '<a href="%s" class="%s-logo" title="%s"><img src="' .
                get_stylesheet_directory_uri() . '/img/%s" alt="%s"></a>';
        $classes = '';
        $inside = '';
        if($exttype == '4h' || (is_array($exttype) && in_array('4h', $exttype))){
            $inside .= sprintf( $logo, 'http://texas4-h.tamu.edu/', 'fourh', '4-H', 'logo-4h.png', '4-H' );
            $classes .= ' fourh';
        }
        if($exttype == 'sg' || (is_array($exttype) && in_array('sg', $exttype))){
            $inside .= sprintf( $logo, 'http://texasseagrant.org/', 'seagrant', 'Sea Grant', 'logo-seagrant.png', 'Sea Grant' );
            $classes .= ' seagrant';
        }
        if($exttype == 'mg' || (is_array($exttype) && in_array('mg', $exttype))){
            $inside .= sprintf( $logo, 'http://txmg.org/', 'txmg', 'Master Gardener Chapter', 'logo-txmg.png', 'Master Gardener Chapter' );
            $classes .= ' txmg';
        }
        if($exttype == 'mn' || (is_array($exttype) && in_array('mn', $exttype))){
            $inside .= sprintf( $logo, 'http://txmn.org/', 'txmn', 'Master Naturalist Chapter', 'logo-txmn.png', 'Master Naturalist Chapter' );
            $classes .= ' txmn';
        }
        if(!empty($inside)){
            $title .= sprintf( $logos, $wrap, $classes, $inside, $wrap );
        }

        return $title;
    }

	/**
	 * Modifies the header title
	 *
	 * @param $title The title text
	 * @param $inside
	 * @param $wrap
	 *
	 * @return string
	 */
	public function seo_title( $title, $inside, $wrap ) {

        // Provide site title if description not used
        if(empty(get_bloginfo('description'))){

            // Replace h1 with div for SEO
            $wrap = 'div';

            $title .= sprintf( '<%s class="site-description" itemprop="description"><span class="site-unit-name">%s</span></%s>',
                $wrap,
                get_bloginfo('name'),
                $wrap
            );
        }

        return $title;

	}

    /**
     * Reformats the tagline
     *
     * @param $title The title text
     * @param $inside
     * @param $wrap
     *
     * @return string
     */
    public function filter_tagline( $title, $inside='', $wrap='' ) {

        // $wrap may be null for some reason
        if(empty($wrap)){
            preg_match( '/\w+/', $title, $results );
            $wrap = $results ? $results[0] : 'h2';
        }

        // $inside may be null for some reason
        if(empty($inside)){
            $results = preg_split('/<\/?'.$wrap.'[^>]*>/', $title);
            $inside = sizeof($results) > 1 ? $results[1] : esc_attr( get_bloginfo('description') );
        }

        // Place wildcards where needed
        $title = preg_replace( '/\b'.$wrap.'\b/', '%s', $title );
        if(!empty($inside)){
            $title = str_replace( $inside, '%s', $title );
        }

        // Add the site title before the description
        $title = sprintf( $title,
            $wrap,
            '<span class="site-unit-name">' . esc_attr( get_bloginfo('name') ) . '</span><span class="site-unit-title">' . $inside . '</span>',
            $wrap
        );

        return $title;

    }

    /**
     * Add and Extension body class
     *
     * @param $classes The existing body classes
     *
     * @return string
     */
    public function ext_body_class( $classes ) {

        $classes[] = 'extension-site';
        return $classes;

    }

    /**
     * Add page slug and category to body class
     *
     * @param $classes The existing body classes
     *
     * @return string
     */
    public function slug_body_class( $classes ) {

        global $post;

        if ( isset( $post ) ) {
            $classes[] = $post->post_type . '-' . $post->post_name;

            $parent = get_page($post->post_parent);
            $classes[] = $parent->post_type . '-parent-' . $parent->post_name;
        }

        return $classes;

    }

    /**
     * Add extension info to bottom of page
     * @since 1.0
     * @return void
     */
    public function add_extension_footer_content()
    {
        remove_all_actions('genesis_footer');
        add_action( 'genesis_footer', 'genesis_footer_markup_open', 5 );
        add_action( 'genesis_footer', 'genesis_footer_markup_close', 15 );

        add_action('genesis_footer', array($this, 'render_ext_logo'));
        add_action('genesis_footer', array($this, 'render_tamus_logo'));
        add_action('genesis_footer', array($this, 'render_footer_widgets'));
        add_action('genesis_footer', array($this, 'render_required_links'));
    }

    /**
     * Render Extension logo
     * @since 1.0
     * @return string
     */
    public function render_ext_logo()
    {

        $output = '
            <div class="footer-container-ext">
                <a href="http://agrilifeextension.tamu.edu/" title="Texas A&M AgriLife Extension Service"><img class="footer-ext-logo" src="'.AG_EXTUNIT_DIR_URL.'/img/logo-ext.png" title="Texas A&M AgriLife Extension Service" alt="Texas A&M AgriLife Extension Service" /><noscript><img src="//agrilifecdn.tamu.edu/wp-content/themes/AgriLife-Beta/images/footer-tamus.png" title="Texas A&M University System Member" alt="Texas A&M University System Member" /></noscript></a>
            </div>';

        echo $output;

    }

	/**
	 * Render the widgets in the footer
	 * @since 1.0
	 * @return void
	 */
	public function render_footer_widgets() {

        if ( is_active_sidebar( 'footer-center' ) ) : ?>
            <div id="footer-center-widgets" class="footer-center widget-area" role="complementary">
                <?php dynamic_sidebar( 'footer-center' ); ?>
            </div><!-- #footer-center-widgets -->
        <?php endif;

	}


    /**
     * Render TAMUS logo
     * @todo refactor this, repeated functionality
     * @since 1.0
     * @return string
     */
    public static function render_tamus_logo()
    {

        $output = '
            <div class="footer-container-tamus">
                <a href="http://tamus.edu/" title="Texas A&amp;M University System"><img class="footer-tamus" src="'.AG_EXTUNIT_DIR_URL.'/img/logo-tamus.png" title="Texas A&amp;M University System Member" alt="Texas A&amp;M University System Member" />
                <noscript><img src="//agrilifecdn.tamu.edu/wp-content/themes/AgriLife-Beta/images/footer-tamus.png" title="Texas A&amp;M University System Member" alt="Texas A&amp;M University System Member" /></noscript></a>
            </div>';

        echo $output;

    }

    /**
     * Render required links
     * @todo refactor this, repeated functionality
     * @since 1.0
     * @return string
     */
    public static function render_required_links()
    {

        $output = '
            <div class="footer-container-required">
                <ul class="req-links">
                    <li><a href="http://agrilife.org/required-links/compact/">Compact with Texans</a></li>
                    <li><a href="http://agrilife.org/required-links/privacy/">Privacy and Security</a></li>
                    <li><a href="http://itaccessibility.tamu.edu/" target="_blank">Accessibility Policy</a></li>
                    <li><a href="http://publishingext.dir.texas.gov/portal/internal/resources/DocumentLibrary/State%20Website%20Linking%20and%20Privacy%20Policy.pdf" target="_blank">State Link Policy</a></li>
                    <li><a href="http://www.tsl.state.tx.us/trail" target="_blank">Statewide Search</a></li>
                    <li><a href="http://www.tamus.edu/veterans/" target="_blank">Veterans Benefits</a></li>
                    <li><a href="http://fcs.tamu.edu/families/military_families/" target="_blank">Military Families</a></li>
                    <li><a href="https://secure.ethicspoint.com/domain/en/report_custom.asp?clientid=19681" target="_blank">Risk, Fraud &amp; Misconduct Hotline</a></li>
                    <li><a href="http://www.texashomelandsecurity.com/" target="_blank">Texas Homeland Security</a></li>
                    <li><a href="http://veterans.portal.texas.gov/">Texas Veteran&apos;s Portal</a></li>
                    <li><a href="http://agrilifeas.tamu.edu/hr/diversity/equal-opportunity-educational-programs/" target="_blank">Equal Opportunity</a></li>
                    <li class="last"><a href="http://agrilife.org/required-links/orpi/">Open Records/Public Information</a></li>
                </ul>
            </div>';

        echo $output;

    }

}
