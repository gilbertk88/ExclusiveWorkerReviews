<style>
	.ewm_wr_chat_city_outer_wrap {
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

	.ewm_wr_chat_city_inner_wrap {
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

	.ewm_wr_chat_city_menu_wrap {
		width: 95%;
		overflow: auto;
		padding: 10px 30px 10px 10px;
		margin: 0px 0px 10px 0px;
	}
	.ewm_wr_close_city {
		float: right;
		margin: 3px 68px 3px 3px;
		border-radius: 5px;
		background-color: #ccc8 !important;
		border: 0px solid #ccc;
		padding: 10px 15px;
		cursor: pointer;
	}
	.ewm_wr_city_title_wrap{
		float: left;
		width: 95%;
		padding: 5px;
		font-size: 18px;
	}
	.ewm_wr_city_title_wrap_outer{
		border-radius:10px !important;
	}
	.ewm_wr_city_name_title{
		width: 100%;
		padding: 2px 25px !important;
		border-radius: 20px !important;
		border: 1px #ccc solid !important;
	}
	.ewm_wr_edit_area_left_city{
		float: left;
		width: 90%;
		overflow-x: scroll;
		padding: 20px;
		overflow-y: scroll;
		height: 400px;
	}
	.ewm_wr_edit_area_right_city{
		float: left;
		width: 50%;
		padding: 20px;
		background: #8ac68d24;
		border-radius: 5px;
		border: 0px solid #ccc5;
		margin: 0px;
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
		padding: 0px 15px;
		overflow: auto;
		margin: 10px;
		border: 0px solid #00ff044d;
		border-radius: 10px;
	}
	.ewm_wr_chat_outer_single_city_line{
		width: 45%;
		float: left;
		padding-right: 23px;
		height: 80px;
	}
	.ewm_wr_edit_single_c_item{
		float: right;
		border: 0px solid #feffaf;
		background-color: #feffaf;
		padding: 6px 15px;
		border-radius: 5px;
		margin-right: 5px;
		color: #333;
		cursor: pointer;
	}
	.ewm_wr_delete_single_c_item{
		cursor: pointer;
		float: right;
		color: #fff;
		background-color: #8ac68d;
		padding: 6px 15px;
		border-radius: 5px;
		margin-right: 5px;
	}
	.ewm_wr_edit_area_right_menu{
		width:95%;
		overflow:auto;
	}
	.ewm_wr_close_single_city_b{
		float: right;
		color: #333;
		background: #fff;
		border: 2px solid #8ac68d7d;
		padding: 8px 10px;
		border-radius: 5px;
	}
	.ewm_wr_save_single_b{
		background: #fff ;
		color: #333;
		padding: 10px;
		border-radius: 20px;
		margin-top:0px;
		border:2px solid #8ac68d;
	}
	.ewm_wr_description_line{
		font-size: 10px;
	}
	.ewm_wr_description_title{
		float:left;
	}
	.ewm_wr_button_new_city_item{
		float: right;
		background-color: #8EFE8D;
		border: 0px;
		color: #333;
		padding: 10px 15px;
		border-radius: 5px;
		cursor: pointer;
		margin-right: 80px;
		border: 0px;
	}
	.ewm_wr_save_single_city{
		background: #fff;
		color: #333;
		border: 2px solid #8ac68d;
		padding: 10px;
		border-radius: 10px;
		margin: 20px;
	}
</style>
<div class="ewm_wr_chat_city_outer_wrap">
	<div class="ewm_wr_chat_city_inner_wrap">
		<div class="ewm_wr_chat_city_menu_wrap">
			<input type="button" value="Close" class="ewm_wr_close_city">
		</div>
		<div class="ewm_wr_chat_city_menu_wrap ewm_wr_city_title_wrap_outer">
			<div class="ewm_wr_city_title_wrap">
				<center>Worker Review Cities</center>
			</div>
			<div class="ewm_wr_city_title_wrap"></div>
		</div>
		<div class="ewm_wr_single_line_list_item_top">
			<input type="button" class="ewm_wr_button_new_city_item" value="New City">
		</div>
		<div class="ewm_wr_edit_area_left_city">

			<?php
			$gpt_new_city = get_posts( [
				'post_type' => 'gpt_new_city',
				'post_status' => 'active',
				'posts_per_page' =>-1
			] );
			
			foreach( $gpt_new_city as $k_ => $v_ ){

				$v_ID_meta = get_post_meta( $v_->ID, "ewm_r_address_city", true );
				echo '<div class="ewm_wr_single_line_list_item ewm_wr_city_id_'. $v_->ID .'">
						<span class="ewm_wr_city_id_title_'.$v_->ID .'" ><b>'. $v_ID_meta .'</b></span>
						<span data-ewm_wr_delete_single_c_item_id="'. $v_->ID .'" class="ewm_wr_delete_single_c_item">Delete</span> 
						<span data-ewm_wr_edit_single_c_item="'. $v_->ID .'" class="ewm_wr_edit_single_c_item">Edit</span>
				</div>';

			}
			?>
		</div>
		<div class="ewm_wr_edit_area_right_city">
			<div class="ewm_wr_edit_area_right_menu">
				<input type="button" class="ewm_wr_close_single_city_b" value="Close Form">
			</div>

			<div class="ewm_wr_chat_outer_single_city_line">
				<div class="ewm_wr_chat_title">
				<div class="ewm_wr_description_title">City</div><div class="ewm_wr_description_line"><span class="ewm_wr_super">*</span></div>
				</div>
				<div class="ewm_wr_chat_input">
					<input name = "ewm_r_address_city" id = "ewm_r_address_city" placeholder = "" required type="text" >
					<span id = "ewm_r_address_city_message"></span>
				</div>
			</div>

			<div class="ewm_wr_chat_outer_single_city_line">
				<div class="ewm_wr_chat_title">
					<div class="ewm_wr_description_title">State/ Province/ Region</div>
					<div class="ewm_wr_description_line"><span class="ewm_wr_super">*</span></div>
				</div>
				<div class="ewm_wr_chat_input">
					<input name = "ewm_r_address_state" id = "ewm_r_address_state" placeholder = "" required >
					<span id = "ewm_r_address_state_message"> </span>
				</div>
			</div>

			<div class="ewm_wr_chat_outer_single_city_line">
				<div class="ewm_wr_chat_title">
					<div class="ewm_wr_description_title">ZIP/ Postal Code</div>
					<div class="ewm_wr_description_line"><span class="ewm_wr_super">*</span></div>
				</div>
				<div class="ewm_wr_chat_input">
					<input name = "ewm_r_address_zip" id = "ewm_r_address_zip" placeholder = "" required type="text" >
					<span id = "ewm_r_address_zip_message"></span>
				</div>
			</div>

			<div class="ewm_wr_chat_outer_single_city_line">
				<div class="ewm_wr_chat_title">
				<div class="ewm_wr_description_title">Country</div><div class="ewm_wr_description_line"><span class="ewm_wr_super">*</span></div>
				</div>
				<div class="ewm_wr_chat_input">
						
					<select name = "ewm_r_address_country" id = "ewm_r_address_country" placeholder = "" required >
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
						<option value="Cote d'Ivoire">"Cote d'Ivoire"</option>
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
						<option value="Korea, Dem. People's Rep">Korea, Dem. People's Rep.</option>
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
					<span id = "ewm_r_address_country_message"> </span>
				</div>
		</div>

			<div class="ewm_wr_edit_area_right_menu">
				<center><input type="button" class="ewm_wr_save_single_city" value="Save"></center>
			</div>
		</div>
	</div>
</div>
