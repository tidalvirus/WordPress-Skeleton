<?php
// Configure local-config.php with the production and staging site hostnames
// local-config MUST declare $production_host and $staging_host
if ( ! file_exists( dirname( __FILE__ ) . '/local-config.php' ) ) {
		header('X-WP-Error: config', true, 500);
		echo '<h1>Configuration file is missing!</h1>';
		echo "<p>If this is in production, deployment is broken.</p>";
		die(1);
}
require_once( dirname( __FILE__ ) . '/local-config.php' );

// ===================================================
// Load database info and local development parameters
// ===================================================
if (isset($production_host) && $_SERVER['HTTP_HOST'] == $production_host) {
	if ( ! file_exists( dirname(__FILE__) . '/local-production-config.php' ) ) {
		header('X-WP-Error: config', true, 500);
		echo '<h1>Production configuration file is missing!</h1>';
		echo "<p>If this is in production, deployment is broken.</p>";
		die(1);
	}
	require_once( dirname( __FILE__ ) . '/local-production-config.php' );
}
elseif (isset($staging_host) && $_SERVER['HTTP_HOST'] == $staging_host) {
	if ( ! file_exists( dirname(__FILE__) . '/local-staging-config.php' ) ) {
		header('X-WP-Error: config', true, 500);
		echo '<h1>Staging configuration file is missing!</h1>';
		echo "<p>If this is in production, deployment is broken.</p>";
		die(1);
	}
	require_once( dirname( __FILE__ ) . '/local-staging-config.php' );
}
else {
	if ( ! file_exists( dirname(__FILE__) . '/local-staging-config.php' ) ) {
		header('X-WP-Error: config', true, 500);
		echo '<h1>Local configuration file is missing!</h1>';
		echo "<p>If this is in production, deployment is broken.</p>";
		die(1);
	}
	require_once( dirname( __FILE__ ) . '/local-development-config.php' );
}

// ========================
// Custom Content Directory
// ========================
define( 'WP_CONTENT_DIR', dirname( __FILE__ ) . '/content' );
define( 'WP_CONTENT_URL', 'http://' . $_SERVER['HTTP_HOST'] . '/content' );

// ================================================
// You almost certainly do not want to change these
// ================================================
define( 'DB_CHARSET', 'utf8' );
define( 'DB_COLLATE', '' );

// ==============================================================
// Salts, for security
// Grab these from: https://api.wordpress.org/secret-key/1.1/salt
// ==============================================================
define( 'AUTH_KEY',         'put your unique phrase here' );
define( 'SECURE_AUTH_KEY',  'put your unique phrase here' );
define( 'LOGGED_IN_KEY',    'put your unique phrase here' );
define( 'NONCE_KEY',        'put your unique phrase here' );
define( 'AUTH_SALT',        'put your unique phrase here' );
define( 'SECURE_AUTH_SALT', 'put your unique phrase here' );
define( 'LOGGED_IN_SALT',   'put your unique phrase here' );
define( 'NONCE_SALT',       'put your unique phrase here' );

// ==============================================================
// Table prefix
// Change this if you have multiple installs in the same database
// ==============================================================
$table_prefix  = 'sz_';

// ================================
// Language
// Leave blank for American English
// ================================
define( 'WPLANG', '' );

// ===========
// Hide errors
// ===========
ini_set( 'display_errors', 0 );
define( 'WP_DEBUG_DISPLAY', false );

// =================================================================
// Debug mode
// Debugging? Enable these. Can also enable them in local-config.php
// =================================================================
// define( 'SAVEQUERIES', true );
// define( 'WP_DEBUG', true );

// ======================================
// Load a Memcached config if we have one
// ======================================
if ( file_exists( dirname( __FILE__ ) . '/memcached.php' ) )
	$memcached_servers = include( dirname( __FILE__ ) . '/memcached.php' );

// ===========================================================================
// This can be used to programatically set the stage when deploying (e.g. production, staging)
// ===========================================================================
define( 'WP_STAGE', '%%WP_STAGE%%' );
define( 'STAGING_DOMAIN', '%%WP_STAGING_DOMAIN%%' ); // Does magic in WP Stack to handle staging domain rewriting

// ===================
// Bootstrap WordPress
// ===================
if ( !defined( 'ABSPATH' ) )
	define( 'ABSPATH', dirname( __FILE__ ) . '/wp/' );
require_once( ABSPATH . 'wp-settings.php' );
