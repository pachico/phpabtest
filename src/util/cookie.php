<?php

namespace Pachico\Abtest\Util;

/**
 * 
 */
class Cookie
{

	/**
	 *
	 * @var string
	 */
	private $_name;

	/**
	 * 
	 * @param string $name
	 */
	public function __construct($name)
	{
		$this->_name = $name;
	}

	/**
	 * 
	 * @return mixed
	 */
	public function get()
	{
		return filter_input(INPUT_COOKIE, $this->_name);
	}

	/**
	 * 
	 * @param mixed $content
	 * @param int $ttl
	 * @return bool
	 */
	public function save($content, $ttl)
	{

		if (php_sapi_name() === 'cli')
		{
			return true;
		}

		if (headers_sent())
		{
			throw new \RuntimeException('Headers are already sent. Cookie cannot be saved.');
		}

		return setcookie($content, ($ttl < 1)
				? -1
				: time() + $ttl, '/');
	}

}
