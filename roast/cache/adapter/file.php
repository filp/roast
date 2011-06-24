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
 * \roast\cache\adapter\file
 * file-based adapter for the roast cache
 *
 * @author Filipe Dobreira <dobreira@gmail.com>
 * @copyright 2011 Filipe Dobreira
 * @version 1
 */
class file
{

	/**
	 * @var string the cache store root
	 */
	private $_path;

	/**
	 * @var string
	 */
	private $_prefix;

	/**
	 * @var array
	 */
	private $_cache;

	/**
	 * _key_to_path
	 *
	 * @param string $key
	 * @return string
	 */
	private function _key_to_path($key)
	{
		return $this->_path . '/' . $this->_prefix . '_' . substr(md5($key), 0, 18);
	}

	/**
	 * __construct
	 *
	 * @return void
	 */
	public function __construct()
	{	
		if(!$this->_path = (string) app::cfg('cache.adapter.file.root'))
		{
			throw new exception('no cache.adapter.file.root parameter specified for the file adapter!');
		}

		$this->_prefix = (string) app::cfg('cache.adapter.file.prefix');
		$this->_cache = array();
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
		$path = $this->_key_to_path($key);
		if(!file_put_contents($path, json_encode($value)))
		{
			return false;
		}

		return ( $this->_cache[$key] = $value );
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
		$path = $this->_key_to_path($key);

		if(isset($this->_cache[$key]))
		{
			return $this->_cache[$key];
		}

		if(!is_file($path))
		{
			return null;
		}

		if(!$this->_cache[$key] = json_decode( file_get_contents($path), true))
		{
			return null;
		}

		return $this->_cache[$key];
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
		return ( @unlink($this->_key_to_path($key)) );
	}

	/**
	 * clear
	 *
	 * @see \roast\cache::clear
	 * @return bool
	 */
	public function clear()
	{
		return false; // TO-DO
	}
}