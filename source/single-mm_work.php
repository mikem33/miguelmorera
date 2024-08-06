<?php 
    get_header();
    $additional_header_classes = 'flex space';
    include(locate_template('includes/page-header.php'));
?>

<?php if (have_posts()) : ?>
    <?php while (have_posts()) : the_post(); ?>
        <article id="content" class="work work--single post">
            <?php if (get_field('work_intro')) : ?>
                <section class="work__intro section space" data-bg-color="#fff2f2" data-type="light" data-scroll>
                    <div class="wrapper">
                        <div class="work__meta">
                            <?php if (get_field('work_year')) : ?>
                                <div class="work__year">
                                    <span><?php _e('Año','prometheus'); ?></span>
                                    <h4 class="delta"><?php the_field('work_year'); ?></h4>
                                </div> <!--  /.year -->
                            <?php endif; ?>
                            <?php if (get_field('work_client')) : ?>
                                <div class="work__client">
                                    <span><?php _e('Cliente','prometheus'); ?></span>
                                    <h4 class="delta"><?php the_field('work_client'); ?></h4>
                                </div> <!--  /.client -->
                            <?php endif; ?>
                            <?php if (get_field('work_website')) : ?>
                                <?php 
                                    $work_website = get_field('work_website'); 
                                    $target = ($work_website['target'] == '_blank' ? ' target="_blank"':'');
                                ?>
                                <div class="work__website">
                                    <span><?php _e('Página web','prometheus'); ?></span>
                                    <h4 class="delta"><a href="<?php echo $work_website['url']; ?>"<?php echo $target; ?>><?php echo $work_website['title']; ?></a></h4>
                                </div> <!--  /.client -->
                            <?php endif; ?>
                        </div> <!--  /.meta -->
                        <?php the_field('work_intro'); ?>
                    </div> <!--  /.wrapper -->
                </section> <!--  /.work__intro -->
            <?php endif; ?>
            <section class="work__content section space" data-bg-color="#ffffff" data-type="light" data-scroll>
                <div class="wrapper">
                    <?php the_content(); ?>
                </div> <!--  /.wrapper -->
            </section> <!--  /.container -->
            <?php if (get_field('work_outro')) : ?>
                <section class="work__outro section space" data-bg-color="#fff2f2" data-type="light" data-scroll>
                    <div class="wrapper">
                        <?php the_field('work_outro'); ?>
                    </div> <!--  /.wrapper -->
                </section> <!--  /.work__outro -->
            <?php endif; ?>
        </article><!-- .post -->
    <?php endwhile; ?>
<?php endif; ?>

<?php get_footer(); ?>