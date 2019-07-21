<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Magazine_Pro
 */

get_header();
    ?>
    <div class="cm-container">
        <div class="inner-page-wrapper">
            <div id="primary" class="content-area">
                <main id="main" class="site-main">
                    <div class="cm_post_page_lay_wrap">
                        <?php
                        /**
    					* Hook - magazine_pro_breadcrumb.
    					*
    					* @hooked magazine_pro_breadcrumb_action - 10
    					*/
    					do_action( 'magazine_pro_breadcrumb' );
                        ?>
                        <div class="row">
                            <div class="single-container clearfix">
                            	<?php
                            	$sidebar_position = magazine_pro_sidebar_position();
                            	$class = magazine_pro_main_container_class();
                            	if( $sidebar_position == 'left' && is_active_sidebar( 'sidebar' ) ) {
                            		get_sidebar();
                            	}
                            	?>
                                <div class="<?php echo esc_attr( $class ); ?>">
                                    <?php
        							while ( have_posts() ) :

        								the_post();

        								get_template_part( 'template-parts/content', 'single' );

        								get_template_part( 'template-parts/content', 'author' );

        								the_post_navigation( array(
        									'prev_text'	=> esc_html__( 'Prev', 'magazine-pro' ),
        									'next_text'	=> esc_html__( 'Next', 'magazine-pro' ),
        								) );

        								get_template_part( 'template-parts/content', 'related' );

        								// If comments are open or we have at least one comment, load up the comment template.
        								if ( comments_open() || get_comments_number() ) :
        									comments_template();
        								endif;

        							endwhile; // End of the loop.
        							?>
                                </div><!-- .col -->
                                <?php 
                                if( $sidebar_position == 'right' && is_active_sidebar( 'sidebar' ) ) {
                            		get_sidebar();
                            	}
                                ?>
                            </div><!-- .single-container -->
                        </div><!-- .row -->
                    </div><!-- .cm_post_page_lay_wrap -->
                </main><!-- #main.site-main -->
            </div><!-- #primary.content-area -->
        </div><!-- .inner-page-wrapper -->
    </div><!-- .cm-container -->
    <?php
get_footer();
