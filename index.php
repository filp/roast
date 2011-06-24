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
 * roast is a lightweight api service
 *
 * @author Filipe Dobreira <dobreira@gmail.com>
 * @copyright 2011 Filipe Dobreira
 * @version 1
 */
require 'roast/app.php';
roast\app::run(
	array(

		// the default output format:
		'format.default'  => 'json',

		// an array of accepted output formats, mapped 
		// to format/adapter/<format> classes.
		'format.accept'   => 
			array( 'json', 'serialize', 'print_r' ),
		
		// opaque on/off switch, all cache operations will return false/null.
		'cache.enabled'   => true,  

		// apc, redis, or another custom adapter, mapped to
		// cache/adapter/<adapter>
		// alternatively, also accepts a compatible object instance.
		'cache.adapter'	  => 'apc',

		// extra parameter examples for the redis cache adapter,
		// uncomment as needed:
		// 'cache.adapter.redis.host' => array('127.0.0.1') // default to 6379
		// 'cache.adapter.redis.host' => array('127.0.0.1', 6379)
		// 'cache.adapter.redis.host' => array('/tmp/redis.sock')
		
	)
);