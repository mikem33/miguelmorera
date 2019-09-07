<?php
    /* Template Name: Diaries */
    __( 'Diaries', 'prometheus' ); // Template Name translation
    get_header(); 
    $additional_header_classes = 'flex space';
    include(locate_template('includes/page-header.php'));
?>

<section class="diaries__list diaries__section items section space" data-bg-color="#ffffff" data-type="light" data-scroll>
    <div class="wrapper">
        <?php
            $diary_posts_args = array(
                'post_type' => 'mm_diary',
                'order' => 'DESC',
                'posts_per_page' => 10,
                'orderby' => 'date'
            );
            $diary_posts_query = new WP_Query($diary_posts_args);
            while ($diary_posts_query->have_posts()) : 
                $diary_posts_query->the_post();
        ?>
            <article class="diary item">
                <h2 class="title beta"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2> <!--  /.title .beta-->
                <div class="meta">
                    <time datetime="<?php echo date(DATE_W3C); ?>" pubdate><?php the_time('j M, Y') ?></time>
                    <span class="reading-time"><?php echo reading_time(); ?></span>
                </div> <!--  /.meta -->
            </article> <!--  /.diary diary--item item -->
        <?php endwhile; ?>
    </div> <!--  /.content -->
</section> <!--  /.diaries__list -->

<?php get_footer(); ?>