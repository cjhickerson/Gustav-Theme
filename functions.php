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
    //$twig->addFunction( new Twig_SimpleFunction('wp_head', wp_head() ) );
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
        parent::__construct();
    }

    function register_post_types(){
        //this is where you can register custom post types
    }

    function register_taxonomies(){
        //this is where you can register custom taxonomies
    }

    function add_to_context($context){
        $context['menu'] = new TimberMenu();
        $context['site'] = $this;
		$context['custom_header'] = get_custom_header();
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

add_theme_support( 'post-formats', array( 'aside', 'link', 'gallery', 'quote' ) );
add_post_type_support( 'post', 'post-formats' );

function Gustav_customize_register( $wp_customize ) {
	// Add Section for controls
	$wp_customize->add_section( 'Gustav_Settings' , array(
		'title'      => 'Gustav Settings',
		'priority'   => 30,
	) );
	// Add settings for controls
	$wp_customize->add_setting( 'footer_textcolor' , array(
    	'default'     => '#fff',
    	'transport'   => 'refresh',
	) );
	$wp_customize->add_setting( 'footer_bgcolor' , array(
    	'default'     => '#333',
    	'transport'   => 'refresh',
	) );
	// Finally add actual controls
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'footer_textcolor', array(
		'label'        => 'Footer Text Color',
		'section'    => 'Gustav_Settings',
		'settings'   => 'footer_textcolor',
	) ) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'footer_bgcolor', array(
		'label'        => 'Footer Background Color',
		'section'    => 'Gustav_Settings',
		'settings'   => 'footer_bgcolor',
	) ) );
	
}
add_action( 'customize_register', 'Gustav_customize_register' );

$custom_header_args = array(
	'default-image'          => '',
	'width'                  => 1170,
	'height'                 => 0,
	'flex-height'            => true,
	'flex-width'             => true,
	'uploads'                => true,
	'random-default'         => false,
	'header-text'            => false,
);

add_theme_support( 'custom-header', $custom_header_args );