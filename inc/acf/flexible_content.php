<?php

/**
 * Flexible Content Loader
 * 
 * This code loops through the acf module directory specified in 
 * config.php and adds all folder/file names to an array. This 
 * allows new modules to be added to the correct folder easily.
 **/

/**
 * Scan the Flexible Content Directory and get an array of all
 * directories and files that we can use later
 * 
 * @return array All directories and files
 */

function fetch_acf_module_directory(){

    /**
     * Ignore these files
     * 
     * Add file names (inc .php) to the array to exclude them from 
     * being included in the loop.
     **/

    $files_to_ignore = array();    

    /**
     * Loop through the specified folder and include
     * all PHP files. Exclude files that have been
     * specified in the above array
     **/ 

    return dirToArray( fox_agency_acf_module_dir(), $files_to_ignore );
    
}


/**
 * Retrieve the Flexible Content array and save in a transient for quick
 * recall
 * 
 * Each array is saved for half a day, but with site caching this shouldnt be anywhere
 * as regularly.
 * 
 * @return array
 **/

function get_acf_module_directory(){
    
    return get_transient_array('acf_module_directories', 'fetch_acf_module_directory', 60 * 60 * 12);
    
}


function build_all_acf_flexible_modules( $post_id ){
        
    if( !is_admin() ){
    
        /**
         * Get ACF Modules parent directory
         **/

        $acf_module_dir = fox_agency_acf_module_dir();


        /**
         * Get the directories and files from the ACF module
         * array transient.
         **/

        $dirs_and_files = get_acf_module_directory();


        /**
         * Set the module counter incase we need to use a unique ID anywhere
         **/ 

        $acf_module_counter = 0;
        

        if( is_array( $dirs_and_files ) && have_rows('flexible_groups', $post_id ) ):
        
            /**
             * Loop through the acf rows
             **/ 

            while ( have_rows('flexible_groups') ) : the_row();    

                // Get this in a variable so we don't keep smashing the server
                $row_layout = get_row_layout();

                //Check that we have a directory for this row layout
                if( isset( $dirs_and_files[ $row_layout ] ) && have_rows( 'flexible_' . $row_layout ) ):

                    // loop through the rows of data
                    while ( have_rows( 'flexible_' . $row_layout ) ) : the_row();
        
                        /**
                         * Loop through modules
                         **/ 

                        foreach( $dirs_and_files[ $row_layout ] as $module ){

                            if( get_row_layout() . '.php' == $module ):

                                $acf_module_counter++;

                                /**
                                 * Create the filename location for the PHP file
                                 **/

                                $module_php_file = $acf_module_dir . "/" . $row_layout . "/" . $module;

                                if ( file_exists ( $module_php_file ) ){
                                    
                                    include( $module_php_file );
                                    
                                }

                            endif;

                        }

                    endwhile;

                endif;

            endwhile;

        endif;

    }
}


/**
 * This function takes an array of sub module names and 
 * checks if they exist, as well as the count of location
 * 
 * i.e. 
 * array(
 *      'text'  =>  array(
 *          'used'      => true,
 *          'location'  => array(1,3,10)
 *      )
 * )
 * 
 * @param int Post ID
 * @param array An array of names to check
 * @return array An array of names, with true or false depending on if they have been used
 */

function search_acf_flexible_modules( $post_id, $modules = array() ){

    $included = array();
    $new_module = array();
    
    //Set up array to return
    foreach( $modules as $module ){
        
        $new_module[$module] = array(
            'used'  => false,
            'count' => array(),
        );
        
    }
        
    if( have_rows('flexible_groups', $post_id ) ):
    
        $acf_module_counter = 0;

        $flexible_fields = get_field('flexible_groups', $post_id);
                
        // Loop through flexible fields
        foreach( $flexible_fields as $flexible_array ){
                        
            if( isset( $flexible_array['flexible_' . $flexible_array['acf_fc_layout']] ) && is_array( $flexible_array['flexible_' . $flexible_array['acf_fc_layout']] ) ){
            
                // Get flexible container name, and get array for fields
                foreach ( $flexible_array['flexible_' . $flexible_array['acf_fc_layout']] as $fields_array ){
                                        
                    foreach( $modules as $module ){

                        if( is_array( $module )){
                            
                            if( in_array( $module, $fields_array['acf_fc_layout'] ) ){
                                
                                $new_module[$module]['used'] = true;
                                $new_module[$module]['count'][] = $acf_module_counter;

                            } 

                        } else {

                            if( $fields_array['acf_fc_layout'] == $module ){
                                
                                $new_module[$module]['used'] = true;
                                $new_module[$module]['count'][] = $acf_module_counter;

                            }

                        }

                    }

                    $acf_module_counter++;

                }
                
            }
                        
        }           
        
    endif;
    
    return $new_module;

}


/**
 * This function take an ACF module name and
 * checks it against the ACF Flexible Module global array
 * 
 * @param string $module_name The name of the module (slug)
 * @return bool If the module is used or not
 */

function check_acf_flexible_module( $module_name ){

    // Get array from Globals
    
    $acf_flexible_checker = search_acf_flexible_modules( get_the_ID(), $modules = array($module_name) );
    
    if( $acf_flexible_checker ){
        if( isset ( $acf_flexible_checker[$module_name] ) && $acf_flexible_checker[$module_name]['used'] ){
            return true;
        }
    }
    
    return false;
    
}