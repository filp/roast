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
 * \roast\app is the big dog on the block.
 *
 * @author Filipe Dobreira <dobreira@gmail.com>
 * @copyright 2011 Filipe Dobreira
 * @version 1
 */
class app
{
	/**
	 * class=>path relationships used by the autoloader
	 * @var array
	 */
	private static $_autoloader_paths;

	/**
	 * internal configuration data
	 * @var array
	 */
	private static $_cfg;
	
	/**
	 * run
	 *
	 * @param array $config
	 */
	public static function run(array $config)
	{
		static::_autoload_init();
		static::$_cfg = $config ?: array();

		// sets up the cache/adapter.
		if(static::cfg('cache.enabled') && static::cfg('cache.adapter'))
		{
			cache::set_adapter(static::cfg('cache.adapter'));
		}
	}

	/**
	 * cfg
	 * overloaded getter/setter for app configuration
	 * parameters.
	 *
	 * app::cfg('param') -> returns the 'param' parameter or null.
	 * app::cfg('param', 'foo') -> sets 'param' to 'foo'
	 *
	 * @param string $key
	 * @param mixed $value
	 * @return mixed|null null if not set
	 */
	public static function cfg($key, $value = null)
	{
		if($value !== null)
		{
			return static::$_cfg[$key] = $value;
		}

		if(isset(static::$_cfg[$key]))
		{
			return static::$_cfg[$key];
		}
	}

	/**
	 * autoload
	 * internal autoloader implementation. the class name
	 * and namespace is interpreted as a path to the class
	 * file, so that for the following class:
	 *
	 * \roast\mynamespace\ponies
	 *
	 * the following path is required:
	 *
	 * %app%/roast/mynamespace/ponies.php
	 *
	 * if the class has been registered with the autoloader,
	 * the registered path will be used instead of the above
	 * method.
	 *
	 * @param string $class_name
	 */
	public static function autoload($class_name)
	{
		if(!($path = static::$_autoloader_paths[$class_name]))
		{
			$path = dirname(__DIR__) . DIRECTORY_SEPARATOR . str_replace('\\', DIRECTORY_SEPARATOR, $class_name) . '.php';
		}

		require $path;

		// classes can define a public static _init method
		if(is_callable($class_name . '::_init'))
		{
			call_user_func($class_name . '::_init');
		}
	}

	/**
	 * register_autoloader_path
	 * register an array of classname=>path values used
	 * to point the integrated autoloader to a class file.
	 *
	 * handy in cases where the class name does not reflect
	 * the location of its file.
	 *
	 * @param array $paths
	 */
	public static function register_autoloader_path(array $paths)
	{
		if(!static::$_autoloader_paths)
		{
			static::$_autoloader_paths = array();
		}

		static::$_autoloader_paths = array_merge(static::$_autoloader_paths, $paths);
	}

	/**
	 * _autoload_init
	 *
	 * prepares the integrated autoloader for use
	 *
	 */
	private static function _autoload_init()
	{
		spl_autoload_register(array('\roast\app', 'autoload'), true, true);
	}	
}