<?php # -*- coding: utf-8 -*-

namespace SendAdminHome\Test\Unit;
use SendAdminHome;

class SendAdminHomeTest extends \PHPUnit_Framework_TestCase {

	public function testSendHome() {

		$http_header_emitter_mock = $this->getHttpHeaderEmitterMock();
		$http_header_emitter_mock->expects( $this->at( 0 ) )
			->method( 'status_header' )
			->with( 302 );

		$http_header_emitter_mock->expects( $this->at( 1 ) )
			->method( 'header' )
			->with( $this->callback(
				// test if the header is a 'Location' header
				function( $parameter ) {
					if ( FALSE === strpos( $parameter, 'Location: ' ) )
						return FALSE;
					return TRUE;
				}
			) );

		$login_validator_mock = $this->getLoginValidatorMock();
		$login_validator_mock->expects( $this->never() )
			->method( 'is_login_invalid' );
		$script_terminator_mock = $this->getScriptTerminatorMock();
		$script_terminator_mock->expects( $this->never() )
			->method( 'stop' );


		$testee = new SendAdminHome\SendAdminHome(
			$login_validator_mock,
			$http_header_emitter_mock,
			$script_terminator_mock
		);

		$testee->send_home();
	}

	public function testInterceptLogin() {

		$http_header_emitter_mock = $this->getHttpHeaderEmitterMock();
		$http_header_emitter_mock->expects( $this->exactly( 1 ) )
			->method( 'status_header' );

		$http_header_emitter_mock->expects( $this->exactly( 1 ) )
			->method( 'header' );


		if ( ! isset( $_REQUEST[ 'log' ] ) )
			$_REQUEST[ 'log' ] = 'admin';

		$login_validator_mock = $this->getLoginValidatorMock();
		$login_validator_mock->expects( $this->exactly( 1 ) )
			->method( 'is_login_invalid' )
			->with( 'admin' )
			->willReturn( TRUE );

		$script_terminator_mock = $this->getScriptTerminatorMock();
		$script_terminator_mock->expects( $this->exactly( 1 ) )
			->method( 'stop' );

		$testee = new SendAdminHome\SendAdminHome(
			$login_validator_mock,
			$http_header_emitter_mock,
			$script_terminator_mock
		);

		$testee->intercept_login();
	}


	public function testInterceptLoginWithParameter() {

		$username = 'jondoe';
		$http_header_emitter_mock = $this->getHttpHeaderEmitterMock();
		$http_header_emitter_mock->expects( $this->never() )
			->method( 'status_header' );

		$http_header_emitter_mock->expects( $this->never() )
			->method( 'header' );

		$login_validator_mock = $this->getLoginValidatorMock();
		$login_validator_mock->expects( $this->exactly( 1 ) )
			->method( 'is_login_invalid' )
			->with( $username )
			->willReturn( FALSE ); // assume the username to be valid

		$script_terminator_mock = $this->getScriptTerminatorMock();
		$script_terminator_mock->expects( $this->never() )
			->method( 'stop' );

		$testee = new SendAdminHome\SendAdminHome(
			$login_validator_mock,
			$http_header_emitter_mock,
			$script_terminator_mock
		);

		$testee->intercept_login( NULL, $username, NULL );
	}

	private function getHttpHeaderEmitterMock() {

		$mock = $this->getMockBuilder( 'SendAdminHome\HttpHeaderEmitter' )
			->disableOriginalConstructor()
			->getMock();

		return $mock;
	}

	private function getLoginValidatorMock() {

		$mock = $this->getMockBuilder( 'SendAdminHome\BlacklistLoginValidator' )
			->disableOriginalConstructor()
			->getMock();

		return $mock;
	}

	private function getScriptTerminatorMock() {

		$mock = $this->getMockBuilder( 'SendAdminHome\ScriptTerminator' )
			->disableOriginalConstructor()
			->getMock();

		return $mock;
	}
}
 