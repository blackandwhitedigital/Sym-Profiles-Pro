<?php

if(!class_exists('SpeakerPostTypeRegistrations')):

	class SpeakerPostTypeRegistrations {
		//public $dr;

		public function __construct() {
		
			// Add the team post type and taxonomies
			add_action( 'init', array( $this, 'register' ) );
			add_action( 'init', array( $this, 'agenda_listing_taxonomy'));
			add_action( 'init', array( $this, 'agenda_listing_categories'));
			
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

		function agenda_listing_taxonomy() {
			global $Speaker;
		    register_taxonomy(
		        'agenda_cat',  //The name of the taxonomy. Name should be in slug form (must not contain capital letters or spaces).
		        'speaker',  //post type name
		        array(
		        'public'                => true,
		        'hierarchical'          => true,
		        'label'                 => 'Event',  //Display name
		        'query_var'             => true,
		        'show_admin_column' => False,
		        'rewrite'               => array(
		            'slug'              => $Speaker->post_type_slug, // This controls the base slug that will display before each term
		            'with_front'        => false // Don't display the category base before
		            )
		        )
		    );

		}


		function agenda_listing_categories() {
			global $Speaker;

			if ( (is_plugin_active( 'Sym-Agenda-Pro-master/Agenda.php' ) ) ||  (is_plugin_active( 'Sym-Agenda-master/Agenda.php' ) ) ){
		
                    $agenda= new WP_Query( array( 'post_type' => 'agenda','post_status' => 'publish') );
                    
                    if ($agenda->have_posts()) { 

                    	while ($agenda->have_posts()) : $agenda->the_post();
                    	
                    	$term = get_the_title(); 
                    	
                    	if (strlen($term)==0){
                    	
						}else{
							$cid=wp_insert_term(
							
							  $term,
							
							    'agenda_cat',
							
							    array(
							
							      'description' => $term,
							
							      'slug'    => $term
							
							    )
							
							  );
							
							}
						endwhile;
					
					}
					
			}

		}
	}

endif;
