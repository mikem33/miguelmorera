<?php
    /* Template Name: Works */
    __( 'Works', 'miguelmorera' ); // Template Name translation
    get_header();
    $additional_header_classes = 'flex space';
    include(locate_template('includes/page-header.php'));
?>

<section class="works__list items section space" data-bg-color="#2e73e5" data-type="dark" data-scroll>
    <div class="items__container wrapper">
        <?php
            $work_posts_args = array(
                'post_type' => 'mm_work',
                'order' => 'DESC',
                'posts_per_page' => 6,
                'orderby' => 'date'
            );
            $work_posts_query = new WP_Query($work_posts_args);
            while ( $work_posts_query->have_posts() ) : 
                $work_posts_query->the_post();
        ?>
            <article class="work work--item item">
                <header>
                    <a href="<?php the_permalink(); ?>">
                        <h2 class="title beta"><?php the_title(); ?></h2> <!--  /.title .beta-->
                        <p><?php the_field('work_subtitle'); ?></p>
                    </a>
                </header>
                <figure>
                    <a href="<?php the_permalink(); ?>">
                        <?php the_post_thumbnail('full'); ?>
                    </a>
                </figure>
                <a href="<?php the_permalink(); ?>" class="item__link">
                    <svg width="7" height="12" class="ico"><use xlink:href="#ico-chevron" /></svg>
                    <span><?php _e( 'See work', 'miguelmorera' ); ?></span>
                </a>
            </article> <!--  /.work .work--item -->
        <?php endwhile; ?>
    </div> <!--  /.items__container -->
    <a href="<?php echo get_permalink(); ?>" class="button button--white-blue button--filled button--icon">
        <span><?php _e( 'Load more works', 'miguelmorera' ); ?></span>
        <svg width="15" height="15" class="ico"><use xlink:href="#ico-circle-arrow" /></svg>
    </a>
</section> <!--  /.works__list -->

<?php get_footer(); ?>