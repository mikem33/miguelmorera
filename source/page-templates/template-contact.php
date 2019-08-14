<?php
    /* Template Name: Contact */
    __( 'Contact', 'miguelmorera' ); // Template Name translation
    get_header();
    $additional_header_classes = 'flex space';
    include(locate_template('includes/page-header.php'));
    if ( function_exists( 'wpcf7_enqueue_scripts' ) ) { wpcf7_enqueue_scripts(); }
    if ( function_exists( 'wpcf7_enqueue_styles' ) ) { wpcf7_enqueue_styles(); }
?>

<?php while (have_posts()) : the_post(); ?>
    <section class="contact__section section space" data-bg-color="#1ebd3b" data-type="dark" data-scroll>
        <div class="content">
            <div class="wrapper">
                <?php the_content(); ?>
                <?php echo do_shortcode('[contact-form-7 id="286" title="Contact form" html_class="mm__form"]'); ?>
            </div> <!--  /.wrapper -->
        </div> <!--  /.content -->
    </section> <!--  /.works__list -->
<?php endwhile; ?>

<?php get_footer(); ?>