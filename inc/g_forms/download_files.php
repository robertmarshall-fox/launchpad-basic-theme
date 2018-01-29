<?php

/**
 * This page is potentially playing with fire
 * 
 * We allow the user to enter any old variable into our argument, do a few
 * checks and then download a file.
 * 
 * The checks that we have covered are:
 * 
 * Remove all characters apart from integers
 * If we still have a download ID after cleaning pass on
 * 
 * TODO: Check that a cookie has been set to allow the user to download a file
 **/ 

if( isset($_GET["download"]) ){

    $download_id_string = $_GET["download"];

    //If the page is a post, and downloads are allowed, and we have a download ID
    if( $download_id_string ) {

        //Clean ID from get function
        //$download_id_string = preg_replace("/[^0-9]/","", $download_id_string);

        //If after cleaning, we still have a download ID
        if( $download_id_string ){

            $download_id = intval( fox_encript_me( $download_id_string, $action = 'd' ) );
            
            //Make sure it exists, and it is bigger than 1
            //FYI - http://php.net/manual/en/function.intval.php
            if( $download_id && $download_id > 1 ){
            
                //Get the file from this page, and only this page
                download_file($download_id);
                
            }

        }
    }
}


/**
 * This function take a file ID and returns
 * an encripted query string to be passed to
 * the user to allow them to download specific files
 */

function create_download_id_query( $file_id ){
    
    if( $file_id ){
        
        $file_id = fox_encript_me( $file_id, $action = 'e' );
        
        return 'download=' . $file_id;
        
    }
    
    return '';
    
}

/**
 * This function takes the attachment id,
 * finds the download file, and returns is to the page
 */

function download_file( $download_id ){
    
    $file = get_attached_file( $download_id );
    
    if($file){
        
        header("Content-Description: File Transfer"); 
        header("Content-Type: application/octet-stream"); 
        header("Content-Disposition: attachment; filename='" . basename($file) . "'"); 

        readfile ($file);
        exit(); 
                
    }
    
}