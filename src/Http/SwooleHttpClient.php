<?php
/**
 * Copyright (c) 2018. 南京痕迹网络科技有限公司
 */

/**
 * Created by PhpStorm.
 * User: jlzan
 * Date: 2018/11/8
 * Time: 15:23
 */

namespace Jlzan1314\WxApp\Http;

use Swoft\Bean\Annotation\Mapping\Bean;
use Swoft\Http\Message\Uri\Uri;
use Swoole\Coroutine\Http\Client;

/**
 * @Bean()
 * Class SwooleHttpClient
 * @package Traceint\Http
 */

class SwooleHttpClient implements HttpClientInterface
{
	public function post($url, $postData, $time = 20)
	{
		$uri = Http::parseUri($url);
		$path=$this->getPath($uri);
		if (!$path) {
			return false;
		}
		$client = $this->getClient($time, $uri);
		$client->post($path, $postData);
		return $this->getResponse($client);
	}

	private function getPath(Uri $uri)
	{
		return Uri::composeComponents('', '', $uri->getPath(), $uri->getQuery(), '');
	}

	public function get($url, $time = 20)
	{
		$uri = Http::parseUri($url);
		$client = $this->getClient($time, $uri);
		$client->get($this->getPath($uri));
		return $this->getResponse($client);
	}

	public function postWithSSL($url, $postData, $sslCert, $sslKey, $time = 20)
	{
		$uri = Http::parseUri($url);
		$client = $this->getClient($time, $uri);
		$client->set(array(
			'ssl_cert_file' => $sslCert,
			'ssl_key_file' => $sslKey,
			'ssl_verify_peer' => false,
			'ssl_allow_self_signed' => true,
//			'ssl_host_name' => $uri->getHost(),
		));
		$client->get($this->getPath($uri));
		return $this->getResponse($client);
	}

	/**
	 * @param $time
	 * @param $uri
	 * @return Client
	 */
	private function getClient($time, Uri $uri): Client
	{
		$port = $uri->getPort() ? $uri->getPort() : $uri->getDefaultPort();
		$client = new Client($uri->getHost(), $port, $uri->getScheme() == 'https');
		$client->setHeaders([
			'Host' => $uri->getHost(),
			"User-Agent" => 'Chrome/49.0.2587.3',
			'Accept' => 'text/html,application/xhtml+xml,application/xml,application/json',
			'Accept-Encoding' => 'gzip',
		]);
		$client->set(['timeout' => $time]);
		return $client;
	}

	/**
	 * @param $client
	 * @return bool
	 */
	private function getResponse(Client $client)
	{
		$body = $client->body;
		$client->close();

		if ($client->statusCode != 200) {
			return false;
		}
		return $body;
	}
}