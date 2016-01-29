<?php
/*
Template Name: Portfolio Page
*/

$context = Timber::get_context();

$post = new TimberPost();
$context['post'] = $post;

$context['posts'] = Timber::get_posts('post_type=portfolio-cpt');
//var_dump($context['posts']);exit;

Timber::render( 'portfolio.twig', $context );