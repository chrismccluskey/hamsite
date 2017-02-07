<?php
/*
 * Plugin Name: Virtual QSO Cards
 * Plugin URI:  http://chris.mccluskey.us/wordpress-plugins/virtual-qso-cards
 * Description: Virtual corkboard of QSO cards
 * Version:		20170206
 * Author:		Chris McCluskey
 * Author URI:	http://chris.mccluskey.us
 * License:		MIT
 * License URI: https://opensource.org/licenses/MIT
 * Text Domain: virtual-qso-cards
 * Domain Paht: /languages
 */

function vqsoc_setup_post_types() {
	register_post_type( 'virtual-qso-card', [
		'labels' => [
			'name'			=> __('Virtual QSO Cards'),
			'singular_name'	=> __('Virtual QSO Card'),
		],
		'public'	  => 'true',
		'has_archive' => 'true',
	] );
}
add_action( 'init', 'vqsoc_setup_post_types' );

function vqsoc_admin_menu() {
	add_options_page( 'Virtual QSO Card Options', 'Virtual QSO Cards', 'manage_options', 'virtual-qso-cards', 'vqsoc_plugin_options' );
}
add_action( 'admin_menu', 'vqsoc_admin_menu' );

function vqsoc_plugin_options() {
	if ( !current_user_can( 'manage_options' ) ) {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}
	echo '<div class="wrap">';
	echo 'Your Callsign: <input type="text" name="callsign" /><br />';
	echo 'Your Grid Square: <input type="text" name="gridsquare" />';
	echo '</div>';
}

function vqsoc_activate() {

	vqsoc_setup_post_types();

	flush_rewrite_rules();

}
register_activation_hook( __FILE__, 'vqsoc_activate' );

function vqsoc_deactivate() {

	flush_rewrite_rules();

}
register_deactivation_hook( __FILE__, 'vqsoc_deactivate' );

