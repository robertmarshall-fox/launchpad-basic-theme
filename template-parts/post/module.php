<?php
/**
 * Template part for displaying posts in module blocks
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 * @link https://codex.wordpress.org/Function_Reference/get_post_gallery_images
 * @link https://codex.wordpress.org/Function_Reference/get_post_gallery
 *
 * @package FoxAgency
 * @since FoxAgency 1.0.0
 */

$module_class = get_post_format();
if ( $module_class ) {
    $module_class = ' module-' . $module_class;
} else {
    $module_class = ' module';
}

?>

<article class="c-3<?php echo $module_class; ?>" <?php schema_semantics_tags( 'post' );?> itemref="site-publisher">

    <a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Link to %s', fox_agency_text_domain() ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark" itemprop="url">

        <?php fox_agency_the_module_image(); ?>

        <div class="entry-text">

            <?php fox_agency_module_posted_details(); ?>

            <h2 class="entry-title p-name smooth" itemprop="name headline"><?php the_title(); ?></h2>

            <?php if( get_the_excerpt() ){ ?>
                <p><?php echo get_the_excerpt(); ?></p>
            <?php } ?>
        </div>
	
	    <div class="line smooth"></div>
	
	</a>
	
</article>