<?php 
    // Do not delete these lines
    if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
        die ('Por favor, no cargues esta página directamente. ¡Gracias!');
    if (!empty($post->post_password)) {
        if ($_COOKIE['wp-postpass_' . COOKIEHASH] != $post->post_password) { ?>
            <p class="nocomments"><?php _e('Este post está protegido con contraseña. Introduce la contraseña para ver los comentarios.','prometheus'); ?></p>
            <?php return;
        }
    }
?>

<section class="post__comment-form space">
    <div class="wrapper">
        <header class="section__header">
            <h3 class="title alpha"><?php _e('Tal vez te apetezca dejar un comentario','prometheus'); ?></h3>
            <p class="legend"><?php _e('Los campos marcados con un asterisco (*) son obligatorios.','prometheus'); ?></p>
        </header>

        <?php 
            // $Author field.
            $author = '<div class="fieldset-group"><fieldset class="fieldset fieldset--text">';
            $author .= '<label for="author">'.__('Nombre*','prometheus').'</label>';
            $author .= '<input type="text" name="author" id="author" value="'.esc_attr( $commenter['comment_author'] ).'" size="55" tabindex="1" placeholder="'.__('Nombre*','prometheus').'">';
            $author .= '</fieldset> <!--  /.fieldset fieldset--text -->';
            // $Email field.
            $email = '<fieldset class="fieldset fieldset--email">';
            $email .= '<label for="email">'.__('E-mail*','prometheus').'</label>';
            $email .= '<input type="text" name="email" id="email" value="'.esc_attr($commenter['comment_author_email']).'" size="55" tabindex="2" placeholder="'.__('E-mail*','prometheus').'">';
            $email .= '</fieldset> <!--  /.fieldset fieldset--email -->';
            // $URL field.
            $url = '<fieldset class="fieldset fieldset--text">';
            $url .= '<label for="url">'.__('Página web','prometheus').'</label>';
            $url .= '<input type="text" name="url" id="url" value="'.esc_attr($commenter['comment_author_url']).'" size="55" tabindex="3" placeholder="'.__('Página web','prometheus').'">';
            $url .= '</fieldset> <!--  /.fieldset fieldset--text -->';
            // $Comment field.
            $comment_field = '<fieldset class="fieldset fieldset--textarea">';
            $comment_field .= '<label for="comment">'.__('Comentario*','prometheus').'</label>';
            $comment_field .= '<textarea name="comment" id="comment" cols="55" rows="10" tabindex="4" placeholder="'.__('Comentario*','prometheus').'"></textarea>';
            $comment_field .= '</fieldset> <!--  /.fieldset fieldset--textarea -->';
            $comment_field .= '</div> <!--  /.fieldset-group -->';
            // $Submit button.
            $submit_button = '<button type="submit" class="button button--dark-grey button--filled button--icon">';
            $submit_button .= '<span>'.__('Enviar comentario','prometheus').'</span>';
            $submit_button .= '<svg width="15" height="15" class="ico"><use xlink:href="#ico-circle-arrow" /></svg>';
            $submit_button .= '</button>';

            comment_form(
                array(
                    'fields' => array(
                        'author'                => $author,
                        'email'                 => $email,
                        'url'                   => $url,
                        'cookies'               => false,
                    ),
                    'comment_field'             => $comment_field,
                    'class_form'                => 'mm__form comment-form',
                    'title_reply_before'        => '<header class="comment__reply-header flex"><h3 class="title beta">',
                    'title_reply_after'         => '</header><!-- /.comment__reply-header -->',
                    'cancel_reply_before'       => '</h3>',
                    'label_submit'              => false,
                    'comment_notes_before'      => false,
                    'comment_notes_after'       => false,
                    'submit_field'              => '%1$s %2$s',
                    'submit_button'             => $submit_button
                )
            ); 
        ?>
    </div><!-- /.wrapper -->
</section><!-- /.post__comment-form -->

<section class="post__comments-list commentslist section space">
    <div class="wrapper">
        <?php if ( have_comments() ) : ?>
            <header class="commentslist__header">
                <svg width="50" height="39" class="ico"><use xlink:href="#ico-comment-bubbles" /></svg>
                <h3 class="title beta"><?php comments_number(__('No hay comentarios','prometheus'), __('Un comentario','prometheus'), __('% comentario','prometheus') ); ?></h3>
            </header>
            <?php wp_list_comments('type=comment&callback=pr_comments'); ?>
            <nav class="post__comments-navigation">
                <div class="comments--older"><?php previous_comments_link() ?></div>
                <div class="comments--newer"><?php next_comments_link() ?></div>
            </nav>
        
        <?php else : // this is displayed if there are no comments so far ?>
     
            <?php if ( comments_open() ) : ?>
                <!-- If comments are open, but there are no comments. -->
                <header class="commentslist__header">
                    <svg width="50" height="39" class="ico"><use xlink:href="#ico-comment-bubbles" /></svg>
                    <h3 class="title beta"><?php _e('No hay comentarios','prometheus'); ?></h3>
                </header>
            <?php else : // comments are closed ?>
                <!-- If comments are closed. -->
                <header class="commentslist__header">
                    <svg width="50" height="39" class="ico"><use xlink:href="#ico-comment-bubbles" /></svg>
                    <h3 class="title beta"><?php _e('Los comentarios están cerrados','prometheus'); ?></h3>
                </header>
            <?php endif; ?>
        <?php endif; ?>
    </div> <!--  /.wrapper -->
</section><!-- /.post__comments-list -->