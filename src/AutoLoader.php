<?php declare(strict_types=1);

namespace Jlzan1314\WxApp;

use Swoft\SwoftComponent;

class AutoLoader extends SwoftComponent
{
	/**
	 * @return array
	 */
	public function getPrefixDirs(): array
	{
		return [
			__NAMESPACE__ => __DIR__,
		];
	}

	/**
	 * @return array
	 */
	public function metadata(): array
	{
		return [];
	}
}
