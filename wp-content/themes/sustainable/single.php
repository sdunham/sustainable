<?php
/**
 * The Template for displaying all single posts
 *
 * Methods for TimberHelper can be found in the /lib sub-directory
 *
 * @package  WordPress
 * @subpackage  Timber
 * @since    Timber 0.1
 */

$context = Timber::get_context();
$post = Timber::query_post();
$context['post'] = $post;
//$context['comment_form'] = TimberHelper::get_comment_form();

$context['news_page'] = new TimberPost(get_option( 'page_for_posts' ));

$context['content_column_1'] = $post->content(1);
$context['content_column_2'] = $post->content(2);
$context['content_has_columns'] = strpos($post->post_content  , '<!--nextpage-->' ) !== false;

if ( post_password_required( $post->ID ) ) {
	Timber::render( 'single-password.twig', $context );
} else {
	Timber::render( array( 'single-' . $post->ID . '.twig', 'single-' . $post->post_type . '.twig', 'single.twig' ), $context );
}
