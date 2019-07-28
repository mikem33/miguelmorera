<?php
    /* Template Name: About */
    __( 'About', 'miguelmorera' ); // Template Name translation
    get_header(); 
?>

    <main class="main" role="main">
        
        <header class="page__header flex space" data-bg-color="<?php echo get_post_meta( get_the_ID(), 'main_page_color', true ); ?>" data-type="dark" data-scroll>
            <div class="content">
                <h1 class="title alpha"><?php the_title(); ?></h1> <!--  /.title alpha -->
                <p><?php _e( 'I’m a Frontend Developer from Alicante, Spain.', 'miguelmorera' ); ?></p>
            </div> <!--  /.content -->
        </header>
        
        <?php while (have_posts()) : the_post(); ?>
            <section class="about__section section space" data-scroll data-type="light" data-bg-color="#ffffff">
                <div class="content">
                    <?php the_content(); ?>
                </div> <!--  /.content -->
                <a href="<?php echo get_permalink(); ?>" class="button button--purple button--filled button--icon">
                    <span><?php _e( 'See some of my thoughts', 'miguelmorera' ); ?></span>
                    <svg width="15" height="15" class="ico"><use xlink:href="#ico-circle-arrow" /></svg>
                </a>
            </section> <!--  /.works__list -->
        <?php endwhile; ?>

    </main> <!--  /.main -->

<?php get_footer(); ?>