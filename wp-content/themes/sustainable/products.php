<?php
/*
Template Name: Products Page
*/

$context = Timber::get_context();

$post = new TimberPost();
$context['post'] = $post;

$context['posts'] = Timber::get_posts('post_type=product-cpt');

Timber::render( 'products.twig', $context );