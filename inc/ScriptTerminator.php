<?php # -*- coding: utf-8 -*-

namespace SendAdminHome;

class ScriptTerminator {

	/**
	 * @param string $msg (Optional)
	 */
	public function stop( $msg = NULL ) {

		exit( $msg );
	}
} 