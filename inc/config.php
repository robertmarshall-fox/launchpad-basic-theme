<?php

/**
 * The base configuration for the theme
 *
 * This file contains the following configurations:
 *
 * * Theme detail constants
 * 
 * @package FoxAgency
 */


/**
 * Get the theme version from the stylesheet
 * 
 * May seem pointless, but it avoids any
 * errors from changes later in the day
 * 
 * @return string version
 */
function fox_agency_version(){
    $theme_details = wp_get_theme();
    return $theme_details->get('Version');
}


/**
 * Get the theme name from the stylesheet
 * 
 * May seem pointless, but it avoids any
 * errors from changes later in the day
 * 
 * @return string theme name
 */
function fox_agency_name(){
    $theme_details = wp_get_theme();
    return $theme_details->get('Name');
}


/**
 * Get the text domain from the stylesheet
 * 
 * May seem pointless, but it avoids any
 * errors from changes later in the day
 * 
 * @return string The text domain of the theme
 */
function fox_agency_text_domain(){
    $theme_details = wp_get_theme();
    return $theme_details->get('TextDomain');
}


/**
 * Get the Google Maps API Key
 * 
 * @return string Google API Key
 */
function fox_agency_google_api_key(){
    return '';
}


/**
 * Return the ACF repeater module directory
 *  * 
 * @return string directory
 */
function fox_agency_acf_module_dir(){
    return get_template_directory() . '/acf_modules';
}