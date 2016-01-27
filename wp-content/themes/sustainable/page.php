<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * To generate specific templates for your pages you can use:
 * /mytheme/views/page-mypage.twig
 * (which will still route through this PHP file)
 * OR
 * /mytheme/page-mypage.php
 * (in which case you'll want to duplicate this file and save to the above path)
 *
 * Methods for TimberHelper can be found in the /lib sub-directory
 *
 * @package  WordPress
 * @subpackage  Timber
 * @since    Timber 0.1
 */

$context = Timber::get_context();

$post = new TimberPost();
$context['post'] = $post;

$context['content_column_1'] = $post->content(1);
$context['content_column_2'] = $post->content(2);
$context['content_has_columns'] = strpos($post->post_content  , '<!--nextpage-->' ) !== false;

Timber::render( array( 'page-' . $post->post_name . '.twig', 'page.twig' ), $context );