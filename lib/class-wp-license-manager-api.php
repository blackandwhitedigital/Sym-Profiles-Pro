<?php
/**
 * The API handler for handling API requests from themes and plugins using
 * the license manager.
 *
 * @package    Wp_License_Manager
 * @subpackage Wp_License_Manager/public
 * @author     Jarkko Laine <jarkko@jarkkolaine.com>
 */
//require('Wp_License_Manager_Public.php');
class Wp_License_Manager_API {

	
	/**
	 * Checks the parameters and verifies the license, then forwards the request to the
	 * actual API request handlers.
	 *
	 * @param $action_function  callable    The function (or array with class and function) to call
	 * @param $params           array       The WordPress request parameters.
	 * @return array            API response.
	 */



	public function verify_license_and_execute( $action_function, $params ) {
		
	    if ( ! isset( $params['p'] ) || ! isset( $params['e'] ) || ! isset( $params['l'] ) ) {
	        return $this->error_response( 'Invalid request' );
	    }
	 
	    $product_id = $params['p'];
	    $email = $params['e'];
	    $license_key = $params['l'];
	 
	    // Find product
	    $posts = get_posts(
	        array (
	            'name' => $product_id,
	            'post_type' => 'wplm_product',
	            'post_status' => 'publish',
	            'numberposts' => 1
	        )
	    );
	 
	    if ( ! isset( $posts[0] ) ) {
	        return $this->error_response( 'Product not found.' );
	    }
	 
	    // Verify license
	    if ( ! $this->verify_license( $posts[0]->ID, $email, $license_key ) ) {
	        return $this->error_response( 'Invalid license or license expired.' );
	    }
	 
	    // Call the handler function
	    return call_user_func_array( $action_function, array( $posts[0], $product_id, $email, $license_key ) );
	}

	/**
	 * Checks whether a license with the given parameters exists and is still valid.
	 *
	 * @param $product_id   int     The numeric ID of the product.
	 * @param $email        string  The email address attached to the license.
	 * @param $license_key  string  The license key.
	 * @return bool                 true if license is valid. Otherwise false.
	 */
	private function verify_license( $product_id, $email, $license_key ) {
	    $license = $this->find_license( $product_id, $email, $license_key );
	    if ( ! $license ) {
	        return false;
	    }
	 
	    $valid_until = strtotime( $license['valid_until'] );
	    if ( $license['valid_until'] != '0000-00-00 00:00:00' && time() > $valid_until ) {
	        return false;
	    }
	 
	    return true;
	}

	/**
	 * Looks up a license that matches the given parameters.
	 *
	 * @param $product_id   int     The numeric ID of the product.
	 * @param $email        string  The email address attached to the license.
	 * @param $license_key  string  The license key
	 * @return mixed                The license data if found. Otherwise false.
	 */
	private function find_license( $product_id, $email, $license_key ) {
	    global $wpdb;
	    $table_name = $wpdb->prefix . 'product_licenses';
	 
	    $licenses = $wpdb->get_results(
	        $wpdb->prepare( "SELECT * FROM $table_name WHERE product_id = %d AND email = '%s' AND license_key = '%s'",
	            $product_id, $email, $license_key ), ARRAY_A );
	 
	    if ( count( $licenses ) > 0 ) {
	        return $licenses[0];
	    }
	 
	    return false;
	}
	/**
	 * Generates and returns a simple error response. Used to make sure every error
	 * message uses same formatting.
	 *
	 * @param $msg      string  The message to be included in the error response.
	 * @return array    The error response as an array that can be passed to send_response.
	 */
	public function error_response( $msg ) {
	    return array( 'error' => $msg );
	}

 
}
