<?php

/** 
 * This page gets any Gravity forms related
 * items for ACF
 **/

function fox_get_GF_forms(){
    
    $forms = array();
    
    if ( class_exists( 'GFCommon' ) ){
        
        $gf = GFAPI::get_forms();
        
        if(isset($gf)){
        
            foreach($gf as $f){

                $forms[] = array(
                    'id'    => $f['id'],
                    'title' => $f['title'],
                );
                
            }
            
        }
        
    }
    
    return $forms;
    
}


/**
 * Dynamically populate ACF with all Gravity Forms avalible
 **/

function dynamic_form_id_picker( $field ) {
    
    // reset choices
    $field['choices'] = array();
    $forms = fox_get_GF_forms();
        
    // check if the repeater field has rows of data
    if( isset( $forms ) ){
        
        // loop through the rows of data
        foreach ( $forms as $form ){

            $field['choices'][ $form['id'] ] = $form['title'];

        }

    }
    

    // return the field
    return $field;
    
}

//List all the fields here than need to use the dynamic form picker
add_filter('acf/load_field/name=form_id', 'dynamic_form_id_picker');
add_filter('acf/load_field/name=gravity_form_newsletter_popup', 'dynamic_form_id_picker');
add_filter('acf/load_field/name=gravity_form_share_popup', 'dynamic_form_id_picker');
add_filter('acf/load_field/name=gravity_form_download_popup', 'dynamic_form_id_picker');
add_filter('acf/load_field/name=gravity_form_contact_form', 'dynamic_form_id_picker');
add_filter('acf/load_field/name=brochure_download_form', 'dynamic_form_id_picker');