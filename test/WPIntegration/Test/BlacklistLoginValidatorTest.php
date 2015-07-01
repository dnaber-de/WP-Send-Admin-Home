<?php # -*- coding: utf-8 -*-

namespace SendAdminHome\Test\WPIntegration\Test;
use SendAdminHome;

class BlacklistLoginValidatorTest extends \WP_UnitTestCase {

	public function testLoginBlacklist() {

		$this->maybeCreateAdmin();
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

		$this->deleteAdmin();

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

	public function testIsLoginInvalid() {

		$this->maybeCreateAdmin();
		$testee = new SendAdminHome\BlacklistLoginValidator;
		$this->assertTrue(
			$testee->is_login_invalid( 'adm1n' ),
			'Login "adm1n" is valid, but it must not be valid.'
		);
		$this->assertTrue(
			$testee->is_login_invalid( 'administrator' ),
			'Login "administrator" is valid, but it must not be valid.'
		);

		$this->assertFalse(
			$testee->is_login_invalid( 'admin' ),
			'Login "admin" is invalid, but it must be valid.'
		);

		$this->deleteAdmin();
		$testee = new SendAdminHome\BlacklistLoginValidator;
		$this->assertTrue(
			$testee->is_login_invalid( 'admin' ),
			'Login "admin" is valid, but it must not be valid.'
		);

	}

	private function maybeCreateAdmin() {

		$admin = get_user_by( 'login', 'admin' );
		if ( ! is_a( $admin, '\WP_User' ) ) {
			$email = time() . '@example' . rand( 1, 10 ) . '.org';
			wp_create_user( 'admin', 'password', $email );
		}
	}

	private function deleteAdmin() {

		$user = get_user_by( 'login', 'admin' );
		if ( is_a( $user, '\WP_User' ) )
			wp_delete_user( $user->ID );
	}
}
 