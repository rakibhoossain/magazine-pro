<?php
/**
 * Magazine Pro Class
 */
class Magazine_Pro {

	/**
	 * Setup class.
	 *
	 * @return  void
	 */
	public function __construct() {

		add_action( 'after_setup_theme', array( $this, 'setup' ), 10 );		
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ), 10 );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_scripts' ), 10 );
		add_filter( 'body_class', array( $this, 'body_classes' ), 10, 1 );
		add_action( 'wp_head', array( $this, 'pingback_header' ), 10 );
		add_filter( 'excerpt_more', array( $this, 'excerpt_more' ), 10, 1 );
		add_filter( 'get_search_form', array( $this, 'search_form' ), 10 );

		$this->load_dependencies();
		$this->customizer_init();
		$this->post_meta_init();
		$this->widget_init();
		$this->woocommerce_init();
	}

	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 *
	 * @return  void
	 */
	public function setup() {

		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on Magazine Pro, use a find and replace
		 * to change 'magazine-pro' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'magazine-pro', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		add_image_size( 'magazine_pro-thumbnail-2', 800, 450, true ); // Featured Medium - used in top news, middle news and bottom news section
		add_image_size( 'magazine_pro-thumbnail-3', 720, 540, true ); // Featured Small - used in top news, middle news and bottom news section, Author Image - used in author widget
		add_image_size( 'magazine_pro-thumbnail-4', 450, 600, true ); // Potrait - used in top news and bottom news section, 3:4 Aspect Ratio

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'menu-1' => esc_html__( 'Primary Menu', 'magazine-pro' ), // Primary Menu
			'menu-2' => esc_html__( 'Top Header Menu', 'magazine-pro' ), // Top Header Menu
			'menu-3' => esc_html__( 'Bottom Footer Menu', 'magazine-pro' ), // Bottom Footer Menu
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'magazine_pro_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support( 'custom-logo', array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		) );

		/**
		 * Add support for core custom header.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/custom-headers/
		 */
		add_theme_support( 'custom-header', apply_filters( 'magazine_pro_custom_header_args', array(
			'default-image'          => '',
			'default-text-color'     => '000000',
			'width'                  => 1920,
			'height'                 => 300,
			'flex-height'            => true,
			'wp-head-callback'       => array( $this, 'header_style' ),
		) ) );

		// This variable is intended to be overruled from themes.
		// Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
		// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
		$GLOBALS['content_width'] = apply_filters( 'magazine_pro_content_width', 640 );
	}

	/**
	 * Styles the header image and text displayed on the blog.
	 *
	 * @see Magazine_Pro_custom_header_setup().
	 */
	public function header_style() {

		$header_text_color = get_header_textcolor();

		/*
		 * If no custom options for text are set, let's bail.
		 * get_header_textcolor() options: Any hex value, 'blank' to hide text. Default: add_theme_support( 'custom-header' ).
		 */
		if ( get_theme_support( 'custom-header', 'default-text-color' ) === $header_text_color ) {
			return;
		}

		// If we get this far, we have custom styles. Let's do this.
		?>
		<style type="text/css">
		<?php
		// Has the text been hidden?
		if ( ! display_header_text() ) :
			?>
			.site-title,
			.site-description {
				position: absolute;
				clip: rect(1px, 1px, 1px, 1px);
			}
		<?php
		// If the user has set a custom color for the text use that.
		else :
			?>
			.site-title a,
			.site-description {
				color: #<?php echo esc_attr( $header_text_color ); ?>;
			}
		<?php endif; ?>
		</style>
		<?php
	}

	/**
	 * Enqueue scripts and styles.
	 *
	 * @see 	https://codex.wordpress.org/Plugin_API/Action_Reference/wp_enqueue_scripts
	 * @see 	https://developer.wordpress.org/reference/functions/wp_enqueue_style/
	 * @see 	https://developer.wordpress.org/reference/functions/wp_enqueue_script/
	 * @return 	void
	 */
	public function enqueue_scripts() {

		wp_enqueue_style( 'magazine_pro-style', get_stylesheet_uri() );

		wp_enqueue_style( 'magazine_pro-fonts', magazine_pro_fonts_url() );

		if( is_rtl() ) {
			wp_enqueue_style( 'magazine_pro-main-rtl', get_template_directory_uri() . '/assets/dist/css/main-rtl.css' );
		} else {
			wp_enqueue_style( 'magazine_pro-main', get_template_directory_uri() . '/assets/dist/css/main.css' );
		}

		wp_enqueue_script( 'magazine_pro-bundle', get_template_directory_uri() . '/assets/dist/js/bundle.min.js', array( 'jquery'), MAGAZINE_PRO_VERSION, true );

		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}
	}


	/**
	 * Enqueue scripts and styles for backend
	 */
	public function enqueue_admin_scripts() {

		wp_enqueue_style( 'magazine_pro-admin-styles', get_template_directory_uri() . '/admin/css/admin-styles.css' );
	}

	/**
	 * Adds custom classes to the array of body classes.
	 *
	 * @param  array $classes Classes for the body element.
	 * @return array
	 */
	public function body_classes( $classes ) {

		// Adds a class of hfeed to non-singular pages.
		if ( ! is_singular() ) {
			$classes[] = 'hfeed';
		}

		// Adds a class of no-sidebar when there is no sidebar present.
		if ( ! is_active_sidebar( 'sidebar' ) ) {
			$classes[] = 'no-sidebar';
		}

		$site_layout = magazine_pro_get_option( 'magazine_pro_select_site_layout' );
		if( $site_layout == 'boxed' ) {
			$classes[] = 'boxed';
		}

		return $classes;
	}


	/**
	 * Add a pingback url auto-discovery header for singularly identifiable articles.
	 *
	 * @return  void
	 */
	public function pingback_header() {

		if ( is_singular() && pings_open() ) {

			echo '<link rel="pingback" href="', esc_url( get_bloginfo( 'pingback_url' ) ), '">';
		}
	}	


	/**
	 * Trailing text for post excerpts.
	 *
	 * @return  void
	 */
	public function excerpt_more( $more ) {

		if ( is_admin() ) {

			return $more;
		}

		return '';

	}

	/**
	 * Load the required dependencies for this this.
	 *
	 * @return void
	 */
	public function load_dependencies() {
		// Load theme functions
		require get_template_directory() . '/inc/theme-functions.php';
		// Load custom hook functions
		require get_template_directory() . '/inc/theme-hooks.php';
		// Load helper functions
		require get_template_directory() . '/inc/helper-functions.php';
		// Load active callback for customizer options
		require get_template_directory() . '/inc/customizer/functions/active-callback.php';
		// Load customizer dependency
		require get_template_directory() . '/inc/customizer/class-magazine-pro-customize.php';
		// Load post meta dependency
		require get_template_directory() . '/inc/metabox/class-magazine-pro-post-meta.php';
		// Load main widget class
		require get_template_directory() . '/inc/widget/class-magazine-pro-widget-init.php';
		// Load breadcrumb class
		require get_template_directory() . '/third-party/breadcrumbs.php';
		// Load class for plugin recommendation
//		require get_template_directory() . '/third-party/class-tgm-plugin-activation.php';
		// Load woocommerce
		if( class_exists( 'WooCommerce' ) ) {
			require get_template_directory() . '/inc/woocommerce/class-magazine-pro-woocommerce.php';

			require get_template_directory() . '/inc/woocommerce/woocommerce-template-functions.php';
		}
	}

	/**
	 * Initialize Customizer
	 *
	 * @return void
	 */
	public function customizer_init() {

		$magazine_pro_customizer = new Magazine_Pro_Customize();
	}

	/**
	 * Initialize Post Meta
	 *
	 * @return void
	 */
	public function post_meta_init() {

		$magazine_pro_post_meta = new Magazine_Pro_Post_Meta();
	}

	/**
	 * Initialize Widgets
	 *
	 * @return void
	 */
	public function widget_init() {

		$magazine_pro_widget = new Magazine_Pro_Widget_Init();
	}

	/**
	 * Initialize Woocommerce
	 *
	 * @return void
	 */
	public function woocommerce_init() {

		if( class_exists( 'Woocommerce' ) ) {

			$magazine_pro_woocommerce = new Magazine_Pro_Woocommerce();
		}
	}

	/**
	 * Custom Search Form
	 *
	 * @return void
	 */
	public function search_form() {

		$form = '<form role="search" method="get" id="search-form" class="clearfix" action="' . esc_url( home_url( '/' ) ) . '"><input type="search" name="s" placeholder="' . esc_attr__( 'Type Here', 'magazine-pro' ) . '" value"' . get_search_query() . '" ><input type="submit" id="submit" value="'. esc_attr__( 'Search', 'magazine-pro' ).'"></form>';

        return $form;
	}
}