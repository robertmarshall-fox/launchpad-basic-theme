<?php
/**
 * The template for the theme
 * 
 * This is the template that displays all of the <head> section and everything up until <div id="page-wrapper">
 * 
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package FoxAgency
 * @since FoxAgency 1.0.0
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
    
<head>
    
    <meta charset="<?php bloginfo( 'charset' ); ?>" />   
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    
    <!-- Hide due to conflict with WC3 recommendations -->
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no"> -->
    
    <meta name="viewport" content="width=device-width">
    
    <link rel="profile" href="http://microformats.org/profile/specs" />
    <link rel="profile" href="http://microformats.org/profile/hatom" />    

    <?php
    
	wp_head(); 
            
    /**
     * Custom Header Scripts
     */

    echo get_theme_mod('fox_agency_scripts_header', '');
    
    ?>
    
</head>
   
<body <?php body_class(); ?><?php schema_semantics_tags( 'body' ); ?>>
    
    <div id="footer-pusher"><!-- Push footer to bottom -->
    
        <?php

        /**
         * Check to see if a Header Takeover is used
         * If it is, add class to the header
         * 
         * As soon as the header_take_over module 
         * leaves the screen, add a class to header
         **/ 
        
        $header_class = "";

        if ( check_acf_flexible_module( 'header_take_over' ) ){
            
            //Add the Header Take Over class
            $header_class = "hto";

        }

        ?>
       
        <header id="header" class="<?php echo $header_class;?>"> 
                       
            <div class="page-inner-wrap group">

                <?php get_template_part( 'template-parts/navigation/navigation', 'top' ); ?>

            </div>
            
        </header>
        
        <div id="page-wrapper">