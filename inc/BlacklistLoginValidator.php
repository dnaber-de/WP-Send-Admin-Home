<?php # -*- coding: utf-8 -*-


namespace SendAdminHome;

class BlacklistLoginValidator implements LoginValidatorInterface {

	/**
	 * @type array
	 */
	private $request;

	/**
	 * @param array $request
	 */
	public function __construct( array $request ) {

		$this->request = $request;
	}

	/**
	 * @return bool
	 */
	public function is_login_invalid() {

		if ( isset( $this->request[ 'log' ] )
			&& in_array( $this->request[ 'log' ], $this->get_invalid_login_names() )
		) {
			return TRUE;
		}

		return FALSE;
	}

	/**
	 * @return array
	 */
	public function get_invalid_login_names() {

		$invalid = array(
			'admin',
			'administrator',
			'adm1n'
		);
		foreach ( $invalid as $index => $name )
			if ( username_exists( $name ) )
				unset( $invalid[ $index ] );

		return $invalid;
	}
} 