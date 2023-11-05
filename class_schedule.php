<?php

// Process schedule
function gpt_process_single_schedule( $args = [] ) {

    $gpt_schedule_id = $args['schedule_id'] ;
    $gpt_main_review_id = $args['main_review_id'] ;
    $gpt_schedule = [
        'group_parent_id' => get_post_meta( $gpt_schedule_id, 'group_parent_id' ),
        'ewm_wr_gpt_review_title' => get_post_meta( $gpt_schedule_id, 'ewm_wr_gpt_review_title' ),
        'ewm_wr_gpt_customer_name' => get_post_meta( $gpt_schedule_id, 'ewm_wr_gpt_customer_name' ),
        'ewm_wr_gpt_rating' => get_post_meta( $gpt_schedule_id, 'ewm_wr_gpt_rating') ,
        'ewm_wr_gpt_address' => get_post_meta( $gpt_schedule_id, 'ewm_wr_gpt_address'), //
        'ewm_wr_gpt_category' => get_post_meta( $gpt_schedule_id, 'ewm_wr_gpt_category'), //
        'ewm_wr_gpt_job_description' => get_post_meta( $gpt_schedule_id, 'ewm_wr_gpt_job_description' ),
        'ewm_wr_gpt_team_member' => get_post_meta( $gpt_schedule_id, 'ewm_wr_gpt_team_member' ),
    ] ;

    $gpt_keyword = $gpt_schedule['ewm_wr_gpt_review_title'][0] ; // $args['keyword']; // get text
    $ewm_txt = ewm_access_chatgpt( ['ewm_keyword' => $gpt_keyword ] ) ;

    $gpt_new_citys = get_posts( [
        'post_type' => 'gpt_new_city',
        'post_status' => 'active',
        'post_parent' => $gpt_main_review_id,
    ] ) ;

    if( count( $gpt_new_citys ) > 0 ) {
        $gpt_new_citys_d = get_post_meta( $gpt_new_citys[0]->ID ); // import img /*[ 'id' =>  $gpt_img_detail, 'url' => $gpt_img_detail_url ] */
        $ewm_r_address_country = $gpt_new_citys_d[ 'ewm_r_address_country' ][0] ;
        $ewm_r_address_city = $gpt_new_citys_d[ 'ewm_r_address_city' ][0] ;
        $ewm_r_address_state = $gpt_new_citys_d[ 'ewm_r_address_state' ][0] ;
        $ewm_r_address_zip = $gpt_new_citys_d[ 'ewm_r_address_zip' ][0] ;
        // 'ewm_r_review_place'    = $gpt_new_citys_d[ 'ewm_r_address_zip' ][0];
    }
    else{
        $ewm_r_address_country = '' ;
        $ewm_r_address_city = '' ;
        $ewm_r_address_state = '' ;
        $ewm_r_address_zip = '' ;
    }

    $ewm_date = date( 'Y-m-d H:i:s' );
    $add_long = $ewm_r_address_city.', '.$ewm_r_address_state.', '.$ewm_r_address_country;

    if( !is_string($add_long) ){
        $add_long = 'Address not set';
    }

    $tt_data = [
        'ewm_r_review_title'    => $gpt_keyword,
        'ewm_r_worker_name'     => $gpt_schedule['ewm_wr_gpt_team_member'][0],
        'ewm_r_job_description' => $gpt_schedule['ewm_wr_gpt_job_description'][0],
        'ewm_r_value_post_author' => 1,
        'ewm_r_post_id'         => 0,
        'ewm_r_address_country' => $ewm_r_address_country,
        'ewm_r_city'            => $ewm_r_address_city,
        'ewm_r_state'           => $ewm_r_address_state,
        'ewm_r_address'         => $ewm_r_address_zip,
        'ewm_r_review_place'    => $ewm_r_address_zip,
        'ewm_r_customer_name'   => $gpt_schedule['ewm_wr_gpt_customer_name'][0],
        'ewm_r_description'     => $ewm_txt,
        'ewm_r_star_rating'     => $gpt_schedule['ewm_wr_gpt_rating'][0],
        'ewm_r_related_page_id' => $gpt_main_review_id, // 'ewm_r_post_id'         => $gpt_main_review_id,
        'ewm_r_review_submit'   => '',
        'group_parent_id'       => $gpt_schedule['group_parent_id'][0],
        "ewm_r_review_address" => $add_long,
        "ewm_r_street_address" => $add_long,
        "ewm_r_address_city" => $ewm_r_address_city,
        "ewm_r_address_state" => $ewm_r_address_state,
        "ewm_r_address_zip" => $ewm_r_address_zip,
        "ewm_r_team_member" => $gpt_schedule['ewm_wr_gpt_customer_name'][0],
        "ewm_wr_category_dropdown" => $gpt_schedule['ewm_wr_gpt_category'],
        "post_is_new" => '',
        'ewm_r_review_date' => $ewm_date
    ] ;

    $args = gpt_r_add_listing_post_data( $tt_data ) ;

    // $new_post_data['args'] = $args;
    $new_post_data['args'] = $tt_data ;

    // manage process.
    $ewm_img = ewm_access_image_chat( ['ewm_keyword' => $gpt_keyword,  'ewm_p_id' => $args['post_id'] ] ) ;
    $ewm_wr_image_id = $ewm_img['id'] ;

    $new_post_data['args']['ewm_wr_img_file'] = $ewm_wr_image_id ;
    //_POST
    $new_post_data['post_id'] =  $args['post_id'] ;
    $new_post_data['post_is_new'] = true ;
    
    // var_dump( $new_post_data );
    gpt_r_add_listing_meta_d( $new_post_data ); // var_dump( $ewm_wr_image_id ); // var_dump( $tt_data );
    // if( daily ) -> replace with another schedule // else delete.

}

function ewm_is_daily_reschedule( $args = [] ) {

    $args['group_parent_id'];
    $args['group_id'];
    $args['is_daily'];
    $args['ewm_wr_gpt_review_title'];
    $args['ewm_wr_gpt_customer_name'];
    $args['ewm_wr_gpt_rating'];
    $args['ewm_wr_gpt_address'];
    $args['ewm_wr_gpt_category'];
    $args['ewm_wr_gpt_job_description'];
    $args['ewm_wr_gpt_team_member'];
    $args['ewm_wr_gpt_nextfire'];
    $args['instant'];
    $args['ewm_r_description'];

}

function ewm_get_city_details_based_on( $args = [] ){

    $gpt_new_city = get_posts( [
		'post_type' => 'gpt_new_city',
		'post_status' => 'active',
		'post_parent' => $args['ewm_wr_main_review_page'],
        'fields' => 'ids'
	] );

    $gpt_new_city_arr = [];

    if( count( $gpt_new_city ) == 0 ) {
        
        $gpt_new_city_arr['id'] = 0 ;
        $gpt_new_city_arr['ewm_r_address_city'] = '-- ';
		$gpt_new_city_arr['ewm_r_address_state'] = '-- ';
		$gpt_new_city_arr['ewm_r_address_zip'] = '-- ';
		$gpt_new_city_arr['ewm_r_address_country'] = '-- ';
		$gpt_new_city_arr['ewm_wr_button_new_city_item'] = '-- ';
        $gpt_new_city_arr['ewm_r_review_place'] = '-- ';

    }
    else {

        $gpt_new_city_arr['id'] = $gpt_new_city['0'];
        $gpt_new_city_arr['ewm_r_address_city'] = get_post_meta( $gpt_new_city['0'], 'ewm_r_address_city', true );
		$gpt_new_city_arr['ewm_r_address_state'] = get_post_meta( $gpt_new_city['0'], 'ewm_r_address_state', true );
		$gpt_new_city_arr['ewm_r_address_zip'] = get_post_meta( $gpt_new_city['0'], 'ewm_r_address_zip', true );
		$gpt_new_city_arr['ewm_r_address_country'] = get_post_meta( $gpt_new_city['0'], 'ewm_r_address_country', true );
		$gpt_new_city_arr['ewm_wr_button_new_city_item'] = get_post_meta( $gpt_new_city['0'], 'ewm_wr_button_new_city_item', true );
        $gpt_new_city_arr['ewm_r_street_address'] = get_post_meta( $gpt_new_city['0'], 'ewm_wr_button_new_city_item', true );
        $gpt_new_city_arr['ewm_r_review_place'] = get_post_meta( $gpt_new_city['0'], 'ewm_r_review_place', true );

        // string details
        $gpt_new_city_arr['id'] = ( is_string( $gpt_new_city_arr['id'] ) && strlen( $gpt_new_city_arr['id'] ) > 0 ) ? $gpt_new_city_arr['id'] : '-- ' ;
        $gpt_new_city_arr['ewm_r_review_place'] =  ( is_string( $gpt_new_city_arr['ewm_r_review_place'] ) && strlen( $gpt_new_city_arr['ewm_r_review_place'] ) > 0 ) ? $gpt_new_city_arr['ewm_r_review_place'] : '-- ' ;
        $gpt_new_city_arr['ewm_r_address_city'] = ( is_string( $gpt_new_city_arr['ewm_r_address_city'] ) && strlen( $gpt_new_city_arr['ewm_r_address_city'] ) > 0 ) ? $gpt_new_city_arr['ewm_r_address_city'] : ' -- ' ;
		$gpt_new_city_arr['ewm_r_address_state'] = ( is_string( $gpt_new_city_arr['ewm_r_address_state'] ) && strlen( $gpt_new_city_arr['ewm_r_address_state'] ) > 0 ) ? $gpt_new_city_arr['ewm_r_address_state'] : ' -- ' ;
		$gpt_new_city_arr['ewm_r_address_zip'] = ( is_string( $gpt_new_city_arr['ewm_r_address_zip'] ) && strlen( $gpt_new_city_arr['ewm_r_address_zip'] ) > 0 ) ? $gpt_new_city_arr['ewm_r_address_zip'] : ' -- ' ;
		$gpt_new_city_arr['ewm_r_address_country'] = ( is_string( $gpt_new_city_arr['ewm_r_address_country'] ) && strlen( $gpt_new_city_arr['ewm_r_address_country'] ) > 0 ) ? $gpt_new_city_arr['ewm_r_address_country'] : ' -- ' ;
		$gpt_new_city_arr['ewm_wr_button_new_city_item'] = ( is_string( $gpt_new_city_arr['ewm_wr_button_new_city_item'] ) && strlen( $gpt_new_city_arr['ewm_wr_button_new_city_item'] ) > 0 ) ? $gpt_new_city_arr['ewm_wr_button_new_city_item'] : ' -- ';
        $gpt_new_city_arr['ewm_r_street_address'] = ( is_string( $gpt_new_city_arr['ewm_r_street_address'] ) && strlen( $gpt_new_city_arr['ewm_r_street_address'] ) > 0 ) ? $gpt_new_city_arr['ewm_r_street_address'] : ' -- ';

    }

    return $gpt_new_city_arr;

}

function ewm_add_gpt_worker_review( $args_schedule = [] ){

    $group_parent_id = get_post_meta( $args_schedule['id'], 'group_parent_id' , true );
    $group_id = get_post_meta( $args_schedule['id'], 'group_id', true );
    $is_daily = get_post_meta( $args_schedule['id'], 'is_daily', true );
    $ewm_wr_gpt_review_title = get_post_meta( $args_schedule['id'], 'ewm_wr_gpt_review_title' , true );
    $ewm_wr_gpt_customer_name = get_post_meta( $args_schedule['id'], 'ewm_wr_gpt_customer_name', true );
    $ewm_wr_gpt_rating = get_post_meta( $args_schedule['id'], 'ewm_wr_gpt_rating', true );
    $ewm_wr_gpt_address = get_post_meta( $args_schedule['id'], 'ewm_wr_gpt_address' , true );
    $ewm_wr_gpt_category = get_post_meta( $args_schedule['id'], 'ewm_wr_gpt_category' , true );
    $ewm_wr_gpt_job_description = get_post_meta( $args_schedule['id'], 'ewm_wr_gpt_job_description', true );
    $ewm_wr_gpt_team_member = get_post_meta( $args_schedule['id'], 'ewm_wr_gpt_team_member', true );
    $ewm_wr_gpt_nextfire = get_post_meta( $args_schedule['id'], 'ewm_wrgpt_nextfire' , true );
    $instant = get_post_meta( $args_schedule['id'], 'ewm_wr_chatgpt_instant' , true );
    $ewm_r_description = ewm_access_chatgpt( ['ewm_keyword' => $ewm_wr_gpt_review_title ] );

    /*
    $ewm_get_city_det[ 'ewm_r_review_place' ];
    $ewm_get_city_det[ 'ewm_r_address_city' ];
    $ewm_get_city_det[ 'ewm_r_street_address' ];
    $ewm_get_city_det[ 'ewm_r_address_state' ];
    $ewm_get_city_det[ 'ewm_r_address_zip' ];
    $ewm_get_city_det[ 'ewm_r_address_country' ];
    */

    $ewm_get_city_det = ewm_get_city_details_based_on( [
        'ewm_wr_main_review_page' => $group_parent_id
    ] );

    $keyword =  $ewm_wr_gpt_review_title;

    // todo -> image
    $ewm_wr_image_d = ewm_access_image_chat( [
        'ewm_keyword' => $keyword
    ] );

    $ewm_wr_image_id = $ewm_wr_image_d['id'] ;
    $ewm_wr_img_file = $ewm_wr_image_id;
    
    $args = [
        'ewm_r_review_title'    => $ewm_wr_gpt_review_title,
        'ewm_r_description'     => $ewm_r_description,
        'ewm_r_customer_name'   => $ewm_wr_gpt_customer_name,
        'ewm_r_review_date'     => date( 'Y-m-d H:i:s' ),
        'ewm_r_star_rating'     => $ewm_wr_gpt_rating,
        'ewm_r_review_place'    => $ewm_get_city_det[ 'ewm_r_review_place' ],
        'ewm_r_address'         => $ewm_wr_gpt_address, // form_data.append( 'ewm_r_street_address' , $('#gpt_ewm_r_street_address').val() ); // gpt_ewm_r_street_address
        'ewm_r_address_city'    => $ewm_get_city_det[ 'ewm_r_address_city' ],
        'ewm_r_street_address'  => $ewm_get_city_det[ 'ewm_r_street_address' ],
        'ewm_r_address_state'   => $ewm_get_city_det[ 'ewm_r_address_state' ],
        'ewm_r_address_zip'     => $ewm_get_city_det[ 'ewm_r_address_zip' ],
        'ewm_r_address_country' => $ewm_get_city_det[ 'ewm_r_address_country' ],
        'ewm_r_job_description' => $ewm_wr_gpt_job_description ,
        'ewm_r_team_member'     => $ewm_wr_gpt_team_member,
        'ewm_wr_category_dropdown' => $ewm_wr_gpt_category,
        'ewm_r_related_page_id' => $group_parent_id,
        'ewm_r_post_id'         => $group_parent_id,
        'ewm_wr_img_file'       => $ewm_wr_image_d['id'],
        'post_is_new'           => true,

    ] ;

    // get meta values
    // $ewm_meta_d = get_post_meta( $args_schedule['id'] );
    
    // ewm_wr_process_image_file( $args );
    $ewm_wr_image_id = $ewm_wr_image_d['id'];

    $args['ewm_r_post_id'] = 0 ;
    $new_post_data = ewm_r_add_listing_post_data( $args );
    $new_post_data['args'] = $args;
    $new_post_data['args']['ewm_wr_img_file'] = $ewm_wr_image_id;

    ewm_r_add_listing_meta_d( $new_post_data );

    $post_meta_d = get_post_meta( $new_post_data[ 'post_id' ] ); // , 'ewm_r_worker_name' );
    $post_value = get_post( $new_post_data['post_id'] );
    $ewm_wr_img_file = ( array_key_exists( 'ewm_wr_img_file', $post_meta_d ) ? $post_meta_d["ewm_wr_img_file"][0] : 0 ) ;
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
    ] ;

    $woo_c_post_id = $new_post_data['post_id'];
    $manager_link = admin_url() . "admin.php?page=ewm-r-new&ewm-review-id=" . $new_post_data['post_id'];
    $value_post_author = get_user_by( 'ID', $post_value->post_author );
    $author_name = ''; //$value_post_author->user_login;

    $ewm_r_review_details = [
        'woo_c_post_id' => $woo_c_post_id,
        'manager_link'  => $manager_link,
        'author_name'   => $author_name,
        'data'          => $data_details,
    ] ;

    if( $is_daily  == 'true' ){

        ewm_is_daily_reschedule( [
            'group_parent_id' => $group_parent_id, // = get_post_meta( $args_schedule['id'], 'group_parent_id' , true );
            'group_id' => $group_id,// = get_post_meta( $args_schedule['id'], 'group_id', true );
            'is_daily' => $is_daily, //= get_post_meta( $args_schedule['id'], 'is_daily', true );
            'ewm_wr_gpt_review_title' => $ewm_wr_gpt_review_title, // = get_post_meta( $args_schedule['id'], 'ewm_wr_gpt_review_title' , true );
            'ewm_wr_gpt_customer_name' => $ewm_wr_gpt_customer_name, // = get_post_meta( $args_schedule['id'], 'ewm_wr_gpt_customer_name', true );
            'ewm_wr_gpt_rating'=> $ewm_wr_gpt_rating,// = get_post_meta( $args_schedule['id'], 'ewm_wr_gpt_rating', true );
            'ewm_wr_gpt_address' => $ewm_wr_gpt_address,// = get_post_meta( $args_schedule['id'], 'ewm_wr_gpt_address' , true );
            'ewm_wr_gpt_category' => $ewm_wr_gpt_category,// = get_post_meta( $args_schedule['id'], 'ewm_wr_gpt_category' , true );
            'ewm_wr_gpt_job_description' => $ewm_wr_gpt_job_description,// = get_post_meta( $args_schedule['id'], 'ewm_wr_gpt_job_description', true );
            'ewm_wr_gpt_team_member'=>$ewm_wr_gpt_team_member, // = get_post_meta( $args_schedule['id'], 'ewm_wr_gpt_team_member', true );
            'ewm_wr_gpt_nextfire'=>$ewm_wr_gpt_nextfire,// = get_post_meta( $args_schedule['id'], 'ewm_wrgpt_nextfire' , true );
            'instant' => $instant, // = get_post_meta( $args_schedule['id'], 'ewm_wr_chatgpt_instant' , true );
            'ewm_r_description' => $ewm_r_description, // = ewm_access_chatgpt( ['ewm_keyword' => $ewm_wr_gpt_review_title ] );
        ] );

    }

    add_post_meta( $args_schedule['id'], 'ewm_been_scheduled', 'true' );

    return [
        "update_successful" => true,
        "post_id"           => $new_post_data["post_id"],
        "post_is_new"       => $new_post_data["post_is_new"],
        "details"           => $ewm_r_review_details,
        "post_meta_d"       => $post_meta_d,
        'post'              => $_POST,
        'data_details'      => $data_details
    ] ;

}

function ewm_process_single_schedule( $args = [] ){

    // populate review
    ewm_add_gpt_worker_review( $args );

    // if daily reschedule => check form main review
    $ewm_wr_group_parent_id = get_post_meta( $args['id'], 'group_parent_id', true );
    $ewm_wr_chatgpt_daily = get_post_meta( $ewm_wr_group_parent_id, 'ewm_wr_chatgpt_daily', true );

    if( $ewm_wr_chatgpt_daily == 'true' ){

        $args_id = $args['id'];
        $instant = 'true';
        $post_id = $ewm_wr_group_parent_id;

        ewm_wr_daily_update_single_schedule( $args_id, $instant, $post_id );

    }

    // Delete schedule
    wp_delete_post( $args['id'] );

}

function ewm_delete_ending_schedules(){

    $wrgpt_schedule = get_posts( [
        'post_type' => 'wrgpt_schedule',
        'post_status' => 'active', // 'post_parent' => $review_main_post , // main review page post
        'meta_query' => array(
            array(
                'key'     => 'ewm_been_scheduled',
                'value'   => 'true', //'2695032824',
                'compare' => '==', // 'type' => 'DATETIME',
            ),
        ),
        'posts_per_page'=> 2,
        'fields' => 'ids'
    ] );

    foreach( $wrgpt_schedule as $wrgpt_schedule_k => $wrgpt_schedule_v ){
        wp_delete_post(  $wrgpt_schedule_v, 'true' );
    }

}

add_action( 'wp_ajax_gpt_run_outstanding_schedule', 'gpt_run_outstanding_schedule' );
add_action( 'wp_ajax_nopriv_gpt_run_outstanding_schedule', 'gpt_run_outstanding_schedule' );
function gpt_run_outstanding_schedule(){ // $review_main_post = 224;

    ewm_delete_ending_schedules();
    $ewm_time = time();

    $wrgpt_schedule = get_posts( [

        'post_type' => 'wrgpt_schedule',
        'post_status' => 'active', // 'post_parent' => $review_main_post , // main review page post
        'meta_query' => array(
            array(
                'key'     => 'ewm_wrgpt_nextfire',
                'value'   => $ewm_time, //'2695032824',
                'compare' => '<=', // 'type' => 'DATETIME',
            ),
        ),
        'posts_per_page'=> 1,
        'fields' => 'ids'

    ] );

    $count_wrgpt_schedule = count( $wrgpt_schedule );
    echo $count_wrgpt_schedule;

    foreach( $wrgpt_schedule as $wrgpt_schedule_k => $wrgpt_schedule_v ){
        // var_dump( $wrgpt_schedule_v ); // var_dump( get_post_meta( $wrgpt_schedule_v ) ); // echo '<br><br><br>'; 
        // var_dump( wp_delete_post( $wrgpt_schedule_v->ID ) ); // var_dump( $wrgpt_schedule_v ); // var_dump( get_post_meta( $wrgpt_schedule_v->ID ) );
        ewm_process_single_schedule( [
            'id' => $wrgpt_schedule_v
        ] );
        // echo '<br><br>';
        
    }

    /*
        if( $count_wrgpt_schedule > 0 ) {
            $wrg_v = $wrgpt_schedule[0]; // var_dump($wrg_v);
            gpt_process_single_schedule( [
                'schedule_id' => $wrg_v->ID,
                'main_review_id' => '4707' // $wrg_v->post_parent,
            ] );
        }
    */

}

// Create schedule for single group item
function ewm_wr_daily_update_single_schedule( $args_id, $instant, $post_id ){

    $v = get_post( $args_id );
    $group_item_id = $v->ID;
    $group_id = $args_id;
    $_gen_d = get_post_meta( $group_item_id ); // $args['gpt_review_post_id']  // $args['group_parent_id']
    $group_parent_id = $post_id ; // $_gen_d['group_parent_id'][0]; // $group_id = $post_id $args['gpt_review_post_id'];
    $ewm_wr_gpt_review_title = $_gen_d['ewm_wr_gpt_review_title'][0];
    $ewm_wr_gpt_customer_name = $_gen_d['ewm_wr_gpt_customer_name'][0];
    $ewm_wr_gpt_rating = $_gen_d['ewm_wr_gpt_rating'][0];
    $ewm_wr_gpt_address = $_gen_d['ewm_wr_gpt_address'][0];
    $ewm_wr_gpt_category = $_gen_d['ewm_wr_gpt_category'][0];
    $ewm_wr_gpt_job_description = $_gen_d['ewm_wr_gpt_job_description'][0];
    $ewm_wr_gpt_team_member = $_gen_d['ewm_wr_gpt_team_member'][0];
    $is_daily = $instant; // ['ewm_wr_chatgpt_instant'] ;
    $ewm_wr_gpt_nextfire = time();
    $ewm_wr_gpt_nextfire_add = 60*60*24;
    $ewm_wr_gpt_nextfire = $ewm_wr_gpt_nextfire + $ewm_wr_gpt_nextfire_add ;

    $new_post_list_meta = [
        'group_parent_id' => $group_parent_id,
        'group_id' => $group_id, // '' => $args_id,
        'is_daily' => $is_daily,
        'ewm_wr_gpt_review_title' => $ewm_wr_gpt_review_title,
        'ewm_wr_gpt_customer_name' => $ewm_wr_gpt_customer_name,
        'ewm_wr_gpt_rating' => $ewm_wr_gpt_rating,
        'ewm_wr_gpt_address' => $ewm_wr_gpt_address,
        'ewm_wr_gpt_category' => $ewm_wr_gpt_category,
        'ewm_wr_gpt_job_description' => $ewm_wr_gpt_job_description,
        'ewm_wr_gpt_team_member' => $ewm_wr_gpt_team_member,
        'ewm_wrgpt_nextfire' => $ewm_wr_gpt_nextfire ,
        'ewm_wr_chatgpt_instant' => $instant,
    ];

    $arg_gen_id = wp_insert_post( [
        'post_type' => 'wrgpt_schedule',
        'post_status' => 'active',
        'post_parent' => $args_id // $post_id // $args[ 'gen_main_post' ], // main review page post
    ] );

    foreach( $new_post_list_meta as $key_top => $value_top ) {
        add_post_meta( $arg_gen_id, $key_top, $value_top ) ;
    }

}

// Create schedule for single group item
function ewm_wr_update_single_schedule( $args_id, $instant, $post_id ){

    $v = get_post( $args_id );
    $group_item_id = $v->ID;
    $group_id = $args_id;
    $_gen_d = get_post_meta( $group_item_id ); // $args['gpt_review_post_id']  // $args['group_parent_id']
    $group_parent_id = $post_id ; // $_gen_d['group_parent_id'][0]; // $group_id = $post_id $args['gpt_review_post_id'];
    $ewm_wr_gpt_review_title = $_gen_d['ewm_wr_gpt_review_title'][0];
    $ewm_wr_gpt_customer_name = $_gen_d['ewm_wr_gpt_customer_name'][0];
    $ewm_wr_gpt_rating = $_gen_d['ewm_wr_gpt_rating'][0];
    $ewm_wr_gpt_address = $_gen_d['ewm_wr_gpt_address'][0];
    $ewm_wr_gpt_category = $_gen_d['ewm_wr_gpt_category'][0];
    $ewm_wr_gpt_job_description = $_gen_d['ewm_wr_gpt_job_description'][0];
    $ewm_wr_gpt_team_member = $_gen_d['ewm_wr_gpt_team_member'][0];
    $is_daily = $instant; // ['ewm_wr_chatgpt_instant'] ;
    $ewm_wr_gpt_nextfire = time();
    // $ewm_wr_gpt_nextfire_add = 60*60*24;
    // $ewm_wr_gpt_nextfire = $ewm_wr_gpt_nextfire + $ewm_wr_gpt_nextfire_add ;

    $new_post_list_meta = [
        'group_parent_id' => $group_parent_id,
        'group_id' => $group_id,
        'is_daily' => $is_daily,
        'ewm_wr_gpt_review_title' => $ewm_wr_gpt_review_title,
        'ewm_wr_gpt_customer_name' => $ewm_wr_gpt_customer_name,
        'ewm_wr_gpt_rating' => $ewm_wr_gpt_rating,
        'ewm_wr_gpt_address' => $ewm_wr_gpt_address,
        'ewm_wr_gpt_category' => $ewm_wr_gpt_category,
        'ewm_wr_gpt_job_description' => $ewm_wr_gpt_job_description,
        'ewm_wr_gpt_team_member' => $ewm_wr_gpt_team_member,
        'ewm_wrgpt_nextfire' => $ewm_wr_gpt_nextfire ,
        'ewm_wr_chatgpt_instant' => $instant,
    ] ;

    $arg_gen_id = wp_insert_post( [
        'post_type' => 'wrgpt_schedule',
        'post_status' => 'active',
        'post_parent' => $args_id // $post_id // $args[ 'gen_main_post' ], // main review page post
    ] ) ;

    foreach( $new_post_list_meta as $key_top => $value_top ) {
        add_post_meta( $arg_gen_id, $key_top, $value_top ) ;
    }

}

// =============== Create schedule ====================================
function gpt_schedule_single_listing( $args = [] ){

    $$gen_post_id = $args['gen_post_id'] ;

    $single_data_post = [
        'post_parent' => $gen_post_id,
        'post_type' => 'ewmgpt_schedule',
    ] ;

    $_schedule_post_id = wp_insert_post( $single_data_post ) ;

    $single_data_meta = [
        'ewm_wr_chatgpt_daily' => get_post_meta( $gen_post_id ,'ewm_wr_chatgpt_daily', true ), // add_post_meta(  $_post_id, 'ewm_wr_chatgpt_number_of_reviews',  $_POST['ewm_wr_chatgpt_number_of_reviews'] , false );
        'ewm_wrchatgpt_page_id' =>  get_post_meta( $gen_post_id , 'ewm_wrchatgpt_page_id' , true ),
        'ewm_wrchatgpt_group_list' =>  get_post_meta( $gen_post_id , 'ewm_wrchatgpt_group_list' , true ),
        'ewm_wr_chatgpt_instant' => get_post_meta( $gen_post_id , 'ewm_wr_chatgpt_instant' , true ),
    ] ;

    foreach( $single_data_meta as $key => $value ){
        add_post_meta(  $_schedule_post_id, $key  , $value , false ); // add_post_meta(  $_post_id, 'ewm_wr_chatgpt_number_of_reviews',  $_POST['ewm_wr_chatgpt_number_of_reviews'] , false );
    }

}

function ewm_wr_chatgpt_schedule_search_post( $search_group_id = '' ){ // schedule single review

    // get search post group list
    $ewm_wrchatgpt_group_list = get_post_meta( $search_group_id, 'ewm_wrchatgpt_group_list', true );

    // get single item
    $ewm_wrchatgpt_group_arr = explode( ",", $ewm_wrchatgpt_group_list );

    foreach( $ewm_wrchatgpt_group_arr as $single_group ){

        // $single_group
        $single_group_item_list = get_posts( [
            'post_parent' => $single_group,
            'post_type' => 'wr_gpt_group',
            'posts_per_page' => -1
        ] );

        // get item list
        foreach( $single_group_item_list as $single_item ){

            $wr_gpt_schedule_item = wp_insert_post( [
                'post_type' => 'wrgpt_schedule',
                'post_status' => 'pending',
            ] );

            // $wr_gpt_schedule_item
            $meta_list = [
                'ewm_wrchatgpt_page_id' => $search_group_id,
                'ewm_wr_gpt_review_title' => get_post_meta( $search_group_id, 'ewm_wr_gpt_review_title', true ),
                'ewm_wr_gpt_customer_name' =>  get_post_meta( $search_group_id, 'ewm_wr_gpt_customer_name', true ),
                'ewm_wr_gpt_rating' =>  get_post_meta( $search_group_id, 'ewm_wr_gpt_rating', true ),
                'ewm_wr_gpt_address' =>  get_post_meta( $search_group_id, 'ewm_wr_gpt_address', true ),
                'ewm_wr_gpt_category' =>  get_post_meta( $search_group_id, 'ewm_wr_gpt_category', true ),
                'ewm_wr_gpt_job_description' =>  get_post_meta( $search_group_id, 'ewm_wr_gpt_job_description', true ),
                'ewm_wr_gpt_team_member' =>  get_post_meta( $search_group_id, 'ewm_wr_gpt_team_member', true ),
            ];

            foreach( $meta_list as $key => $val ){
                add_post_meta( $wr_gpt_schedule_item,  $key, $val );
            }

        }
        // create an import post for each item list
        // create an an auto initialize function

    }

}

add_action( 'wp_ajax_nopriv_ewm_wr_input_api_key_save', 'ewm_wr_input_api_key_save' );
add_action( 'wp_ajax_ewm_wr_input_api_key_save', 'ewm_wr_input_api_key_save' );

// =============== GPT key API =========================================
function ewm_wr_input_api_key_save(){

    $ewm_gpt_api_key = get_option( 'ewm_gpt_api_key' );

    if( $ewm_gpt_api_key == false ){
        $ewm_gpt_api_key = add_option( 'ewm_gpt_api_key', $_POST['ewm_key'] );
    }
    else{
        $ewm_gpt_api_key = update_option( 'ewm_gpt_api_key' , $_POST['ewm_key'] );
    }

    echo json_encode( [
        'ewm_gpt_api_key' => $ewm_gpt_api_key,
        'post' => $_POST
    ] );
    
    wp_die();

}

function gpt_log_update_schedule( $args = [] ) {

    foreach( $args as $key => $val ) {
        // var_dump( get_post_meta( $val->ID, 'ewm_event_time' ) );
        $ewm_event_time = current_time( 'timestamp' );
        update_post_meta( $val->ID, 'ewm_event_time', $ewm_event_time );
    }

}

?>