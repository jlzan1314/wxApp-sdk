<?php
/**
 * Created by PhpStorm.
 * User: Jlzan1314
 * Date: 2017/7/30
 * Time: 11:16
 */

namespace Jlzan1314\WxApp\Api;

use Swoft\Bean\Annotation\Mapping\Bean;

/**
 * @package Jlzan1314\WxApp\Api
 * @Bean(scope=Bean::PROTOTYPE)
 */
class SessionKey extends BaseApi
{


	public function get($code){
		$url = ApiUrl::SESSION_KEY;
		$param = array(
			'appid'=>$this->wxApp->getAppid(),
			'secret'=>$this->wxApp->getSecret(),
			'js_code'=>$code,
			'grant_type'=>'authorization_code',
		);
		return file_get_contents($url.'?'.http_build_query($param));
	}
}