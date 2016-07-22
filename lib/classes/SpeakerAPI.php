<?php

/**
*
*/

class SpeakerAPI
{

    function __construct()
    {
  
        add_action( 'admin_menu' , array($this, 'api_menu_register'));
        add_action( 'admin_init', array( $this, 'load_settings' ) );
    }

    /**
     *  speaker menu addition
     */
    function api_menu_register() {
        global $Speaker;
        $api = add_submenu_page( 'edit.php?post_type=speaker', __('Speaker API', SPEAKER_SLUG), __('API License', SPEAKER_SLUG), 'administrator', 'config_page', array($this, 'config_page') );
    }

    /**
     *  speaker Style addition
     */
    function speaker_style(){
        global $Speaker;
        wp_enqueue_style( 'tpl_css_settings', $Speaker->assetsUrl . 'css/settings.css');
    }

    /**
     *  speaker script addition
     */
    function speaker_script(){
        global $Speaker;
        wp_enqueue_style( 'wp-color-picker' );
        wp_enqueue_script( 'tpl_js_settings',  $Speaker->assetsUrl. 'js/settings.js', array('jquery','wp-color-picker'), '', true );
        $nonce = wp_create_nonce( $Speaker->nonceText() );
        wp_localize_script( 'tpl_js_settings', 'tpl_var', array('speaker_nonce' => $nonce) );
    }

    public function config_page() {

		$settings_tabs = array( SP()->sp_activation_tab_key => __( SP()->sp_menu_tab_activation_title, SP()->text_domain ), SP()->sp_deactivation_tab_key => __( SP()->sp_menu_tab_deactivation_title, SP()->text_domain ) );
		$current_tab = isset( $_GET[ 'tab' ] ) ? $_GET[ 'tab' ] : SP()->sp_activation_tab_key;
		$tab = isset( $_GET[ 'tab' ] ) ? $_GET[ 'tab' ] : SP()->sp_activation_tab_key;
		?>
		<div class='wrap'>
			<?php screen_icon(); ?>
			<h2><?php _e( SP()->sp_settings_title, SP()->text_domain ); ?></h2>

			<h2 class="nav-tab-wrapper">
			<?php
				foreach ( $settings_tabs as $tab_page => $tab_name ) {
					$active_tab = $current_tab == $tab_page ? 'nav-tab-active' : '';
					echo '<a class="nav-tab ' . $active_tab . '" href="?post_type=' . SP()->sp_deactivate_posttype .'&page=' . SP()->sp_activation_tab_key . '&tab=' . $tab_page . '">' . $tab_name . '</a>';
				}
			?>
			</h2>
				<form action='options.php' method='post'>
					<div class="main">
				<?php
					if( $tab == SP()->sp_activation_tab_key ) {
							settings_fields( SP()->sp_data_key );
							do_settings_sections( SP()->sp_activation_tab_key );
							submit_button( __( 'Save Changes', SP()->text_domain ) );
					} else {
							settings_fields( SP()->sp_deactivate_checkbox );
							do_settings_sections( SP()->sp_deactivation_tab_key );
							submit_button( __( 'Save Changes', SP()->text_domain ) );
					}
				?>
					</div>
				</form>
			</div>
			<?php
	}

	public function load_settings() {

		register_setting( SP()->sp_data_key, SP()->sp_data_key, array( $this, 'validate_options' ) );

		// API Key
		add_settings_section( SP()->sp_api_key, __( 'API License Activation', SP()->text_domain ), array( $this, 'wc_am_api_key_text' ), SP()->sp_activation_tab_key );

		add_settings_field( SP()->sp_api_test_mode, __( 'Testing Mode', SP()->text_domain ), array( $this, 'wc_am_api_test_mode' ), SP()->sp_activation_tab_key, SP()->sp_api_key );
		add_settings_field( 'status', __( 'API License Key Status', SP()->text_domain ), array( $this, 'wc_am_api_key_status' ), SP()->sp_activation_tab_key, SP()->sp_api_key );
		add_settings_field( SP()->sp_api_key, __( 'API License Key', SP()->text_domain ), array( $this, 'wc_am_api_key_field' ), SP()->sp_activation_tab_key, SP()->sp_api_key );
		add_settings_field( SP()->sp_activation_email, __( 'API License email', SP()->text_domain ), array( $this, 'wc_am_api_email_field' ), SP()->sp_activation_tab_key, SP()->sp_api_key );

		// Activation settings
		register_setting( SP()->sp_deactivate_checkbox, SP()->sp_deactivate_checkbox, array( $this, 'wc_am_license_key_deactivation' ) );
		add_settings_section( 'deactivate_button', __( 'API License Deactivation', SP()->text_domain ), array( $this, 'wc_am_deactivate_text' ), SP()->sp_deactivation_tab_key );
		add_settings_field( 'deactivate_button', __( 'Deactivate API License Key', SP()->text_domain ), array( $this, 'wc_am_deactivate_textarea' ), SP()->sp_deactivation_tab_key, 'deactivate_button' );

	}

	// Provides text for api key section
	public function wc_am_api_key_text() {
		//
	}

	public function wc_am_api_test_mode(){
		echo "<input type='radio' id='test_mode' name='" . SP()->sp_api_test_mode . "[" . SP()->sp_api_test_mode ."]' value='" . SP()->sp_options[SP()->sp_api_test_mode] . "' />Test<br>";
		echo "<input type='radio' id='live_mode' name='" . SP()->sp_api_test_mode . "[" . SP()->sp_api_test_mode ."]' value='" . SP()->sp_options[SP()->sp_api_live_mode] . "' />Live";
	}

	// Returns the API License Key status from the WooCommerce API Manager on the server
	public function wc_am_api_key_status() {
		$license_status = $this->license_key_status();
		$license_status_check = ( ! empty( $license_status['status_check'] ) && $license_status['status_check'] == 'active' ) ? 'Activated' : 'Deactivated';
		if ( ! empty( $license_status_check ) ) {
			echo $license_status_check;
		}
	}

	// Returns API License text field
	public function wc_am_api_key_field() {
		echo "<input id='api_key' name='" . SP()->sp_data_key . "[" . SP()->sp_api_key ."]' size='25' type='text' value='" . SP()->sp_options[SP()->sp_api_key] . "' />";
		//var_dump(SP()->sp_options[SP()->sp_api_key]);
		if ( SP()->sp_options[SP()->sp_api_key] ) {
			echo "<span class='dashicons dashicons-yes' style='color: #66ab03;'></span>";
		} else {
			echo "<span class='dashicons dashicons-no' style='color: #ca336c;'></span>";
		}
	}

	// Returns API License email text field
	public function wc_am_api_email_field() {
		echo "<input id='activation_email' name='" . SP()->sp_data_key . "[" . SP()->sp_activation_email ."]' size='25' type='text' value='" . SP()->sp_options[SP()->sp_activation_email] . "' />";
		if ( SP()->sp_options[SP()->sp_activation_email] ) {
			echo "<span class='dashicons dashicons-yes' style='color: #66ab03;'></span>";
		} else {
			echo "<span class='dashicons dashicons-no' style='color: #ca336c;'></span>";
		}
	}

	public function validate_options( $input ) {

		// Load existing options, validate, and update with changes from input before returning


		$options = SP()->options;

		$options[SP()->api_key] = trim( $input[SP()->api_key] );
		$options[SP()->activation_email] = trim( $input[SP()->activation_email] );
		$options[SP()->api_test_mode] = trim( $input[SP()->api_test_mode] );

		/**
		  * Plugin Activation
		  */
		$api_email = trim( $input[SP()->activation_email] );
		$api_key = trim( $input[SP()->api_key] );
		$api_test_mode = trim( $input[SP()->api_test_mode] );

		$activation_status = get_option( SP()->activated_key );
		$checkbox_status = get_option( SP()->deactivate_checkbox );

		$current_api_key = SP()->options[SP()->api_key];

		// Should match the settings_fields() value
		if ( $_REQUEST['option_page'] != SP()->deactivate_checkbox ) {

			if ( $activation_status == 'Deactivated' || $activation_status == '' || $api_key == '' || $api_email == '' || $checkbox_status == 'on' || $current_api_key != $api_key  ) {

				/**
				 * If this is a new key, and an existing key already exists in the database,
				 * deactivate the existing key before activating the new key.
				 */
				if ( $current_api_key != $api_key )
					$this->replace_license_key( $current_api_key );

				$args = array(
					'email' => $api_email,
					'licence_key' => $api_key,
					);

				$activate_results = json_decode( SP()->key()->activate( $args ), true );
				

				if ( $activate_results['activated'] === true ) {
					add_settings_error( 'activate_text', 'activate_msg', __( 'Plugin activated. ', SP()->text_domain ) . "{$activate_results['message']}.", 'updated' );
					update_option( SP()->activated_key, 'Activated' );
					update_option( SP()->deactivate_checkbox, 'off' );
				}

				if ( $activate_results == false ) {
					add_settings_error( 'api_key_check_text', 'api_key_check_error', __( 'Connection failed to the License Key API server. Try again later.', SP()->text_domain ), 'error' );
					$options[SP()->api_key] = '';
					$options[SP()->activation_email] = '';
					update_option( SP()->options[SP()->activated_key], 'Deactivated' );
				}

				if ( isset( $activate_results['code'] ) ) {

					switch ( $activate_results['code'] ) {
						case '100':
							add_settings_error( 'api_email_text', 'api_email_error', "{$activate_results['error']}. {$activate_results['additional info']}", 'error' );
							$options[SP()->activation_email] = '';
							$options[SP()->api_key] = '';
							update_option( SP()->options[SP()->activated_key], 'Deactivated' );
						break;
						case '101':
							add_settings_error( 'api_key_text', 'api_key_error', "{$activate_results['error']}. {$activate_results['additional info']}", 'error' );
							$options[SP()->sp_api_key] = '';
							$options[SP()->sp_activation_email] = '';
							update_option( SP()->sp_options[SP()->sp_activated_key], 'Deactivated' );
						break;
						case '102':
							add_settings_error( 'api_key_purchase_incomplete_text', 'api_key_purchase_incomplete_error', "{$activate_results['error']}. {$activate_results['additional info']}", 'error' );
							$options[SP()->sp_api_key] = '';
							$options[SP()->sp_activation_email] = '';
							update_option( SP()->sp_options[SP()->sp_activated_key], 'Deactivated' );
						break;
						case '103':
								add_settings_error( 'api_key_exceeded_text', 'api_key_exceeded_error', "{$activate_results['error']}. {$activate_results['additional info']}", 'error' );
								$options[SP()->sp_api_key] = '';
								$options[SP()->sp_activation_email] = '';
								update_option( SP()->sp_options[SP()->sp_activated_key], 'Deactivated' );
						break;
						case '104':
								add_settings_error( 'api_key_not_activated_text', 'api_key_not_activated_error', "{$activate_results['error']}. {$activate_results['additional info']}", 'error' );
								$options[SP()->sp_api_key] = '';
								$options[SP()->sp_activation_email] = '';
								update_option( SP()->sp_options[SP()->sp_activated_key], 'Deactivated' );
						break;
						case '105':
								add_settings_error( 'api_key_invalid_text', 'api_key_invalid_error', "{$activate_results['error']}. {$activate_results['additional info']}", 'error' );
								$options[SP()->sp_api_key] = '';
								$options[SP()->sp_activation_email] = '';
								update_option( SP()->sp_options[SP()->sp_activated_key], 'Deactivated' );
						break;
						case '106':
								add_settings_error( 'sub_not_active_text', 'sub_not_active_error', "{$activate_results['error']}. {$activate_results['additional info']}", 'error' );
								$options[SP()->sp_api_key] = '';
								$options[SP()->sp_activation_email] = '';
								update_option( SP()->sp_options[SP()->sp_activated_key], 'Deactivated' );
						break;
					}

				}

			} // End Plugin Activation

		}

		return $options;
	}

	// Returns the API License Key status from the WooCommerce API Manager on the server
	public function license_key_status() {
		$activation_status = get_option( SP()->sp_activated_key );

		$args = array(
			'email' => SP()->sp_options[SP()->sp_activation_email],
			'licence_key' => SP()->sp_options[SP()->sp_api_key],
			'test_mode' => SP()->sp_options[SP()->sp_api_test_mode],
			);
		
		return json_decode( SP()->key()->status( $args ), true );
	}

	// Deactivate the current license key before activating the new license key
	public function replace_license_key( $current_api_key ) {

		$args = array(
			'email' => SP()->sp_options[SP()->sp_activation_email],
			'licence_key' => $current_api_key,
			);

		$reset = SP()->key()->deactivate( $args ); // reset license key activation

		if ( $reset == true )
			return true;

		return add_settings_error( 'not_deactivated_text', 'not_deactivated_error', __( 'The license could not be deactivated. Use the License Deactivation tab to manually deactivate the license before activating a new license.', SP()->text_domain ), 'updated' );
	}

		// Deactivates the license key to allow key to be used on another blog
	public function wc_am_license_key_deactivation( $input ) {

		$activation_status = get_option( SP()->sp_activated_key );

		$args = array(
			'email' => SP()->sp_options[SP()->sp_activation_email],
			'licence_key' => SP()->sp_options[SP()->sp_api_key],
			);

		// For testing activation status_extra data
		// $activate_results = json_decode( AME()->key()->status( $args ), true );
		// print_r($activate_results); exit;

		$options = ( $input == 'on' ? 'on' : 'off' );

		if ( $options == 'on' && $activation_status == 'Activated' && SP()->sp_options[SP()->sp_api_key] != '' && SP()->sp_options[SP()->sp_activation_email] != '' ) {

			// deactivates license key activation
			$activate_results = json_decode( SP()->key()->deactivate( $args ), true );

			// Used to display results for development
			//print_r($activate_results); exit();

			if ( $activate_results['deactivated'] === true ) {
				$update = array(
					SP()->sp_api_key => '',
					SP()->sp_activation_email => ''
					);

				$merge_options = array_merge( SP()->sp_options, $update );

				update_option( SP()->sp_data_key, $merge_options );

				update_option( SP()->sp_activated_key, 'Deactivated' );

				add_settings_error( 'wc_am_deactivate_text', 'deactivate_msg', __( 'Plugin license deactivated. ', SP()->text_domain ) . "{$activate_results['activations_remaining']}.", 'updated' );

				return $options;
			}

			if ( isset( $activate_results['code'] ) ) {

				switch ( $activate_results['code'] ) {
					case '100':
						add_settings_error( 'api_email_text', 'api_email_error', "{$activate_results['error']}. {$activate_results['additional info']}", 'error' );
						$options[SP()->sp_activation_email] = '';
						$options[SP()->sp_api_key] = '';
						update_option( SP()->sp_options[SP()->sp_activated_key], 'Deactivated' );
					break;
					case '101':
						add_settings_error( 'api_key_text', 'api_key_error', "{$activate_results['error']}. {$activate_results['additional info']}", 'error' );
						$options[SP()->sp_api_key] = '';
						$options[SP()->sp_activation_email] = '';
						update_option( SP()->sp_options[SP()->sp_activated_key], 'Deactivated' );
					break;
					case '102':
						add_settings_error( 'api_key_purchase_incomplete_text', 'api_key_purchase_incomplete_error', "{$activate_results['error']}. {$activate_results['additional info']}", 'error' );
						$options[SP()->sp_api_key] = '';
						$options[SP()->sp_activation_email] = '';
						update_option( SP()->sp_options[SP()->sp_activated_key], 'Deactivated' );
					break;
					case '103':
							add_settings_error( 'api_key_exceeded_text', 'api_key_exceeded_error', "{$activate_results['error']}. {$activate_results['additional info']}", 'error' );
							$options[SP()->sp_api_key] = '';
							$options[SP()->sp_activation_email] = '';
							update_option( SP()->sp_options[SP()->sp_activated_key], 'Deactivated' );
					break;
					case '104':
							add_settings_error( 'api_key_not_activated_text', 'api_key_not_activated_error', "{$activate_results['error']}. {$activate_results['additional info']}", 'error' );
							$options[SP()->sp_api_key] = '';
							$options[SP()->sp_activation_email] = '';
							update_option( SP()->sp_options[SP()->sp_activated_key], 'Deactivated' );
					break;
					case '105':
							add_settings_error( 'api_key_invalid_text', 'api_key_invalid_error', "{$activate_results['error']}. {$activate_results['additional info']}", 'error' );
							$options[SP()->sp_api_key] = '';
							$options[SP()->sp_actSPivation_email] = '';
							update_option( SP()->sp_options[SP()->sp_activated_key], 'Deactivated' );
					break;
					case '106':
							add_settings_error( 'sub_not_active_text', 'sub_not_active_error', "{$activate_results['error']}. {$activate_results['additional info']}", 'error' );
							$options[SP()->sp_api_key] = '';
							$options[SP()->sp_activation_email] = '';
							update_option( SP()->sp_options[SP()->sp_activated_key], 'Deactivated' );
					break;
				}

			}

		} else {

			return $options;
		}

	}

	public function wc_am_deactivate_text() {}

	public function wc_am_deactivate_textarea() {

		echo '<input type="checkbox" id="' . SP()->sp_deactivate_checkbox . '" name="' . SP()->sp_deactivate_checkbox . '" value="on"';
		echo checked( get_option( SP()->sp_deactivate_checkbox ), 'on' );
		echo '/>';
		?><span class="description"><?php _e( 'Deactivates an API License Key.', SP()->text_domain ); ?></span>
		<?php
	}



}
