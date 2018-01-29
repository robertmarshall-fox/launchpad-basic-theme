<?php

/**
 * This page creates the dynamic css
 **/

function fox_agency_create_dynamic_css(){ ?>
<?php
    
    /**
     * Get fonts details from Customizer
     */ 
    
    $fonts          = get_google_font_details();
    $heading_font   = $fonts['heading']['name'];
    $paragraph_font = $fonts['paragraph']['name'];  
    
    ?>
html { 
    font-family: '<?php echo $paragraph_font;?>', Verdana, Geneva, sans-serif;
}

h1,
h2,
h3,
h4,
h5,
#header .logo p {
    font-family: '<?php echo $heading_font;?>', Verdana, Geneva, sans-serif;
    color: <?php echo get_theme_mod('fox_agency_heading_text_colour', '#222222'); ?>;
} 

p, 
li, 
a, 
label,
time,
button.search-submit,
button.search-close {
    font-family: '<?php echo $paragraph_font;?>', Verdana, Geneva, sans-serif;
    color: <?php echo get_theme_mod('fox_agency_paragraph_text_colour', '#222222');?>;
}

body {
    background-color: <?php echo get_theme_mod('fox_agency_background_colour', '#f5f4f2');?>;
}

#comments,
.article-share {
    border-top: 0.5em solid <?php echo get_theme_mod('fox_agency_background_colour', '#f5f4f2');?>;
}


/** Essentials **/

.toTop {
    background-color: <?php echo get_theme_mod('fox_agency_to_top_colour', '#868686');?>;
	color: <?php echo getContrastColor( get_theme_mod('fox_agency_to_top_colour', '#868686') ); ?>;
}

.toTop:hover {
    background-color: <?php echo get_theme_mod('fox_agency_to_top_colour_hover', '#5d5d5d');?>;
}

<?php    
}



/**
 * This function takes PHP generated CSS and 
 * allows it to be used within the main CSS file
 */

function fox_agency_dynamic_css(){
    header('Content-Type: text/css');
    fox_agency_create_dynamic_css();
    exit;
}
add_action('wp_ajax_fox_agency_dynamic_css', 'fox_agency_dynamic_css');
add_action('wp_ajax_nopriv_fox_agency_dynamic_css', 'fox_agency_dynamic_css');