<?php

/**
 * This function returns an array of all social media links and icons in a usable array
 * 
 * Will only return a social media element if both URL and Icon exist
 */

function fetch_social_media_links(){

    $social = array();
    
    $custom_count = 1;

    if( function_exists('acf_add_options_page') ) {

        if( have_rows('social_media_account', 'option') ) {           
                   
            while ( have_rows('social_media_account', 'option') ) : the_row();
                                                                     
                $social_fa = $social_field = $social_type = $icon_url = '';

                if(get_sub_field('social_account')){
                    
                    $social_type = get_sub_field('social_account');

                    switch ( $social_type ) {
                            
                        case "github":
                            $social_fa = 'fa-github';
                            $social_field = 'github_url';
                            break;
                        case "google":
                            $social_fa = 'fa-google-plus';
                            $social_field = 'google_url';
                            break;
                        case "facebook":    
                            $social_fa = 'fa-facebook';
                            $social_field = 'facebook_url';
                            break;
                        case "instagram":
                            $social_fa = 'fa-instagram';
                            $social_field = 'instagram_url';
                            break;
                        case "linkedin":
                            $social_fa = 'fa-linkedin';
                            $social_field = 'linkedin_url';
                            break;
                        case "pinterest":
                            $social_fa = 'fa-pinterest-p';
                            $social_field = 'pinterest_url';
                            break;
                        case "twitter":
                            $social_fa = 'fa-twitter';
                            $social_field = 'twitter_url';
                            break;
                        case "youtube":
                            $social_fa = 'fa-youtube';
                            $social_field = 'youtube_url';
                            break;
                        case "rss":
                            $social_fa = 'fa-rss-square';
                            $social_field = 'rss_url';
                            break;
                        case "custom":
                            $social_field = 'custom_url';
                            break;
                            
                    }

                    if($social_field != 'custom_url'){
                    
                        if( $social_fa && $social_field && $social_type ) {

                            $social[$social_type] = array(
                                'type'  => $social_type,
                                'link'  => get_sub_field( $social_field ),
                                'fa'    => $social_fa,
                            );
                        }
                        
                    } else {
                        
                        if( $social_field && get_sub_field( 'custom_icon' ) ){
                        
                            $social['custom_' . $custom_count] = array(
                                'type'      => 'custom',
                                'link'      => get_sub_field( $social_field ),
                                'icon_url'  => get_sub_field( 'custom_icon' )
                            );
                            
                            $custom_count++;
                            
                        }

                    }

                }

            endwhile;
            
        }

    }
    
    return $social;
    
}


/**
 * Retrieve the social media links and save in a transient for quick
 * recall
 **/

function get_social_media_links(){
    
    $social_array = get_transient_array('social_media_links', 'fetch_social_media_links', 'auto');
    
    return $social_array;
    
}


/**
 * This function returns a fully developed list of social media icons
 * If there are no accounts to return, then it will return an empty string
 **/

function create_social_media_list(){

    //Set up header social media links
    $social_media = get_social_media_links();
    $social_media_list = '';

    if(!empty($social_media)){
        
        $social_media_list = '<div class="social-media">';
        
        foreach($social_media as $social){

            if($social['type'] != 'custom'){
            
                if($social['fa'] && $social['link']){

                    $social_media_list .= '<a class="external smooth icon-style icon-' . $social['type'] . ' roll-over hover" href="' . $social['link'] . '"><i class="roll fa ' . $social['fa'] . '" aria-hidden="true"></i></a>';

                } 
                
            } else {
                
                if($social['icon_url'] && $social['link']){
                
                    $social_media_list .= '<a class="external smooth icon-style icon-custom roll-over hover" href="' . $social['link'] . '"><img src="' . $social['icon_url'] . '" class="roll smooth" aria-hidden="true"></i></a>'; 
                    
                }
                
            }
        } 
        $social_media_list .= '</div>';
    }
    
    return $social_media_list;
    
}


function get_specific_social_media_link( $option = null ){
    
    $social = get_social_media_links();
    
    if( isset( $social[$option] ) ){
        return $social[$option]['link'];
    }
    
    return false;
    
}
    