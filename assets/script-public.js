jQuery(document).ready(function($) {

    $('input[type="range"]').on("change mousemove", function() {
        //alert($( this ).val());

        range_details = $( this ).val() / 2 ;

        $( '#ratingOne' ).html( range_details );

    } )

    var ewm_wr_field_details = [];

    ewm_wr_field_details[0] = {'name' : 'ewm_r_team_member' } ;
    ewm_wr_field_details[1] = {'name' : 'ewm_r_team_member' } ;
    ewm_wr_field_details[2] = {'name' : 'ewm_r_customer_name' } ;
    ewm_wr_field_details[3] = {'name' : 'ewm_r_review_title' } ;
    ewm_wr_field_details[4] = {'name' : 'ewm_r_description' } ;
    ewm_wr_field_details[5] = {'name' : 'ewm_r_related_page_id' } ;
    ewm_wr_field_details[6] = {'name' : 'ewm_r_review_date'} ;
    ewm_wr_field_details[7] = {'name' : 'ewm_r_review_address'} ;
    ewm_wr_field_details[8] = {'name' : 'ewm_r_street_address'} ;
    ewm_wr_field_details[9] = {'name' : 'ewm_wr_category_dropdown'} ;
    ewm_wr_field_details[10] = {'name' : 'ewm_r_star_rating'} ;

    // ewm_wr_field_details[1] = {'name' : 'ewm_r_job_description' } ;
    // ewm_wr_field_details[13] = {'name' : 'ewm_r_address_city'} ;
    // ewm_wr_field_details[3] = {'name' : 'ewm_r_address_country' } ;
    // ewm_wr_field_details[4] = {'name' : 'ewm_r_address_zip' } ;
    // ewm_wr_field_details[5] = {'name' : 'ewm_r_address_state' } ;
    
    function ewm_wr_check_all_fields_are_added(){

        number_of_missing_required_fields = 0;

        ewm_wr_field_details.forEach( function( field , details ){

            current_field_len = $( '#' + ewm_wr_field_details[details].name ).val().length ;

            if( current_field_len == 0 ){

                // Change the border colors
                $( '#' + ewm_wr_field_details[details].name ).css( 'border' , '1px solid darkred' );

                // Add text message
                $( '#' + ewm_wr_field_details[details].name + '_message' ).html( 'This is a required field.' ) ;

                number_of_missing_required_fields++;

            }
            
        } ) ;

        if( number_of_missing_required_fields === 0 ){

            // Send data to server
            ewm_wr_send_data_to_server();

        }

    }

    function ewm_wr_clear_fields(){

        $('#ewm_r_review_title').val('');
        $('#ewm_r_description').val('')
        $('#ewm_r_customer_name').val('');
        $('#ewm_r_review_date').val('');
        $('#ewm_r_star_rating').val('');
        $('#ewm_r_review_address').val('');
        $('#ewm_r_street_address').val('');
        $('#ewm_r_address_city').val('');
        $('#ewm_r_address_state').val('');
        $('#ewm_r_address_zip').val('');
        $('#ewm_r_address_country').val('');
        $('#ewm_r_job_description').val('');
        $('#ewm_r_team_member').val('');
        $('#ewm_wr_category_dropdown').val('');

    }

    $('#ewm_wr_notification_pop_up_close').click(function() {

        $('#ewm_wr_notification_pop_up').hide();

        $('#ewm_wr_notification_pop_up_message').html('');

    } ) ;

    var ewm_r_post_id = 0 ;

    function ewm_wr_append_html( args ){
        
        return '<div class="wr_main_review_body"> \
        <div class="wr_review_body"> \
            <div class="wr_picture_area"> \
                <img src="' + args.ewm_wr_img_file_url +'"> \
            </div> \
            <div class="wr_review_area"> \
                <div class="wr_review_first_line"> \
                    <span class="wr_review_title">'+args.ewm_r_review_title+'</span> \
                    <span class="wr_review_date">'+args.ewm_r_review_date+'</span> \
                </div> \
                <div class="wr_location_line"> \
                '+args.ewm_r_address_city+', '+args.ewm_r_address_state+', '+args.ewm_r_review_address+', '+args.ewm_r_address_zip+' </div> \
                <div> \
                <div class="wr_review_rating_string"> \
                    <div class="wr_review_stars_figure"> '+args.ewm_r_star_rating+' </div> \
                    <div class="wr_review_stars_d"> \
                        <span class="fa fa-star checked"></span><span class="fa fa-star checked"></span><span class="fa fa-star checked"></span><span class="fa fa-star-half checked"></span> \
                    </div> \
                </div> \
                </div>\
                <div class="wr_final_review_description"> \
                    '+args.ewm_r_description+'</div> \
                <div> \
                    <div class="wr_customer_detail_main_detail"> \
                        <div class="wr_face_display"> \
                            <i class="fa fa-user-circle"></i> \
                        </div> \
                        <div class="wr_review_customer_name"> \
                            <div> \
                                <span style="width:100%;">Review By:</span> \
                                <span style="width:100%;">'+args.ewm_r_customer_name+'</span> \
                            </div> \
                        </div> \
                    </div> \
                </div> \
            </div> \
        </div> \
        <div class="wr_review_cat"> \
            <h2>'+args.ewm_wr_category_dropdown+'</h2> \
            <p> '+args.ewm_r_job_description+'</p> \
                <div> \
                    <div class="wr_customer_detail_main_detail"> \
                        <div class="wr_face_display"> \
                            <i class="fa fa-user-circle"></i> \
                        </div> \
                        <div class="wr_review_customer_name"> \
                            <div> \
                                <span style="width:100%;">Job Performed by:</span> \
                                <span style="width:100%;">'+args.ewm_r_team_member+'</span> \
                            </div> \
                        </div> \
                    </div> \
                </div> \
        </div> \
    </div>';
    
    }

    function ewm_wr_send_data_to_server(){

        // show loading message
        // send data to server
        // show that the data is loading 
        $('#ewm_submit_worker_review').val('Saving review...');

        var form_data = new FormData() ;

        $("#ewn_r_work_review_next").html( "Sending..." ) ;
        form_data.append( 'action' , 'ewm_r_add_update_review_details' ) ;
        ewm_r_star_rating = $( '#ewm_r_star_rating' ).val()  / 2 ; // console.log( droppedFiles ) ;

        form_data.append( 'ewm_r_review_title' , $('#ewm_r_review_title').val() );
        form_data.append( 'ewm_r_description' , $('#ewm_r_description').val() );
        form_data.append( 'ewm_r_customer_name' , $('#ewm_r_customer_name').val() );
        form_data.append( 'ewm_r_review_date' , $('#ewm_r_review_date').val() );
        form_data.append( 'ewm_r_star_rating' , ewm_r_star_rating );
        form_data.append( 'ewm_r_review_address' , $('#ewm_r_review_address').val() );
        form_data.append( 'ewm_r_street_address' , $('#ewm_r_street_address').val() );
        form_data.append( 'ewm_r_address_city' , $('#ewm_r_address_city').val() );
        form_data.append( 'ewm_r_address_state' , $('#ewm_r_address_state').val() );
        form_data.append( 'ewm_r_address_zip' , $('#ewm_r_address_zip').val() );
        form_data.append( 'ewm_r_address_country' , $('#ewm_r_address_country').val() );
        form_data.append( 'ewm_r_job_description' , $('#ewm_r_job_description').val() );
        form_data.append( 'ewm_r_team_member' , $('#ewm_r_team_member').val() );
        form_data.append( 'ewm_wr_category_dropdown' , $('#ewm_wr_category_dropdown').val() );
        form_data.append( 'ewm_r_related_page_id' , $('#ewm_r_related_page_id').val() );
        form_data.append( 'ewm_r_post_id' , ewm_r_post_id );
        form_data.append( 'ewm_wr_img_file', droppedFiles[0] );
        // form_data.append( 'ewm_r_post_parent', $('#ewm_r_post_parent').val() );

        jQuery.ajax( {

            url: ajax_object.ajaxurl,
            type: 'post',
            contentType: false,
            processData: false,
            data: form_data,
            success: function ( response ) {
                console.log( response ) ;
                response = JSON.parse( response ) ;
                // append to the latest reviews // hide loading
                $('#ewm_wr_notification_pop_up').show() ;
                $('#ewm_wr_notification_pop_up_message').html( 'Congratulations! The review was successfully added<br><br><input type="submit" id="ewm_wr_notification_pop_up_message_ok" value="Okay">' );
                $('#ewm_wr_notification_pop_up_message_ok').click(function () {
                    $('#ewm_wr_notification_pop_up').hide();
                    $('#ewm_wr_notification_pop_up_message').html('');
                } )

                $('#ewm_submit_worker_review').val( 'Submit Review' );
                //ewm_wr_clear_fields();
                $('.ewm_r_review_list_container').prepend( ewm_wr_append_html( response.details.data ) );
            },
            error: function (response) {
                console.log( response ) ;
            }

        } ) ;

        // hide loading message and show new status

    }

    $("#ewm_submit_worker_review").click( function(e) {

        e.preventDefault();

        // Check that the fields are all filed and throw error if the field is missing
        ewm_wr_check_all_fields_are_added();

    } )

    droppedFiles = [] ;

    $('#ewm_wr_img_file').on('change',function(){

        droppedFiles = $('#ewm_wr_img_file').prop('files');

        console.log(droppedFiles);
    
    } )

    if(typeof ewm_wr_user_can_delete_worker_reviews == 'undefined'){
        ewm_wr_user_can_delete_worker_reviews = false;
    }

    function ewm_wr_edit_worker_reviews(){

        if( ewm_wr_user_can_delete_worker_reviews == false ){

            return;

        }; //

        $('.wr_main_review_body').mouseenter(function() {

            current_box_id = $(this).data('current_review_box') ;

            $( '#ewm_wr_delete_box_'+current_box_id ).show() ;

            $('#ewm_wr_whold_box_'+current_box_id).css( 'border','1px lightgray solid' ) ;

        } ).mouseleave(function() {

            current_box_id = $(this).data('current_review_box') ;

            $( '#ewm_wr_delete_box_' + current_box_id ).hide() ;

            $('#ewm_wr_whold_box_'+current_box_id).css( 'border','0px gray solid' ) ;

        } );

    }

    ewm_wr_edit_worker_reviews();
    
    $('.ewm_wr_delete_box').click( function(){

        // get the review to delete.
        current_review_box = $( this ).data( 'current_review_box' );

        // delete the review 
        // console.log( current_review_box );
        var form_data = new FormData() ;

        form_data.append( 'action' , 'ewm_wr_delete_a_worker_review' ) ;

        form_data.append( 'ewm_wr_worker_review_post_id' , current_review_box );

        jQuery.ajax( {

            url: ajax_object.ajaxurl,
            type: 'post',
            contentType: false,
            processData: false,
            data: form_data,
            success: function ( response ) {
                // console.log( response ) ;
                response = JSON.parse( response ) ;
                // append to the latest reviews
                $( '#ewm_wr_whold_box_' + current_review_box ).remove();
            },
            error: function (response) {
                console.log( response ) ;
            }
        } ) ;

    } )

    var d = new Date();

    var month = d.getMonth()+1;
    var day = d.getDate();

    var output = d.getFullYear() + '-' +
        (month<10 ? '0' : '') + month + '-' +
        (day<10 ? '0' : '') + day;

    $('#ewm_r_review_date').val(output);

    //document.getElementById('datePicker').value = new Date().toDateInputValue();

} ) ;