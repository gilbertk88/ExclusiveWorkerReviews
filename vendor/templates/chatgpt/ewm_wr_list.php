<style>
    .ewm_wr_top_menu_list{
        width: 100%;
        overflow: auto;
    }
    .ewm_wr_top_menu_single{
        float: left;
        padding: 8px 15px;
        background-color: #323232;
        color: #fff;
        border-radius: 3px;
        width: 45%;
        margin-right: 6px;
        min-height: 20px;
        border: 1px solid #80808038;
    }
    .ewm_r_cat_name, .ewm_manage_l_items{
        float: left;
        color: #333;
        border-radius: 6px;
        width: 45%;
        margin-right: 6px;
        padding: 6px 15px;
    }
    .ewm_settings_b_t{
        width: 95%;
        overflow: auto;
    }
    .ewm_settings_b_title{
        width: 100%;
    }
</style>
<?php

$ewm_wr_is_active = get_posts( [
    
    'post_type' => ['post','page'],
    'meta_query'  => [ [
        'relation' => 'AND',
        [
        'key'     => 'ewm_wr_is_active',
        'value'   => 'true',
        'compare' => '=',
    ],
    ] ],
    'posts_per_page' => -1
] );

?>

<script type="text/javascript">

</script>

<div class="ewm_r_main_container_div">

    <div class="ewm_settings_b_t">
        <input type="button" id="ewm_review_settings_chatgpt" class="ewm_review_settings_chatgpt" value="ChatGPT Settings">
        <input type="button" id="ewm_new_review_page" class="ewm_review_settings_chatgpt_new" value="Add New Worker Review Page">
    </div>
	<!-- <input type="button" id="ewm_review_gen_chatgpt" class="ewm_review_gen_chatgpt" value="Generate for All Posts"> -->
    <div class="ewm_settings_b_title">
        <center>
            <h2>Active Worker Review Pages</h2>
        </center>
    </div>
    <div class="ewm_wr_top_menu_list">
        <div class="ewm_wr_top_menu_single"> Page Title</div>
        <div class="ewm_wr_top_menu_single"> </div>
    </div>
<?php

    // get post with shortcode // be able to manage them individually
    foreach(  $ewm_wr_is_active as $key => $value ){

        $ewm_single_chatgpt_key = $value->ID;
        $ewm_single_chatgpt_val = $value->post_title;
        $ewm_single_chatgpt_link = $value->guid;

        $ewm_wrchatgpt_list = get_posts( [
            'post_parent' => $value->ID,
            'post_type' => 'ewm_gpt_gen',
        ] );

        $ewm_chatgpt_search_id = 0 ;
        $_search_post_exists = false ;
    
        if( is_array( $ewm_wrchatgpt_list ) ) {
            if( count( $ewm_wrchatgpt_list ) > 0 ) { // update
                $ewm_chatgpt_search_id = $ewm_wrchatgpt_list[0]->ID ;
            }
        }

        include dirname(__FILE__).'/single_front_review_chatgpt.php' ;

    }

?>

</div>

<?php

    // include dirname(__FILE__).'/single_popup_review_category.php' ; 
    include dirname(__FILE__).'/items_popup_llt.php' ;
    include dirname(__FILE__).'/items_popup_settings_llt.php' ;
    include dirname(__FILE__).'/items_popup_new_settings_llt.php' ;

?>