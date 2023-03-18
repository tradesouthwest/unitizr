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

/inc/unitizr-postmeta.php

/inc/unitizr-quantity.php
