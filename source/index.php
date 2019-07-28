<?php get_header(); ?>
    
    <main class="main" role="main">

        <header class="page__header flex space" data-bg-color="<?php echo get_post_meta( get_option('page_for_posts', true), 'main_page_color', true ); ?>" data-type="dark" data-scroll>
            <div class="content">
                <h1 class="title alpha"><?php echo get_the_title( get_option('page_for_posts', true) ); ?></h1> <!--  /.title alpha -->
                <p><?php _e( 'I like to talk of several topics so this is the place where I will write down some of them.', 'miguelmorera' ); ?></p>
            </div> <!--  /.content -->
        </header>

        <section class="posts__list posts__section section space" data-scroll data-bg-color="#f45a5a" data-type="dark">
            <div class="content">
            <?php while (have_posts()) : the_post(); ?>
                <article id="post-<?php the_ID(); ?>" class="post post--item item">
                    <figure>
                        <a href="<?php the_permalink(); ?>">
                            <?php the_post_thumbnail('full'); ?>
                        </a>
                    </figure>
                    <h2 class="title beta"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php _e('Permanent link to','miguelmorera'); ?> <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
                    <div class="meta">
                        <time datetime="<?php echo date(DATE_W3C); ?>" pubdate><?php the_time('j M, Y') ?></time>
                        <span class="reading-time"><?php echo reading_time(); ?></span>
                    </div> <!--  /.meta -->
                    </header>
                    <div class="content">
                        <?php the_excerpt(); ?>
                    </div><!-- .post-content -->
                    <a href="<?php the_permalink(); ?>" class="item__link">
                        <svg width="7" height="12" class="ico"><use xlink:href="#ico-chevron" /></svg>
                        <span><?php _e( 'Continue reading', 'miguelmorera' ); ?></span>
                    </a>
                </article><!-- .post -->
            <?php endwhile; ?>
            </div> <!--  /.content -->

            <nav class="navigation">
                <div class="next-posts"><?php next_posts_link(__('Página Siguiente &raquo;', 'miguelmorera')) ?></div>
                <div class="prev-posts"><?php previous_posts_link(__('&laquo; Página Anterior', 'miguelmorera')) ?></div>
            </nav>

        </section> <!--  /.works__list -->

    </main> <!--  /.main -->

<?php get_footer(); ?>