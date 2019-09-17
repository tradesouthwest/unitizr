<?php
/**
 * Delete our options when this plugin is deleted
 */
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}
global $wpdb;
// Delete options.
$wpdb->query( "DELETE FROM $wpdb->options WHERE option_name LIKE 'unitizr\_%';" );
$unitizr_options = array(
	'unitizr_cstitle_field',
	'unitizr_csdescription_field',
	'unitizr_wndinwidth_field',
	'unitizr_wndtaxbase_field'
);
foreach( $unitizr_options as $option ) {
	delete_option( $option );
}
