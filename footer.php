<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #page-wrapper div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package FoxAgency
 * @since FoxAgency 1.0.0
 */

?>   
        </div> <!-- Page Wrapper Close -->        
        
    </div> <!-- Footer Pusher Close -->    
    
    <footer id="colophon" role="contentinfo">

        <div id="site-publisher" class="page-inner-wrap" itemprop="publisher" itemscope itemtype="https://schema.org/Organization">

            <meta itemprop="name" content="<?php echo get_bloginfo( 'name', 'display' ); ?>" />
            <meta itemprop="url" content="<?php echo home_url( '/' ); ?>" />
            
            <p class="copyright external" xmlns:dct="http://purl.org/dc/terms/" href="http://purl.org/dc/dcmitype/Text" property="dct:title" rel="dct:type"><a href="http://www.fox.agency" property="cc:attributionName" rel="cc:attributionURL">Copyright Fox Agency</p>
            
            <p class="custom"><?php echo get_theme_mod('fox_agency_footer'); ?></p>

        </div>

    </footer>      

    <a class="toTop smooth"><i class="fa fa-angle-up"></i></a>
        
    <?php wp_footer();?>
    
    <?php echo get_theme_mod('fox_agency_scripts_footer', ''); ?>
 
</body>
</html>