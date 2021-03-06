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

/**
 * \roast\cache\adapter\apc
 * apc adapter for the roast cache
 *
 * @author Filipe Dobreira <dobreira@gmail.com>
 * @copyright 2011 Filipe Dobreira
 * @version 1
 */
class apc
{
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
		return apc_store($key, $value, $ttl);
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
		return apc_fetch($key);
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
		return apc_delete($key);
	}

	/**
	 * clear
	 *
	 * @see \roast\cache::clear
	 * @return bool
	 */
	public function clear()
	{
		return apc_clear_cache('user');
	}
}