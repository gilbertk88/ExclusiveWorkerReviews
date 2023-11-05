jQuery(document).ready(function($) {

    $('input[type="range"]').on("change mousemove", function() {

        range_details = $(this).val() / 2 ;

        $(this).next().html( range_details );

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

        ewm_r_star_rating = $( '#ewm_r_star_rating' ).val()  / 2 ;

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

} ) ;
