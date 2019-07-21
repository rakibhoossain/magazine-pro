<?php
/**
 * Magazine Pro Widget Init Class
 */
class Magazine_Pro_Widget_Init {

	/**
	 * Setup class.
	 *
	 * @return  void
	 */
	public function __construct() {	

		add_action( 'widgets_init', array( $this, 'widgets_init' ), 5 );

		$this->load_dependencies();
	}

	/**
	 * Load the required dependencies for this this.
	 *
	 * @return void
	 */
	public function load_dependencies() {
		// Load author widget class
		require get_template_directory() . '/inc/widget/sidebar-footer-widgets/class-magazine-pro-author-widget.php';
		// Load post widget class
		require get_template_directory() . '/inc/widget/sidebar-footer-widgets/class-magazine-pro-post-widget.php';
		// Load social widget class
		require get_template_directory() . '/inc/widget/sidebar-footer-widgets/class-magazine-pro-social-widget.php';
		// Load News Widgets
		require get_template_directory() . '/inc/widget/news-widgets/class-magazine-pro-news-widget-one.php';
		require get_template_directory() . '/inc/widget/news-widgets/class-magazine-pro-news-widget-two.php';
		require get_template_directory() . '/inc/widget/news-widgets/class-magazine-pro-news-widget-three.php';
		require get_template_directory() . '/inc/widget/news-widgets/class-magazine-pro-news-widget-six.php';
		require get_template_directory() . '/inc/widget/news-widgets/class-magazine-pro-news-widget-nine.php';
		require get_template_directory() . '/inc/widget/news-widgets/class-magazine-pro-news-widget-eleven.php';
	}

	/**
	 * Register widget area.
	 *
	 * @see 	https://codex.wordpress.org/Function_Reference/register_sidebar
	 * @return  void
	 */
	public function widgets_init() {

		register_sidebar( array(
			'name'          => esc_html__( 'Sidebar', 'magazine-pro' ),
			'id'            => 'sidebar',
			'description'   => esc_html__( 'Add widgets here.', 'magazine-pro' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<div class="widget-title"><h2>',
			'after_title'   => '</h2></div>',
		) );

		register_sidebar( array(
			'name'          => esc_html__( 'Footer Left', 'magazine-pro' ),
			'id'            => 'footer-left',
			'description'   => esc_html__( 'Add widgets here.', 'magazine-pro' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<div class="widget-title"><h2>',
			'after_title'   => '</h2></div>',
		) );

		register_sidebar( array(
			'name'          => esc_html__( 'Footer Middle', 'magazine-pro' ),
			'id'            => 'footer-middle',
			'description'   => esc_html__( 'Add widgets here.', 'magazine-pro' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<div class="widget-title"><h2>',
			'after_title'   => '</h2></div>',
		) );

		register_sidebar( array(
			'name'          => esc_html__( 'Footer Right', 'magazine-pro' ),
			'id'            => 'footer-right',
			'description'   => esc_html__( 'Add widgets here.', 'magazine-pro' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<div class="widget-title"><h2>',
			'after_title'   => '</h2></div>',
		) );

		register_sidebar( array(
			'name'          => esc_html__( 'Header Advertisement', 'magazine-pro' ),
			'id'            => 'header-advertisement',
			'description'   => esc_html__( 'Add widgets here.', 'magazine-pro' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<div class="widget_title"><h3>',
			'after_title'   => '</h3></div>',
		) );

		register_sidebar( array(
			'name'          => esc_html__( 'Home Top News Area', 'magazine-pro' ),
			'id'            => 'home-top-news-area',
			'description'   => esc_html__( 'Add Fullwidth News Widgets Here.', 'magazine-pro' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<div class="section-title"><h2>',
			'after_title'   => '</h2></div>',
		) );

		register_sidebar( array(
			'name'          => esc_html__( 'Home Middle News Area', 'magazine-pro' ),
			'id'            => 'home-middle-news-area',
			'description'   => esc_html__( 'Add Halfwidth News Widgets Here.', 'magazine-pro' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<div class="section-title"><h2>',
			'after_title'   => '</h2></div>',
		) );

		register_sidebar( array(
			'name'          => esc_html__( 'Home Bottom News Area', 'magazine-pro' ),
			'id'            => 'home-bottom-news-area',
			'description'   => esc_html__( 'Add Fullwidth News Widgets Here.', 'magazine-pro' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<div class="section-title"><h2>',
			'after_title'   => '</h2></div>',
		) );

		if( class_exists( 'Woocommerce' ) ) {
			register_sidebar( array(
				'name'          => esc_html__( 'Woocommerce Sidebar', 'magazine-pro' ),
				'id'            => 'woocommerce-sidebar',
				'description'   => esc_html__( 'Add widgets here.', 'magazine-pro' ),
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<div class="widget-title"><h2>',
				'after_title'   => '</h2></div>',
			) );
		}

		register_widget( 'Magazine_Pro_Author_Widget' );

		register_widget( 'Magazine_Pro_Post_Widget' );
		
		register_widget( 'Magazine_Pro_Social_Widget' );

		// News Widgets
		register_widget( 'Magazine_Pro_News_Widget_One' );

		register_widget( 'Magazine_Pro_News_Widget_Two' );

		register_widget( 'Magazine_Pro_News_Widget_Three' );

		register_widget( 'Magazine_Pro_News_Widget_Six' );

		register_widget( 'Magazine_Pro_News_Widget_Nine' );

		register_widget( 'Magazine_Pro_News_Widget_Eleven' );
	}
}