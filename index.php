<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Magazine_Pro
 */

get_header();
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

	<div class="cm-container">
	    <div class="inner-page-wrapper">
	        <div id="primary" class="content-area">
	            <main id="main" class="site-main">
	                <div class="cm_blog_page">
	                    <div class="row">
	                    	<div class="blog-container clearfix">
		                    	<?php
		                    	$sidebar_position = magazine_pro_sidebar_position();
		                    	$class = magazine_pro_main_container_class();
		                    	if( $sidebar_position == 'left' && is_active_sidebar( 'sidebar' ) ) {
		                    		get_sidebar();
		                    	}
		                    	?>
		                        <div class="<?php echo esc_attr( $class ); ?>">
		                            <div class="content-entry">
		                            	<?php
		                            	if( have_posts() ) {
			                            	?>
			                                <section class="list_page_iner">
		                                		<div class="list_entry">
	                                                <section class="post-display-grid">
	                                                    <div class="section_inner">
	                                                        <div class="row">
	                                                            <?php
	                                                            $break = 0;
				                                            	/* Start the Loop */
																while ( have_posts() ) {
																	the_post();
																	if( $sidebar_position != 'none' ) {
																		if( $break%2 == 0 && $break > 0 ) {
																			?>
																			<div class="row clearfix visible-sm visible-md visible-lg"></div>
																			<?php
																		}
																	} else {
																		if( $break%3 == 0 && $break > 0 ) {
																			?>
																			<div class="row clearfix visible-md visible-lg"></div>
																			<?php
																		}
																		if( $break%2 == 0 && $break > 0 ) {
																			?>
																			<div class="row clearfix visible-sm"></div>
																			<?php
																		}
																	}

																	/*
																	 * Include the Post-Type-specific template for the content.
																	 * If you want to override this in a child theme, then include a file
																	 * called content-___.php (where ___ is the Post Type name) and that will be used instead.
																	 */
																	get_template_part( 'template-parts/layout/layout', 'grid' );

																	$break++;
																}
																?>
	                                                        </div><!-- .row -->
	                                                    </div><!-- .section_inner -->
	                                                </section><!-- .cm-post-widget-three -->
	                                            </div><!-- .list_entry -->
			                                </section><!-- .section list -->
			                                <?php
					                        /**
											* Hook - magazine_pro_pagination.
											*
											* @hooked magazine_pro_pagination_action - 10
											*/
											do_action( 'magazine_pro_pagination' );
										} else {
											get_template_part( 'template-parts/content', 'none' );
										}
										?>
		                            </div><!-- .content-entry -->
		                        </div>
		                        <?php 
		                        if( $sidebar_position == 'right' && is_active_sidebar( 'sidebar' ) ) {
		                    		get_sidebar();
		                    	}
		                        ?>
	                    	</div><!-- .blog-container -->
	                    </div><!-- .row -->
	                </div><!-- .cm_archive_page -->
	            </main><!-- #main.site-main -->
	        </div><!-- #primary.content-area -->
	    </div><!-- .inner-page-wrapper -->
	</div><!-- .cm-container -->
	<?php
get_footer();
