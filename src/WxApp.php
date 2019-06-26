<?php
/**
 * Created by PhpStorm.
 * User: Jlzan1314
 * Date: 2017/7/29
 * Time: 10:04
 */

namespace Jlzan1314\WxApp;

use Jlzan1314\WxApp\Api\CustomMsg;
use Jlzan1314\WxApp\Api\QRCode;
use Jlzan1314\WxApp\Api\SessionKey;
use Jlzan1314\WxApp\Api\Statistic;
use Jlzan1314\WxApp\Api\TemplateMsg;

/**
 * Class WeApp
 * @package Jlzan1314\WxApp
 */
class WxApp
{
	/**
	 * @var string
	 */
	protected $appid;

	/**
	 * @var string
	 */
	protected $secret;
	/**
	 * @var SessionKey
	 */
	private $sessionKey;

	/**
	 * @var TemplateMsg
	 */
	private $templateMsg;

	/**
	 * @var QRCode
	 */
	private $qrCode;

	/**
	 * @var CustomMsg
	 */
	private $customMsg;

	/**
	 * @var Statistic
	 */
	private $statistic;

	/**
	 * @return string
	 */
	public function getAppid(): string
	{
		return $this->appid;
	}

	/**
	 * @return string
	 */
	public function getSecret(): string
	{
		return $this->secret;
	}

	/**
	 * @return SessionKey
	 */
	public function getSessionKey(): SessionKey
	{
		if (!$this->sessionKey) {
			$this->sessionKey = SessionKey::new($this);
		}
		return $this->sessionKey;
	}

	/**
	 * @return TemplateMsg
	 */
	public function getTemplateMsg(): TemplateMsg
	{
		if (!$this->templateMsg) {
			$this->templateMsg = TemplateMsg::new($this);
		}
		return $this->templateMsg;
	}

	/**
	 * @return QRCode
	 */
	public function getQrCode(): QRCode
	{
		if (!$this->qrCode) {
			$this->qrCode = QRCode::new($this);
		}
		return $this->qrCode;
	}

	/**
	 * @return CustomMsg
	 */
	public function getCustomMsg(): CustomMsg
	{
		if (!$this->customMsg) {
			$this->customMsg = CustomMsg::new($this);
		}
		return $this->customMsg;
	}

	/**
	 * @return Statistic
	 */
	public function getStatistic(): Statistic
	{
		if (!$this->statistic) {
			$this->statistic = Statistic::new($this);
		}
		return $this->statistic;
	}
}