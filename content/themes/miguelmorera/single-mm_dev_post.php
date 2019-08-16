<?php 
    get_header();
    $additional_header_classes = 'flex space';
    include(locate_template('includes/page-header.php'));
?>

<?php if (have_posts()) : ?>
    <?php while (have_posts()) : the_post(); ?>
        <article id="content" class="post dev-post--single post section space" data-bg-color="#ffffff" data-type="light" data-scroll>
            <div class="wrapper">
                <?php the_content(); ?>
            </div> <!--  /.wrapper -->
        </article><!-- .post -->
        <?php comments_template('', true); ?>
    <?php endwhile; ?>
<?php endif; ?>

<?php get_footer(); ?>