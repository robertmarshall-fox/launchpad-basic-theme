<?php 
/** 
 * Template Name: Home
 * 
 * The template for displaying the home page.
 * 
 * @link https://developer.wordpress.org/reference/functions/query_posts/
 * 
 * @package FoxAgency
 * @since FoxAgency 1.0.0
 */ 

get_header(); ?>
      
<section id="primary">
    <main id="content" role="main">

        <?php build_all_acf_flexible_modules( get_the_ID() );?> 
       
        <div class="page-inner-wrap">
            
            <?php
            
            /**
             * Here we show the home content first
             **/
                        
            if ( have_posts() ){
                               
                /* Start the Loop */
                while ( have_posts() ) : the_post();

                    if( !empty_content ($post->post_content) ){
                        
                        /* Include the Post-Format-specific template for the content.
                         * If you want to overload this in a child theme then include a file
                         * called content-___.php (where ___ is the Post Format name) and that will be used instead.
                         */
                        get_template_part( 'template-parts/page/content', 'page-home' );

                    }
                
                endwhile;

            }
            
            /**
             * Now lets get the home loop
             **/
                                    
            $args = array(
                'category_name' => 'home',
            );

            query_posts( $args );

            if ( have_posts()  ) { 
                ?>
               
                <div id="ajax-post-wrap" class="gc eq">
                                                          
                    <!-- modules -->
                    <?php
                    while ( have_posts() ) : the_post();

                        get_template_part( 'template-parts/post/module', 'home' );

                    endwhile
                    ?>

                </div>

                <?php

            }

            //Clean up post
            wp_reset_query();
                
            ?>           
                        
        </div>

    </main><!-- #main -->
</section><!-- #primary -->

<?php get_footer();