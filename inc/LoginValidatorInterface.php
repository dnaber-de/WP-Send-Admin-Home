<?php # -*- coding: utf-8 -*-

namespace SendAdminHome;

interface LoginValidatorInterface {

	/**
	 * checks if the login is invalid and should be redirected
	 *
	 * @return bool
	 */
	public function is_login_invalid();
} 