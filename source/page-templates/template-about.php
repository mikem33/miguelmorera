<?php
    /* Template Name: About */
    __( 'About', 'miguelmorera' ); // Template Name translation
    get_header();
    $additional_header_classes = 'flex space';
    include(locate_template('includes/page-header.php'));
?>

<?php while (have_posts()) : the_post(); ?>
    <section class="about__section section space" data-bg-color="#ffffff" data-type="light" data-scroll>
        <div class="content">
            <?php the_content(); ?>
        </div> <!--  /.content -->
        <a href="<?php echo get_permalink(); ?>" class="button button--purple button--filled button--icon">
            <span><?php _e('See some of my thoughts', 'miguelmorera'); ?></span>
            <svg width="15" height="15" class="ico"><use xlink:href="#ico-circle-arrow" /></svg>
        </a>
    </section> <!--  /.works__list -->
<?php endwhile; ?>

<?php get_footer(); ?>