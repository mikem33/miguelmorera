<?php get_header(); ?>
    
    <div class="wrapper">
        <header>
            <h1 class="page-title"><?php _e('Page not found','prometheus'); ?></h1>
        </header><!-- .head-title -->
        <article class="content">
            <p><?php _e('We are sorry but the page that you are looking for is not found or is not available at this moment.','prometheus'); ?></p>
            <?php get_search_form(); ?>
        </article>
    </div>

<?php get_footer(); ?>