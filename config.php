<?php
	define( 'ENABLE_DEBUG', false );
	if(ENABLE_DEBUG){
		ini_set('display_errors', 1);
		ini_set('display_startup_errors', 1);
		error_reporting(E_ALL);
	}

	if ( ! defined( 'ABSPATH' ) ) {
		define( 'ABSPATH', __DIR__ . '/' );
	}

	define( 'SITE_URL', (empty($_SERVER['HTTPS']) ? 'http' : 'https') . "://$_SERVER[HTTP_HOST]" );
    define( 'SITE_IMAGES_DIR', SITE_URL . '/assets/products/' );

    // DB DATA
    if( strpos(SITE_URL, 'theconqueror.test') ){
        define( 'DB_NAME', 'theconqueror' );
        define( 'DB_USER', 'root' );
        define( 'DB_PASSWORD', '' );
        define( 'DB_HOST', 'localhost' );
        define( 'DB_CHARSET', 'utf8' );
    }
    else if( strpos(SITE_URL, 'bondas.ro') ){
        define( 'DB_NAME', 'bondasro_theconqueror' );
        define( 'DB_USER', 'bondasro_theconqueror' );
        define( 'DB_PASSWORD', 'theconqueror' );
        define( 'DB_HOST', 'localhost' );
        define( 'DB_CHARSET', 'utf8' );
    }
    define( 'DB_TABLE_ITEMS', 'items' );

	require_once( ABSPATH . 'libs/db.class.php' );
	DB::$user = DB_USER;
	DB::$password = DB_PASSWORD;
	DB::$dbName = DB_NAME;
	DB::$host = DB_HOST;
	DB::$encoding = DB_CHARSET;
	DB::get();
	
	require_once( ABSPATH . 'libs/functions.php' );