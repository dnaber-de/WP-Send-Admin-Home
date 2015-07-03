<?php # -*- coding: utf-8 -*-

namespace SendAdminHome;

class HttpHeaderEmitter {

	/**
	 * @param string $header_str
	 */
	public function header( $header_str ) {

		header( $header_str );
	}

	/**
	 * @param int $status_code
	 */
	public function status_header( $status_code ) {

		status_header( $status_code );
	}
} 