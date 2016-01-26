<?php
/*
Template Name: Home Page
*/

$context = Timber::get_context();

$post = new TimberPost();
$context['post'] = $post;

$context['recent_posts'] = Timber::get_posts('numberposts=2');
//var_dump($context['recent_posts']);exit;

Timber::render( 'front-page.twig', $context );