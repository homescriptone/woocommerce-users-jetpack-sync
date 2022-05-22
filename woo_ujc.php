<?php
/*
 * @wordpress-plugin
 * Plugin Name:       Sync WooCommerce Users with JetPack CRM
 * Plugin URI:        https://dev.homescriptone.com
 * Description:       Sync WooCommerce Users with JetPack CRM
 * Version:           1.0.0
 * Author:            HomeScript
 * Author URI:        https://dev.homescriptone.com
 * License:           GPL-3.0+
 * License URI:       http://www.gnu.org/licenses/gpl-3.0.txt
 * Text Domain:       woo_ujc
 * Domain Path:       /languages
 */

define('WOO_UJC_JETPACK_CRM_API_KEY', 'Put your jetpack crm api key');
define('WOO_UJC_JETPACK_CRM_API_SECRET', 'Put your jetpack crm api secret key');
define('WOO_UJC_JETPACK_CRM_API_ENDPOINTS', 'Put your jetpack crm api endpoints');


add_action("woocommerce_created_customer",'woo_ujc_add_new_users_to_sys' );


function woo_ujc_add_new_users_to_sys( $customer_id ){
    $wc_customer   = new WC_Customer( $customer_id );
    
    $data = array(
		'status' => 'Lead',
		'fname'  => 'Put your full name',
		'email'  => 'Put your email address',
		'country'  => 'Africa-BJ',
	);

	$curl = curl_init();

    curl_setopt_array($curl, array(
    CURLOPT_URL => WOO_UJC_JETPACK_CRM_API_ENDPOINTS.'/create_customer?api_key='.WOO_UJC_JETPACK_CRM_API_KEY.'&api_secret='. WOO_UJC_JETPACK_CRM_API_SECRET,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS => wp_json_encode( $data ),
    CURLOPT_HTTPHEADER => array(
        'Content-Type: application/json'
    ),
    ));

    curl_exec($curl);

    curl_close($curl);
    
}
