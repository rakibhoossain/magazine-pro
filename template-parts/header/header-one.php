<?php
/**
 * Template part for displaying header layout one
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Magazine_Pro
 */

$show_top_header = magazine_pro_get_option( 'magazine_pro_enable_top_header' );
?>
<header class="general-header">
    <?php if( $show_top_header == true ) { ?>
        <div class="top-header">
            <div class="cm-container">
                <div class="row">
                    <div class="col-md-8 col-sm-7 col-xs-12">
                        <div class="top-header-left">
                            <?php
                            /**
                            * Hook - magazine_pro_top_header_menu.
                            *
                            * @hooked magazine_pro_top_header_menu_action - 10
                            */
                            do_action( 'magazine_pro_top_header_menu' );
                            ?>
                        </div><!-- .top-header-left -->
                    </div><!-- col -->
                    <div class="col-md-4 col-sm-5 col-xs-12">
                        <div class="top-header-social-links">
                            <?php
                            /**
                            * Hook - magazine_pro_social_links.
                            *
                            * @hooked magazine_pro_social_links_action - 10
                            */
                            do_action( 'magazine_pro_social_links' );
                            ?>
                        </div><!-- .top-header-social-links -->
                    </div><!-- .col -->
                </div><!-- .row -->
            </div><!-- .cm-container -->
        </div><!-- .top-header -->
    <?php } ?>
    <div class="cm-container">
        <div class="logo-container">
            <div class="row">
                <div class="col-md-4 col-sm-12 col-xs-12">
                    <?php
                    /**
                    * Hook - magazine_pro_site_identity.
                    *
                    * @hooked magazine_pro_site_identity_action - 10
                    */
                    do_action( 'magazine_pro_site_identity' );
                    ?>
                </div><!-- .col -->
                <?php if( is_active_sidebar( 'header-advertisement' ) ) { ?>
                    <div class="col-md-8 col-sm-12 col-xs-12">
                        <div class="advertisement-area">
                            <?php dynamic_sidebar( 'header-advertisement' ); ?>
                        </div><!-- .advertisement-area -->
                    </div><!-- .col -->
                <?php } ?>
            </div><!-- .row -->
        </div><!-- .logo-container -->
        <nav class="main-navigation">
            <div id="main-nav" class="primary-navigation">
                <?php
                /**
                * Hook - magazine_pro_main_menu.
                *
                * @hooked magazine_pro_top-header_menu_action - 10
                */
                do_action( 'magazine_pro_main_menu' );
                ?>
            </div><!-- .primary-navigation -->
            <div class="header-search-container">
                <?php get_search_form(); ?>
            </div><!-- .search-container -->
        </nav><!-- .main-navigation -->
    </div><!-- .cm-container -->
</header><!-- .general-header -->