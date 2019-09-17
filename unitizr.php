<?php
/**
 * Plugin Name:       Unitizr
 * Plugin URI:        https://themes.tradesouthwest.com/wordpress/plugins/
 * Description:       For WooCommerce, adds number of days to checkout. Opens under WooCommerce > Settings > Products > unitizr.
 * Version:           1.0.2
 * Author:            Larry Judd
 * Author URI:        http://tradesouthwest.com
 * @wordpress-plugin  wpdb =
 * License:           GPLv2 or later
 * License URI:       http://www.gnu.org/licenses/gpl-3.0.html
 * Requires Package:  WooCommerce 3.0+
 * Requires at least: 4.5
 * Tested up to:      5.2.2
 * Requires PHP:      5.4
 * Text Domain:       unitizr
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) { exit; }

if (!defined('UNITIZR_VER')) { define('UNITIZR_VER', '1.0.2'); } 
//activate/deactivate hooks
function unitizr_plugin_activation() {

    // Check for WooCommerce
    if (!class_exists('WooCommerce')) {
    printf('<div class="error"><p>%s</p></div>', 
    esc_html__('This plugin requires that WooCommerce is installed and activated.',
              'unitizr') 
    ); 
    return;
    }
}
function unitizr_plugin_deactivation() {
    //unitizrs_deregister_shortcode() 
        return false;
}

//activate and deactivate registered
register_activation_hook( __FILE__, 'unitizr_plugin_activation');
register_deactivation_hook( __FILE__, 'unitizr_plugin_deactivation');

if( is_admin() ) : 
//enqueue scripts
function unitizr_addtoplugin_scripts() 
{
    wp_enqueue_style( 'unitizr-admin',  plugin_dir_url(__FILE__) 
                      . 'lib/unitizr-admin-style.css',
                      array(), UNITIZR_VER, false );
    // Register Scripts
    wp_register_script( 'unitizr-plugin', 
       plugins_url( 'lib/unitizr-plugin.js', __FILE__ ), 
                    array( 'jquery' ), true );
                    
    wp_enqueue_style ( 'unitizr-admin' ); 
    wp_enqueue_script( 'unitizr-plugin' );
    
}
//load admin scripts as well
add_action( 'admin_enqueue_scripts',  'unitizr_addtoplugin_scripts' );
endif;

//public scripts
function unitizr_addtosite_scripts()
{
    wp_enqueue_script('jquery-ui-datepicker');
    wp_enqueue_style( 'jquery-ui',  plugin_dir_url(__FILE__) 
                      . 'lib/jquery-ui.css',
                      array(), '', false );
    wp_enqueue_style( 'unitizr-public',  plugin_dir_url(__FILE__) 
                      . 'lib/unitizr-public-style.css',
                      array(), UNITIZR_VER, false );
}
add_action( 'wp_enqueue_scripts', 'unitizr_addtosite_scripts' );

//load language scripts     
function unitizr_load_text_domain() 
{
    load_plugin_textdomain( 'unitizr', false, 
    basename( dirname( __FILE__ ) ) . '/languages' ); 
}
require ( plugin_dir_path( __FILE__ ) . 'inc/unitizr-functions.php' ); 
//include admin and public views
require ( plugin_dir_path( __FILE__ ) . 'inc/unitizr-adminpage.php' ); 
require ( plugin_dir_path( __FILE__ ) . 'inc/unitizr-postmeta.php' ); 
require ( plugin_dir_path( __FILE__ ) . 'inc/unitizr-quantity.php' ); 
?>