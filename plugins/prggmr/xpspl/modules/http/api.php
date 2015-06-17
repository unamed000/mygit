<?php
namespace XPSPL;
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */

/**
 * API can be included to load the entire signal.
 */

use \XPSPL\http as http;

/**
 * Attaches a new process to a URI request.
 *
 * @param  string  $uri  URI of request to process.
 * @param  object  $function  Closure function to execute
 * @param  string|array  $method  Request method type to process.
 * @param  object  $event  XPSPL\http\Event object
 * 
 * @return  object  XPSPL\Process
 */
function uri_request($uri, $function, $method = null, $event = null) { 
    return \XPSPL\process(new http\Uri(
        $uri, $method, $event
    ), $function);
}