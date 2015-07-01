<?php # -*- coding: utf-8 -*-

namespace SendAdminHome\Test\WPIntegration;
use SendAdminHome\Test\WPDB;
use WpTestsStarter;

// allow a local boostrap.php
$localBootstrap = __DIR__ . '/bootstrap.php';
if ( file_exists( $localBootstrap ) ) {
	require_once $localBootstrap;
	return;
}

$baseDir = dirname( dirname( __DIR__ ) );

$composerAutoload = $baseDir . '/vendor/autoload.php';

if ( file_exists( $composerAutoload ) )
	require_once $composerAutoload;

$wpBaseDir = $baseDir . '/vendor/inpsyde/wordpress-dev';
$testStarter = new WpTestsStarter\WpTestsStarter( $wpBaseDir );

$testStarter->defineAbspath( $baseDir . '/vendor/inpsyde/wordpress-dev/src/' );

$testStarter->setTablePrefix( WPDB\TABLE_PREFIX );
$testStarter->defineDbName( WPDB\NAME );
$testStarter->defineDbUser( WPDB\USER );
$testStarter->defineDbPassword( WPDB\PASSWORD );
$testStarter->defineDbHost( WPDB\HOST );

$testStarter->defineTestsDomain( 'example.org' );
$testStarter->defineTestsEmail( 'admin@example.org' );
$testStarter->defineTestsEmail( 'Send Admin Home Tests' );

$testStarter->defineConst( 'WP_PLUGIN_DIR', dirname( $baseDir ) );

$GLOBALS['wp_tests_options'] = array(
	'active_plugins' => array( basename( $baseDir ) . '/send-admin-home.php' ),
);

$testStarter->bootstrap();

$srcLoader = function( $class ) use ( $baseDir ) {
	require_once $baseDir . '/inc/' . $class . '.php';
};
$srcLoader( 'LoginValidatorInterface' );
$srcLoader( 'BlacklistLoginValidator' );
$srcLoader( 'SendAdminHome' );
