<?php
/*
Template Name: Team Page
*/

$context = Timber::get_context();

$post = new TimberPost();
$context['post'] = $post;

$context['posts'] = Timber::get_posts('post_type=team-cpt&posts_per_page=-1');

$context['content_column_1'] = $post->content(1);
$context['content_column_2'] = $post->content(2);
$context['content_has_columns'] = strpos($post->post_content  , '<!--nextpage-->' ) !== false;

Timber::render( 'team.twig', $context );