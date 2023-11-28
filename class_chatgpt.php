<?php

function ewm_access_chatgpt( $args = [] ){

    $yourApiKey = get_option( 'ewm_gpt_api_key' ); // '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'; // getenv('YOUR_API_KEY');
    $client = OpenAI::client( $yourApiKey );

    if(array_key_exists('ewm_keyword', $args)) {
        if( strlen( $args['ewm_keyword'] ) == 0 ) {
            $args['ewm_keyword'] = "hvac cooling system";
        }
    }
    else{
        $args['ewm_keyword'] = "hvac cooling system";
    }

    $rand_number = rand( 30, 150 );
    $result = $client->completions()->create( [
        'model' => 'text-davinci-003',
        'prompt' => 'write and spin a "' .$args['ewm_keyword']. '" word review about "' .$args['ewm_keyword']. '". The review needs to be from the point of view of the contractor. It should have incorrect english.They need to sound trustworthy.',
        'max_tokens' => 1600,
    ] );

    return $result['choices'][0]['text']; // an open-source, widely-used, server-side scripting language.
    
}

add_action( 'wp_ajax_nopriv_ewm_wrchatgpt_del_city', 'ewm_wrchatgpt_del_city' );
add_action( 'wp_ajax_ewm_wrchatgpt_del_city', 'ewm_wrchatgpt_del_city' );
function ewm_wrchatgpt_del_city(){

    $post_deleted = wp_delete_post($_POST['ewm_city_id']);

    echo json_encode( [
        'post_deleted' => $post_deleted->ID,
        'post' => $_POST
    ] );

    wp_die();
}

// add_shortcode('ewm_access_chatgpt', 'ewm_access_chatgpt');
function ewm_access_image_chat( $args = [] ){

    $yourApiKey = get_option( 'ewm_gpt_api_key' ) ; // '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'; // getenv('YOUR_API_KEY');
    $client = OpenAI::client( $yourApiKey );

    if( array_key_exists( 'ewm_keyword', $args ) ) {
        if( strlen( $args['ewm_keyword'] ) == 0 ) {
            $args['ewm_keyword'] = "hvac cooling system";
        }
    }
    else{
        $args['ewm_keyword'] = "hvac cooling system";
    }

    $response = $client->images()->create( [
        'prompt' => $args['ewm_keyword'],
        'n' => 1,
        'size' => '512x512',
        'response_format' => 'url',
    ] );
    
    $response->created; // 1589478378
    
    foreach ($response->data as $data) {
        $data->url; // 'https://oaidalleapiprodscus.blob.core.windows.net/private/...'
        $data->b64_json; // null
    }
    
    $final_Results = $response->toArray(); /// 
    // return $final_Results["data"][0]["url"] ; // var_dump( $final_Results["data"][0]["url"] );
    $gpt_img_detail_url = $final_Results["data"][0]["url"] ;

    $gpt_img_detail_id = gpt_process_thumbnail_image([
        'post_id' => $args['ewm_p_id'],
        'image_url' => $gpt_img_detail_url
    ] ) ; // process

    $gpt_img_detail_url = wp_get_attachment_url(  $gpt_img_detail_id );

    return [
        'id'    => $gpt_img_detail_id,
        'url'   => $gpt_img_detail_url,
    ] ;

}

?>