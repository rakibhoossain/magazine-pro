<?php
/**
 * Template Name: Home
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Magazine_Pro
 */

get_header(); 

    $show_ticker_news_section = magazine_pro_get_option( 'magazine_pro_enable_ticker_news' );
    if( $show_ticker_news_section == true ) {
        ?>
        <div class="ticker-news-area">
            <div class="cm-container">
                    <?php
            		/**
                    * Hook - magazine_pro_ticker_news.
                    *
                    * @hooked magazine_pro_ticker_news_action - 10
                    */
                    do_action( 'magazine_pro_ticker_news' );
                ?>
            </div><!-- .cm-container -->
        </div><!-- .ticker-news-area -->
        <?php
    }

    
    $show_banner = magazine_pro_get_option( 'magazine_pro_enable_banner' );
    if( $show_banner == true ) {
        ?>
        <div class="banner-area">
            <div class="cm-container">
                <?php
                /**
                * Hook - magazine_pro_banner_slider.
                *
                * @hooked magazine_pro_banner_slider_action - 10
                */
                do_action( 'magazine_pro_banner_slider' );
                ?>
            </div><!-- .cm-container -->
        </div><!-- .banner-area -->
        <?php
    }

    if( is_active_sidebar( 'home-top-news-area' ) ) {
        ?>
        <div class="top-news-area news-area">
            <div class="cm-container">
                <?php
                /**
                * Hook - magazine_pro_top_news.
                *
                * @hooked magazine_pro_top_news_action - 10
                */
                do_action( 'magazine_pro_top_news' );
            	?>
            </div><!-- .cm-container -->
        </div><!-- .top-news-area.news-area -->
        <?php
    }
    ?>
    
    <div class="middle-news-area news-area">
        <div class="cm-container">
            <div class="left_and_right_layout_divider">
                <div class="row">
                    <?php
                    $sidebar_position = magazine_pro_get_option( 'magazine_pro_homepage_sidebar' );
                    if( $sidebar_position == 'left' ) {
                        get_sidebar();
                    }
                    ?>
                    <div class="col-md-8 col-sm-12 col-xs-12 sticky_portion">
                        <div id="primary" class="content-area">
                            <main id="main" class="site-main">
                                <?php
                                /**
                                * Hook - magazine_pro_middle_news.
                                *
                                * @hooked magazine_pro_middle_news_action - 10
                                */
                                do_action( 'magazine_pro_middle_news' );
                                ?>
                            </main><!-- #main.site-main -->
                        </div><!-- #primary.content-area -->
                    </div><!-- .col -->
                    <?php 
                    if( $sidebar_position == 'right' ) {
                        get_sidebar();
                    }
                    ?>
                </div><!-- .main row -->
            </div><!-- .left_and_right_layout_divider -->
        </div><!-- .cm-container -->
    </div><!-- .middle-news-area.news-area -->
    <?php
    if( is_active_sidebar( 'home-bottom-news-area' ) ) {
        ?>
        <div class="bottom-news-area news-area">
            <div class="cm-container">
                <?php
                /**
                * Hook - magazine_pro_top_news.
                *
                * @hooked magazine_pro_top_news_action - 10
                */
                do_action( 'magazine_pro_bottom_news' );
                ?>
            </div><!-- .cm-container -->
        </div><!-- .bottom-news-area.news-area -->
        <?php
    }
get_footer();