<?php 
// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {	exit; }
/**
 * Create the section beneath the products tab
 **/
add_filter( 'woocommerce_get_sections_products', 'unitizr_add_section' );
function unitizr_add_section( $sections ) {
	
	$sections['unitizr'] = __( 'Unitizr', 'unitizr' );
	return $sections;
	
}

/**
 * Add settings to the specific section we created before
 */
add_filter( 'woocommerce_get_settings_products', 'unitizr_add_settings', 12, 2 );
function unitizr_add_settings( $settings, $current_section ) 
{

	/**
	 * Check the current section is what we want
	 **/
	if ( $current_section == 'unitizr' ) 
	{ 

	$unitizr_settings = array(
	array(
		'desc'     => __( 'Unitizr Settings Section can be found here:', 'unitizr' ),
		'type'      => 'title',
		'id'     => 'unitizr-h4',
		),
	
		
    array( 
		'name' => __( 'Unitizr Settings Link', 'unitizr' ), 
		'type' => 'title', 
        'desc' => '<a class="button wnd-centered" href="'. admin_url('options-general.php?page=unitizr') .'">Unitizr</a>',
		'id' => 'unitizr_link_topage' 
		    ),
		);
		
		return $unitizr_settings;

    /*
	 * If not, return the standard settings
	 */
	} else {
		return $settings;
    }
}
