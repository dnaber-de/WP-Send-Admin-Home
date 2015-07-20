<?php # -*- coding: utf-8 -*-

namespace SendAdminHome;

class BlacklistLoginValidator implements LoginValidatorInterface {

	/**
	 * @type array
	 */
	private $request;

	/**
	 * @type array
	 */
	private $invalid_login_names = [];

	/**
	 * Setup list of invalid login names
	 */
	public function __construct() {

		$invalid_login_names = array(
			'admin',
			'administrator',
			'adm1n',
			'test'
		);
		foreach ( $invalid_login_names as $index => $name )
			if ( username_exists( $name ) )
				unset( $invalid_login_names[ $index ] );

		$this->invalid_login_names = $invalid_login_names;
	}

	/**
	 * @param $login
	 * @return bool
	 */
	public function is_login_invalid( $login ) {

		return
			in_array( $login, $this->invalid_login_names );
	}

	/**
	 * @return array
	 */
	public function get_invalid_login_names() {

		return $this->invalid_login_names;
	}
}