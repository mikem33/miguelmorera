<?php get_header(); ?>
    <div class="wrapper">
        <?php if (have_posts()) : ?>
            <header>
                <?php 
                    $post = $posts[0]; // hack: set $post so that the_date() works
                    if (is_category()) : 
                ?>
                    <h1 class="page-title"><?php _e('Archivo de la Categoría','miguelmorera'); ?> &ldquo;<?php single_cat_title(); ?>&rdquo;</h1>
                <?php elseif (is_tag()) : ?>
                    <h1 class="page-title"><?php _e('Entradas etiquetadas con','miguelmorera'); ?> &ldquo;<?php single_tag_title(); ?>&rdquo;</h1>
                <?php elseif (is_day()) : ?>
                    <h1 class="page-title"><?php _e('Archivo de fecha','miguelmorera'); ?> <?php the_time('F jS, Y'); ?></h1>
                <?php elseif (is_month()) : ?>
                    <h1 class="page-title"><?php _e('Archivo de','miguelmorera'); ?> <?php the_time('F, Y'); ?></h1>
                <?php elseif (is_year()) : ?>
                    <h1 class="page-title"><?php _e('Archivo del año','miguelmorera'); ?> <?php the_time('Y'); ?></h1>
                <?php elseif (is_author()) : ?>
                    <h1 class="page-title"><?php _e('Archivo por Autor','miguelmorera'); ?></h1>
                <?php elseif (isset($_GET['paged']) && !empty($_GET['paged'])) : ?>
                    <h1 class="page-title"><?php _e('Archivos de Blog','miguelmorera'); ?></h1>
                <?php endif; ?>
            </header><!-- #head-title -->
            <?php while (have_posts()) : the_post(); ?>

                <article id="post-<?php the_ID(); ?>" class="post">
                    <header>
                        <h2><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php _e('Enlace permanente a','miguelmorera'); ?> <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
                        <p><?php _e('Publicado el','miguelmorera'); ?> <?php the_time('F jS, Y'); ?></p>
                    </header>
                    <div class="content">
                        <?php the_excerpt(); ?>
                    </div>
                    <footer>
                        <p><?php _e('Publicado bajo la/s categoría/s','miguelmorera'); ?> <?php the_category(', '); ?> &bull; <?php edit_post_link('Edit', '', ' &bull; '); ?> <?php comments_popup_link(__('Responder a este post &raquo;','miguelmorera'), __('1 Respuesta &raquo;','miguelmorera'), __('% Respuestas &raquo;','miguelmorera')); ?></p>
                    </footer>
                </article>

            <?php endwhile; ?>

            <nav>
                <p><?php posts_nav_link('&nbsp;&bull;&nbsp;'); ?></p>
            </nav>

        <?php else : ?>

            <article class="post">
                <h1><?php _e('No se ha encontrado.','miguelmorera'); ?></h1>
                <p><?php _e('Lo sentimos, pero el recurso solicitado no se encuentra.','miguelmorera'); ?></p>
                <?php get_search_form(); ?>
            </article>

        <?php endif; ?>
    </div><!-- .wrapper -->
    
<?php get_footer(); ?>
