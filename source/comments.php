<?php 
    // Do not delete these lines
    if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
        die ('Please do not load this page directly. Thanks!');
    if (!empty($post->post_password)) {
        if ($_COOKIE['wp-postpass_' . COOKIEHASH] != $post->post_password) { ?>
            <p class="nocomments"><?php _e('This posts is protected with password. Enter the password to see the comments.','miguelmorera'); ?></p>
            <?php return;
        }
    }    
?>

<?php if ('open' == $post->comment_status) : ?>

    <section class="post__comment-form space" id="commentform">
        <header>
            <h3 class="title alpha"><?php _e('Maybe you would like to leave a comment','miguelmorera'); ?></h3>
            <small><?php _e('The fields marked with an asterisk (*) are required.','miguelmorera'); ?></small>
        </header>
        <?php if (get_option('comment_registration') && !$user_ID) : ?>
            <p><?php _e('You must','miguelmorera'); ?> <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?redirect_to=<?php echo urlencode(get_permalink()); ?>"><?php _e('register or log in','miguelmorera'); ?></a> <?php _e('to leave a comment.','miguelmorera'); ?></p>
        <?php else : ?>
            <form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" class="mm__form" method="post">
                <?php if ($user_ID) : ?>
                    <p><?php _e('You are now logged in as','miguelmorera'); ?> <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>. <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?action=logout" title="<?php _e('Log out on this account','miguelmorera'); ?>"><?php _e('Log out &raquo;','miguelmorera'); ?></a></p>
                <?php else : ?>
                    <fieldset class="fieldset fieldset--text">
                        <label for="author"><?php _e('Name*','miguelmorera'); ?></label>
                        <input type="text" name="author" id="author" value="<?php echo $comment_author; ?>" size="55" tabindex="1" placeholder="<?php _e('Name*','miguelmorera'); ?>" <?php if ($req) echo "aria-required='true'"; ?>>
                    </fieldset> <!--  /.fieldset fieldset--text -->
                    <fieldset class="fieldset fieldset--email">
                        <label for="email"><?php _e('E-mail*','miguelmorera'); ?></label>
                        <input type="text" name="email" id="email" value="<?php echo $comment_author_email; ?>" size="55" tabindex="2" placeholder="<?php _e('E-mail*','miguelmorera'); ?>" <?php if ($req) echo "aria-required='true'"; ?>>
                    </fieldset> <!--  /.fieldset fieldset--email -->
                    <fieldset class="fieldset fieldset--text">
                        <label for="url"><?php _e('Website','miguelmorera'); ?></label>
                        <input type="text" name="url" id="url" value="<?php echo $comment_author_url; ?>" size="55" tabindex="3" placeholder="<?php _e('Website','miguelmorera'); ?>">
                    </fieldset> <!--  /.fieldset fieldset--text -->
                <?php endif; ?>
                <fieldset class="fieldset fieldset--textarea">
                    <label for="comment"><?php _e('Comment*','textdomain'); ?></label>
                    <textarea name="comment" id="comment" cols="55" rows="10" tabindex="4" placeholder="<?php _e('Comment*','miguelmorera'); ?>"></textarea>
                </fieldset> <!--  /.fieldset fieldset--textarea -->
                <button type="submit" class="button button--dark-grey button--filled button--icon">
                    <span><?php _e('Send comment','miguelmorera'); ?></span>
                    <svg width="15" height="15" class="ico"><use xlink:href="#ico-circle-arrow" /></svg>
                </button>
                <input type="hidden" name="comment_post_ID" value="<?php echo $id; ?>">
                <?php do_action('comment_form', $post->ID); ?>
            </form>
        <?php endif; ?>

    </section><!-- .post__comment-form -->
<?php endif; ?>

<?php if ($comments) : // there are comments ?>

    <section class="post__comments-list commentslist section space">
        <h3><?php comments_number('', __('One comment','miguelmorera'), __('% comments','miguelmorera') ); ?></h3>

        <?php 
            foreach ($comments as $comment) :
        ?>
            
            <article <?php echo $oddcomment; ?>id="comment-<?php comment_ID(); ?>">
                <header class="comment__header">
                    <div class="avatar">
                        <?php echo get_avatar($comment, 32); ?>
                    </div>
                    <div class="comment__meta">
                        <h4><?php comment_author_link(); ?></h4>
                        <a href="#comment-<?php comment_ID(); ?>" title="<?php _e('Permanent link to this comment','miguelmorera'); ?>">
                            <time datetime="<?php echo date(DATE_W3C); ?>" pubdate class="updated">
                                <?php the_time('F j, Y') ?> at <?php comment_time(); ?>
                            </time> 
                        </a>
                    </div><!-- .meta -->                    
                    <?php if ($comment->comment_approved == '0') : ?>
                        <small><?php _e('Your comment is awaiting for moderation.','miguelmorera'); ?></small>
                    <?php endif; ?>
                </header>
                <div class="comment__content">
                    <?php comment_text(); ?>
                </div>
            </article>

        <?php 
            $oddcomment = (empty($oddcomment)) ? 'class="oddcomment comment"' : 'class="comment"'; // alternating comments
            endforeach; 
        ?>

    </section><!-- /.post__comments-list -->

<?php else : // no comments yet ?>
    <?php if ('open' != $post->comment_status) : ?>
        <section class="post__comments-list section space">
            <p><?php _e('The comments are closed.','miguelmorera'); ?></p>
        </section> <!--  /.post__comments-list -->
    <?php endif; ?>
<?php endif; ?>