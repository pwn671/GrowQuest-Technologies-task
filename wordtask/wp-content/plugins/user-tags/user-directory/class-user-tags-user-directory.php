<?php
/**
 * Handles registration of custom block user-directory
 */

if ( ! class_exists( 'User_Tags_User_Directory' ) ) :

	class User_Tags_User_Directory {

		/**
		 * @var object Class instance
		 */
		private static $instance;

		/**
		 * Register block
		 */
		private function __construct() {
			add_action( 'init', array( $this, 'register_block' ) );
		}

		/**
		 * Initialize/Return Class instance
		 *
		 * @return object|User_Tags_User_Directory
		 */
		public static function get_instance() {
			if ( ! isset( self::$instance ) ) {
				self::$instance = new User_Tags_User_Directory();
			}

			// Returns the instance.
			return self::$instance;
		}

		public function register_block() {
			register_block_type( __DIR__ . '/block/build',
				array(
					'style'  => 'user-directory-block-style'
				)
			);

			// Enqueue script after register_block_type() so script handle is valid.
			add_action( 'admin_enqueue_scripts', array( $this, 'register_script' ) );
			add_action( 'wp_enqueue_scripts', array( $this, 'register_script' ) );
		}

		/**
		 * Localize Block data for the block editor script
		 *
		 * @return void
		 */
		public function register_script() {

			$handle     = 'user-tags-user-directory-editor-script';
			$block_data = array(
				'user_role'  => $this->user_get_role_names(),
//				'taxonomies' => get_registered_user_taxonomies(),
				'filters'    => $this->get_filters(),
				'fields'     => $this->get_user_fields(),
			);
			wp_localize_script( $handle, 'userDir', $block_data );

			$block_js = 'frontend.js';
			wp_register_script(
				'user-directory-block',
				UT_URL . '/user-directory/' . $block_js,
				array( 'jquery' ),
				filemtime( UT_DIR . 'user-directory/' . $block_js ),
				array( 'in_footer' => true )
			);
		}

		/**
		 * Get registered user roles
		 *
		 * @return string[]
		 */
		public function user_get_role_names() {

			global $wp_roles;
			if ( ! isset( $wp_roles ) ) {
				//phpcs:ignore
				$wp_roles = new WP_Roles();
			}

			return apply_filters( 'user_tags_directory_user_roles', $wp_roles->get_names() );
		}

		/**
		 * Returns list of filters for the Directory block
		 *
		 * @return array $filters
		 *
		 */
		public function get_filters() {
			$filters = array(
				'search' => array(
					'name'  => 'search',
					'label' => __( 'Search', 'user_taxonomy' ),
					'type'  => 'search',
				),
			);

			$user_taxonomies = get_registered_user_taxonomies();
			foreach ( $user_taxonomies as $taxonomy ) {
				$filters[ 'tax_' . $taxonomy['name'] ] = array(
					'name'       => $taxonomy['name'],
					'label'      => $taxonomy['label'],
					'type'       => 'taxonomy',
					'value_type' => 'text',
					'default'    => false,
				);
			}

			return $filters;
		}

		/**
		 * Fields to be displayed in front-end
		 *
		 * Fields args:
		 *  default - If a field should be displayed by default. Others can be enabled/disabled from block setting
		 *
		 * @return array
		 */
		public function get_user_fields() {
			$fields = array(
				'user_title' => array(
					'field_name' => 'user-directory-field-user_title',
					'name'       => 'user_title',
					'label'      => __( 'User name', 'user_taxonomy' ),
					'type'       => 'user',
					'value_type' => 'text',
					'default'    => true,
					'args'       => array(
						'link' => true,
					)
				),
				'bio'        => array(
					'field_name' => 'user-directory-field-bio',
					'name'       => 'description',
					'label'      => __( 'Bio', 'user_taxonomy' ),
					'type'       => 'custom_field',
					'value_type' => 'text',
					'default'    => false,
				),
				'user_email' => array(
					'field_name' => 'user-directory-field-user_email',
					'name'       => 'user_email',
					'label'      => __( 'Email', 'user_taxonomy' ),
					'type'       => 'user',
					'value_type' => 'email',
					'default'    => false,
				),
				'image'      => array(
					'field_name' => 'user-directory-field-image',
					'name'       => 'image',
					'label'      => __( 'Image', 'user_taxonomy' ),
					'type'       => 'custom_field',
					'value_type' => 'image',
					'default'    => true,
				),
				'user_url'   => array(
					'field_name' => 'user-directory-field-user_url',
					'name'       => 'user_url',
					'label'      => __( 'Website', 'user_taxonomy' ),
					'type'       => 'user',
					'value_type' => 'url',
					'default'    => false,
				),
			);

			$user_taxonomies = get_registered_user_taxonomies();
			foreach ( $user_taxonomies as $taxonomy ) {

				$fields[ 'tax_' . $taxonomy['name'] ] = array(
					'name'       => $taxonomy['name'],
					'label'      => $taxonomy['label'],
					'type'       => 'taxonomy',
					'value_type' => 'text',
					'default'    => false,
				);
			}

			return apply_filters( 'user_tags_directory_fields', $fields );
		}
	}

	User_Tags_User_Directory::get_instance();
endif;
