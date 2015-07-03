<?php # -*- coding: utf-8 -*-

namespace SendAdminHome\Test\Unit;

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

$srcLoader = function( $class ) use ( $baseDir ) {
	require_once $baseDir . '/inc/' . $class . '.php';
};
$srcLoader( 'LoginValidatorInterface' );
$srcLoader( 'BlacklistLoginValidator' );
$srcLoader( 'SendAdminHome' );
$srcLoader( 'HttpHeaderEmitter' );
$srcLoader( 'ScriptTerminator' );
