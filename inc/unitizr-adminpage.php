<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @package    unitizr
 * @subpackage /inc
 * @author     Larry Judd <tradesouthwest@gmail.com>
 * TODO add a field in the order table (admin side)
 */
// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {	exit; }

add_action( 'admin_menu', 'unitizr_add_options_page' ); 
add_action( 'admin_init', 'unitizr_register_admin_options' ); 

//create an options page
function unitizr_add_options_page() 
{
   add_submenu_page(
       'options-general.php',
        esc_html__( 'Unitizr', 'woocommerce' ),
        esc_html__( 'Unitizr', 'woocommerce' ),
        'manage_options',
        'unitizr',
        'unitizr_options_page',
        'dashicons-admin-tools' 
    );
}   
 
/** a.) Register new settings
 *  $option_group (page), $option_name, $sanitize_callback
 *  --------
 ** b.) Add sections
 *  $id, $title, $callback, $page
 *  --------
 ** c.) Add fields 
 *  $id, $title, $callback, $page, $section, $args = array() 
 *  --------
 ** d.) Options Form Rendering. action="options.php"
 *
 */

// a.) register all settings groups
function unitizr_register_admin_options() 
{
    //options pg
    register_setting( 'unitizr_options', 'unitizr_options' );
     

/**
 * b1.) options section
 */        
    add_settings_section(
        'unitizr_options_section',
        esc_html__( 'Configuration and Settings', 'woocommerce' ),
        'unitizr_options_section_cb',
        'unitizr_options'
    ); 
        // c1.) settings 
    add_settings_field(
        'unitizr_cstitle_field',
        esc_attr__('Label for Checkout Field', 'unitizr'),
        'unitizr_cstitle_field_cb',
        'unitizr_options',
        'unitizr_options_section',
        array( 
            'type'         => 'text',
            'option_group' => 'unitizr_options', 
            'name'         => 'unitizr_cstitle_field',
            'value'        => 
            esc_attr( get_option( 'unitizr_options' )['unitizr_cstitle_field'] ),
            'description'  => esc_html__( 'Shows below the last field in checkout.', 'unitizr' ),
            'tip'          => esc_html__( 'Also used in orders in admin', 'unitizr' )
        )
    );
    // c2.) settings 
    add_settings_field(
        'unitizr_csdescription_field',
        esc_attr__('Cart Text', 'unitizr'),
        'unitizr_csdescription_field_cb',
        'unitizr_options',
        'unitizr_options_section',
        array( 
            'type'         => 'text',
            'option_group' => 'unitizr_options', 
            'name'         => 'unitizr_csdescription_field',
            'value'        => 
            esc_attr( get_option( 'unitizr_options' )['unitizr_csdescription_field'] ),
            'description'  => esc_html__( 'Shows below product name in cart. Try: Number of Days', 'unitizr' ),
             'tip'         => esc_html__( 'Also shows on line items in checkout', 'unitizr' )
        )
    );
    // c3.) settings 
    add_settings_field(
        'unitizr_wndproduct_field',
        esc_attr__('Product Page Increment Name', 'unitizr'),
        'unitizr_wndproduct_field_cb',
        'unitizr_options',
        'unitizr_options_section',
        array( 
            'type'         => 'text',
            'option_group' => 'unitizr_options', 
            'name'         => 'unitizr_wndproduct_field',
            'value'        => 
            esc_attr( get_option( 'unitizr_options' )['unitizr_wndproduct_field'] ),
            'description'  => esc_html__( 'Text to display on the product page. Try: Select No. of Days', 'unitizr' ),
            'tip'  => esc_attr__( 'Text will show above the add-to-cart button to the left of the quantity field. Could be Days, Hours, People....', 'unitizr' )
        )
    );    
    // c9.) settings 
    add_settings_field(
            'unitizr_begin_date',
            esc_attr__('Text Before Begin Date', 'unitizr'),
            'unitizr_begin_date_cb',
            'unitizr_options',
            'unitizr_options_section',
            array( 
                'type'         => 'text',
                'option_group' => 'unitizr_options', 
                'name'         => 'unitizr_begin_date',
                'value'        => 
                esc_attr( get_option( 'unitizr_options' )['unitizr_begin_date'] ),
                'description'  => esc_html__( 'Text to display before datepicker. Try: On: ', 'unitizr' ),
                'tip'  => esc_attr__( 'Text will show above the add-to-cart button.', 'unitizr' )
            )
        );    
    // c4.) settings 
    add_settings_field(
        'unitizr_wndinwidth_field',
        esc_attr__('Product Page Style', 'unitizr'),
        'unitizr_wndinwidth_field_cb',
        'unitizr_options',
        'unitizr_options_section',
        array( 
            'type'         => 'text',
            'option_group' => 'unitizr_options', 
            'name'         => 'unitizr_wndinwidth_field',
            'value'        => 
            esc_attr( ( empty( get_option( 'unitizr_options' )['unitizr_wndinwidth_field'] ) ) )
            ? 'width:67px' : get_option( 'unitizr_options' )['unitizr_wndinwidth_field'],
            'description'  => esc_html__( 'Style qunty and date fields. Try: display:block;margin-left:0;', 'unitizr' ),
            'tip'  => esc_attr__( 'You my add a attribute like margin-left etc. Just write like it is after style="". ', 'unitizr' )
        )
    );
    // c5.) settings 
    add_settings_field(
        'unitizr_wndinppd_field',
        esc_attr__('Style Cart wnd Price', 'unitizr'),
        'unitizr_wndinppd_field_cb',
        'unitizr_options',
        'unitizr_options_section',
        array( 
            'type'         => 'text',
            'option_group' => 'unitizr_options', 
            'name'         => 'unitizr_wndinppd_field',
            'value'        => 
            esc_attr( ( empty( get_option( 'unitizr_options' )['unitizr_wndinppd_field'] ) ) )
            ? 'font-size:90%;opacity:.9;position:relative;top:1em' : get_option( 'unitizr_options' )['unitizr_wndinppd_field'],
            'description'  => esc_html__( 'Add inline styles below Cart product name.', 'unitizr' ),
            'tip'  => esc_attr__( 'You my add a attribute like margin-left etc. Just write like it is after style="". ', 'unitizr' )
        )
    );    
    // c6.) settings 
    add_settings_field(
        'unitizr_wndtaxbase_field',
        esc_attr__('Tax Options', 'unitizr'),
        'unitizr_wndtaxbase_field_cb',
        'unitizr_options',
        'unitizr_options_section',
         array(
            'type' => 'select',
            'option_group' => 'unitizr_options', 
            'name'         => 'unitizr_wndtaxbase_field',
            'value'        => esc_attr( 
                              get_option( 'unitizr_options' )['unitizr_wndtaxbase_field'] ),
            'options'      => array(
                                  "standard" => "Standard", 
                                  "reduced" => "Reduced", 
                                  "zero" => "Zero" ),
            'description'  => esc_html__( 'This adjust the Additional Fee tax rate only 
                                           - not the product tax rate.', 'unitizr' ),
            'tip'  => esc_attr__( 'Choices are: standard | reduced | zero 
                                  See Woocommerce Settings to set taxes', 'unitizr' )
        )
    );
    // c7.) settings checkbox 
    add_settings_field(
        'unitizr_wndnada_field',
        esc_attr__('Activate Zero Entry', 'unitizr'),
       'unitizr_wndnada_field_cb',
        'unitizr_options',
        'unitizr_options_section',
        array( 
            'type'        => 'checkbox',
            'option_name' => 'unitizr_options', 
            'name'        => 'unitizr_wndnada_field',
            'label_for'   => 'unitizr_wndnada_field',
            'value'       => 
                get_option('unitizr_options')['unitizr_wndnada_field'],
            'description' => esc_html__( 
                'Check to allow Add-To-Cart without selecting increments.', 'unitizr' ),
            'checked'     => esc_attr( checked( 1, 
                get_option('unitizr_options')['unitizr_wndnada_field'], 
                false ) ),
            'tip'         => esc_attr__( 'Checking will override the default of requiring customers to select a length of time/increment.', 'wordness' ) 
            )
    ); 
    // c8.) settings checkbox 
    add_settings_field(
        'unitizr_wndmatch_field',
        esc_attr__('Allow Product Price to Match', 'unitizr'),
       'unitizr_wndmatch_field_cb',
        'unitizr_options',
        'unitizr_options_section',
        array( 
            'type'        => 'checkbox',
            'option_name' => 'unitizr_options', 
            'name'        => 'unitizr_match_field',
            'label_for'   => 'unitizr_match_field',
            'value'       => 
                get_option('unitizr_options')['unitizr_match_field'],
            'description' => esc_html__( 
                'Check to have product price the same as increment.', 'unitizr' ).'<small>'. esc_html__( ' You still must add fees price to product data.', 'unitizr' ) .'</small>',
            'checked'     => esc_attr( checked( 1, 
                get_option('unitizr_options')['unitizr_wndnada_field'], 
                false ) ),
            'tip'         => esc_attr__( 'All this really does is count the number of increments the person selected in the product page and subtracts one (day) from the increments so the first (day) is the price of the product.', 'unitizr' ) 
            )
    ); 

} 

/** 
 * name for 'label' field
 * @since 1.0.0
 */
function unitizr_cstitle_field_cb($args)
{  
   printf(
        '<input type="%1$s" name="%2$s[%3$s]" id="%2$s-%3$s" 
        value="%4$s" class="regular-text" /><b class="wntip" title="%6$s"> ? </b><br>
        <span class="wndspan">%5$s </span>',
        $args['type'],
        $args['option_group'],
        $args['name'],
        $args['value'],
        $args['description'],
        $args['tip']
    );
}

/** 
 * name for 'text' field
 * @since 1.0.0
 */
function unitizr_csdescription_field_cb($args)
{  
   printf(
        '<input type="%1$s" name="%2$s[%3$s]" id="%2$s-%3$s" 
        value="%4$s" class="regular-text" /><b class="wntip" title="%6$s"> ? </b><br>
        <span class="wndspan">%5$s </span>',
        $args['type'],
        $args['option_group'],
        $args['name'],
        $args['value'],
        $args['description'],
        $args['tip']
    );
}
/** 
 * name for 'display' field
 * @since 1.0.0
 */
function unitizr_wndproduct_field_cb($args)
{  
   printf(
        '<input type="%1$s" name="%2$s[%3$s]" id="%2$s-%3$s" 
        value="%4$s" class="regular-text" /><b class="wntip" title="%6$s"> ? </b><br>
        <span class="wndspan">%5$s </span>',
        $args['type'],
        $args['option_group'],
        $args['name'],
        $args['value'],
        $args['description'],
        $args['tip']
    );
}
/** 
 * callback for 'text' field
 * @since 1.0.0
 */
function unitizr_begin_date_cb($args)
{  
   printf(
        '<input type="%1$s" name="%2$s[%3$s]" id="%2$s-%3$s" 
        value="%4$s" class="regular-text" /><b class="wntip" title="%6$s"> ? </b><br>
        <span class="wndspan">%5$s </span>',
        $args['type'],
        $args['option_group'],
        $args['name'],
        $args['value'],
        $args['description'],
        $args['tip']
    );
}
/** 
 * 'style' field
 * @since 1.0.0
 */
function unitizr_wndinwidth_field_cb($args)
{  
   printf(
        '<input type="%1$s" name="%2$s[%3$s]" id="%2$s-%3$s" 
        value="%4$s" class="regular-text" /><b class="wntip" title="%6$s"> ? </b><br>
        <span class="wndspan">%5$s </span>',
        $args['type'],
        $args['option_group'],
        $args['name'],
        $args['value'],
        $args['description'],
        $args['tip']
    );
}
/** 
 * inline style field 2
 * @since 1.0.0
 */
function unitizr_wndinppd_field_cb($args)
{  
   printf(
        '<input type="%1$s" name="%2$s[%3$s]" id="%2$s-%3$s" 
        value="%4$s" class="regular-text" /><b class="wntip" title="%6$s"> ? </b><br>
        <span class="wndspan">%5$s </span>',
        $args['type'],
        $args['option_group'],
        $args['name'],
        $args['value'],
        $args['description'],
        $args['tip']
    );
}
/** 
 * 'select' field
 * @since 1.0.0
 */
function unitizr_wndtaxbase_field_cb($args)
{  
  print('<label for="unitizr_wndtaxbase_field">');
    if( ! empty ( $args['options'] && is_array( $args['options'] ) ) )
    { 
    $options_markup = '';
    $value = $args['value'];
        foreach( $args['options'] as $key => $label )
        {
            $options_markup .= sprintf( '<option value="%s" %s>%s</option>', 
            $key, selected( $value, $key, false ), $label );
        }
        printf( '<select name="%1$s[%2$s]" id="%1$s-%2$s">%3$s</select>',  
        $args['option_group'],
        $args['name'],
        $options_markup );
    }
        $tip = $args['tip'];
        print('<b class="wntip" title="' . esc_attr($tip) . '"> ? </b></label>'); 
}
/** 
 * switch for 'allow zero qnty' field
 * @since 1.0.1
 * @input type checkbox
 */
function unitizr_wndnada_field_cb($args)
{ 
     printf(
        '<label for="%2$s-%3$s">
        <input type="hidden" name="%2$s[%3$s]" value="0">
        <input type="%1$s" name="%2$s[%3$s]" id="%4$s" value="1"  
        class="regular-text" %7$s > %6$s </label>
        <b class="wntip" title="%8$s"> ? </b>',
        $args['type'],
        $args['option_name'],
        $args['name'],
        $args['label_for'],        
        $args['value'],
        $args['description'],
        $args['checked'],
        $args['tip']
    );    
}   
/** 
 * switch for 'allow match' field
 * @since 1.0.1
 * @input type checkbox
 */
function unitizr_wndmatch_field_cb($args)
{ 
     printf(
        '<label for="%2$s-%3$s">
        <input type="hidden" name="%2$s[%3$s]" value="1">
        <input type="%1$s" name="%2$s[%3$s]" id="%4$s" value="0"  
        class="regular-text" %7$s > %6$s </label>
        <b class="wntip" title="%8$s"> ? </b>',
        $args['type'],
        $args['option_name'],
        $args['name'],
        $args['label_for'],        
        $args['value'],
        $args['description'],
        $args['checked'],
        $args['tip']
    );    
}   

/**
 ** Section Callbacks
 *  $id, $title, $callback, $page
 */
// section heading cb
function unitizr_options_section_cb()
{    
print( UNITIZR_VER );
} 


// d.) render admin page
function unitizr_options_page() 
{
    // check user capabilities
    if ( ! current_user_can( 'manage_options' ) ) return;
    // check if the user have submitted the settings
    // wordpress will add the "settings-updated" $_GET parameter to the url
    ?>
    <div class="wrap wrap-unitizr-admin">
    
    <h1><span id="SlwOptions" class="dashicons dashicons-admin-tools"></span> 
    <?php echo esc_html( 'Woo Number of Days plugin Options' ); ?></h1>
         
    <form action="options.php" method="post">
    <?php //page=unitizr&tab=unitizr_options
        settings_fields(     'unitizr_options' );
        do_settings_sections( 'unitizr_options' ); 
        
        submit_button( 'Save Settings' ); 

    ?>
    </form>
    <?php 
    $stylaa = "text-input wndfee text-input wndqty";
    ob_start();
    echo '
    <h3>'. esc_html__( 'Help and Information', 'unitizr' ) .'</h3>
    <div class="accordion"><h2> + </h2><div class="accordion-content">
    <dl>
    <dt>'. esc_html__( '1. Label for Checkout Field', 'unitizr' ) .'</dt>
    <dd>'. esc_html__( ' also appears on the customers order invoice and email.', 'unitizr' ) .'</dd>
    <dt>'. esc_html__( '2. Admin Order Text', 'unitizr' ) .'</dt>
    <dd>'. esc_html__( 'What the administrator text will be on the Orders page or Woocommerce Orders.', 'unitizr' ) .'</dd>
    <dt>'. esc_html__( '3. Display Increment', 'unitizr' ) .'</dt>
    <dd>'. esc_html__( 'Text to display on the product page. Text will show above the add-to-cart button to the left of the quantity field. Could be Days, Hours, Tours....', 'unitizr' ) .'</dd>
    <dt>'. esc_html__( '4./5. Style', 'unitizr' ) .'</dt>
    <dd>'. esc_html__( 'Styling should be done as if you were writing style properties between the inline style element. For single-product page use', 'unitizr' ) . '<code>'. esc_attr( $stylaa ) .'</code>'. esc_html__( 'class selector styles.', 'unitizr'  ) .'</dd>
    <dd>'. esc_html__( 'Leaving the field blank will also allow you to add your own styles externally. The selectors for this field are class .quantity.wnd wraps the label and the input, which is id ', 'unitizr' ) .'<code>wnd_quantity</code></dd>
    <dt>'. esc_html__( '6. Tax Options', 'unitizr' ) .'</dt>
    <dd>'. esc_html__( 'This adjust the Additional Fee tax rate only - not the product tax rate.', 'unitizr' ) .'</dd>
    <dd>'. esc_html__( 'Choices are: standard | reduced | zero. See Woocommerce Settings to set taxes', 'unitizr' ) .'</dd>
    <dt>'. esc_html__( '7. Zero Entry', 'unitizr' ) .'</dt>
    <dd>'. esc_html__( 'Check box to allow customers to press the Add-To-Cart button WITHOUT requiring them to select a duration from the unitizr quantity field. This gives the option to add rental price of product as the same price of the rental per day price.', 'unitizr' ) .'</dd>
    <dt>'. esc_html__( '8. Allow Product Price to Match Fee', 'unitizr' ) .'</dt>
    <dd>'. esc_html__( 'Check to have product price the same as increment. You still must add fees price to product data. All this really does is count the number of increments the person selected in the product page and subtracts one (day) from the increments so the first (day) is the price of the product.', 'unitizr' ) .'</small></dd>
    </dl>
    <p>&nbsp;</p>
    <span class="accordion-close"> - </span>
    </div></div><div class="clear"></div>';
    $htmls = ob_get_clean();
    echo $htmls;
    ?>
    <p><?php esc_html_e( 'For custom configuration of Unitizr please email 
    Larry @ ', 'unitizr' ); ?> <a href="mailto:support@tradesouthwest.com">
    support@tradesouthwest.com</a><br></p>
    </div>
<?php 
} 
