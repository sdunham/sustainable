<?php
/*
Template Name: Portfolio Page
*/

$context = Timber::get_context();

$post = new TimberPost();
$context['post'] = $post;

$context['posts'] = Timber::get_posts('post_type=portfolio-cpt&orderby=menu_order&order=ASC');

$context['posts_per_page'] = get_option('posts_per_page');

Timber::render( 'portfolio.twig', $context );