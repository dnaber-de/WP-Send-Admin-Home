<?php # -*- coding: utf-8 -*-

namespace SendAdminHome;

class SendAdminHome {

	/**
	 * @type LoginValidatorInterface
	 */
	private $login_validator;

	/**
	 * @type HttpHeaderEmitter
	 */
	private $http_header_emitter;

	/**
	 * @type ScriptTerminator
	 */
	private $script_terminator;

	/**
	 * @param LoginValidatorInterface $login_validator
	 * @param HttpHeaderEmitter       $http_header_emitter
	 * @param ScriptTerminator        $script_terminator
	 */
	function __construct(
		LoginValidatorInterface $login_validator,
		HttpHeaderEmitter $http_header_emitter,
		ScriptTerminator $script_terminator
	) {

		$this->login_validator = $login_validator;
		$this->http_header_emitter = $http_header_emitter;
		$this->script_terminator = $script_terminator;
	}

	/**
	 * @wp_hook login_init
	 * @wp_hook authenticate (In case of xml-rpc requests)
	 * @param NULL $null
	 * @param string $username
	 * @param string $password
	 */
	public function intercept_login( $null = NULL, $username = NULL, $password = NULL ) {

		if ( $username ) {
			$login = $username;
		} else {
			$login = isset( $_REQUEST[ 'log' ] )
				? $_REQUEST[ 'log' ]
				: '';
		}
		if ( $this->login_validator->is_login_invalid( $login ) ) {
			$this->send_home();
			$this->script_terminator->stop();
		}
	}

	/**
	 * send a location header and exit
	 */
	public function send_home() {

		$this->http_header_emitter->status_header( 302 ); //found!
		$this->http_header_emitter->header( 'Location: http://localhost' );
	}
} 