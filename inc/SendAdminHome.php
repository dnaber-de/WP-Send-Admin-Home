<?php # -*- coding: utf-8 -*-


namespace SendAdminHome;

class SendAdminHome {

	/**
	 * @type LoginValidator
	 */
	private $login_validator;

	/**
	 * @param LoginValidator $login_validator
	 */
	function __construct( LoginValidator $login_validator ) {

		$this->login_validator = $login_validator;
	}

	/**
	 * @wp_hook login_init
	 */
	public function intercept_login() {

		if ( $this->login_validator->is_login_invalid() ) {
			$this->send_home();
			exit;
		}
	}

	/**
	 * send a location header and exit
	 */
	public function send_home() {

		status_header( 302 ); //found!
		header( 'Location: http://localhost' );
	}
} 