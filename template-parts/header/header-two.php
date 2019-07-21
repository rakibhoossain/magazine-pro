<?php
/**
 * Template part for displaying header layout two
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Magazine_Pro
 */
?>
<header class="general-header cm_header-five">
    <?php 
    if( has_header_image() ) { 
        ?>
        <div class="top-header" style="background-image: url(<?php header_image(); ?>);">
        <?php 
    } else { 
        ?>
        <div class="top-header" >
        <?php
    }
    ?>
        <div class="logo-container">
            <?php
            /**
            * Hook - magazine_pro_site_identity.
            *
            * @hooked magazine_pro_site_identity_action - 10
            */
            do_action( 'magazine_pro_site_identity' );
            ?>
        </div><!-- .logo-container -->
        <div class="mask"></div><!-- .mask -->
    </div><!-- .top-header -->
    <div class="navigation-container">
        <div class="cm-container">
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
                </div><!-- #main-nav.primary-navigation -->
                <div class="header-search-container">
                    <?php get_search_form(); ?>
                </div><!-- .search-container -->
            </nav><!-- .main-navigation -->
        </div><!-- .cm-container -->
    </div><!-- .navigation-container -->
</header><!-- .general-header.cm_header-five -->