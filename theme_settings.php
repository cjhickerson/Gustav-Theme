<?php 


// add theme customize controls
function Gustav_customize_register( $wp_customize ) {
	// Add Section for controls
	$wp_customize->add_section( 'Gustav_Color_Settings' , array(
		'title'      => 'Gustav Colors',
		'priority'   => 100,
	) );
	$wp_customize->add_section( 'Gustav_Sidebar_Settings' , array(
		'title'      => 'Gustav Sidebars',
		'priority'   => 110,
	) );
	$wp_customize->add_section( 'Gustav_Tease_Settings' , array(
		'title'      => 'Gustav Teases',
		'priority'   => 110,
	) );
	// Add settings for controls
	$wp_customize->add_setting( 'textcolor' , array(
    	'default'     => '#fff',
    	'transport'   => 'refresh',
	) );
	$wp_customize->add_setting( 'bgcolor' , array(
    	'default'     => '#333',
    	'transport'   => 'refresh',
	) );
	$wp_customize->add_setting( 'sidebar_position' , array(
    	'default'     => 'right',
    	'transport'   => 'refresh',
	) );
	$wp_customize->add_setting( 'aside_thumbnail_position' , array(
    	'default'     => 'right',
    	'transport'   => 'refresh',
	) );
	$wp_customize->add_setting( 'tease_width' , array(
    	'default'     => 'full',
    	'transport'   => 'refresh',
	) );
	// Finally add actual controls
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'footer_textcolor', 		array(
		'label'        => 'Text Color',
		'section'    => 'Gustav_Color_Settings',
		'settings'   => 'textcolor',
	) ) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'footer_bgcolor', 		array(
		'label'        => 'Background Color',
		'section'    => 'Gustav_Color_Settings',
		'settings'   => 'bgcolor',
	) ) );
	$wp_customize->add_control( 'sidebar_position', 
		array(
			'label'    => 'Sidebar Position',
			'section'  => 'Gustav_Sidebar_Settings',
			'settings' => 'sidebar_position',
			'type'     => 'radio',
			'choices'  => array( 'left'  => 'left', 'right' => 'right' )
		) 
	);
	$wp_customize->add_control( 'aside_thumbnail_position', 
		array(
			'label'    => 'Aside Thumbnail Position',
			'section'  => 'Gustav_Tease_Settings',
			'settings' => 'aside_thumbnail_position',
			'type'     => 'radio',
			'choices'  => array( 'left'  => 'left', 'right' => 'right' )
		) 
	);
	$wp_customize->add_control( 'tease_width', 
		array(
			'label'    => 'Tease Width',
			'section'  => 'Gustav_Tease_Settings',
			'settings' => 'tease_width',
			'type'     => 'radio',
			'choices'  => array( 'half'  => 'half', 'full' => 'full' )
		) 
	);
}
add_action( 'customize_register', 'Gustav_customize_register' );

// add custom header image
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

// sidebar registration
$sidebarargs = array(
	'name'          => 'Sidebar',
	'id'            => 'main_sidebar',
	'description'   => '',
    'class'         => '',
	'before_widget' => '<aside id="%1$s" class="widget %2$s">',
	'after_widget'  => '</div></aside>',
	'before_title'  => '<h3 class="widgettitle">',
	'after_title'   => '</h3><div class="widget-body">' );
register_sidebar($sidebarargs);

// add post format support
add_theme_support( 'post-formats', array( 'aside', 'link', 'gallery', 'quote' ) );
add_post_type_support( 'post', 'post-formats' );