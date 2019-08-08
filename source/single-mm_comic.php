<?php 
    get_header();
    $additional_header_classes = 'flex space';
    include(locate_template('includes/page-header.php'));
?>

<?php if (have_posts()) : ?>
    <?php while (have_posts()) : the_post(); ?>
        <article id="content" class="comic comic--single section space" data-bg-color="#ffffff" data-type="light" data-scroll>
            <?php the_post_thumbnail('full'); ?>
            <div class="wrapper">
                <?php the_content(); ?>
            </div> <!--  /.wrapper -->
        </article><!-- .post -->
    <?php endwhile; ?>
<?php endif; ?>

<?php get_footer(); ?>