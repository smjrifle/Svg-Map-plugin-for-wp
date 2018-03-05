<?php

/**
* The plugin bootstrap file
*
* This file is read by WordPress to generate the plugin information in the plugin
* admin area. This file also includes all of the dependencies used by the plugin,
* registers the activation and deactivation functions, and defines a function
* that starts the plugin.
*
* @link              https://smjrifle.net
* @since             1.0.0
* @package           Svg_Map_By_Saedi
*
* @wordpress-plugin
* Plugin Name:       Svg Map By Saedi
* Plugin URI:        https://saediworks.com
* Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
* Version:           1.0.0
* Author:            Saedi Works
* Author URI:        https://smjrifle.net
* License:           GPL-2.0+
* License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
* Text Domain:       svg-map-by-saedi
* Domain Path:       /languages
*/

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
* The code that runs during plugin activation.
* This action is documented in includes/class-svg-map-by-saedi-activator.php
*/
function activate_svg_map_by_saedi() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-svg-map-by-saedi-activator.php';
	Svg_Map_By_Saedi_Activator::activate();
}

/**
* The code that runs during plugin deactivation.
* This action is documented in includes/class-svg-map-by-saedi-deactivator.php
*/
function deactivate_svg_map_by_saedi() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-svg-map-by-saedi-deactivator.php';
	Svg_Map_By_Saedi_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_svg_map_by_saedi' );
register_deactivation_hook( __FILE__, 'deactivate_svg_map_by_saedi' );

/**
* The core plugin class that is used to define internationalization,
* admin-specific hooks, and public-facing site hooks.
*/
require plugin_dir_path( __FILE__ ) . 'includes/class-svg-map-by-saedi.php';

/**
* Begins execution of the plugin.
*
* Since everything within the plugin is registered via hooks,
* then kicking off the plugin from this point in the file does
* not affect the page life cycle.
*
* @since    1.0.0
*/
function run_svg_map_by_saedi() {

	$plugin = new Svg_Map_By_Saedi();
	$plugin->run();

}
run_svg_map_by_saedi();


add_action( 'admin_menu', 'svg_map_setup_menu' );

function svg_map_setup_menu() {
	add_menu_page( 'SVG Map By Saedi', 'SVG Map', 'manage_options', 'svg-map-saedi', 'svg_map_init' );
}

function svg_map_init() {
	include( plugin_dir_path( __FILE__ ) . 'admin/svg-map.php' );
}

add_action( 'wp_ajax_save_data', 'save_data' );

function save_data() {
	global $wpdb;

	$points = esc_sql( $_POST['points'] );
	$popup = '';
	$table_name = $wpdb->prefix . 'svg_map';
	$i = 0;
	$map_points = implode( ',', array_map( 'absint', $points ) );
	$delete_unselected = $wpdb->query( "DELETE FROM $table_name WHERE map_point NOT IN ($map_points)" );
	foreach ( $points as $point ) {
		$fetch = $wpdb->get_results( "SELECT * FROM $table_name where map_point='$point'" );
		if ( $wpdb->num_rows == 0 ) {
			$result = $wpdb->insert(
				$table_name,
				array(
					'time' => current_time( 'mysql' ),
					'map_point' => $point,
					'map_popup' => $popup,
					)
			);
			if ( ! $result ) {
				echo 'Error Occured';
			} else {
				$i++;
			}
		}
	}
		echo $i . ' Points Added';

		wp_die();
}

	add_action( 'wp_ajax_delete_data', 'delete_data' );

function delete_data() {
	global $wpdb;

	$point = esc_sql( $_POST['point'] );
	$table_name = $wpdb->prefix . 'svg_map';
	$result = $wpdb->delete(
		$table_name,
		array(
		'id' => $point,
		)
	);
	if ( ! $result ) {
		echo 'Error Occured';
	}

	echo 'Points Deleted';

	wp_die();
}

	add_action( 'wp_ajax_add_popup', 'add_popup' );

function add_popup() {
	global $wpdb;

	$point = esc_sql( $_POST['point'] );
	$popup = esc_sql( $_POST['popup'] );
	$table_name = $wpdb->prefix . 'svg_map';
	$result = $wpdb->update(
		$table_name,
		array(
		'map_popup' => $popup,
		),
		array(
		'id' => $point,
		)
	);
	if ( ! $result ) {
		echo 'Error Occured';
	}

	echo 'Points Deleted';

	wp_die();
}

function display_map( $atts ) {
	include( plugin_dir_path( __FILE__ ) . 'public/partials/svg-map-by-saedi-public-display.php' );
	;
}
add_shortcode( 'display_svg_map', 'display_map' );
