<?php

$post_id = get_the_ID() ;

$args = [

    'post_type'     => 'ewm_worker_review',

    'numberposts'   => 300,

    // 'post__in' => 'post_id',
    
] ;

$get_posts_args = get_posts( $args ) ;

// foreach ( $get_posts_args as $post_type => $post_value ){ 

//    $post_meta_d = get_post_meta( $post_value->ID ) ; // , 'ewm_r_worker_name' ) ;

// }

$get_posts_args_count = count( $get_posts_args );

?>

<h2 class="screen-reader-text">Filter posts list</h2><ul class="subsubsub">

	<li class="all"><a href="edit.php?;post_type=post" class="current" aria-current="page">All <span class="count">( <?php echo $get_posts_args_count; ?> )</span></a> </li>

</ul>

    <br class="clear">

</div>

<h2 class="screen-reader-text">Posts list</h2>

<table class="wp-list-table widefat fixed striped table-view-list posts">

    <thead>

        <tr>
            <th scope="col" id="author" class="manage-column column-author">
                
                Reviewer
                
            </th>
            <th scope="col" id="author" class="manage-column column-author">

                Address

            </th>
            <th scope="col" id="author" class="manage-column column-author">

                Review place

            </th>
            <th scope="col" id="author" class="manage-column column-author">

                Customer name

            </th>
            <th scope="col" id="author" class="manage-column column-author">

                Review details

            </th>
            <th scope="col" id="author" class="manage-column column-author">

                Related reviews

            </th>	
        </tr>

    </thead>

    <tbody id="the-list" class="ewm_r_review_list_container" >

        <script type="text/javascript" >

            var ewm_r_post_date = [] ;

        </script>
    
        <?php

            foreach( $get_posts_args as $post_type => $post_value ){

                $post_meta_d        = get_post_meta( $post_value->ID ) ; // , 'ewm_r_worker_name' ) ;

                $woo_c_post_id      = $post_value->ID ;

                $manager_link       =  admin_url()."admin.php?page=ewm-r-new&ewm-review-id=" . $post_value->ID ;

                $worker_name        = array_key_exists( 'ewm_r_worker_name' , $post_meta_d ) ? $post_meta_d["ewm_r_worker_name"][0] : '' ; // "required": 1

                $job_description    = array_key_exists( 'ewm_r_job_description' , $post_meta_d ) ? $post_meta_d["ewm_r_job_description"][0] : '' ; // "required": 1

                $value_post_author  = get_user_by( 'ID' , $post_value->post_author ) ;

                $author_name        = $value_post_author->user_login ;
                
                $city               = array_key_exists( 'ewm_r_city' , $post_meta_d ) ? $post_meta_d["ewm_r_city"][0] : '' ; // "required": 1

                $state              = array_key_exists( 'ewm_r_state' , $post_meta_d ) ? $post_meta_d["ewm_r_state"][0] : '' ; // "required": 1

                $address            = array_key_exists( 'ewm_r_address' , $post_meta_d ) ? $post_meta_d["ewm_r_address"][0] : '' ; // "required": 1

                $review_place       = array_key_exists( 'ewm_r_review_place' , $post_meta_d ) ? $post_meta_d["ewm_r_review_place"][0] : '' ;
                // "required": 0 / "type": "image"/ "return_format": "id" / "preview_size": "thumbnail" / "library": "uploadedTo" / "min_width": "" / 
                // "min_height": "" / "min_size": "" / "max_width": 500 / "max_height": "" / "max_size": "" / "mime_types": ""

                $customer_name      = array_key_exists( 'ewm_r_customer_name' , $post_meta_d ) ? $post_meta_d["ewm_r_customer_name"][0] : '' ; // "required": 1

                $review_title       = array_key_exists( 'ewm_r_review_title' , $post_meta_d ) ? $post_meta_d["ewm_r_review_title"][0] : '' ; // "instructions": "Put a suitable title for your review" / "required": 1 / $value->post_title ;

                $description        = array_key_exists( 'ewm_r_description' , $post_meta_d ) ? $post_meta_d["ewm_r_description"][0] : '' ; // "required": 1

                $star_rating        = array_key_exists( 'ewm_r_star_rating' , $post_meta_d ) ? $post_meta_d["ewm_r_star_rating"][0] : '' ; // "required": 1

                $related_page_id    = array_key_exists( 'ewm_r_related_page_id' , $post_meta_d ) ? $post_meta_d["ewm_r_related_page_id"][0] : '' ; // "required": 0

                echo '<script type="text/javascript" >

                ewm_r_post_date['. $post_value->ID .'] = {
                    
                    "woo_c_post_id" :       "'. $woo_c_post_id .' ",
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
                
                include dirname(__FILE__).'/single_review_line.php' ;

            }

        ?>

	</tbody>

</table>

<?php 

    // include dirname(__FILE__) . '/pop_up.php' ;

?>
