<?php 

namespace App;

/**
 * 
 */
class Jssdk
{
	
	function __construct()
	{
		# code...
	}

	public static function config()
	{
		return app('wechat.official_account')->jssdk->buildConfig(['openProductSpecificView'], $debug = false, $beta = false, $json = true);
	}
}
 ?>