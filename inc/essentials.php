<?php

/**
 * Hex code to RGB 
 * @param $hex $hex Hex code to be turned to RGB
 */
function hex2rgb($hex) {
	$hex = str_replace("#", "", $hex);
	if(strlen($hex) == 3) {
        $r = hexdec(substr($hex,0,1).substr($hex,0,1));
        $g = hexdec(substr($hex,1,1).substr($hex,1,1));
        $b = hexdec(substr($hex,2,1).substr($hex,2,1));
	} else {
        $r = hexdec(substr($hex,0,2));
        $g = hexdec(substr($hex,2,2));
        $b = hexdec(substr($hex,4,2));
	}
	$rgb = array($r, $g, $b);
	return $rgb; // returns an array with the rgb values
}


/**
 * Get RGBA colour from HEX
 * @param  string $hex   Hex colour to be converted
 * @param  string $alpha Value between 0 - 1 for opacity
 * @return string  RGBA string
 */

function hex_to_rgba( $hex, $alpha ){
    
    $rgb = hex2rgb( $hex );
    
    return 'rgba(' . $rgb[0] . ', ' . $rgb[1] . ', ' . $rgb[2] . ', ' . $alpha . ')';
    
}


/**
 * Re-write the oembed filter so that we can make videos responsive!
 */

// Hook onto 'oembed_dataparse' and get 2 parameters
add_filter( 'oembed_dataparse','responsive_wrap_oembed_dataparse',10,2);

function responsive_wrap_oembed_dataparse( $html, $data ) {
    // Verify oembed data (as done in the oEmbed data2html code)
    if ( ! is_object( $data ) || empty( $data->type ) )
    return $html;

    // Verify that it is a video
    if ( !($data->type == 'video') )
    return $html;

    // Calculate aspect ratio
    $ar = $data->width / $data->height;

    // Set the aspect ratio modifier
    $ar_mod = ( abs($ar-(4/3)) < abs($ar-(16/9)) ? 'embed-responsive-4by3' : 'embed-responsive-16by9');

    // Strip width and height from html
    $html = preg_replace( '/(width|height)="\d*"\s/', "", $html );

    // Return code
    return '<div class="embed-responsive">'.$html.'</div>';
}


//Gets the word count of the content
function word_count($id) {
    $content = apply_filters('the_content', get_post_field('post_content', $id));;
    $word_count = '0';
    if($content){
        $word_count = str_word_count( strip_tags( $content ) );
    }
    return $word_count;
}


/**
 * Outputs the current year for Copyrighting
 * Entering 'auto' into the function outputs the current year
 * Entering the Year copyright began automatically chooses the output
 */

function auto_copyright($year = 'auto'){
     if(intval($year) == 'auto'){ $year = date('Y'); }
     if(intval($year) == date('Y')){ echo intval($year); }
     if(intval($year) < date('Y')){ echo intval($year) . ' - ' . date('Y'); }
     if(intval($year) > date('Y')){ echo date('Y'); }
} 


/**
 * Change the excerpt length
 * 
 * @return string The excerpt trimmed down
 */
function fox_agency_excerpt_length( $length ) {

  $excerpt = get_theme_mod('exc_length', '30');    
  return $excerpt;

}
add_filter( 'excerpt_length', 'fox_agency_excerpt_length', 999 );


/**
 * Alter the default excerpt
 * @param  string The excerpt taken from the post
 * @return string The excerpt
 */

function fox_agency_get_the_excerpt( $desc ) { 
    // Remove any left over spaces, commas or full stops
    $desc = rtrim($desc, ", . \t\n");
    // Add elipses
    $desc = $desc . '...';
    return $desc; 
}; 
add_filter( 'get_the_excerpt', 'fox_agency_get_the_excerpt', 10, 1 ); 


/**
 * Alter the default excerpt elipses. Remove so we can add in the get_the_excerpt filer
 * @param  
 * @return string new elipses
 */

function new_excerpt_more($more) {
    return '';
}
add_filter('excerpt_more', 'new_excerpt_more');



/**
 * Get the image alternative text
 * @param  id $image_id The ID of the attachment an alt tag is wanted for
 * @return string Alt of image
 */

function fox_agency_get_image_alt($image_id = null){
    
    $alt = '';
    
    if ( $image_id ) {
        
        $retrieved_alt = get_post_meta($image_id, '_wp_attachment_image_alt', true);
        
        if ( $retrieved_alt ) {
            $alt = $retrieved_alt;
        }
        
    }
    
    return $alt;
    
}


/** Share links **/
function article_social_sharing($title,$page_url){
    
    //Include the platforms you wish to share on
    $sharing_platforms = array(
        //'linkedin',
        //'google+',
        'facebook',
        'twitter',
        'email'
    );
    
    if($page_url && isset($sharing_platforms)){
?>
        <ul class="article-share">

            <?php 
            if(in_array('linkedin',$sharing_platforms)){
            ?>

                <li><a class="linkedin-share smooth external" href="http://www.linkedin.com/shareArticle?mini=true&url=<?php echo $page_url;?>&title=<?php echo $title;?>&source=<?php get_home_url(); ?>"><i class="fa fa-linkedin"></i></a></li>

            <?php 
            }
            if(in_array('google+',$sharing_platforms)){
            ?>

                <li><a class="google-share smooth external" href="https://plus.google.com/share?url=<?php echo $page_url;?>"><i class="fa fa-google-plus"></i></a></li>

            <?php 
            }
            if(in_array('facebook',$sharing_platforms)){
            ?>

                <li><a class="facebook-share smooth external" href="http://www.facebook.com/sharer/sharer.php?u=<?php echo $page_url;?>&title=<?php echo $title;?>"><i class="fa fa-facebook-f"></i></a></li>

            <?php 
            }
            if(in_array('twitter',$sharing_platforms)){
            ?>

                <li><a class="twitter-share smooth external" href="http://twitter.com/intent/tweet?status=<?php echo $title;?>+<?php echo $page_url;?>"><i class="fa fa-twitter"></i></a></li>

            <?php 
            }
            if(in_array('email',$sharing_platforms)){
            ?>

                <li><a class="email-share smooth" data-fancybox data-src="#email-pop" href="javascript:;"><i class="fa fa-envelope"></i></a></li>

            <?php  
            }  
            ?>

        </ul>

<?php
    }
}


/**
 * Loop through a multidimentional array and clean each value
 */

function clean_all($arr){
    foreach($arr as $key=>$value){
        if(is_array($value)){
            $arr[$key] = clean_all($value);
        } else {
            $arr[$key] = strip_tags($value);
        }
    }
    return $arr;
}


/** 
 * This function helps display where abouts in an archive/post list the user is.
 * 
 * For example if the user has clicked on a date filter, the function will output:
 * Date: 10/05/2017
 **/

function show_where_in_archive_filter(){
    
    //If searched
    if( get_query_var( 'lookup' ) ){ 
        $posts_search = get_query_var('lookup');
        
        return '<p class="article-filter">Searched: <span style="color: #0060ac;">' . $posts_search . '</span></p>';
    }
    
    //If filtering by taxonomy
    if( get_query_var( 'taxonomy' ) ){
    
        $posts_tax   = get_query_var( 'taxonomy' );

        if( $posts_tax ){
            $term       = get_term_by( 'slug', get_query_var( 'term' ), $posts_tax );
            $posts_cat  = $term->name;

            return '<p class="article-filter">Category: <span style="color: #0060ac;">' . $posts_cat . '</span></p>';
        }
    }
    
    //If filtered by standard category
    if( get_query_var('cat') ){
        
        $category = get_category( get_query_var('cat') );
        
        if( $category ){
            $posts_cat  = $category->name;
        
            return '<p class="article-filter">Category: <span style="color: #0060ac;">' . $posts_cat . '</span></p>'; 
        }
        
    }
        
    //If filtered by date
    if( get_query_var('year') && get_query_var('monthnum') ){
        $posts_year = get_query_var('year');
        $posts_month = get_query_var('monthnum');
        
        $dateObject     = DateTime::createFromFormat('m-Y', $posts_month . '-' . $posts_year);
        $correctFormat  = $dateObject->format('F Y');       
        
        return '<p class="article-filter">Date: <span style="color: #0060ac;">' . $correctFormat . '</span></p>';
    }
    
}

add_shortcode('fox_agency_show_filtered','show_where_in_archive_filter');
add_shortcode('fox_agency_SHOW_FILTERED','show_where_in_archive_filter');


/**
 * Get the file extention
 * @param  file Any file to get extention from
 * @return mixed return extention as string or false
 */
function get_extension($file) {
    $end = explode(".", $file);
    $extension = end( $end );
    return $extension ? $extension : false;
}


/**
 * Find a value within a multi dimentional array, by using the value and field name.
 * 
 * @param  array   $fullArray  Full multi dimentional array
 * @param  string  $find_field Field value would be in
 * @param  string  $value      Value to look for
 * @return boolean True or False
 */
function findNeedle($fullArray, $find_field, $value){
    foreach($fullArray as $key => $item){
        if(isset($item[$find_field])){ 
            if ( $item[$find_field] === $value ){
                return true;
            }
        }
    }
   return false;
}


/**
 * Clean empty spaces
 * @param  string Any string to clean
 * @return returns the clean string
 */
function empty_content($str) {
    return trim(str_replace('&nbsp;','',strip_tags($str))) == '';
}


/**
 * Turn a directory string into an array
 * 
 * http://php.net/manual/en/function.scandir.php
 * 
 * @param  string Directory to turn to array
 * @param  array Filenames of files to ignore
 * @return array Outputs an the directory split into array
 */
function dirToArray($dir, $to_ignore) { 
   
   $result = array(); 

   $cdir = scandir($dir); 
   foreach ($cdir as $key => $value) 
   { 
      if (!in_array($value,array(".",".."))) 
      { 
         if (is_dir($dir . DIRECTORY_SEPARATOR . $value)) 
         { 
            $result[$value] = dirToArray($dir . DIRECTORY_SEPARATOR . $value, $to_ignore); 
         } 
         else 
         { 
            if( !in_array( $value, $to_ignore ) ){
                $result[] = $value; 
            }
         } 
      } 
   } 
   
   return $result; 
} 