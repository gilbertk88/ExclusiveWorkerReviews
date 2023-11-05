<?php

function ewm_add_cat_post(){

    $current_user_id = get_current_user_id() ;

	// create a post and return values
	$post_data = [

        // ["ID"]=> int(1464) 
        "post_author"   	=> $current_user_id ,
        "post_date"    		=> date('Y-m-d H:i:s') ,
        "post_date_gmt" 	=> date('Y-m-d H:i:s') , 
        "post_content"  	=> 'ewm review categories' ,
        "post_title"    	=> 'ewm review categories' ,
        "post_excerpt"  	=> 'ewm review categories' ,
        "post_status"   	=> "publish" ,
        "comment_status"	=> "open" ,
        "ping_status"   	=> "closed" ,
        "post_password" 	=> "" ,
        "post_name"     	=> 'ewm review categories' ,
        "to_ping"       	=> "" ,
        "pinged"        	=> "" ,
        "post_modified" 	=> date('Y-m-d H:i:s') , 
        "post_modified_gmt"	=> date('Y-m-d H:i:s') , 
        "post_content_filtered" => "" ,
        "post_parent"   	=> 0 , 
        "guid"          	=> "" , 
        "menu_order"    	=> 0 ,
        "post_type"     	=> "ewm_wr_category" ,
        "post_mime_type"	=> "" ,
        "comment_count" 	=> "0" ,
        "filter"        	=> "raw" ,

    ] ;

    global $wp_error;

    $post_id = wp_insert_post( $post_data , true ) ;

	add_option( 'ewm_review_categories_list_post_id', $post_id );

	return $post_id; 
	
}

$ewm_review_categories_list_post_id = get_option('ewm_review_categories_list_post_id');

if(!$ewm_review_categories_list_post_id){

	$ewm_review_categories_list_post_id = ewm_add_cat_post();

}

if ( false == get_post_status ( $ewm_review_categories_list_post_id  ) ) {
    
	// recreate 
	$ewm_review_categories_list_post_id = ewm_add_cat_post();

}

$ewm_r_categories_list = get_post_meta( $ewm_review_categories_list_post_id, 'ewm_front_cats');

?>

<script type="text/javascript">

	var ewm_review_categories_list_post_id = <?php echo $ewm_review_categories_list_post_id; ?>

</script>

<div class="ewm_r_main_container_div">

	<input type="button" id="ewm_review_add_cat" value="Add Category">
	<?php
	
	$ewm_cat_id = 1;

    $latest_cat_key_id = ''; 

	foreach( $ewm_r_categories_list as $ewm_single_cat_key => $ewm_single_cat_val ){
		
		include dirname(__FILE__).'/single_front_review_category.php' ;

        $latest_cat_key_id = $ewm_single_cat_key;

		$ewm_cat_id++;

	}

	?>
    <script type="text/javascript">

        var latest_cat_key_id = <?php echo $latest_cat_key_id; ?>
        
    </script>

</div>

<?php include dirname(__FILE__).'/single_popup_review_category.php' ; ?>
