<?php
/**
 * The template for displaying related posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Magazine_Pro
 */

$enable_related_posts = magazine_pro_get_option( 'magazine_pro_enable_related_section' );

$section_title = magazine_pro_get_option( 'magazine_pro_related_section_title' );

$related_posts_no = magazine_pro_get_option( 'magazine_pro_related_section_posts_number');

$related_args = array(
	'no_found_rows'       => true,
	'ignore_sticky_posts' => true,
);

if( absint( $related_posts_no ) > 0 ) {
	$related_args['posts_per_page'] = absint( $related_posts_no );
} else {
	$related_args['posts_per_page'] = 6;
}

$current_object = get_queried_object();

if ( $current_object instanceof WP_Post ) {
	$current_id = $current_object->ID;
	if ( absint( $current_id ) > 0 ) {
		// Exclude current post.
		$related_args['post__not_in'] = array( absint( $current_id ) );
		// Include current posts categories.
		$categories = wp_get_post_categories( $current_id );
		if ( ! empty( $categories ) ) {
			$related_args['tax_query'] = array(
				array(
					'taxonomy' => 'category',
					'field'    => 'term_id',
					'terms'    => $categories,
					'operator' => 'IN',
					)
				);
		}
	}
}

$related_posts = new WP_Query( $related_args );

if( $related_posts->have_posts() && $enable_related_posts == true ) {
	
	$show_categories_meta = magazine_pro_get_option( 'magazine_pro_enable_related_section_categories_meta' );
    $show_author_meta = magazine_pro_get_option( 'magazine_pro_enable_related_section_author_meta' );
    $show_date_meta = magazine_pro_get_option( 'magazine_pro_enable_related_section_date_meta' );
    $show_cmnt_no_meta = magazine_pro_get_option( 'magazine_pro_enable_related_section_cmnts_no_meta' );
    ?>
    <section class="cm_related_post_container">
        <div class="section_inner">
        	<?php
        	if( !empty( $section_title ) ) {
        		?>
        		<div class="section-title">
	                <h2><?php echo esc_html( $section_title ); ?></h2>
	            </div><!-- .section-title -->
        		<?php
        	}
        	?>
            <div class="row clearfix">
            	<?php
            	$break = 0;
            	$sidebar_position = magazine_pro_sidebar_position();
				$container_class = '';
				if( $sidebar_position != 'none' && is_active_sidebar( 'sidebar' ) ) {
					$container_class = 'col-md-6 col-sm-6 col-xs-12';
				} else {
					$container_class = 'col-md-4 col-sm-6 col-xs-12';
				}
				while( $related_posts->have_posts() ) {
					$related_posts->the_post();
					if( $sidebar_position != 'none' && is_active_sidebar( 'sidebar' ) ) {
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
					?>
					<div class="<?php echo esc_attr( $container_class ); ?>">
	                    <div class="card">
					       <div class="<?php magazine_pro_thumbnail_class(); ?>">
						       	<?php
	                        	if( has_post_thumbnail() ) {
	                        		
	                        		$lazy_thumbnail = magazine_pro_get_option( 'magazine_pro_enable_lazy_load' );

									if( $lazy_thumbnail == true ) {
										magazine_pro_lazy_thumbnail( 'magazine_pro-thumbnail-2' );
									} else {
										magazine_pro_normal_thumbnail( 'magazine_pro-thumbnail-2' );
									}
								}
	                        	?>
					        </div><!-- .post_thumb.imghover -->
					        <div class="card_content">
				       			<?php magazine_pro_post_categories_meta( $show_categories_meta ); ?>
				                <div class="post_title">
				                    <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
				                </div><!-- .post_title -->
				                <?php magazine_pro_post_meta( $show_date_meta, $show_author_meta, $show_cmnt_no_meta ); ?>	 
					        </div><!-- .card_content -->
					    </div><!-- .card -->
	                </div><!-- .col -->
					<?php
					$break++;
				}
				wp_reset_postdata();
            	?>
            </div><!-- .row -->
        </div><!-- .section_inner -->
    </section><!-- .cm-post-widget-three -->
    <?php
}