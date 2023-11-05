<?php

/**
 * Plugin Name: Exclusive Worker Reviews
 * Description: Provides the ability to add worker reviews that are SEO friendly.
 * Version: 1.0.18
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
require __DIR__ . '/vendor/autoload.php';
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
                'is_premium'       => false,
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

function ewm_r_add_listing_post_data( $args )
{
    $current_user_id = get_current_user_id();
    // Add mapping to see were a product relate tot the other
    // => Add new product if the product does not exist => Update the old product of the product already exist
    // Add Post
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
        "post_parent"           => 0,
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
    ];
    $new_post_id = '';
    // @todo change from name to id
    remove_all_filters( "content_save_pre" );
    add_filter(
        'wp_kses_allowed_html',
        'wpse_kses_allowed_html',
        10,
        2
    );
    
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
        $wp_update_d = wp_update_post( $post_data );
        // var_dump( $wp_update_d ) ;
    }
    
    // Remove Custom Filter
    remove_filter( 'wp_kses_allowed_html', 'wpse_kses_allowed_html', 10 );
    return $new_post_data;
}

function ewm_r_add_listing_meta_d( $new_post_data = array() )
{
    $args = $new_post_data['args'];
    // Map to Actual Metas
    // Get Metadata Fields
    $post_id = $new_post_data['post_id'];
    $final_arr = [
        'ewm_r_review_title'       => sanitize_text_field( $args['ewm_r_review_title'] ),
        'ewm_r_description'        => sanitize_text_field( $args['ewm_r_description'] ),
        'ewm_r_customer_name'      => sanitize_text_field( $args['ewm_r_customer_name'] ),
        'ewm_r_review_date'        => sanitize_text_field( $args['ewm_r_review_date'] ),
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

function ewm_r_process_thumbnail_image( $args = array() )
{
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

function ewm_r_process_gallery_list( $args = array() )
{
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
        __( 'Exclusive worker review', 'exclusive-web-marketing-r-plugin' ),
        __( 'Exclusive worker review', 'exclusive-web-marketing-r-plugin' ),
        'manage_options',
        'ewm-r-child',
        'ewm_r_admin_page_contents',
        'dashicons-format-quote',
        3
    );
}

add_action( 'admin_menu', 'ewm_r_admin_menu' );
function ewm_r_admin_page_contents()
{
    ?>
    <h1> <?php 
    esc_html_e( 'Exclusive Worker Review', 'exclusive-web-marketing-r-plugin' );
    ?> </h1>

    <div class="wrap">

            <hr class="wp-header-end">

            <h2> Introduction </h2>
            
        <?php 
    // setup guidlines
    include dirname( __FILE__ ) . '/vendor/templates/setup_guideline.php';
    // review list
    include dirname( __FILE__ ) . '/vendor/templates/ewm_wr_categories.php';
    ?>
                
        <div id="ajax-response"></div>

        <div class="clear"></div>

    </div>

    <?php 
}

add_action( 'wp_ajax_ewm_r_delete_review_item', 'ewm_r_delete_review_item' );
add_action( 'wp_ajax_nopriv_ewm_r_delete_review_item', 'ewm_r_delete_review_item' );
function ewm_r_delete_review_item()
{
    wp_delete_post( sanitize_text_field( $_POST['ewm_r_post_id'] ), true );
    echo  json_encode( [
        'post_id' => sanitize_text_field( $_POST['ewm_r_post_id'] ),
    ] ) ;
    wp_die();
}

function ewm_wr_process_image_file()
{
    
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
    // echo 'final upload:';
    // var_dump( $movefile );
    // echo 'Initial upload:';
    // var_dump( $uploadedfile );
    // Adds file as attachment to WordPress
    $wp_attachment_id = wp_insert_attachment( $attachment, $file_attr['file'], $post_id );
    $post_id_det = attachment_url_to_postid( $movefile['url'] );
    return $wp_attachment_id;
}

add_action( "wp_ajax_nopriv_ewm_wr_delete_a_worker_review", "ewm_wr_delete_a_worker_review" );
add_action( "wp_ajax_ewm_wr_delete_a_worker_review", "ewm_wr_delete_a_worker_review" );
function ewm_wr_delete_a_worker_review()
{
    $ewm_wr_worker_review_post_id = wp_delete_post( sanitize_text_field( $_POST['ewm_wr_worker_review_post_id'] ) );
    echo  json_encode( [
        'post_deleted' => $ewm_wr_worker_review_post_id,
    ] ) ;
    wp_die();
}

add_action( "wp_ajax_nopriv_ewm_r_add_update_review_details", "ewm_r_add_update_worker_review" );
add_action( "wp_ajax_ewm_r_add_update_review_details", "ewm_r_add_update_worker_review" );
function ewm_r_add_update_worker_review()
{
    $args = $_POST;
    $ewm_wr_image_id = ewm_wr_process_image_file();
    $new_post_data = ewm_r_add_listing_post_data( $args );
    $new_post_data['args'] = $args;
    $new_post_data['args']['ewm_wr_img_file'] = $ewm_wr_image_id;
    ewm_r_add_listing_meta_d( $new_post_data );
    $post_meta_d = get_post_meta( $new_post_data['post_id'] );
    // , 'ewm_r_worker_name' ) ;
    $post_value = get_post( $new_post_data['post_id'] );
    $ewm_wr_img_file = ( array_key_exists( 'ewm_wr_img_file', $post_meta_d ) ? $post_meta_d["ewm_wr_img_file"][0] : 0 );
    $ewm_wr_img_file_url = wp_get_attachment_image_src( $ewm_wr_image_id, 'full' );
    if ( is_array( $ewm_wr_img_file_url ) ) {
        $ewm_wr_img_file_url = $ewm_wr_img_file_url[0];
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
    ] ) ;
    wp_die();
}

function ewm_wr_review_list()
{
    include dirname( __FILE__ ) . '/vendor/templates/ewm_wr_list.php';
}

function ewm_wr_review_form()
{
    include dirname( __FILE__ ) . '/vendor/templates/ewm_wr_form.php';
}

add_shortcode( 'exclusive_worker_review', 'exclusive_worker_review_display' );
function exclusive_worker_review_display()
{
    $final_html = '';
    $final_html .= ewm_wr_review_list();
    if ( is_user_logged_in() ) {
        $final_html .= ewm_wr_review_form();
    }
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

function ewm_wr_rating_aggregrated()
{
    $post_id = get_the_ID();
    $posts = get_posts( array(
        'numberposts' => -1,
        'post_type'   => 'ewm_worker_review',
        'meta_key'    => 'ewm_r_related_page_id',
        'meta_value'  => $post_id,
    ) );
    $review_list = '';
    $bestRating = 0.0;
    $ratingCount = 0;
    $total_rating = 0;
    foreach ( $posts as $post_type => $post_value ) {
        $post_meta_d = get_post_meta( $post_value->ID );
        $review_rating = ( array_key_exists( 'ewm_r_star_rating', $post_meta_d ) ? $post_meta_d["ewm_r_star_rating"][0] : 0 );
        $team_member = ( array_key_exists( 'ewm_r_team_member', $post_meta_d ) ? $post_meta_d["ewm_r_team_member"][0] : '' );
        $review_body = ( array_key_exists( 'ewm_r_description', $post_meta_d ) ? $post_meta_d["ewm_r_description"][0] : '' );
        $total_rating = $total_rating + $review_rating;
        if ( (double) $bestRating < (double) $review_rating ) {
            $bestRating = $review_rating;
        }
        $ratingCount++;
    }
    
    if ( $total_rating > 0 ) {
        $total_rating = $total_rating / $ratingCount;
    } else {
        $total_rating = 0;
    }
    
    return '
    "@type": "AggregateRating",
    "ratingValue": "' . number_format(
        $total_rating,
        2,
        '.',
        ''
    ) . '",
    "bestRating": "' . $bestRating . '",
    "ratingCount": "' . $ratingCount . '"';
}

function ewm_wr_schema_display()
{
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

function ewm_wr_add_edit_cat( $args = array() )
{
    // "ewm_wr_cat_post_id":"12209","ewm_wr_category_f":"cat name","ewm_wr_action_type":"add"}
    // if new create a new category // else edit the cat
    $post_id = $args['ewm_wr_cat_post_id'];
    $meta_key = 'ewm_front_cats';
    $meta_value = $args['ewm_wr_category_f'];
    $meta_arr_box = '';
    
    if ( $args['ewm_wr_action_type'] == 'add' ) {
        $meta_arr_box = add_post_meta(
            $post_id,
            $meta_key,
            $meta_value,
            false
        );
    } else {
        $meta_arr_box = update_post_meta(
            $post_id,
            $meta_key,
            $meta_value,
            $args['ewm_wr_action_type']
        );
    }
    
    return $meta_arr_box;
}

add_action( 'wp_head', 'ewm_wr_schema_display' );
add_action( "wp_ajax_nopriv_ewm_wr_add_edit_category", "ewm_wr_add_edit_category" );
add_action( "wp_ajax_ewm_wr_add_edit_category", "ewm_wr_add_edit_category" );
function ewm_wr_add_edit_category()
{
    ewm_wr_add_edit_cat( $_POST );
    echo  json_encode( $_POST ) ;
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
