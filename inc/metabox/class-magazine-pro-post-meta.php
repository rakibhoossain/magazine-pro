<?php
/**
 * Custom field for post page sidebar position.
 */
if( ! class_exists( 'Magazine_Pro_Post_Meta' ) ) {

	class Magazine_Pro_Post_Meta {

		/**
		 * Initialize the class and set its properties.
		 *
		 * @since    1.0.0
		 * @param      string    'magazine-pro'       The name of this plugin.
		 * @param      string    $version    The version of this plugin.
		 */
		public function __construct() {
			$this->init();
		}

		/**
		 * Sets up initial actions.
		 *
		 * @since  1.0.0
		 * @access public
		 * @return void
		 */
		public function init() {
			// Register post meta fields and save meta fields values.
			add_action( 'admin_init', array( $this, 'register_post_meta' ) );
			add_action( 'save_post', array( $this, 'save_sidebar_position_meta' ) );
		}

		/**
		 * Register post custom meta fields.
		 *
		 * @since    1.0.0
		 */
		public function register_post_meta() {   

		    add_meta_box( 'sidebar_position_metabox', esc_html__( 'Sidebar Position', 'magazine-pro' ), array( $this, 'sidebar_position_meta' ), array( 'post', 'page' ), 'side', 'default' );
		}

		/**
		 * Custom Sidebar Post Meta.
		 *
		 * @since    1.0.0
		 */
		public function sidebar_position_meta() {

			global $post;

			$sidebar = get_post_meta( $post->ID, 'magazine_pro_sidebar_position', true );

			if( empty( $sidebar ) ) {
				$sidebar = 'right';
			}

		    wp_nonce_field( 'magazine_pro_sidebar_position_meta_nonce', 'magazine_pro_sidebar_position_meta_nonce_id' );

		    $sidebar_positions = array(
		        'right' => esc_html__( 'Right', 'magazine-pro' ),
		        'left' => esc_html__( 'Left', 'magazine-pro' ),
		        'none' => esc_html__( 'None', 'magazine-pro' ),
		    );

		    ?>

		    <table width="100%" border="0" class="options" cellspacing="5" cellpadding="5">
		        <tr>
		        	<td>
		        		<select class="widefat" name="sidebar_position" id="sidebar_position">
		        			<?php
		        			foreach( $sidebar_positions as $key => $option ) {
		        				?>
		        				<option value="<?php echo esc_attr( $key ); ?>" <?php if( $sidebar == $key ) { echo esc_attr__( 'selected', 'magazine-pro' ); } ?>><?php echo esc_html( $option ); ?></option>
		        				<?php
		        			}
		        			?>
		        		</select>
		        	</td>   
		        </tr> 
		    </table>   
		    <?php   
		}

		/**
		 * Save Custom Sidebar Position Post Meta.
		 *
		 * @since    1.0.0
		 */
		public function save_sidebar_position_meta() {

		    global $post;  

		    // Bail if we're doing an auto save
		    if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		        return;
		    }
		    
		    // if our nonce isn't there, or we can't verify it, bail
		    if( !isset( $_POST['magazine_pro_sidebar_position_meta_nonce_id'] ) || !wp_verify_nonce( sanitize_key( $_POST['magazine_pro_sidebar_position_meta_nonce_id'] ), 'magazine_pro_sidebar_position_meta_nonce' ) ) {
		        return;
		    }
		    
		    // if our current user can't edit this post, bail
		    if ( ! current_user_can( 'edit_post', $post->ID ) ) {
		        return;
		    } 

		    if( isset( $_POST['sidebar_position'] ) ) {
				update_post_meta( $post->ID, 'magazine_pro_sidebar_position', sanitize_text_field( wp_unslash( $_POST['sidebar_position'] ) ) ); 
			}
		}
	}
}