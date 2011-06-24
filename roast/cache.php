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

namespace roast;

/**
 * \roast\cache makes your server happy(?)
 *
 * @author Filipe Dobreira <dobreira@gmail.com>
 * @copyright 2011 Filipe Dobreira
 * @version 1
 */
class cache
{
	/**
	 * the active cache adapter
	 * @var object
	 */
	private static $_adapter;

	/**
	 * set_adapter
	 * sets the cache adapter, from a string name
	 * (mapped to \roast\cache\adapter\<name>) or a
	 * compatible object.
	 *
	 * @param string|object $adapter
	 */
	public static function set_adapter($adapter)
	{
		if(is_object($adapter))
		{
			return static::$_adapter = $adapter;
		}
		
		$adapter = '\\roast\\cache\\adapter\\' . $adapter;
		return static::$_adapter = new $adapter;	
	}

	/**
	 * set
	 * stores a new cache entry
	 *
	 * @param string $key
	 * @param mixed $value
	 * @param int $ttl time-to-live in seconds, 0 is permanent
	 * @return bool
	 */
	public static function set($key, $value, $ttl = 0)
	{
		if(!static::$_adapter)
		{
			return null;
		}

		return static::$_adapter->set($key, $value, $ttl);
	}

	/**
	 * get
	 * retrieves a cached entry by name
	 *
	 * @param string $key
	 * @return mixed|null null if not set or no adapter
	 */
	public static function get($key)
	{
		if(!static::$_adapter)
		{
			return null;
		}

		return static::$_adapter->get($key);
	}

	/**
	 * del
	 * deletes a cache entry
	 *
	 * @param string $key
	 * @return bool
	 */
	public static function del($key)
	{
		if(!static::$_adapter)
		{
			return null;
		}
		
		return static::$_adapter->del($key);
	}

	/**
	 * clear
	 * completely empties the cache.
	 *
	 * @return bool
	 */
	public static function clear()
	{
		if(!static::$_adapter)
		{
			return null;
		}

		return static::$_adapter->clear();
	}

	/**
	 * get_adapter_instance
	 *
	 * @return object|null
	 */
	public static function get_adapter_instance()
	{
		return static::$_adapter;
	}
}