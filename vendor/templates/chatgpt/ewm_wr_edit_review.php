<style>
	.ewm_wrchatgpt_sr_edit_background_main {
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

	.ewm_wrchatgpt_sr_edit_background_inner {
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
	.ewm_wrchatgpt_sr_edit_background_inner_close {
		float: right;
		margin: 3px 60px 3px 3px;
		border-radius: 10px;
		background-color: #f9f9f9 !important;
		border: 0px solid #ccc;
		padding: 10px 15px;
		cursor: pointer;
	}
	.ewm_wrchatgpt_sr_edit_menu_top {
		width: 100%;
		overflow: auto;
	}

	.ewm_wrchatgpt_sr_edit_main_body {
		width: 90%;
		float: left;
		margin-left: 5%;
		padding-bottom: 50px;
	}

	.gpt_ewm_wr_title_top{
		width: 98%;
		font-weight: bold;
		font-size: 15px;
		padding: 10px;
	}

	.gpt_ewm_wr_worker_review_img{
		height: 80px;
		float: left;
		overflow: auto;
		margin: 5px 0px;
		border-radius: 3px;
		border: 0px solid #ccc;
		max-width: 23%;
	}

	#gpt_ewm_r_review_title,
	#gpt_ewm_r_description,
	#gpt_ewm_r_customer_name,
	#gpt_ewm_r_review_date,
	#ewm_r_star_rating,
	#gpt_ewm_r_review_address,
	#gpt_ewm_r_address_city,
	#gpt_ewm_r_address_state,
	#gpt_ewm_r_address_zip,
	#gpt_ewm_r_address_country,
	#gpt_ewm_r_job_description,
	#gpt_ewm_r_team_member,
	#gpt_ewm_wr_category_dropdown,
	#gpt_ewm_r_street_address{
		width: 98%;
		border-radius: 5px;
		padding: 1px 10px;
		border: 1px solid #ccc;
		height: 30px;
	}

	.gpt_ewm_wr_worker_review_img_{
		float: left;
		width: 40%;
		padding: 10px;
	}
	.gpt_half_life_img{
		width: 43%;
		overflow: auto;
		padding: 10px 30px;
		border: 0px solid #ccc8;
		border-radius: 10px;
		float: left;
	}

	.gpt_half_life_title{
		width: 43%;
		float: left;
		padding: 10px 15px;
		overflow: auto;
		border-radius: 10px;
		margin-left: 12px;
		min-height: 90px;
	}
	.gpt_ewm_wr_worker_review_main{
		overflow: auto;
	}

	.gpt_ewm_description_list{
		width: 98%;
		padding: 20px 10px;
		overflow: auto;
	}

	.gpt_half_life_description{
		float: left;
		border-radius: 10px;
		width: 46%;
		padding: 18px 10px;
		margin-right: 10px;
	}

	.gpt_ewm_r_worker_review_main{
		overflow: auto;
	}
	#gpt_ewm_wr_img_file_message,
	#gpt_ewm_r_review_title_message,
	#gpt_ewm_r_customer_name_message,
	#gpt_ewm_r_review_date_message,
	#gpt_ewm_r_star_rating_message,
	#gpt_ewm_r_review_address_message,
	#gpt_ewm_r_street_address_message,
	#gpt_ewm_r_address_city_message,
	#gpt_ewm_r_address_state_message,
	#gpt_ewm_r_address_zip_message,
	#gpt_ewm_r_address_country_message,
	#gpt_ewm_r_team_member_message,
	#gpt_ewm_wr_category_dropdown_message{
		color:red;
	}

	.gpt_ewm_wr_full_content{
		width:60%;
		padding:20px;

	}

	#ewm_r_star_rating{
		float: left;
		width: 94%;
		height: 20px;
		margin-top:5px;
	}

	#gpt_wr_ewm_r_star_rating{
		width: 50%;
	}

	#ratingOne{
		border: 1px solid #333;
		float: left;
		padding: 5px 10px;
		border-radius: 10px;
		margin-left: 5px;
		background: #333;
		color: #fff;
	}

	.ewm_gpt_rate_display{
		width: 90%;
		background: #01b40014;
		margin-left: 3%;
		border-radius: 20px;
		margin-top: 10px;
	}

	#gpt_ewm_wr_worker_review_img_d{
		height: 70px;
		width: 100px;
	}

</style>

<div class="ewm_wrchatgpt_sr_edit_background_main">
	<div class="ewm_wrchatgpt_sr_edit_background_inner">
		<div class="ewm_wrchatgpt_sr_edit_menu_top">
			<input type="button" value="Close[x]" class="ewm_wrchatgpt_sr_edit_background_inner_close">
		</div>
		<div class="ewm_wrchatgpt_sr_edit_section">
			<form id="ewm_r_work_review_form_">
				<div class="gpt_ewm_wr_title_top">
					<center>Edit Worker Review</center>
				</div>
				<div class="gpt_ewm_wr_worker_review_main">
					
					<div class="gpt_half_life_img">

						<div class="gpt_ewm_wr_worker_review_img"></div>

						<div class="gpt_ewm_wr_worker_review_img_">

							<label class="gpt_wr_lable">Select image <span class="gpt_ewm_wr_asteric">*</span> </label>
							<span id="gpt_ewm_img_container">
								<input name="gpt_ewm_wr_img_file" id="gpt_ewm_wr_img_file" placeholder="" type="file">
							</span>
							<span id="gpt_ewm_wr_img_file_message"></span>
							
						</div>

					</div>

					<div class="gpt_half_life_title">
						
						<label class="gpt_wr_lable">Review Title<span class="gpt_ewm_wr_asteric">*</span></label>

						<input name="gpt_ewm_r_review_title" id="gpt_ewm_r_review_title" placeholder="" required="" type="text">

						<span id="gpt_ewm_r_review_title_message"> </span>

					</div>

				</div>

				<div class="ewm_r_worker_review_customer">
						
					<div class="ewm_wr_third padding_right_8">

						<label class="gpt_wr_lable">Customer Name <span class="ewm_wr_asteric">*</span> </label>

						<input name="gpt_ewm_r_customer_name" id="gpt_ewm_r_customer_name" placeholder="Customer Name" required="">
						
						<span id="gpt_ewm_r_customer_name_message"> </span>

					</div>

					<div class="gpt_ewm_wr_third gpt_padding_right_8">

						<label class="gpt_wr_lable">Review Date <span class="gpt_ewm_wr_asteric">*</span> </label>

						<input name="gpt_ewm_r_review_date" id="gpt_ewm_r_review_date" type="date" placeholder="Review Date">

						<span id="gpt_ewm_r_review_date_message"> </span>

					</div>

					<div id="first" class="gpt_ewm_wr_third">

						<label for="slider1" class="gpt_wr_lable">Review Rating <span class="gpt_ewm_wr_asteric">*</span> </label>

						<div class="score_div">

							<div class="score" id="gpt_ratingOne">0</div>

							<input type="range" id="ewm_r_star_rating" name="ewm_r_star_rating" min="0" max="10" value="0">

						</div>

						<span id="gpt_ewm_r_star_rating_message"> </span>

					</div>

				</div>

				<div class="gpt_ewm_r_worker_review_main gpt_ewm_r_padding_bottom_0">

					<div class="gpt_half_life">
						<label class="gpt_wr_lable">Address<span class="gpt_ewm_wr_asteric">*</span></label>
						<input name="gpt_ewm_r_review_address" id="gpt_ewm_r_review_address" placeholder="" required="" type="text">
						<span id="gpt_ewm_r_review_address_message"></span>
					</div>

					<div class="gpt_half_life">
						<label class="gpt_wr_lable">Street Address<span class="gpt_ewm_wr_asteric">*</span> </label>
						<input name="gpt_ewm_r_street_address" id="gpt_ewm_r_street_address" placeholder="" required="">
						<span id="gpt_ewm_r_street_address_message"> </span>
					</div>

					<div class="gpt_ewm_wr_half_content gpt_padding_right_8">

						<label class="gpt_wr_lable">City<span class="gpt_ewm_wr_asteric"></span></label>
						
						<input name="gpt_ewm_r_address_city" id="gpt_ewm_r_address_city" placeholder="" required="" type="text">

						<span id="gpt_ewm_r_address_city_message"></span>

					</div>

					<div class="gpt_ewm_wr_half_content">

						<label class="gpt_wr_lable">State/ Province/ Region<span class="gpt_ewm_wr_asteric"></span></label>

						<input name="gpt_ewm_r_address_state" id="gpt_ewm_r_address_state" placeholder="" required="">

						<span id="gpt_ewm_r_address_state_message"> </span>

					</div>

					<div class="gpt_ewm_wr_half_content gpt_padding_right_8 gpt_ewm_r_padding_top_0">

						<label class="gpt_wr_lable">ZIP/ Postal Code<span class="gpt_ewm_wr_asteric"></span></label>
						
						<input name="gpt_ewm_r_address_zip" id="gpt_ewm_r_address_zip" placeholder="" required="" type="text">

						<span id="gpt_ewm_r_address_zip_message"></span>

					</div>

					<div class="gpt_ewm_wr_half_content gpt_ewm_r_padding_top_0">

						<label class="gpt_wr_lable">Country<span class="gpt_ewm_wr_asteric"></span></label>
						<select name="gpt_ewm_r_address_country" id="gpt_ewm_r_address_country" placeholder="" required="">
							<option value="">Not Selected</option>
							<option value="Afghanistan">Afghanistan</option>
							<option value="Albania">Albania</option>
							<option value="Algeria">Algeria</option>
							<option value="American Samoa">American Samoa</option>
							<option value="Andorra">Andorra</option>
							<option value="Angola">Angola</option>
							<option value="Antigua and Barbuda">Antigua and Barbuda</option>
							<option value="Argentina">Argentina</option>
							<option value="Armenia">Armenia</option>
							<option value="Aruba">Aruba</option>
							<option value="Australia">Australia</option>
							<option value="Austria">Austria</option>
							<option value="Azerbaijan">Azerbaijan</option>
							<option value="Bahamas, The">Bahamas, The</option>
							<option value="Bahrain">Bahrain</option>
							<option value="Bangladesh">Bangladesh</option>
							<option value="Barbados">Barbados</option>
							<option value="Belarus">Belarus</option>
							<option value="Belgium">Belgium</option>
							<option value="Belize">Belize</option>
							<option value="Benin">Benin</option>
							<option value="Bermuda">Bermuda</option>
							<option value="Bhutan">Bhutan</option>
							<option value="Bolivia">Bolivia</option>
							<option value="Bosnia and Herzegovina">Bosnia and Herzegovina</option>
							<option value="Botswana">Botswana</option>
							<option value="Brazil">Brazil</option>
							<option value="British Virgin Islands">British Virgin Islands</option>
							<option value="Brunei Darussalam">Brunei Darussalam</option>
							<option value="Bulgaria">Bulgaria</option>
							<option value="Burkina Faso">Burkina Faso</option>
							<option value="Burundi">Burundi</option>
							<option value="Cabo Verde">Cabo Verde</option>
							<option value="Cambodia">Cambodia</option>
							<option value="Cameroon">Cameroon</option>
							<option value="Canada">Canada</option>
							<option value="Cayman Islands">Cayman Islands</option>
							<option value="Central African Republic">Central African Republic</option>
							<option value="Chad">Chad</option>
							<option value="Channel Islands">Channel Islands</option>
							<option value="Chile">Chile</option>
							<option value="China">China</option>
							<option value="Colombia">Colombia</option>
							<option value="Comoros">Comoros</option>
							<option value="Congo, Dem. Rep.">Congo, Dem. Rep.</option>
							<option value="Congo, Rep.">Congo, Rep.</option>
							<option value="Costa Rica">Costa Rica</option>
							<option value="Cote d'Ivoire">“Cote d’Ivoire”</option>
							<option value="Croatia">Croatia</option>
							<option value="Cuba">Cuba</option>
							<option value="Curacao">Curacao</option>
							<option value="Cyprus">Cyprus</option>
							<option value="Czech Republic">Czech Republic</option>
							<option value="Denmark">Denmark</option>
							<option value="Djibouti">Djibouti</option>
							<option value="Dominica">Dominica</option>
							<option value="Dominican Republic">Dominican Republic</option>
							<option value="Ecuador">Ecuador</option>
							<option value="Egypt, Arab Rep.">Egypt, Arab Rep.</option>
							<option value="El Salvador">El Salvador</option>
							<option value="Equatorial Guinea">Equatorial Guinea</option>
							<option value="Eritrea">Eritrea</option>
							<option value="Estonia">Estonia</option>
							<option value="Eswatini">Eswatini</option>
							<option value="Ethiopia">Ethiopia</option>
							<option value="Faroe Islands">Faroe Islands</option>
							<option value="Fiji">Fiji</option>
							<option value="Finland">Finland</option>
							<option value="France">France</option>
							<option value="French Polynesia">French Polynesia</option>
							<option value="Gabon">Gabon</option>
							<option value="Gambia, The">Gambia, The</option>
							<option value="Georgia">Georgia</option>
							<option value="Germany">Germany</option>
							<option value="Ghana">Ghana</option>
							<option value="Gibraltar">Gibraltar</option>
							<option value="Greece">Greece</option>
							<option value="Greenland">Greenland</option>
							<option value="Grenada">Grenada</option>
							<option value="Guam">Guam</option>
							<option value="Guatemala">Guatemala</option>
							<option value="Guinea">Guinea</option>
							<option value="Guinea-Bissau">Guinea-Bissau</option>
							<option value="Guyana">Guyana</option>
							<option value="Haiti">Haiti</option>
							<option value="Honduras">Honduras</option>
							<option value="Hong Kong SAR, China">Hong Kong SAR, China</option>
							<option value="Hungary">Hungary</option>
							<option value="Iceland">Iceland</option>
							<option value="India">India</option>
							<option value="Indonesia">Indonesia</option>
							<option value="Iran, Islamic Rep.">Iran, Islamic Rep.</option>
							<option value="Iraq">Iraq</option>
							<option value="Ireland">Ireland</option>
							<option value="Isle of Man">Isle of Man</option>
							<option value="Israel">Israel</option>
							<option value="Italy">Italy</option>
							<option value="Jamaica">Jamaica</option>
							<option value="Japan">Japan</option>
							<option value="Jordan">Jordan</option>
							<option value="Kazakhstan">Kazakhstan</option>
							<option value="Kenya">Kenya</option>
							<option value="Kiribati">Kiribati</option>
							<option value="Korea, Dem. People's Rep">Korea, Dem. People’s Rep.</option>
							<option value="Korea, Rep.">Korea, Rep.</option>
							<option value="Kosovo">Kosovo</option>
							<option value="Kuwait">Kuwait</option>
							<option value="Kyrgyz Republic">Kyrgyz Republic</option>
							<option value="Lao PDR">Lao PDR</option>
							<option value="Latvia">Latvia</option>
							<option value="Lebanon">Lebanon</option>
							<option value="Lesotho">Lesotho</option>
							<option value="Liberia">Liberia</option>
							<option value="Libya">Libya</option>
							<option value="Liechtenstein">Liechtenstein</option>
							<option value="Lithuania">Lithuania</option>
							<option value="Luxembourg">Luxembourg</option>
							<option value="Macao SAR, China">Macao SAR, China</option>
							<option value="Madagascar">Madagascar</option>
							<option value="Malawi">Malawi</option>
							<option value="Malaysia">Malaysia</option>
							<option value="Maldives">Maldives</option>
							<option value="Mali">Mali</option>
							<option value="Malta">Malta</option>
							<option value="Marshall Islands">Marshall Islands</option>
							<option value="Mauritania">Mauritania</option>
							<option value="Mauritius">Mauritius</option>
							<option value="Mexico">Mexico</option>
							<option value="Micronesia, Fed. Sts.">Micronesia, Fed. Sts.</option>
							<option value="Moldova">Moldova</option>
							<option value="Monaco">Monaco</option>
							<option value="Mongolia">Mongolia</option>
							<option value="Montenegro">Montenegro</option>
							<option value="Morocco">Morocco</option>
							<option value="Mozambique">Mozambique</option>
							<option value="Myanmar">Myanmar</option>
							<option value="Namibia">Namibia</option>
							<option value="Nauru">Nauru</option>
							<option value="Nepal">Nepal</option>
							<option value="Netherlands">Netherlands</option>
							<option value="New Caledonia">New Caledonia</option>
							<option value="New Zealand">New Zealand</option>
							<option value="Nicaragua">Nicaragua</option>
							<option value="Niger">Niger</option>
							<option value="Nigeria">Nigeria</option>
							<option value="North Macedonia">North Macedonia</option>
							<option value="Northern Mariana Islands">Northern Mariana Islands</option>
							<option value="Norway">Norway</option>
							<option value="Oman">Oman</option>
							<option value="Pakistan">Pakistan</option>
							<option value="Palau">Palau</option>
							<option value="Panama">Panama</option>
							<option value="Papua New Guinea">Papua New Guinea</option>
							<option value="Paraguay">Paraguay</option>
							<option value="Peru">Peru</option>
							<option value="Philippines">Philippines</option>
							<option value="Poland">Poland</option>
							<option value="Portugal">Portugal</option>
							<option value="Puerto Rico">Puerto Rico</option>
							<option value="Qatar">Qatar</option>
							<option value="Romania">Romania</option>
							<option value="Russian Federation">Russian Federation</option>
							<option value="Rwanda">Rwanda</option>
							<option value="Samoa">Samoa</option>
							<option value="San Marino">San Marino</option>
							<option value="Sao Tome and Principe">Sao Tome and Principe</option>
							<option value="Saudi Arabia">Saudi Arabia</option>
							<option value="Senegal">Senegal</option>
							<option value="Serbia">Serbia</option>
							<option value="Seychelles">Seychelles</option>
							<option value="Sierra Leone">Sierra Leone</option>
							<option value="Singapore">Singapore</option>
							<option value="Sint Maarten (Dutch part)">Sint Maarten (Dutch part)</option>
							<option value="Slovak Republic">Slovak Republic</option>
							<option value="Slovenia">Slovenia</option>
							<option value="Solomon Islands">Solomon Islands</option>
							<option value="Somalia">Somalia</option>
							<option value="South Africa">South Africa</option>
							<option value="South Sudan">South Sudan</option>
							<option value="Spain">Spain</option>
							<option value="Sri Lanka">Sri Lanka</option>
							<option value="St. Kitts and Nevis">St. Kitts and Nevis</option>
							<option value="St. Lucia">St. Lucia</option>
							<option value="St. Martin (French part)">St. Martin (French part)</option>
							<option value="St. Vincent and the Grenadines">St. Vincent and the Grenadines</option>
							<option value="Sudan">Sudan</option>
							<option value="Suriname">Suriname</option>
							<option value="Sweden">Sweden</option>
							<option value="Switzerland">Switzerland</option>
							<option value="Syrian Arab Republic">Syrian Arab Republic</option>
							<option value="Tajikistan">Tajikistan</option>
							<option value="Tanzania">Tanzania</option>
							<option value="Thailand">Thailand</option>
							<option value="Timor-Leste">Timor-Leste</option>
							<option value="Togo">Togo</option>
							<option value="Tonga">Tonga</option>
							<option value="Trinidad and Tobago">Trinidad and Tobago</option>
							<option value="Tunisia">Tunisia</option>
							<option value="Turkey">Turkey</option>
							<option value="Turkmenistan">Turkmenistan</option>
							<option value="Turks and Caicos Islands">Turks and Caicos Islands</option>
							<option value="Tuvalu">Tuvalu</option>
							<option value="Uganda">Uganda</option>
							<option value="Ukraine">Ukraine</option>
							<option value="United Arab Emirates">United Arab Emirates</option>
							<option value="United Kingdom">United Kingdom</option>
							<option value="United States">United States</option>
							<option value="Uruguay">Uruguay</option>
							<option value="Uzbekistan">Uzbekistan</option>
							<option value="Vanuatu">Vanuatu</option>
							<option value="Venezuela, RB">Venezuela, RB</option>
							<option value="Vietnam">Vietnam</option>
							<option value="Virgin Islands (U.S.)">Virgin Islands (U.S.)</option>
							<option value="West Bank and Gaza">West Bank and Gaza</option>
							<option value="Yemen, Rep.">Yemen, Rep.</option>
							<option value="Zambia">Zambia</option>
							<option value="Zimbabwe">Zimbabwe</option>
						</select>
						<span id="gpt_ewm_r_address_country_message"> </span>

					</div>

					<div class="gpt_ewm_wr_half_content gpt_padding_right_8">
						
						<label class="gpt_wr_lable">Team Member<span class="gpt_ewm_wr_asteric">*</span></label>

						<input name="gpt_ewm_r_team_member" id="gpt_ewm_r_team_member" placeholder="" required="" type="text">

						<span id="gpt_ewm_r_team_member_message"></span>

					</div>

					<div class="gpt_ewm_wr_half_content">

						<label class="gpt_wr_lable">Category<span class="gpt_ewm_wr_asteric">*</span></label>

						<select name="gpt_ewm_wr_category_dropdown" id="gpt_ewm_wr_category_dropdown" placeholder="" required="">

							<option value = "" >No Category</option>

							<?php 
														
							$ewm_review_categories_list_post_id = get_option('ewm_review_categories_list_post_id');

							$ewm_r_categories_list = get_post_meta( $ewm_review_categories_list_post_id, 'ewm_front_cats');

							foreach($ewm_r_categories_list as $category_k => $category_v ){

								echo '<option value = "'. $category_v .'" >'. $category_v .'</option>';

							}
							?>
						</select>

						<span id="gpt_ewm_wr_category_dropdown_message"> </span>

					</div>

					<div class="gpt_ewm_wr_half_content">
						<label class="gpt_wr_lable">Review By<span class="gpt_ewm_wr_asteric"></span></label>
						<div class="gpt_ewm_r_customer_name">
							<input type="text" id="gpt_ewm_r_customer_name" name="gpt_ewm_r_customer_name" value="">
						</div>
						<span id="gpt_ewm_r_address_zip_message"></span>
					</div>

					<div class="gpt_ewm_wr_half_content ewm_gpt_rate_display" >
						<label class="gpt_wr_lable">Rate<span class="gpt_ewm_wr_asteric"></span></label>
						<div class="gpt_wr_ewm_r_star_rating">
							<input type="range" id="ewm_r_star_rating" name="ewm_r_star_rating" min="0" max="10" value="">
							<div id="ratingOne"></div>
						</div>
						<span id="gpt_ewm_r_address_zip_message"></span>
					</div>

				</div>

				<div class="gpt_ewm_description_list">

					<div  class="gpt_half_life_description">

						<label class="gpt_wr_lable">Review Description <span class="gpt_ewm_wr_asteric">*</span> </label>
						<textarea name="gpt_ewm_r_description" id="gpt_ewm_r_description" placeholder="" required=""> </textarea>
						<span id="gpt_ewm_r_description_message"> </span>

					</div>

					<div class="gpt_half_life_description">
							
						<label class="gpt_wr_lable">Job Description<span class="gpt_ewm_wr_asteric"></span></label>
						<textarea name="gpt_ewm_r_job_description" id="gpt_ewm_r_job_description" placeholder="" required=""> </textarea>
						<span id="gpt_ewm_r_job_description_message"> </span>

					</div>

				</div>

				<div class="gpt_ewm_r_submit">
					<center>
					<input type="hidden" id="gpt_ewm_r_related_page_id" name="gpt_ewm_r_related_page_id" value="0">
					<input type="submit" value="Post Review" id="ewm_submit_worker_review">
					</center>
				</div>

			</form>
		</div>

	</div>

</div>

</div>
