<?php 
if ( ! defined( 'ABSPATH' ) ) { exit; }
/**
 * Validate if product has a unitized field value
 * 
 * @since 1.0.2
 * @param string $value Title option must be set.
 * @return Bool
 */
function unitizr_is_unitized($post)
{
    global $post;

    $ppday = get_post_meta( $post->ID, '_unitizr_fee', true );
    
    if( empty ( $ppday  ) ) { 
        $unitized = false; 
        }
        else { 
            $unitized = true; 
    }
        return (bool)$unitized;
}

/**
 * Display input on single product page
 * 
 * @param  str $wndtext Product Page Increment Name
 * @param  str $wndwdth Style in put fields
 * @param  str $value   Price 
 * @return print HTML
 */
add_action( 'woocommerce_before_add_to_cart_button', 'unitizr_custom_option', 11 );
function unitizr_custom_option()
{ 
         
    $plchld  = $wndtext = $wndwdth ='';
    $wndtext = get_option('unitizr_options')['unitizr_wndproduct_field'];
    $wndwdth = get_option('unitizr_options')['unitizr_wndinwidth_field'];
    $value   = isset( $_POST['_unitizr_custom_option'] ) 
    ? sanitize_text_field( $_POST['_unitizr_custom_option'] ) : '';

    if( unitizr_is_unitized($post) === true ) {

    printf( '<div class="alignwnd"> 
            <label>%s </label>
            <input id="wnd_quantity"
                   class="input-text wndqty"
                   style="%s" 
                   type="number" 
                   name="_unitizr_custom_option" 
                   value="%s"
                   placeholder="" /> </div>', 
                   esc_html( $wndtext ), 
                   esc_attr( $wndwdth ), 
                   esc_attr( $value )
                   );
        } 
        else { 
            return; 
    }
}

/**
 * Display datepicker on single product page
 * 
 * @param string $wndbegin Product Page datepicker value
 * @param string $wndwdth  Style in put fields
 * @param string $value    Date
 * @param string $plchldr  Placeholder (optional)
 * @return print HTML
 */
add_action( 'woocommerce_before_add_to_cart_button', 'unitizr_custom_datepicker', 15 );
function unitizr_custom_datepicker() 
{
        
    $plchldr  = $wndbegin = $wndwdth = '';
    $wndbegin = get_option('unitizr_options')['unitizr_begin_date'];
    $wndwdth  =   get_option('unitizr_options')['unitizr_wndinwidth_field'];
    $value    = isset( $_POST['_unitizr_begin_date'] ) 
    ? sanitize_text_field( $_POST['_unitizr_begin_date'] ) : '';
    
    if( unitizr_is_unitized($post) === true ) {

    printf( '<div class="alignwnd"> 
            <label>%s </label>
            <input id="wnd_wndbegin"
                   class="input-text date_picker"
                   style="min-width:148px; %s" 
                   type="text" 
                   name="_unitizr_begin_date" 
                   value="%s"
                   placeholder="%s" /> </div>', 
                   esc_html( $wndbegin ), 
                   esc_attr( $wndwdth ), 
                   esc_attr( $value ),
                   esc_attr( $plchldr )
                   );
        } else { 
            return false; 
    }
}

/**
 * Display price on single product page
 * 
 * @param str $label Label for Checkout Field
 * @param str $ppday Increment price value
 * @param str @currency_symbol $ il8n
 * @return html
 */
function unitizr_custom_option_label($product)
{ 
    global $woocommerce, $product;

    $label    = get_option('unitizr_options')['unitizr_cstitle_field']; 
    $ppday    = get_post_meta( $product->get_id(), '_unitizr_fee', true ); 
    $currency_symbol = get_woocommerce_currency_symbol();

    if( unitizr_is_unitized($post) === true ) {

        printf( '<div class="input-text wndfee">
                <label>%s 
                <span>%s</span><span>%s</span></label></div>',
                esc_html( $label ), 
                esc_attr( $currency_symbol ),
                esc_html( $ppday ) 
                ); 
        } else { 
            return false; 
    }
} 
add_action( 'woocommerce_single_product_summary', 'unitizr_custom_option_label', 9 );

/**
 * Validate when adding to cart
 * @param bool $passed
 * @param int $product_id
 * @param int $quantity
 * @return bool
 */
function unitizr_add_to_cart_validation($passed, $product_id, $qty)
{
    //check for require entry set
    $wndnada = get_option( 'unitizr_options' )['unitizr_wndnada_field'];
    
    if( $wndnada != 1 ) {
       
        if( isset( $_POST['_unitizr_custom_option'] ) 
            && sanitize_text_field( $_POST['_unitizr_custom_option'] ) == '' ){
        
            $product = wc_get_product( $product_id );
                wc_add_notice( sprintf( __( 
                    '%s cannot be added. You must add increment', 'unitizr' ), 
                    $product->get_title() 
                    ), 
                    'error' 
                );
            
            return false;
        }
    } 
        return $passed;
}
add_filter( 'woocommerce_add_to_cart_validation', 'unitizr_add_to_cart_validation', 10, 3 );

/**
 * Add custom data to the cart item
 * @param array $cart_item
 * @param int $product_id
 * @return array
 */
add_filter( 'woocommerce_add_cart_item_data', 'unitizr_add_cart_item_data', 10, 2 );
function unitizr_add_cart_item_data( $cart_item, $product_id )
{
 
    if( isset( $_POST['_unitizr_custom_option'] ) ) {
        $cart_item['unitizr_custom_option'] = sanitize_text_field( 
        $_POST['_unitizr_custom_option'] );
    }

    if( isset( $_POST['_unitizr_begin_date'] ) ) {
        $cart_item['unitizr_begin_date'] = sanitize_text_field( 
        $_POST['_unitizr_begin_date'] );
    }
        return $cart_item;
}

/**
 * Load cart data from session
 * @param  array $cart_item
 * @param  array $other_data
 * @return array
 */
add_filter( 'woocommerce_get_cart_item_from_session', 'unitizr_get_cart_item_from_session', 20, 4 );
function unitizr_get_cart_item_from_session( $cart_item, $values ) 
{
 
    if ( isset( $values['unitizr_custom_option'] ) ){
        $cart_item['unitizr_custom_option'] = 
        $values['unitizr_custom_option'];
    }
    if ( isset( $values['unitizr_begin_date'] ) ){
        $cart_item['unitizr_begin_date'] = 
        $values['unitizr_begin_date'];
    }
        return $cart_item;
}

/** 
 * Calculate additional fees, add to item totals.
 * Set tax rate (universal between all wndfees)
 * TODO wc_numeric_decimals
 * @param array $cart_item_key
 * @param array $cart_item
 * @returns wc_add_fee
 */ 
add_action( 'woocommerce_before_calculate_totals', 'unitizr_update_line_item_subtotal' );
function unitizr_update_line_item_subtotal( $cart_item ) 
{
    global $woocommerce;
    if ( is_admin() && ! defined( 'DOING_AJAX' ) )
        return;
   
    $cart_size = sizeof( WC()->cart->get_cart() );
    if ( $cart_size > 0 ) :  
    
        // option to allow prod price same as days fee
        $optqnty = get_option( 'unitizr_options' )['unitizr_wndmatch_field'] 
                 ? get_option( 'unitizr_options' )['unitizr_wndmatch_field'] : 0;
        $wndtaxx = get_option( 'unitizr_options' )['unitizr_wndtaxbase_field'] 
                 ? get_option( 'unitizr_options' )['unitizr_wndtaxbase_field'] : 'zero';
        
        //label in cart totals
        $wndttltext = get_option( 'unitizr_options' )['unitizr_cstitle_field'];
        $wnd_fee    = '';        // clean string
        $wnd_fee    = array();  // init array
        $found      = false;   // default
        foreach ( $woocommerce->cart->get_cart() as $cart_item_key => $cart_item ) 
        { 
        /* Check for the wnd_fee Line Item in Woocommerce Cart */
        $_wnd_qnty = $cart_item['unitizr_custom_option'];
            if( '' != $_wnd_qnty && $_wnd_qnty > $optqnty ) 
            { 
                $found = true; 
            }
                if( $found == true)  
                { 
                $wnd_cost   = get_post_meta( $cart_item['product_id'], 
                              '_unitizr_fee', true );
                $product_id = $cart_item['product_id'];
                $wnd_qnty   = $cart_item['unitizr_custom_option'];            
                $_fees      = $wnd_cost * $wnd_qnty;
                $wnd_fee[]  = round($_fees, 2);             
                }  
                
        } //ends foreach loop
        
        $woocommerce->cart->add_fee( __($wndttltext, 'unitizr'), 
                                     array_sum($wnd_fee), 
                                     $wndtaxx 
                                    );
    endif; 
}

/**
 * Get item data to display in cart
 * @param  array $other_data
 * @param  array $cart_item
 * @return array
 */
function unitizr_get_item_data( $other_data, $cart_item ) 
{
    $label = get_option('unitizr_options')['unitizr_csdescription_field']; 
    $labfl = get_option('unitizr_options')['unitizr_begin_date']; 

    if ( isset( $cart_item['unitizr_custom_option'] ) )
    {
    
        $other_data[] = array(
            'name'  => esc_attr( $label ),
            'value' => sanitize_text_field( $cart_item['unitizr_custom_option'] )
        );
        $other_data[] = array(
            'name'  => esc_attr( $labfl ),
            'value' => sanitize_text_field( $cart_item['unitizr_begin_date'] )
        );
    }
        return $other_data;
}
add_filter( 'woocommerce_get_item_data', 'unitizr_get_item_data', 10, 4 );

/**
 * Add meta to order item
 * @param  int $item_id
 * @param  array $values
 * @return void
 */
add_action( 'woocommerce_add_order_item_meta', 'unitizr_add_order_item_meta', 10, 2 );
function unitizr_add_order_item_meta( $item_id, $values ) 
{
 
    if ( ! empty( $values['unitizr_custom_option'] ) ) {
        woocommerce_add_order_item_meta( $item_id, 'unitizr_custom_option', 
                          $values['unitizr_custom_option'] );           
    }
    //unitizr_begin_date
    if ( ! empty( $values['unitizr_begin_date'] ) ) {
        woocommerce_add_order_item_meta( $item_id, 'unitizr_begin_date', 
                          $values['unitizr_begin_date'] );           
    }
}

/** 
 * @_cart_item_price only displays, does not total
 * display ppd next to price
 * @param  string $title
 * @param  array $cart_item
 * @param  array $cart_item_key
 * @return array
 */ 
function unitizr_render_priceperday_field( $title=null, $cart_item, $cart_item_key)
{
    $styls    = get_option('unitizr_options')['unitizr_wndinppd_field']; 
    $currency = get_woocommerce_currency_symbol();
    $ppday    = get_post_meta( $cart_item['product_id'], 
                               '_unitizr_fee', true 
                               );
    if( $cart_item_key && is_cart() ) 
    {
        echo $title. '<span class="variation wnddays" style="'. $styls .'"> 
        '. $currency .''. $ppday . '</span>';
        } else {
        echo $title;
    }
}
add_filter( 'woocommerce_cart_item_name', 'unitizr_render_priceperday_field', 10, 3 ); 

if( ! function_exists( 'unitizr_date_format_php_to_js') )
{
	/**
	 * Convert a date format to a jQuery UI DatePicker format
	 *
	 * @param string $dateFormat a date format
	 *
	 * @return string
	 */
	function unitizr_date_format_php_to_js( $dateFormat ) {
		$chars = array(
			// Day
			'd' => 'dd',
			'j' => 'd',
			'l' => 'DD',
			'D' => 'D',
			// Month
			'm' => 'mm',
			'n' => 'm',
			'F' => 'MM',
			'M' => 'M',
			// Year
			'Y' => 'yy',
			'y' => 'y',
		);
		return strtr( (string) $dateFormat, $chars );
	}
}

/**
 * Test whether a condition is met, and then return either TRUE or FALSE
 * @uses   is_product()
 * @since  1.0.2
 * @return Bool or footer javascript
 */
function unitizr_datepicker_onpage()
{   
    global $woocommerce;

        $dateFormat = get_option( 'date_format' );
        // will only add javascript to footer if is on single product page
    if( is_product() )  :  
        $date_format = unitizr_date_format_php_to_js($dateFormat);
        if ( $date_format =='' ) { 
            $date_format = 'mm/dd/yy'; 
        }
        ob_start();        
echo '
<script type="text/javascript">
    jQuery(document).ready(function($) {
        $(".date_picker").datepicker({
            dateFormat : "' . $date_format .'"
        });
    });
</script>';

        $jshtml = ob_get_clean();
        echo $jshtml;   
    endif;
}
add_action( 'wp_footer', 'unitizr_datepicker_onpage'); 
