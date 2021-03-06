<?php
/**
 * The template for displaying 404 pages.
 *
 * @package FoxAgency
 * @since FoxAgency 1.0.0
 */

get_header(); ?>

<section id="primary" class="full-width">
    <main id="content" role="main">

        <div class="page-inner-wrap">

            <article id="post-0" class="post error404 not-found">
                <header class="entry-header">
                    <h1 class="entry-title p-entry-title"><?php _e( 'It looks like we got you lost. Sorry!', fox_agency_text_domain() ); ?></h1>
                </header>

                <div class="entry-content e-entry-content">

                    <p><?php _e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help. If not, try the menu above.', fox_agency_text_domain() ); ?></p>

                    <?php main_search_form(); ?>

                    <?php the_widget( 'WP_Widget_Recent_Posts' ); ?>

                </div>
            </article>

        </div>

    </main>
</section>

<?php get_footer(); ?>