<?php
/**
 * Delete our options when this plugin is deleted
 */
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

if ( is_plugin_active( 'unitizr-plus/unitizr-plus.php' ) ) { return; }
// Delete options.
global $wpdb;
$options = array(
	'unitizr_cstitle_field',
	'unitizr_csdescription_field',
	'unitizr_wndproduct_field',
	'unitizr_wndinwidth_field',
	'unitizr_wndtaxbase_field',
	'unitizr_begin_date',
	'unitizr_wndinppd_field',
	'unitizr_wndnada_field',
	'unitizr_wndmatch_field'
);
foreach( $options as $option ) {
	delete_option( $option );
}
