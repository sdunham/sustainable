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
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'menus' );
		add_theme_support( 'title-tag' );

		// Register Menus
		register_nav_menus( array(
			'primary' => esc_html__( 'Primary', 'sustainable-interiors' ),
			'resources' => esc_html__( 'Footer Resources', 'sustainable-interiors' )
		) );

		// Register Image Sizes
    	// Home Image Sizes
		add_image_size( 'home-hero', 1300, 668, true );
		add_image_size( 'post-block', 650, 308, true );
		// Interior Template Image Sizes
		add_image_size( 'interior-hero', 1300, 280, true );
		add_image_size( 'interior-showcase', 930, 435, true );
		add_image_size( 'interior-team', 275, 275, true );
		add_image_size( 'interior-grid', 575, 275, true );
		add_image_size( 'interior-product', 490, 505, true );
		add_image_size( 'interior-portfolio-slider', 975, 555, true );
		add_image_size( 'interior-portfolio-carousel', 180, 105, true );
		//RTE Image Sizes
		add_image_size( 'small', 230, 230, true );
		update_option( 'medium_size_w', 445 );
		update_option( 'medium_size_h', 445 );
		update_option( 'large_size_w', 965 );
		update_option( 'large_size_h', 965 );

		// General Site Setup
		add_filter( 'timber_context', array( $this, 'add_to_context' ) );
		add_filter( 'get_twig', array( $this, 'add_to_twig' ) );
		add_action( 'init', array($this, 'register_portfolio_post_type') );
		add_action( 'init', array($this, 'register_product_post_type') );
		add_action( 'init', array($this, 'register_team_post_type') );

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
		wp_localize_script( 'sustainable-interiors-common', 'sustainableIncludes', array(
			'ajaxurl' => admin_url( 'admin-ajax.php' ),
			'siteurl' => home_url('/')
		) );
		//
		wp_localize_script( 'map', 'mapIncludes', array( 'markericon' => get_template_directory_uri() . '/img/marker@2x.png' ) );


		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}
	}

	// Render the portfolio popup for the given post
	function render_portfolio_popup(){
		$intPostId = intval($_POST['post_id']);
		$objPost = new TimberPost($intPostId);
		Timber::render('partials/portfolio-popup.twig', array('post' => $objPost));
		wp_die();
	}

	// Render the product popup for the given post
	function render_product_popup(){
		$intPostId = intval($_POST['post_id']);
		$objPost = new TimberPost($intPostId);
		Timber::render('partials/product-popup.twig', array('post' => $objPost));
		wp_die();
	}

	/**
	 * Register a portfolio item post type.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/register_post_type
	 */
	function register_portfolio_post_type() {
		$labels = array(
			'name'               => _x( 'Portfolio Items', 'post type general name', 'sustainable-interiors' ),
			'singular_name'      => _x( 'Portfolio Item', 'post type singular name', 'sustainable-interiors' ),
			'menu_name'          => _x( 'Portfolio Items', 'admin menu', 'sustainable-interiors' ),
			'name_admin_bar'     => _x( 'Portfolio Item', 'add new on admin bar', 'sustainable-interiors' ),
			'add_new'            => _x( 'Add New', 'portfolio', 'sustainable-interiors' ),
			'add_new_item'       => __( 'Add New Portfolio Item', 'sustainable-interiors' ),
			'new_item'           => __( 'New Portfolio Item', 'sustainable-interiors' ),
			'edit_item'          => __( 'Edit Portfolio Item', 'sustainable-interiors' ),
			'view_item'          => __( 'View Portfolio Item', 'sustainable-interiors' ),
			'all_items'          => __( 'All Portfolio Items', 'sustainable-interiors' ),
			'search_items'       => __( 'Search Portfolio Items', 'sustainable-interiors' ),
			'parent_item_colon'  => __( 'Parent Portfolio Items:', 'sustainable-interiors' ),
			'not_found'          => __( 'No portfolio items found.', 'sustainable-interiors' ),
			'not_found_in_trash' => __( 'No portfolio items found in Trash.', 'sustainable-interiors' )
		);

		$args = array(
			'labels'             => $labels,
			'description'        => __( 'Description.', 'sustainable-interiors' ),
			'public'             => false,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			//'rewrite'            => array( 'slug' => 'portfolio' ),
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => false,
			'menu_position'      => null,
			'menu_icon'			 => 'dashicons-portfolio',
			'supports'           => array( 'title' )
		);

		register_post_type( 'portfolio-cpt', $args );
	}
	
	/**
	 * Register a product post type.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/register_post_type
	 */
	function register_product_post_type() {
		$labels = array(
			'name'               => _x( 'Products', 'post type general name', 'sustainable-interiors' ),
			'singular_name'      => _x( 'Product', 'post type singular name', 'sustainable-interiors' ),
			'menu_name'          => _x( 'Products', 'admin menu', 'sustainable-interiors' ),
			'name_admin_bar'     => _x( 'Product', 'add new on admin bar', 'sustainable-interiors' ),
			'add_new'            => _x( 'Add New', 'product', 'sustainable-interiors' ),
			'add_new_item'       => __( 'Add New Product', 'sustainable-interiors' ),
			'new_item'           => __( 'New Product', 'sustainable-interiors' ),
			'edit_item'          => __( 'Edit Product', 'sustainable-interiors' ),
			'view_item'          => __( 'View Product', 'sustainable-interiors' ),
			'all_items'          => __( 'All Products', 'sustainable-interiors' ),
			'search_items'       => __( 'Search Products', 'sustainable-interiors' ),
			'parent_item_colon'  => __( 'Parent Products:', 'sustainable-interiors' ),
			'not_found'          => __( 'No products found.', 'sustainable-interiors' ),
			'not_found_in_trash' => __( 'No products found in Trash.', 'sustainable-interiors' )
		);

		$args = array(
			'labels'             => $labels,
			'description'        => __( 'Description.', 'sustainable-interiors' ),
			'public'             => false,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			//'rewrite'            => array( 'slug' => 'product' ),
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => false,
			'menu_position'      => null,
			'menu_icon'			 => 'dashicons-products',
			'supports'           => array( 'title' )
		);

		register_post_type( 'product-cpt', $args );
	}
	
	/**
	 * Register a team member post type.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/register_post_type
	 */
	function register_team_post_type() {
		$labels = array(
			'name'               => _x( 'Team Members', 'post type general name', 'sustainable-interiors' ),
			'singular_name'      => _x( 'Team Member', 'post type singular name', 'sustainable-interiors' ),
			'menu_name'          => _x( 'Team Members', 'admin menu', 'sustainable-interiors' ),
			'name_admin_bar'     => _x( 'Team Member', 'add new on admin bar', 'sustainable-interiors' ),
			'add_new'            => _x( 'Add New', 'team', 'sustainable-interiors' ),
			'add_new_item'       => __( 'Add New Team Member', 'sustainable-interiors' ),
			'new_item'           => __( 'New Team Member', 'sustainable-interiors' ),
			'edit_item'          => __( 'Edit Team Member', 'sustainable-interiors' ),
			'view_item'          => __( 'View Team Member', 'sustainable-interiors' ),
			'all_items'          => __( 'All Team Members', 'sustainable-interiors' ),
			'search_items'       => __( 'Search Team Members', 'sustainable-interiors' ),
			'parent_item_colon'  => __( 'Parent Team Members:', 'sustainable-interiors' ),
			'not_found'          => __( 'No team members found.', 'sustainable-interiors' ),
			'not_found_in_trash' => __( 'No team members found in Trash.', 'sustainable-interiors' )
		);

		$args = array(
			'labels'             => $labels,
			'description'        => __( 'Description.', 'sustainable-interiors' ),
			'public'             => false,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			//'rewrite'            => array( 'slug' => 'team' ),
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => false,
			'menu_position'      => null,
			'menu_icon'			 => 'dashicons-groups',
			'supports'           => array( 'title' )
		);

		register_post_type( 'team-cpt', $args );
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
		
		$twig->addFilter('myfoo', new Twig_SimpleFilter('breakspaces', 'string_spaces_to_break_tags'));
		
		return $twig;
	}
	
	function string_spaces_to_break_tags($strText){
		return str_replace(' ', '<br />', $strText);
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

Timber::add_route('posts/get/:offset', function($params){
	$intPostsPerPage = intval(get_option('posts_per_page'));
	$intOffset = intval($params['offset']);
	$strPostType = ($_POST['post_type'] ? $_POST['post_type'] : 'post');
    $strQuery = 'posts_per_page='.($intPostsPerPage+1).'&post_type='.$strPostType.'&offset='.($intOffset > 0 ? $intOffset : 0);
    $arrPosts = Timber::get_posts($strQuery);
	
	$blnHasMore = (count($arrPosts) < $intPostsPerPage+1 ? false : true);
	// Remove the last post if we got the number of posts we asked for
	if($blnHasMore){
		array_pop($arrPosts);
	}
	
	$arrRet = array(
		'posts' => $arrPosts,
		'hasMore' => $blnHasMore,
		'offset' => $intOffset + $intPostsPerPage
	);
	
	echo json_encode($arrRet);
	exit;
});