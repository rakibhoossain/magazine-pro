<?php
/**
 * Singleton class for handling the theme's customizer integration.
 *
 * @since  1.0.0
 * @access public
 */
if( ! class_exists( 'Magazine_Pro_Customize' ) ) {

	class Magazine_Pro_Customize {

		/**
		 * Constructor method.
		 *
		 * @since  1.0.0
		 * @access private
		 * @return void
		 */
		public function __construct() {
			
			$this->setup_actions();
		}

		/**
		 * Sets up initial actions.
		 *
		 * @since  1.0.0
		 * @access private
		 * @return void
		 */
		public function setup_actions() {

			// Register panels, sections, settings, controls, and partials.
			add_action( 'customize_register', array( $this, 'register_panels'   ) );
			add_action( 'customize_register', array( $this, 'register_sections' ) );
			add_action( 'customize_register', array( $this, 'register_settings' ) );
			add_action( 'customize_register', array( $this, 'register_controls' ) );
			add_action( 'customize_register', array( $this, 'add_partials' ) );
			add_action( 'wp_head', array( $this, 'dynamic_style' ) );

			// Register scripts and styles for the controls.
			add_action( 'customize_controls_enqueue_scripts', array( $this, 'customizer_scripts' ), 0 );

			// Enqueue scripts and styles for the preview.
			add_action( 'customize_preview_init', array( $this, 'customize_preview_js' ) );
		}

		/**
		 * Sets up the customizer panels.
		 *
		 * @since  1.0.0
		 * @access public
		 * @param  object  $wp_customize
		 * @return void
		 */
		public function register_panels( $wp_customize ) {

			// Home Page Customization Panel
			$wp_customize->add_panel(
				'magazine_pro_homepage_customization',
				array(
					'title' => esc_html__( 'Home Customization', 'magazine-pro' ),
					'description' => esc_html__( 'Magazine Pro Home Page Customization. Set Options For Home Page Customization.', 'magazine-pro' ),
					'priority' => 10,
				)
			);

			// Theme Customization Panel
			$wp_customize->add_panel(
				'magazine_pro_theme_customization',
				array(
					'title' => esc_html__( 'Theme Customization', 'magazine-pro' ),
					'description' => esc_html__( 'Magazine Pro Customization. Set Options For Theme Customization.', 'magazine-pro' ),
					'priority' => 10,
				)
			);

			// Theme Color Customization Panel
			$wp_customize->add_panel(
				'magazine_pro_color_customization',
				array(
					'title' => esc_html__( 'Color Customization', 'magazine-pro' ),
					'description' => esc_html__( 'Magazine Pro Color Customization. Set Colors For Theme Color Customization.', 'magazine-pro' ),
					'priority' => 10,
				)
			);
		}

		/**
		 * Sets up the customizer sections.
		 *
		 * @since  1.0.0
		 * @access public
		 * @param  object  $wp_customize
		 * @return void
		 */
		public function register_sections( $wp_customize ) {

			$wp_customize->get_control( 'header_textcolor' )->section = 'title_tagline';
			$wp_customize->get_control( 'background_color' )->section = 'background_image';
			$wp_customize->get_control( 'header_textcolor' )->label = esc_html__( 'Site Title Color', 'magazine-pro' );

			$wp_customize->get_section( 'background_image' )->title = esc_html__( 'Site Background', 'magazine-pro' );

			// // Upsell Class
			// require get_template_directory() . '/inc/customizer/upgrade-to-pro/upgrade.php';

			// $wp_customize->register_section_type( 'Magazine_Pro_Customize_Section_Upsell' );

			// // Register sections.
			// $wp_customize->add_section(
			// 	new Magazine_Pro_Customize_Section_Upsell(
			// 		$wp_customize,
			// 		'theme_upsell',
			// 		array(
			// 			'title'    => esc_html__( 'Magazine Pro Pro', 'magazine-pro' ),
			// 			'pro_text' => esc_html__( 'Get Pro', 'magazine-pro' ),
			// 			'pro_url'  => 'https://themebeez.com/themes/magazine_pro-pro/?ref=cm-upsell-button',
			// 			'priority' => 1,
			// 		)
			// 	)
			// );

			// Section - Site Layout
			$wp_customize->add_section( 
				'magazine_pro_site_layout_options', 
				array(
					'title'			=> esc_html__( 'Site Layout', 'magazine-pro' ),
					'priority'		=> 10,
				) 
			);

			// Section - Ticker
			$wp_customize->add_section( 
				'magazine_pro_ticker_news_options', 
				array(
					'title'			=> esc_html__( 'Ticker News', 'magazine-pro' ),
					'description'	=> esc_html__( 'Set and select options to configure ticker news section.', 'magazine-pro' ),
					'panel'			=> 'magazine_pro_homepage_customization',	
				) 
			);

			// Section - Banner
			$wp_customize->add_section( 
				'magazine_pro_banner_options', 
				array(
					'title'			=> esc_html__( 'Banner/Slider', 'magazine-pro' ),
					'description' => esc_html__( 'Set and select options to configure banner/slider section.', 'magazine-pro' ),
					'panel'			=> 'magazine_pro_homepage_customization',
				) 
			);

			// Homepage Sidebar
			$wp_customize->add_section( 
				'magazine_pro_homepage_sidebar_options', 
				array(
					'title'			=> esc_html__( 'Homepage Sidebar', 'magazine-pro' ),
					'panel'			=> 'magazine_pro_homepage_customization',
				) 
			);

			// Header Options
			$wp_customize->add_section( 
				'magazine_pro_header_options', 
				array(
					'title'			=> esc_html__( 'Header', 'magazine-pro' ),
					'panel'			=> 'magazine_pro_theme_customization',
				) 
			);

			// Footer Options
			$wp_customize->add_section( 
				'magazine_pro_footer_options', 
				array(
					'title'			=> esc_html__( 'Footer', 'magazine-pro' ),
					'panel'			=> 'magazine_pro_theme_customization',
				) 
			);

			// Blog Page Options
			$wp_customize->add_section( 
				'magazine_pro_blog_page_options', 
				array(
					'title'			=> esc_html__( 'Blog Page', 'magazine-pro' ),
					'panel'			=> 'magazine_pro_theme_customization',
				) 
			);

			// Archive Page Options
			$wp_customize->add_section( 
				'magazine_pro_archive_page_options', 
				array(
					'title'			=> esc_html__( 'Archive Page', 'magazine-pro' ),
					'panel'			=> 'magazine_pro_theme_customization',
				) 
			);

			// Search Page Options
			$wp_customize->add_section( 
				'magazine_pro_search_page_options', 
				array(
					'title'			=> esc_html__( 'Search Page', 'magazine-pro' ),
					'panel'			=> 'magazine_pro_theme_customization',
				) 
			);

			// Single Post Options
			$wp_customize->add_section( 
				'magazine_pro_single_post_options', 
				array(
					'title'			=> esc_html__( 'Single Post', 'magazine-pro' ),
					'panel'			=> 'magazine_pro_theme_customization',
				) 
			);

			// Post Meta Options
			$wp_customize->add_section( 
				'magazine_pro_post_meta_options', 
				array(
					'title'			=> esc_html__( 'Global Post Meta', 'magazine-pro' ),
					'description'	=> esc_html__( 'These options lets you control post metas globally i.e. once you change option here, this will be reflected on all pages.', 'magazine-pro' ),
					'panel'			=> 'magazine_pro_theme_customization',
				) 
			);

			// Excerpt Options
			$wp_customize->add_section( 
				'magazine_pro_post_excerpt_options', 
				array(
					'title'			=> esc_html__( 'Post Excerpt', 'magazine-pro' ),
					'description'	=> esc_html__( 'Post Excerpt is the number of words of content which are displayed instead of full content. You can control the number of words to be displyed in this section.', 'magazine-pro' ),
					'panel'			=> 'magazine_pro_theme_customization',
				) 
			);

			// Social Links
			$wp_customize->add_section( 
				'magazine_pro_social_links_options', 
				array(
					'title'			=> esc_html__( 'Social Links', 'magazine-pro' ),
					'panel'			=> 'magazine_pro_theme_customization',
				) 
			);

			// Breadcrumb Options
			$wp_customize->add_section( 
				'magazine_pro_breadcrumb_options', 
				array(
					'title'			=> esc_html__( 'Breadcrumb', 'magazine-pro' ),
					'panel'			=> 'magazine_pro_theme_customization',
				) 
			);

			// Sidebar Options
			$wp_customize->add_section( 
				'magazine_pro_sidebar_options', 
				array(
					'title'			=> esc_html__( 'Sidebar', 'magazine-pro' ),
					'panel'			=> 'magazine_pro_theme_customization',
				) 
			);


			// Site Image Options
			$wp_customize->add_section( 
				'magazine_pro_site_image_options', 
				array(
					'title'			=> esc_html__( 'Site Image', 'magazine-pro' ),
					'panel'			=> 'magazine_pro_theme_customization',
				) 
			);

			// Theme Color
			$wp_customize->add_section( 
				'magazine_pro_theme_color_options', 
				array(
					'title'			=> esc_html__( 'Theme Color', 'magazine-pro' ),
					'panel'			=> 'magazine_pro_color_customization',
				) 
			);

			if( class_exists( 'Woocommerce' ) ) {

				// Sidebar Postion For Woocommerce Pages
				$wp_customize->add_section( 
					'magazine_pro_woocommerce_sidebar_position', 
					array(
						'title'			=> esc_html__( 'Woocommerce Sidebar Position', 'magazine-pro' ),
						'panel'			=> 'woocommerce',
					) 
				);
			}		
		}

		/**
		 * Sets up the customizer settings.
		 *
		 * @since  1.0.0
		 * @access public
		 * @param  object  $wp_customize
		 * @return void
		 */
		public function register_settings( $wp_customize ) {

			// Dropdown Taxonomies
			require get_template_directory() . '/inc/customizer/functions/sanitize-callback.php';

			// Set the transport property of existing settings.
			$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
			$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
			$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

			$defaults = magazine_pro_get_default_theme_options();	

			// Show Ticker News
			$wp_customize->add_setting( 
				'magazine_pro_select_site_layout', 
				array(
					'sanitize_callback'		=> 'magazine_pro_sanitize_select',
					'default'				=> $defaults['magazine_pro_select_site_layout'], 
				) 
			);

			// Show Ticker News
			$wp_customize->add_setting( 
				'magazine_pro_enable_ticker_news', 
				array(
					'sanitize_callback'		=> 'wp_validate_boolean',
					'default'				=> $defaults['magazine_pro_enable_ticker_news'], 
				) 
			);	

			// Ticker News Title
			$wp_customize->add_setting( 
				'magazine_pro_ticker_news_title', 
				array(
					'sanitize_callback'		=> 'sanitize_text_field',
					'default'				=> $defaults['magazine_pro_ticker_news_title'], 
				) 
			);

			// Ticker News Cateogries
			$wp_customize->add_setting( 
				'magazine_pro_ticker_news_categories', 
				array(
					'sanitize_callback' => 'magazine_pro_sanitize_multiple_cat_select',
				) 
			);

			// Ticker News No
			$wp_customize->add_setting( 
				'magazine_pro_ticker_news_posts_no', 
				array(
					'sanitize_callback'		=> 'magazine_pro_sanitize_number',
					'default'				=> $defaults['magazine_pro_ticker_news_posts_no'], 
				) 
			);

			// Enable Banner/Slider
			$wp_customize->add_setting( 
				'magazine_pro_enable_banner', 
				array(
					'sanitize_callback'	=> 'wp_validate_boolean',
					'default'			=> $defaults['magazine_pro_enable_banner'],
				) 
			);

			// Banner Cateogries
			$wp_customize->add_setting( 
				'magazine_pro_banner_categories', 
				array(
					'sanitize_callback' => 'magazine_pro_sanitize_multiple_cat_select',
				) 
			);

			// Banner Posts No
			$wp_customize->add_setting( 
				'magazine_pro_banner_posts_no', 
				array(
					'sanitize_callback'		=> 'magazine_pro_sanitize_number',
					'default'				=> $defaults['magazine_pro_banner_posts_no'], 
				) 
			);

			// Banner Enable Author Meta
			$wp_customize->add_setting( 
				'magazine_pro_enable_banner_author_meta', 
				array(
					'sanitize_callback'	=> 'wp_validate_boolean',
					'default'			=> $defaults['magazine_pro_enable_banner_author_meta'],
				) 
			);

			// Banner Enable Date Meta
			$wp_customize->add_setting( 
				'magazine_pro_enable_banner_date_meta', 
				array(
					'sanitize_callback'	=> 'wp_validate_boolean',
					'default'			=> $defaults['magazine_pro_enable_banner_date_meta'],
				) 
			);

			// Banner Enable Comment Meta
			$wp_customize->add_setting( 
				'magazine_pro_enable_banner_cmnts_no_meta', 
				array(
					'sanitize_callback'	=> 'wp_validate_boolean',
					'default'			=> $defaults['magazine_pro_enable_banner_cmnts_no_meta'],
				) 
			);

			// Banner Enable Category Meta
			$wp_customize->add_setting( 
				'magazine_pro_enable_banner_categories_meta', 
				array(
					'sanitize_callback'	=> 'wp_validate_boolean',
					'default'			=> $defaults['magazine_pro_enable_banner_categories_meta'],
				) 
			);

			// Homepage Sidebar Position
			$wp_customize->add_setting( 
				'magazine_pro_homepage_sidebar', 
				array(
					'sanitize_callback'	=> 'magazine_pro_sanitize_select',
					'default'			=> $defaults['magazine_pro_homepage_sidebar'],
				) 
			);

			// Enable Top Header
			$wp_customize->add_setting( 
				'magazine_pro_enable_top_header', 
				array(
					'sanitize_callback'	=> 'wp_validate_boolean',
					'default'			=> $defaults['magazine_pro_enable_top_header'],
				) 
			);

			// Enable Home Button
			$wp_customize->add_setting( 
				'magazine_pro_enable_home_button', 
				array(
					'sanitize_callback'	=> 'wp_validate_boolean',
					'default'			=> $defaults['magazine_pro_enable_home_button'],
				) 
			);

			// Enable Search Button
			$wp_customize->add_setting( 
				'magazine_pro_enable_search_button', 
				array(
					'sanitize_callback'	=> 'wp_validate_boolean',
					'default'			=> $defaults['magazine_pro_enable_search_button'],
				) 
			);

			// Select Header Layout
			$wp_customize->add_setting( 
				'magazine_pro_select_header_layout', 
				array(
					'sanitize_callback'	=> 'magazine_pro_sanitize_select',
					'default'			=> $defaults['magazine_pro_select_header_layout'],
				) 
			);

			// Header Mask Color
			$wp_customize->add_setting( 
				'magazine_pro_header_overlay_color', 
				array(
					'sanitize_callback'	=> 'sanitize_text_field',
					'default'			=> $defaults['magazine_pro_header_overlay_color'],
				) 
			);

			// Coyright & Credit Text
			$wp_customize->add_setting( 
				'magazine_pro_copyright_credit', 
				array(
					'sanitize_callback'	=> 'sanitize_text_field',
					'default'			=> $defaults['magazine_pro_copyright_credit'],
				) 
			);

			// Blog Page Enable Author Meta
			$wp_customize->add_setting( 
				'magazine_pro_enable_blog_author_meta', 
				array(
					'sanitize_callback'	=> 'wp_validate_boolean',
					'default'			=> $defaults['magazine_pro_enable_blog_author_meta'],
				) 
			);

			// Blog Page Enable Date Meta
			$wp_customize->add_setting( 
				'magazine_pro_enable_blog_date_meta', 
				array(
					'sanitize_callback'	=> 'wp_validate_boolean',
					'default'			=> $defaults['magazine_pro_enable_blog_date_meta'],
				) 
			);

			// Blog Page Enable Comment Meta
			$wp_customize->add_setting( 
				'magazine_pro_enable_blog_cmnts_no_meta', 
				array(
					'sanitize_callback'	=> 'wp_validate_boolean',
					'default'			=> $defaults['magazine_pro_enable_blog_cmnts_no_meta'],
				) 
			);

			// Blog Page Enable Category Meta
			$wp_customize->add_setting( 
				'magazine_pro_enable_blog_categories_meta', 
				array(
					'sanitize_callback'	=> 'wp_validate_boolean',
					'default'			=> $defaults['magazine_pro_enable_blog_categories_meta'],
				) 
			);

			// Select Sidebar Position For Blog Page
			$wp_customize->add_setting( 
				'magazine_pro_select_blog_sidebar_position', 
				array(
					'sanitize_callback'	=> 'magazine_pro_sanitize_select',
					'default'			=> $defaults['magazine_pro_select_blog_sidebar_position'],
				) 
			);


			// Archive Page Enable Author Meta
			$wp_customize->add_setting( 
				'magazine_pro_enable_archive_author_meta', 
				array(
					'sanitize_callback'	=> 'wp_validate_boolean',
					'default'			=> $defaults['magazine_pro_enable_archive_author_meta'],
				) 
			);

			// Archive Page Enable Date Meta
			$wp_customize->add_setting( 
				'magazine_pro_enable_archive_date_meta', 
				array(
					'sanitize_callback'	=> 'wp_validate_boolean',
					'default'			=> $defaults['magazine_pro_enable_archive_date_meta'],
				) 
			);

			// Archive Page Enable Comment Meta
			$wp_customize->add_setting( 
				'magazine_pro_enable_archive_cmnts_no_meta', 
				array(
					'sanitize_callback'	=> 'wp_validate_boolean',
					'default'			=> $defaults['magazine_pro_enable_archive_cmnts_no_meta'],
				) 
			);

			// Archive Page Enable Category Meta
			$wp_customize->add_setting( 
				'magazine_pro_enable_archive_categories_meta', 
				array(
					'sanitize_callback'	=> 'wp_validate_boolean',
					'default'			=> $defaults['magazine_pro_enable_archive_categories_meta'],
				) 
			);

			// Select Sidebar Position For Archive Page
			$wp_customize->add_setting( 
				'magazine_pro_select_archive_sidebar_position', 
				array(
					'sanitize_callback'	=> 'magazine_pro_sanitize_select',
					'default'			=> $defaults['magazine_pro_select_archive_sidebar_position'],
				) 
			);


			// Search Page Enable Author Meta
			$wp_customize->add_setting( 
				'magazine_pro_enable_search_author_meta', 
				array(
					'sanitize_callback'	=> 'wp_validate_boolean',
					'default'			=> $defaults['magazine_pro_enable_search_author_meta'],
				) 
			);

			// Search Page Enable Date Meta
			$wp_customize->add_setting( 
				'magazine_pro_enable_search_date_meta', 
				array(
					'sanitize_callback'	=> 'wp_validate_boolean',
					'default'			=> $defaults['magazine_pro_enable_search_date_meta'],
				) 
			);

			// Search Page Enable Comment Meta
			$wp_customize->add_setting( 
				'magazine_pro_enable_search_cmnts_no_meta', 
				array(
					'sanitize_callback'	=> 'wp_validate_boolean',
					'default'			=> $defaults['magazine_pro_enable_search_cmnts_no_meta'],
				) 
			);

			// Search Page Enable Category Meta
			$wp_customize->add_setting( 
				'magazine_pro_enable_search_categories_meta', 
				array(
					'sanitize_callback'	=> 'wp_validate_boolean',
					'default'			=> $defaults['magazine_pro_enable_search_categories_meta'],
				) 
			);

			// Select Sidebar Position For Search Page
			$wp_customize->add_setting( 
				'magazine_pro_select_search_sidebar_position', 
				array(
					'sanitize_callback'	=> 'magazine_pro_sanitize_select',
					'default'			=> $defaults['magazine_pro_select_search_sidebar_position'],
				) 
			);


			// Post Single Enable Author Meta
			$wp_customize->add_setting( 
				'magazine_pro_enable_post_single_author_meta', 
				array(
					'sanitize_callback'	=> 'wp_validate_boolean',
					'default'			=> $defaults['magazine_pro_enable_post_single_author_meta'],
				) 
			);

			// Post Single Enable Date Meta
			$wp_customize->add_setting( 
				'magazine_pro_enable_post_single_date_meta', 
				array(
					'sanitize_callback'	=> 'wp_validate_boolean',
					'default'			=> $defaults['magazine_pro_enable_post_single_date_meta'],
				) 
			);

			// Post Single Enable Comment Meta
			$wp_customize->add_setting( 
				'magazine_pro_enable_post_single_cmnts_no_meta', 
				array(
					'sanitize_callback'	=> 'wp_validate_boolean',
					'default'			=> $defaults['magazine_pro_enable_post_single_cmnts_no_meta'],
				) 
			);

			// Post Single Enable Tags Meta
			$wp_customize->add_setting( 
				'magazine_pro_enable_post_single_tags_meta', 
				array(
					'sanitize_callback'	=> 'wp_validate_boolean',
					'default'			=> $defaults['magazine_pro_enable_post_single_tags_meta'],
				) 
			);

			// Post Single Enable Featured Image
			$wp_customize->add_setting( 
				'magazine_pro_enable_post_single_featured_image', 
				array(
					'sanitize_callback'	=> 'wp_validate_boolean',
					'default'			=> $defaults['magazine_pro_enable_post_single_featured_image'],
				) 
			);

			// Post Single Enable Author Section
			$wp_customize->add_setting( 
				'magazine_pro_enable_author_section', 
				array(
					'sanitize_callback'	=> 'wp_validate_boolean',
					'default'			=> $defaults['magazine_pro_enable_author_section'],
				) 
			);

			// Post Single Enable Related Section
			$wp_customize->add_setting( 
				'magazine_pro_enable_related_section', 
				array(
					'sanitize_callback'	=> 'wp_validate_boolean',
					'default'			=> $defaults['magazine_pro_enable_related_section'],
				) 
			);

			// Post Single Related Section Title
			$wp_customize->add_setting( 
				'magazine_pro_related_section_title', 
				array(
					'sanitize_callback'	=> 'sanitize_text_field',
					'default'			=> $defaults['magazine_pro_related_section_title'],
				) 
			);

			// Post Single Related Section Posts No
			$wp_customize->add_setting( 
				'magazine_pro_related_section_posts_number', 
				array(
					'sanitize_callback'		=> 'magazine_pro_sanitize_number',
					'default'				=> $defaults['magazine_pro_related_section_posts_number'], 
				) 
			);

			// Post Single Related Section Enable Author Meta
			$wp_customize->add_setting( 
				'magazine_pro_enable_related_section_author_meta', 
				array(
					'sanitize_callback'	=> 'wp_validate_boolean',
					'default'			=> $defaults['magazine_pro_enable_related_section_author_meta'],
				) 
			);

			// Post Single Related Section Enable Date Meta
			$wp_customize->add_setting( 
				'magazine_pro_enable_related_section_date_meta', 
				array(
					'sanitize_callback'	=> 'wp_validate_boolean',
					'default'			=> $defaults['magazine_pro_enable_related_section_date_meta'],
				) 
			);

			// Post Single Related Section Enable Comment Meta
			$wp_customize->add_setting( 
				'magazine_pro_enable_related_section_cmnts_no_meta', 
				array(
					'sanitize_callback'	=> 'wp_validate_boolean',
					'default'			=> $defaults['magazine_pro_enable_related_section_cmnts_no_meta'],
				) 
			);

			// Post Single Related Section Enable Category Meta
			$wp_customize->add_setting( 
				'magazine_pro_enable_related_section_categories_meta', 
				array(
					'sanitize_callback'	=> 'wp_validate_boolean',
					'default'			=> $defaults['magazine_pro_enable_related_section_categories_meta'],
				) 
			);

			// Enable Author Meta
			$wp_customize->add_setting( 
				'magazine_pro_enable_author_meta', 
				array(
					'sanitize_callback'	=> 'wp_validate_boolean',
					'default'			=> $defaults['magazine_pro_enable_author_meta'],
				) 
			);

			// Enable Date Meta
			$wp_customize->add_setting( 
				'magazine_pro_enable_date_meta', 
				array(
					'sanitize_callback'	=> 'wp_validate_boolean',
					'default'			=> $defaults['magazine_pro_enable_date_meta'],
				) 
			);

			// Enable Comment Meta
			$wp_customize->add_setting( 
				'magazine_pro_enable_comment_meta', 
				array(
					'sanitize_callback'	=> 'wp_validate_boolean',
					'default'			=> $defaults['magazine_pro_enable_comment_meta'],
				) 
			);

			// Enable Tag Meta
			$wp_customize->add_setting( 
				'magazine_pro_enable_tag_meta', 
				array(
					'sanitize_callback'	=> 'wp_validate_boolean',
					'default'			=> $defaults['magazine_pro_enable_tag_meta'],
				) 
			);

			// Enable Category Meta
			$wp_customize->add_setting( 
				'magazine_pro_enable_category_meta', 
				array(
					'sanitize_callback'	=> 'wp_validate_boolean',
					'default'			=> $defaults['magazine_pro_enable_category_meta'],
				) 
			);

			// Excerpt Length
			$wp_customize->add_setting( 
				'magazine_pro_post_excerpt_length', 
				array(
					'sanitize_callback'		=> 'magazine_pro_sanitize_number',
					'default'				=> $defaults['magazine_pro_post_excerpt_length'], 
				) 
			);

			// Social Link - Facebook
			$wp_customize->add_setting( 
				'magazine_pro_facebook_link', 
				array(
					'sanitize_callback'		=> 'esc_url_raw',
					'default'				=> $defaults['magazine_pro_facebook_link'], 
				) 
			);

			// Social Link - Twitter
			$wp_customize->add_setting( 
				'magazine_pro_twitter_link', 
				array(
					'sanitize_callback'		=> 'esc_url_raw',
					'default'				=> $defaults['magazine_pro_twitter_link'], 
				) 
			);

			// Social Link - Instagram
			$wp_customize->add_setting( 
				'magazine_pro_instagram_link', 
				array(
					'sanitize_callback'		=> 'esc_url_raw',
					'default'				=> $defaults['magazine_pro_instagram_link'], 
				) 
			);

			// Social Link - Youtube
			$wp_customize->add_setting( 
				'magazine_pro_youtube_link', 
				array(
					'sanitize_callback'		=> 'esc_url_raw',
					'default'				=> $defaults['magazine_pro_youtube_link'], 
				) 
			);

			// Social Link - VK
			$wp_customize->add_setting( 
				'magazine_pro_vk_link', 
				array(
					'sanitize_callback'		=> 'esc_url_raw',
					'default'				=> $defaults['magazine_pro_vk_link'], 
				) 
			);

			// Social Link - Linkedin
			$wp_customize->add_setting( 
				'magazine_pro_linkedin_link', 
				array(
					'sanitize_callback'		=> 'esc_url_raw',
					'default'				=> $defaults['magazine_pro_linkedin_link'], 
				) 
			);

			// Social Link - Vimeo
			$wp_customize->add_setting( 
				'magazine_pro_vimeo_link', 
				array(
					'sanitize_callback'		=> 'esc_url_raw',
					'default'				=> $defaults['magazine_pro_vimeo_link'], 
				) 
			);

			// Enable Breadcrumb
			$wp_customize->add_setting( 
				'magazine_pro_enable_breadcrumb', 
				array(
					'sanitize_callback'	=> 'wp_validate_boolean',
					'default'			=> $defaults['magazine_pro_enable_breadcrumb'],
				) 
			);

			// Enable Scroll Top Button
			$wp_customize->add_setting( 
				'magazine_pro_enable_scroll_top_button', 
				array(
					'sanitize_callback'	=> 'wp_validate_boolean',
					'default'			=> $defaults['magazine_pro_enable_scroll_top_button'],
				) 
			);

			// Enable Sticky Sidebar
			$wp_customize->add_setting( 
				'magazine_pro_enable_sticky_sidebar', 
				array(
					'sanitize_callback'	=> 'wp_validate_boolean',
					'default'			=> $defaults['magazine_pro_enable_sticky_sidebar'],
				) 
			);


			// Enable Lazy Load
			$wp_customize->add_setting( 
				'magazine_pro_enable_lazy_load', 
				array(
					'sanitize_callback'	=> 'wp_validate_boolean',
					'default'			=> $defaults['magazine_pro_enable_lazy_load'],
				) 
			);

			// Set Primary Theme Color
			$wp_customize->add_setting( 
				'magazine_pro_primary_theme_color', 
				array(
					'sanitize_callback'	=> 'sanitize_text_field',
					'default'			=> $defaults['magazine_pro_primary_theme_color'],
				) 
			);

			if( class_exists( 'Woocommerce' ) ) {

				// Select Sidebar Position For Woocommerce Pages
				$wp_customize->add_setting( 
					'magazine_pro_select_woocommerce_sidebar_position', 
					array(
						'sanitize_callback'	=> 'magazine_pro_sanitize_select',
						'default'			=> $defaults['magazine_pro_select_woocommerce_sidebar_position'],
					) 
				);
			}
		}

		/**
		 * Sets up the customizer controls.
		 *
		 * @since  1.0.0
		 * @access public
		 * @param  object  $wp_customize
		 * @return void
		 */
		public function register_controls( $wp_customize ) {

			// Multiple Select Dropdown Taxonomies
			require get_template_directory() . '/inc/customizer/controls/class-magazine-pro-multiple-select-dropdown-taxonomies.php';
			// Radio Image Control
			require get_template_directory() . '/inc/customizer/controls/class-magazine-pro-radio-image-control.php';
			// Alpha Color Picker Control
			require get_template_directory() . '/inc/customizer/controls/class-magazine-pro-alpha-color-picker-control.php';

			// Select Site Layout
			$wp_customize->add_control( 
				'magazine_pro_select_site_layout', 
				array(
					'label'				=> esc_html__( 'Select Site Layout', 'magazine-pro' ),
					'section'			=> 'magazine_pro_site_layout_options',
					'type'				=> 'select',
					'choices'			=> array(
						'boxed' => esc_html__( 'Boxed Layout', 'magazine-pro' ),
						'fullwidth' => esc_html__( 'Fullwidth Layout', 'magazine-pro' )
					), 
				) 
			);

			// Show Ticker News
			$wp_customize->add_control( 
				'magazine_pro_enable_ticker_news', 
				array(
					'label' => esc_html__( 'Enable Ticker News', 'magazine-pro' ),
					'description' => esc_html__( 'This option will be effective only for the ticker news section that is displayed below the header section.', 'magazine-pro' ),
					'section' => 'magazine_pro_ticker_news_options',
					'type' => 'checkbox',
				) 
			);

			// Ticker News Title
			$wp_customize->add_control( 
				'magazine_pro_ticker_news_title', 
				array(
					'label' => esc_html__( 'Ticker News: Section Title', 'magazine-pro' ),
					'section' => 'magazine_pro_ticker_news_options',
					'type' => 'text',
					'active_callback' => 'magazine_pro_is_ticker_news_enabled',
				) 
			);

			// Ticker News Cateogries
			$wp_customize->add_control( 
				new Magazine_Pro_Multiple_Select_Dropdown_Taxonomies( 
					$wp_customize, 'magazine_pro_ticker_news_categories', 
					array(
						'label'	=> esc_html__( 'Ticker News: Categories', 'magazine-pro' ),
						'section' => 'magazine_pro_ticker_news_options',
						'choices' => $this->get_category_taxonomies(),
						'active_callback' => 'magazine_pro_is_ticker_news_enabled',
					) 
				) 
			);

			// Ticker News Posts No
			$wp_customize->add_control( 
				'magazine_pro_ticker_news_posts_no', 
				array(
					'label' => esc_html__( 'Ticker News: Posts Number', 'magazine-pro' ),
					'section' => 'magazine_pro_ticker_news_options',
					'type' => 'number',
					'active_callback' => 'magazine_pro_is_ticker_news_enabled',
				) 
			);

			// Banner - Enable Banner
			$wp_customize->add_control( 
				'magazine_pro_enable_banner', 
				array(
					'label'				=> esc_html__( 'Enable Banner/Slider', 'magazine-pro' ),
					'section'			=> 'magazine_pro_banner_options',
					'type'				=> 'checkbox' 
				) 
			);

			// Banner - Enable Author Meta
			$wp_customize->add_control( 
				'magazine_pro_enable_banner_author_meta', 
				array(
					'label'				=> esc_html__( 'Enable Post Author Meta', 'magazine-pro' ),
					'section'			=> 'magazine_pro_banner_options',
					'type'				=> 'checkbox' 
				) 
			);

			// Banner - Enable Date Meta
			$wp_customize->add_control( 
				'magazine_pro_enable_banner_date_meta', 
				array(
					'label'				=> esc_html__( 'Enable Posted Date Meta', 'magazine-pro' ),
					'section'			=> 'magazine_pro_banner_options',
					'type'				=> 'checkbox' 
				) 
			);

			// Banner - Enable Comment Meta
			$wp_customize->add_control( 
				'magazine_pro_enable_banner_cmnts_no_meta', 
				array(
					'label'				=> esc_html__( 'Enable Post Comments Number Meta', 'magazine-pro' ),
					'section'			=> 'magazine_pro_banner_options',
					'type'				=> 'checkbox' 
				) 
			);

			// Banner - Enable Category Meta
			$wp_customize->add_control( 
				'magazine_pro_enable_banner_categories_meta', 
				array(
					'label'				=> esc_html__( 'Enable Post Categories Meta', 'magazine-pro' ),
					'section'			=> 'magazine_pro_banner_options',
					'type'				=> 'checkbox' 
				) 
			);

			// Banner - Banner Element Cateogries
			$wp_customize->add_control( 
				new Magazine_Pro_Multiple_Select_Dropdown_Taxonomies( 
					$wp_customize, 'magazine_pro_banner_categories', 
					array(
						'label'	=> esc_html__( 'Banner/Slider Post Categories', 'magazine-pro' ),
						'section' => 'magazine_pro_banner_options',
						'choices' => $this->get_category_taxonomies(),
						'active_callback' => 'magazine_pro_is_banner_active',
					) 
				) 
			);

			// Banner - Element No
			$wp_customize->add_control( 
				'magazine_pro_banner_posts_no', 
				array(
					'label' => esc_html__( 'Banner/Slider Posts Number', 'magazine-pro' ),
					'section' => 'magazine_pro_banner_options',
					'type' => 'number',
					'active_callback' => 'magazine_pro_is_banner_active',
				) 
			);

			// Homepage Sidebar Position
			$wp_customize->add_control( 
				new Magazine_Pro_Radio_Image_Control( 
					$wp_customize,  
					'magazine_pro_homepage_sidebar', 
					array(
						'label'				=> esc_html__( 'Sidebar Position', 'magazine-pro' ),
						'section'			=> 'magazine_pro_homepage_sidebar_options',
						'type'				=> 'radio',
						'choices'			=> $this->get_homepage_sidebar(), 
					) 
				) 
			);

			// Enable Top Header
			$wp_customize->add_control( 
				'magazine_pro_enable_top_header', 
				array(
					'label'				=> esc_html__( 'Enable Top Header', 'magazine-pro' ),
					'section'			=> 'magazine_pro_header_options',
					'type'				=> 'checkbox',
					'active_callback'	=> 'magazine_pro_is_header_one_active',
				) 
			);

			// Enable Home Button
			$wp_customize->add_control( 
				'magazine_pro_enable_home_button', 
				array(
					'label'				=> esc_html__( 'Enable Home Button', 'magazine-pro' ),
					'section'			=> 'magazine_pro_header_options',
					'type'				=> 'checkbox' 
				) 
			);

			// Enable Search Button
			$wp_customize->add_control( 
				'magazine_pro_enable_search_button', 
				array(
					'label'				=> esc_html__( 'Enable Search Button', 'magazine-pro' ),
					'section'			=> 'magazine_pro_header_options',
					'type'				=> 'checkbox' 
				) 
			);

			// Select Header Layout
			$wp_customize->add_control( 
				new Magazine_Pro_Radio_Image_Control( 
					$wp_customize,
					'magazine_pro_select_header_layout', 
					array(
						'label'				=> esc_html__( 'Select Header Layout', 'magazine-pro' ),
						'section'			=> 'magazine_pro_header_options',
						'type'				=> 'select',
						'choices'			=> $this->get_header_layout(), 
					) 
				)
			);

			// Menu Color - Set Home Icon Color
			$wp_customize->add_control( 
				new Magazine_Pro_Alpha_Color_Control( 
					$wp_customize, 
					'magazine_pro_header_overlay_color', 
					array(
						'label'		=> esc_html__( 'Header Overlay Color', 'magazine-pro' ),
						'section'	=> 'magazine_pro_header_options',
						'show_opacity' => true,
						'palette' => array( '#000', '#fff', '#df312c', '#df9a23', '#eef000', '#7ed934', '#1571c1', '#8309e7' ),
						'active_callback' => 'magazine_pro_is_header_two_active',
					) 
				) 
			);

			// Enable Scroll Top Button
			$wp_customize->add_control(
				'magazine_pro_enable_scroll_top_button', 
				array(
					'label'			=> esc_html__( 'Enable Scroll Top Button', 'magazine-pro' ),
					'section'		=> 'magazine_pro_footer_options',
					'type'			=> 'checkbox',
				) 
			);

			// Copyright & Credit
			$wp_customize->add_control( 
				'magazine_pro_copyright_credit', 
				array(
					'label'				=> esc_html__( 'Copyright Text', 'magazine-pro' ),
					'section'			=> 'magazine_pro_footer_options',
					'type'				=> 'text' 
				) 
			);

			// Blog - Enable Author Meta
			$wp_customize->add_control( 
				'magazine_pro_enable_blog_author_meta', 
				array(
					'label'				=> esc_html__( 'Enable Post Author Meta', 'magazine-pro' ),
					'section'			=> 'magazine_pro_blog_page_options',
					'type'				=> 'checkbox' 
				) 
			);

			// Blog - Enable Date Meta
			$wp_customize->add_control( 
				'magazine_pro_enable_blog_date_meta', 
				array(
					'label'				=> esc_html__( 'Enable Posted Date Meta', 'magazine-pro' ),
					'section'			=> 'magazine_pro_blog_page_options',
					'type'				=> 'checkbox' 
				) 
			);

			// Blog - Enable Comment Meta
			$wp_customize->add_control( 
				'magazine_pro_enable_blog_cmnts_no_meta', 
				array(
					'label'				=> esc_html__( 'Enable Post Comments Number Meta', 'magazine-pro' ),
					'section'			=> 'magazine_pro_blog_page_options',
					'type'				=> 'checkbox' 
				) 
			);

			// Blog - Enable Category Meta
			$wp_customize->add_control( 
				'magazine_pro_enable_blog_categories_meta', 
				array(
					'label'				=> esc_html__( 'Enable Post Categories Meta', 'magazine-pro' ),
					'section'			=> 'magazine_pro_blog_page_options',
					'type'				=> 'checkbox' 
				) 
			);

			// Blog - Select Sidebar Position
			$wp_customize->add_control( 
				new Magazine_Pro_Radio_Image_Control( 
					$wp_customize,
					'magazine_pro_select_blog_sidebar_position', 
					array(
						'label'				=> esc_html__( 'Select Sidebar Position', 'magazine-pro' ),
						'section'			=> 'magazine_pro_blog_page_options',
						'type'				=> 'select',
						'choices'			=> $this->get_sidebar_position(), 
					) 
				)
			);

			// Archive - Enable Author Meta
			$wp_customize->add_control( 
				'magazine_pro_enable_archive_author_meta', 
				array(
					'label'				=> esc_html__( 'Enable Post Author Meta', 'magazine-pro' ),
					'section'			=> 'magazine_pro_archive_page_options',
					'type'				=> 'checkbox' 
				) 
			);

			// Archive - Enable Date Meta
			$wp_customize->add_control( 
				'magazine_pro_enable_archive_date_meta', 
				array(
					'label'				=> esc_html__( 'Enable Posted Date Meta', 'magazine-pro' ),
					'section'			=> 'magazine_pro_archive_page_options',
					'type'				=> 'checkbox' 
				) 
			);

			// Archive - Enable Comment Meta
			$wp_customize->add_control( 
				'magazine_pro_enable_archive_cmnts_no_meta', 
				array(
					'label'				=> esc_html__( 'Enable Post Comments Number Meta', 'magazine-pro' ),
					'section'			=> 'magazine_pro_archive_page_options',
					'type'				=> 'checkbox' 
				) 
			);

			// Archive - Enable Category Meta
			$wp_customize->add_control( 
				'magazine_pro_enable_archive_categories_meta', 
				array(
					'label'				=> esc_html__( 'Enable Post Categories Meta', 'magazine-pro' ),
					'section'			=> 'magazine_pro_archive_page_options',
					'type'				=> 'checkbox' 
				) 
			);

			// Archive - Select Sidebar Position
			$wp_customize->add_control( 
				new Magazine_Pro_Radio_Image_Control( 
					$wp_customize,
					'magazine_pro_select_archive_sidebar_position', 
					array(
						'label'				=> esc_html__( 'Select Sidebar Position', 'magazine-pro' ),
						'section'			=> 'magazine_pro_archive_page_options',
						'type'				=> 'select',
						'choices'			=> $this->get_sidebar_position(), 
					) 
				)
			);

			// Search - Enable Author Meta
			$wp_customize->add_control( 
				'magazine_pro_enable_search_author_meta', 
				array(
					'label'				=> esc_html__( 'Enable Post Author Meta', 'magazine-pro' ),
					'section'			=> 'magazine_pro_search_page_options',
					'type'				=> 'checkbox' 
				) 
			);

			// Search - Enable Date Meta
			$wp_customize->add_control( 
				'magazine_pro_enable_search_date_meta', 
				array(
					'label'				=> esc_html__( 'Enable Posted Date Meta', 'magazine-pro' ),
					'section'			=> 'magazine_pro_search_page_options',
					'type'				=> 'checkbox' 
				) 
			);

			// Search - Enable Comment Meta
			$wp_customize->add_control( 
				'magazine_pro_enable_search_cmnts_no_meta', 
				array(
					'label'				=> esc_html__( 'Enable Post Comments Number Meta', 'magazine-pro' ),
					'section'			=> 'magazine_pro_search_page_options',
					'type'				=> 'checkbox' 
				) 
			);

			// Search - Enable Category Meta
			$wp_customize->add_control( 
				'magazine_pro_enable_search_categories_meta', 
				array(
					'label'				=> esc_html__( 'Enable Post Categories Meta', 'magazine-pro' ),
					'section'			=> 'magazine_pro_search_page_options',
					'type'				=> 'checkbox' 
				) 
			);

			// Search - Select Sidebar Position
			$wp_customize->add_control( 
				new Magazine_Pro_Radio_Image_Control( 
					$wp_customize,
					'magazine_pro_select_search_sidebar_position', 
					array(
						'label'				=> esc_html__( 'Select Sidebar Position', 'magazine-pro' ),
						'section'			=> 'magazine_pro_search_page_options',
						'type'				=> 'select',
						'choices'			=> $this->get_sidebar_position(), 
					) 
				)
			);


			// Post Single Enable Author Meta
			$wp_customize->add_control( 
				'magazine_pro_enable_post_single_author_meta', 
				array(
					'label'				=> esc_html__( 'Enable Post Author Meta', 'magazine-pro' ),
					'section'			=> 'magazine_pro_single_post_options',
					'type'				=> 'checkbox' 
				) 
			);

			// Post Single Enable Date Meta
			$wp_customize->add_control( 
				'magazine_pro_enable_post_single_date_meta', 
				array(
					'label'				=> esc_html__( 'Enable Posted Date Meta', 'magazine-pro' ),
					'section'			=> 'magazine_pro_single_post_options',
					'type'				=> 'checkbox' 
				) 
			);

			// Post Single Enable Comment Meta
			$wp_customize->add_control( 
				'magazine_pro_enable_post_single_cmnts_no_meta', 
				array(
					'label'				=> esc_html__( 'Enable Post Comments Number Meta', 'magazine-pro' ),
					'section'			=> 'magazine_pro_single_post_options',
					'type'				=> 'checkbox' 
				) 
			);

			// Post Single Enable Tag Meta
			$wp_customize->add_control( 
				'magazine_pro_enable_post_single_tags_meta', 
				array(
					'label'				=> esc_html__( 'Enable Post Tags Meta', 'magazine-pro' ),
					'section'			=> 'magazine_pro_single_post_options',
					'type'				=> 'checkbox' 
				) 
			);

			// Post Single Enable Featured Image
			$wp_customize->add_control( 
				'magazine_pro_enable_post_single_featured_image', 
				array(
					'label'				=> esc_html__( 'Enable Featured Image', 'magazine-pro' ),
					'section'			=> 'magazine_pro_single_post_options',
					'type'				=> 'checkbox' 
				) 
			);

			// Post Single Enable Author Section
			$wp_customize->add_control( 
				'magazine_pro_enable_author_section', 
				array(
					'label'				=> esc_html__( 'Enable Author Section', 'magazine-pro' ),
					'section'			=> 'magazine_pro_single_post_options',
					'type'				=> 'checkbox' 
				) 
			);

			// Post Single Enable Related Section
			$wp_customize->add_control( 
				'magazine_pro_enable_related_section', 
				array(
					'label'				=> esc_html__( 'Enable Related Posts Section', 'magazine-pro' ),
					'section'			=> 'magazine_pro_single_post_options',
					'type'				=> 'checkbox' 
				) 
			);

			// Post Single Related Section Title
			$wp_customize->add_control( 
				'magazine_pro_related_section_title', 
				array(
					'label'				=> esc_html__( 'Related Posts Section Title', 'magazine-pro' ),
					'section'			=> 'magazine_pro_single_post_options',
					'type'				=> 'text',
					'active_callback'	=> 'magazine_pro_is_related_section_active',
				) 
			);

			// Post Single Related Section Posts No
			$wp_customize->add_control( 
				'magazine_pro_related_section_posts_number', 
				array(
					'label' => esc_html__( 'Related Section Posts Number', 'magazine-pro' ),
					'section' => 'magazine_pro_single_post_options',
					'type' => 'number',
					'active_callback'	=> 'magazine_pro_is_related_section_active',
				) 
			);

			// Post Single Related Section - Enable Author Meta
			$wp_customize->add_control( 
				'magazine_pro_enable_related_section_author_meta', 
				array(
					'label'				=> esc_html__( 'Enable Post Author Meta', 'magazine-pro' ),
					'section'			=> 'magazine_pro_single_post_options',
					'type'				=> 'checkbox',
					'active_callback'	=> 'magazine_pro_is_related_section_active', 
				) 
			);

			// Post Single Related Section - Enable Date Meta
			$wp_customize->add_control( 
				'magazine_pro_enable_related_section_date_meta', 
				array(
					'label'				=> esc_html__( 'Enable Posted Date Meta', 'magazine-pro' ),
					'section'			=> 'magazine_pro_single_post_options',
					'type'				=> 'checkbox',
					'active_callback'	=> 'magazine_pro_is_related_section_active', 
				) 
			);

			// Post Single Related Section - Enable Comment Meta
			$wp_customize->add_control( 
				'magazine_pro_enable_related_section_cmnts_no_meta', 
				array(
					'label'				=> esc_html__( 'Enable Post Comments Number Meta', 'magazine-pro' ),
					'section'			=> 'magazine_pro_single_post_options',
					'type'				=> 'checkbox',
					'active_callback'	=> 'magazine_pro_is_related_section_active',  
				) 
			);

			// Post Single Related Section - Enable Category Meta
			$wp_customize->add_control( 
				'magazine_pro_enable_related_section_categories_meta', 
				array(
					'label'				=> esc_html__( 'Enable Post Categories Meta', 'magazine-pro' ),
					'section'			=> 'magazine_pro_single_post_options',
					'type'				=> 'checkbox',
					'active_callback'	=> 'magazine_pro_is_related_section_active', 
				) 
			);

			// Enable Author Meta
			$wp_customize->add_control( 
				'magazine_pro_enable_author_meta', 
				array(
					'label'				=> esc_html__( 'Enable Post Author Meta', 'magazine-pro' ),
					'section'			=> 'magazine_pro_post_meta_options',
					'type'				=> 'checkbox'
				) 
			);

			// Enable Date Meta
			$wp_customize->add_control( 
				'magazine_pro_enable_date_meta', 
				array(
					'label'				=> esc_html__( 'Enable Posted Date Meta', 'magazine-pro' ),
					'section'			=> 'magazine_pro_post_meta_options',
					'type'				=> 'checkbox' 
				) 
			);

			// Enable Comment Meta
			$wp_customize->add_control( 
				'magazine_pro_enable_comment_meta', 
				array(
					'label'				=> esc_html__( 'Enable Post Comments Number Meta', 'magazine-pro' ),
					'section'			=> 'magazine_pro_post_meta_options',
					'type'				=> 'checkbox' 
				) 
			);

			// Enable Category Meta
			$wp_customize->add_control( 
				'magazine_pro_enable_category_meta', 
				array(
					'label'				=> esc_html__( 'Enable Post Categories Meta', 'magazine-pro' ),
					'section'			=> 'magazine_pro_post_meta_options',
					'type'				=> 'checkbox' 
				) 
			);

			// Enable Tag Meta
			$wp_customize->add_control( 
				'magazine_pro_enable_tag_meta', 
				array(
					'label'				=> esc_html__( 'Enable Post Tags Meta', 'magazine-pro' ),
					'section'			=> 'magazine_pro_post_meta_options',
					'type'				=> 'checkbox' 
				) 
			);

			// Excerpt Length
			$wp_customize->add_control( 
				'magazine_pro_post_excerpt_length', 
				array(
					'label' => esc_html__( 'Excerpt Length', 'magazine-pro' ),
					'section' => 'magazine_pro_post_excerpt_options',
					'type' => 'number',
				) 
			);

			// Social Links - Facebook
			$wp_customize->add_control( 
				'magazine_pro_facebook_link', 
				array(
					'label' => esc_html__( 'Facebook Link', 'magazine-pro' ),
					'section' => 'magazine_pro_social_links_options',
					'type' => 'url',
				) 
			);

			// Social Links - Twitter
			$wp_customize->add_control( 
				'magazine_pro_twitter_link', 
				array(
					'label' => esc_html__( 'Twitter Link', 'magazine-pro' ),
					'section' => 'magazine_pro_social_links_options',
					'type' => 'url',
				) 
			);

			// Social Links - Instagram
			$wp_customize->add_control( 
				'magazine_pro_instagram_link', 
				array(
					'label' => esc_html__( 'Instagram Link', 'magazine-pro' ),
					'section' => 'magazine_pro_social_links_options',
					'type' => 'url',
				) 
			);

			// Social Links - Youtube
			$wp_customize->add_control( 
				'magazine_pro_youtube_link', 
				array(
					'label' => esc_html__( 'Youtube Link', 'magazine-pro' ),
					'section' => 'magazine_pro_social_links_options',
					'type' => 'url',
				) 
			);

			// Social Links - VK
			$wp_customize->add_control( 
				'magazine_pro_vk_link', 
				array(
					'label' => esc_html__( 'VK Link', 'magazine-pro' ),
					'section' => 'magazine_pro_social_links_options',
					'type' => 'url',
				) 
			);

			// Social Links - Linkedin
			$wp_customize->add_control( 
				'magazine_pro_linkedin_link', 
				array(
					'label' => esc_html__( 'Linkedin Link', 'magazine-pro' ),
					'section' => 'magazine_pro_social_links_options',
					'type' => 'url',
				) 
			);

			// Social Links - Vimeo
			$wp_customize->add_control( 
				'magazine_pro_vimeo_link', 
				array(
					'label' => esc_html__( 'Vimeo Link', 'magazine-pro' ),
					'section' => 'magazine_pro_social_links_options',
					'type' => 'url',
				) 
			);

			// Enable Breadcrumb
			$wp_customize->add_control( 
				'magazine_pro_enable_breadcrumb', 
				array(
					'label'				=> esc_html__( 'Enable Breadcrumb', 'magazine-pro' ),
					'section'			=> 'magazine_pro_breadcrumb_options',
					'type'				=> 'checkbox' 
				) 
			);

			// Enable Sticky Sidebar
			$wp_customize->add_control(
				'magazine_pro_enable_sticky_sidebar', 
				array(
					'label'			=> esc_html__( 'Enable Sticky Sidebar', 'magazine-pro' ),
					'section'		=> 'magazine_pro_sidebar_options',
					'type'			=> 'checkbox',
				) 
			);


			// Enable Lazy Load
			$wp_customize->add_control(
				'magazine_pro_enable_lazy_load', 
				array(
					'label'			=> esc_html__( 'Enable Lazy Load', 'magazine-pro' ),
					'section'		=> 'magazine_pro_site_image_options',
					'type'			=> 'checkbox',
				) 
			);
			
			// Set Primary Theme Color
			$wp_customize->add_control( 
				new WP_Customize_Color_Control( 
					$wp_customize, 
					'magazine_pro_primary_theme_color',
					array(
						'label' => esc_html__( 'Primary Theme Color', 'magazine-pro' ),
						'section' => 'magazine_pro_theme_color_options'
					) 
				) 
			);

			if( class_exists( 'Woocommerce' ) ) {
				// Select Sidebar Position For Search Page
				$wp_customize->add_control( 
					new Magazine_Pro_Radio_Image_Control( 
						$wp_customize,
						'magazine_pro_select_woocommerce_sidebar_position', 
						array(
							'label'				=> esc_html__( 'Woocommerce Sidebar Position', 'magazine-pro' ),
							'section'			=> 'magazine_pro_woocommerce_sidebar_position',
							'type'				=> 'select',
							'choices'			=> $this->get_sidebar_position(), 
						) 
					)
				);
			}
		}

		/**
		 * Sets up the customizer partials.
		 *
		 * @since  1.0.0
		 * @access public
		 * @param  object  $manager
		 * @return void
		 */
		public function add_partials( $manager ) {
			
			if ( isset( $wp_customize->selective_refresh ) ) {

				$wp_customize->selective_refresh->add_partial( 
					'blogname', 
					array(
						'selector'        => '.site-title a',
						'render_callback' => array( $this, 'customize_partial_blogname' ),
					) 
				);

				$wp_customize->selective_refresh->add_partial( 
					'blogdescription', 
					array(
						'selector'        => '.site-description',
						'render_callback' => array( $this, 'customize_partial_blogdescription' ),
					) 
				);
			}
		}

		/**
		 * Render the site title for the selective refresh partial.
		 *
		 * @return void
		 */
		function customize_partial_blogname() {

			bloginfo( 'name' );
		}

		/**
		 * Render the site tagline for the selective refresh partial.
		 *
		 * @return void
		 */
		function customize_partial_blogdescription() {

			bloginfo( 'description' );
		}

		/**
		 * Loads theme customizer JavaScript.
		 *
		 * @since  1.0.0
		 * @access public
		 * @return void
		 */
		public function customize_preview_js() {

			wp_enqueue_script( 'magazine_pro-customizer', get_template_directory_uri() . '/admin/js/customizer.js', array( 'customize-preview' ), MAGAZINE_PRO_VERSION, true );
		}

		/**
		 * Loads theme customizer CSS.
		 *
		 * @since  1.0.0
		 * @access public
		 * @return void
		 */
		public function customizer_scripts() {

			wp_enqueue_style( 'chosen', get_template_directory_uri() . '/admin/css/chosen.css' );

			// wp_enqueue_style( 'magazine_pro-upgrade', get_template_directory_uri() . '/inc/customizer/upgrade-to-pro/upgrade.css' );

			wp_enqueue_style( 'magazine_pro-customizer-style', get_template_directory_uri() . '/admin/css/customizer-style.css' );

			wp_enqueue_script( 'chosen', get_template_directory_uri() . '/admin/js/chosen.js', array( 'jquery' ), MAGAZINE_PRO_VERSION, true );

			// wp_enqueue_script( 'magazine_pro-upgrade', get_template_directory_uri() . '/inc/customizer/upgrade-to-pro/upgrade.js', array( 'jquery' ), MAGAZINE_PRO_VERSION, true );

			wp_enqueue_script( 'magazine_pro-customizer-script', get_template_directory_uri() . '/admin/js/customizer-script.js', array( 'jquery' ), MAGAZINE_PRO_VERSION, true );
		}

		/**
		 * Function to load choices for controls.
		 *
		 * @since  1.0.0
		 * @access public
		 * @return void
		 */
		function get_category_taxonomies() {
		  $cats    = array();
		  foreach ( get_categories() as $categories => $cat ) {
		    $cats[ $cat->term_id ] = $cat->name;
		  }
		  return $cats;
		}
		/**
		 * Function to load layout choices for homepage sidebar.
		 *
		 * @since  1.0.0
		 * @access public
		 * @return array
		 */
		function get_homepage_sidebar() {

			$news_layouts = array(
				'left' => get_template_directory_uri() . '/admin/images/sidebar-placeholders/sidebar_left.png',
				'right' => get_template_directory_uri() . '/admin/images/sidebar-placeholders/sidebar_right.png',
			);

			return $news_layouts;
		}

		/**
		 * Function to load layout choices for header.
		 *
		 * @since  1.0.0
		 * @access public
		 * @return array
		 */
		function get_header_layout() {

			$header_layouts = array(
				'header_1' => get_template_directory_uri() . '/admin/images/header-placeholders/header_1.png',
				'header_2' => get_template_directory_uri() . '/admin/images/header-placeholders/header_2.png',
			);

			return $header_layouts;
		}

		/**
		 * Function to load layout choices for sidebar.
		 *
		 * @since  1.0.0
		 * @access public
		 * @return array
		 */
		function get_sidebar_position() {

			$news_layouts = array(
				'left' => get_template_directory_uri() . '/admin/images/sidebar-placeholders/sidebar_left.png',
				'right' => get_template_directory_uri() . '/admin/images/sidebar-placeholders/sidebar_right.png',
				'none' => get_template_directory_uri() . '/admin/images/sidebar-placeholders/sidebar_none.png',
			);

			return $news_layouts;
		}

		/**
		 * Function to load dynamic styles.
		 *
		 * @since  1.0.0
		 * @access public
		 * @return null
		 */
		public function dynamic_style() {

			$primary_theme_color = magazine_pro_get_option( 'magazine_pro_primary_theme_color' );

			$enable_scroll_top = magazine_pro_get_option( 'magazine_pro_enable_scroll_top_button' );
			$enable_header_search = magazine_pro_get_option( 'magazine_pro_enable_search_button' );
			$header_overlay = magazine_pro_get_option( 'magazine_pro_header_overlay_color' );
			?>
			<style>
				.primary-navigation li.primarynav_search_icon {
					<?php
					if( $enable_header_search == false ) {
						?>
						display: none;
						<?php
					}
					?>
				}

				#toTop {
					<?php
					if( $enable_scroll_top == false ) {
						?>
						display: none !important;
						<?php
					}
					?>
				}

				<?php
				if( !empty( $primary_theme_color ) ) {
					?>


					button,
					input[type="button"],
					input[type="reset"],
					input[type="submit"],
					.primary-navigation > ul > li.home-btn,
					.cm_header_lay_three .primary-navigation > ul > li.home-btn,
					.news_ticker_wrap .ticker_head,
					#toTop,
					.section-title h2::after,
					.sidebar-widget-area .widget .widget-title h2::after,
					footer .widget .widget-title h2::after,
					#comments div#respond h3#reply-title::after,
					#comments h2.comments-title:after,
					ul.post-categories li a,
					.post_tags a,
					.owl-carousel .owl-nav button.owl-prev, 
					.owl-carousel .owl-nav button.owl-next,
					.cm_author_widget .author-detail-link a,
					.error_foot form input[type="submit"], 
					.widget_search form input[type="submit"],
					.header-search-container input[type="submit"],
					.widget_tag_cloud .tagcloud a:hover,
					.trending_widget_carousel .owl-dots button.owl-dot,
					footer .widget_calendar .calendar_wrap caption,
					.pagination .page-numbers.current,
					.post-navigation .nav-links .nav-previous a, 
					.post-navigation .nav-links .nav-next a,
					#comments form input[type="submit"],
					footer .widget_tag_cloud .tagcloud a,
					footer .widget.widget_search form input[type="submit"]:hover,
					.widget_product_search .woocommerce-product-search button[type="submit"],
					.woocommerce ul.products li.product .button,
					.woocommerce .woocommerce-pagination ul.page-numbers li span.current,
					.woocommerce .product div.summary .cart button.single_add_to_cart_button,
					.woocommerce .product div.woocommerce-tabs div.panel #reviews #review_form_wrapper .comment-form p.form-submit .submit,
					.woocommerce .product section.related > h2::after,
					.woocommerce .cart .button:hover, 
					.woocommerce .cart .button:focus, 
					.woocommerce .cart input.button:hover, 
					.woocommerce .cart input.button:focus, 
					.woocommerce #respond input#submit:hover, 
					.woocommerce #respond input#submit:focus, 
					.woocommerce button.button:hover, 
					.woocommerce button.button:focus, 
					.woocommerce input.button:hover, 
					.woocommerce input.button:focus,
					.woocommerce #respond input#submit.alt:hover, 
					.woocommerce a.button.alt:hover, 
					.woocommerce button.button.alt:hover, 
					.woocommerce input.button.alt:hover,
					.woocommerce a.remove:hover,
					.woocommerce-account .woocommerce-MyAccount-navigation ul li.is-active a,
					.woocommerce a.button:hover, 
					.woocommerce a.button:focus,
					.widget_product_tag_cloud .tagcloud a:hover, 
					.widget_product_tag_cloud .tagcloud a:focus,
					.woocommerce .widget_price_filter .price_slider_wrapper .ui-slider .ui-slider-handle,
					.error_page_top_portion {

						background-color: <?php echo esc_attr( $primary_theme_color ); ?>;
					}
					

					a:hover,
					.post_title h2 a:hover,
					.post_title h2 a:focus,
					.post_meta li a:hover,
					.post_meta li a:focus,
					ul.social-icons li a[href*=".com"]:hover::before,
					.ticker_carousel .owl-nav button.owl-prev i, 
					.ticker_carousel .owl-nav button.owl-next i,
					.news_ticker_wrap .ticker_items .item a:hover,
					.news_ticker_wrap .ticker_items .item a:focus,
					.cm_banner .post_title h2 a:hover,
					.cm_banner .post_meta li a:hover,
					.cm-post-widget-two .big-card .post-holder a:hover, 
					.cm-post-widget-two .big-card .post-holder a:focus,
					.cm-post-widget-two .small-card .post-holder a:hover, 
					.cm-post-widget-two .small-card .post-holder a:focus,
					.cm_middle_post_widget_one .post_title h2 a:hover, 
					.cm_middle_post_widget_one .post_meta li a:hover,
					.cm_middle_post_widget_three .post_thumb .post-holder a:hover,
					.cm_middle_post_widget_three .post_thumb .post-holder a:focus,
					.cm_middle_post_widget_six .middle_widget_six_carousel .item .card .card_content a:hover, 
					.cm_middle_post_widget_six .middle_widget_six_carousel .item .card .card_content a:focus,
					.cm_post_widget_twelve .card .post-holder a:hover, 
					.cm_post_widget_twelve .card .post-holder a:focus,
					.cm_post_widget_seven .card .card_content a:hover, 
					.cm_post_widget_seven .card .card_content a:focus,
					.copyright_section a:hover,
					.footer_nav ul li a:hover,
					.breadcrumb ul li:last-child span,
					.pagination .page-numbers:hover,
					#comments ol.comment-list li article footer.comment-meta .comment-metadata span.edit-link a:hover,
					#comments ol.comment-list li article .reply a:hover,
					.social-share ul li a:hover,
					ul.social-icons li a:hover,
					ul.social-icons li a:focus,
					.woocommerce ul.products li.product a:hover,
					.woocommerce ul.products li.product .price,
					.woocommerce .woocommerce-pagination ul.page-numbers li a.page-numbers:hover,
					.woocommerce div.product p.price, 
					.woocommerce div.product span.price,
					.video_section .video_details .post_title h2 a:hover,
					.primary-navigation.dark li a:hover {

						color: <?php echo esc_attr( $primary_theme_color ); ?>;
					}
					
					.ticker_carousel .owl-nav button.owl-prev, 
					.ticker_carousel .owl-nav button.owl-next,
					.error_foot form input[type="submit"], 
					.widget_search form input[type="submit"],
					.pagination .page-numbers:hover,
					#comments form input[type="submit"],
					.social-share ul li a:hover,
					.header-search-container form,
					.widget_product_search .woocommerce-product-search button[type="submit"],
					.woocommerce .woocommerce-pagination ul.page-numbers li span.current,
					.woocommerce .woocommerce-pagination ul.page-numbers li a.page-numbers:hover,
					.woocommerce a.remove:hover,
					.ticker_carousel .owl-nav button.owl-prev:hover, 
					.ticker_carousel .owl-nav button.owl-next:hover,
					footer .widget.widget_search form input[type="submit"]:hover,
					.trending_widget_carousel .owl-dots button.owl-dot,
					.the_content blockquote {

						border-color: <?php echo esc_attr( $primary_theme_color ); ?>;
					}
					<?php
				}

				if( !empty( $header_overlay ) ) {
					?>
					header .mask {
						background-color: <?php echo esc_attr( $header_overlay ); ?>;
					}
					<?php
				}
				?>
			</style>
			<?php
		}
	}
}