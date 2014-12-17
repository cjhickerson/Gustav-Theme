<?php
namespace mtv_theme\views;
use mtv\wp\models\PostCollection,
     mtv\shortcuts,
     Timber,
     WP_Query,
	 TimberImage;

function fourofour( $request, $context ){
	$templates = array('404.twig');
	$context['sidebar'] = null;
	$context['request'] = $request[0];
	Timber::render($templates, $context);
}

function index( $request ) {
    global $paged;
    $paged = isset($request[0]) ? $request[0] : 1;

	$posts_per_page = get_option('posts_per_page');
	
    $args = array('post_type' => array('post'),
              'posts_per_page' => $posts_per_page,
              'paged' => $paged,
              'order' => 'DESC');
    
    shortcuts\set_query_flags('home');
    query_posts($args);
	
    $context = Timber::get_context();
	
	$context['lead_art'] = new TimberImage(6413);
	$context['home'] = ($paged > 1) ? false : true;
	$context['sidebar'] = Timber::get_widgets('main_sidebar');
	$context['posts'] = Timber::get_posts($args);
    $context['pagination'] = Timber::get_pagination();
	$templates = array('index.twig');
	Timber::render($templates, $context);
}

function single( $request ) {
    $args = array('post_type' => 'any',
                  'posts_per_page' => 1,
                  'name' => $request[0],
                  'order' => 'DESC');
    $context = Timber::get_context();
	$context['sidebar'] = false;
    $post = Timber::get_posts($args);
    $context['post'] = (isset($post[0])) ? $post[0] : null;
	
	if (isset($context['post'])) {
    	$templates = array('single.twig');
		Timber::render($templates, $context);
	} else {
		fourofour($request, $context);
	}
}

function category( $request ) {	
	global $paged;
    $paged = isset($request[1]) ? $request[1] : 1;

	$posts_per_page = get_option('posts_per_page');
	
    $args = array('post_type' => 'any',
              'posts_per_page' => $posts_per_page,
			  'category_name' => $request[0],
              'paged' => $paged,
              'order' => 'DESC');
    
    query_posts($args);
	
    $context = Timber::get_context();
	$context['title'] = $context['wp_title'];
	$context['sidebar'] = Timber::get_widgets('main_sidebar');
	$context['posts'] = Timber::get_posts($args);
    $context['pagination'] = Timber::get_pagination();
	$templates = array('index.twig');
	Timber::render($templates, $context);
}