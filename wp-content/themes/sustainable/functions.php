<?php

if ( ! class_exists( 'Timber' ) ) {
	add_action( 'admin_notices', function() {
			echo '<div class="error"><p>Timber not activated. Make sure you activate the plugin in <a href="' . esc_url( admin_url( 'plugins.php#timber' ) ) . '">' . esc_url( admin_url( 'plugins.php' ) ) . '</a></p></div>';
		} );
	return;
}

Timber::$dirname = array('templates', 'views');

class SustainableSite extends TimberSite {

	function __construct() {
		add_theme_support( 'post-formats' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'menus' );

		register_nav_menus( array(
			'primary' => esc_html__( 'Primary', 'sustainable-interiors' ),
			'resources' => esc_html__( 'Footer Resources', 'sustainable-interiors' )
		) );

		add_filter( 'timber_context', array( $this, 'add_to_context' ) );
		add_filter( 'get_twig', array( $this, 'add_to_twig' ) );
		add_action( 'init', array( $this, 'register_post_types' ) );
		add_action( 'init', array( $this, 'register_taxonomies' ) );

		add_action( 'wp_enqueue_scripts', array($this, 'enqueue_scripts') );

		// AJAX Handlers
		// Portfolio Popup
		add_action( 'wp_ajax_nopriv_portfolio_popup', array($this, 'render_portfolio_popup') );
		add_action( 'wp_ajax_portfolio_popup', array($this, 'render_portfolio_popup') );
		// Product Popup
		add_action( 'wp_ajax_nopriv_product_popup', array($this, 'render_product_popup') );
		add_action( 'wp_ajax_product_popup', array($this, 'render_product_popup') );

		parent::__construct();
	}

	function enqueue_scripts() {
		wp_enqueue_script( 'modernizr', get_template_directory_uri() . '/js/modernizr.custom.53630.js', array(), '', false );
		wp_enqueue_script( 'map', get_template_directory_uri() . '/js/map.js', array(), '', true );

		wp_enqueue_style( 'sustainable-interiors-style', get_stylesheet_uri() );

		wp_enqueue_script( 'jquery' );
		wp_enqueue_script( 'jquery-effects-core' );

		wp_enqueue_script( 'skrollr', get_template_directory_uri() . '/js/skollr.js', array(), '', true );
		wp_enqueue_script( 'flexslider', get_template_directory_uri() . '/js/jquery.flexslider-min.js', array(), '', true );
		wp_enqueue_script( 'magnific-popup', get_template_directory_uri() . '/js/jquery.magnific-popup.min.js', array(), '', true );
		wp_enqueue_script( 'sustainable-interiors-common', get_template_directory_uri() . '/js/sus-common.js', array(), '', true );

		// sus-common.js localization
		wp_localize_script( 'sustainable-interiors-common', 'sustainableIncludes', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
		//
		wp_localize_script( 'map', 'mapIncludes', array( 'markericon' => get_template_directory_uri() . '/img/marker@2x.png' ) );


		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}
	}

	// TODO
	function render_portfolio_popup(){
		Timber::render('partials/portfolio-popup.twig');
		wp_die();
	}

	// TODO
	function render_product_popup(){
		Timber::render('partials/product-popup.twig');
		wp_die();
	}

	function register_post_types() {
		//this is where you can register custom post types
	}

	function register_taxonomies() {
		//this is where you can register custom taxonomies
	}

	function add_to_context( $context ) {
		$context['menu'] = new TimberMenu('primary');

		// Header options
		$context['header_contact_link'] = get_field('contact_page', 'option');

		// Footer options
		$context['footer_contact_email'] = get_field('contact_email', 'option');
		$context['footer_contact_phone'] = get_field('contact_phone', 'option');
		$context['footer_contact_address'] = get_field('contact_address', 'option');
		$context['footer_licenses_text'] = get_field('licenses_text', 'option');
		$context['footer_resources_menu'] = new TimberMenu('resources');

		$context['site'] = $this;
		return $context;
	}

	function add_to_twig( $twig ) {
		/* this is where you can add your own fuctions to twig */
		return $twig;
	}

}

new SustainableSite();

if( function_exists('acf_add_options_page') ) {
	
	acf_add_options_page(array(
		'page_title' 	=> 'General Theme Settings',
		'menu_title'	=> 'Theme Settings',
		'menu_slug' 	=> 'theme-settings',
		'capability'	=> 'edit_posts',
		'redirect'		=> false
	));
	
}