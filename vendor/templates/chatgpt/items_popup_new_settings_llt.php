<style>
	.ewm_wrchatgpt_background_main_gptset_new {
		width: 100%;
		height: 100%;
		background-color: #33333350;
		position: fixed;
		left: 0px;
		top: 0px;
		padding-left: 20%;
		z-index: 1000000;
		display:none;
	}

	.ewm_wrchatgpt_background_inner_gptset {
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

	.ewm_wrchatgpt_background_inner_close_gptset_new {
		float: right;
		margin: 3px 150px 3px 3px;
		border-radius: 10px;
		background-color: #f9f9f9 !important;
		border: 0px solid #ccc;
		padding: 15px;
		cursor: pointer;
	}

	.ewm_wrchatgpt_menu_top_gptset {
		width: 100%;
		overflow: auto;
	}
	.ewm_wrchatgpt_l_key_section_gptset{
		width: 80%;
		padding: 35px;
		border: 1px solid #32323240;
		border-radius: 5px;
		margin-top: 30px;
	}
	.ewm_wr_key_title_bold{
		width: 100%;
		padding: 0px 15px;
	}

	.ewm_wr_key_input{
		Width:100%;
		padding: 10px 0px;
	}

	.ewm_wr_input_api_key{
		width: 100%;
		padding: 3px 20px !important;
		border-radius: 5px !important;
	}

	.ewm_wr_input_api_key_save{
		width: 50%;
		border-radius: 5px;
		border: 0px solid #ccc !important;
		color: #fff;
		background: #02a814 ;
		padding: 10px;
	}

</style>

<div class="ewm_wrchatgpt_background_main_gptset_new">
	<div class="ewm_wrchatgpt_background_inner_gptset">
		<div class="ewm_wrchatgpt_menu_top">
			<input type="button" value="Close[x]" class="ewm_wrchatgpt_background_inner_close_gptset_new">
		</div>

		<div class="ewm_wrchatgpt_l_key_section_gptset">

			<div class="ewm_wr_key_title_bold" >
				<h2>How to create a worker review page</h2>
			</div>

			<div class="ewm_wr_key_input">
				<p>

					<b>The worker review plugin helps you display worker reviews using a shortcode. </b>
					<br>
					<br>

					To display the worker reviews, follow the following instructions:

				</p>

				<ul class="ewm_wr_guide_ul">

					<li class="ewm_wr_guide_li">Add the following shortcode to the desired page/post: <span class="ewm_wr_shortcode">[exclusive_worker_review]</span> </li>
					<li class="ewm_wr_guide_li">After adding the shortcode, <a href="<?php echo get_admin_url().'admin.php?page=ewm-wr-chat-gpt'; ?>">Click Here</a> to edit the worker review.</li>
				</ul>

			</div>
			
		</div>

	</div>

</div>

</div>
