<?php

/**
 * Create Installer Custom Post Types
 *
 * For More Info:
 * https://codex.wordpress.org/Function_Reference/register_post_type
 * 
 */

register_taxonomy(
    "sector", 
    array("case-study"), 
    array("hierarchical" => true, 
          "label" => "Sector", 
          "rewrite" => array( 
              'slug' => 'case-studies/sector',
              'with_front' => false 
          )
    )
);

function fox_case_study_post_type_register() {
        
    $general_name = 'Case studies';
    $singular_name = 'Case study';
    
    //Create Product Study Post Type
    register_post_type( 
        'case-study', 
        array(
            'labels' => array(
                'name' => __( $general_name ),
                'singular_name' => __( $singular_name ),
                'add_new' => __( 'Add ' . $singular_name ),
                'add_new_item' => __( 'Add ' . $singular_name ),
                'edit' => __( 'Edit ' . $singular_name ),
                'edit_item' => __( 'Edit ' . $singular_name ),
                'new_item' => __( 'New ' . $singular_name ),
                'view' => __( 'View ' . $singular_name ),
                'view_item' => __( 'View ' . $singular_name ),
                'search_items' => __( 'Search ' . $general_name ),
                'not_found' => __( 'No ' . $general_name . ' Found' ),
                'not_found_in_trash' => __( 'No ' . $general_name . ' found in Trash' ),
                'parent' => __( 'Parent ' . $singular_name ),
            ),
            'public' => true,
            'publicly_queryable' => true,
            'show_ui' => true,
            'show_in_menu' => true,
            'capability_type' => 'post',
            'hierarchical' => true,
            'rewrite' => array(
                'with_front' => false,
                'slug' => 'case-studies',
            ),
            'has_archive'   => true,
            'query_var' => true,
            'menu_icon' => 'dashicons-portfolio',
            'supports' => array(
                'title','editor','author','excerpt','page-attributes','revisions','thumbnail',
            ),
            'menu_position' => 10
        )
    );
    
}
add_action( 'init', 'fox_case_study_post_type_register' );