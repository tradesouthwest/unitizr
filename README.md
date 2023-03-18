## Unitizr

# Load Order

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

#### After ver 1.1.0
/inc/unitizr-functions.php

/inc/unitizr-adminpage.php replaced by /include/unitizr-core.php

/inc/unitizr-postmeta.php replaced by /include/unitizr-postmeta.php
- add_action( 'woocommerce_product_options_general_product_data', 'unitizr_general_product_data_field' );
- add_action( 'woocommerce_process_product_meta', 'unitizr_save_unitizr_fee' );
- add_filter( 'woocommerce_order_item_product', 'unitizr_order_item_product', 10, 2 ); 
- add_filter( 'woocommerce_order_item_display_meta_key', 'change_order_item_meta_title', 20, 3 );
- add_filter( 'woocommerce_order_item_get_formatted_meta_data', 'change_formatted_meta_data', 20, 2 ); (NOT LOADED)


/inc/unitizr-quantity.php