<?php

$post_id = get_the_ID() ;

$posts = get_posts( array(

    'numberposts'   => -1,
    'post_type'     => 'ewm_worker_review',
    'meta_key'      => 'ewm_r_related_page_id',
    'meta_value'    => $post_id

) ) ;

$posts_count = count( $posts );

function ewm_wr_user_can_delete_worker_reviews(){

    $can_delete_or_edit = '' ;
    
    // can edit if the author or is admin

    if( current_user_can('administrator') ) {
        $can_delete_or_edit = 'true';
    }
    else {
        $can_delete_or_edit = 'false';
    }

    return $can_delete_or_edit;
}

?>

<ul class="subsubsub">

</ul>

<br class="clear">

</div>

<h2 class="screen-reader-text">Posts list</h2>

<div class="wp-list-table widefat fixed striped table-view-list posts ewm_r_review_list_container" >

<!-- Add icon library -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

        <script type="text/javascript" >

            var ewm_r_post_date = [] ;

            var post_id = <?php echo $post_id; ?>

            var ewm_wr_user_can_delete_worker_reviews = <?php echo ewm_wr_user_can_delete_worker_reviews(); ?> ;

        </script>
    
        <?php

            $ewm_ratting_list = [] ;

            // echo $posts_count .'<br>';
            // $posts ;
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

                $address            = array_key_exists( 'ewm_r_review_address' , $post_meta_d ) ? $post_meta_d["ewm_r_review_address"][0] : '' ; // "required": 1

				$zip 				= array_key_exists( 'ewm_r_address_zip' , $post_meta_d ) ? $post_meta_d["ewm_r_address_zip"][0] : '' ;

				$date_details 		= array_key_exists( 'ewm_r_review_date' , $post_meta_d ) ? $post_meta_d["ewm_r_review_date"][0] : '' ; 

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

                array_push( $ewm_ratting_list , $star_rating );

                echo '<script type="text/javascript" >

                ewm_r_post_date['. $post_value->ID .'] = {
                    
                    "woo_c_post_id" :       "'. $ewm_wr_post_id .' ",
                    "manager_link" :        " '. $manager_link .' ",
                    "worker_name" :         " '. $worker_name .' " ,
                    "job_description" :     " '. $job_description .' ",
                    "author_name" :         " '. $author_name .' " ,
                    "city" :                " '. $city .' " ,
                    "state" :               " '. $state .' " ,
                    "address" :             " '. $address .' " , 
                    "review_place" :        " '. $review_place .' ",
                    "customer_name" :       " '. $customer_name .' ",
                    "review_title" :        " '. $review_title .' ",
                    "description" :         " '. $description .' ",
                    "star_rating" :         " '. $star_rating .' ",
                    "related_page_id" :     " '. $related_page_id .' ",

                } ;
                
                </script>' ;
                
                include dirname(__FILE__).'/single_front_review_line.php' ;

            }

        ?>

</div>

<?php

$r_rating_total = 0 ;

foreach( $ewm_ratting_list as $r_key => $r_value ){

    $r_rating_total  += $r_value;

}

$wr_rating_average = 0 ; // average number of rating 

$wr_total_number_of_reviews = count( $ewm_ratting_list ) ; // total reviews

if( $r_rating_total > 0 ){

    $wr_rating_average = $r_rating_total/ $wr_total_number_of_reviews;

}

?>

<h4 id="ewm_wr_review_summary">Rated <span id="ewm_wr_review_summary_av" > <?php echo number_format( $wr_rating_average , 2, '.', '')  ; ?></span> out of 5 stars on <?php  echo $wr_total_number_of_reviews; ?> customer review(s)</h4>
