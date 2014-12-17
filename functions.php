<?php
define("DEPLOYMENT_TARGET", "development");

// Configure MTV
if ( function_exists('mtv\register_app') )
    mtv\register_app('mtv_theme', __DIR__);
 
// Setup enabled apps
global $apps;
$apps = array('wp','mtv_theme');

function add_to_twig($twig) {
    //$twig->addFunction( new Twig_SimpleFunction( 'function', array( $this, 'exec_function' ) ) );
    $twig->addExtension(new Twig_Extension_StringLoader());
    $twig->addExtension(new Twig_Extension_Debug());
    $twig->addFunction( new Twig_SimpleFunction('wp_head', wp_head() ) );
    $twig->addFunction( new Twig_SimpleFunction('wp_footer', wp_footer() ) );
    return $twig;
}

class Gustav extends TimberSite {

    function __construct(){
        add_theme_support('post-formats');
        add_theme_support('post-thumbnails');
        add_theme_support('menus');
        add_filter('timber_context', array($this, 'add_to_context'));
        add_filter('get_twig', array($this, 'add_to_twig'));
        add_action('init', array($this, 'register_post_types'));
        add_action('init', array($this, 'register_taxonomies'));
        add_action('init', array($this, 'register_stylesheets'));
        add_action('init', array($this, 'register_scripts'));
        parent::__construct();
    }

    function register_post_types(){
        //this is where you can register custom post types
    }

    function register_taxonomies(){
        //this is where you can register custom taxonomies
    }
	
	function register_stylesheets(){
		wp_enqueue_style('bootstrap', '//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css');
		wp_enqueue_style('theme_styles', get_template_directory_uri().'/style.css');
		wp_enqueue_style('font_roboto', 'http://fonts.googleapis.com/css?family=Roboto:100,300,900,700');
		wp_enqueue_style('font_awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css');
	}
	
	function register_scripts(){
		
	}

    function add_to_context($context){
        $context['menu'] = new TimberMenu();
        $context['site'] = $this;
		$context['custom_header'] = get_custom_header();
		$context['settings'] = array ( 
			'sidebar_position' => get_theme_mod('sidebar_position'),
			'aside_thumbnail_position' => get_theme_mod('aside_thumbnail_position'),
			'tease_width' => get_theme_mod('tease_width'),
		);
        return $context;
    }

    function add_to_twig($twig){
        /* this is where you can add your own fuctions to twig */
        $twig->addExtension(new Twig_Extension_StringLoader());
		
		$function = new Twig_SimpleFunction('get_post_format', function($id) {
			return get_post_format($id);
		});
		$twig->addFunction($function);
		
		$get_theme_mod = new Twig_SimpleFunction('get_theme_mod', function($id) {
			return get_theme_mod($id);
		});
		$twig->addFunction($get_theme_mod);
		
        return $twig;
    }

}
Timber::$dirname = 'templates';
new Gustav();

require_once('theme_settings.php');