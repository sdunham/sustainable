<?php
/*
Template Name: Portfolio Page
*/

$context = Timber::get_context();

$post = new TimberPost();
$context['post'] = $post;

$context['posts'] = Timber::get_posts('post_type=portfolio-cpt&orderby=menu_order&order=ASC');

//var_dump(Timber::get_pagination());exit;
//var_dump(get_class_methods('TimberPostsCollection'));
//var_dump(Timber::get_posts('post_type=portfolio-cpt&orderby=menu_order&order=ASC','TimberPost',true)->count());exit;

Timber::render( 'portfolio.twig', $context );