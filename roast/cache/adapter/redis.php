<?php
/**
 *	Copyright (C) 2011 by Filipe Dobreira
 *
 *	Permission is hereby granted, free of charge, to any person obtaining a copy
 *	of this software and associated documentation files (the "Software"), to deal
 *	in the Software without restriction, including without limitation the rights
 *	to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 *	copies of the Software, and to permit persons to whom the Software is
 *	furnished to do so, subject to the following conditions:
 *
 *	The above copyright notice and this permission notice shall be included in
 *	all copies or substantial portions of the Software.
 *
 *	THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 *	IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 *	FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 *	AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 *	LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 *	OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 *	THE SOFTWARE.
 *
 */

namespace roast\cache\adapter;
use roast\cache\exception;
use roast\app;

/**
 * \roast\cache\adapter\redis
 * redis adapter for the roast cache
 * 
 * IMPORTANT: requires phpredis:
 * https://github.com/nicolasff/phpredis
 *
 * @author Filipe Dobreira <dobreira@gmail.com>
 * @copyright 2011 Filipe Dobreira
 * @version 1
 */
class redis
{
	/**
	 * @var Redis
	 */
	private $_redis;

	/**
	 * __construct
	 *
	 * @return void
	 */
	public function __construct()
	{
		if(!$params = app::cfg('cache.adapter.redis.host'))
		{
			throw new exception('missing connection parameters: cache.adapter.redis.host');
		}

		$this->_redis = new \Redis();
		if(!call_user_func(array($this->_redis, 'connect'), $params))
		{
			throw new exception('failed to open redis connection (params:' . print_r($params, true) .')');
		}
	}

	/**
	 * set
	 *
	 * @see \roast\cache::set
	 * @param string $key
	 * @param mixed $value
	 * @param int $ttl
	 * @return bool
	 */
	public function set($key, $value, $ttl = 0)
	{
		if($ttl === 0)
		{
			return $this->_redis->set($key, $value);
		}

		return $this->_redis->setex($key, $ttl, $value);
	}

	/**
	 * get
	 *
	 * @see \roast\cache::get
	 * @param string $key
	 * @return mixed|null
	 */
	public function get($key)
	{
		// returns false if not set; which is turned to null for consistency.
		return $this->_redis->get($key) ?: null;
	}

	/**
	 * del
	 *
	 * @see \roast\cache::del
	 * @param string $key
	 * @return bool
	 */
	public function del($key)
	{
		return $this->_redis->del($key);
	}

	/**
	 * clear
	 *
	 * @see \roast\cache::clear
	 * @return bool
	 */
	public function clear()
	{
		// need to look into this :I
		return false;
	}
}