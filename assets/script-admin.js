jQuery(document).ready(function($) {

    var range_details = 0 ;

    $('input[type="range"]').on("change mousemove", function() {

        range_details = $(this).val() ;

        $(this).next().html( range_details / 2 );

    })

    ewm_r_form_flow = {

        "ewm_r_work_review_worker"      : [ "ewm_r_worker_name"	, "ewm_r_job_description" ] ,
        "ewm_r_work_review_address"     : [ "ewm_r_city" , "ewm_r_state", "ewm_r_address" ] ,
        "ewm_r_worker_review_customer"  : [ "ewm_r_review_place" , "ewm_r_customer_name" ] ,
        "ewm_r_worker_review_main"      : [ "ewm_r_review_title" , "ewm_r_description" , "ewm_r_star_rating" ] , 
        "ewm_r_worker_review_page"      : ["ewm_r_related_page_id" ] ,
        "ewm_r_worker_review_submit"    : [ "ewm_r_review_submit" ] ,

    } ;

    var ewm_r_from_flrow_arr = [] ;

    ewm_r_from_flrow_arr[1] = {

        name            : "ewm_r_work_review_worker",
        fields          : [ "ewm_r_worker_name"	, "ewm_r_job_description" ] ,
        required_fields : [ "ewm_r_worker_name"	, "ewm_r_job_description" ]

    } ;

    ewm_r_from_flrow_arr[2] = {

        name            : "ewm_r_work_review_address",
        fields          : [ "ewm_r_city" , "ewm_r_state", "ewm_r_address" ] ,
        required_fields : [ "ewm_r_city" , "ewm_r_state", "ewm_r_address" ] 

    } ;

    ewm_r_from_flrow_arr[3] = {

        name            : "ewm_r_worker_review_customer",
        fields          : [ "ewm_r_review_place" , "ewm_r_customer_name" ] ,
        required_fields : [ "ewm_r_review_place" , "ewm_r_customer_name" ]

    } ;

    ewm_r_from_flrow_arr[4] = {

        name            : "ewm_r_worker_review_main",
        field           : [ "ewm_r_review_title" , "ewm_r_description" , "ewm_r_star_rating" ] ,
        required_fields : [ "ewm_r_review_title" , "ewm_r_description" , "ewm_r_star_rating" ]

    } ;

    ewm_r_from_flrow_arr[5] = {

        name            : "ewm_r_worker_review_page" ,
        fields          : [ "ewm_r_related_page_id" ] ,
        required_fields : [ "ewm_r_related_page_id" ]
        
    };

    var ewm_r_form_flow_stage = 1 ;

    function ewm_r_highlight_fields( field_id = '' ){

        // Add challenge message
        $( "#"+field_id+"_message" ).html( "This is a required field" ) ;

        // Change border
        $( "#"+field_id ).css( "border" , "1px solid red" );

    }

    function ewm_r_remove_focus( field_id = '' ){

        // Add challenge message
        $( "#"+field_id+"_message" ).html( "" ) ;

        // Change border
        $( "#"+field_id ).css( "border" , "1px solid gray" );

    }

    function ewm_r_confirm_that_required_fields_are_added(){

        ewm_r_required_fields = ewm_r_from_flrow_arr[ ewm_r_form_flow_stage ].required_fields ;

        number_of_missing_required_fields = [] ;
         
        $.each( ewm_r_required_fields, function( key , field_id ){

            if( $( "#"+field_id ).val().length == 0 ){

                number_of_missing_required_fields.push( field_id ) ;

                ewm_r_highlight_fields( field_id );

            }
            else{

                ewm_r_remove_focus( field_id ) ;

            }

        } ) ;

        return number_of_missing_required_fields ;

    }

    function ewm_r_update_for_last_page(){

        $('#ewn_r_work_review_next').css( 'background-color','rgb(157, 155, 155)' );

    }

    function ewm_r_move_from_first_page(){

        $('#ewm_r_work_review_pre').css( 'background-color','#0000ff' ) ;

    }

    var ewm_previous_stage_index = 1 ;

    function ewm_r_flow_move_to_next_stage( args = [] ){

        pre_array_count = args['array_count'] - 1 ;

        if( pre_array_count == args['next_stage'] ){

            $("#ewn_r_work_review_next").html( "Submit" ) ;

            // $("#ewn_r_work_review_next").addClass( 'ewn_r_work_review_next_submit' ) ;

        }

        i  = args[ 'index' ] ;

        ewm_r_form_flow_stage   = args['next_stage'] ;

        list_length             = ewm_r_from_flrow_arr.length ;

        if( list_length < i ){

            alert( 'end of details' );

            return ;

        }

        if( i == ewm_r_form_flow_stage ){

            // Display
            $( "." + ewm_r_from_flrow_arr[ i ].name ).show() ;

        }
        else{

            $( "." +  ewm_r_from_flrow_arr[ i ].name ).hide() ;

        }

        // If last page
        if( ewm_r_form_flow_stage == ewm_r_from_flrow_arr.length ){

            ewm_r_update_for_last_page() ;

        }

        // If moving away from first page
        if( ewm_r_form_flow_stage == 2 ){

            ewm_r_move_from_first_page() ;

        }

    }

    function ewm_r_listen_button_list(){

        $( "#ewn_r_work_review_next" ).click( function(e) {
            
            //. Find current stag
            // Inspect if all required fields have been input
            ewm_r_missing_required_fields = ewm_r_confirm_that_required_fields_are_added() ;

            // If everything looks good -> move to the next stage
            if( ewm_r_missing_required_fields.length == 0 ) {

                // get the next stage
                ewm_r_form_flow_stage++ ;

                // If beyond the number of page
                Arr_count       = ewm_r_from_flrow_arr.length ;

                Arr_count_loop  = Arr_count + 1 ;

                for( let i = 1 ; i < Arr_count ; i++ ) {

                    data_to_process = [] ;

                    data_to_process[ 'index' ] = i ;

                    data_to_process[ 'next_stage' ] = ewm_r_form_flow_stage ;

                    data_to_process[ 'array_count' ] = Arr_count ;

                    if( data_to_process['array_count']  == data_to_process['next_stage'] ){

                        // console.log( 'Final stage' ) ;
                        ewm_r_add_update_review() ;
                        
                        break;

                    }

                    ewm_r_flow_move_to_next_stage( data_to_process ) ;

                } ;

            } 
            // If it's the last page

        } )

        $( '#ewm_r_work_review_pre' ).click(function(e) {

            console.log( 'Current stage: ' + ewm_r_form_flow_stage ) ;

            // Find current stage
            if( ewm_r_form_flow_stage == 1 ){

                console.log('It is at the first page.');

            }
            else{

                if( ewm_r_form_flow_stage == 1 ){

                    // make the button gray
                    $('#ewm_r_work_review_pre').css('background', 'background-color: rgb(157, 155, 155);' ) ;

                }

                ewm_r_form_flow_stage-- ;

                // Get the next stage
                // If beyond the number of page
                Arr_count       = ewm_r_from_flrow_arr.length ;

                Arr_count_loop  = Arr_count + 1 ;

                for( let i = 1 ; i < Arr_count ; i++ ) {

                    data_to_process = [] ;

                    data_to_process[ 'index' ] = i ;

                    data_to_process[ 'next_stage' ] = ewm_r_form_flow_stage ;

                    data_to_process[ 'array_count' ] = Arr_count ;

                    if( data_to_process['array_count']  == data_to_process['next_stage'] ){

                        // console.log( 'Final stage' ) ;
                        ewm_r_add_update_review() ;
                        
                        break;

                    }

                    ewm_r_flow_move_to_next_stage( data_to_process ) ;

                } ;

            } 
            // If it's the last page


        } );

        $( '#ewm_r_add_new_review' ).click(function (e) {

            e.preventDefault() ;

            ewm_r_form_flow_stage = 1 ;

            // Display popup
            ewm_r_display_popup() ;

        } ) ;

        $(".ewm_r_close_box_review").click( function(e){ 
            
            ewm_r_close_box_review(e) ;

        } ) ;

    }

    ewm_r_listen_button_list() ;

    ewm_r_close_box_review = function( e ) {

        e.preventDefault();

        $(".ewm_r_dark_background_review").hide();

        $('#ewm_r_post_id').val('0') ; 

        $("#ewn_r_work_review_next").html( "Next >> " ) ;

        
        // Get the next stage
        ewm_r_form_flow_stage   =   1 ;

        // If beyond the number of page
        Arr_count       = ewm_r_from_flrow_arr.length ;

        Arr_count_loop  = Arr_count + 1 ;

        for( let i = 1 ; i < Arr_count ; i++ ) {

            data_to_process = [] ;

            data_to_process[ 'index' ] = i ;

            data_to_process[ 'next_stage' ] = ewm_r_form_flow_stage ;

            data_to_process[ 'array_count' ] = Arr_count ;

            ewm_r_flow_move_to_next_stage( data_to_process ) ;

        } ;

        $( '#ewm_r_worker_name' ).val('') ;
        $( '#ewm_r_job_description' ).val('') ;
        $( '#ewm_r_post_id' ).val('') ;
        $( '#ewm_r_city' ).val('') ;
        $( '#ewm_r_state' ).val('') ;
        $( '#ewm_r_address' ).val('') ;
        $( '#ewm_r_review_place' ).val('') ;
        $( '#ewm_r_customer_name' ).val('') ;
        $( '#ewm_r_review_title' ).val('') ;
        $( '#ewm_r_description' ).val('') ;
        $( '#ewm_r_star_rating' ).val('') ;
        $( '#ewm_r_related_page_id' ).val('') ;
        $( '#ewm_r_review_submit' ).val('') ;

    } ;

    function ewm_r_display_popup() {

        $("#ewm_r_work_review_pre").css( "background-color" , "#9d9b9b" ) ;

        $(".ewm_r_dark_background_review").show() ;

    }

    function ewm_r_check_that_required_fields_are_filled() { }

    function ewm_r_update_worker_review_state(){}

    function ewm_r_add_list_item( args = {} ){

        return ' <tr id="post-' + args.post_id + ' " class="iedit author-self level-0 post-' + args.post_id + '  type-page status-publish hentry entry woo_c_review_id-' + args.post_id + ' "> \
            <td class="title column-title has-row-actions column-primary page-title" data-colname="Title"> \
                Worker: <b>' + args.details.worker_name + ' </b><br> \
                Position: <b>' + args.details.job_description + '</b> <br><br>\
                Author - ' + args.details.author_name + ' \
            </td> \
            <td scope="col" id="author" class="manage-column column-author"> \
            ' + args.details.city + ' <br> ' + args.details.state + ' <br> ' + args.details.address + ' <br> \
            </td> \
            <td> \
                ' + args.details.review_place + ' \
            </td> \
            <td> \
                ' + args.details.customer_name + ' \
            </td> \
            <td> \
                <b>'+ args.details.review_title +'</b><br> ' + args.details.description + ' <br>' + args.details.star_rating + ' \
            </td> \
            <td> \
                ' +  args.details.related_page_id + ' \
            </td> \
            <td class="date column-date" data-colname="Date"> \
                <span data-reviewid="' + args.post_id + '" class="ewm_r_edit_review" id="wr_edit_button_' + args.post_id + '">Edit</span> \
                <span data-reviewid="' + args.post_id + '" class="ewm_r_delete_review" id="wr_delete_' + args.post_id + ' ">Delete</span> \
            </td> \
        </tr>' ;
        
        ewm_r_listen_button_list() ;

    }

    $('.ewm_r_edit_review').click(function( e ) {

        e.preventDefault();
    
        // alert('Edit click:' + $( this ).data('reviewid') ) ;
        ewm_r_form_flow_stage = 1 ;

        // Set the state of the post being edited
        ewm_r_porpulate_edit_field( $( this ).data('reviewid') ) ; 
        
        // Fill the fields on the inputs

        // On edit on the server, edit on the client

        // 

        $(".ewm_r_dark_background_review").show() ;

    } ) ;

    function ewm_r_delete_list_item( post_id_item = '' ){

        var form_data = new FormData() ;

        $("#wr_delete_" + post_id_item ).html( "Deleting..." ) ;
        
        form_data.append( 'action' , 'ewm_r_delete_review_item' ) ;

        form_data.append( 'ewm_wr_cat_post_id' , ewm_review_categories_list_post_id ) ;

        form_data.append( "ewm_wr_category_f" , $('#ewm_wr_category_f').val() );
        
		form_data.append( "ewm_wr_action_type" , $('#ewm_wr_action_type').val() );

        jQuery.ajax( {

            url: ajax_object.ajaxurl,

            type: 'post',

            contentType: false,

            processData: false,

            data: form_data,

            success: function ( response ) {

                console.log( response ) ;

                response = JSON.parse( response ) ; 

                $( "#post-" + response.post_id ).remove() ;

            },

            error: function (response) {

                console.log( response ) ;

            }

        } ) ;

    }

    $( '.ewm_r_delete_review' ).click( function () {

        ewm_r_delete_list_item( $( this ).data('reviewid') ) ;

    } )

    function ewm_r_porpulate_edit_field( post_value_ID = '' ){

        // Add hidden  fields and update fields
        current_val =  ewm_r_post_date[ post_value_ID ] ;


        range_details = current_val.star_rating * 2 ;


        $("#ewm_r_worker_name").val( current_val.worker_name ) ;
		
        $("#ewm_r_job_description").val( current_val.job_description ) ;

        $("#ewm_r_city").val( current_val.city ) ;

        $("#ewm_r_state").val( current_val.state ) ;

        $("#ewm_r_address").val( current_val.address ) ;

        $("#ewm_r_review_place").val( current_val.review_place ) ;

        $("#ewm_r_customer_name").val( current_val.customer_name ) ;

        $("#ewm_r_review_title").val( current_val.review_title ) ;

        $("#ewm_r_description").val( current_val.description ) ;
        
        $("#ewm_r_star_rating").val( range_details ) ;

        $("#ratingOne").html( ( range_details / 2 ) ) ;

        $("#ewm_r_related_page_id" ).val( current_val.related_page_id ) ;

        $("#ewm_r_post_id").val( current_val.woo_c_post_id ) ;

    }

    function ewm_r_edit_list_time( args = '' ) {

        edit_post_id = args.post_id ;

        // Update each fields.
        $("#wr_edit_worker_name_" + edit_post_id ).html( args.details.worker_name );

        $("#wr_edit_job_description_" + edit_post_id ).html( args.details.job_description );
        
        $("#wr_edit_author_name_" + edit_post_id ).html( args.details.author_name );

        $("#wr_edit_city_" + edit_post_id ).html( args.details.city );

        $("#wr_edit_state_" + edit_post_id ).html( args.details.state );

        $("#wr_edit_address_" + edit_post_id ).html( args.details.address );

        $("#wr_edit_review_place_" + edit_post_id ).html( args.details.review_place );

        $("#wr_edit_customer_name_" + edit_post_id ).html( args.details.customer_name );

        $("#wr_edit_review_title_" + edit_post_id ).html( args.details.review_title );

        $("#wr_edit_descripition_" + edit_post_id ).html( args.details.description );

        $("#wr_edit_star_rating_" + edit_post_id ).html( args.details.star_rating );
        
        $("#wr_edit_related_page_id_" + edit_post_id ).html( args.details.related_page_id );

    }
    
    function ewm_r_add_update_review() {

        var form_data = new FormData() ;

        $("#ewn_r_work_review_next").html( "Sending..." ) ;
        form_data.append( 'action' , 'ewm_r_add_update_review_details' ) ;
        ewm_r_star_rating = $( '#ewm_r_star_rating' ).val() / 2 ;

        form_data.append( 'ewm_r_worker_name'       , $( '#ewm_r_worker_name' ).val() ) ;
        form_data.append( 'ewm_r_job_description'   , $( '#ewm_r_job_description' ).val() ) ;
        form_data.append( 'ewm_r_value_post_author' , '' ) ; // Update on server side
        form_data.append( 'ewm_r_post_id'           , $('#ewm_r_post_id').val() ) ;
        form_data.append( 'ewm_r_city'              , $( '#ewm_r_city' ).val() ) ;
        form_data.append( 'ewm_r_state'             , $( '#ewm_r_state' ).val() ) ;
        form_data.append( 'ewm_r_address'           , $( '#ewm_r_address' ).val() ) ;
        form_data.append( 'ewm_r_review_place'      , $( '#ewm_r_review_place' ).val() ) ;
        form_data.append( 'ewm_r_customer_name'     , $( '#ewm_r_customer_name' ).val() ) ;
        form_data.append( 'ewm_r_review_title'      , $( '#ewm_r_review_title' ).val() ) ;
        form_data.append( 'ewm_r_description'       , $( '#ewm_r_description' ).val() ) ;
        form_data.append( 'ewm_r_star_rating'       , ewm_r_star_rating ) ;
        form_data.append( 'ewm_r_related_page_id'   , $( '#ewm_r_related_page_id' ).val() ) ;

        jQuery.ajax( {

            url: ajax_object.ajaxurl,

            type: 'post',

            contentType: false,

            processData: false,

            data: form_data,

            success: function ( response ) {

                console.log( response ) ;

                response = JSON.parse( response ) ; 

                $(".ewm_r_dark_background_review").hide();

                $("#ewn_r_work_review_next").html( "Next >> " ) ;

                if( response.post_is_new == true ){

                    $('.ewm_r_review_list_container').prepend( ewm_r_add_list_item( response ) ) ;

                }
                else{ 

                    ewm_r_edit_list_time( response ) ;

                }

                // Get the page
                // $("#hl_display_page").html( '<a href="'+ response.guid + '" >' + response.post_title + ' </a>' ) ;

                // $("#iframe_submit").attr( 'value', 'Save Changes' ) ;

                // $("#hl_update_progress").html('Saving successful!');

                // $(".wt_dark_background_company" ).hide() ;

            },

            error: function (response) {

                console.log( response ) ;

            }

        } ) ;

    }

    $('.ewm_manage_l_items_edit').click(function(){

        //todo do popup that does edit
        $('#ewm_wr_light_overlay').show();

        $('#ewm_wr_category_f').val( $( this ).data('cat_name_details') );

        $('#ewm_wr_header_text').html('Add Category');

        $('#ewm_wr_action_type').val( $( this ).data('cat_name_details') );

        ewm_wr_category_edit_id = $(this).data('ewm_cat_edit') ; 

        //todo populate from html

    } ) ;

    var ewm_cat_delete ; 

    function ewm_wr_delete_cat_review(  ewm_wr_category_f ) {
        
        var form_data = new FormData() ;

        $("#ewn_r_work_review_next").html( "..." ) ;
        
        form_data.append( 'action' , 'ewm_wr_delete_cat_review' ) ;

        form_data.append( 'ewm_wr_cat_post_id' , ewm_review_categories_list_post_id ) ;

        form_data.append( "ewm_wr_category_f" , ewm_wr_category_f );


        jQuery.ajax( {

            url: ajax_object.ajaxurl,

            type: 'post',

            contentType: false,

            processData: false,

            data: form_data,

            success: function ( response ) {

                $('#ewm_r_single_cat_'+ewm_cat_delete ).remove() ;

            },

            error: function (response) {

                console.log( response ) ;

            }

        } ) ;

    }

    var ewm_wr_category_edit_id = 'xx'; 

    $( '.ewm_manage_l_items_delete' ).click(function(){

        // todo remove in server        
        ewm_wr_category_f = $( this ).data('cat_name_details') ;

        ewm_cat_delete = $(this).data('ewm_cat_delete') ; 

        ewm_wr_delete_cat_review(  ewm_wr_category_f );

    } ) ;

    $('#ewm_wr_close_popup').click(function(){

        $('#ewm_wr_light_overlay').hide();

        $('#ewm_wr_category_f').val('');

        $('.ewm_wr_cat_message').html('');

        $( '#ewm_wr_category_f').css('border','1px solid #8c8f94') ;


    })

    $('#ewm_review_add_cat').click(function(){

        $('#ewm_wr_light_overlay').show();

        $('#ewm_wr_category_f').val('');

        $('#ewm_wr_header_text').html('Add Category');

        $('#ewm_wr_action_type').val('add');

    } )

    function ewm_wr_add_category_item( args = {} ){

        $( '#ewm_wr_light_overlay' ).hide();

        latest_cat_key_id = latest_cat_key_id + 1;

        return '<div class="ewm_r_single_cat" data-single-cat="'+latest_cat_key_id+'" id="ewm_r_single_cat_'+latest_cat_key_id+'">\
            <div class="ewm_r_cat_name" id="ewm_r_cat_name_'+latest_cat_key_id+'"> '+ args.ewm_wr_category_f +'</div>\
            <div class="ewm_manage_l_items"><span class="ewm_manage_l_items_edit" data-ewm_cat_edit="'+latest_cat_key_id+'" data-cat_name_details="'+ args.ewm_wr_category_f +'" id="ewm_wr_cat_edit_'+latest_cat_key_id+'" >Edit</span> | \
            <span class="ewm_manage_l_items_delete" data-ewm_cat_delete="'+latest_cat_key_id+'" data-cat_name_details="'+ args.ewm_wr_category_f +'" id="ewm_wr_cat_delete_'+latest_cat_key_id+'" >Delete</span></div>\
        </div>';

    }

    function ewm_wr_edit_category_item( args ){

        // return

        $( '#ewm_wr_light_overlay' ).hide();

        cat_key = args.ewm_wr_local_index ; 

        $( '#ewm_r_cat_name_'+cat_key ).html( args.ewm_wr_category_f );

        $( "#ewm_wr_cat_edit_" + cat_key).attr('data-cat_name_details','tt');

        $( "#ewm_wr_cat_delete_" + cat_key).attr('data-cat_name_details','tt');

    }

    $( '#ewm_wr_submit_button_send').click(function(){

        if( $('#ewm_wr_category_f').val().length == 0 ){

            $('.ewm_wr_cat_message').html('Please fill in the above required field') ;

            $( '#ewm_wr_category_f').css('border','1px solid darkred') ;

            return;

        }

        $('.ewm_wr_cat_message').html('');

        $( '#ewm_wr_category_f').css('border','1px solid #8c8f94') ;

        var form_data = new FormData() ;

        form_data.append( 'action' , 'ewm_wr_add_edit_category' ) ;

        form_data.append( 'ewm_wr_cat_post_id' , ewm_review_categories_list_post_id ) ;

        form_data.append( "ewm_wr_category_f" , $('#ewm_wr_category_f').val() );
        
		form_data.append( "ewm_wr_action_type" , $('#ewm_wr_action_type').val() );

        form_data.append( "ewm_wr_local_index" , ewm_wr_category_edit_id );

        jQuery.ajax( {

            url: ajax_object.ajaxurl,

            type: 'post',

            contentType: false,

            processData: false,

            data: form_data,

            success: function ( response ) {

                console.log( response ) ;

                response = JSON.parse( response ) ; 

                if( response.ewm_wr_action_type == 'add' ){

                    $('.ewm_r_main_container_div').append( ewm_wr_add_category_item( response ) ) ;

                }
                else{ 

                    ewm_wr_edit_category_item( response ) ;

                }

            },

            error: function (response) {

                console.log( response ) ;

            }

        } ) ;

    })

    $(".ewm_wrchatgpt_menu_l_s").click(function() {

        $( this ).css({
            'border':'1px solid #333'
        });
        $(".ewm_wrchatgpt_menu_r_s").css({
            'border':'1px solid #fff',
        });
        $('.ewm_wrchatgpt_no_keyword_selected').show();
        $('.ewm_wrchatgpt_generate_long_tails').hide();

    });

    $(".ewm_wrchatgpt_menu_r_s").click(function() {
        ewm_wr_save_chatgpt_values();
    });

    $('.ewm_wrchatgpt_background_inner_close').click(function () {
        $( '.ewm_wrchatgpt_background_main' ).hide();
        $( '.ewm_wr_autoselection_left' ).click();
    });

    var ewm_wr_update_chatgpt_request = function ( data_list ){

        var form_data = new FormData();

        form_data.append( 'action' , 'ewm_wr_update_chatgpt_request' ); // form_data.append( 'ewm_wr_chatgpt_quote' , $("#ewm_wr_chatgpt_quote").val() );
        
        form_data.append( 'ewm_wr_chatgpt_daily' , data_list.daily_past_reviews );
        form_data.append( 'ewm_wr_chatgpt_instant' , data_list.ewm_wr_chatgpt_instant ); // form_data.append( 'ewm_wr_chatgpt_number_of_reviews' , data_list.Number_of_Reviews );
        form_data.append( 'ewm_wrchatgpt_page_id' , $("#ewm_wrchatgpt_page_id").val() );
        form_data.append( 'ewm_wrchatgpt_search_id' , $("#ewm_wrchatgpt_search_id").val() );
        form_data.append( 'ewm_wrchatgpt_group_list' , data_list.group_list );
        form_data.append( 'ewm_wr_chatgpt_city' , data_list.ewm_wr_chatgpt_city );

        jQuery.ajax( {

            url: ajax_object.ajaxurl,
            type: 'post',
            contentType: false,
            processData: false,
            data: form_data,
            success: function ( response ) {        
                console.log( response ) ;
                response = JSON.parse( response ) ; 
                $( '#ewm_search_post_id' ).val( response.search_post_id );
                $('.ewm_wr_chatgpt_input_next').val( 'Saving Chatgpt Automation Settings' );
            },
            error: function (response) {
                console.log( response ) ;
            }

        } ) ;

    }

    var ewm_wr_save_group_item = function (){

        $("#ewm_wr_gpt_review_title").val();
        $("#ewm_wr_gpt_customer_name").val();
        $("#ewm_wr_gpt_rating").val();
        $("#ewm_wr_gpt_address").val();
        $("#ewm_wr_gpt_category").val();
        $("#ewm_wr_gpt_job_description").val();
        $("#ewm_wr_gpt_team_member").val();

    }

    var ewm_wr_clear_new_group_item = function ( $args = [] ){

        $("#ewm_wr_gpt_review_title").val('');
        $("#ewm_wr_gpt_customer_name").val('');
        $("#ewm_wr_gpt_rating").val('');
        $("#ewm_wr_gpt_address").val('');
        $("#ewm_wr_gpt_category").val('');
        $("#ewm_wr_gpt_job_description").val('');
        $("#ewm_wr_gpt_team_member").val('');

        $('.ewm_wr_edit_area_left').css({ 'width': '40%' });
        $('.ewm_wr_edit_area_right').css({ 'width': '50%' });
        $('.ewm_wr_edit_area_right').show();

    }

    var ewm_wr_clear_new_city_item = function ( $args = [] ){
        $('.ewm_wr_edit_area_left_city').css({ 'width': '40%' });
        $('.ewm_wr_edit_area_right_city').css({ 'width': '50%' });
        $('.ewm_wr_edit_area_right_city').show();

        $("#ewm_r_address_city").val( '' );
        $("#ewm_r_address_state").val( '' );
        $("#ewm_r_address_zip").val( '' );
        $("#ewm_r_address_country").val( '' );
        $("#ewm_wr_button_new_city_item").val( 0 );

    }

    $('.ewm_wr_button_new_city_item').click( function(){

        // $('.ewm_wr_city_edit_id').val(0);
        $("#ewm_wr_button_new_city_item").val(0) 
        ewm_wr_clear_new_city_item();

    } );

    var ewm_wr_update_cities = function( gpt_city_list ) {

        //console.log( gpt_city_list ); 

        city_list = '<div class="ewm_wr_chat_input"> \
            <select class="" type="checkbox" id="ewm_wr_chatgpt_city">\
                <option value="">Select a City</option> ';

        gpt_city_list.forEach(element => {

            console.log(element);
            city_list  = city_list + '<option value="'+ element.id +'">'+ element.name +'</option> ';
            
        });

        city_list  = city_list + '</select> \
            <input type="button" id="ewm_wr_chatgpt_cities" value="Manage Cities"> \
        </div>';

        $( '.ewm_wr_chat_input_city' ).html( city_list );

        $('#ewm_wr_chatgpt_cities').click(function(){
            $('#city_before_edit').val( $('#ewm_wr_chatgpt_city').val() );
            $('.ewm_wr_chat_city_outer_wrap').show();
        })

    }

    $('#ewm_wr_chatgpt_cities').click(function(){
        $('#city_before_edit').val( $('#ewm_wr_chatgpt_city').val() );
        $('.ewm_wr_chat_city_outer_wrap').show();
    })

    $('.ewm_wr_close_city').click(function(){

        $('.ewm_wr_chat_city_outer_wrap').hide();

        var form_data = new FormData();
        form_data.append( 'action' , 'ewm_wr_close_city' );
        form_data.append( 'city_before_edit' , $('#city_before_edit').val() );

        jQuery.ajax( {
            url: ajax_object.ajaxurl,
            type: 'post',
            contentType: false,
            processData: false,
            data: form_data,
            success: function ( response ) {
                // console.log( response );
                //$('#ewm_search_post_id').val( response.search_post_id );
                response = JSON.parse( response ) ; 
                ewm_wr_update_cities( response.gpt_city_list );
                // gpt_city_list
                $('#ewm_wr_chatgpt_city').val( response.city_before_edit );

                console.log( response );

            },
            error: function (response) {

                console.log( response ) ;

            }
        } ) ;

    })

    $('.ewm_wr_button_new_group_item').click( function(){
        $('#ewm_wrchatgpt_group_item_id').val( 0 );
        ewm_wr_clear_new_group_item();
    } );

    var ewm_wr_save_chatgpt_values = function () { // $Number_of_Reviews = $('#ewm_wr_chatgpt_number_of_reviews').val();

        $daily_past_reviews =  $( '#ewm_wr_chatgpt_daily' ).is( ':checked' );
        ewm_wr_chatgpt_instant = true; //$( '#ewm_wr_chatgpt_instant' ).is( ':checked' );
        ewm_wr_chatgpt_city = $('#ewm_wr_chatgpt_city').val(); //

        $group_list = '';

        $('.ewm_wr_chat_cat_inline').each( function () {

            ewm_group_selected = $( this ).data( 'ewm_group_selected' );
            if( ewm_group_selected == 1 ){
                ewm_group_id = $( this ).data( 'ewm_group_id' );
                $group_list = $group_list + ewm_group_id + ', ' ;
            }

        } );

        ewm_looks_good = true ;

        /*
            if( $("#ewm_wr_chatgpt_number_of_reviews").val().length == '0' ){
                ewm_looks_good = false;
                $(".ewm_wr_chatgpt_number_of_reviews_message").html('Field required, please fill it up.');
            } 
        */

        if( ewm_looks_good == true ){

            $(".ewm_wr_chatgpt_number_of_reviews_message").html('');
            ewm_wr_update_chatgpt_request( { // 'Number_of_Reviews' : $Number_of_Reviews,
                'daily_past_reviews' : $daily_past_reviews,
                'group_list' : $group_list,
                'ewm_wr_chatgpt_instant' : ewm_wr_chatgpt_instant,
                'ewm_wr_chatgpt_city' : ewm_wr_chatgpt_city
            } );

        }

    }

    $('.ewm_wr_chatgpt_input_next').click( function () {

        $('.ewm_wr_chatgpt_input_next').val( 'Saving Settings...' );

        ewm_wr_save_chatgpt_values();

    } );

    var ewm_gpt_populate_group_append = function ( response_data ) {
        
        // class_detail = $(".ewm_wr_chat_cat_inline"); // ob_len = class_detail.length
        //class_detail.each(function(i, obj) {
            // console.log( $( obj ).data('ewm_group_id') ); // console.log( $( obj ).data('ewm_group_selected') );
            // $( obj ).attr({'data-ewm_group_selected': 0}); //,
            // $( obj ).attr({'border' : '2px solid #fff'});
        //} );
        // ta-ewm_group_selected="0" // ata-ewm_group_id="4765" // Number of Reviews per Page * // alert('hallo world');

        console.log( response_data );
        response_data.forEach( ( element ) => { // console.log( element );
            if( element.trim() !== '' ) {
                trim_details =  element.trim(); // 

                console.log( 'element' ); 
                console.log( trim_details );

                // $( "#ewm_wr_chat_cat_inline_"+trim_details ).click();

                $( "#ewm_wr_chat_cat_inline_"+trim_details ).attr( 'data-ewm_group_selected',1 );
                $( "#ewm_wr_chat_cat_inline_"+trim_details ).css('border','2px solid rgb(51, 51, 51' );
                
            }

        } );

        // Delete past worker reviews on each page:
        // Select Group

    }

    var ewm_gpt_populate_group = function ( group_id ) {

        var form_data = new FormData();
        form_data.append( 'action', 'ewm_gpt_populate_group' );
        form_data.append( 'ewm_wr_page_id' , group_id );

        jQuery.ajax( {
            url: ajax_object.ajaxurl,
            type: 'post',
            contentType: false,
            processData: false,
            data: form_data,
            success: function ( response ) { // console.log( response );
                response = JSON.parse( response ); // console.log();
                ewm_gpt_populate_group_append( response.gpt_select_group );

                if( 'true' == response.ewm_wr_chatgpt_daily ){
                    if( $( '#ewm_wr_chatgpt_daily' ).is( ':checked' ) !== true ){
                        $('#ewm_wr_chatgpt_daily').click();
                    }
                } // 
                else{
                    if( $( '#ewm_wr_chatgpt_daily' ).is( ':checked' ) == true ){
                        $('#ewm_wr_chatgpt_daily').click();
                    }
                }

                console.log( 'ewm_wr_chatgpt_city' );
                console.log( response.ewm_wr_chatgpt_city );
                $('#ewm_wr_chatgpt_city').val( response.ewm_wr_chatgpt_city );

            },
            error: function (response) {
                console.log( response ) ;
            }
        } );

    } // var ewm_load_group_selected = function( args = {} ) {}

    $('.ewm_manage_l_items_generate_chatgpt').click( function () {

        ewm_chatgpt_id = $( this ).data('ewm_chatgpt');
        ewm_chatgpt_search_id = $( this ).data('ewm_chatgpt_search');

        $('.ewm_wrchatgpt_background_main').show();
        $('#ewm_wrchatgpt_page_id').val( ewm_chatgpt_id );
        $( "#ewm_wrchatgpt_search_id" ).val( ewm_chatgpt_search_id );
        $('#gpt_ewm_wr_new_file_exist').val(0)
        $( '.ewm_single_review_title' ).html( '<center>' + $( "#ewm_r_cat_name_" + ewm_chatgpt_id ).html() + '</center>' );

        $( '.ewm_wr_chat_cat_inline' ).attr( 'data-ewm_group_selected', '0' ); //,
        $( '.ewm_wr_chat_cat_inline' ).css( 'border', '2px solid #fff' );

        // group populate
        ewm_gpt_populate_group( ewm_chatgpt_id );

        // manage views
        $('.ewm_wr_sing_group_edit').hide();
        $('.ewm_wr_sing_group_delete').hide();
        $('.ewm_wr_chat_group_outer_wrap').hide();

    } )

    $('.ewm_wr_delete_single_c_item').click(function(e) {

        var form_data = new FormData();
        form_data.append( 'action' , 'ewm_wrchatgpt_del_city' );
        form_data.append( 'ewm_city_id' , $( this ).data( 'ewm_wr_delete_single_c_item_id' ) ); // data-ewm_wr_delete_single_c_item_id

        jQuery.ajax( {
            url: ajax_object.ajaxurl,
            type: 'post',
            contentType: false,
            processData: false,
            data: form_data,
            success: function ( response ) { // 
                console.log( response ) ;
                response = JSON.parse( response );

                $( '.ewm_wr_city_id_'+response.post_deleted ).remove();
            },
            error: function (response) {
                console.log( response );
            }
        } ) ;
        
    } )

    $('.ewm_wrchatgpt_generate_worker_review_button').click(function () {

        var form_data = new FormData();
        form_data.append( 'action' , 'ewm_wrchatgpt_generate_worker_review_button' );
        // form_data.append( 'ewm_wr_chatgpt_quote' , $("#ewm_wr_chatgpt_quote").val() );
        // form_data.append( 'ewm_wr_chatgpt_delete' , $("#ewm_wr_chatgpt_delete").val() );
        // form_data.append( 'ewm_wr_chatgpt_number_of_reviews' , $("#ewm_wr_chatgpt_number_of_reviews").val() );
        // form_data.append( 'ewm_wrchatgpt_page_id' , $("#ewm_wrchatgpt_page_id").val() );

        jQuery.ajax( {
            url: ajax_object.ajaxurl,
            type: 'post',
            contentType: false,
            processData: false,
            data: form_data,
            success: function ( response ) {
                console.log( response ) ;                
                $('#ewm_search_post_id').val( response.search_post_id );
            },
            error: function (response) {

                console.log( response ) ;

            }
        } ) ;

    })

    var ewm_change_group_names = function(){

        ewm__group_id = $( '#ewm_wrchatgpt_group_id' ).val();
        ewm_group_name__ = $('.ewm_wr_group_name_title').val();

        $( '#ewm_wr_chat_cat_inline_' + ewm__group_id ).html( ewm_group_name__ );

    }

    var ewm_wr_listen_to_edit_del = function( ewm_group = [] ){

        $('.ewm_wr_sing_group_edit').click( function() {

            $('.ewm_wr_chat_group_outer_wrap').show();
            ewm_group_id = $( this ).data( 'ewm_group_id' ); 
            $('.ewm_wrchatgpt_group_id').val( ewm_group_id );
            ewm_wr_gpt_fill_fields( ewm_group_id );

            $('#ewm_wr_edit_area_left').css( 'width','90%' );
            $('#ewm_wr_edit_area_right').css( 'display', 'none' );

        } );

        $('.ewm_wr_sing_group_delete').click( function( event ) {
            ewm_group_id = $(this).data( 'ewm_group_id' ) ;
            ewm_wr_sing_group_delete( ewm_group_id );    
        } )

    }
    
    var ewm_new_group_names = function(){ // $('ewm_wr_chat_cat_inline')

        ewm__group_id = $( '#ewm_wrchatgpt_group_id' ).val();
        ewm_group_name__ = $('.ewm_wr_group_name_title').val();

        ewm_group_name = '<div class="ewm_wr_chat_group_top" id="ewm_wr_chat_group_top_'+ewm__group_id+'" > \
            <div class="ewm_wr_chat_cat_inline" id="ewm_wr_chat_cat_inline_'+ewm__group_id+'" data-ewm_group_selected="0" data-ewm_group_id="'+ewm__group_id+'" border="2px solid #fff">'+ewm_group_name__+'</div> \
            <div class="ewm_wr_chat_edit_cat_inline"> \
                <span class="ewm_wr_sing_group_edit" id="ewm_wr_sing_group_edit_'+ewm__group_id+'" data-ewm_group_id="'+ewm__group_id+'" style="display: none;">Edit</span> \
                <span class="ewm_wr_sing_group_delete" data-ewm_group_id="'+ewm__group_id+'" style="display: none;">Delete</span> \
            </div> \
        </div>';
        $('.ewm_wr_chat_g_list').append( ewm_group_name );

        ewm_wr_listen_to_edit_del();

    }

    var ewm_update_group_names = function (){ // if is new // => create group // else // => update group 
        if( $('#ewm_wr_group_is_new').val() == 'is_new' ){            
            ewm_new_group_names();
        }
        else{
            ewm_change_group_names();
        }

        $('#ewm_wr_group_is_new').val('none');

    }

    $('.ewm_wr_close_group').click(function() {

        ewm_update_group_names()
        $('.ewm_wr_chat_group_outer_wrap').hide();

        $('.ewm_wr_edit_area_left').css( 'width','90%' );
        $('.ewm_wr_edit_area_right').css( 'display', 'none' );

    } );

    var ewm_wrchatgpt_new_group_id = function(){

        var form_data = new FormData();
        form_data.append( 'action' , 'ewm_wrchatgpt_new_group_id' );
        form_data.append( 'group_parent_id', $('#ewm_wrchatgpt_page_id').val() );

        jQuery.ajax({
            url: ajax_object.ajaxurl,
            type: 'post',
            contentType: false,
            processData: false,
            data: form_data,
            success: function ( response ) {
                // console.log( response ) ;
                response = JSON.parse(response) ;
                $('#ewm_wrchatgpt_group_id').val( response.new_gpt_group_id );
                // console.log( response.new_gpt_group_id );
                // console.log( 'group id' );
                // console.log( $( '#ewm_wrchatgpt_group_id' ).val() );
            },
            error: function (response) {
                console.log( response ) ;
            }
        });
    }

    var ewm_wr_new_chatgpt_group = function( args ){ // establish gpt group is = 0

        $('#ewm_wrchatgpt_group_id').val('0');
        $('.ewm_wr_edit_area_left').html('');
        $('.ewm_wr_edit_area_right').hide();
        $('.ewm_wr_edit_area_left').css({'width': '90%'});
        $('#ewm_wr_group_is_new').val( 'is_new' );
        $('.ewm_wr_group_name_title').val('');
        $('.ewm_wr_sing_group_edit').hide();
        $('.ewm_wr_sing_group_delete').hide();

        // create gpt group draft
        ewm_wrchatgpt_new_group_id();  // on typing group title

    }

    $('.ewm_wr_chat_new_groups').click(function() {

        $('.ewm_wr_chat_group_outer_wrap').show();
        //ewm_wr_chat_manage_groups
        ewm_wr_new_chatgpt_group();

    } );

    $('.ewm_wr_chat_edit_groups').click(function(){

        $('.ewm_wr_sing_group_edit').toggle();
        $('.ewm_wr_sing_group_delete').toggle();

    } );

    var ewm_wrchatgpt_list_item_group_data = function( list ){

        $('.ewm_wr_edit_area_left').html('') ; // console.log( list ); //list.each(function(i, obj) {        //test  //});

        for ( let x in list ) { // console.log(x + ": "+ list[x])
            $('.ewm_wr_edit_area_left').append(
            '<div class="ewm_wr_single_line_list_item ewm_wr_group_wrap_g_item_'+ list[x].ID +'">\
                <span class="ewm_wr_group_single_g_item_'+ list[x].ID +'">'+ list[x].post_title +' </span> \
                <span data-ewm_wr_delete_single_g_item_id="'+ list[x].ID +'" class="ewm_wr_delete_single_g_item">Delete</span> \
                <span data-ewm_wr_edit_single_g_item="'+ list[x].ID +'" class="ewm_wr_edit_single_g_item">Edit</span>\
            </div>' );
        }

    }

    var ewm_wr_gpt_fill_fields = function( ewm_group_id ){

        var form_data = new FormData();
        form_data.append( 'action' , 'ewm_wrchatgpt_edit_group_data' );
        form_data.append( 'ewm_group_id', ewm_group_id );

        jQuery.ajax({
            url: ajax_object.ajaxurl,
            type: 'post',
            contentType: false,
            processData: false,
            data: form_data,
            success: function ( response ) { // console.log( response );
                response = JSON.parse(response) ;

                ewm_wrchatgpt_list_item_group_data( response.ewm_post_data );
                $('.ewm_wr_group_name_title').val( response.group_data );
                $('.ewm_wr_sing_group_edit_' + response.group_data.ID ).html( '' );
                ewm_wr_group_item_button();
            },
            error: function (response) {
                console.log( response ) ;
            }
        });

    }

    $('.ewm_wr_sing_group_edit').click( function() {

        $('.ewm_wr_chat_group_outer_wrap').show();
        ewm_group_id = $( this ).data( 'ewm_group_id' ); 
        $('.ewm_wrchatgpt_group_id').val( ewm_group_id );
        ewm_wr_gpt_fill_fields( ewm_group_id );

    } )

    $( '#ewm_wr_gpt_review_title' ).focus(function() {
        $('.ewm_wr_save_single_b').val('Save');
    });
    $( '#ewm_wr_gpt_customer_name').focus(function() {
        $('.ewm_wr_save_single_b').val('Save');
    });
    $( '#ewm_wr_gpt_rating').focus(function() {
        $('.ewm_wr_save_single_b').val('Save');
    });
    $( '#ewm_wr_gpt_address').focus(function() {
        $('.ewm_wr_save_single_b').val('Save');
    });
    $( '#ewm_wr_gpt_category').focus(function() {
        $('.ewm_wr_save_single_b').val('Save');
    });
    $( '#ewm_wr_gpt_job_description').focus(function() {
        $('.ewm_wr_save_single_b').val('Save');
    });
    $( '#ewm_wr_gpt_team_member').focus(function() {
        $('.ewm_wr_save_single_b').val('Save');
    });
    $( '.ewm_wr_edit_single_g_item').click(function() {
        $('.ewm_wr_save_single_b').val('Save');
    });

    $(".ewm_wr_save_single_b").click( function(){

        var form_data = new FormData();
        form_data.append( 'action' , 'ewm_wr_save_single_b' );

        $('.ewm_wr_save_single_b').val( 'Saving' );

        form_data.append( 'ewm_wrchatgpt_page_id', $('#ewm_wrchatgpt_page_id').val() );
        form_data.append( 'group_parent_id', $('#ewm_wrchatgpt_group_id').val() );
        form_data.append( 'ewm_wr_gpt_review_title', $("#ewm_wr_gpt_review_title").val() );
        form_data.append( 'ewm_wr_gpt_customer_name', $("#ewm_wr_gpt_customer_name").val() );
        form_data.append( 'ewm_wr_gpt_rating', $("#ewm_wr_gpt_rating").val() );
        form_data.append( 'ewm_wr_gpt_address', $("#ewm_wr_gpt_address").val() );
        form_data.append( 'ewm_wr_gpt_category', $("#ewm_wr_gpt_category").val() );
        form_data.append( 'ewm_wr_gpt_job_description',$("#ewm_wr_gpt_job_description").val() );
        form_data.append( 'ewm_wr_gpt_team_member', $("#ewm_wr_gpt_team_member").val() );
        form_data.append( 'ewm_wrchatgpt_group_item_id', $('#ewm_wrchatgpt_group_item_id').val() );

        jQuery.ajax( {
            url: ajax_object.ajaxurl,
            type: 'post',
            contentType: false,
            processData: false,
            data: form_data,
            success: function ( response ) { // console.log( response ) ;
                response = JSON.parse(response) ;
                $('.ewm_wr_save_single_b').val('Saved Successfully');

                console.log( $('#ewm_wrchatgpt_group_item_id').val() );

                if( $('#ewm_wrchatgpt_group_item_id').val() == 0 ){

                    $('.ewm_wr_edit_area_left').append(
                        '<div class="ewm_wr_single_line_list_item ewm_wr_group_wrap_g_item_'+ response.post.ID +'">\
                            <span class="ewm_wr_group_single_g_item_'+ response.post.ID +'">'+ response.post.post_title  +' </span> \
                            <span data-ewm_wr_delete_single_g_item_id="'+ response.post.ID +'" class="ewm_wr_delete_single_g_item">Delete</span> \
                            <span data-ewm_wr_edit_single_g_item="'+ response.post.ID +'" class="ewm_wr_edit_single_g_item">Edit</span>\
                        </div>'
                    ) ;
                    ewm_wr_group_item_button();

                }
                else{
                    $( '.ewm_wr_group_single_g_item_' + response.post.ID ).html( response.item_title );
                }

                $('#ewm_wrchatgpt_group_item_id').val( response.new_gpt_group_item_id );
                
                
            },
            error: function (response) {
                console.log( response ) ;
            }
        } );

    } )

    $('.ewm_wr_close_single_b').click(function(){
        $('.ewm_wr_edit_area_right').hide();
        $('.ewm_wr_edit_area_left').css({ 'width': '90%' });
    })

    var ewm_wr_update_group_item = function( group_item_id ){

        var form_data = new FormData();
        form_data.append( 'action' , 'ewm_wr_update_group_item' );
        form_data.append( 'group_item_id',  group_item_id );
       
        jQuery.ajax({

            url: ajax_object.ajaxurl,
            type: 'post',
            contentType: false,
            processData: false,
            data: form_data,
            success: function ( response ) { // console.log( response );

                response = JSON.parse(response) ;
                $("#ewm_wr_gpt_review_title").val( response.ewm_wr_gpt_review_title );
                $("#ewm_wr_gpt_customer_name").val( response.ewm_wr_gpt_customer_name );
                $("#ewm_wr_gpt_rating").val( response.ewm_wr_gpt_rating );
                $("#ewm_wr_gpt_address").val( response.ewm_wr_gpt_address );
                $("#ewm_wr_gpt_category").val( response.ewm_wr_gpt_category );
                $("#ewm_wr_gpt_job_description").val( response.ewm_wr_gpt_job_description );
                $("#ewm_wr_gpt_team_member").val( response.ewm_wr_gpt_team_member );
                
            },
            error: function (response) {
                console.log( response ) ;
            }
        } );

    }

    var ewm_wr_group_item_button = function(){

        $('.ewm_wr_edit_single_g_item').click( function(){

            $('.ewm_wr_edit_area_left').css( { 'width': '40%' } );
            $('.ewm_wr_edit_area_right').css( { 'width': '50%' } );
            $('.ewm_wr_edit_area_right').show(); // $('#ewm_wrchatgpt_group_item_id').val( $(this).val() );

            ewm_wr_edit_single_g_item = $( this ).data( 'ewm_wr_edit_single_g_item' );
            $('#ewm_wrchatgpt_group_item_id').val( ewm_wr_edit_single_g_item );

            ewm_wr_update_group_item( ewm_wr_edit_single_g_item );

        } );

        $('.ewm_wr_delete_single_g_item').click( function(){

            ewm_wr_delete_single_g_item_id = $( this ).data( 'ewm_wr_delete_single_g_item_id' );

            var form_data = new FormData();
            form_data.append( 'action' , 'ewm_wr_delete_single_g_item' );
            form_data.append( 'single_g_item_id', ewm_wr_delete_single_g_item_id ); // data-current_review_box

            jQuery.ajax( {
                url: ajax_object.ajaxurl,
                type: 'post',
                contentType: false,
                processData: false,
                data: form_data,
                success: function ( response ) { // console.log( response );
                    response = JSON.parse(response) ;
                    $( ".ewm_wr_group_wrap_g_item_" + response.new_post_id ).remove(); //
                },
                error: function (response) {
                    console.log( response ) ;
                }
            } );

        } );

    }

    $(".ewm_wr_autoselection_left").click( function(){

        $('.ewm_wr_autoselection_left').css( {
            'color': '#333',
            'border': '2px solid #fff',
            'background': '#8EFE8D'
        } );

        $('.ewm_wr_autoselection_right').css( {
            "color":"#333",
            "background":"#ccc2",
            "border":"1px solid #fff"
        } );

        $('.ewm_wrchatgpt_no_keyword_selected').show();
        $('.ewm_wr_chat_manual').hide();

    } )

    $(".ewm_wr_autoselection_right").click( function(){

        $('.ewm_wr_autoselection_left').css( {
            "color":"#333",
            "background":"#ccc2",
            "border":"1px solid #fff",
        } );

        $('.ewm_wr_autoselection_right').css( {
            'color': '#333',
            'border': '2px solid #fff',
            'background': '#8EFE8D'
        } );

        $('.ewm_wrchatgpt_no_keyword_selected').hide();
        $('.ewm_wr_chat_manual').show();

        ewm_wr_autofill_review_list();

    } )

    var gpt_populate_individual_reviews_list = function( args ) { // console.log( args );

        $("#gpt_ewm_r_review_title").val( args.review_title );
        $("#gpt_ewm_r_description").val( args.description );
        $("#gpt_ewm_r_customer_name").val( args.customer_name );
        $("#gpt_ewm_r_review_date").val( args.ewm_r_review_date );
        $("#ewm_r_star_rating").val( args.star_rating );
        $("#gpt_ewm_r_review_address").val( args.address ); // 
        $("#gpt_ewm_r_street_address").val( args.review_place ); // $("#gpt_ewm_r_street_address").val( args. );
        $("#gpt_ewm_r_address_city").val( args.city );
        $("#gpt_ewm_r_address_state").val( args.state );
        $("#gpt_ewm_r_address_zip").val( args.zip );
        $("#gpt_ewm_r_address_country").val( args.country );
        $("#gpt_ewm_r_job_description").val( args.job_description );
        $("#ewm_r_star_rating").val( args.star_rating );
        $("#ratingOne").html( '<center>' + args.star_rating + "</center>" );
        $("#gpt_ewm_r_team_member").val(  args.worker_name );
        $("#gpt_ewm_wr_category_dropdown").val( args.review_categories );
        $("#gpt_ewm_wr_img_file").prop( 'href', args.ewm_wr_img_file_url );
        $('.gpt_ewm_wr_worker_review_img').html( '<img src="'+ args.ewm_wr_img_file_url+'" height="80px" id="gpt_ewm_wr_worker_review_img_d">' );

    }

    var droppedFiles = [] ;

    var droppedFiles_ewm = function(){

        $('#gpt_ewm_wr_img_file').on('change',function(){

            droppedFiles = $('#gpt_ewm_wr_img_file').prop('files');
            $('#gpt_ewm_img_file_is_changed').val('1');

            console.log( droppedFiles );
        
        } )
    }
    droppedFiles_ewm();

    var gpt_populate_review_form_fields = function( args = {} ) { // args.review_id

        var form_data = new FormData();

        form_data.append( 'action' , 'gpt_populate_review_form_fields' );
        form_data.append( 'review_id', args.review_id ); // data-current_review_box

        jQuery.ajax( {
            url: ajax_object.ajaxurl,
            type: 'post',
            contentType: false,
            processData: false,
            data: form_data,
            success: function ( response ) { // console.log( response );
                response = JSON.parse(response) ;
                gpt_populate_individual_reviews_list( response );
            },
            error: function (response) {
                console.log( response ) ;
            }
        } );

    }

    var ewm_wr_review_lister = function (){
        ewm_wr_remove_box();
        ewm_wr_edit_box();
    }

    $('.ewm_wrchatgpt_sr_edit_background_inner_close').click(function(){
        $('.ewm_wr_autoselection_right').click();
    })

    var ewm_wr_review_list_populate = function( args = {} ){

        $( '.ewm_r_review_list_container' ).html( '' );

        Object.entries(args).forEach(element => {

            review_id = ewm_wr_post_id = element[1].ewm_wr_post_id;
            manager_link = element[1].manager_link;
            worker_name = element[1].worker_name;
            job_description = element[1].job_description;
            value_post_author = element[1].value_post_author;
            author_name = element[1].author_name ;

            city = element[1].city;
            state = element[1].state;
            address = element[1].address;
            zip = element[1].zip;

            review_time = ewm_r_review_date = element[1].ewm_r_review_date;
            review_place = element[1].review_place;
            customer_name = element[1].customer_name;
            review_title = element[1].review_title;
            description = element[1].description;
            star_rating = element[1].star_rating;
            related_page_id = element[1].related_page_id;
            review_categories = element[1].review_categories;
            ewm_wr_img_file_url = element[1].ewm_wr_img_file_url;

            review_address = address + ' ' + city + ' ' + state + ' ' + zip ;
            review_rating = star_rating;
            review_content = description
            review_by = customer_name;
            review_job_performed_by = worker_name;

            single_review = `<div class="wr_main_review_body" data-current_review_box="`+review_id+`" id="ewm_wr_whold_box_`+review_id+`"> \
                <div class="ewm_wr_top_box_nav"> \
                    <span class="ewm_wr_delete_box ewm_wr_remove_box" id="ewm_wr_delete_box_`+review_id+`" data-current_review_box="`+review_id+`">\
                        Delete \
                    </span> \
                    <span class="ewm_wr_delete_box ewm_wr_edit_box" id="ewm_wr_delete_box_`+review_id+`" data-current_review_box="`+review_id+`"> \
                        Edit \
                    </span> \
                </div> \
                <div class="wr_review_body"> \
                    <div class="wr_picture_area"> \
                        <img src="`+ewm_wr_img_file_url+`" > \
                    </div> \
                    <div class="wr_review_area"> \
                        <div class="wr_review_first_line"> \
                            <span class="wr_review_title">`+review_title+`</span> \
                            <span class="wr_review_date">`+review_time+`</span> \
                        </div> \
                        <div class="wr_location_line"> `+review_address+` </div> \
                        <div> \
                        <div class="wr_review_rating_string"> \
                            <div class="wr_review_stars_figure">Rating: `+review_rating+` </div> \
                        </div> \
                        </div> \
                        <div class="wr_final_review_description">`+ review_content + `</div>\
                        <div> \
                            <div class="wr_customer_detail_main_detail"> \
                                <div class="wr_face_display"> \
                                    <i class="fa fa-user-circle"></i> \
                                </div> \
                                <div class="wr_review_customer_name"> \
                                    <div> \
                                        <span style="width:100%;">Review By:</span> \
                                        <span style="width:100%;">`+review_by+`</span> \
                                    </div> \
                                </div> \
                            </div> \
                        </div> \
                    </div> \
                </div> \
                <div class="wr_review_cat"> \
                    <h2>`+ review_categories +`</h2> \
                    <p>` + job_description	+ `</p> \
                        <div> \
                            <div class="wr_customer_detail_main_detail"> \
                                <div class="wr_face_display"> \
                                    <i class="fa fa-user-circle"></i> \
                                </div> \
                                <div class="wr_review_customer_name"> 
                                    <div> \
                                        <span style="width:100%;">Job Performed by:</span> \
                                        <span style="width:100%;">`+review_job_performed_by+`</span> \
                                    </div> \
                                </div> \
                            </div> \
                        </div> \
                </div> \
            </div>`;

            $( '.ewm_r_review_list_container' ).append( single_review );

            ewm_wr_review_lister();

        });

    }

    $('.gpt_ewm_new_review_btn').click( function () {

        $('#ewm_wrchatgpt_review_id').val( '0' );
        $('.ewm_wrchatgpt_sr_edit_background_main ').show();
        $('#gpt_ewm_wr_new_file_exist').val('0');
        $('#gpt_ewm_img_container').html('<input name="gpt_ewm_wr_img_file" id="gpt_ewm_wr_img_file" placeholder="" type="file">');
        $('.gpt_ewm_wr_worker_review_img').html('');

        droppedFiles_ewm();

        $("#gpt_ewm_r_review_title").val('');
        $("#gpt_ewm_r_description").val('');
        $("#gpt_ewm_r_customer_name").val('');
        $("#gpt_ewm_r_review_date").val('');
        $("#ewm_r_star_rating").val('0');
        $("#gpt_ewm_r_review_address").val(''); // 
        $("#gpt_ewm_r_street_address").val(''); // $("#gpt_ewm_r_street_address").val( args. );
        $("#gpt_ewm_r_address_city").val('');
        $("#gpt_ewm_r_address_state").val('');
        $("#gpt_ewm_r_address_zip").val('');
        $("#gpt_ewm_r_address_country").val('');
        $("#gpt_ewm_r_job_description").val('');
        $("#ratingOne").html("");
        $("#gpt_ewm_r_team_member").val('');
        $("#gpt_ewm_wr_category_dropdown").val('');
        $('#gpt_ewm_img_file_is_changed').val( 0 )
        // $("#gpt_ewm_wr_img_file").prop( 'href', '' ); // args.ewm_wr_img_file_url ); 
        // $('.gpt_ewm_wr_worker_review_img').html('');
        // $('#gpt_ewm_wr_img_file').val('');

    } );

    $("#gpt_ewm_wr_img_file").change( function() {
        $('#gpt_ewm_img_file_is_changed').val( '1' );
    } );

    $('#ewm_wrchatgpt_sr_edit_background_inner_close').click( function() {
        $('#gpt_ewm_img_file_is_changed').val( '0' );
    })

    var ewm_wr_edit_box = function(){

        $('.ewm_wr_edit_box').click( function(){ // console.log('delete');

            gpt_review_box = $( this ).data( 'current_review_box' ); // alert( gpt_review_box );
            $('#ewm_wrchatgpt_review_id').val( gpt_review_box );
            $('.ewm_wrchatgpt_sr_edit_background_main ').show(); // $('#gpt_ewm_wr_new_file_exist').val('0');
            $( '#gpt_ewm_img_file_is_changed' ).val(0);
            $('#gpt_ewm_img_container').html( '<input name="gpt_ewm_wr_img_file" id="gpt_ewm_wr_img_file" placeholder="" type="file">' );
            droppedFiles_ewm();
            
            gpt_populate_review_form_fields( {
                "review_id": gpt_review_box 
            } );
            
        } );

    }

    var ewm_wr_autofill_review_list = function() {

        var form_data = new FormData();
        form_data.append( 'action' , 'ewm_wr_generate_review_list' );
        form_data.append( 'post_id' , $('#ewm_wrchatgpt_page_id').val() );

        jQuery.ajax( {
            url: ajax_object.ajaxurl,
            type: 'post',
            contentType: false,
            processData: false,
            data: form_data,
            success: function ( response ) { // console.log( response );
                response = JSON.parse( response ); // var_dump( response ); // console.log( response ); // ewm_wr_load_review_l( response.review_list );
                ewm_wr_review_list_populate( response.review_list );
            },
            error: function (response) {
                console.log( response ) ;
            }
        } );

    }

    $('.ewm_wr_chat_cat_inline').click( function () {

        var ewm_group_selected = $( this ).data('ewm_group_selected');
        
        // console.log( typeof ewm_group_selected )
        if( ewm_group_selected == 0 ){
            $( this ).data( 'ewm_group_selected',1 );
            $( this ).css({ 'border':'2px solid #333' });
            // console.log( 'ewm_group_selected_true' );
        }
        else if(  ewm_group_selected == 1 ){
            $( this ).data( 'ewm_group_selected' , 0 );
            $( this ).css({ 'border':'0px solid #333' });
            // console.log( 'ewm_group_selected_false' );
        }

        // console.log( $( this ).data('ewm_group_selected') );


    } );

    var ewm_wrchatgpt_group_title_update = function( group_title ) {

        ewm_group_title = group_title.val();

        var form_data = new FormData();
        form_data.append( 'action' , 'ewm_wrchatgpt_group_title_update' );
        form_data.append( 'group_title' , group_title.val() );
        form_data.append( 'group_id', $('#ewm_wrchatgpt_group_id').val() );

        jQuery.ajax({
            url: ajax_object.ajaxurl,
            type: 'post',
            contentType: false,
            processData: false,
            data: form_data,
            success: function ( response ) {
                console.log( response );
                response = JSON.parse(response) ;

                console.log( response.group_id );
                console.log( response.group_title );
                // if doesn't exist > create new one
                $( '#ewm_wr_chat_cat_inline_' + response.group_id ).html( response.group_title );
                // $('#ewm_wrchatgpt_group_id').val( );
            },
            error: function (response) {
                console.log( response ) ;
            }
        });

    }

    $('.ewm_wr_group_name_title').keyup(function( event ) {
        ewm_wrchatgpt_group_title_update( $( this ) );
    })

    var ewm_wr_sing_group_delete = function( group_id ){

        var form_data = new FormData();
        form_data.append( 'action' , 'ewm_wr_sing_group_delete' );
        form_data.append( 'group_id', group_id );

        console.log( group_id );

        jQuery.ajax({
            url: ajax_object.ajaxurl,
            type: 'post',
            contentType: false,
            processData: false,
            data: form_data,
            success: function ( response ) {
                console.log( response );
                response = JSON.parse(response) ;
                // if doesn't exist > create new one
                $( '#ewm_wr_chat_group_top_' + response.group_id ).remove();
            },
            error: function (response) {
                console.log( response ) ;
            }
        });

    }

    $('.ewm_wr_sing_group_delete').click(function( event ) {

        ewm_group_id = $(this).data( 'ewm_group_id' ) ;
        ewm_wr_sing_group_delete( ewm_group_id );

    })

    $('.ewm_wrchatgpt_background_inner_close_gptset').click(function() {
        $('.ewm_wrchatgpt_background_main_gptset').hide();
    })

    $('.ewm_review_settings_chatgpt').click( function(){
        $('.ewm_wrchatgpt_background_main_gptset').show();
    });

    ewm_wr_input_api_key_save = function( key = '' ) {

        key = $('.ewm_wr_input_api_key').val();

        var form_data = new FormData();
        form_data.append( 'action' , 'ewm_wr_input_api_key_save' );
        form_data.append( 'ewm_key' , key );

        jQuery.ajax({
            url: ajax_object.ajaxurl,
            type: 'post',
            contentType: false,
            processData: false,
            data: form_data,
            success: function ( response ) {
                console.log( response ) ;
                response = JSON.parse(response) ;
                // if doesn't exist > create new one
                $( '.ewm_wr_input_api_key_save_message' ).html( 'ChatGPT Key Saved Successfully' );
                $( '.ewm_wr_input_api_key_save' ).val( 'Save ChatGPT key' );

            },
            error: function (response) {
                console.log( response ) ;
            }

        });

    }

    $('.ewm_wr_close_single_city_b').click(function () {
        
        $('.ewm_wr_edit_area_left_city').css({ 'width': '90%' });
        $('.ewm_wr_edit_area_right_city').css({ 'width': '0%' });
        $('.ewm_wr_edit_area_right_city').hide();

    } )

    var ewm_rr_populate_city_fields = function( ewm_rr_city ){

        // get values
        var form_data = new FormData();
        form_data.append( 'action' , 'ewm_rr_populate_city_fields' );
        form_data.append( 'ewm_rr_city' , ewm_rr_city );

        jQuery.ajax({
            url: ajax_object.ajaxurl,
            type: 'post',
            contentType: false,
            processData: false,
            data: form_data,
            success: function ( response ) {

                console.log( response );
                response = JSON.parse(response);
                // if doesn't exist > create new one
                $("#ewm_r_address_city").val( response.ewm_r_address_city );
                $("#ewm_r_address_state").val( response.ewm_r_address_state );
                $("#ewm_r_address_zip").val( response.ewm_r_address_zip );
                $("#ewm_r_address_country").val( response.ewm_r_address_country );

            },
            error: function (response) {
                console.log( response ) ;
            }

        });

    }

    $( '.ewm_wr_edit_single_c_item' ).click(function () {

        ewm_wr_edit_single_c_item = $(this).data( 'ewm_wr_edit_single_c_item' );

        // ewm_wr_edit_single_c_item
        $("#ewm_wr_button_new_city_item").val( ewm_wr_edit_single_c_item ) ;

        $('.ewm_wr_edit_area_left_city').css({ 'width': '40%' });
        $('.ewm_wr_edit_area_right_city').css({ 'width': '50%' });
        $('.ewm_wr_edit_area_right_city').show();

        // populate city fields
        ewm_rr_populate_city_fields( ewm_wr_edit_single_c_item );

    })

    $("#ewm_r_address_city").focus(function() {
        $('.ewm_wr_save_single_city').val('Save');
    });
    $("#ewm_r_address_state").focus(function() {
        $('.ewm_wr_save_single_city').val('Save');
    });
    $("#ewm_r_address_zip").focus(function() {
        $('.ewm_wr_save_single_city').val('Save');
    });
    $("#ewm_r_address_country").focus(function() {
        $('.ewm_wr_save_single_city').val('Save');
    });

    var ewm_wr_listen_city_manage = function(){

        $( '.ewm_wr_edit_single_c_item' ).click(function () {

            ewm_wr_edit_single_c_item = $(this).data( 'ewm_wr_edit_single_c_item' );

            // ewm_wr_edit_single_c_item
            $("#ewm_wr_button_new_city_item").val( ewm_wr_edit_single_c_item ) ;
            $('.ewm_wr_edit_area_left_city').css({ 'width': '40%' });
            $('.ewm_wr_edit_area_right_city').css({ 'width': '50%' });
            $('.ewm_wr_edit_area_right_city').show();

            // populate city fields
            ewm_rr_populate_city_fields( ewm_wr_edit_single_c_item );

        });

        $('.ewm_wr_delete_single_c_item').click(function(e) {

            var form_data = new FormData();
            form_data.append( 'action' , 'ewm_wrchatgpt_del_city' );
            form_data.append( 'ewm_city_id' , $( this ).data( 'ewm_wr_delete_single_c_item_id' ) ); // data-ewm_wr_delete_single_c_item_id

            jQuery.ajax( {
                url: ajax_object.ajaxurl,
                type: 'post',
                contentType: false,
                processData: false,
                data: form_data,
                success: function ( response ) { // 
                    console.log( response ) ;
                    response = JSON.parse( response );

                    $( '.ewm_wr_city_id_'+response.post_deleted ).remove();
                },
                error: function (response) {
                    console.log( response );
                }
            } ) ;

        } )

    }

    $(".ewm_wr_button_new_city_item").click( function() {
        $('#ewm_wr_city_is_new').val('is_new');
    } )

    $(".ewm_wr_edit_single_c_item").click( function() {
        $('#ewm_wr_city_is_new').val('not_new');
    } );

    var ewm_wr_save_single_city_ajax = function (){

        var form_data = new FormData();
        form_data.append( 'action' , 'ewm_wr_save_single_city_ajax' );
        form_data.append( 'ewm_r_address_city' , $("#ewm_r_address_city").val() );
        form_data.append( 'ewm_r_address_state' , $("#ewm_r_address_state").val() );
        form_data.append( 'ewm_r_address_zip' , $("#ewm_r_address_zip").val() );
        form_data.append( 'ewm_r_address_country' , $("#ewm_r_address_country").val() );
        form_data.append( 'ewm_wr_button_new_city_item' , $("#ewm_wr_button_new_city_item").val() );
        form_data.append( 'ewm_wr_main_review_page' , $("#ewm_wrchatgpt_page_id").val() );
        form_data.append( 'ewm_wr_city_is_new' , $('#ewm_wr_city_is_new').val() );
        $('.ewm_wr_save_single_city').val('Saving..');

        jQuery.ajax( {
            url: ajax_object.ajaxurl,
            type: 'post',
            contentType: false,
            processData: false,
            data: form_data,
            success: function ( response ) {
                console.log( response ) ;
                response = JSON.parse(response) ;

                // if doesn't exist > create new one
                if( $("#ewm_wr_button_new_city_item").val() == 0 || response.w_r_post_id !== 0 ) {
                    $("#ewm_wr_button_new_city_item").val();
                    $('.ewm_wr_edit_area_left_city').append();
                }

                $('.ewm_wr_save_single_city').val('Saved');
                w_r_post_id = response.w_r_post_id;

                if( response.ewm_wr_city_is_new == 'is_new' ){

                    ewm_wr_save_single_city = '<div class="ewm_wr_single_line_list_item ewm_wr_city_id_'+w_r_post_id+'"> \
                    <span class="ewm_wr_city_id_title_'+w_r_post_id+'" ><b>'+response.name+'</b></span> \
                        <span data-ewm_wr_delete_single_c_item_id="'+w_r_post_id+'" class="ewm_wr_delete_single_c_item">Delete</span> \
                        <span data-ewm_wr_edit_single_c_item="'+w_r_post_id+'" class="ewm_wr_edit_single_c_item">Edit</span> \
                    </div>' ;
                    $('.ewm_wr_edit_area_left_city').append( ewm_wr_save_single_city );
                    ewm_wr_listen_city_manage();

                }
                else{
                    response_name = $('#ewm_r_address_city').val();
                    $( ".ewm_wr_city_id_title_" + w_r_post_id ).html( '<b>' + response_name + '</b>' );
                }

                $('#ewm_wr_city_is_new').val('not_new');

            },
            error: function (response) {
                console.log( response ) ;
            }
        } );

    }

    $('.ewm_wr_save_single_city').click(function(){
        ewm_wr_save_single_city_ajax();
    } )

    $('.ewm_wr_input_api_key_save').click( function(){
        $( this ).val( 'Saving...' );
        ewm_wr_input_api_key_save();
    } )

    $('.ewm_wrchatgpt_sr_edit_background_inner_close').click(function(){
        $('.ewm_wrchatgpt_sr_edit_background_main').hide();
    })

    var ewm_wr_remove_box = function(){

        $('.ewm_wr_remove_box').click( function(){ // ewm_wr_remove_box // get the review to delete.
            current_review_box = $( this ).data( 'current_review_box' ); // delete the review // console.log( current_review_box ); 
            var form_data = new FormData() ;
            form_data.append( 'action' , 'ewm_wr_delete_a_worker_review' ) ;
            form_data.append( 'ewm_wr_worker_review_post_id' , current_review_box );

            jQuery.ajax( {
                url: ajax_object.ajaxurl,
                type: 'post',
                contentType: false,
                processData: false,
                data: form_data,
                success: function ( response ) { // console.log( response ) ;
                    response = JSON.parse( response ) ; // append to the latest reviews
                    $( '#ewm_wr_whold_box_' + current_review_box ).remove();
                },
                error: function (response) {
                    console.log( response ) ;
                }

            } );

        } )

    }

    function ewm_wr_send_data_to_server(){

        // show loading message // send data to serve // show that the data is loading
        $('#ewm_submit_worker_review').val('Saving review...');

        var form_data = new FormData() ;
        $("#ewn_r_work_review_next").html( "Sending..." );

        form_data.append( 'action' , 'ewm_r_add_update_review_details' ) ;

        ewm_r_star_rating = range_details / 2 ; // $( '#ewm_r_star_rating' ).val()  / 2 ; // console.log( droppedFiles ) ;  // gpt_ewm_r_review_address // console.log( $( '#ewm_r_star_rating' ).val() );

        form_data.append( 'ewm_r_review_title' , $('#gpt_ewm_r_review_title').val() );
        form_data.append( 'ewm_r_description' , $('#gpt_ewm_r_description').val() );
        form_data.append( 'ewm_r_customer_name' , $('#gpt_ewm_r_customer_name').val() );
        form_data.append( 'ewm_r_review_date' , $('#gpt_ewm_r_review_date').val() );
        form_data.append( 'ewm_r_star_rating' , ewm_r_star_rating );
        form_data.append( 'ewm_r_review_place' , $('#gpt_ewm_r_street_address').val() );
        form_data.append( 'ewm_r_address' , $('#gpt_ewm_r_review_address').val() ); // gpt_ewm_r_street_address // form_data.append( 'ewm_r_street_address' , $('#gpt_ewm_r_street_address').val() ); // gpt_ewm_r_street_address
        form_data.append( 'ewm_r_address_city' , $('#gpt_ewm_r_address_city').val() );
        form_data.append( 'ewm_r_address_state' , $('#gpt_ewm_r_address_state').val() );
        form_data.append( 'ewm_r_address_zip' , $('#gpt_ewm_r_address_zip').val() );
        form_data.append( 'ewm_r_address_country' , $('#gpt_ewm_r_address_country').val() );
        form_data.append( 'ewm_r_job_description' , $('#gpt_ewm_r_job_description').val() );
        form_data.append( 'ewm_r_team_member' , $('#gpt_ewm_r_team_member').val() );
        form_data.append( 'ewm_wr_category_dropdown' , $('#gpt_ewm_wr_category_dropdown').val() );
        form_data.append( 'ewm_r_related_page_id' , $('#ewm_wrchatgpt_page_id').val() );
        form_data.append( 'ewm_r_post_id' , $('#ewm_wrchatgpt_review_id').val() );
        form_data.append( 'ewm_wr_img_file', droppedFiles[0] );
        form_data.append( 'gpt_ewm_img_file_is_changed', $( '#gpt_ewm_img_file_is_changed' ).val() );

        jQuery.ajax( {

            url: ajax_object.ajaxurl,
            type: 'post',
            contentType: false,
            processData: false,
            data: form_data,
            success: function ( response ) {
                
                response = JSON.parse( response ) ;
                // console.log( response.details );
                // append to the latest reviews   // hide loading
                // $('#ewm_wr_notification_pop_up').show() ;
                // $('#ewm_wr_notification_pop_up_message').html( 'Congratulations! The review was successfully added<br><br><input type="submit" id="ewm_wr_notification_pop_up_message_ok" value="Okay">' );

                //$('#ewm_wr_notification_pop_up_message_ok').click(function () {
                //    $('#ewm_wr_notification_pop_up').hide();
                //    $('#ewm_wr_notification_pop_up_message').html('');
                //} )
                $('#ewm_submit_worker_review').val( 'Submit Review' ); // ewm_wr_clear_fields();
                // $('.ewm_r_review_list_container').prepend( ewm_wr_append_html( response.details.data ) );
                // ewm_wr_img_file_url
            
                $('.gpt_ewm_wr_worker_review_img').html( '<img src="' + response.details.data.ewm_wr_img_file_url + '" id="gpt_ewm_wr_worker_review_img_d" style="height: 80px;width: 100px;" height="80px">' );

            },
            error: function (response) {
                console.log( response ) ;
            }
            
        } ) ;
        // hide loading message and show new status

    }

    var ewm_wr_field_details = [];

    // ewm_wr_field_details[0] = { 'name' :"gpt_ewm_wr_img_file" };
    ewm_wr_field_details[1] = { 'name' :"gpt_ewm_r_review_title" };
    ewm_wr_field_details[2] = { 'name' :"gpt_ewm_r_description" };
    ewm_wr_field_details[3] = { 'name' :"ewm_r_star_rating" };
    ewm_wr_field_details[4] = { 'name' :"gpt_ewm_r_review_address" };
    ewm_wr_field_details[5] = { 'name' :"gpt_ewm_r_street_address" }; // ewm_wr_field_details[8] = { 'name' :"gpt_ewm_r_street_address2" };
    ewm_wr_field_details[6] = { 'name' :"gpt_ewm_r_address_city" };
    ewm_wr_field_details[7] = { 'name' :"gpt_ewm_r_address_state" };
    ewm_wr_field_details[8] = { 'name' :"gpt_ewm_r_address_zip" };
    ewm_wr_field_details[9] = { 'name' :"gpt_ewm_r_address_country" };
    ewm_wr_field_details[10] = { 'name' :"gpt_ewm_r_job_description" };
    ewm_wr_field_details[11] = { 'name' :"gpt_ewm_r_team_member" };
    // ewm_wr_field_details[12] = { 'name' :"gpt_ewm_wr_category_dropdown" };

    function ewm_wr_check_all_fields_are_added(){

        number_of_missing_required_fields = 0;
        ewm_wr_field_details.forEach( function( field , details ){

            current_field_len = $( '#' + ewm_wr_field_details[details].name ).val().length ; // console.log( ewm_wr_field_details[details].name ); //console.log( $( '#' + ewm_wr_field_details[details].name ).val() );
            if( current_field_len == 0 ){ // console.log( ewm_wr_field_details[details].name ); // console.log( $( '#' + ewm_wr_field_details[details].name ).val() );
                // Change the border colors
                $( '#' + ewm_wr_field_details[details].name ).css( 'border' , '1px solid darkred' );
                // Add text message
                $( '#' + ewm_wr_field_details[details].name + '_message' ).html( 'This is a required field.' ) ;
                number_of_missing_required_fields++;
            }

        } ); // console.log( number_of_missing_required_fields );

        if( number_of_missing_required_fields === 0 ){ // Send data to server
            ewm_wr_send_data_to_server();
        }

    }

    $("#ewm_submit_worker_review").click( function(e) {

        e.preventDefault();

        // Check that the fields are all filed and throw error if the field is missing
        ewm_wr_check_all_fields_are_added();

    } );

} ) ;

