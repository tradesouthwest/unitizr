## Unitizr

## Load Order

unitizr.php
- register_activation_hook
- register_deactivation_hook
- add_action( 'admin_enqueue_scripts',  'unitizr_addtoplugin_scripts' );
    - unitizr-admin
    - unitizr-plugin
- add_action( 'wp_enqueue_scripts', 'unitizr_addtosite_scripts' );
    - jquery-ui-datepicker
    - jquery-ui
    - unitizr-public


> /inc/unitizr-functions.php replaced by /includes/unitizr-functions.php
##### Before ver 1.1.0
- add_filter( 'woocommerce_get_sections_products', 'unitizr_add_section' );
- add_filter( 'woocommerce_get_settings_products', 'unitizr_add_settings', 12, 2 );
##### After
- add_filter( 'woocommerce_get_sections_products', 'unitizr_add_section' );
- add_filter( 'woocommerce_get_settings_products', 'unitizr_add_settings', 12, 2 );
    - changed slug to match before ver!

> /inc/unitizr-adminpage.php replaced by /include/unitizr-core.php
##### Before ver 1.1.0
- add_action( 'admin_menu', 'unitizr_add_options_page' ); 
    - unitizr_options_page unitizr_options_section
- add_action( 'admin_init', 'unitizr_register_admin_options' ); 
    - register_setting( 'unitizr_options', 'unitizr_options' );
##### After
- add_action( 'admin_menu', 'unitizr_add_options_page' ); 
    - unitizr_options_page unitizr_options_section
- add_action( 'admin_init', 'unitizr_register_admin_options' ); 
    - register_setting( 'unitizr_options', 'unitizr_options' );

> /inc/unitizr-postmeta.php replaced by /include/unitizr-postmeta.php
##### Before ver 1.1.0
- add_action( 'woocommerce_product_options_general_product_data', 'unitizr_general_product_data_field' );
    - unitizr_general_product_data_field() 
- add_action( 'woocommerce_process_product_meta', 'unitizr_save_unitizr_fee' )
    - unitizr_fee
- add_filter( 'woocommerce_order_item_product', 'unitizr_order_item_product', 10, 2 )
    - unitizr_custom_option -> removed/replaced 
- add_filter( 'woocommerce_order_item_display_meta_key', 'change_order_item_meta_title', 20, 3 )
    - change_order_item_meta_title
- add_filter( 'woocommerce_order_item_get_formatted_meta_data', 'change_formatted_meta_data') NOT LOADED!

##### After
- add_action( 'woocommerce_product_options_general_product_data', 'unitizr_general_product_data_field' );
    - function unitizr_plus_general_product_data_field() backwards compat->[rename unitizr_plus_fee to unitizr_fee]
- add_action( 'woocommerce_process_product_meta', 'unitizr_save_unitizr_fee' );
- add_filter( 'woocommerce_order_item_product', 'unitizr_order_item_product', 10, 2 )
    - unitizr_plus_numberof & unitizr_plus_begin_date -> new values
- add_filter( 'woocommerce_order_item_display_meta_key', 'unitizr_change_order_item_meta_title' );
    - unitizr_change_order_item_meta_title

> /inc/unitizr-quantity.php
##### Before ver 1.1.0
##### After

> /include/unitizr-product-functions.php
- add_action('woocommerce_product_options_general_product_data', 'unitizr_plus_products_general_editor_fields');
- add_action( 'woocommerce_process_product_meta', 'unitizr_plus_products_save_plus_fields' );
- add_action( 'wp_enqueue_scripts', 'unitizr_plus_products_enqueue_woospecific' );
- add_action( 'wp_enqueue_scripts', 'unitizr_plus_products_override_woocommerce_buttons' );

> /include/admin/unitizr-admin-page.php