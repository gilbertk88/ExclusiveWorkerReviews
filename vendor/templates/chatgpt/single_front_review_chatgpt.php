<div class="ewm_r_single_cat" data-single-cat="<?php echo $ewm_single_chatgpt_key; ?>" id="ewm_r_single_cat_<?php echo $ewm_single_chatgpt_key; ?>">

	<div class = 'ewm_r_cat_name' id="ewm_r_cat_name_<?php echo $ewm_single_chatgpt_key; ?>" > <?php echo $ewm_single_chatgpt_val; ?></div>

	<div class="ewm_manage_l_items">
		<span class="ewm_manage_l_items_edit" data-ewm_chatgpt_edit="<?php echo $ewm_single_chatgpt_key; ?>" data-chatgpt_name_details="<?php echo $ewm_single_chatgpt_val; ?>" id="ewm_wr_chatgpt_edit_<?php echo $ewm_single_chatgpt_key; ?>" ><a target="new" href="<?php echo $ewm_single_chatgpt_link; ?>">Open Link</a></span>
		<span class="ewm_manage_l_items_generate_chatgpt" data-ewm_chatgpt_search = "<?php echo $ewm_chatgpt_search_id; ?>" data-ewm_chatgpt="<?php echo $ewm_single_chatgpt_key; ?>" data-cat_name_details="<?php echo $ewm_single_chatgpt_key; ?>"  id="ewm_wr_chatgpt_<?php echo $ewm_single_chatgpt_key; ?>" >Generate ChatGpt</span>
	</div>

</div>
