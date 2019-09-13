<?php

class Magazine_Pro_News_Widget_Three extends WP_Widget {
 
    function __construct() { 

        parent::__construct(
            'magazine_pro-news-widget-three',  // Base ID
            esc_html__( 'CM Full: News Widget 3', 'magazine-pro' ),   // Name
            array(
                'description' => esc_html__( 'Displays posts of selected category.', 'magazine-pro' ), 
            )
        );
 
    }
 
    public function widget( $args, $instance ) {

        $title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );

		$post_cat = !empty( $instance[ 'post_cat' ] ) ? $instance[ 'post_cat' ] : 'none';

		$post_no = !empty( $instance[ 'post_no' ] ) ? $instance[ 'post_no' ] : 6;

        $show_author_meta = $instance['show_author_meta'];

        $show_date_meta = $instance['show_date_meta'];

        $show_cmnt_no_meta = $instance['show_cmnt_no_meta'];

		$post_args = array(
			'post_type' => 'post',
		);

        if( $post_cat != 'none' ) {
            $post_args['category_name'] = sanitize_text_field( $post_cat );
        }

        if( absint( $post_no ) > 0 ) {
            $post_args['posts_per_page'] = absint( $post_no );
        }

		$post_query = new WP_Query( $post_args );

		if( $post_query->have_posts() ) {
            ?>
            <section class="cm_post_widget_six cm-post-widget-section">
                <div class="section_inner">
                    <?php 
                    if( !empty( $title ) ) {
                        ?>
                        <div class="section-title">
                            <h2><?php echo esc_html( $title ); ?></h2>
                        </div><!-- .section-title -->
                        <?php
                    }
                    ?>      
                    <div class="post_widget_inner">
                        <div class="row">
                            <?php
                            $break = 0;
                            while( $post_query->have_posts() ) {
                                $post_query->the_post();
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
                                ?>
                                <div class="col-md-4 col-sm-6 col-xs-12">
                                    <div class="box">
                                        <div class="row">
                                            <div class="col-md-5 col-sm-5 col-xs-4">
                                                <div class="<?php magazine_pro_thumbnail_class(); ?>">
                                                    <?php
                                                    if( has_post_thumbnail() ) {
                                                        
                                                        $lazy_thumbnail = magazine_pro_get_option( 'magazine_pro_enable_lazy_load' );

                                                        if( $lazy_thumbnail == true ) {
                                                            magazine_pro_lazy_thumbnail( 'magazine_pro-thumbnail-3' );
                                                        } else {
                                                            magazine_pro_normal_thumbnail( 'magazine_pro-thumbnail-3' );
                                                        }
                                                    }
                                                    ?>
                                                </div><!-- .post_thumb.imghover -->
                                            </div><!-- .col -->
                                            <div class="col-md-7 col-sm-7 col-xs-8">
                                                <div class="right_box">
                                                    <div class="post_title">
                                                        <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                                                    </div><!-- .post_title -->
                                                    <?php magazine_pro_post_meta( $show_date_meta, $show_author_meta, $show_cmnt_no_meta ); ?>
                                                </div><!-- .right_box -->
                                            </div><!-- .col -->
                                        </div><!-- .row -->
                                    </div><!-- .box -->
                                </div><!-- .col -->
                                <?php
                                $break++;
                            }
                            wp_reset_postdata();
                            ?>
                        </div><!-- .row -->
                    </div><!-- .post_widget_inner -->
                </div><!-- .section_inner -->
            </section><!-- .cm_post_widget_six.section_spacing -->
            <?php
        }
 
    }
 
    public function form( $instance ) {
        $defaults = array(
            'title'       => '',
            'post_cat'	=> 'none',
            'post_no'	  => 6,
            'show_author_meta' => true,
            'show_date_meta' => true,
            'show_cmnt_no_meta' => true,
        );

        $instance = wp_parse_args( (array) $instance, $defaults );

		?>
        <p>
            <strong><?php esc_html_e( 'At frontend this widget looks like as below:', 'magazine-pro' ); ?></strong> 
            <img src="<?php echo esc_url( get_template_directory_uri() . '/admin/images/widget-placeholders/cm-full-widget-three.png' ); ?>" style="max-width: 100%; height: auto;"> 
        </p>

		<p>
            <label for="<?php echo esc_attr( $this->get_field_name('title') ); ?>">
                <strong><?php esc_html_e('Title', 'magazine-pro'); ?></strong>
            </label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id('title') ); ?>" name="<?php echo esc_attr( $this->get_field_name('title') ); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>" />   
        </p>

        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'post_cat' ) )?>"><strong><?php echo esc_html__( 'Select Category: ', 'magazine-pro' ); ?></strong></label>
            <?php
            $categories = get_terms( 
                array( 
                    'taxonomy' => 'category', 
                    'hide_empty' => 0, 
                )
            );
            ?>
            <select class="widefat" name="<?php echo esc_attr( $this->get_field_name( 'post_cat' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'post_cat' ) ); ?>">
                <option value="<?php esc_attr_e( 'none', 'magazine-pro' ); ?>"<?php if( $instance['post_cat'] == 'none' ) { esc_attr_e( 'selected', 'magazine-pro' ); } ?>><?php esc_html_e( 'Select Categories', 'magazine-pro' ); ?></option>
                <?php
                if( !empty( $categories ) ) {
                    foreach( $categories as $cat ) {
                        ?>
                        <option value="<?php echo esc_attr( $cat->term_id ); ?>" <?php if( $instance['post_cat'] == $cat->term_id ) { esc_attr_e( 'selected', 'magazine-pro' ); } ?>><?php echo esc_html( $cat->name ); ?></option>
                        <?php
                    }
                }
                ?>
            </select>
            <small><?php echo esc_html__( 'If no category is selected, then recent posts will be displayed.', 'magazine-pro' ); ?></small>
        </p>

		<p>
            <label for="<?php echo esc_attr( $this->get_field_name('post_no') ); ?>">
                <strong><?php esc_html_e('No of Posts', 'magazine-pro'); ?></strong>
            </label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id('post_no') ); ?>" name="<?php echo esc_attr( $this->get_field_name('post_no') ); ?>" type="number" value="<?php echo esc_attr( $instance['post_no'] ); ?>" />
        </p>

        <p>
            <label for="<?php echo esc_attr( $this->get_field_name('show_author_meta') ); ?>">
                <input type="checkbox" id="<?php echo esc_attr( $this->get_field_id('show_author_meta') ); ?>" name="<?php echo esc_attr( $this->get_field_name('show_author_meta') ); ?>" <?php if( $instance['show_author_meta'] == true ) { esc_attr_e( 'checked', 'magazine-pro' ); } ?> >
                <?php esc_html_e('Show Post Author', 'magazine-pro'); ?>
            </label>
        </p> 

        <p>
            <label for="<?php echo esc_attr( $this->get_field_name('show_date_meta') ); ?>">
                <input type="checkbox" id="<?php echo esc_attr( $this->get_field_id('show_date_meta') ); ?>" name="<?php echo esc_attr( $this->get_field_name('show_date_meta') ); ?>" <?php if( $instance['show_date_meta'] == true ) { esc_attr_e( 'checked', 'magazine-pro' ); } ?> >
                <?php esc_html_e('Show Posted Date', 'magazine-pro'); ?>
            </label>
        </p>  

        <p>
            <label for="<?php echo esc_attr( $this->get_field_name('show_cmnt_no_meta') ); ?>">
                <input type="checkbox" id="<?php echo esc_attr( $this->get_field_id('show_cmnt_no_meta') ); ?>" name="<?php echo esc_attr( $this->get_field_name('show_cmnt_no_meta') ); ?>" <?php if( $instance['show_cmnt_no_meta'] == true ) { esc_attr_e( 'checked', 'magazine-pro' ); } ?> >
                <?php esc_html_e('Show Post Comments Number', 'magazine-pro'); ?>
            </label>
        </p>  
		<?php
    }
 
    public function update( $new_instance, $old_instance ) {
 
        $instance = $old_instance;

        $instance['title']  	= sanitize_text_field( $new_instance['title'] );

        $instance['post_cat']  	= sanitize_text_field( $new_instance['post_cat'] );

        $instance['post_no']  	= absint( $new_instance['post_no'] );
        
        $instance['show_author_meta']  = wp_validate_boolean( $new_instance['show_author_meta'] );

        $instance['show_date_meta']  = wp_validate_boolean( $new_instance['show_date_meta'] );

        $instance['show_cmnt_no_meta']  = wp_validate_boolean( $new_instance['show_cmnt_no_meta'] );

        return $instance;
    } 
}