<style>
	.ewm_wrchatgpt_background_main {
		width: 100%;
		height: 100%;
		background-color: #33333350;
		position: fixed;
		left: 0px;
		top: 0px;
		padding-left: 20%;
		display: none;
		z-index: 1000000;
	}

	.ewm_wrchatgpt_background_inner {
		width: 80%;
		background-color: #fff !important;
		float: right;
		position: fixed;
		right: 0px;
		top: 0px;
		padding-top: 30px;
		height: 100%;
		padding-left: 20px;
		box-shadow: 0 5px 8px 0 rgb(151 151 151 / 10%), 0 6px 10px 0 rgb(118 118 118 / 10%) !important;
		overflow: auto;
	}

	.ewm_wrchatgpt_background_inner_close {
		float: right;
		margin: 3px 150px 3px 3px;
		border-radius: 10px;
		background-color: #f9f9f9 !important;
		border: 0px solid #ccc;
		padding: 8px 15px;
		cursor: pointer;
	}

	.ewm_wrchatgpt_menu_top {
		width: 100%;
		overflow: auto;
	}

	.ewm_wrchatgpt_keyword_select_left {
		width: 38%;
		float: left;
		background-color: var(--e-context-warning-tint-1);
		color: var(--wc-secondary-text);
		height: 100%;
		padding: 8px;
		border-radius: 5px;
	}

	.ewm_wrchatgpt_main_body {
		width: 90%;
		float: left;
		margin-left: 5%;
		padding-bottom: 50px;
	}

	.ewm_wrchatgpt_tabs_50 {
		width: 49%;
		float: left;
		background: #fff;
		padding: 7px;
		border: 1px #cccccc90 solid;
		border-radius: 3px;
		cursor: pointer;
		color: #333;
	}

	.ewm_wrchatgpt_tabs_50_active {
		background: var(--wc-secondary);
		color: #333;
	}

	.ewm_wrchatgpt_submenu_main {
		width: 100%;
		overflow: auto;
	}

	.ewm_wrchatgpt_subbody_main {
		width: 100%;
		overflow: auto;
	}

	.ewm_wrchatgpt_locations_single {
		padding: 10px 0px 3px 12px;
		margin: 0px 30px;
		border: 0px;
		border-radius: 5px;
		background: #f9f9f9c4;
	}

	.ewm_wrchatgpt_locations_list {
		width: 100%;
		background: #cccccc17;
		border-radius: 8px;
	}

	.ewm_wrchatgpt_no_keyword_selected {
		padding: 10px 0px 0px 0px;
		color: #515151;
	}

	.ewm_wrchatgpt_generate_worker_review_button {
		width: 90%;
		padding: 25px 30px;
		background: #f9f9f9;
		margin-left: 5%;
		border-radius: 10px;
	}

	.ewm_wrchatgpt_ttle {
		background: #646970;
		color: #fff;
		padding: 10px 20px;
		border-radius: 5px;
	}

	.ewm_wrchatgpt_generate_worker_review_button {
		border-radius: 15px;
		margin: 23px;
		padding: 10px 30px;
		background-color: #f9f9f9 !important;
		border: 2px solid #ccc !important;
		cursor: pointer;
		background: #fff;
	}

	.ewm_wrchatgpt_generate_long_tail_menu {
		width: 100%;
		padding: 0px;
	}

	.ewm_wrchatgpt_generate_long_tails {
		width: 95%;
		display: none;

	}

	.ewm_dpm_single_title_link {
		width: 100%;
		padding: 6.8px;
		border: 0px solid #cccccc2e;
		margin-bottom: 2px;
		border-radius: 3px;
	}

	.ewm_wrchatgpt_locations_single_all {
		color: #333;
		padding: 8px;
		border-radius: 3px;
		margin-top: 20px;
		width: 98%;
		border: 0px;
	}

	.ewm_wrchatgpt_checkbox_item_all {}

	.ewm_wrchatgpt_kw_table {
		display: none;
	}

	.ewm_wrchatgpt_single_raw {
		border: 1px solid #fff;
		padding: 5px;
	}

	.ewm_wrchatgpt_edit_kw_item {
		background-color: #8eadbf;
		cursor: pointer;
		border-radius: 30px;
		padding: 8px 10px;
		border: 0px #333 solid;
		color: #fff;
	}

	.ewm_wrchatgpt_edit_kw_item_new {
		background-color: #333;
		cursor: pointer;
		border-radius: 30px;
		padding: 8px 10px;
		border: 0px var(--wc-blue) solid;
		color: #fff;
		margin: 30px;
	}

	.ewm_wrchatgpt_left_kw_item {
		border-bottom: #fff;
		min-width: 260px;
		padding: 10px;
	}

	.ewm_wrchatgpt_keyword_edit_wrapper {
		width: 100%;
		padding: 15px;
	}

	.ewm_wrchatgpt_kw_edit_area {
		width: 96.8%;
		margin: 10px;
	}

	.ewm_wrchatgpt_edit_kw_t {
		float: left;
		padding: 15px 8px 0px 10px;
	}

	.ewm_wrchatgpt_keyword_edit {
		background-color: #fcb92c66;
		border-radius: 10px;
	}

	.ewm_wrchatgpt_keyword_edit_link {
		width: 100%;
	}

	.ewm_wrchatgpt_kw_edit_link_1 {
		float: left;
	}

	.ewm_wrchatgpt_kw_edit_link_2 {
		float: left;
	}

	.ewm_wrchatgpt_kw_edit_link_3 {
		float: left;
	}

	.ewm_wrchatgpt_kw_edit_link_4 {
		float: left;
	}

	.ewm_wrchatgpt_left_kw_item {
		cursor: pointer;
	}

	.ewm_wrchatgpt_menu_key_manager {
		width: 90%;
	}

	.ewm_wrchatgpt_menu_l_s,
	.ewm_wrchatgpt_menu_r_s {
		float: left;
		background-color: #9acd3230;
		color: #333;
		border-radius: 15px;
		width: 46.6%;
		cursor: pointer;
		padding: 10px;
		border: 2px solid #fff;
	}

	.ewm_dpm_single_title_link_a {
		color: #333 !important;
	}
	.ewm_wr_chat_outer_single_line{
		width: 28%;
		float: left;
		min-width: 200px;
		padding: 2px 15px;
		overflow: auto;
		height: 79px;
		margin: 5px 10px 30px 0px;
		border: 1px solid #80808000;
		border-radius: 20px;
		background: #fff;
	}

	.ewm_wr_chat_outer_single_line_full{
		width: 100%;
	}

	.ewm_wr_chatgpt_wrap_outer{
		padding: 5px;
		overflow: auto;
	}
	.ewm_wr_chat_manage_groups{
		background: #feffaf;
		color: #333;
		border: 1px solid #feffaf;
		padding: 8px 15px;
		border-radius: 10px 15px;
		cursor: pointer;
		margin-top: 15px;
		float: right;
		margin-right: 10px;
	}
	.ewm_wr_chat_cat_input{
		width: 95%;
		border-radius: 15px !important;
		padding: 5px;
	}
	.ewm_wr_chat_title{
		width: 95%;
	}
	.ewm_wr_chat_outer_group_top{
		width: 98%;
		overflow: auto;
	}
	.ewm_wr_chat_cat_input{
		width: 95%;
		margin: 30px 15px;
	}
	.ewm_wr_chat_cat_inline{
		background: #fff;
		border-radius: 10px 15px;
		float: left; /*margin: 5px;*/
		padding: 10px 20px;
		cursor: pointer;
		color: #333;
		min-width: 150px;
	}
	.ewm_wr_chat_title_group{
		font-weight: initial;
		font-size: 18px;
	}
	.ewm_wr_chat_outer_single_group_list{
		border: 0px solid #80808029;
		overflow: auto;
		width: 95%;
		padding: 15px;
		border-radius: 20px;
		background-color: #8ac68d21;
	}
	.ewm_wr_sing_group_edit{
		border: 0px solid #3335;
		border-radius: 10px;
		padding: 8px 10px;
		background: #feffaf;
		color: #333;
		margin-left: 15px;
		display: none;
		cursor: pointer;
	}
	.ewm_wr_sing_group_delete{
		border: 0px solid #8ac68d;
		border-radius: 10px;
		padding: 5px 18px;
		background: #8ac68d;
		color: #333;
		display: none;
		cursor: pointer;
	}
	.ewm_wr_chat_edit_cat_inline{
		min-height:100%;
	}
	.ewm_wr_chat_group_top{
		width: 45%;
		overflow: auto;
		float: left;
		min-height: 65px;
	}
	.ewm_wr_chat_edit_cat_inline{
		padding: 12px;
	}
	#ewm_wr_chatgpt_city{
		float: left;
		border-radius: 10px;
		padding:3px 10px;
		min-width: 50% ;
		border:1px solid #d3cece;
		margin-right: 15px;
	}
	#ewm_wr_chatgpt_cities{
		float: left;
		background-color: #8dc68c;
		color: #333;
		border-radius: 10px 15px;
		padding: 8px 15px;
		border: 0px;
		cursor: pointer;
	}
	.ewm_single_review_title_outer{
		width: 90%;
		background: #fff;
		overflow: auto;
		padding: 10px;
		border: 0px solid gray;
		margin: 10px;
	}
	.ewm_single_review_title_details{
		float: left;
	}
	.ewm_wr_top_menu{
		width:100%;
		padding:10px;
		overflow: auto;
	}
	.ewm_single_review_title{
		font-size: larger;
		font-weight: bold;
	}

	.ewm_wr_autoselection_left{
		width:45%;
		float:left;
		border:0px solid #ccc;
		margin-right: 10px;
		padding:10px;
		cursor:pointer;
		border-radius: 10px 15px;
		background-color: #ccc2;
		border: 2px solid #8EFE8D;
		color: #333;
        background: #8EFE8D;
	}

	.ewm_wr_autoselection_right{
		width:45%;
		float:left;
		border:0px solid #ccc;
		padding:10px;
		border-radius: 10px 15px;
		background-color: #ccc2;
		cursor:pointer;
	}
	.ewm_wr_chat_manual{
		display: none;
		width: 90%;
		padding: 20px;
	}
	.ewm_wr_inner_line{
		max-width: 500px;
		border: 0px solid gray;
		padding: 10px 25px;
		border-radius: 10px;
		background: #fff;
		color: #333;
	}
	.gpt_ewm_top_menu_list{
		width: 100%;
		overflow: auto;
		padding-bottom: 20px;
	}
	.gpt_ewm_new_review_btn{
		color: #333;
		background: rgb(142, 254, 141);
		float: right;
		border: 0px;
		padding: 10px;
		border-radius: 10px;
		cursor: pointer;
	}


</style>

<div class="ewm_wrchatgpt_background_main">
	<div class="ewm_wrchatgpt_background_inner">
		<div class="ewm_wrchatgpt_menu_top">
			<input type="button" value="Close[x]" class="ewm_wrchatgpt_background_inner_close">
		</div>
		<div class="ewm_wrchatgpt_l_key_section">
			<div class="ewm_single_review_title_outer">
				<center>
				<div class="ewm_wr_inner_line">
					<!-- <span class="ewm_single_review_title_details">Post Title:</span> -->
					<span class="ewm_single_review_title"></span>
				</div>
				</center>
			</div>

			<div class="ewm_wr_top_menu">
				<div class="ewm_wr_autoselection_left"><center>Automated</center></div>
				<div class="ewm_wr_autoselection_right"><center>Manual</center></div>
			</div>
			<div class="ewm_wrchatgpt_no_keyword_selected">				
				<div class="ewm_wr_chat_outer">
					<div class="ewm_wr_chatgpt_wrap_outer">						

						<!--
						<div class="ewm_wr_chat_outer_single_line">
							<div class="ewm_wr_chat_title">
								Number of Reviews per Page <span class="ewm_wr_super">*</span>
							</div>
							<div class="ewm_wr_chat_input">
								<select class="ewm_wr_chatgpt_input" type="text" id="ewm_wr_chatgpt_number_of_reviews" placeholder>
									<option value="">Select Number of Reviews</option>
									<option value="1">One</option>
									<option value="2">Two</option>
									<option value="3">Three</option>
									<option value="4">Four</option>
									<option value="5">Five</option>
									<option value="6">Six</option>
									<option value="7">Seven</option>
									<option value="8">Eight</option>
									<option value="9">Nine</option>
									<option value="10">Ten</option>
								</select><br>
								<span class="ewm_wr_chatgpt_number_of_reviews_message"></span>
							</div>
						</div>
						-->
						<div class="ewm_wr_chat_outer_single_line">
							<div class="ewm_wr_chat_input">
								<input class="" type="checkbox" id="ewm_wr_chatgpt_daily" placeholder> Post a Daily Worker Review
							</div>
						</div>
						<!-- <div class="ewm_wr_chat_outer_single_line">						
							<div class="ewm_wr_chat_input">
								<input class="ewm_wr_chatgpt_instant" type="checkbox" id="ewm_wr_chatgpt_instant" placeholder> Generate Instant review on Save
							</div>
						</div> -->
						<div class="ewm_wr_chat_outer_single_line">							
							<div class="ewm_wr_chat_input ewm_wr_chat_input_city">
								<?php

									$gpt_new_city = get_posts( [
										'post_type' => 'gpt_new_city',
										'post_status' => 'active',
										'posts_per_page' => -1
									] );

								?>
								<select class="" type="checkbox" id="ewm_wr_chatgpt_city">
									<option value="0">Select City</option>
									<?php 
									// var_dump( $gpt_new_city );
									foreach( $gpt_new_city as $k_ => $v_ ){
										$v_ID_meta = get_post_meta( $v_->ID, "ewm_r_address_city", true );
										echo '<option value="'. $v_->ID .'">'. $v_ID_meta .'</option>';
									}
									?>
									
								</select>
								<input type="button" id="ewm_wr_chatgpt_cities" value="Manage Cities">
							</div>
						</div>

						<div class="ewm_wr_chat_outer_single_group_list">
							<div class="ewm_wr_chat_title_group">
								<center>Select Template Group</center>
							</div>
							<div class="ewm_wr_chat_outer_group_top">
								<div class="ewm_wr_chat_input">
								<input type="button" class="ewm_wr_chat_manage_groups ewm_wr_chat_edit_groups" value="Edit Template Group (Show/ Hide)">
								<input type="button" class="ewm_wr_chat_manage_groups ewm_wr_chat_new_groups" value="New Template Group">
								</div>
							</div>
							<div class="ewm_wr_chat_input">
								<?php
								
								$post_data = [
									'post_status' => 'active',
									'post_type' => 'wr_gpt_group',
									'posts_per_page'=> -1
								];
								$post_data_results = get_posts( $post_data );

								?>
								<div class="ewm_wr_chat_cat_input ewm_wr_chat_g_list" >
									<?php
									foreach( $post_data_results as $row ){

										echo '<div class="ewm_wr_chat_group_top" id="ewm_wr_chat_group_top_'.$row->ID.'">
											<div class="ewm_wr_chat_cat_inline"  id="ewm_wr_chat_cat_inline_'.$row->ID.'"  data-ewm_group_selected="0" data-ewm_group_id="'.$row->ID.'">'.
											$row->post_title
											.'</div>
											<div class="ewm_wr_chat_edit_cat_inline" >
												<span class="ewm_wr_sing_group_edit" id="ewm_wr_sing_group_edit_'.$row->ID.'" data-ewm_group_id="'.$row->ID.'">Edit</span>
												<span class="ewm_wr_sing_group_delete" data-ewm_group_id="'.$row->ID.'">Delete</span>
											</div>
										</div>';

									}
									?>
								</div>
							</div>
						</div>
						
					</div>
					
					<div class="ewm_wr_chat_outer_single_line_full">
						<div class="ewm_wr_chat_input">
							<center>
								<div class="ewm_wr_chatgpt_wrapper_button">
									<input class="ewm_wr_chatgpt_input_next" type="button" value="Save Chatgpt Automation Settings">
								</div>
							</center>
						</div>
					</div>
				</div>
			</div>
			
			<div class="ewm_wr_chat_manual">
				<div class='gpt_ewm_top_menu_list'>
					<input type="button" value="New Review" class="gpt_ewm_new_review_btn">
				</div>
				<?php

					include dirname(__FILE__).'/review_list.php' ;
					
				?>
			</div>

		</div>

	</div>

</div>

</div>

<input type="hidden" name="ewm_wrchatgpt_page_id" class="ewm_wrchatgpt_page_id" id="ewm_wrchatgpt_page_id" value="0">
<input type="hidden" name="ewm_wrchatgpt_search_id"  id="ewm_wrchatgpt_search_id" class="ewm_wrchatgpt_search_id" value="0">
<input type="hidden" name="ewm_wrchatgpt_group_id" class="ewm_wrchatgpt_group_id" id="ewm_wrchatgpt_group_id" value="0">
<input type="hidden" name="ewm_wrchatgpt_review_id" class="ewm_wrchatgpt_review_id" id="ewm_wrchatgpt_review_id" value="0">
<input type="hidden" name="ewm_wrchatgpt_group_item_id" value="ewm_wrchatgpt_group_item_id" id="ewm_wrchatgpt_group_item_id" value="0">
<input type="hidden" name="ewm_wr_group_is_new" value="ewm_wr_group_is_new" id="ewm_wr_group_is_new" value="0">
<input type="hidden" name="ewm_wr_button_new_city_item" value="ewm_wr_button_new_city_item" id="ewm_wr_button_new_city_item" value="0">
<input type="hidden" name="ewm_wr_city_is_new" value="ewm_wr_city_is_new" id="ewm_wr_city_is_new" value="0">
<input type="hidden" name="gpt_ewm_img_file_is_changed" value="gpt_ewm_img_file_is_changed" id="gpt_ewm_img_file_is_changed" value="0">
<input type="hidden" name="city_before_edit" value="city_before_edit" id="city_before_edit" value="0">

<?php

	include dirname(__FILE__).'/ewm_wr_group.php' ;
	include dirname(__FILE__).'/ewm_wr_city.php' ;

?>
