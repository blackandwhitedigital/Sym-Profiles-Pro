<?php

if(!class_exists('SpeakerPostTypeRegistrations')):

	class SpeakerPostTypeRegistrations {

		public function __construct() {
			// Add the team post type and taxonomies
			add_action( 'init', array( $this, 'register' ) );
		}
		/**
		 * Initiate registrations of post type and taxonomies.
		 *
		 * @uses Portfolio_Post_Type_Registrations::register_post_type()
		 */
		public function register() {
			$this->register_post_type();
		}

		


		/**
		 * Register the custom post type.
		 *
		 * @link http://codex.wordpress.org/Function_Reference/register_post_type
		 */
		protected function register_post_type() {
			
			global $Speaker;
			$team_labels = array(
			    'name'                => _x( 'Speaker Pro', SPEAKER_SLUG ),
			    'singular_name'       => _x( 'Speaker', SPEAKER_SLUG ),
			    'menu_name'           => __( 'Speaker Pro', SPEAKER_SLUG ),
			    'name_admin_bar'      => __( 'Speaker', SPEAKER_SLUG ),
			    'parent_item_colon'   => __( 'Parent Speaker:', SPEAKER_SLUG ),
			    'all_items'           => __( 'All Speakers', SPEAKER_SLUG ),
			    'add_new_item'        => __( 'Add New Speaker', SPEAKER_SLUG ),
			    'add_new'             => __( 'Add Speaker', SPEAKER_SLUG ),
			    'new_item'            => __( 'New Speaker', SPEAKER_SLUG ),
			    'edit_item'           => __( 'Edit Speaker', SPEAKER_SLUG ),
			    'update_item'         => __( 'Update Speaker', SPEAKER_SLUG ),
			    'view_item'           => __( 'View Speaker', SPEAKER_SLUG ),
			    'search_items'        => __( 'Search Speaker', SPEAKER_SLUG ),
			    'not_found'           => __( 'Not found', SPEAKER_SLUG ),
			    'not_found_in_trash'  => __( 'Not found in Trash', SPEAKER_SLUG ),
			);
			$team_args = array(
			    'label'               => __( 'Speaker Pro', SPEAKER_SLUG ),
			    'description'         => __( 'Speaker', SPEAKER_SLUG ),
			    'labels'              => $team_labels,
			    'supports'            => array( 'title', 'editor','thumbnail', 'page-attributes' ),
				'taxonomies'          => array(),
				'hierarchical'        => false,
				'public'              => true,
				'rewrite'			  => array('slug' => $Speaker->post_type_slug),
				'show_ui'             => true,
				'show_in_menu'        => true,
				'menu_position'       => 20,
				'menu_icon' 		  => $Speaker->assetsUrl.'images/Speakers-Icon_new.png',
				'show_in_admin_bar'   => true,
				'show_in_nav_menus'   => true,
				'can_export'          => true,
				'has_archive'         => false,
				'exclude_from_search' => false,
				'publicly_queryable'  => true,
				'capability_type'     => 'page',
			);
			register_post_type( $Speaker->post_type, $team_args );
			flush_rewrite_rules();
	
		}
	}

endif;
