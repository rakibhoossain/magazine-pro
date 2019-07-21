<?php

class Magazine_Pro_Author_Widget extends WP_Widget {
 
    function __construct() { 

        parent::__construct(
            'magazine_pro-author-widget',  // Base ID
            esc_html__( 'CM: Author Widget', 'magazine-pro' ),   // Name
            array(
                'description' => esc_html__( 'Displays Brief Author Description.', 'magazine-pro' ), 
            )
        );
 
    }
 
    public function widget( $args, $instance ) {

        $title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
            
        $author_page = !empty( $instance['author_page'] ) ? $instance['author_page'] : ''; 

        $author_link_title = !empty( $instance['author_link_title'] ) ? $instance['author_link_title'] : ''; 

        echo $args[ 'before_widget' ];

            $author_args = array(
                'post_type' => 'page',
                'posts_per_page' => 1,
            ); 

            if( $author_page > 0 ) {
                $author_args['page_id'] = absint( $author_page );
            }

            $author = new WP_Query( $author_args );

            if( $author->have_posts() ) :
                if( !empty( $title ) ) {
                    echo $args['before_title'];
                    echo esc_html( $title );
                    echo $args['after_title'];
                }
                while( $author->have_posts() ) : $author->the_post();
                    ?>
                    <div class="cm_author_widget">
                        <div class="author_thumb <?php magazine_pro_thumbnail_class(); ?>">
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
                        </div><!-- .author_thumb -->
                        <div class="author_name">
                            <h4><?php the_title(); ?></h4>
                        </div><!-- .author_name -->
                        <div class="author_desc">
                            <?php the_excerpt(); ?>
                        </div><!-- .author_desc -->
                        <?php 
                        if( !empty( $author_link_title ) ) { 
                            ?>
                            <div class="author-detail-link">
                                <a href="<?php the_permalink(); ?>"><?php echo esc_html( $author_link_title ); ?></a>
                            </div>
                            <?php
                            }
                        ?>
                    </div><!-- .cm_author_widget -->
                    <?php
                endwhile;
                wp_reset_postdata();                
            endif;
        echo $args[ 'after_widget' ]; 
 
    }
 
    public function form( $instance ) {
        $defaults = array(
            'title' => '',
            'author_page' => '',
            'author_link_title' => '',
        );

        $instance = wp_parse_args( (array) $instance, $defaults );

        ?>
        <p>
            <strong><?php esc_html_e( 'At frontend this widget looks like as below:', 'magazine-pro' ); ?></strong> 
            <img src="<?php echo esc_url( get_template_directory_uri() . '/admin/images/widget-placeholders/cm-author-widget.png' ); ?>" style="max-width: 100%; height: auto;"> 
        </p>

        <p>
            <label for="<?php echo esc_attr( $this->get_field_name('title') ); ?>">
                <strong><?php esc_html_e('Title', 'magazine-pro'); ?></strong>
            </label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id('title') ); ?>" name="<?php echo esc_attr( $this->get_field_name('title') ); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>" />   
        </p>

        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'author_page' ) )?>"><strong><?php echo esc_html__( 'Author Page', 'magazine-pro' ); ?></strong></label>
            <?php
                wp_dropdown_pages( array(
                    'id'               => esc_attr( $this->get_field_id( 'author_page' ) ),
                    'class'            => 'widefat',
                    'name'             => esc_attr( $this->get_field_name( 'author_page' ) ),
                    'selected'         => esc_attr( $instance[ 'author_page' ] ),
                    'show_option_none' => esc_html__( '&mdash; Select Page &mdash;', 'magazine-pro' ),
                    )
                );
            ?>
        </p>

        <p>
            <label for="<?php echo esc_attr( $this->get_field_name('author_link_title') ); ?>">
                <strong><?php esc_html_e('Author Link Title', 'magazine-pro'); ?></strong>
            </label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id('author_link_title') ); ?>" name="<?php echo esc_attr( $this->get_field_name('author_link_title') ); ?>" type="text" value="<?php echo esc_attr( $instance['author_link_title'] ); ?>" />   
        </p>
        <?php 
    }
 
    public function update( $new_instance, $old_instance ) {
 
        $instance = $old_instance;

        $instance['title']              = sanitize_text_field( $new_instance['title'] );

        $instance['author_page']        = absint( $new_instance['author_page'] );

        $instance['author_link_title']  = sanitize_text_field( $new_instance['author_link_title'] );

        return $instance;
    } 
}