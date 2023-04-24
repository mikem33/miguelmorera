<?php
    /* Template Name: Contact */
    __( 'Contact', 'prometheus' ); // Template Name translation
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
            </div> <!--  /.wrapper -->
        </div> <!--  /.content -->
    </section> <!--  /.works__list -->
<?php endwhile; ?>

<?php get_footer(); ?>