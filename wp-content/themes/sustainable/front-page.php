<?php
/*
Template Name: Home Page
*/

$context = Timber::get_context();

$post = new TimberPost();
$context['post'] = $post;

Timber::render( 'front-page.twig', $context );