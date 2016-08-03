
<?php
/**
 * The API handler for handling API requests from themes and plugins using
 * the license manager.
 *
 * @package    Wp_License_Manager
 * @subpackage Wp_License_Manager/public
 * @author     Jarkko Laine <jarkko@jarkkolaine.com>
 */
require ('class-wp-license-manager-api.php');
class Wp_License_Manager_Public extends Wp_License_Manager_API {
	/**
 * @var     License_Manager_API     The API handler
 */
private $api;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @var      string    $plugin_name       The name of the plugin.
	 * @var      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {
	    $this->plugin_name = $plugin_name;
	    $this->version = $version;
	    //$this->api = new Wp_License_Manager_API(); 
	     

	    // The external API setup
		add_filter( 'query_vars', array( $this, 'add_api_query_vars' ));
		add_action( 'parse_request', array( $this, 'sniff_api_requests' ));
		add_action( 'init', array( $this, 'add_api_endpoint_rules' ));
	  


	}
/**
	 * Defines the query variables used by the API.
	 *
	 * @param $vars     array   Existing query variables from WordPress.
	 * @return array    The $vars array appended with our new variables
	 */
	public function add_api_query_vars( $vars ) {
		
		
	    // The parameter used for checking the action used
	    $vars []= '__wp_license_api';
		
	    // Additional parameters defined by the API requests
	    $api_vars = $this->api->get_api_vars();
	 
	    return array_merge( $vars, $api_vars );
	}

	/**
	 * Returns a list of variables used by the API
	 *
	 * @return  array    An array of query variable names.
	 */
	public function get_api_vars() {
		
	    return array( 'l',  'e', 'p' );
	}



	/**
	 * A sniffer function that looks for API calls and passes them to our API handler.
	 */
	public function sniff_api_requests() {
	    global $wp;
	    if ( isset( $wp->query_vars['__wp_license_api'] ) ) {
	        $action = $wp->query_vars['__wp_license_api'];
	        $this->api->handle_request( $action, $wp->query_vars );
	 
	        exit;
	    }
	}

	/**
	 * The handler function that receives the API calls and passes them on to the
	 * proper handlers.
	 *
	 * @param $action   string  The name of the action
	 * @param $params   array   Request parameters
	 */
	public function handle_request( $action, $params ) {
		
	    switch ( $action ) {
	        case 'info':
	        $arrainfo= new Wp_License_Manager_API();
		    $response = $arrainfo->verify_license_and_execute( array( $this, 'product_info' ), $params );
		    break;

	        case 'get':
	            break;
	 
	        default:
	            $arrainfo= new Wp_License_Manager_API();
		    $response = $arrainfo->error_response( 'No such API action' );
	            break;
	    }
	 
	    $this->send_response($response);
	}

	/**
	 * Prints out the JSON response for an API call.
	 *
	 * @param $response array   The response as associative array.
	 */
	private function send_response($response) {
		
	    echo json_encode( $response );
	}

	

	/**
	 * The permalink structure definition for API calls.
	 */
	public function add_api_endpoint_rules() {
	    add_rewrite_rule( 'api/license-manager/v1/(info|get)/?',
	        'index.php?__wp_license_api=$matches[1]', 'top' );
	 
	    // If this was the first time, flush rules
	    if ( get_option( 'wp-license-manager-rewrite-rules-version' ) != '1.1' ) {
	        flush_rewrite_rules();
	        update_option( 'wp-license-manager-rewrite-rules-version', '1.1' );
	    }
	}


}