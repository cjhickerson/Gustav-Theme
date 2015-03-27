<?php
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
        add_action('wp_enqueue_scripts', array($this, 'register_stylesheets'));
        add_action('wp_enqueue_scripts', array($this, 'register_scripts'));
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
		wp_enqueue_style('font_roboto', 'http://fonts.googleapis.com/css?family=Open+Sans:100,300,900,700');
		wp_enqueue_style('font_awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css');
	}
	
	function register_scripts(){
		wp_enqueue_script('bootstrap', '//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js', 'jQuery');
	}

    function add_to_context($context){
        $context['headerMenu'] = new TimberMenu('header-menu');
        $context['footerMenu'] = new TimberMenu('footer-menu');

        $context['site'] = $this;
		
		$context['home'] = (is_home()) ? true : false;
		
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


/* Remove height and width attributes from images added via post editor. They cause problems with the responsive layout. */
add_filter( 'post_thumbnail_html', 'remove_width_attribute', 10 );
add_filter( 'image_send_to_editor', 'remove_width_attribute', 10 );

function remove_width_attribute( $html ) {
   $html = preg_replace( '/(width|height)="\d*"\s/', "", $html );
   return $html;
}