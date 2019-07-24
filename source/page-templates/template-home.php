<?php
    /* Template Name: Home */
    __( 'Home', 'miguelmorera' ); // Template Name translation
    get_header(); 
?>
    
    <main class="main" role="main">
        
        <header class="page__header page__header--hero flex space" data-bg-color="<?php echo get_post_meta( get_the_ID(), 'main_page_color', true ); ?>" data-type="dark" data-scroll>
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

        <section class="home__blog home__section section space" id="content" data-bg-color="#f45a5a" data-type="dark" data-scroll>
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
                <article class="post post--home item">
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
                </article><!-- /.post .post--home .item -->
                <?php endwhile; wp_reset_postdata(); ?>
            </div> <!--  /.content -->
            <a href="<?php echo get_permalink(); ?>" class="button button--white-red button--filled button--icon">
                <span><?php _e( 'See more posts', 'miguelmorera' ); ?></span>
                <svg width="15" height="15" class="ico"><use xlink:href="#ico-circle-arrow" /></svg>
            </a>
        </section> <!--  /.home__blog .home__section -->
        
        <section class="home__comics home__section section space" data-scroll data-type="light" data-bg-color="#ffffff">
            <header class="section__header">
                <h3 class="title"><?php _e('...or draw some comics','miguelmorera'); ?></h3> <!--  /.title -->
            </header> <!--  /.section__header -->
            <div class="content">
                <?php
                    $home_comics_args = array(
                        'post_type' => 'mm_comic',
                        'order' => 'DESC',
                        'posts_per_page' => 2,
                        'orderby' => 'date'
                    );
                    $home_comics_query = new WP_Query($home_comics_args);
                    while ( $home_comics_query->have_posts() ) : 
                        $home_comics_query->the_post();
                ?>
                <article class="comic comic--home item">
                    <figure>
                        <a href="<?php the_permalink(); ?>">
                            <?php the_post_thumbnail('full'); ?>
                        </a>
                    </figure>
                    <h2 class="title beta"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2> <!--  /.title .beta-->
                    <div class="meta">
                        <time datetime="<?php echo date(DATE_W3C); ?>" pubdate><?php the_time('j M, Y') ?></time>
                        <div class="categories">
                        <?php 
                            $count = 0;
                            $get_terms = wp_get_post_terms( get_the_ID(), 'mm_comic_category' ); 
                            $total_terms = count($get_terms);
                            foreach ( $get_terms as $term ) :
                        ?>
                            <span>
                                <a href="<?php echo get_term_link( $term->term_id ); ?>"><?php echo $term->name; ?></a><?php if ( $total_terms > 1 && $count < $total_terms - 1 ) : ?>,<?php endif; ?>
                            </span>
                        <?php $count++; endforeach; ?>
                        </div> <!--  /.categories -->
                    </div> <!--  /.meta -->
                    <div class="content">
                        <?php the_excerpt(); ?>
                    </div> <!--  /.content -->
                </article> <!--  /.comic comic--home item -->
                <?php endwhile; ?>
            </div> <!--  /.content -->
            <a href="<?php echo get_permalink(); ?>" class="button button--purple button--filled button--icon">
                <span><?php _e( 'See more comics', 'miguelmorera' ); ?></span>
                <svg width="15" height="15" class="ico"><use xlink:href="#ico-circle-arrow" /></svg>
            </a>
        </section> <!--  /.home__comics home__section section space -->

    </main> <!--  /.main -->

<?php get_footer(); ?>