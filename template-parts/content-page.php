<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Magazine_Pro
 */

?>
<div class="content-entry">
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	    <div class="the_title">
	        <h2><?php the_title(); ?></h2>
	    </div><!-- .the_title -->
	    <?php magazine_pro_post_thumbnail(); ?>
	    <div class="the_content">
	    	<?php
	    	the_content();

	    	wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'magazine-pro' ),
				'after'  => '</div>',
			) );

			edit_post_link(
				sprintf(
					wp_kses(
						/* translators: %s: Name of current post. Only visible to screen readers */
						__( 'Edit <span class="screen-reader-text">%s</span>', 'magazine-pro' ),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					get_the_title()
				),
				'<span class="edit-link">',
				'</span>'
			);
	    	?>
	    </div><!-- .the_content -->
	</article><!-- #post-<?php the_ID(); ?> -->
</div><!-- .content-entry -->