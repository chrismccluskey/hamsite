<?php
/*
 * Plugin Name: Virtual QSL Cards
 * Plugin URI:  http://chris.mccluskey.us/wordpress-plugins/virtual-qsl-cards
 * Description: Virtual corkboard of QSL cards
 * Version:		20170206
 * Author:		Chris McCluskey
 * Author URI:	http://chris.mccluskey.us
 * License:		MIT
 * License URI: https://opensource.org/licenses/MIT
 * Text Domain: virtual-qsl-cards
 * Domain Paht: /languages
 */

// prevent calling the file directory
if ( !defined( 'WPINC' ) ) {
	die();
}

function vqslc_setup_post_types() {
	register_post_type( 'virtual-qsl-card', [
		'labels' => [
			'name'			=> __('Virtual QSL Cards'),
			'singular_name'	=> __('Virtual QSL Card'),
		],
		'public'	  => 'true',
		'has_archive' => 'true',
		'rewrite'	  => ['slug' => 'qsl'],
	] );
	remove_post_type_support( 'virtual-qsl-card', 'title' );
	remove_post_type_support( 'virtual-qsl-card', 'editor' );
}
add_action( 'init', 'vqslc_setup_post_types' );

function vqslc_admin_menu() {
	add_options_page( 'Virtual QSL Card Options', 'Virtual QSL Cards', 'manage_options', 'virtual-qsl-cards', 'vqslc_plugin_options' );
}
add_action( 'admin_menu', 'vqslc_admin_menu' );

function vqslc_plugin_options() {
	if ( !current_user_can( 'manage_options' ) ) {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}
	echo '<div class="wrap">';
	echo 'Your Callsign: <input type="text" name="callsign" /><br />';
	echo 'Your Grid Square: <input type="text" name="gridsquare" />';
	echo '</div>';
}

function vqslc_activate() {

	vqslc_setup_post_types();

	flush_rewrite_rules();

}
register_activation_hook( __FILE__, 'vqslc_activate' );

function vqslc_deactivate() {

	flush_rewrite_rules();

}
register_deactivation_hook( __FILE__, 'vqslc_deactivate' );

function vqslc_page_template( $template ) {
	if( get_post_type() === 'virtual-qsl-card' ) {
		$new_template = __DIR__ . '/templates/single-virtual-qsl-card.php';
		if ( $new_template !== '' ) {
			return $new_template;
		}
	}
	return $template;
}
add_filter( 'template_include', 'vqslc_page_template', 99 );

function vqslc_add_custom_box() {
	$screens = ['virtual-qsl-card'];
	foreach($screens as $screen) {
		add_meta_box(
			'vqslc_box_id',
			'Virtual QSL Card',
			'vqslc_custom_box_html',
			$screen
		);
	}
}
add_action('add_meta_boxes', 'vqslc_add_custom_box');

function vqslc_custom_box_html() {
	$post_id = get_the_ID();

	$post_meta = get_post_meta( $post_id, '');
	$your_call_sign = $post_meta['_vqslc_your_call_sign'][0];
	$your_name_and_address = $post_meta['_vqslc_your_name_and_address'][0];
	$contacted_station_call_sign = $post_meta['_vqslc_contacted_station_call_sign'][0];
	$qsl_date = $post_meta['_vqslc_qsl_date'][0];
	$qsl_time = $post_meta['_vqslc_qsl_time'][0];
	$qsl_frequency_or_band = $post_meta['_vqslc_qsl_frequency_or_band'][0];
	$qsl_mode = $post_meta['_vqslc_qsl_mode'][0];
	$qsl_rst = $post_meta['_vqslc_qsl_rst'][0];
	$qsl_message = $post_meta['_vqslc_qsl_message'][0];
?>
<style>
#normal-sortables {
	display: none;
}
#advanced-sortables {
	position: relative;
	top: -1.5em;
}
</style>
	your call sign: <input type="text" name="your_call_sign" value="<?php echo $your_call_sign; ?>" /><br />
your name and address: <input type="text" name="your_name_and_address" value="<?php echo $your_name_and_address; ?>" /><br />
<hr />
- the call of the station you contacted: <input type="text" name="contacted_station_call_sign" value="<?php echo $contacted_station_call_sign; ?>" /><br />
- the date (use DD/MM/YY to comply with most countries): <input type="text" name="qsl_date" value="<?php echo $qsl_date; ?>" /> UTC<br />
- time in UTC (Coordinated Universal Time): <input type="text" name="qsl_time" value="<?php echo $qsl_time; ?>" /> UTC<br />
- frequency or band: <input type="text" name="qsl_frequency_or_band" value="<?php echo $qsl_frequency_or_band; ?>" /><br />
- mode (SSB, CW, Rtty, etc.): <input type="text" name="qsl_mode" value="<?php echo $qsl_mode; ?>" /><br />
- RST: <input type="text" name="qsl_rst" value="<?php echo $qsl_rst; ?>" /><br />
a request to QSL or thanks for a QSL received.: <input type="text" name="message" value="<?php echo $message; ?>" /><br />
	<?php
}

function vqslc_save_post($post_id, $post) {
	if( empty( $post_id ) || empty( $post ) || empty( $_POST ) ) return;
	if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
	if( ! current_user_can( 'edit_post', $post_id ) ) return;
	if( $post->post_type != 'virtual-qsl-card' ) return;

	$post->post_title = implode(' - ', [ $_POST['contacted_station_call_sign'], $_POST['qsl_date'], $_POST['qsl_time'] ]);
	update_post_meta( $post_id, '_vqslc_your_call_sign', $_POST['your_call_sign'] );
	update_post_meta( $post_id, '_vqslc_your_name_and_address', $_POST['your_name_and_address'] );
	update_post_meta( $post_id, '_vqslc_contacted_station_call_sign', $_POST['contacted_station_call_sign'] );
	update_post_meta( $post_id, '_vqslc_qsl_date', $_POST['qsl_date'] );
	update_post_meta( $post_id, '_vqslc_qsl_time', $_POST['qsl_time'] );
	update_post_meta( $post_id, '_vqslc_qsl_frequency_or_band', $_POST['qsl_frequency_or_band'] );
	update_post_meta( $post_id, '_vqslc_qsl_mode', $_POST['qsl_mode'] );
	update_post_meta( $post_id, '_vqslc_qsl_rst', $_POST['qsl_rst'] );
	update_post_meta( $post_id, '_vqslc_qsl_message', $_POST['qsl_message'] );
}
add_action('save_post', 'vqslc_save_post', 2, 2);
