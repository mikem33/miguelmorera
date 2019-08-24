<?php 
    get_header();
    $additional_header_classes = 'flex space';
    include(locate_template('includes/page-header.php'));
?>
    
<section class="posts__list posts__section section space">
    <?php if (have_posts()) : ?>
        <?php while (have_posts()) : the_post(); ?>
            <article id="post-<?php the_ID(); ?>" class="post post--item item">
                <figure>
                    <a href="<?php the_permalink(); ?>">
                        <?php the_post_thumbnail('full'); ?>
                    </a>
                </figure>
                <h2 class="title beta"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php _e('Permanent link to','prometheus'); ?> <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
                <div class="meta">
                    <time datetime="<?php echo date(DATE_W3C); ?>" pubdate><?php the_time('j M, Y') ?></time>
                    <span class="reading-time"><?php echo reading_time(); ?></span>
                </div> <!--  /.meta -->
                <div class="content">
                    <?php 
                        $page_header_stuff =  get_field('page_header_stuff', get_the_ID());
                        echo $page_header_stuff['page_header_text'];
                    ?>
                </div>
                <a href="<?php the_permalink(); ?>" class="item__link">
                    <svg width="7" height="12" class="ico"><use xlink:href="#ico-chevron" /></svg>
                    <span><?php _e( 'Continue reading', 'prometheus' ); ?></span>
                </a>
            </article><!-- .post .post--item .item -->
        <?php endwhile; ?>

        <nav>
            <p><?php posts_nav_link('&nbsp;&bull;&nbsp;'); ?></p>
        </nav>

    <?php else : ?>

        <article class="post">
            <h2 class="title beta"><?php _e('Not found.','prometheus'); ?></h1>
            <p><?php _e('We are sorry, but we haven&apos;t found what are you looking for.','prometheus'); ?></p>
        </article>

    <?php endif; ?>
</section> <!--  /.posts__list posts__section section space -->

<?php get_footer(); ?>
