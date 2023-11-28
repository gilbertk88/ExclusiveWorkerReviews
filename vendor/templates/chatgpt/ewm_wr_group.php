<style>
	.ewm_wr_chat_group_outer_wrap {
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

	.ewm_wr_chat_group_inner_wrap {
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

	.ewm_wr_chat_group_menu_wrap {
		width: 95%;
		overflow: auto;
		padding: 10px 30px 10px 10px;
		margin: 0px 0px 10px 0px;
	}
	.ewm_wr_close_group {
		float: right;
		margin: 3px 68px 3px 3px;
		border-radius: 10px;
		background-color: #f9f9f9 !important;
		border: 0px solid #ccc;
		padding: 15px;
		cursor: pointer;
	}
	.ewm_wr_group_title_wrap{
		float: left;
		width: 95%;
		padding: 5px;
		font-size: 18px;
	}
	.ewm_wr_group_title_wrap_outer{
		border-radius:10px !important;
	}
	.ewm_wr_group_name_title{
		width: 100%;
		padding: 2px 25px !important;
		border-radius: 20px !important;
		border: 1px #ccc solid !important;
	}
	.ewm_wr_edit_area_left{
		float: left;
		width: 90%;
		overflow-x: scroll;
		padding: 20px;
		overflow-y: scroll;
		height: 400px;
	}
	.ewm_wr_edit_area_right{
		float: left;
		width: 50%;
		padding: 20px;
		background: #8ac68d12;
		border-radius: 5px;
		border: 0px solid #ccc5;
		margin: ;
		display: none;
	}
	.ewm_wr_single_line_list_item_top{
		float: left;
		padding: 10px;
		width: 95%;
	}
	.ewm_wr_single_line_list_item{
		width: 95%;
		float: left;
		min-width: 200px;
		padding:15px;
		overflow: auto;
		margin: 10px;
		border: 0px solid #00ff044d;
		border-radius: 10px;
	}
	.ewm_wr_chat_outer_single_group_line{
		width: 45%;
		float: left;
		padding-right: 23px;
	}
	.ewm_wr_edit_single_g_item{
		float: right;
		border: 0px solid #ccc;
		background-color: #feffaf;
		padding: 6px 15px;
		border-radius: 5px;
		margin-right: 5px;
		color: #333;
		cursor: pointer;
	}
	.ewm_wr_delete_single_g_item{
		cursor: pointer;
		float: right;
		color: #fff;
		background-color: #8ac68d;
		padding: 6px 20px;
		border-radius: 5px;
		margin-right: 5px;
	}
	.ewm_wr_edit_area_right_menu{
		width:95%;
		overflow:auto;
	}
	.ewm_wr_close_single_b{
		float: right;
		background: #fff;
		border: 1px solid #3333;
		padding: 10px;
		border-radius: 10px;
		color: #333;
		background: #fff;
		color: #333;
		padding: 5px 12px;
		border-radius: 5px;
		margin-top: 30px;
		border: 2px solid #8ac68d99;
	}
	.ewm_wr_save_single_b{
		background: #fff;
		color: #333;
		padding: 10px !important;
		border-radius: 10px !important;
		border: 2px solid #8ac68d;
		margin-top: 30px !important;
	}
	.ewm_wr_description_line{
		font-size: 10px;
	}
	.ewm_wr_description_title{
		float:left;
	}
	.ewm_wr_button_new_group_item{
		float: right;
		background-color: #8EFE8D;
		border: 0px;
		color: #333;
		padding: 9px 20px;
		border-radius: 5px;
		cursor: pointer;
		margin-right: 80px;
		border: 0px;
	}

</style>
<div class="ewm_wr_chat_group_outer_wrap">
	<div class="ewm_wr_chat_group_inner_wrap">
		<div class="ewm_wr_chat_group_menu_wrap">
			<input type="button" value="Close" class="ewm_wr_close_group">
		</div>
		<div class="ewm_wr_chat_group_menu_wrap ewm_wr_group_title_wrap_outer">
			<div class="ewm_wr_group_title_wrap">
				<center>Template Group Name</center>
			</div>
			<div class="ewm_wr_group_title_wrap"><input type="text" value="" class="ewm_wr_group_name_title"></div>
		</div>
		<div class="ewm_wr_single_line_list_item_top">
			<input type="button" class="ewm_wr_button_new_group_item" value="New Item">
		</div>
		<div class="ewm_wr_edit_area_left">			
			<div class="ewm_wr_single_line_list_item">
				<span data-ewm_wr_delete_single_g_item_id="" class="ewm_wr_delete_single_g_item">Delete</span> 
				<span data-ewm_wr_edit_single_g_item="" class="ewm_wr_edit_single_g_item">Edit</span>
			</div>
		</div>
		<div class="ewm_wr_edit_area_right">
			<div class="ewm_wr_edit_area_right_menu">
				<input type="button" class="ewm_wr_close_single_b" value="Close Form">
			</div>

			<div class="ewm_wr_chat_outer_single_group_line">
				<div class="ewm_wr_chat_title">
				<div class="ewm_wr_description_title">Review Title</div><div class="ewm_wr_description_line">(Will be used in ChatGPT)<span class="ewm_wr_super">*</span></div>
				</div>
				<div class="ewm_wr_chat_input">
					<input type="text" id="ewm_wr_gpt_review_title">
				</div>
			</div>
			<div class="ewm_wr_chat_outer_single_group_line">
				<div class="ewm_wr_chat_title">
					Customer Name<span class="ewm_wr_super">*</span>
				</div>
				<div class="ewm_wr_chat_input">
					<input type="text" id="ewm_wr_gpt_customer_name">
				</div>
			</div>
			<div class="ewm_wr_chat_outer_single_group_line">
				<div class="ewm_wr_chat_title">
					Rating<span class="ewm_wr_super">*</span>
				</div>
				<div class="ewm_wr_chat_input">
					<select id="ewm_wr_gpt_rating">
						<option value="1">1</option>
						<option value="2">2</option>
						<option value="3">3</option>
						<option value="4">4</option>
						<option value="5">5</option>
					</select>
				</div>
			</div>
			<div class="ewm_wr_chat_outer_single_group_line">
				<div class="ewm_wr_chat_title">
					Street Address<span class="ewm_wr_super">*</span>
				</div>
				<div class="ewm_wr_chat_input">
					<input type="text" id="ewm_wr_gpt_address">
				</div>
			</div>
			<div class="ewm_wr_chat_outer_single_group_line">
				<div class="ewm_wr_chat_title">
					Category<span class="ewm_wr_super">*</span>
				</div>
				<div class="ewm_wr_chat_input">
					<select type="text" id="ewm_wr_gpt_category">
						<option value = "" >No Category Select</option>
					<?php 
						$ewm_review_categories_list_post_id = get_option('ewm_review_categories_list_post_id');
						$ewm_r_categories_list = get_post_meta( $ewm_review_categories_list_post_id, 'ewm_front_cats');
						foreach($ewm_r_categories_list as $category_k => $category_v ){
							echo '<option value = "'. $category_v .'" >'. $category_v .'</option>';
						}
					?>
							
					</select>
				</div>
			</div>
			<div class="ewm_wr_chat_outer_single_group_line">
				<div class="ewm_wr_chat_title">
					Job Description<span class="ewm_wr_super">*</span>
				</div>
				<div class="ewm_wr_chat_input">
					<input type="text" id="ewm_wr_gpt_job_description">
				</div>
			</div>
			<div class="ewm_wr_chat_outer_single_group_line">
				<div class="ewm_wr_chat_title">
					Team member<span class="ewm_wr_super">*</span>
				</div>
				<div class="ewm_wr_chat_input">
					<input type="text" id="ewm_wr_gpt_team_member">
				</div>
			</div>

			<div class="ewm_wr_edit_area_right_menu">
				<center><input type="button" class="ewm_wr_save_single_b" value="Save"></center>
			</div>
		</div>
	</div>
</div>
