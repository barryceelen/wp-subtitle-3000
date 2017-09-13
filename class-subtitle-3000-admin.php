<?php
/**
 * Contains the admin class
 *
 * @package    WordPress
 * @subpackage Subtitle_3000
 * @author     Barry Ceelen
 * @license    GPL-3.0+
 * @link       https://github.com/barryceelen/wp-subtitle-3000
 * @copyright  Barry Ceelen
 */

/**
 * Admin subtitle class.
 */
class Subtitle_3000_Admin {

	/**
	 * Instance of this class.
	 *
	 * @since 1.0.0
	 *
	 * @var object
	 */
	protected static $instance = null;

	/**
	 * Initialize the plugin by setting actions and filters.
	 *
	 * @since 1.0.0
	 */
	private function __construct() {

		// Enqueue styles.
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_styles' ) );

		// Enqueue scripts.
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );

		// Add subtitle input to post edit field.
		add_action( 'edit_form_before_permalink', array( $this, 'edit_form_subtitle' ), 0, 1 );

		// Save post subtitle.
		add_action( 'save_post', array( $this, 'save_post_subtitle' ), 10, 2 );
	}

	/**
	 * Enqueue admin styles.
	 *
	 * @since 1.0.0
	 */
	public function enqueue_styles() {

		$current_screen = get_current_screen();

		if ( 'post' === $current_screen->base && post_type_supports( $current_screen->post_type, 'subtitle' ) ) {

			wp_enqueue_style(
				'subtitle-3000',
				plugin_dir_url( __FILE__ ) . 'css/admin.css'
			);
		}
	}

	/**
	 * Enqueue admin scripts.
	 *
	 * @since 1.0.0
	 */
	public function enqueue_scripts() {

		$current_screen = get_current_screen();

		if ( 'post' === $current_screen->base && post_type_supports( $current_screen->post_type, 'subtitle' ) ) {
			wp_enqueue_script(
				'subtitle-3000',
				plugin_dir_url( __FILE__ ) . 'js/admin.js',
				array( 'jquery' ),
				'1.0.0',
				true
			);
		}
	}

	/**
	 * Return an instance of this class.
	 *
	 * @since 1.0.0
	 *
	 * @return object A single instance of this class.
	 */
	public static function get_instance() {
		// If the single instance hasn't been set, set it now.
		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Add subtitle input to post edit screen.
	 *
	 * @todo Remove tabbing from title to editor in post.js line 328.
	 * @todo Autosave.
	 *
	 * @param  WP_Post $post Post object.
	 */
	function edit_form_subtitle( $post ) {

		if ( ! post_type_supports( $post->post_type, 'subtitle' ) ) {
			return;
		}

		printf(
			'<div id="subtitle-div"><div id="subtitle-wrap"><label id="subtitle-input-prompt-text" for="subtitle" %s>%s</label><input type="text" name="subtitle" value="%s" id="subtitle-input" size="30" spellcheck="true" autocomplete="off" />%s</div></div>',
			empty( $post->subtitle ) ? '' : 'class="screen-reader-text"',
			esc_html( apply_filters( 'subtitle_3000_label', __( 'Enter subtitle here', 'subtitle-3000' ) ) ),
			esc_attr( $post->subtitle ),
			wp_kses(
				wp_nonce_field( 'save-subtitle', 'subtitle-nonce', false ),
				array(
					'input' => array(
						'type'  => array(),
						'id'    => array(),
						'name'  => array(),
						'value' => array(),
					),
				)
			)
		);
	}

	/**
	 * Save post subtitle.
	 *
	 * @access private
	 *
	 * @param  int     $post_id Post ID.
	 * @param  WP_Post $post    Post object.
	 */
	public function save_post_subtitle( $post_id, $post ) {

		if ( empty( $_POST['subtitle-nonce'] ) ) { // WPCS: input var okay.
			return;
		}

		if ( ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['subtitle-nonce'] ) ), 'save-subtitle' ) ) { // WPCS: input var okay.
			return;
		}

		// Get the post type object.
		$post_type = get_post_type_object( $post->post_type );

		// Check if the current user has permission to edit the post.
		if ( ! current_user_can( $post_type->cap->edit_post, $post_id ) ) {
			return;
		}

		$subtitle = isset( $_POST['subtitle'] ) ? sanitize_text_field( wp_unslash( $_POST['subtitle'] ) ) : false; // WPCS: input var okay.

		if ( $subtitle ) {
			update_post_meta(
				$post->ID,
				'subtitle',
				sanitize_text_field( wp_unslash( $_POST['subtitle'] ) )  // WPCS: input var okay.
			);
		} else {
			delete_post_meta( $post->ID, 'subtitle' );
		}
	}

}

global $subtitle_3000_admin;
$subtitle_3000_admin = Subtitle_3000_Admin::get_instance();
