<?php

/**
 * ACF Options Page
 * 
 * This function sets up the main admin menu ACF settings
 **/

if( function_exists('acf_add_options_page') ) {
	acf_add_options_page();
}


/**
 * ACF Google Maps
 * 
 * Add the Google API Key to ACF to allow the use of Google Maps maps
 **/ 

//Set the Google Maps API key
function my_acf_init() {
	acf_update_setting('google_api_key', fox_agency_google_api_key());
}
add_action('acf/init', 'my_acf_init');



/**
 * This code enables campaigns to have a new file directory for downloadable files
 **/

function download_acf_prefilter( $errors, $file, $field ) {
    
    //this filter changes directory just for item being uploaded
    add_filter('upload_dir', 'download_upload_directory');
    
    // return
    return $errors;
    
}
//add_filter('acf/upload_prefilter/key=field_59e9f81f86366', 'download_acf_prefilter');

function download_upload_directory( $param ){
    $mydir = '/downloads';

    $param['path'] = $param['basedir'] . $mydir;
    $param['url'] = $param['baseurl'] . $mydir;

    return $param;
}
