<?php
/**
 * Cardealer car gurus functions.
 *
 * @author  TeamWP @Potenza Global Solutions
 * @package cardealer-car-gurus
 * @version 1.0.0
 */

/**
 * Function to add Geo Fencing button in cardealer panel.
 *
 * @param array $features features.
 */
function cdcg_extend_cardealer_other_fetures( $features ) {

	$features['car-gurus'] = array(
		'title' => esc_html__( 'Car Gurus', 'cardealer-car-gurus' ),
		'link'  => admin_url( 'themes.php?page=cardealer&tab=23' ),
		'desc'  => esc_html__( 'Click this button to open Car Gurus section.', 'cardealer-car-gurus' ),
	);

	return $features;
}
add_filter( 'cardealer_other_fetures', 'cdcg_extend_cardealer_other_fetures' );

if ( ! function_exists( 'cardealer_get_car_guru_badge_html' ) ) {
	/**
	 * Get car gurubad
	 *
	 * @param string $id .
	 */
	function cardealer_get_car_guru_badge_html( $id ) {
		global $car_dealer_options;
		if ( empty( $id ) || ! isset( $car_dealer_options['enable_carguru'] ) || ( '0' === $car_dealer_options['enable_carguru'] ) ) {
			return;
		}
		$vin = wp_get_post_terms( $id, 'car_vin_number' );
		if ( isset( $vin[0]->name ) && ! empty( $vin[0]->name ) ) {
			$price_arr = cardealer_get_car_price_array( $id );
			if ( ! empty( $price_arr ) ) {

				$final_price = $price_arr['regular_price'];
				if ( 0 < $price_arr['sale_price'] ) {
					$final_price = $price_arr['sale_price'];
				}
				return '<span class="cd-vehicle-gurus" data-cg-vin="' . esc_attr( $vin[0]->name ) . '" data-cg-price="' . esc_attr( $final_price ) . '"></span>';
			}
		}
	}
}

add_filter( 'cardealer_vrs_link_html', 'cardealer_update_stamp_html', 10, 2 );
if ( ! function_exists( 'cardealer_update_stamp_html' ) ) {
	/**
	 * Update stamp html
	 *
	 * @param string $html .
	 * @param string $id .
	 */
	function cardealer_update_stamp_html( $html, $id ) {
		$carguru_html = cardealer_get_car_guru_badge_html( $id );
		if ( ! empty( $carguru_html ) ) {
			$html .= $carguru_html;
		}
		return $html;
	}
}

/**
 * Add Theme Options.
 *
 * @param string $opt_name option name.
 */
function car_dealer_options__cargurus_settings( $opt_name ) {
	Redux::setSection(
		$opt_name,
		array(
			'title'            => esc_html__( 'CarGurus Settings', 'cardealer-car-gurus' ),
			'id'               => 'cargurus_settings',
			'subsection'       => true,
			'customizer_width' => '450px',
			'icon'             => 'fas fa-chevron-right',
			'fields'           => array(
				array(
					'id'    => 'carguru_notice',
					'type'  => 'info',
					'style' => 'info',
					'title' => esc_html__( 'Note: ', 'cardealer-car-gurus' ),
					'desc'  => esc_html__( 'The CarGurus badge requires an active subscription to CarGurus.', 'cardealer-car-gurus' ),
				),
				array(
					'title'   => esc_html__( 'Enable CarGuru', 'cardealer-car-gurus' ),
					'desc'    => esc_html__( 'Enable / Disable CarGuru feature', 'cardealer-car-gurus' ),
					'id'      => 'enable_carguru',
					'type'    => 'button_set',
					'options' => array(
						'1' => esc_html__( 'Yes', 'cardealer-car-gurus' ),
						'0' => esc_html__( 'No', 'cardealer-car-gurus' ),
					),
					'default' => '0',
				),
				array(
					'title'    => esc_html__( 'Minimum Rating', 'cardealer-car-gurus' ),
					'desc'     => esc_html__( 'Minimum rating to display for vehicles', 'cardealer-car-gurus' ),
					'id'       => 'carguru_minimum_rating',
					'type'     => 'button_set',
					'options'  => array(
						'GREAT_PRICE' => esc_html__( 'Great Deal', 'cardealer-car-gurus' ),
						'GOOD_PRICE'  => esc_html__( 'Good Deal', 'cardealer-car-gurus' ),
						'FAIR_PRICE'  => esc_html__( 'Fair Deal', 'cardealer-car-gurus' ),
					),
					'default'  => 'FAIR_PRICE',
					'required' => array( 'enable_carguru', '=', '1' ),
				),
				array(
					'title'         => esc_html__( 'Height', 'cardealer-car-gurus' ),
					'desc'          => esc_html__( 'Height of badges(in pixels).', 'cardealer-car-gurus' ),
					'id'            => 'carguru_badge_height',
					'type'          => 'slider',
					'default'       => '40',
					'min'           => 40,
					'max'           => 200,
					'step'          => 1,
					'display_value' => 'text',
					'required'      => array( 'enable_carguru', '=', '1' ),
				),
			),
		)
	);
}
add_action( 'car_dealer_options_after_vehicle_settings', 'car_dealer_options__cargurus_settings' );
