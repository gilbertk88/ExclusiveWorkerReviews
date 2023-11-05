<style>
	.ewm_wrchatgpt_background_main_gptset {
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

	.ewm_wrchatgpt_background_inner_close_gptset {
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
		border-radius: 20px !important;
	}

	.ewm_wr_input_api_key_save{
		width: 50%;
		border-radius: 20px;
		border: 0px solid #ccc !important;
		color: #fff;
		background: #02a814 ;
		padding: 10px;
	}

</style>

<div class="ewm_wrchatgpt_background_main_gptset">
	<div class="ewm_wrchatgpt_background_inner_gptset">
		<div class="ewm_wrchatgpt_menu_top">
			<input type="button" value="Close[x]" class="ewm_wrchatgpt_background_inner_close_gptset">
		</div>

		<div class="ewm_wrchatgpt_l_key_section_gptset">

			<div class="ewm_wr_key_title_bold" >
				Chatgpt API Key
			</div>
			<div class="ewm_wr_key_input">
				<?php
					$ewm_gpt_api_key = get_option( 'ewm_gpt_api_key' );
				?>
				<input class="ewm_wr_input_api_key" type ="text" value="<?php echo $ewm_gpt_api_key ; ?>">
			</div>

			<div class="ewm_wr_key_input">
				<center>
					<input class="ewm_wr_input_api_key_save" type ="button" value="Save ChatGPT Key">
					<div class="ewm_wr_input_api_key_save_message"></div>
				</center>
			</div>
			

		</div>

	</div>

</div>

</div>
