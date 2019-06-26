<?php
/**
 * Created by PhpStorm.
 * User: jlzan
 * Date: 2019/6/26
 * Time: 10:09
 */

namespace Jlzan1314\WxApp\Api;


class RedisKeys
{
	public static function createAccessTokenKey($appId,$appSecret):string {
		return "wxApp:".md5($appId.$appSecret);
	}
}