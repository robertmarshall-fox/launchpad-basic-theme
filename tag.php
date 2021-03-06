<?php
/**
 * The template for displaying Category Archive pages.
 *
 * @package FoxAgency
 * @since FoxAgency 1.0.0
 */

get_header(); ?>

<section id="primary">
    <main id="content" role="main">
        
        <div class="page-inner-wrap">

            <?php if ( have_posts() ) { ?>

                <header class="page-header">
                   <?php
                        the_archive_title( '<h1 class="page-title">', '</h1>' );
                        $tag_description = tag_description();
                        if ( ! empty( $tag_description ) ) {
                            echo apply_filters( 'tag_archive_meta', '<div class="tag-archive-meta">' . $tag_description . '</div>' );
                        }
                    ?>
                </header>
                
                <div id="ajax-post-wrap"  class="grid-container masonry basic">
               
                    <?php /* Start the Loop */ ?>
                    <?php while ( have_posts() ) : the_post(); ?>

                        <?php
                            /* Include the Post-Format-specific template for the content.
                             * If you want to overload this in a child theme then include a file
                             * called content-___.php (where ___ is the Post Format name) and that will be used instead.
                             */
                            get_template_part( 'template-parts/post/module', get_post_format() );
                        ?>

                    <?php endwhile; ?>

                </div>
               
                <?php 
                fox_agency_content_nav( 'nav-below', 'load-more' );

            } else {

                get_template_part( 'template-parts/post/content', 'none' );

            } ?>
        
        </div>

    </main>
</section>

<?php get_footer(); ?>