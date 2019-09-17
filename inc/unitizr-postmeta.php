<?php 
/**
 * @package unitizr
 *
 */
// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {	exit; }
/**
 * *****************************************
 * Post meta and Cart meta
 * 
 * **************************************** */
// Add Number Field to admin General tab
add_action( 'woocommerce_product_options_general_product_data', 
        'unitizr_general_product_data_field' );
function unitizr_general_product_data_field() 
{
    woocommerce_wp_text_input( array( 
        'id'    => '_unitizr_fee', 
        'name'    => '_unitizr_fee', 
        'label'     => __( 'Rental Days Fee', 'unitizr' ), 
        'placeholder' => '', 
        'description'   => __( 'Price per day.', 'unitizr' ), 
        'type'            => 'number', 
        'custom_attributes' => array( 'step' => 'any', 
                                      'min' => '0' ) 
    ) );
}

/**
 * Save the whales... I mean save post meta
 * Hook callback functions to save custom fields 
 *
 * meta_id[26117] post_id[1696] meta_key[_unitizr_fee] meta_value[int]
 * https://www.ibenic.com/how-to-add-woocommerce-custom-product-fields/
 */
 
add_action( 'woocommerce_process_product_meta', 'unitizr_save_unitizr_fee' );
function unitizr_save_unitizr_fee( $post_id ) 
{
    //global $product;
    $custom_field_value = isset( $_POST['_unitizr_fee'] ) 
                               ? $_POST['_unitizr_fee'] : '';
    $custom_field_clean = sanitize_text_field( $custom_field_value );
    $product = wc_get_product( $post_id );
    $product->update_meta_data( '_unitizr_fee', $custom_field_clean );
    $product->save();
}

/**
 * Show custom field in order overview
 * @param array $cart_item
 * @param array $order_item
 * @return array
 */ 
add_filter( 'woocommerce_order_item_product', 'unitizr_order_item_product', 10, 2 ); 
 function unitizr_order_item_product( $cart_item, $order_item )
{
    if( isset( $order_item['unitizr_custom_option'] ) ){ 
        $cart_item_meta['unitizr_custom_option'] = 
        $order_item['unitizr_custom_option']; 
    }
    if( isset( $order_item['unitizr_begin_date'] ) ){ 
        $cart_item_meta['unitizr_begin_date'] = 
        $order_item['unitizr_begin_date']; 
    }
        return $cart_item;
}

/** 
 * Add the field to order emails 
 * @param array $keys 
 * @return array  meta_id, order_item_id, meta_key, meta_value
 * woocommerce_checkout_update_order_meta
 */
//add_filter( 'woocommerce_order_item_get_formatted_meta_data', 'unitizr_change_formatted_meta_data', 20, 2 );
/**
 * Filterting the meta data of an order item.
 * @param  array         $meta_data Meta data array
 * @param  WC_Order_Item $item      Item object
 * @return array                    The formatted meta
 */
function unitizr_change_formatted_meta_data( $meta_data, $item ) 
{
    $new_meta = array();
    foreach ( $meta_data as $id => $meta_array ) {
        // We are removing the meta with the key 'unitizr' from the whole array.
        if ( 'unitizr_' === $meta_array->key ) { continue; }
        $new_meta[ $id ] = $meta_array;
    }
    return $new_meta;
}

/**
 * Changing a meta title
 * @param  string        $key  The meta key
 * @param  WC_Meta_Data  $meta The meta object
 * @param  WC_Order_Item $item The order item object
 * @return string        The title
 */
add_filter( 'woocommerce_order_item_display_meta_key', 'unitizr_change_order_item_meta_title', 20, 3 );
function unitizr_change_order_item_meta_title( $key, $meta, $item ) 
{
    $wnddays = get_option('unitizr_options')['unitizr_csdescription_field'];
    $wndbegin = get_option('unitizr_options')['unitizr_begin_date'];
    // By using $meta-key we are sure we have the correct one.
    if ( 'unitizr_custom_option' === $meta->key ) { $key = esc_attr($wnddays); }
    if ( 'unitizr_begin_date' === $meta->key ) { $key = $wndbegin; }
     
    return $key;
} 