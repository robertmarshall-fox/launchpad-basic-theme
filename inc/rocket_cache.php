<?php

/**
 * This file checks to see if the theme has been updated
 * if it has been updated, clear the WP Rocket Cache
 **/

function fox_theme_upgrade_completed( $upgrader_object, $options ) {
    
    // If an update has taken place and the updated type is plugins and the plugins element exists
    if( $options['action'] == 'update' && $options['type'] == 'theme' ) {
        
        $current_theme = wp_get_theme();
        $theme_slug = fox_theme_name_to_slug( $current_theme->get('Name') );
        
        //If there are multisites
        if( fox_have_multisite() ){
            
            fox_flush_wp_rocket_multisite( $theme_slug );
            
        } else {
            
            //If the theme that has been updated is used by this multisite
            if( in_array ( $theme_slug , $options['themes'] ) ){
                
                fox_clean_site_cache();
                
                update_option( 'fox_theme_updated', 1 );

            }
            
        }
                
    }
}
add_action( 'upgrader_process_complete', 'fox_theme_upgrade_completed', 10, 2 );


/**
 * This function loops through all mulisites, and checks if the theme
 * that has been updated is used by each multisite.
 * 
 * If the theme is used by that multisite, then the WP Rocket
 * cache is cleared.
 **/

function fox_flush_wp_rocket_multisite( $theme_slug ){

    $multisites = get_sites();
    
    foreach ($multisites as $current_blog->blog_id) {
        
        // Switch to each blog to get the posts
        switch_to_blog($current_blog->blog_id);
        
        //If the theme that has been updated is used by this multisite
        if( in_array ( $theme_slug , $options['themes'] ) ){

            fox_clean_site_cache();
            
            update_option( 'fox_theme_updated', 1 );
            
        }

        //Restore original blog
        restore_current_blog();

    }
    
}


function fox_clean_site_cache(){
    if( function_exists ( 'rocket_clean_domain' ) ){
        rocket_clean_domain();
    }
    if( function_exists ( 'fox_clean_down_all_transients' ) ){
        fox_clean_down_all_transients();
    }    
}


function fox_theme_upgrade_message_notif(){
    
    if ( get_option( 'fox_theme_updated' ) ) {
    
        //reset value
        update_option( 'fox_theme_updated', 0 );
        
        /**
        * At this point, if WP Rocket has been installed we clear the cache
        * If not, we just inform the user about a happy upgrade
        **/

        if ( function_exists( 'rocket_clean_domain' ) ) {

            echo '<div class="notice notice-info is-dismissible">
                  <p>The theme has been updated, and the WP Rocket Cache has been cleared. Saved you a whole click ;)</p>
                 </div>';

        } else {

            echo '<div class="notice notice-info is-dismissible">
                  <p>The theme has been updated, high five!</p>
                 </div>';

        }
        
    }
    
}

add_action('admin_notices', 'fox_theme_upgrade_message_notif'); 
function fox_have_multisite() {
    if ( is_multisite() ) {
        if ( get_blog_count() > 1 ) {
            return true;
        }
    }
    return false;
}

function fox_theme_name_to_slug( $name ){
 
    //Remove spaces
    $name = str_replace(' ', '-', $name);
    // convert the string to all lowercase
    $slug = strtolower($name);
    
    return $slug;
    
}

//When Rocket cleans it cache, also clean down custom transients
do_action( 'after_rocket_clean_domain', 'fox_clean_down_all_transients' ); 