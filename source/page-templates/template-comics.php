<?php
    /* Template Name: Comics */
    __( 'Comics', 'miguelmorera' ); // Template Name translation
    get_header(); 
    $additional_header_classes = 'flex space';
    include(locate_template('includes/page-header.php'));
?>

<section class="comics__list comics__section items section space" data-bg-color="#ffe42b" data-type="dark" data-scroll>
    <div class="items__container wrapper">
        <?php
            $comic_posts_args = array(
                'post_type' => 'mm_comic',
                'order' => 'DESC',
                'posts_per_page' => 6,
                'orderby' => 'date'
            );
            $comic_posts_query = new WP_Query($comic_posts_args);
            while ($comic_posts_query->have_posts()) : 
                $comic_posts_query->the_post();
        ?>
            <article class="comic item">
                <figure>
                    <a href="<?php the_permalink(); ?>">
                        <?php mm_post_thumbnail(get_the_ID()); ?>
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
                        <p>
                            <a href="<?php echo get_term_link($term->term_id); ?>">
                                <?php echo $term->name; ?>
                            </a>
                            <?php echo ($total_terms > 1 && $count < $total_terms - 1 ? ',':''); ?>
                        </p>
                    <?php $count++; endforeach; ?>
                    </div> <!--  /.categories -->
                </div> <!--  /.meta -->
                <div class="content">
                    <?php 
                        $page_header_stuff =  get_field('page_header_stuff', get_the_ID());
                        echo $page_header_stuff['page_header_text'];
                    ?>
                </div> <!--  /.content -->
                <a href="<?php the_permalink(); ?>" class="item__link">
                    <svg width="7" height="12" class="ico"><use xlink:href="#ico-chevron" /></svg>
                    <span><?php _e('Read comic', 'miguelmorera'); ?></span>
                </a>
            </article> <!--  /.comic comic--item item -->
        <?php endwhile; ?>
    </div> <!--  /.content -->
    <a href="<?php echo get_permalink(); ?>" class="button button--dark-grey-brown button--filled button--icon">
        <span><?php _e('Load more works', 'miguelmorera'); ?></span>
        <svg width="15" height="15" class="ico"><use xlink:href="#ico-circle-arrow" /></svg>
    </a>
</section> <!--  /.comics__list -->

<?php get_footer(); ?>