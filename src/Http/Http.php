<?php


namespace Jlzan1314\WxApp\Http;

use Swoft\Http\Message\Uri\Uri;

class Http
{
	public static function post($url, $postData, $time = 20)
	{
		return self::getClient()->post($url, $postData, $time);
	}

	public static function get($url, $time = 20)
	{
		return self::getClient()->get($url, $time);
	}

	public static function postWithSSL($url, $postData, $ssl, $sslKey, $time = 20)
	{
		return self::getClient()->postWithSSL($url, $postData, $ssl, $sslKey, $time);
	}

	/**
	 * @return HttpClientInterface
	 */
	public static function getClient(): HttpClientInterface
	{
		return \bean(SwooleHttpClient::class);
	}

	public static function parseUri($url): Uri
	{
		return Uri::new($url);
	}
}



