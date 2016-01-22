<?php
/*
Template Name: Team Page
*/

$context = Timber::get_context();

$post = new TimberPost();
$context['post'] = $post;

Timber::render( 'team.twig', $context );