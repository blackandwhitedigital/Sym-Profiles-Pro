<?php

if(!class_exists('SpeakerPostTypeAdmin')):
	

	/**
	*
	*/
	class SpeakerPostTypeAdmin
	{

		function __construct()
		{
			add_filter( 'manage_edit-speaker_columns', array($this, 'arrange_speaker_columns'));
			add_action( 'manage_speaker_posts_custom_column', array($this,'manage_speaker_columns'), 10, 3);
			// add_action( 'restrict_manage_posts', array( $this, 'add_taxonomy_filters' ) );
			add_filter( "manage_edit-speaker_sortable_columns", array($this,'speaker_column_sorts'));
		}


		public function add_taxonomy_filters() {
			global $typenow, $Speaker;
			// Must set this to the post type you want the filter(s) displayed on
			if ( $Speaker->post_type !== $typenow ) {
				return;
			}
			$taxonomies = array();
			foreach ( $taxonomies as $tax_slug ) {
				echo $this->build_taxonomy_filter( $tax_slug );
			}
		}

		/**
		 * Build an individual dropdown filter.
		 *
		 * @param  string $tax_slug Taxonomy slug to build filter for.
		 *
		 * @return string Markup, or empty string if taxonomy has no terms.
		 */
		protected function build_taxonomy_filter( $tax_slug ) {
			$terms = get_terms( $tax_slug );
			if ( 0 == count( $terms ) ) {
				return '';
			}
			$tax_name         = $this->get_taxonomy_name_from_slug( $tax_slug );
			$current_tax_slug = isset( $_GET[$tax_slug] ) ? $_GET[$tax_slug] : false;
			$filter  = '<select name="' . esc_attr( $tax_slug ) . '" id="' . esc_attr( $tax_slug ) . '" class="postform">';
			$filter .= '<option value="0">' . esc_html( $tax_name ) .'</option>';
			$filter .= $this->build_term_options( $terms, $current_tax_slug );
			$filter .= '</select>';
			return $filter;
		}

		/**
		 * Get the friendly taxonomy name, if given a taxonomy slug.
		 *
		 * @param  string $tax_slug Taxonomy slug.
		 *
		 * @return string Friendly name of taxonomy, or empty string if not a valid taxonomy.
		 */
		protected function get_taxonomy_name_from_slug( $tax_slug ) {
			$tax_obj = get_taxonomy( $tax_slug );
			if ( ! $tax_obj )
				return '';
			return $tax_obj->labels->name;
		}

		/**
		 * Build a series of option elements from an array.
		 *
		 * Also checks to see if one of the options is selected.
		 *
		 * @param  array  $terms            Array of term objects.
		 * @param  string $current_tax_slug Slug of currently selected term.
		 *
		 * @return string Markup.
		 */
		protected function build_term_options( $terms, $current_tax_slug ) {
			$options = '';
			foreach ( $terms as $term ) {
				$options .= sprintf(
					"<option value='%s' %s />%s</option>",
					esc_attr( $term->slug ),
					selected( $current_tax_slug, $term->slug, false ),
					esc_html( $term->name . '(' . $term->count . ')' )
				);
				// $options .= selected( $current_tax_slug, $term->slug );
			}
			return $options;
		}


		public function arrange_speaker_columns( $columns ) {
			// echo "mangesh";

		   $column_thumbnail = array( 'thumbnail' => __( 'Image', SPEAKER_SLUG ) );
			$column_designation = array( 'role' => __( 'Role', SPEAKER_SLUG ) );
			$column_email = array( 'email' => __( 'Email', SPEAKER_SLUG ) );
			$column_location = array( 'location' => __( 'Location', SPEAKER_SLUG ) );
			$column_event = array( 'Event Id' => __( 'Event ID', SPEAKER_SLUG ) );
			return array_slice( $columns, 0, 2, true ) + $column_thumbnail + $column_designation + $column_email + $column_location +$column_event+ array_slice( $columns, 1, null, true );
		}

		public function manage_speaker_columns( $column ) {
			// echo "mangesh";

			// global $post;
			switch ( $column ) {
				case 'thumbnail':
					echo get_the_post_thumbnail( get_the_ID(), array( 35, 35 ) );
					break;
				case 'role':
				    echo get_post_meta( get_the_ID() , 'role' , true );
				    break;
				case 'email':
				    echo get_post_meta( get_the_ID() , 'email' , true );
				    break;
				case 'location':
				    echo get_post_meta( get_the_ID() , 'location' , true );
				    break;
				case 'Event Id':
				     $cat= get_the_terms(get_the_ID(), 'agenda_cat');
				     echo $cat[0]->term_id;
				    break;
				default:
				    break;
			}
		}

		function speaker_column_sorts($columns){
		    $custom = array(
		    	'thumbnail'  => 'thumbnail',
		        'role'     => 'role',
		        'email'         => 'email',
		        'location'		=> 'location',
		        'Event Id' => 'Event Id',
		        
		    );
		    return wp_parse_args($custom, $columns);
		}
	}


endif;
