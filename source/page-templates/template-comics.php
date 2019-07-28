<?php
    /* Template Name: Comics */
    __( 'Comics', 'miguelmorera' ); // Template Name translation
    get_header(); 
?>

    <main class="main" role="main">
        
        <header class="page__header flex space" data-bg-color="<?php echo get_post_meta( get_the_ID(), 'main_page_color', true ); ?>" data-type="light" data-scroll>
            <div class="content">
                <h1 class="title alpha"><?php the_title(); ?></h1> <!--  /.title alpha -->
                <p><?php _e( 'From time to time I draw short comics. Eventually I will be updating this section.', 'miguelmorera' ); ?></p>
            </div> <!--  /.content -->
        </header>

        <section class="comics__list comics__section section space" data-scroll data-type="dark" data-bg-color="#ffe42b">

            <div class="content">
                <?php
                    $comic_posts_args = array(
                        'post_type' => 'mm_comic',
                        'order' => 'DESC',
                        'posts_per_page' => 6,
                        'orderby' => 'date'
                    );
                    $comic_posts_query = new WP_Query($comic_posts_args);
                    while ( $comic_posts_query->have_posts() ) : 
                        $comic_posts_query->the_post();
                ?>
                    <article class="comic comic--item item">
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
                    </article> <!--  /.comic comic--item item -->
                <?php endwhile; ?>
            </div> <!--  /.content -->
            <a href="<?php echo get_permalink(); ?>" class="button button--dark-grey button--filled button--icon">
                <span><?php _e( 'Load more works', 'miguelmorera' ); ?></span>
                <svg width="15" height="15" class="ico"><use xlink:href="#ico-circle-arrow" /></svg>
            </a>
        </section> <!--  /.comics__list -->

    </main> <!--  /.main -->

<?php get_footer(); ?>