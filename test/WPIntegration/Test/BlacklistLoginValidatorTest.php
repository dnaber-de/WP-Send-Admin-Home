<?php # -*- coding: utf-8 -*-

namespace SendAdminHome\Test\WPIntegration\Test;
use SendAdminHome;

class BlacklistLoginValidatorTest extends \WP_UnitTestCase {

	public function testLoginBlacklist() {

		$admin = get_user_by( 'login', 'admin' );
		if ( ! is_a( $admin, '\WP_User' ) ) {
			$email = time() . '@example' . rand( 1, 10 ) . '.org';
			wp_create_user( 'admin', 'password', $email );
		}

		/**
		 * as the user 'admin' exists by default
		 * it should not appear in this list
		 */
		$expectedLogins = [
			'adm1n',
			'administrator'
		];

		$testee = new SendAdminHome\BlacklistLoginValidator;

		$loginBlacklist = $testee->get_invalid_login_names();
		$this->assertEquals(
			$expectedLogins,
			$loginBlacklist,
			'',
			0.0,
			10,
			TRUE // canonicalize means, that the order of the array is irrelevant
		);
	}

	public function testBlacklistAfterRemoveAdmin() {

		$user = get_user_by( 'login', 'admin' );
		wp_delete_user( $user->ID );
		$admin = get_user_by( 'login', 'admin' );

		/**
		 * as the user 'admin' exists by default
		 * it should not appear in this list
		 */
		$expectedLogins = [
			'admin',
			'adm1n',
			'administrator'
		];

		$testee = new SendAdminHome\BlacklistLoginValidator;

		$loginBlacklist = $testee->get_invalid_login_names();
		$this->assertEquals(
			$expectedLogins,
			$loginBlacklist,
			'',
			0.0,
			10,
			TRUE // canonicalize means, that the order of the array is irrelevant
		);
	}
}
 