<?php
global $url_patterns;

$url_patterns = array(
     '/^$/' => #home
        'mtv_theme\views\index',
     '/^page\/([0-9-]*)\/?$/' => #home
        'mtv_theme\views\index',
	
	 '/^category\/([A-Za-z0-9-\/]*)\/page\/([0-9-]*)\/?$/' => # category paged
		'mtv_theme\views\category',
	 '/^category\/([A-Za-z0-9-\/]*)\/?$/' => # category
		'mtv_theme\views\category',
	
	 '/^([A-Za-z0-9-]*)\/?$/' => # single
		'mtv_theme\views\single',
	
     '/^\/([A-Za-z0-9-]*)\/?$/' => # 404
        'mtv_theme\views\fourofour',
);