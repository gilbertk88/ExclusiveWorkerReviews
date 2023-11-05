<?php

function ewm_wr_new_city(){

	$_city_id = wp_insert_post( [
		'post_type' => 'gpt_new_city',
		'post_status' => 'active',
		'post_parent' => $_POST['ewm_wr_main_review_page'],
	] );

	$_meta_list = [
		'ewm_r_address_city' => $_POST['ewm_r_address_city'],
		'ewm_r_address_state' => $_POST['ewm_r_address_state'],
		'ewm_r_address_zip' => $_POST['ewm_r_address_zip'],
		'ewm_r_address_country' => $_POST['ewm_r_address_country'],
		'ewm_wr_button_new_city_item' => $_POST['ewm_wr_button_new_city_item'],
	] ;

	foreach( $_meta_list as $k => $v ) {
		add_post_meta( $_city_id ,  $k, $v );
	}

	return $_city_id;

}

function ewm_wr_update_city(){

	$_city_id = $_POST['ewm_wr_button_new_city_item'];

	$_meta_list = [
		'ewm_r_address_city' => $_POST['ewm_r_address_city'],
		'ewm_r_address_state' => $_POST['ewm_r_address_state'],
		'ewm_r_address_zip' => $_POST['ewm_r_address_zip'],
		'ewm_r_address_country' => $_POST['ewm_r_address_country'],
		'ewm_wr_button_new_city_item' => $_POST['ewm_wr_button_new_city_item'],
	];

	foreach( $_meta_list as $k => $v ) {
		update_post_meta( $_city_id ,  $k, $v );
	}

	return $_city_id;

}

add_action( "wp_ajax_nopriv_ewm_rr_populate_city_fields", "ewm_rr_populate_city_fields" );
add_action( "wp_ajax_ewm_rr_populate_city_fields", "ewm_rr_populate_city_fields" );
function ewm_rr_populate_city_fields(){	// $_POST['ewm_rr_city'];

	$ewm_rr_city_meta = get_post_meta( $_POST['ewm_rr_city'] );

	echo json_encode( [
		'ewm_r_address_city' => $ewm_rr_city_meta["ewm_r_address_city"][0],
		'ewm_r_address_state' => $ewm_rr_city_meta["ewm_r_address_state"][0],
		'ewm_r_address_zip' => $ewm_rr_city_meta["ewm_r_address_zip"][0],
		'ewm_r_address_country' => $ewm_rr_city_meta["ewm_r_address_country"][0],
	] );

	wp_die();

}

add_action( "wp_ajax_nopriv_ewm_wr_close_city", "ewm_wr_close_city" );
add_action( "wp_ajax_ewm_wr_close_city", "ewm_wr_close_city" );
function ewm_wr_close_city(){

	$gpt_new_city = get_posts( [
		'post_type' => 'gpt_new_city',
		'post_status' => 'active',
		'posts_per_page' => -1
	] );

	$gpt_city_list = [] ;
	foreach( $gpt_new_city as $k_ => $v_ ){

		array_push( $gpt_city_list, [
			'id' => $v_->ID,
			'name' =>  get_post_meta( $v_->ID, "ewm_r_address_city", true ),
		]);

	}
	$city_before_edit = $_POST['city_before_edit'];

	echo  json_encode( [ // 'post'=> $_POST,
		// 'w_r_post_id' => $w_r_post_id,
		'post' => $_POST,
		'gpt_city_list' => $gpt_city_list,
		'city_before_edit' => $_POST['city_before_edit'],
	] );

	wp_die();

}

add_action( "wp_ajax_nopriv_ewm_wr_save_single_city_ajax", "ewm_wr_save_single_city_ajax" );
add_action( "wp_ajax_ewm_wr_save_single_city_ajax", "ewm_wr_save_single_city_ajax" );
function ewm_wr_save_single_city_ajax(){

	$w_r_post_id = 0; // all pages / single page > // If post does not exist -> create it, else update time on meta
	if ( $_POST['ewm_wr_city_is_new'] == 'is_new' ){
		$w_r_post_id = ewm_wr_new_city();
	}
	else{
		$w_r_post_id = ewm_wr_update_city();
	}

	$ewm_r_address_city = get_post_meta( $w_r_post_id, 'ewm_r_address_city' , true );

	echo  json_encode( [ // 'post'=> $_POST,
		'w_r_post_id' => $w_r_post_id,
		'post' => $_POST,
		'name' => $ewm_r_address_city,
		'ewm_wr_city_is_new' => $_POST['ewm_wr_city_is_new'],
	] );

	wp_die();

}