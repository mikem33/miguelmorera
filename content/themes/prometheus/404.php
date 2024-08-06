<?php get_header(); ?>
    
    <div class="wrapper">
        <header>
            <h1 class="page-title"><?php _e('Página no encontrada','prometheus'); ?></h1>
        </header><!-- .head-title -->
        <article class="content">
            <p><?php _e('Lo sentimos pero la página que estabas buscando no se ha encontrado o no está disponible en este momento.','prometheus'); ?></p>
            <?php get_search_form(); ?>
        </article>
    </div>

<?php get_footer(); ?>