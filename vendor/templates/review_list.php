<?php

$post_id = get_the_ID();

echo $post_id;

$args = [
    'post_type' => 'ewm_worker_review',
    'numberposts' => 300,
    'post_parent' => $post_id ,
    'fields' => ['ID']
] ;

$get_posts_args = get_posts( $args ) ;

var_dump( $get_posts_args );
$arr_list_args = [];

foreach ( $get_posts_args as $post_type => $post_value ){ 
    // $post_meta_d = get_post_meta( $post_value->ID ) ; // , 'ewm_r_worker_name' ) ;
    $arr_list_args[$post_value->ID] = $post_value->post_author;
}

$get_posts_args_count = count( $get_posts_args );
unset( $get_posts_args );

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

            foreach( $$arr_list_args as $post_k => $post_author_id ){

                $post_value_ID = $post_k ;

                $post_meta_d        = get_post_meta( $post_k  ) ; // , 'ewm_r_worker_name' ) ;
                $woo_c_post_id      = $post_value->ID ;

                $manager_link       = admin_url()."admin.php?page=ewm-r-new&ewm-review-id=" . $post_value->ID ;
                $worker_name        = get_post_meta( $post_value_ID, 'ewm_r_worker_name' , true );
                $job_description    = get_post_meta( $post_value_ID, 'ewm_r_job_description' , true );
                $value_post_author  = get_user_by( 'ID' ,  $post_author_id ) ;
                $author_name        = $value_post_author->user_login ;

                $city               = get_post_meta( $post_value_ID, 'ewm_r_city' , true );
                $state              = get_post_meta( $post_value_ID,'ewm_r_state' , true );
                $address            = get_post_meta( $post_value_ID, 'ewm_r_review_address' , true );
                $review_place       = get_post_meta( $post_value_ID, 'ewm_r_review_place' , true );

                $customer_name      = get_post_meta( $post_value_ID, 'ewm_r_customer_name' , true );
                $review_title       = get_post_meta( $post_value_ID, 'ewm_r_review_title' , true );
                $description        = get_post_meta( $post_value_ID, 'ewm_r_description' , true );
                $star_rating        = get_post_meta( $post_value_ID, 'ewm_r_star_rating' , true );
                $related_page_id    = get_post_meta( $post_value_ID, 'ewm_r_related_page_id' , true );

                $ewm_r_review_date 	= get_post_meta( $post_value_ID, 'ewm_r_review_date' , true );

                echo '<script type="text/javascript" >

                ewm_r_post_date['. $post_value_ID .'] = {
                    
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

    include dirname(__FILE__) . '/pop_up.php' ;
    
?>