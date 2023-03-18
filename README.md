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

/inc/unitizr-functions.php

/inc/unitizr-adminpage.php

/inc/unitizr-postmeta.php

/inc/unitizr-quantity.php