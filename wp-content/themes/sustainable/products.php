<?php
/*
Template Name: Products Page
*/

$context = Timber::get_context();

$post = new TimberPost();
$context['post'] = $post;

Timber::render( 'products.twig', $context );