<?php
    get_header();
    $additional_header_classes = 'flex space';
    include(locate_template('includes/page-header.php'));
?>

<?php while (have_posts()) : the_post(); ?>
    <section class="page__section section space" data-bg-color="#ffffff" data-type="light" data-scroll>
        <div class="content">
            <?php the_content(); ?>
        </div> <!--  /.content -->
    </section> <!--  /.page__list -->
<?php endwhile; ?>

<?php get_footer(); ?>