<?php
namespace network;
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */

/**
 * Creates a new socket connection.
 *
 * @param  string  $address  Address to make the connection on.
 * @param  string  $options  Connection options
 * @param  callback  $callback  Function to call when connected
 */
function connect($address, $options = [])
{
    $server = new Socket($address, $options);
    signal($server, null_exhaust(null));
    return $server;
}

/**
 * Throws a runtime exception of the last socket error
 *
 * @throws  RuntimeException
 * 
 * @return  void
 */
function throw_socket_error() {
    $code = socket_last_error();
    $str = socket_strerror($code);
    throw new \RuntimeException(sprintf(
        '(%s) - %s',
        $code, $str
    ));
}