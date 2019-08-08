<?php 
    get_header();
    $additional_header_classes = 'flex space';
    include(locate_template('includes/page-header.php'));
?>

<?php if (have_posts()) : ?>
    <?php while (have_posts()) : the_post(); ?>
        <article id="content" class="work work--single">
            <?php if (get_field('work_intro')) : ?>
                <div class="work__intro section space" data-bg-color="#fff2f2" data-type="light" data-scroll>
                    <div class="wrapper">
                        <?php the_field('work_intro'); ?>
                    </div> <!--  /.wrapper -->
                </div> <!--  /.work__intro -->
            <?php endif; ?>
            <div class="container section space" data-bg-color="#ffffff" data-type="light" data-scroll>
                <div class="wrapper">
                    <?php the_content(); ?>
                </div> <!--  /.wrapper -->
            </div> <!--  /.container -->
            <?php if (get_field('work_outro')) : ?>
                <div class="work__outro" data-bg-color="#fff2f2" data-type="light" data-scroll>
                    <div class="wrapper">
                        <?php the_field('work_outro'); ?>
                    </div> <!--  /.wrapper -->
                </div> <!--  /.work__outro -->
            <?php endif; ?>
        </article><!-- .post -->
    <?php endwhile; ?>
<?php endif; ?>

<?php get_footer(); ?>