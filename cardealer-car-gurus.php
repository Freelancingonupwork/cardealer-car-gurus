<?php
/**
 * Plugin Name:       Car Dealer - Car Gurus
 * Plugin URI:        http://www.potenzaglobalsolutions.com/
 * Description:       This plugin contains CarGurus badge functionality for the "Car Dealer" theme.
 * Version:           1.0.0
 * Author:            Potenza Global Solutions
 * Author URI:        http://www.potenzaglobalsolutions.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       cardealer-car-gurus
 * Domain Path:       /languages
 *
 * @package cardealer-car-gurus
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! defined( 'CDCG_PATH' ) ) {
	define( 'CDCG_PATH', plugin_dir_path( __FILE__ ) );
}
if ( ! defined( 'CDCG_URL' ) ) {
	define( 'CDCG_URL', plugin_dir_url( __FILE__ ) );
}

if ( ! defined( 'CDCG_VERSION' ) ) {
	define( 'CDCG_VERSION', '1.0.0' );
}

add_action( 'wp_enqueue_scripts', 'cdcg_load_style_script', 10 ); // enqueue base scripts and styles.

/**
 * Add Javascript for CarGuru.
 */
function cdcg_load_style_script() {
	global $car_dealer_options;
	wp_register_script( 'cdcg-js', CDCG_URL . '/js/cargurus.js', array(), CDCG_VERSION, true );
	if ( isset( $car_dealer_options['enable_carguru'] ) && ( 1 === (int) $car_dealer_options['enable_carguru'] ) ) {
		$carguru_rating = $car_dealer_options['carguru_minimum_rating'];
		$carguru_height = $car_dealer_options['carguru_badge_height'];
		wp_localize_script(
			'cdcg-js',
			'cardealer_carguru',
			array(
				'carguru_rating' => $carguru_rating,
				'carguru_height' => $carguru_height,
			)
		);
		wp_enqueue_script( 'cdcg-js' );
	}
}

require_once trailingslashit( CDCG_PATH ) . 'inc/functions.php'; // phpcs:ignore WPThemeReview.CoreFunctionality.FileInclude.FileIncludeFound
