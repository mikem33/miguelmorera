<?php
    /* Template Name: Home */
    __( 'Home', 'miguelmorera' ); // Template Name translation
    get_header(); 
?>
    
    <main class="main" role="main">
        
        <header class="page__header page__header--hero flex space">
            <div class="content">
                <span class="alpha-warning"><?php _e( 'Alpha', 'miguelmorera' ); ?></span>
                <h1 class="title alpha"><?php _e( 'Hi, my name is Miguel Morera.', 'miguelmorera' ); ?></h1> <!--  /.title alpha -->
                <p><?php _e('I’m a Frontend Web Developer focused on create beautiful and usable websites.','miguelmorera'); ?></p>
                <a href="javascript:;" class="button button--white-purple button--filled button--icon">
                    <span><?php _e( 'See my works', 'miguelmorera' ); ?></span>
                    <svg width="15" height="15" class="ico"><use xlink:href="#ico-circle-arrow" /></svg>
                </a>
            </div> <!--  /.content -->
            <a href="#content" class="content-anchor">
                <svg width="20" height="20" class="ico"><use xlink:href="#ico-circle-chevron" /></svg>
            </a>
            <canvas class="header-circles"></canvas> <!--  /.header-circles -->
        </header> <!--  /.page__header -->

        <section class="home__blog section space" id="content">
            <header class="section__header">
                <h3 class="title"><?php _e( 'Eventually I like to write down some thoughts...', 'miguelmorera' ); ?></h3>
            </header> <!--  /.section__header -->
            <div class="content">
                <?php
                    $home_posts_args = array(
                        'post_type' => 'post',
                        'order' => 'DESC',
                        'posts_per_page' => 2,
                        'orderby' => 'date'
                    );
                    $home_posts_query = new WP_Query($home_posts_args);
                    while ( $home_posts_query->have_posts() ) : 
                        $home_posts_query->the_post();
                ?>
                <article class="post post--home">
                    <figure>
                        <a href="<?php the_permalink(); ?>">
                            <?php the_post_thumbnail('full'); ?>
                        </a>
                    </figure>
                    <h2 class="title beta"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2> <!--  /.title .beta-->
                    <div class="meta">
                        <time datetime="<?php echo date(DATE_W3C); ?>" pubdate><?php the_time('j M, Y') ?></time>
                        <span class="reading-time"><?php echo reading_time(); ?></span>
                    </div> <!--  /.meta -->
                    <div class="content">
                        <?php the_excerpt(); ?>
                    </div> <!--  /.content -->
                    <a href="<?php the_permalink(); ?>" class="item__link">
                        <svg width="7" height="12" class="ico"><use xlink:href="#ico-chevron" /></svg>
                        <span><?php _e( 'Continue reading', 'miguelmorera' ); ?></span>
                    </a>
                </article>
                <?php endwhile; ?>
            </div> <!--  /.content -->
        </section> <!--  /.home__blog -->

    </main> <!--  /.main -->

<?php get_footer(); ?>