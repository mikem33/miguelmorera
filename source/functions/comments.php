<?php
    /**
     * Custom Comments
     */

    /**
     * Change the order of the textarea field in comment forms.
     */
    function pr_move_comment_field_to_bottom( $fields ) {
        $comment_field = $fields['comment'];
        unset( $fields['comment'] );
        $fields['comment'] = $comment_field;
        return $fields;
    }
     
    add_filter( 'comment_form_fields', 'pr_move_comment_field_to_bottom' );

    function pr_comments($comment, $args, $depth) {
        $GLOBALS['comment'] = $comment;
        $output = '<article class="'.implode(' ', get_comment_class()).'" id="comment-'.get_comment_ID().'">';
        $output .= '<header class="comment__header">';
        $output .= '<div class="avatar">';
        $avatar_size = 64;
        if ('0' != $comment->comment_parent) {
            $avatar_size = 44;
        }
        $output .= get_avatar($comment, $avatar_size);
        $output .= '</div><!-- /.avatar -->';
        $output .= '<div class="comment__meta">';
        $output .= '<h4 class="title beta">'.get_comment_author_link().'</h4>';
        $comment_timestamp = sprintf( __( '%1$s a las %2$s', 'prometheus' ), get_comment_date( '', $comment ), get_comment_time() );
        $output .= '<a href="'.esc_url( get_comment_link( $comment, $args ) ).'">';
        $output .= '<time datetime="'.get_comment_time('c').'" title="'.$comment_timestamp.'">';
        $output .= $comment_timestamp;
        $output .= '</time>';
        $output .= '</a>';
        $output .= '</div><!-- /.comment__meta -->';
        $output .= '</header><!-- /.comment__header -->';
        add_filter('get_comment_text','wpautop');
        $output .= '<div class="comment__content">';
        $output .= get_comment_text();
        $output .= '</div><!-- /.comment__content -->';
        remove_filter('get_comment_text','wpautop');
        if ($comment->comment_approved == '0') {
            $output .= '<p class="moderation">'.__('Tu comentario está a la espera de moderación.','prometheus').'</p>';
        }
        $output .= '<div class="comment__reply">';
        $output .= get_comment_reply_link(
                        array_merge( $args, 
                            array(
                                'depth' => $depth, 
                                'max_depth' => $args['max_depth']
                            )
                        )
                    );
        $output .= '</div>';
        $output .= '</article>';

        echo $output;
    }

    function pr_custom_class_comment_reply_link($content) {
        $extra_classes = 'button button--dark-grey button--filled';
        return preg_replace( '/comment-reply-link/', 'comment-reply-link ' . $extra_classes, $content);
    }

    add_filter('comment_reply_link', 'pr_custom_class_comment_reply_link', 99);
?>