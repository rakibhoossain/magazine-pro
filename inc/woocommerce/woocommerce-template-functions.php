<?php
/**
 * WooCommerce Compatibility File
 *
 * @link https://woocommerce.com/
 *
 * @package Magazine_Pro
 */

/**
 * Default loop columns on product archives.
 *
 * @return integer products per row.
 */
function magazine_pro_woocommerce_loop_columns() {

	$sidebar_position = magazine_pro_sidebar_position();

	if( $sidebar_position != 'none' && is_active_sidebar( 'woocommerce-sidebar' ) ) {

		return 3;
	} else {

		return 4;
	}
}
add_filter( 'loop_shop_columns', 'magazine_pro_woocommerce_loop_columns' );

/**
 * Related Products Args.
 *
 * @param array $args related products args.
 * @return array $args related products args.
 */
function magazine_pro_woocommerce_related_products_args( $args ) {

	$columns = '';
	$sidebar_position = magazine_pro_sidebar_position();

	if( $sidebar_position != 'none' && is_active_sidebar( 'woocommerce-sidebar' ) ) {

		$columns = 3;
		$posts_per_page = 3;
	} else {

		$columns = 4;
		$posts_per_page = 4;
	}

	$defaults = array(
		'posts_per_page' => $posts_per_page,
		'columns'        => $columns,
	);

	$args = wp_parse_args( $defaults, $args );

	return $args;
}
add_filter( 'woocommerce_output_related_products_args', 'magazine_pro_woocommerce_related_products_args' );


if ( ! function_exists( 'magazine_pro_woocommerce_product_columns_wrapper' ) ) {
	/**
	 * Product columns wrapper.
	 *
	 * @return  void
	 */
	function magazine_pro_woocommerce_product_columns_wrapper() {

		$columns = magazine_pro_woocommerce_loop_columns();

		echo '<div class="columns-' . absint( $columns ) . '">';
	}
}
add_action( 'woocommerce_before_shop_loop', 'magazine_pro_woocommerce_product_columns_wrapper', 40 );


if ( ! function_exists( 'magazine_pro_woocommerce_product_columns_wrapper_close' ) ) {
	/**
	 * Product columns wrapper close.
	 *
	 * @return  void
	 */
	function magazine_pro_woocommerce_product_columns_wrapper_close() {

		echo '</div>';
	}
}
add_action( 'woocommerce_after_shop_loop', 'magazine_pro_woocommerce_product_columns_wrapper_close', 40 );

/**
 * Remove default WooCommerce wrapper.
 */
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );
remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );

if ( ! function_exists( 'magazine_pro_woocommerce_wrapper_before' ) ) {
	/**
	 * Before Content.
	 *
	 * Wraps all WooCommerce content in wrappers which match the theme markup.
	 *
	 * @return void
	 */
	function magazine_pro_woocommerce_wrapper_before() {
		?>
		<div class="cm-container">
		    <div class="inner-page-wrapper">
		        <div id="primary" class="content-area">
		            <main id="main" class="site-main">
		                <div class="cm_woocommerce_pages">
		                    <?php
		                    /**
							* Hook - magazine_pro_breadcrumb.
							*
							* @hooked magazine_pro_breadcrumb_action - 10
							*/
							do_action( 'magazine_pro_breadcrumb' );
		                    ?>
		                    <div class="row">
		                    	<div class="woocommerce-container clearfix">
			                    	<?php
			                    	$sidebar_position = magazine_pro_sidebar_position(); 
			                    	$is_sticky = magazine_pro_check_sticky_sidebar();
			                    	$main_class = '';
			                    	if( $sidebar_position != 'none' && is_active_sidebar( 'woocommerce-sidebar' ) ) {
			                    		if( $is_sticky == true ) {
			                    			$main_class = 'col-md-8 col-sm-12 col-xs-12 sticky_portion';
			                    		} else {
			                    			$main_class = 'col-md-8 col-sm-12 col-xs-12';
			                    		}
			                    	} else {
			                    		$main_class = 'col-md-12 col-sm-12 col-xs-12';
			                    	}
			                    	if( $sidebar_position == 'left' && is_active_sidebar( 'woocommerce-sidebar' ) ) {
			                    		magazine_pro_woocommerce_sidebar();
			                    	}
			                    	?>
			                        <div class="<?php echo esc_attr( $main_class ); ?>">
			                            <div class="content-entry">
											<?php
	}
}
add_action( 'woocommerce_before_main_content', 'magazine_pro_woocommerce_wrapper_before' );

if ( ! function_exists( 'magazine_pro_woocommerce_wrapper_after' ) ) {
	/**
	 * After Content.
	 *
	 * Closes the wrapping divs.
	 *
	 * @return void
	 */
	function magazine_pro_woocommerce_wrapper_after() {
									?>
									</div><!-- .content-entry -->
		                        </div>

		                        <?php 
		                        $sidebar_position = magazine_pro_sidebar_position();
		                        if( $sidebar_position == 'right' && is_active_sidebar( 'woocommerce-sidebar' ) ) {
		                        	magazine_pro_woocommerce_sidebar();
		                        }
		                        ?>
		                        </div><!-- .woocommerce-container -->
		                    </div><!-- .row -->
		                </div><!-- .cm_woocommerce_pages -->
		            </main><!-- #main.site-main -->
		        </div><!-- #primary.content-area -->
		    </div><!-- .inner-page-wrapper -->
		</div><!-- .cm-container -->
		<?php
	}
}
add_action( 'woocommerce_after_main_content', 'magazine_pro_woocommerce_wrapper_after' );

/**
 * Sample implementation of the WooCommerce Mini Cart.
 *
 * You can add the WooCommerce Mini Cart to header.php like so ...
 *
	<?php
		if ( function_exists( 'magazine_pro_woocommerce_header_cart' ) ) {
			Magazine_Pro_woocommerce_header_cart();
		}
	?>
 */

if ( ! function_exists( 'magazine_pro_woocommerce_cart_link_fragment' ) ) {
	/**
	 * Cart Fragments.
	 *
	 * Ensure cart contents update when products are added to the cart via AJAX.
	 *
	 * @param array $fragments Fragments to refresh via AJAX.
	 * @return array Fragments to refresh via AJAX.
	 */
	function magazine_pro_woocommerce_cart_link_fragment( $fragments ) {

		ob_start();
		magazine_pro_woocommerce_cart_link();
		$fragments['a.cart-contents'] = ob_get_clean();

		return $fragments;
	}
}
add_filter( 'woocommerce_add_to_cart_fragments', 'magazine_pro_woocommerce_cart_link_fragment' );


if ( ! function_exists( 'magazine_pro_woocommerce_cart_link' ) ) {
	/**
	 * Cart Link.
	 *
	 * Displayed a link to the cart including the number of items present and the cart total.
	 *
	 * @return void
	 */
	function magazine_pro_woocommerce_cart_link() {
		?>
		<a class="cart-contents" href="<?php echo esc_url( wc_get_cart_url() ); ?>" title="<?php esc_attr_e( 'View your shopping cart', 'magazine-pro' ); ?>">
			<?php
			$item_count_text = sprintf(
				/* translators: number of items in the mini cart. */
				_n( '%d item', '%d items', WC()->cart->get_cart_contents_count(), 'magazine-pro' ),
				WC()->cart->get_cart_contents_count()
			);
			?>
			<span class="amount"><?php echo wp_kses_data( WC()->cart->get_cart_subtotal() ); ?></span> <span class="count"><?php echo esc_html( $item_count_text ); ?></span>
		</a>
		<?php
	}
}


if ( ! function_exists( 'magazine_pro_woocommerce_header_cart' ) ) {
	/**
	 * Display Header Cart.
	 *
	 * @return void
	 */
	function magazine_pro_woocommerce_header_cart() {
		
		if ( is_cart() ) {
			$class = 'current-menu-item';
		} else {
			$class = '';
		}
		?>
		<ul id="site-header-cart" class="site-header-cart">
			<li class="<?php echo esc_attr( $class ); ?>">
				<?php magazine_pro_woocommerce_cart_link(); ?>
			</li>
			<li>
				<?php
				$instance = array(
					'title' => '',
				);

				the_widget( 'WC_Widget_Cart', $instance );
				?>
			</li>
		</ul>
		<?php
	}
}