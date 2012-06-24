<?php namespace ls3;

use S3;

class ls3 extends S3 {
	public function __construct() {
		$credentials = \Config::get( 'ls3::config' );
		parent::__construct(
			$credentials['accesskey'],
			$credentials['secretkey'],
			$credentials['usessl'],
			$credentials['endpoint']
		);
	}
}

?>