<?php
/*
Template Name: Contact Page
*/

$context = Timber::get_context();

$post = new TimberPost();
$context['post'] = $post;

Timber::render( 'contact.twig', $context );