<?php

/**
 * Plugin Name: Exclusive Worker Reviews (Premium)
 * Description: Provides the ability to add worker reviews that are SEO friendly.
 * Version: 1.2.1
 * Update URI: https://api.freemius.com
 * Author: Exclusive web marketing
 * Author URI: https://exclusivewebmarketing.com/
 * Text Domain: exclusive-worker-reviews
 * Domain Path: /languages/
 * License: GPLv2 or any later version
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License, version 2 or later, as
 * published by the Free Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 *
 * @package WPBDP
*/
// Do not allow direct access to this file.
require __DIR__ . '/vendor/vendor/autoload.php';
// Process images
require_once ABSPATH . 'wp-admin/includes/media.php';
require_once ABSPATH . 'wp-admin/includes/file.php';
require_once ABSPATH . 'wp-admin/includes/image.php';

if ( !function_exists( 'xc_fs' ) ) {
    // Create a helper function for easy SDK access.
    function xc_fs()
    {
        global  $xc_fs ;
        
        if ( !isset( $xc_fs ) ) {
            // Include Freemius SDK.
            require_once dirname( __FILE__ ) . '/freemius/start.php';
            $xc_fs = fs_dynamic_init( array(
                'id'               => '9891',
                'slug'             => 'ExclusiveWorkerReviews',
                'premium_slug'     => 'ExclusiveWorkerReviews-premium',
                'type'             => 'plugin',
                'public_key'       => 'pk_49d0f4854835c581918678417df09',
                'is_premium'       => true,
                'is_premium_only'  => false,
                'has_addons'       => false,
                'has_paid_plans'   => true,
                'is_org_compliant' => false,
                'trial'            => array(
                'days'               => 14,
                'is_require_payment' => true,
            ),
                'menu'             => array(
                'slug'    => 'ewm-r-child',
                'support' => false,
            ),
                'is_live'          => true,
            ) );
        }
        
        return $xc_fs;
    }
    
    // Init Freemius.
    xc_fs();
    // Signal that SDK was initiated.
    do_action( 'xc_fs_loaded' );
}

add_action( 'admin_enqueue_scripts', 'ewm_wr_load_admin_resources' );
function ewm_wr_load_admin_resources( $options = array() )
{
    wp_enqueue_script( 'jquery' );
    wp_enqueue_script( 'ewm-wr-main-lib-uploader-js', plugins_url( basename( dirname( __FILE__ ) ) . '/assets/script-admin.js', 'jquery' ) );
    wp_localize_script( 'ewm-wr-main-lib-uploader-js', 'ajax_object', array(
        'ajaxurl' => admin_url( 'admin-ajax.php' ),
    ) );

    wp_enqueue_style( 'ewm-r-style_admin', plugins_url( basename( dirname( __FILE__ ) ) . '/assets/style-admin.css' ) );

}

add_action( 'wp_enqueue_scripts', 'ewm_wr_load_public_resources' );
function ewm_wr_load_public_resources( $options = array() )
{
    wp_enqueue_script( 'jquery' );
    wp_enqueue_script( 'ewm-wr-public-main-lib-uploader-js', plugins_url( basename( dirname( __FILE__ ) ) . '/assets/script-public.js', 'jquery' ) );
    wp_localize_script( 'ewm-wr-public-main-lib-uploader-js', 'ajax_object', array(
        'ajaxurl' => admin_url( 'admin-ajax.php' ),
    ) );
    wp_enqueue_style( 'ewm-wr-style_public', plugins_url( basename( dirname( __FILE__ ) ) . '/assets/style-public.css' ) );
}


// Enable WP_DEBUG mode
// define( 'WP_DEBUG', false );

// Enable Debug logging to the /wp-content/debug.log file
// define( 'WP_DEBUG_LOG', false );

// Disable display of errors and warnings
// define( 'WP_DEBUG_DISPLAY', false );

@ini_set( 'display_errors', 0 );

// Use dev versions of core JS and CSS files (only needed if you are modifying these core files)
// define( 'SCRIPT_DEBUG', false );

ini_set('display_errors', 0 );

ini_set('display_startup_errors', 0 );

error_reporting(0);

function ewm_r_add_listing_post_data( $args ){

    $current_user_id = get_current_user_id();
    // => Add mapping to see were a product relate tot the other
    // => Add new product if the product does not exist
    // => Update the old product of the product already exist // Add Post
    $content_slug = preg_replace( '#[ -]+#', '-', sanitize_text_field( $args['ewm_r_review_title'] ) );

    // Create post
    $post_data = [
        "post_author"           => $current_user_id,
        "post_date"             => date( 'Y-m-d H:i:s' ),
        "post_date_gmt"         => date( 'Y-m-d H:i:s' ),
        "post_content"          => sanitize_text_field( $args['ewm_r_description'] ),
        "post_title"            => sanitize_text_field( $args['ewm_r_review_title'] ),
        "post_excerpt"          => sanitize_text_field( $args['ewm_r_description'] ),
        "post_status"           => "publish",
        "comment_status"        => "open",
        "ping_status"           => "closed",
        "post_password"         => "",
        "post_name"             => $content_slug,
        "to_ping"               => "",
        "pinged"                => "",
        "post_modified"         => date( 'Y-m-d H:i:s' ),
        "post_modified_gmt"     => date( 'Y-m-d H:i:s' ),
        "post_content_filtered" => "",
        "post_parent"           => $args['ewm_r_related_page_id'], 
        "guid"                  => "",
        "menu_order"            => 0,
        "post_type"             => "ewm_worker_review",
        "post_mime_type"        => "",
        "comment_count"         => "0",
        "filter"                => "raw",
    ];

    global  $wp_error ;
    $new_post_data = [
        'post_id'     => '',
        'post_is_new' => '',
    ] ;

    $new_post_id = '' ;

    // @todo change from name to id
    remove_all_filters( "content_save_pre" );
    add_filter( 'wp_kses_allowed_html', 'wpse_kses_allowed_html', 10, 2 ) ;
    
    if ( $args['ewm_r_post_id'] == 0 ) {
        $new_post_id = wp_insert_post( $post_data, $wp_error );
        $new_post_data['post_id'] = $new_post_id;
        $new_post_data['post_is_new'] = true;
    } else {
        $new_post_id = intval( $args['ewm_r_post_id'] );
        $new_post_data['post_id'] = $new_post_id;
        $new_post_data['post_is_new'] = false;
        // do product post update
        $post_data['ID'] = $args['ewm_r_post_id'];
        $wp_update_d = wp_update_post( $post_data ); // var_dump( $wp_update_d ) ;
    }
    
    // Remove Custom Filter
    remove_filter( 'wp_kses_allowed_html', 'wpse_kses_allowed_html', 10 );

    return $new_post_data;

}

function ewm_r_add_listing_meta_d( $new_post_data = array() ){

    $args = $new_post_data['args'];
    // Map to Actual Metas // Get Metadata Fields
    $post_id = $new_post_data['post_id'];
    $post_is_new = $new_post_data['post_is_new'];

    $final_arr = [
        'ewm_r_review_title'       => sanitize_text_field( $args['ewm_r_review_title'] ),
        'ewm_r_description'        => sanitize_text_field( $args['ewm_r_description'] ),
        'ewm_r_customer_name'      => sanitize_text_field( $args['ewm_r_customer_name'] ),
        'ewm_r_review_date'        => date( 'Y-m-d H:i:s' ),
        'ewm_r_star_rating'        => $args['ewm_r_star_rating'],
        'ewm_r_review_place'       => sanitize_text_field( $args['ewm_r_review_place'] ) ,
        'ewm_r_address'            => sanitize_text_field( $args['ewm_r_address'] ),
        'ewm_r_street_address'     => sanitize_text_field( $args['ewm_r_street_address'] ), // 'ewm_r_review_address2'    => sanitize_text_field( $args['ewm_r_review_address2'] ),
        'ewm_r_address_city'       => sanitize_text_field( $args['ewm_r_address_city'] ),
        'ewm_r_address_state'      => sanitize_text_field( $args['ewm_r_address_state'] ),
        'ewm_r_address_zip'        => sanitize_text_field( $args['ewm_r_address_zip'] ),
        'ewm_r_address_country'    => sanitize_text_field( $args['ewm_r_address_country'] ),
        'ewm_r_job_description'    => sanitize_text_field( $args['ewm_r_job_description'] ),
        'ewm_r_team_member'        => sanitize_text_field( $args['ewm_r_team_member'] ),
        'ewm_wr_category_dropdown' => sanitize_text_field( $args['ewm_wr_category_dropdown'] ),
        'ewm_r_related_page_id'    => sanitize_text_field( $args['ewm_r_related_page_id'] ),
        'ewm_wr_img_file'          => sanitize_text_field( $args['ewm_wr_img_file'] ),
    ] ;

    // Create Metadata
    $meta_arr_box = [];
    $tt = 0;
    $post_meta_data = get_post_meta( $post_id );
    foreach ( $final_arr as $meta_key => $meta_value ) {
        
        if ( $post_is_new ) {

            $meta_arr_box[$tt] = add_post_meta(
                $post_id,
                $meta_key,
                $meta_value,
                true
            );

        } else {

            if( array_key_exists( $meta_key, $post_meta_data ) ) { 
                $meta_arr_box[$tt] = update_post_meta(
                    $post_id,
                    $meta_key,
                    $meta_value,
                    $post_meta_data[$meta_key][0]
                ) ;
            }

        }
        
        $tt++;
    }
}

function ewm_r_process_thumbnail_image( $args = array() ){
    $images = $args['product_data']->images;
    $media = '';
    $new_post_id = $args['post_detail']['post_id'];
    $image_url = $images[0]->src;

    // Magic sideload image returns an HTML image, not an ID
    $media = media_sideload_image( $image_url, $new_post_id, 'id' );
    
    // Therefore we must find it so we can set it as featured ID
    if ( !empty($media) && !is_wp_error( $media ) ) {
        $args = array(
            'post_type'      => 'attachment',
            'posts_per_page' => -1,
            'post_status'    => 'any',
            'post_parent'    => $new_post_id,
        );
        // Reference new image to set as featured
        $attachments = get_posts( $args );
        if ( isset( $attachments ) && is_array( $attachments ) ) {
            foreach ( $attachments as $attachment ) {
                // Grab source of full size images (so no 300x150 nonsense in path)
                $image = wp_get_attachment_image_src( $attachment->ID, 'full' );
                // Determine if in the $media image we created, the string of the URL exists
                
                if ( strpos( $media, $image[0] ) !== false ) {
                    // If so, we found our image. set it as thumbnail
                    set_post_thumbnail( $new_post_id, $attachment->ID );
                    // Only want one image
                    break;
                }
            
            }
        }
    }
    
    if ( is_wp_error( $media ) ) {
        echo  $media->get_error_message() ;
    }
    return $attachment->ID;
}

function ewm_r_process_gallery_list( $args = array() ){
    $images = $args['product_data']->images;
    $media = '';
    $new_post_id = $args['post_detail']['post_id'];
    $image_list = '';
    foreach ( $images as $img_key => $image ) {
        if ( $img_key == 0 ) {
            continue;
        }
        $image_url = $image->src;
        // Magic sideload image returns an HTML image, not an ID
        $media = media_sideload_image( $image_url, $new_post_id, 'id' ) . ',';
        // therefore we must find it so we can set it as featured ID
        
        if ( !empty($media) && !is_wp_error( $media ) ) {
            $args = array(
                'post_type'      => 'attachment',
                'posts_per_page' => -1,
                'post_status'    => 'any',
                'post_parent'    => $new_post_id,
            );
            // reference new image to set as featured
            $attachments = get_posts( $args );
            if ( isset( $attachments ) && is_array( $attachments ) ) {
                foreach ( $attachments as $attachment ) {
                    // Grab source of full size images (so no 300x150 nonsense in path)
                    $image = wp_get_attachment_image_src( $attachment->ID, 'full' );
                    $image_list .= $attachment->ID . ',';
                    // Determine if in the $media image we created, the string of the URL exists
                    
                    if ( strpos( $media, $image[0] ) !== false ) {
                        // If so, we found our image. set it as thumbnail
                        set_post_thumbnail( $new_post_id, $attachment->ID );
                        // Only want one image
                        break;
                    }
                
                }
            }
        }
        
        if ( is_wp_error( $media ) ) {
            echo  $media->get_error_message() ;
        }
    }
    return $image_list;
}

function ewm_r_add_single_review( $single_product_data )
{
    $listing_post_data = add_listing_post_data( $single_product_data );
    // Add Categories // @TODO add tags
    add_cat_name( [
        'product_data' => $single_product_data,
        'post_detail'  => $listing_post_data,
    ] );
    // Add/ Update Images
    // Do thumbnail
    $thumbnail_image = process_thumbnail_image( [
        'product_data' => $single_product_data,
        'post_detail'  => $listing_post_data,
    ] );
    // Do gallery
    $gallery_list = process_gallery_list( [
        'product_data' => $single_product_data,
        'post_detail'  => $listing_post_data,
    ] );
    $listing_post_data['thumbnail_image'] = $thumbnail_image;
    // var_dump( $listing_post_data['thumbnail_image'] );
    $listing_post_data['gallery_list'] = $gallery_list;
    // Add/ Update Meta Data
    $listing_meta = add_listing_meta_d( [
        'product_data' => $single_product_data,
        'post_details' => $listing_post_data,
    ] );
}

function ewm_r_admin_menu()
{
    add_menu_page(
        __( 'Worker Review', 'exclusive-web-marketing-r-plugin' ),
        __( 'Worker Review', 'exclusive-web-marketing-r-plugin' ),
        'manage_options',
        'ewm-r-child',
        'ewm_r_admin_page_contents',
        'dashicons-format-quote',
        3
    );

    add_submenu_page(
        'ewm-r-child',
        'Categories',
        'Categories',
        'edit_pages',
        'ewm-wr-cat',
        'ewm_wr_cat',
        2
    );

    add_submenu_page(
        'ewm-r-child',
        'Chatgpt',
        'Chatgpt',
        'edit_pages',
        'ewm-wr-chat-gpt',
        'ewm_wr_chat_gpt',
        2
    );

}

add_action( 'admin_menu', 'ewm_r_admin_menu' );

function ewm_wr_chat_gpt(){

    // review list
    include dirname( __FILE__ ) . '/vendor/templates/chatgpt/ewm_wr_list.php';
    
}

function ewm_wr_cat(){

    // review list
    include dirname( __FILE__ ) . '/vendor/templates/ewm_wr_categories.php';

}

function ewm_r_admin_page_contents(){
    ?>

    <div class="wrap">

        <hr class="wp-header-end">

        <?php 
            // setup guidlines
            include dirname( __FILE__ ) . '/vendor/templates/setup_guideline.php';
        ?>
        
        <div id="ajax-response"></div>

        <div class="clear"></div>

    </div>

    <?php 
}

add_action( 'wp_ajax_ewm_r_delete_review_item', 'ewm_r_delete_review_item' );
add_action( 'wp_ajax_nopriv_ewm_r_delete_review_item', 'ewm_r_delete_review_item' );
function ewm_r_delete_review_item(){
    wp_delete_post( sanitize_text_field( $_POST['ewm_r_post_id'] ), true );
    echo  json_encode( [
        'post_id' => sanitize_text_field( $_POST['ewm_r_post_id'] ),
    ] ) ;
    wp_die();
}

function ewm_wr_process_image_file(){
    
    if ( isset( $_POST ) ) {
        $sf_data_o = $_POST;
        $time_of_entry = date( "Y-m-d H:i:s" );
    }
    
    $support_title = ( !empty(sanitize_text_field( $_POST['supporttitle'] )) ? sanitize_text_field( $_POST['supporttitle'] ) : 'Resume Title' );
    if ( !function_exists( 'wp_handle_upload' ) ) {
        require_once ABSPATH . 'wp-admin/includes/file.php';
    }

    $file_urls = [];
    $uploadedfile = $_FILES['ewm_wr_img_file'];

    // Processing
    $uploadedfile['name'] = md5( mt_rand() ) . sanitize_file_name( $uploadedfile['name'] );
    $upload_overrides = array(
        'test_form' => false,
    );

    $movefile = wp_handle_upload( $uploadedfile, $upload_overrides );
    $trd = wp_parse_url( $file_location );
    $file_l = substr_replace( get_home_path(), "", -1 ) . '' . $trd['path'];
    $file_attr = $movefile;

    $attachment = array(
        'guid'           => $file_attr['url'],
        'post_mime_type' => $file_attr['type'],
        'post_title'     => preg_replace( '/\\.[^.]+$/', '', basename( $file['name'] ) ),
        'post_content'   => '',
        'post_status'    => 'inherit',
    );

    // echo 'final upload:'; // var_dump( $movefile ); // echo 'Initial upload:'; // var_dump( $uploadedfile );
    // Adds file as attachment to WordPress
    $wp_attachment_id = wp_insert_attachment( $attachment, $file_attr['file'], $post_id );
    $post_id_det = attachment_url_to_postid( $movefile['url'] );

    return $wp_attachment_id;

}

add_action( "wp_ajax_nopriv_ewm_wr_delete_a_worker_review", "ewm_wr_delete_a_worker_review" );
add_action( "wp_ajax_ewm_wr_delete_a_worker_review", "ewm_wr_delete_a_worker_review" );
function ewm_wr_delete_a_worker_review()
{
    $ewm_wr_worker_review_post_id = wp_delete_post( $_POST['ewm_wr_worker_review_post_id'] );
    echo  json_encode( [
        'post_deleted' => $ewm_wr_worker_review_post_id,
    ] ) ;
    wp_die();
}

add_action( "wp_ajax_nopriv_ewm_r_add_update_review_details", "ewm_r_add_update_worker_review" );
add_action( "wp_ajax_ewm_r_add_update_review_details", "ewm_r_add_update_worker_review" );
function ewm_r_add_update_worker_review(){

    $args = $_POST;

    $new_post_data = ewm_r_add_listing_post_data( $args );
    $new_post_data['args'] = $args;

    $ewm_wr_image_id = '';
    
    if( $args['gpt_ewm_img_file_is_changed'] == 1 ) {
        $ewm_wr_image_id = ewm_wr_process_image_file();
    }
    else{ // ewm_wr_img_file
        $ewm_wr_image_id = get_post_meta( $new_post_data[ 'post_id' ] , 'ewm_wr_img_file', true );
    }

    // var_dump($new_post_data);
    // var_dump($ewm_wr_image_id);
    // wp_die();

    $new_post_data['args']['ewm_wr_img_file'] = $ewm_wr_image_id;
    ewm_r_add_listing_meta_d( $new_post_data );
    $post_meta_d = get_post_meta( $new_post_data[ 'post_id' ] ); // , 'ewm_r_worker_name' );
    $post_value = get_post( $new_post_data['post_id'] );
    $ewm_wr_img_file = ( array_key_exists( 'ewm_wr_img_file', $post_meta_d ) ? $post_meta_d["ewm_wr_img_file"][0] : 0 );

    $ewm_wr_img_file_url = wp_get_attachment_image_src( $ewm_wr_image_id, 'full' );

    if ( is_array( $ewm_wr_img_file_url ) ) {
        $ewm_wr_img_file_url = $ewm_wr_img_file_url[0];
    }
    else{
        $ewm_wr_img_file_url = '';
    }

    $data_details = [
        'ewm_r_review_title'       => ( array_key_exists( 'ewm_r_review_title', $post_meta_d ) ? $post_meta_d["ewm_r_review_title"][0] : '' ),
        'ewm_r_description'        => ( array_key_exists( 'ewm_r_description', $post_meta_d ) ? $post_meta_d["ewm_r_description"][0] : '' ),
        'ewm_r_customer_name'      => ( array_key_exists( 'ewm_r_customer_name', $post_meta_d ) ? $post_meta_d["ewm_r_customer_name"][0] : '' ),
        'ewm_r_review_date'        => ( array_key_exists( 'ewm_r_review_date', $post_meta_d ) ? $post_meta_d["ewm_r_review_date"][0] : '' ),
        'ewm_r_star_rating'        => ( array_key_exists( 'ewm_r_star_rating', $post_meta_d ) ? $post_meta_d["ewm_r_star_rating"][0] : '' ),
        'ewm_r_review_address'     => ( array_key_exists( 'ewm_r_review_address', $post_meta_d ) ? $post_meta_d["ewm_r_review_address"][0] : '' ),
        'ewm_r_street_address'     => ( array_key_exists( 'ewm_r_street_address', $post_meta_d ) ? $post_meta_d["ewm_r_street_address"][0] : '' ),
        'ewm_r_address_city'       => ( array_key_exists( 'ewm_r_address_city', $post_meta_d ) ? $post_meta_d["ewm_r_address_city"][0] : '' ),
        'ewm_r_address_state'      => ( array_key_exists( 'ewm_r_address_state', $post_meta_d ) ? $post_meta_d["ewm_r_address_state"][0] : '' ),
        'ewm_r_address_zip'        => ( array_key_exists( 'ewm_r_address_zip', $post_meta_d ) ? $post_meta_d["ewm_r_address_zip"][0] : '' ),
        'ewm_r_address_country'    => ( array_key_exists( 'ewm_r_address_country', $post_meta_d ) ? $post_meta_d["ewm_r_address_country"][0] : '' ),
        'ewm_r_job_description'    => ( array_key_exists( 'ewm_r_job_description', $post_meta_d ) ? $post_meta_d["ewm_r_job_description"][0] : '' ),
        'ewm_r_team_member'        => ( array_key_exists( 'ewm_r_team_member', $post_meta_d ) ? $post_meta_d["ewm_r_team_member"][0] : '' ),
        'ewm_wr_category_dropdown' => ( array_key_exists( 'ewm_wr_category_dropdown', $post_meta_d ) ? $post_meta_d["ewm_wr_category_dropdown"][0] : '' ),
        'ewm_r_related_page_id'    => ( array_key_exists( 'ewm_r_related_page_id', $post_meta_d ) ? $post_meta_d["ewm_r_related_page_id"][0] : '' ),
        'ewm_wr_img_file'          => $ewm_wr_image_id,
        'ewm_wr_img_file_url'      => $ewm_wr_img_file_url,
    ];

    $woo_c_post_id = $new_post_data['post_id'];
    $manager_link = admin_url() . "admin.php?page=ewm-r-new&ewm-review-id=" . $new_post_data['post_id'];
    $value_post_author = get_user_by( 'ID', $post_value->post_author );
    $author_name = $value_post_author->user_login;

    $ewm_r_review_details = [
        'woo_c_post_id' => $woo_c_post_id,
        'manager_link'  => $manager_link,
        'author_name'   => $author_name,
        'data'          => $data_details,
    ];

    echo  json_encode( [
        "update_successful" => true,
        "post_id"           => $new_post_data["post_id"],
        "post_is_new"       => $new_post_data["post_is_new"],
        "details"           => $ewm_r_review_details,
        "post_meta_d"       => $post_meta_d,
        'post'              => $_POST,
        'data_details'      => $data_details
    ] );

    wp_die();

}

function ewm_wr_review_list(){
    ob_start();
        include dirname( __FILE__ ) . '/vendor/templates/ewm_wr_list.php';
    return ob_get_clean();
}

function ewm_wr_review_form()
{
    ob_start();
        // include dirname( __FILE__ ) . '/vendor/templates/ewm_wr_form.php';
    return ob_get_clean();
}

add_shortcode( 'exclusive_worker_review', 'exclusive_worker_review_display' );

function ewm_ensure_page_is_listed(){

    // TODO:
    // get meta data
    $get_the_ID = get_the_ID();
    $ewm_wr_is_active = get_post_meta( $get_the_ID, 'ewm_wr_is_active' , true );

    // see if the metadata is listed properly
    if( $ewm_wr_is_active == 'true' ){
        // do nothing
    }
    else{
        //!is_string( $ewm_wr_is_active ) || strlen( $ewm_wr_is_active ) == 0 ){
        // create meta information
        add_post_meta( $get_the_ID, 'ewm_wr_is_active' , 'true' );
    }
    // $ewm_wr_is_active

}

function exclusive_worker_review_display(){

    ewm_ensure_page_is_listed(); // echo 'hello'; $get_the_ID = get_the_ID(); var_dump( $get_the_ID );
    $final_html = '<div class="ewm_wr_list_wrapper_outer">';

    $final_html .= ewm_wr_review_list();

    if ( is_user_logged_in() ) {
        $final_html .= ewm_wr_review_form();
    }
    $final_html .= '</div>';

    return $final_html;

}

function ewm_wr_review_string()
{
    $post_id = get_the_ID();
    $posts = get_posts( array(
        'numberposts' => -1,
        'post_type'   => 'ewm_worker_review',
        'meta_key'    => 'ewm_r_related_page_id',
        'meta_value'  => $post_id,
    ) );

    $review_list = '';
    foreach ( $posts as $post_type => $post_value ) {
        $post_meta_d = get_post_meta( $post_value->ID );
        $review_rating = ( array_key_exists( 'ewm_r_star_rating', $post_meta_d ) ? $post_meta_d["ewm_r_star_rating"][0] : '' );
        $team_member = ( array_key_exists( 'ewm_r_team_member', $post_meta_d ) ? $post_meta_d["ewm_r_team_member"][0] : '' );
        $review_body = ( array_key_exists( 'ewm_r_description', $post_meta_d ) ? $post_meta_d["ewm_r_description"][0] : '' );
        $review_list .= '{
            "@type": "Review",
            "reviewRating": {
              "@type": "Rating",
              "ratingValue": "' . $review_rating . '"
            },
            "author": {
              "@type": "Person",
              "name": "' . $team_member . '"
            },
            "reviewBody": "' . $review_body . '"
          },';
    }

    return '[' . $review_list . ']';

}

function ewm_wr_rating_aggregrated(){
    $post_id = get_the_ID();
    $posts = get_posts(array(
        'numberposts' => -1,
        'post_type'   => 'ewm_worker_review',
        'meta_key'    => 'ewm_r_related_page_id',
        'meta_value'  => $post_id,
    ) );
    $review_list = '';
    $bestRating = 0.0;
    $ratingCount = 0;
    $total_rating = 0;
    foreach ($posts as $post_type => $post_value) {
        $post_meta_d = get_post_meta($post_value->ID);
        $review_rating = (array_key_exists('ewm_r_star_rating', $post_meta_d) ? $post_meta_d["ewm_r_star_rating"][0] : 0);
        $team_member = (array_key_exists('ewm_r_team_member', $post_meta_d) ? $post_meta_d["ewm_r_team_member"][0] : '');
        $review_body = (array_key_exists('ewm_r_description', $post_meta_d) ? $post_meta_d["ewm_r_description"][0] : '');
        $total_rating = $total_rating + $review_rating;
        if ((float) $bestRating < (float) $review_rating) {
            $bestRating = $review_rating;
        }
    }
}

add_action( "wp_ajax_gpt_populate_review_form_fields", "gpt_populate_review_form_fields" );
function gpt_populate_review_form_fields(){

    $post_value_ID      = $_POST['review_id'];
    $post_meta_d        = get_post_meta( $post_value_ID ) ; // , 'ewm_r_worker_name' ) ;
    $manager_link       =  admin_url()."admin.php?page=ewm-r-new&ewm-review-id=" . $post_value->ID ;
    $worker_name        = array_key_exists( 'ewm_r_team_member' , $post_meta_d ) ? $post_meta_d["ewm_r_team_member"][0] : '' ; // "required": 1
    $job_description    = array_key_exists( 'ewm_r_job_description' , $post_meta_d ) ? $post_meta_d["ewm_r_job_description"][0] : '' ; // "required": 1
    $value_post_author  = get_user_by( 'ID' , $post_value->post_author ) ;
    $author_name        = $value_post_author->user_login ;

    $city               = array_key_exists( 'ewm_r_address_city' , $post_meta_d ) ? $post_meta_d["ewm_r_address_city"][0] : '' ; // "required": 1
    $state              = array_key_exists( 'ewm_r_address_state' , $post_meta_d ) ? $post_meta_d["ewm_r_address_state"][0] : '' ; // "required": 1
    $address            = array_key_exists( 'ewm_r_review_address' , $post_meta_d ) ? $post_meta_d["ewm_r_review_address"][0] : '' ; // "required": 1
    $zip 				= array_key_exists( 'ewm_r_address_zip' , $post_meta_d ) ? $post_meta_d["ewm_r_address_zip"][0] : '' ;

    $ewm_r_review_date 	= array_key_exists( 'ewm_r_review_date' , $post_meta_d ) ? $post_meta_d["ewm_r_review_date"][0] : '' ; 
    $review_place       = array_key_exists( 'ewm_r_review_place' , $post_meta_d ) ? $post_meta_d["ewm_r_review_place"][0] : '' ;
    $customer_name      = array_key_exists( 'ewm_r_customer_name' , $post_meta_d ) ? $post_meta_d["ewm_r_customer_name"][0] : '' ;
    $review_title       = array_key_exists( 'ewm_r_review_title' , $post_meta_d ) ? $post_meta_d["ewm_r_review_title"][0] : '' ;
    $description        = array_key_exists( 'ewm_r_description' , $post_meta_d ) ? $post_meta_d["ewm_r_description"][0] : '' ; 
    $star_rating        = array_key_exists( 'ewm_r_star_rating' , $post_meta_d ) ? $post_meta_d["ewm_r_star_rating"][0] : '' ;
    $related_page_id    = array_key_exists( 'ewm_r_related_page_id' , $post_meta_d ) ? $post_meta_d["ewm_r_related_page_id"][0] : '' ;
    $review_categories  = array_key_exists( 'ewm_wr_category_dropdown', $post_meta_d ) ? $post_meta_d["ewm_wr_category_dropdown"][0] : '' ;
    $ewm_wr_img_file    = array_key_exists( 'ewm_wr_img_file', $post_meta_d ) ? $post_meta_d["ewm_wr_img_file"][0] : 0 ;
    $ewm_r_address_country = array_key_exists( 'ewm_r_address_country', $post_meta_d ) ? $post_meta_d["ewm_r_address_country"][0] : 0 ;
    $ewm_wr_img_file_url = wp_get_attachment_url( $ewm_wr_img_file, 'full' );

    $address            = array_key_exists( 'ewm_r_address' , $post_meta_d ) ? $post_meta_d["ewm_r_address"][0] : '' ; // "required": 1
    $review_place       = array_key_exists( 'ewm_r_review_place' , $post_meta_d ) ? $post_meta_d["ewm_r_review_place"][0] : '' ;

    echo json_encode( [

        'ewm_wr_post_id' => $post_value_ID,
        'manager_link'  => $manager_link,
        'worker_name'   => $worker_name, // "required": 1
        'job_description' => $job_description, // "required": 1
        'value_post_author' => $value_post_author,
        'author_name' => $author_name,
        'city' => $city, // "required": 1
        'state' => $state, // "required": 1
        'address' => $address,
        'country'=> $ewm_r_address_country,
        'zip' => $zip,
        'ewm_r_review_date' => $ewm_r_review_date,
        'review_place' => $review_place,
        'customer_name' => $customer_name,
        'review_title' => $review_title,
        'description' => $description ,
        'star_rating' => $star_rating,
        'related_page_id' => $related_page_id,
        'review_categories' => $review_categories,
        'ewm_wr_img_file' => $ewm_wr_img_file,
        'ewm_wr_img_file_url' => $ewm_wr_img_file_url,
        'post' => $_POST

    ] ) ;

    wp_die();

}

add_action( 'wp_head', 'ewm_wr_schema_display' );

function ewm_wr_schema_display() {
    
    $post_id = get_the_ID();
    $get_post_data = get_post( $post_id );
    $get_post_data->post_title;
    $review_string = ewm_wr_review_string();
    $get_the_post_thumbnail = get_the_post_thumbnail( $post_id );
    $aggregrated = ewm_wr_rating_aggregrated();
    echo  '<script type="application/ld+json">
    {
      "@context": "https://schema.org/",
      "@type": "Product",
      "brand": {
        "@type": "Brand",
        "name": "' . $get_post_data->post_title . '"
      },
      "description": "' . $get_post_data->post_title . '",
      "sku": "' . $post_id . '",
      "mpn": "' . $post_id . '",
      "image": "' . $get_the_post_thumbnail . '",
      "name": "' . $get_post_data->post_title . '",
      "review": ' . $review_string . ',
      "aggregateRating": { ' . $aggregrated . ' }
    }
</script>' ;
}

add_action( "wp_ajax_nopriv_ewm_wr_add_edit_category", "ewm_wr_add_edit_category" );
add_action( "wp_ajax_ewm_wr_add_edit_category", "ewm_wr_add_edit_category" );
function ewm_wr_add_edit_category()
{
    ewm_wr_add_edit_cat( $_POST );
    echo  json_encode( $_POST ) ;
    wp_die();
}

add_action( "wp_ajax_nopriv_ewm_wrchatgpt_edit_group_data", "ewm_wrchatgpt_edit_group_data" );
add_action( "wp_ajax_ewm_wrchatgpt_edit_group_data", "ewm_wrchatgpt_edit_group_data" );
function ewm_wrchatgpt_edit_group_data(){

    $ewm_post_data = get_posts( [
        'post_parent' => $_POST[ 'ewm_group_id' ],
        'post_type' => 'gpt_group_item' ,
        'post_status' => 'active' ,
    ] );

    $data_det = [];

    foreach( $ewm_post_data as $ewm_post_k => $ewm_post_v ){

        $data_det[ $ewm_post_v->ID ] = [
            'ID' => $ewm_post_v->ID,
            'post_title' => get_post_meta( $ewm_post_v->ID, 'ewm_wr_gpt_review_title', true ),
        ] ;

    }

    $ewm_group_d = get_post( $_POST[ 'ewm_group_id' ] );
    // $ewm_group_d = get_post_meta( $_POST[ 'ewm_group_id' ], 'ewm_wr_gpt_review_title', true );

    echo  json_encode( [
        'ewm_post_data' => $data_det,
        'group_data' =>  $ewm_group_d->post_title
    ] );

    wp_die();

}

add_action( "wp_ajax_nopriv_ewm_wr_update_group_item", "ewm_wr_update_group_item" );
add_action( "wp_ajax_ewm_wr_update_group_item", "ewm_wr_update_group_item" );
function ewm_wr_update_group_item(){

    $group_item_id = $_POST['group_item_id'];

    $ewm_response = [
        'ewm_wr_gpt_review_title' => get_post_meta( $group_item_id, 'ewm_wr_gpt_review_title', true ),
        'ewm_wr_gpt_customer_name' => get_post_meta( $group_item_id, 'ewm_wr_gpt_customer_name', true ),
        'ewm_wr_gpt_rating' => get_post_meta( $group_item_id, 'ewm_wr_gpt_rating', true ),
        'ewm_wr_gpt_address' => get_post_meta( $group_item_id, 'ewm_wr_gpt_address',true ),
        'ewm_wr_gpt_category' => get_post_meta( $group_item_id, 'ewm_wr_gpt_category', true ),
        'ewm_wr_gpt_job_description' => get_post_meta( $group_item_id, 'ewm_wr_gpt_job_description', true ),
        'ewm_wr_gpt_team_member' => get_post_meta( $group_item_id, 'ewm_wr_gpt_team_member', true ),
        'post' => $_POST, 
        'meta' => get_post_meta( $group_item_id )
    ];

    echo json_encode( $ewm_response );

    wp_die();

}

add_action( "wp_ajax_nopriv_ewm_wr_generate_review_list", "ewm_wr_generate_review_list" );
add_action( "wp_ajax_ewm_wr_generate_review_list", "ewm_wr_generate_review_list" );
function ewm_wr_generate_review_list(){ // $post_id = get_the_ID() ;
    $posts = get_posts( array( // 'numberposts'   => -1,
        'post_type'     => 'ewm_worker_review' , // 'ewm_worker_review',    // 'meta_key'      => 'ewm_r_related_page_id', // 'post_status' => 'active',
        'post_parent'    => $_POST['post_id'],
        'post_status' => 'publish',
        'posts_per_page'=> -1,
    ) );

    // var_dump($posts );
    $ewm_ratting_list = [] ; // echo $posts_count .'<br>'; // $posts ;
    $response_review_list = [];

    foreach( $posts as $post_type => $post_value ){

        $post_meta_d        = get_post_meta( $post_value->ID ) ; // , 'ewm_r_worker_name' ) ;
        $ewm_wr_post_id      = $post_value->ID ;
        $manager_link       =  admin_url()."admin.php?page=ewm-r-new&ewm-review-id=" . $post_value->ID ;
        $worker_name        = array_key_exists( 'ewm_r_team_member' , $post_meta_d ) ? $post_meta_d["ewm_r_team_member"][0] : '' ; // "required": 1
        $job_description    = array_key_exists( 'ewm_r_job_description' , $post_meta_d ) ? $post_meta_d["ewm_r_job_description"][0] : '' ; // "required": 1
        $value_post_author  = get_user_by( 'ID' , $post_value->post_author ) ;
        $author_name        = $value_post_author->user_login ;
        $city               = array_key_exists( 'ewm_r_address_city' , $post_meta_d ) ? $post_meta_d["ewm_r_address_city"][0] : '' ; // "required": 1
        $state              = array_key_exists( 'ewm_r_address_state' , $post_meta_d ) ? $post_meta_d["ewm_r_address_state"][0] : '' ; // "required": 1
        $address            = array_key_exists( 'ewm_r_address' , $post_meta_d ) ? $post_meta_d["ewm_r_address"][0] : '' ; // "required": 1
        $zip 				= array_key_exists( 'ewm_r_address_zip' , $post_meta_d ) ? $post_meta_d["ewm_r_address_zip"][0] : '' ;
        $ewm_r_review_date 	= array_key_exists( 'ewm_r_review_date' , $post_meta_d ) ? $post_meta_d["ewm_r_review_date"][0] : '' ; 
        $review_place       = array_key_exists( 'ewm_r_review_place' , $post_meta_d ) ? $post_meta_d["ewm_r_review_place"][0] : '' ;
        $customer_name      = array_key_exists( 'ewm_r_customer_name' , $post_meta_d ) ? $post_meta_d["ewm_r_customer_name"][0] : '' ;
        $review_title       = array_key_exists( 'ewm_r_review_title' , $post_meta_d ) ? $post_meta_d["ewm_r_review_title"][0] : '' ;
        $description        = array_key_exists( 'ewm_r_description' , $post_meta_d ) ? $post_meta_d["ewm_r_description"][0] : '' ; 
        $star_rating        = array_key_exists( 'ewm_r_star_rating' , $post_meta_d ) ? $post_meta_d["ewm_r_star_rating"][0] : '' ;
        $related_page_id    = array_key_exists( 'ewm_r_related_page_id' , $post_meta_d ) ? $post_meta_d["ewm_r_related_page_id"][0] : '' ;
        $review_categories  = array_key_exists( 'ewm_wr_category_dropdown', $post_meta_d ) ? $post_meta_d["ewm_wr_category_dropdown"][0] : '' ;
        $ewm_wr_img_file    = array_key_exists( 'ewm_wr_img_file', $post_meta_d ) ? $post_meta_d["ewm_wr_img_file"][0] : 0 ;
        $ewm_wr_img_file_url = wp_get_attachment_image_src( $ewm_wr_img_file, 'full' );

        if( is_array( $ewm_wr_img_file_url ) ){
            $ewm_wr_img_file_url = $ewm_wr_img_file_url[0];
        }

        $response_review_list[ $ewm_wr_post_id ] = [

            'ewm_wr_post_id' => $ewm_wr_post_id,
            'manager_link' => $manager_link ,
            'worker_name' => $worker_name,
            'job_description' => $job_description,
            'value_post_author' => $value_post_author,
            'author_name' => $author_name ,

            'city' => $city,
            'state' => $state ,
            'address' => $address .' '. $review_place,
            'zip' => $zip,

            'ewm_r_review_date' => $ewm_r_review_date,
            'review_place' => $review_place,
            'customer_name' => $customer_name,
            'review_title' => $review_title,
            'description' => $description,
            'star_rating' => $star_rating,
            'related_page_id' => $related_page_id,
            'review_categories' => $review_categories,
            'ewm_wr_img_file' => $ewm_wr_img_file,
            'ewm_wr_img_file_url' => $ewm_wr_img_file_url

        ] ;
        
    }

    echo json_encode( [
        'review_list'=> $response_review_list
    ] );

    wp_die();

}

/*
    'gpt_review_post_id' => $_review_post_id,
    'group_parent_id' => $_group_parent_id,
    'ewm_wr_chatgpt_instant' => $_POST[ 'ewm_wr_chatgpt_instant' ]
*/
function ewm_wr_generate_new_chatgpt_for_group( $args = [] ) {

    // schedule post generation right away. // create schedule posts. // find groups
    // loop through the group list -> create schedule post // get single group list // gpt_schedule_single_listing // $_gen_d = get_post_meta( $args['gpt_review_post_id'] );
    // get list of group items and run each of them
    $gpt_group_items = get_posts( [ // 'post_title' => $_POST['ewm_wr_gpt_review_title'],
        'post_type' => 'gpt_group_item',
        'post_status' => 'active',
        'post_parent' => $args['group_parent_id'], // $args_id // $_POST['group_parent_id']
        'fields' => 'ids'
    ] );

    foreach( $gpt_group_items as $item_k => $item_v ){

        $args_id = $item_v ;
        $instant = $args[ 'ewm_wr_chatgpt_instant' ];
        $post_id = $args[ 'gpt_review_post_id' ]; // echo ' ewm_wr_generate_new_chatgpt_for_group $args_id $instant $post_id' ;
        ewm_wr_update_single_schedule( $args_id, $instant, $post_id );

    }

    return 0;// $arg_gen_id;

}

add_action( "wp_ajax_nopriv_ewm_wr_update_chatgpt_request", "ewm_wr_update_chatgpt_request" );
add_action( "wp_ajax_ewm_wr_update_chatgpt_request", "ewm_wr_update_chatgpt_request" );
function ewm_wr_update_chatgpt_request(){ // all pages // single page >> // If post does not exist >> create it, else update time on meta

    $ewm_wrchatgpt_page_id = $_POST['ewm_wrchatgpt_page_id'];

    /*
    $ewm_wrchatgpt_list = get_posts( [
        'post_parent' => $_POST['ewm_wrchatgpt_page_id'],
        'post_type' => 'ewm_gpt_gen',
    ] );
    */

    // $_search_post_exists = false;

    /*
        if( is_array( $ewm_wrchatgpt_list ) ) {
            if( count( $ewm_wrchatgpt_list ) > 0 ) { // update
                $_search_post_exists = true;
            }
        }
    */

    $_review_post_id = $_POST['ewm_wrchatgpt_page_id'];    // if( $_POST['ewm_wrchatgpt_search_id'] > 0 ) { // update
    $_post_id = $_POST['ewm_wrchatgpt_page_id'];
    $_review_post_id = $_POST['ewm_wrchatgpt_page_id'];

    update_post_meta( $_post_id, 'ewm_wr_chatgpt_daily', $_POST['ewm_wr_chatgpt_daily'] ); // add_post_meta(  $_post_id, 'ewm_wr_chatgpt_number_of_reviews',  $_POST['ewm_wr_chatgpt_number_of_reviews'] , false );
    update_post_meta( $_post_id, 'ewm_wrchatgpt_page_id',  $_POST[ 'ewm_wrchatgpt_page_id' ] );
    update_post_meta( $ewm_wrchatgpt_page_id, 'ewm_wrchatgpt_group_list',  $_POST[ 'ewm_wrchatgpt_group_list' ] );
    update_post_meta( $_post_id, 'ewm_wr_chatgpt_instant',  $_POST[ 'ewm_wr_chatgpt_instant' ] );
    update_post_meta( $_post_id, 'ewm_wr_chatgpt_city',  $_POST[ 'ewm_wr_chatgpt_city' ] );

    // }
    //else{ // create new post
    /*
            $_post_data = [
                'post_parent' => $_POST['ewm_wrchatgpt_page_id'],
                'post_type' => 'ewm_gpt_gen',
            ] ;
            $_post_id = wp_insert_post( $_post_data );
            add_post_meta(  $_post_id, 'ewm_wr_chatgpt_daily', $_POST['ewm_wr_chatgpt_daily'] , false ); // add_post_meta(  $_post_id, 'ewm_wr_chatgpt_number_of_reviews',  $_POST['ewm_wr_chatgpt_number_of_reviews'] , false );
            add_post_meta(  $_post_id, 'ewm_wrchatgpt_page_id',  $_POST[ 'ewm_wrchatgpt_page_id' ] , false );
            add_post_meta(  $ewm_wrchatgpt_page_id, 'ewm_wrchatgpt_group_list',  $_POST[ 'ewm_wrchatgpt_group_list' ] , false );
            add_post_meta(  $_post_id, 'ewm_wr_chatgpt_instant',  $_POST[ 'ewm_wr_chatgpt_instant' ] , false );

        }
    */

    // if( $_POST[ 'ewm_wr_chatgpt_instant' ] == true ){ // var_dump( $_POST[ 'ewm_wr_chatgpt_instant' ] );

        $ewm_wrchatgpt_group_list = explode( ',', $_POST[ 'ewm_wrchatgpt_group_list' ] );
        $ewm_wrgpt_g_l = [];

        foreach( $ewm_wrchatgpt_group_list as $ewm_k => $ewm_v ){
            if(is_numeric($ewm_v)) {
                $ewm_wrgpt_g_l[ $ewm_v ] = $ewm_v;
            }
        }

        foreach( $ewm_wrgpt_g_l as $group_key => $group_value ){
            $_group_parent_id = $group_value;
            ewm_wr_generate_new_chatgpt_for_group( [
                'gpt_review_post_id' => $_review_post_id,
                'group_parent_id' => $_group_parent_id,
                'ewm_wr_chatgpt_instant' => $_POST[ 'ewm_wr_chatgpt_instant' ],
                'ewm_wr_chatgpt_daily' => $_POST[ 'ewm_wr_chatgpt_daily' ] 
            ] );
        }

    // }
    // if( $_POST[ 'ewm_wr_chatgpt_daily' ] == true ){
        // ewm_wr_schedule_daily( $_review_post_id );
    //} // schedule generation  // $search_post_id = ewm_wr_chatgpt_schedule_search_post( $_review_post_id ); // $_post_id // $_review_post_id

    echo  json_encode( [ // 'post'=> $_POST
        'post_id'=> $_post_id,
        'search_post_id' => $_review_post_id,
        'post' => $_POST
    ] );

    wp_die();

}

function ewm_generate_single_worker_reviews(){
    // ewm_generate_single_worker_reviews
    // generate chatgpt
    // update the relevant reviews

}

function ewm_generate_all_worker_reviews(){
    // get all posts
    $_list_of_all_posts = [];

    // loop through all posts
    foreach( $_list_of_all_posts as $post_key => $post_val ){
        ewm_generate_single_worker_reviews([
            'post_id' => $post_val->ID
        ]);
    }

}

add_action( "wp_ajax_nopriv_ewm_wrchatgpt_generate_worker_review_button", "ewm_wrchatgpt_generate_worker_review_button" );
add_action( "wp_ajax_ewm_wrchatgpt_generate_worker_review_button", "ewm_wrchatgpt_generate_worker_review_button" );
function ewm_wrchatgpt_generate_worker_review_button(){

    // all pages / single page > // If post does not exist -> create it, else update time on meta
    if ( $_POST['ewm_search_post_id'] == 'all' ){
        $worker_review_post_id = ewm_generate_all_worker_reviews();
    }
    else{
        $worker_review_post_id = ewm_generate_single_worker_reviews();
    }

    echo  json_encode([ // 'post'=> $_POST,
        // 'search_post_id' => $search_post_id
    ]);

    wp_die();

}

add_action( 'wp_ajax_nopriv_ewm_wrchatgpt_new_group_id', 'ewm_wrchatgpt_new_group_id' );
add_action( 'wp_ajax_ewm_wrchatgpt_new_group_id', 'ewm_wrchatgpt_new_group_id' );
function ewm_wrchatgpt_new_group_id(){

    // create a new group id, and return it
    $post_data = [
        'post_title' => 'New Group',
        'post_status' => 'newdraft',
        'post_type' => 'wr_gpt_group',
        'post_parent' => $_POST['group_parent_id'],
    ];

    $new_post_id = wp_insert_post( $post_data, $wp_error );

    echo json_encode([ 'new_gpt_group_id' => $new_post_id ]);
    wp_die();

}

add_action( 'wp_ajax_nopriv_ewm_wr_delete_single_g_item', 'ewm_wr_delete_single_g_item' );
add_action( 'wp_ajax_ewm_wr_delete_single_g_item', 'ewm_wr_delete_single_g_item' );
function ewm_wr_delete_single_g_item(){

    // create a new group id, and return it
    $new_post_id = wp_delete_post( $_POST['single_g_item_id'] );

    echo json_encode( [
        'new_post_id' =>  $_POST['single_g_item_id']
    ] );

    wp_die();

}

// ewm_wr_save_single_b
add_action( 'wp_ajax_nopriv_ewm_wr_save_single_b', 'ewm_wr_save_single_b' );
add_action( 'wp_ajax_ewm_wr_save_single_b', 'ewm_wr_save_single_b' );
function ewm_wr_save_single_b(){

    // create a new group id, and return it
    $post_data = [
        'ID' => $_POST['group_id'],
        'post_title' => $_POST['group_title'],
        'post_status' => 'active',
        'post_type' => 'wr_gpt_group',
    ];

    $meta_data = [
        'group_parent_id' => $_POST['group_parent_id'],
        'ewm_wr_gpt_review_title' => $_POST['ewm_wr_gpt_review_title'],
        'ewm_wr_gpt_customer_name' => $_POST['ewm_wr_gpt_customer_name'],
        'ewm_wr_gpt_rating' => $_POST['ewm_wr_gpt_rating'],
        'ewm_wr_gpt_address' => $_POST['ewm_wr_gpt_address'],
        'ewm_wr_gpt_category' => $_POST['ewm_wr_gpt_category'],
        'ewm_wr_gpt_job_description' => $_POST['ewm_wr_gpt_job_description'],
        'ewm_wr_gpt_team_member' => $_POST['ewm_wr_gpt_team_member'],
        'ewm_wrchatgpt_group_item_id' => $_POST['ewm_wrchatgpt_group_item_id']
        // 'ewm_wr_chatgpt_delete' => $_POST['ewm_wr_chatgpt_delete']
    ] ;

    if($_POST['ewm_wrchatgpt_group_item_id'] == 0) {
        $new_post_id = wp_insert_post([
            'post_title' => $_POST['ewm_wr_gpt_review_title'],
            'post_type' => 'gpt_group_item',
            'post_status' => 'active',
            'post_parent' => $_POST['group_parent_id']
        ]);
    }
    else{
        $new_post_id = $_POST['ewm_wrchatgpt_group_item_id'];
    }

    foreach( $meta_data as $k => $v ) {
        update_post_meta( $new_post_id, $k , $v);
    }

    $new_post_data  = get_post( $new_post_id );

    echo json_encode( [
        'post' => $new_post_data,
        'new_gpt_group_item_id' => $new_post_id,
        'item_title' => $_POST['ewm_wr_gpt_review_title']
    ] );

    wp_die();

}

add_action( 'wp_ajax_nopriv_ewm_gpt_populate_group', 'ewm_gpt_populate_group' );
add_action( 'wp_ajax_ewm_gpt_populate_group', 'ewm_gpt_populate_group' );
function ewm_gpt_populate_group(){ // $_POST['ewm_wr_group_id'] // ewm_gpt_populate_group

    $gpt_number_reviews_per_page = '';
    $dpt_delete_past_worker_reviews_on_each_page = '';
    $gpt_select_group = '';
    $post_id = 0 ;

    $post_list = get_post( [
        'post_parent' => $_POST['ewm_wr_page_id'],
        'post_type' => 'gtpsearcht',
    ] );

    /*
        if( is_array( $post_list ) ) {
            if(count($post_list) > 0) {
                $post_id = $post_list[0]->ID;
                $gpt_number_reviews_per_page = get_post_meta( $post_id , 'review_numb' );
                $dpt_delete_past_worker_reviews_on_each_page = get_post_meta( $post_id , 'delete_past' );
            }
        }

    */

    $gpt_select_group = explode( ',', get_post_meta( $_POST['ewm_wr_page_id'] , 'ewm_wrchatgpt_group_list', true ) );
    $ewm_wr_chatgpt_daily = get_post_meta( $_POST['ewm_wr_page_id'] , 'ewm_wr_chatgpt_daily', true );
    $ewm_wr_chatgpt_city = get_post_meta( $_POST['ewm_wr_page_id'] , 'ewm_wr_chatgpt_city', true );

    echo json_encode( [
        // 'gpt_post' => $_POST, // 'post_id' => $post_id, // 'gpt_number_reviews_per_page' => $gpt_number_reviews_per_page,
        // 'dpt_delete_past_worker_reviews_on_each_page' => $dpt_delete_past_worker_reviews_on_each_page,
        'gpt_select_group' => $gpt_select_group ,
        'ewm_wr_chatgpt_daily' => $ewm_wr_chatgpt_daily,
        'ewm_wr_chatgpt_city' => $ewm_wr_chatgpt_city,
    ] );

    wp_die();

}

add_action( 'wp_ajax_nopriv_ewm_wr_group_name_title', 'ewm_wr_group_name_title' );
add_action( 'wp_ajax_ewm_wr_group_name_title', 'ewm_wr_group_name_title' );
function ewm_wr_group_name_title(){

    // create a new group id, and return it
    $post_data = [
        'ID' => $_POST['group_id'],
        'post_title' => $_POST['group_title'],
        'post_status' => 'active',
        'post_type' => 'wr_gpt_group',
    ];

    $new_post_id = wp_update_post( $post_data, $wp_error );

    echo json_encode([ 'new_gpt_group_id' => $new_post_id ]);

    wp_die();

}

add_action( 'wp_ajax_nopriv_ewm_wrchatgpt_new_group_data', 'ewm_wrchatgpt_new_group_data' );
add_action( 'wp_ajax_ewm_wrchatgpt_new_group_data', 'ewm_wrchatgpt_new_group_data' );
function ewm_wrchatgpt_new_group_data(){

    $ewm_wrchatgpt_group_data = get_post( $_POST['ewm_group_id'] );

    echo json_encode([
        'group_data' => $ewm_wrchatgpt_group_data
    ]);

    wp_die();


}

add_action( 'wp_ajax_nopriv_ewm_wr_sing_group_delete', 'ewm_wr_sing_group_delete' );
add_action( 'wp_ajax_ewm_wr_sing_group_delete', 'ewm_wr_sing_group_delete' );
function ewm_wr_sing_group_delete(){

    $ewmgpt_sitem = get_posts([
        'post_parent' => $_POST['group_id'],
        'post_type' => 'ewmgpt_sitem'
    ]);

    if( is_array( $ewmgpt_sitem ) ){
        foreach( $ewmgpt_sitem as $v => $k ){
            wp_delete_post( $k->ID );
        }
    }

    $deleted_group_id = wp_delete_post( $_POST['group_id'] );

    echo json_encode( [
        'deleted_group_id' => $deleted_group_id,
        'group_id' =>  $_POST['group_id']
    ] );
    
    wp_die();

}

add_action( 'wp_ajax_nopriv_ewm_wrchatgpt_group_title_update', 'ewm_wrchatgpt_group_title_update' );
add_action( 'wp_ajax_ewm_wrchatgpt_group_title_update', 'ewm_wrchatgpt_group_title_update' );
function ewm_wrchatgpt_group_title_update(){

    $new_group_title = [
        'ID' => $_POST['group_id'],
        'post_title' => $_POST['group_title'],
        'post_status' => 'active',
        'post_type' => 'wr_gpt_group'
    ];

    wp_update_post( $new_group_title );

    echo json_encode([
        'group_title' => $new_group_title['post_title'],
        'group_id' => $_POST['group_id']
    ]);
    
    wp_die();

}

add_action( 'wp_ajax_nopriv_ewm_wr_delete_cat_review', 'ewm_wr_delete_cat_review' );
add_action( 'wp_ajax_ewm_wr_delete_cat_review', 'ewm_wr_delete_cat_review' );
function ewm_wr_delete_cat_review()
{
    $post_id = $_POST['ewm_wr_cat_post_id'];
    $meta_key = 'ewm_front_cats';
    $meta_value = $_POST['ewm_wr_category_f'];
    $delete_post_meta = delete_post_meta( $post_id, $meta_key, $meta_value );
    echo  json_encode( [
        'data'         => $_POST,
        'post details' => $delete_post_meta,
    ] ) ;
    wp_die();
}

function gpt_process_thumbnail_image( $args = array() ){
    // $images =;
    $media = '';
    $new_post_id = $args['post_id'];
    $image_url =  $args['image_url'];

    // Magic sideload image returns an HTML image, not an ID
    $media = media_sideload_image( $image_url, $new_post_id, 'id' );

    // Therefore we must find it so we can set it as featured ID
    if ( !empty( $media ) && !is_wp_error( $media ) ) {

        $args = array(
            'post_type'      => 'attachment',
            'posts_per_page' => -1,
            'post_status'    => 'any',
            'post_parent'    => $new_post_id,
        );

        // Reference new image to set as featured
        $attachments = get_posts( $args );
        if ( isset( $attachments ) && is_array( $attachments ) ) {
            foreach ( $attachments as $attachment ) {
                // Grab source of full size images (so no 300x150 nonsense in path)
                $image = wp_get_attachment_image_src( $attachment->ID, 'full' );
                // Determine if in the $media image we created, the string of the URL exists
                
                if ( strpos( $media, $image[0] ) !== false ) {
                    // If so, we found our image. set it as thumbnail
                    set_post_thumbnail( $new_post_id, $attachment->ID );
                    // Only want one image
                    break;
                }
            }
        }
    }
    
    if ( is_wp_error( $media ) ) {
        echo  $media->get_error_message() ;
    }
    return $attachment->ID;

}

function gpt_r_add_listing_meta_d( $new_post_data = [] ){

    $args = $new_post_data['args'];

    // Map to Actual Metas // Get Metadata Fields
    $post_id = $new_post_data['post_id'];
    $final_arr = [
        'ewm_r_review_title'       => sanitize_text_field( $args['ewm_r_review_title'] ),
        'ewm_r_description'        => sanitize_text_field( $args['ewm_r_description'] ),
        'ewm_r_customer_name'      => sanitize_text_field( $args['ewm_r_customer_name'] ),
        'ewm_r_review_date'        => date( 'Y-m-d H:i:s' ),
        'ewm_r_star_rating'        => sanitize_text_field( $args['ewm_r_star_rating'] ),
        'ewm_r_review_address'     => sanitize_text_field( $args['ewm_r_review_address'] ),
        'ewm_r_street_address'     => sanitize_text_field( $args['ewm_r_street_address'] ),
        'ewm_r_address_city'       => sanitize_text_field( $args['ewm_r_address_city'] ),
        'ewm_r_address_state'      => sanitize_text_field( $args['ewm_r_address_state'] ),
        'ewm_r_address_zip'        => sanitize_text_field( $args['ewm_r_address_zip'] ),
        'ewm_r_address_country'    => sanitize_text_field( $args['ewm_r_address_country'] ),
        'ewm_r_job_description'    => sanitize_text_field( $args['ewm_r_job_description'] ),
        'ewm_r_team_member'        => sanitize_text_field( $args['ewm_r_team_member'] ),
        'ewm_wr_category_dropdown' => sanitize_text_field( $args['ewm_wr_category_dropdown'] ),
        'ewm_r_related_page_id'    => sanitize_text_field( $args['ewm_r_related_page_id'] ),
        'ewm_wr_img_file'          => sanitize_text_field( $args['ewm_wr_img_file'] ),
    ];
    
    // Create Metadata
    $meta_arr_box = [];
    $tt = 0;
    $post_meta_data = get_post_meta( $post_id );
    foreach ( $final_arr as $meta_key => $meta_value ) {
        
        if ( $args['post_is_new'] ) {
            $meta_arr_box[$tt] = add_post_meta(
                $post_id,
                $meta_key,
                $meta_value,
                true
            );
        } else {
            $meta_arr_box[$tt] = update_post_meta(
                $post_id,
                $meta_key,
                $meta_value,
                $post_meta_data[$meta_key][0]
            );
        }
        
        $tt++;
    }

}

function gpt_r_add_listing_post_data( $args ){

    $current_user_id = get_current_user_id();
    // Add mapping to see were a product relate tot the other
    // => Add new product if the product does not exist => Update the old product of the product already exist // Add Post
    $content_slug = preg_replace( '#[ -]+#', '-', sanitize_text_field( $args['ewm_r_review_title'] ) );
    $args['ewm_r_worker_name'];
    $args['ewm_r_job_description'];
    $args['ewm_r_value_post_author'];

    // Update on server side
    $args['ewm_r_post_id'];
    $args['ewm_r_city'];
    $args['ewm_r_state'];
    $args['ewm_r_address'];
    $args['ewm_r_review_place'];
    $args['ewm_r_customer_name'];
    $args['ewm_r_review_title'];
    $args['ewm_r_description'];
    $args['ewm_r_star_rating'];
    $args['ewm_r_related_page_id'];
    $args['ewm_r_review_submit'];

    // Create post
    $post_data = [
        "post_author"           => $current_user_id,
        "post_date"             => date( 'Y-m-d H:i:s' ),
        "post_date_gmt"         => date( 'Y-m-d H:i:s' ),
        "post_content"          => sanitize_text_field( $args['ewm_r_description'] ),
        "post_title"            => sanitize_text_field( $args['ewm_r_review_title'] ),
        "post_excerpt"          => sanitize_text_field( $args['ewm_r_description'] ),
        "post_status"           => "publish",
        "comment_status"        => "open",
        "ping_status"           => "closed",
        "post_password"         => "",
        "post_name"             => $content_slug,
        "to_ping"               => "",
        "pinged"                => "",
        "post_modified"         => date( 'Y-m-d H:i:s' ),
        "post_modified_gmt"     => date( 'Y-m-d H:i:s' ),
        "post_content_filtered" => "",
        "post_parent"           => $args['ewm_r_related_page_id'], 
        "guid"                  => "",
        "menu_order"            => 0,
        "post_type"             => "ewm_worker_review",
        "post_mime_type"        => "",
        "comment_count"         => "0",
        "filter"                => "raw",
    ] ;

    global  $wp_error ;
    $new_post_data = $args;
    $new_post_data = [
        'post_id'     => '',
        'post_is_new' => '',
    ];
    $new_post_id = '';

    // @todo change from name to id
    remove_all_filters( "content_save_pre" );
    add_filter( 'wp_kses_allowed_html', 'wpse_kses_allowed_html', 10, 2 ) ;
    
    if ( sanitize_text_field( $args['ewm_r_post_id'] ) == 0 ) {

        $new_post_id = wp_insert_post( $post_data, $wp_error );
        $new_post_data['post_id'] = $new_post_id;
        $new_post_data['post_is_new'] = true;

    } else {

        $new_post_id = intval( sanitize_text_field( $args['ewm_r_post_id'] ) );
        $new_post_data['post_id'] = $new_post_id;
        $new_post_data['post_is_new'] = false;

        // do product post update
        $post_data['ID'] = $args['ewm_r_post_id'];
        $wp_update_d = wp_update_post( $post_data ); // var_dump( $wp_update_d ) ;

    }
    
    // Remove Custom Filter
    remove_filter( 'wp_kses_allowed_html', 'wpse_kses_allowed_html', 10 );

    // $new_post_data = $args;

    return $new_post_data;

}

// Other sections
include dirname( __FILE__ ) . '/class_chatgpt.php';
include dirname( __FILE__ ) . '/class_city.php';
include dirname( __FILE__ ) . '/class_schedule.php';


/* add_shortcode('ewm_access_image_chat', 'ewm_access_image_chat') ; // gpt_run_schedule_data
function gpt_wp_footer_list(){

    // $review_main_post =  224;
    $_post_data = [
        'post_parent' => $review_main_post,
        'post_type' => 'ewm_gpt_gen',
        'post_status' => 'published',
    ] ;

    $_post_d = get_posts( $_post_data ); // add_post_meta(  $_post_id, 'ewm_wrchatgpt_page_id',  $_POST[ 'ewm_wrchatgpt_page_id' ] , false );
    $ewm_wrchatgpt_group_list = get_post_meta( $_post_d[0]->ID , 'ewm_wrchatgpt_group_list', true );
    $wr_gpt_group = get_posts([
        'post_type' => 'wr_gpt_group',
        'post_parent' => $review_main_post,
        'post_status' => 'active',
    ]);
    $ewm_wrchatgpt_group_arr = explode( ',', $ewm_wrchatgpt_group_list );
    // echo 'schedule:<br><br>';
    foreach( $ewm_wrchatgpt_group_arr as $g_key => $g_value ){

        $gpt_wp_group_child_list = get_posts( [
            'post_type' => 'gpt_group_item',
            'post_status' => 'active',
            'post_parent' => $g_value
        ] );

        // echo count( $gpt_wp_group_child_list ) . '<br><br>';
        // array(2) { [0]=> object(WP_Post)#1286 (24) { ["ID"]=> int(3644) ["post_author"]=> string(1) "2" ["post_date"]=> string(19) "2023-09-01 16:20:45" ["post_date_gmt"]=> string(19) "2023-09-01 16:20:45" ["post_content"]=> string(0) "" ["post_title"]=> string(10) "title name" ["post_excerpt"]=> string(0) "" ["post_status"]=> string(6) "active" ["comment_status"]=> string(6) "closed" ["ping_status"]=> string(6) "closed" ["post_password"]=> string(0) "" ["post_name"]=> string(10) "title-name" ["to_ping"]=> string(0) "" ["pinged"]=> string(0) "" ["post_modified"]=> string(19) "2023-09-01 16:20:45" ["post_modified_gmt"]=> string(19) "2023-09-01 16:20:45" ["post_content_filtered"]=> string(0) "" ["post_parent"]=> int(3629) ["guid"]=> string(29) "http://workshop-1.com/?p=3644" ["menu_order"]=> int(0) ["post_type"]=> string(14) "gpt_group_item" ["post_mime_type"]=> string(0) "" ["comment_count"]=> string(1) "0" ["filter"]=> string(3) "raw" } [1]=> object(WP_Post)#1315 (24) { ["ID"]=> int(3630) ["post_author"]=> string(1) "2" ["post_date"]=> string(19) "2023-08-24 06:42:49" ["post_date_gmt"]=> string(19) "2023-08-24 06:42:49" ["post_content"]=> string(0) "" ["post_title"]=> string(5) "title" ["post_excerpt"]=> string(0) "" ["post_status"]=> string(6) "active" ["comment_status"]=> string(6) "closed" ["ping_status"]=> string(6) "closed" ["post_password"]=> string(0) "" ["post_name"]=> string(5) "title" ["to_ping"]=> string(0) "" ["pinged"]=> string(0) "" ["post_modified"]=> string(19) "2023-08-24 06:42:49" ["post_modified_gmt"]=> string(19) "2023-08-24 06:42:49" ["post_content_filtered"]=> string(0) "" ["post_parent"]=> int(3629) ["guid"]=> string(29) "http://workshop-1.com/?p=3630" ["menu_order"]=> int(0) ["post_type"]=> string(14) "gpt_group_item" ["post_mime_type"]=> string(0) "" ["comment_count"]=> string(1) "0" ["filter"]=> string(3) "raw" } }
        foreach( $gpt_wp_group_child_list as $wp_key => $wp_value ) { // var_dump( get_post_meta(  $wp_value->ID ) ); // echo '<br><br><br>'; // var_dump( $gpt_wp_footer_list );
            /*
                $details_id =  ewm_wr_generate_new_chatgpt( [
                    'gen_id' => $wp_value->ID ,
                    'gen_main_post' => $review_main_post
                ] );
                echo $details_id . '<br><br>';
            */
    /*    }

    }

}

/*
function gpt_footer_data_d(){

    // $gtpt_ll = [ 4612, 4613, 4614, 4615, 4616, 4617, 4618, 4619 ];
    foreach( $gtpt_ll as $dd_k => $dd_v ){

        var_dump( get_post( $dd_v ) );
        echo '<br><br>';

        var_dump( get_post_meta( $dd_v ) );
        echo '<br><br>';

        /*
        array(8) {
            ["group_parent_id"]=> array(1) { [0]=> string(4) "3651" } 
            ["ewm_wr_gpt_review_title"]=> array(1) { [0]=> string(10) "title name" } 
            ["ewm_wr_gpt_customer_name"]=> array(1) { [0]=> string(8) "customer" } 
            ["ewm_wr_gpt_rating"]=> array(1) { [0]=> string(1) "4" } 
            ["ewm_wr_gpt_address"]=> array(1) { [0]=> string(6) "street" } 
            ["ewm_wr_gpt_category"]=> array(1) { [0]=> string(7) "Cooling" } 
            ["ewm_wr_gpt_job_description"]=> array(1) { [0]=> string(4) "job " } 
            ["ewm_wr_gpt_team_member"]=> array(1) { [0]=> string(4) "team" } 
        } 
        */
/*
    }

}
/*
function gpt_footer_data_pp(){ // var_dump( get_post_meta( 4714 ) );
    $post_value_ID = 4748;
    $post_meta_d = get_post_meta( $post_value_ID ) ;
    var_dump( $post_meta_d );
}*/

add_action( 'wp_footer', 'gpt_run_outstanding_schedule' );

/*
function ewm_wr_ff_ajax(){

    echo `
    var ewm_wr_load_gpt_scheduler = function(){

        var form_data = new FormData();
        form_data.append( 'action' , 'gpt_run_outstanding_schedule' );

        jQuery.ajax( {

            url: ajax_object.ajaxurl,
            type: 'post',
            contentType: false,
            processData: false,
            data: form_data,
            success: function ( response ) {
                response = JSON.parse(response) ;
            },
            error: function (response) {
                console.log( response ) ;
            }

        } );

    }

    ewm_wr_load_gpt_scheduler();

    `;

}
*/

?>
