<?php
/**
 * Copyright (c) 2018. 南京痕迹网络科技有限公司
 */

/**
 * Created by PhpStorm.
 * User: jlzan
 * Date: 2018/11/8
 * Time: 15:27
 */

namespace Jlzan1314\WxApp\Http;


interface HttpClientInterface
{
	public function post($url, $postData, $time = 20);

	public function get($url, $time = 20);

	public function postWithSSL($url, $postData, $sslCert, $sslKey, $time = 20);
}