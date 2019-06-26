<?php
/**
 * Created by PhpStorm.
 * User: Jlzan1314
 * Date: 2017/7/29
 * Time: 17:39
 */

namespace Jlzan1314\WxApp\Api;


use Swoft\Redis\Redis;

use Jlzan1314\WxApp\Http\Http;

class BaseApi
{
	protected $appid;
	protected $secret;

	public function __construct($appid, $secret)
	{
		$this->appid = $appid;
		$this->secret = $secret;
	}

	public function getAccessToken()
	{
		$accessTokenKey = RedisKeys::createAccessTokenKey($this->appid, $this->secret);
		$token = Redis::get($accessTokenKey);
		if ($token) {
			return $token;
		}

		$url = ApiUrl::ACCESS_TOKEN;
		$param = array(
			'grant_type' => 'client_credential',
			'appid' => $this->appid,
			'secret' => $this->secret,
		);
		$res = $this->sendHttpRequest($url, $param, null, false);
		if (!isset($res['access_token'])) {
			throw new WxAppException($res['errcode'] . ':' . $res['errmsg'], $res['errcode']);
		}

		Redis::set($accessTokenKey, $res['access_token'], $res['expires_in'] - 200);
		return $res['access_token'];
	}

	public function sendRequestWithToken($url, $body_param = null, $is_post = true)
	{
		$token = array(
			'access_token' => $this->getAccessToken()
		);
		return $this->sendHttpRequest($url, $token, $body_param, $is_post);
	}

	/**
	 * @param string $url
	 * @param array $urlParam
	 * @param array $bodyParam
	 * @param bool $isPost
	 * @return mixed
	 * @throws WxAppException
	 */
	public function sendHttpRequest($url, $urlParam = null, $bodyParam = null, $isPost = true)
	{
		if ($urlParam) {
			$urlParam = '?' . http_build_query($urlParam);
		}
		$url = $url . $urlParam;

		if ($bodyParam) {
			$bodyParam = json_encode($bodyParam, JSON_UNESCAPED_UNICODE);
		}
		if ($isPost) {
			$data = Http::post($url, $bodyParam);
		} else {
			$data = Http::get($url);
		}

		$jsonData = json_decode($data, true);
		if ($jsonData) {
			if (isset($jsonData['errcode']) && $jsonData['errcode'] != 0) {
				throw new WxAppException($jsonData['errcode'] . ':' . $jsonData['errmsg'], $jsonData['errcode']);
			}
			return $jsonData;
		}
		return $data;
	}

}