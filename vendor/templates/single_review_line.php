<tr id="post-<?php echo $woo_c_post_id ;?>" class="iedit author-self level-0 post-<?php echo $woo_c_post_id ;?> type-page status-publish hentry entry woo_c_review_id-<?php echo $woo_c_post_id ;?>">

    <td class="title column-title has-row-actions column-primary page-title" data-colname="Title">
            
        <?php 

        echo 'Worker: <b> <span id="wr_edit_worker_name_'.$woo_c_post_id .'">' . $worker_name .' </span> </b> <br> 
        Position: <b><span id="wr_edit_job_description_'.$woo_c_post_id .'">'. $job_description . ' </span> </b> <br><br>

        Author - <span id="wr_edit_author_name_'.$woo_c_post_id .'"> ' . $author_name .'</span>';

        ?>
    
            
    </td>
    <td scope="col" id="author" class="manage-column column-author">

        <?php

        echo    '<span id="wr_edit_city_'.$woo_c_post_id .'">'. $city . '</span> <br>
                <span id="wr_edit_state_'.$woo_c_post_id .'"> ' . $state . ' </span> <br>
                <span id="wr_edit_address_'.$woo_c_post_id .'"> ' . $address  . '</span> <br>' ;
    
        ?>

    </td>
    <td>

        <?php echo '<span id="wr_edit_review_place_'.$woo_c_post_id .'">'. $review_place .'</span> <br>' ; ?>

    </td>
    <td>

        <?php echo '<span id="wr_edit_customer_name_'.$woo_c_post_id .'">' . $customer_name .'</span> <br>' ; ?>

    </td>
    <td>

        <?php 
        echo    '<b> <span id="wr_edit_review_title_'.$woo_c_post_id .'">'. $review_title .'</span></b><br>
                <span id="wr_edit_descripition_'.$woo_c_post_id .'">'. $description . '</span></br>
                <span id="wr_edit_star_rating_'.$woo_c_post_id .'">' . $star_rating .'</span>'; ?> 

    </td>
    <td>

        <?php echo '<span id="wr_edit_related_page_id_'.$woo_c_post_id .'">'.$related_page_id .'</span>' ; ?>

    </td>
    
</tr>