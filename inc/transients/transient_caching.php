<?php

/**
 * This function allows functions that use a lot of resources to be cached in the database.
 * @param  [string]       $transName [This is the name of the transient]
 * @param  [array/string] $function  [Provide either a string, with the name of the array to call, or an array
 *                                      with arguments you wish to pass to the functions. i.e:
 *                                      array($function_name, $arg_1, $arg_2)]
 * @param  [num]          $lifespan  [Length of time for the transient to exist. 'auto' = day in seconds]
 * @return boolean/data   [Returns the data, or false if no data]
 */

/**
 * For more information:    https://codex.wordpress.org/Transients_API
 *                          https://css-tricks.com/the-deal-with-wordpress-transients
 */

//The name should be 150 characters or less - this is due to database space
//FYI - https://codex.wordpress.org/Function_Reference/get_transient

function get_transient_array($transName, $function, $lifespan) {

    // Do we have this information in our transients already?
    
    $transient_name = 'fox_tran_'.$transName. '_' . fox_agency_version();
    
    if (defined('WP_DEBUG') && true === WP_DEBUG) {
        $transient = ''; //If debug is on, never use a saved transient
    } else {
        $transient = get_transient( $transient_name );
    }
    
    // Yep!  Just return it and we're done.
    if( ! empty( $transient ) ) {

        // The function will return here every time after the first time it is run, until the transient expires.
        return $transient;

    // Nope!  We gotta make a call.
    } else {

        //Set function to pass as empty
        $out = null;
        
        //Do we have parameters to pass to the transient array?
        //If we do, we must use call_user_func_array
        
        if ( is_array( $function ) ){
            
            if ( count ($function > 1) ) {
                
                $function_name = $function[0];
                $arguments = array_slice($function, 1); //Remove function name so we only have arguments
                
                $out = call_user_func_array($function_name, $arguments);
                
            } else {
                
                //We only have one item in the array, use this as the function name
                $out = call_user_func($function[0]);
                
            }
            
        } else {
            
            //We have no array, lets just use a basic function
            $out = call_user_func($function);
            
        }
            
        if($out){

            //Get transient time
            $lifespan = fox_general_transient_lifespan($lifespan);
                    
            set_transient( $transient_name, $out, $lifespan );
            fox_store_transient_in_list( $transient_name );
            
            return $out;
            
        } 
    }
    //If nothing worked!
    return false;
}


// If the user is a super admin and debug mode is on, only store transients for a second.
function fox_general_transient_lifespan($lifespan) {
            
    if( is_admin() && WP_DEBUG ) {
        return 1;
    } else {
        if($lifespan == 'auto' || !$lifespan){
            return DAY_IN_SECONDS;
        } else {
            return $lifespan;
        }
    }
}


/**
 * This function takes the name of a transient and 
 * deletes it. This allows the database to be cleaned 
 * of all custom theme transients easily.
 */

function fox_clean_down_all_transients(){
    
    $transient_list = fox_get_transient_list();
    
    foreach ( $transient_list as $transient ){
        
        delete_transient( $transient );
        
    }
    
}


/**
 * This function takes the transient name
 * and stores it in the Fox Transient Array.
 * 
 * This array can be used to mass clean all 
 * Fox transients
 */

function fox_store_transient_in_list( $transient_name ){
    
    //Get current transients
    $transient_list = fox_get_transient_list();
    
    if( !in_array( $transient_name, $transient_list ) ){
        
        $transient_list[] = $transient_name;
        
    }
    
    update_option( 'fox_transient_storage', $transient_list );
    
}



function fox_get_transient_list(){
    
    $transient_list = get_option('fox_transient_storage');

    if( !$transient_list ){
        return array();
    }
    
    return $transient_list;
    
}