<?php # -*- coding: utf-8 -*-

/**
 * Plugin Name: Send »Admin« Home
 * Description: Redirect login attempts with blacklisted login names to http://localhost.
 * Author: David Naber
 * Author URI: http://dnaber.de/
 * Version: 2015.07.05
 * Licence: MIT
 */

namespace SendAdminHome;

add_action( 'wp_loaded', __NAMESPACE__ . '\init' );
function init() {

	require_once __DIR__ . '/inc/LoginValidatorInterface.php';
	require_once __DIR__ . '/inc/BlacklistLoginValidator.php';
	require_once __DIR__ . '/inc/SendAdminHome.php';
	require_once __DIR__ . '/inc/HttpHeaderEmitter.php';
	require_once __DIR__ . '/inc/ScriptTerminator.php';

	$validator = apply_filters( 'send_admin_home_validator', new BlacklistLoginValidator );
	$plugin    = new SendAdminHome( $validator, new HttpHeaderEmitter, new ScriptTerminator );

	add_action( 'login_init', array( $plugin, 'intercept_login' ) );
	add_filter( 'authenticate', array( $plugin, 'intercept_login' ), 5, 3 );

}