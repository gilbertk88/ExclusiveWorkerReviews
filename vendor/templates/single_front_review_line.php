<div class="wr_main_review_body" data-current_review_box="<?php echo $ewm_wr_post_id ; ?>" id="ewm_wr_whold_box_<?php echo $ewm_wr_post_id ; ?>">

	<div class="ewm_wr_top_box_nav">
		<span class="ewm_wr_delete_box" id="ewm_wr_delete_box_<?php echo $ewm_wr_post_id ; ?>" data-current_review_box="<?php echo $ewm_wr_post_id ; ?>">
			Delete
		</span>
	</div>

	<figure>

		<div class="wr_review_body" >
			<div class="wr_picture_area">
				<img src="<?php echo $ewm_wr_img_file_url ; ?>">
			</div>
			<div class="wr_review_area">
				<div class="wr_review_first_line">
					<span class="wr_review_title"><?php echo $review_title; ?></span>
					<span class="wr_review_date"> <?php echo $ewm_r_review_date  ; ?></span>
				</div>
				<div class="wr_location_line">
					<address> <?php echo $address . ' <span style="font-weight: bold; ">' . $city . '</span> ' . $state . ' <span style="font-weight: bold; ">' . $zip . '</span>'; ?> </address>
				</div>
				<div>
					<div class="wr_review_rating_string">
						<div class="wr_review_stars_figure"><?php echo $star_rating ; ?> </div>
						
						<div class="wr_review_stars_d">

							<?php

							$Rating_details = 0;

							if($star_rating !== "") {

								for($i = 1 ; $i <= $star_rating ; $i++) {
									echo  '<span class="fa fa-star checked"></span>';
									$Rating_details++;
								}

								$rating_reminder  = $star_rating - $Rating_details ;

								if($rating_reminder > 0) {

									echo '<span class="fa fa-star-half checked"></span>';
								}
							}
							?>

						</div>

					</div>

				</div>
				
				<div class="wr_final_review_description">
					<blockquote> <?php echo $description ; ?> </blockquote>
				</div>

				<div>
					<div class="wr_customer_detail_main_detail">
						<div class="wr_face_display">
							<i class="fa fa-user-circle"></i>
						</div>
						<div class="wr_review_customer_name">
							<div>
								<figcaption>
									<span style="width:100%;">Review By:</span>
									<span style="width:100%;"><?php echo $customer_name; ?></span>
								</figcaption>
							</div>
						</div>

					</div>

				</div>

			</div>
		</div>

		<div class="wr_review_cat" >
			<h2><?php echo $review_categories; ?></h2>
			<p>
				<blockquote><?php echo $job_description; ?> </blockquote>
			</p>

				<div>
					<div class="wr_customer_detail_main_detail">
						<div class="wr_face_display">
							<i class="fa fa-user-circle"></i>
						</div>
						<div class="wr_review_customer_name">
							<div>
								<figcaption>
									<span style="width:100%;">Job Performed by:</span>
									<span style="width:100%;"><?php echo  $worker_name; ?></span>
								</figcaption>
							</div>
						</div>

					</div>

				</div>
		</div>

	</figure>

</div>

<!--

<tr id="post-<?php echo $woo_c_post_id ;?>" class="iedit author-self level-0 post-<?php echo $woo_c_post_id ;?> type-page status-publish hentry entry woo_c_review_id-<?php echo $woo_c_post_id ;?>">

    <td class="title column-title has-row-actions column-primary page-title" data-colname="Title">
            
        <?php 

        echo 'Worker: <b> <span id="wr_edit_worker_name_'.$ewm_wr_post_id .'">' . $worker_name .' </span> </b> <br> 
        Position: <b><span id="wr_edit_job_description_'.$ewm_wr_post_id .'">'. $job_description . ' </span> </b> <br><br>

        Author - <span id="wr_edit_author_name_'.$$ewm_wr_post_id .'"> ' . $author_name .'</span>';

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
-->