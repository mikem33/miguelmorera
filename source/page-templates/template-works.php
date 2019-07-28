<?php
    /* Template Name: Works */
    __( 'Works', 'miguelmorera' ); // Template Name translation
    get_header(); 
?>

    <main class="main" role="main">
        
        <header class="page__header flex space" data-bg-color="<?php echo get_post_meta( get_the_ID(), 'main_page_color', true ); ?>" data-type="dark" data-scroll>
            <div class="content">
                <h1 class="title alpha"><?php _e( 'Works', 'miguelmorera' ); ?></h1> <!--  /.title alpha -->
                <p><?php _e( 'In this section you will find a list of projects developed during all my career as a freelance and others as an employed worker.', 'miguelmorera' ); ?></p>
            </div> <!--  /.content -->
        </header>

        <section class="works__list works__section section space" data-scroll data-type="light" data-bg-color="#ffffff">
            
            <div class="content">
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
                    <article class="work item">
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
                    </article> <!--  /.work -->
                <?php endwhile; ?>
            </div> <!--  /.content -->
            <a href="<?php echo get_permalink(); ?>" class="button button--purple button--filled button--icon">
                <span><?php _e( 'Load more works', 'miguelmorera' ); ?></span>
                <svg width="15" height="15" class="ico"><use xlink:href="#ico-circle-arrow" /></svg>
            </a>
        </section> <!--  /.works__list -->

    </main> <!--  /.main -->

<?php get_footer(); ?>