<?php
/**
 * Helper functions for this theme.
 *
 * @package Magazine_Pro
 */

if ( ! function_exists( 'magazine_pro_get_option' ) ) {

	/**
	 * Get theme option.
	 *
	 * @since 1.0.0
	 *
	 * @param string $key Option key.
	 * @return mixed Option value.
	 */
	function magazine_pro_get_option( $key ) {

	       if ( empty( $key ) ) {
			return;
		}

		$value = '';

		$default = magazine_pro_get_default_theme_options();

		$default_value = null;

		if ( is_array( $default ) && isset( $default[ $key ] ) ) {
			$default_value = $default[ $key ];
		}

		if ( null !== $default_value ) {
			$value = get_theme_mod( $key, $default_value );
		}
		else {
			$value = get_theme_mod( $key );
		}

		return $value;
	}
}


if ( ! function_exists( 'magazine_pro_get_default_theme_options' ) ) {

	/**
	 * Get default theme options.
	 *
	 * @since 1.0.0
	 *
	 * @return array Default theme options.
	 */

	function magazine_pro_get_default_theme_options() {

    	$defaults = array();

        $defaults['magazine_pro_select_site_layout'] = 'fullwidth';

    	$defaults['magazine_pro_enable_ticker_news'] = false;
    	$defaults['magazine_pro_ticker_news_title'] = esc_html__( 'Breaking News', 'magazine-pro' );
    	$defaults['magazine_pro_ticker_news_posts_no'] = 5;

    	$defaults['magazine_pro_enable_banner'] = false;
        $defaults['magazine_pro_banner_posts_no'] = 3;
        $defaults['magazine_pro_enable_banner_categories_meta'] = true;
        $defaults['magazine_pro_enable_banner_author_meta'] = true;
        $defaults['magazine_pro_enable_banner_date_meta'] = true;
    	$defaults['magazine_pro_enable_banner_cmnts_no_meta'] = true;

    	$defaults['magazine_pro_homepage_sidebar'] = 'right';

        $defaults['magazine_pro_enable_top_header'] = true;
    	$defaults['magazine_pro_enable_home_button'] = false;
    	$defaults['magazine_pro_enable_search_button'] = true;
        $defaults['magazine_pro_select_header_layout'] = 'header_1';
        $defaults['magazine_pro_header_overlay_color'] = 'rgba(0,0,0,0.2)';
        
        $defaults['magazine_pro_enable_scroll_top_button'] = true;
    	$defaults['magazine_pro_copyright_credit'] = '';

        $defaults['magazine_pro_enable_blog_categories_meta'] = true;
        $defaults['magazine_pro_enable_blog_author_meta'] = true;
        $defaults['magazine_pro_enable_blog_date_meta'] = true;
        $defaults['magazine_pro_enable_blog_cmnts_no_meta'] = true;
    	$defaults['magazine_pro_select_blog_sidebar_position'] = 'right';

        $defaults['magazine_pro_enable_archive_categories_meta'] = true;
        $defaults['magazine_pro_enable_archive_author_meta'] = true;
        $defaults['magazine_pro_enable_archive_date_meta'] = true;
        $defaults['magazine_pro_enable_archive_cmnts_no_meta'] = true;
    	$defaults['magazine_pro_select_archive_sidebar_position'] = 'right';

        $defaults['magazine_pro_enable_search_categories_meta'] = true;
        $defaults['magazine_pro_enable_search_author_meta'] = true;
        $defaults['magazine_pro_enable_search_date_meta'] = true;
        $defaults['magazine_pro_enable_search_cmnts_no_meta'] = true;
    	$defaults['magazine_pro_select_search_sidebar_position'] = 'right';

        $defaults['magazine_pro_enable_post_single_tags_meta'] = true;
        $defaults['magazine_pro_enable_post_single_author_meta'] = true;
        $defaults['magazine_pro_enable_post_single_date_meta'] = true;
        $defaults['magazine_pro_enable_post_single_featured_image'] = true;
        $defaults['magazine_pro_enable_post_single_cmnts_no_meta'] = true;
    	$defaults['magazine_pro_enable_author_section'] = true;
    	$defaults['magazine_pro_enable_related_section'] = true;
    	$defaults['magazine_pro_related_section_title'] = '';
    	$defaults['magazine_pro_related_section_posts_number'] = 6;
        $defaults['magazine_pro_enable_related_section_categories_meta'] = true;
        $defaults['magazine_pro_enable_related_section_author_meta'] = true;
        $defaults['magazine_pro_enable_related_section_date_meta'] = true;
        $defaults['magazine_pro_enable_related_section_cmnts_no_meta'] = true;

    	$defaults['magazine_pro_enable_category_meta'] = true;
    	$defaults['magazine_pro_enable_date_meta'] = true;
    	$defaults['magazine_pro_enable_author_meta'] = true;
    	$defaults['magazine_pro_enable_tag_meta'] = true;
    	$defaults['magazine_pro_enable_comment_meta'] = true;

    	$defaults['magazine_pro_post_excerpt_length'] = 15;

        $defaults['magazine_pro_facebook_link'] = '';
        $defaults['magazine_pro_twitter_link'] = '';
        $defaults['magazine_pro_instagram_link'] = '';
        $defaults['magazine_pro_youtube_link'] = '';
        $defaults['magazine_pro_vk_link'] = '';
        $defaults['magazine_pro_linkedin_link'] = '';
        $defaults['magazine_pro_vimeo_link'] = '';

        $defaults['magazine_pro_enable_breadcrumb'] = true;
        
        $defaults['magazine_pro_enable_sticky_sidebar'] = true;

        $defaults['magazine_pro_enable_lazy_load'] = false;

        $defaults['magazine_pro_primary_theme_color'] = '#FF3D00';

        if( class_exists( 'Woocommerce' ) ) {
            $defaults['magazine_pro_select_woocommerce_sidebar_position'] = 'right';
        }  


    	return $defaults;

	}
}


/**
 * Funtion To Get Google Fonts
 */
if ( !function_exists( 'magazine_pro_fonts_url' ) ) :

    /**
     * Return Font's URL.
     *
     * @since 1.0.0
     * @return string Fonts URL.
     */
    function magazine_pro_fonts_url() {

        $fonts_url = '';
        $fonts     = array();
        $subsets   = 'latin,latin-ext';

        /* translators: If there are characters in your language that are not supported by Merriweather, translate this to 'off'. Do not translate into your own language. */
        if ('off' !== _x('on', 'Roboto font: on or off', 'magazine-pro')) {

            $fonts[] = 'Roboto:400,400i,500,500i,700,700i';
        }

        /* translators: If there are characters in your language that are not supported by Merriweather, translate this to 'off'. Do not translate into your own language. */
        
        if ('off' !== _x('on', 'Muli font: on or off', 'magazine-pro')) {

            $fonts[] = 'Muli:400,400i,600,600i,700,700i';
        }

        $fonts = array_unique( $fonts );

        if ( $fonts ) {
            $fonts_url = add_query_arg( array(
                'family' => urlencode( implode( '|', $fonts ) ),
                'subset' => urlencode( $subsets ),
            ), '//fonts.googleapis.com/css' );
        }

        return $fonts_url;
    }
endif;


/**
 * Funtion To Get Sidebar Position
 */
if ( !function_exists( 'magazine_pro_sidebar_position' ) ) :

    /**
     * Return Position of Sidebar.
     *
     * @since 1.0.0
     * @return string Fonts URL.
     */
    function magazine_pro_sidebar_position() {

        $sidebar_position = '';

        if( class_exists( 'Woocommerce' ) ) {
            if( is_woocommerce() || is_cart() || is_account_page() || is_checkout() ) {

                $sidebar_position = magazine_pro_get_option( 'magazine_pro_select_woocommerce_sidebar_position' );
            } else {
                
                if( is_home() ) {
                    $sidebar_position = magazine_pro_get_option( 'magazine_pro_select_blog_sidebar_position' );
                }

                if( is_archive() ) {
                    $sidebar_position = magazine_pro_get_option( 'magazine_pro_select_archive_sidebar_position' );
                }

                if( is_search() ) {
                    $sidebar_position = magazine_pro_get_option( 'magazine_pro_select_search_sidebar_position' );
                }

                if( is_single() ) {
                    $sidebar_position = get_post_meta( get_the_ID(), 'magazine_pro_sidebar_position', true );
                }

                if( is_page() ) {
                    $sidebar_position = get_post_meta( get_the_ID(), 'magazine_pro_sidebar_position', true );
                }
            }
        } else {
            if( is_home() ) {
                $sidebar_position = magazine_pro_get_option( 'magazine_pro_select_blog_sidebar_position' );
            }

            if( is_archive() ) {
                $sidebar_position = magazine_pro_get_option( 'magazine_pro_select_archive_sidebar_position' );
            }

            if( is_search() ) {
                $sidebar_position = magazine_pro_get_option( 'magazine_pro_select_search_sidebar_position' );
            }

            if( is_single() ) {
                $sidebar_position = get_post_meta( get_the_ID(), 'magazine_pro_sidebar_position', true );
            }

            if( is_page() ) {
                $sidebar_position = get_post_meta( get_the_ID(), 'magazine_pro_sidebar_position', true );
            }
        }
        
        if( empty( $sidebar_position ) ) {
            $sidebar_position = 'right';
        }

        return $sidebar_position;
    }
endif;



/**
 * Funtion To Check Sidebar Sticky
 */
if ( !function_exists( 'magazine_pro_check_sticky_sidebar' ) ) :

    /**
     * Return True or False
     *
     * @since 1.0.0
     * @return boolean.
     */
    function magazine_pro_check_sticky_sidebar() {

        $is_sticky_sidebar = magazine_pro_get_option( 'magazine_pro_enable_sticky_sidebar' );

        if( $is_sticky_sidebar == true ) {
            return true;
        } else {
            return false;
        }
    }
endif;


/**
 * Function To Get Woocommerce Sidebar
 */
if( ! function_exists( 'magazine_pro_woocommerce_sidebar' ) ) {

    function magazine_pro_woocommerce_sidebar() {

        if( is_active_sidebar( 'woocommerce-sidebar' ) ) {

            $sidebar_class = '';

            $is_sticky = magazine_pro_check_sticky_sidebar();

            if( $is_sticky == true ) {
                $sidebar_class .= 'col-md-4 col-sm-12 col-xs-12 sticky_portion';
            } else {
                $sidebar_class .= 'col-md-4 col-sm-12 col-xs-12';
            }

            ?>
            <div class="<?php echo esc_attr( $sidebar_class ); ?>">
                <aside id="secondary" class="sidebar-widget-area">
                    <?php dynamic_sidebar( 'woocommerce-sidebar' ); ?>
                </aside><!-- #secondary -->
            </div><!-- .col.sticky_portion -->
            <?php
        }
    }
}


/**
 * Function To Get Thumbnail Class
 */
if( ! function_exists( 'magazine_pro_thumbnail_class' ) ) {

    function magazine_pro_thumbnail_class() {

        $thumbnail_class = 'post_thumb imghover';

        $lazy_thumbnail = magazine_pro_get_option( 'magazine_pro_enable_lazy_load' );

        if( $lazy_thumbnail == true ) {

            $thumbnail_class .= ' lazy-thumb lazyloading';
        }

        echo esc_attr( $thumbnail_class );
    }
}


// /*
//  * Hook - Plugin Recommendation
//  */
// if ( ! function_exists( 'magazine_pro_recommended_plugins' ) ) :
//     /**
//      * Recommend plugins.
//      *
//      * @since 1.0.0
//      */
//     function magazine_pro_recommended_plugins() {

//         $plugins = array(
//             array(
//                 'name'     => esc_html__( 'Themebeez Toolkit', 'magazine-pro' ),
//                 'slug'     => 'themebeez-toolkit',
//                 'required' => false,
//             ),
//             array(
//                 'name'     => esc_html__( 'Universal Google AdSense And Ads Manager', 'magazine-pro' ),
//                 'slug'     => 'universal-google-adsense-and-ads-manager',
//                 'required' => false,
//             ),
//         );

//         tgmpa( $plugins );
//     }
// endif;
// add_action( 'tgmpa_register', 'magazine_pro_recommended_plugins' );