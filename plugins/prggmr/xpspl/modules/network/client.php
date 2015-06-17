<?php
namespace network;
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */

use \XPSPL\processor\idle as idle,
    \XPSPL\Handle;

/**
 * Client
 *
 * Connected client socket.
 */
class Client extends Connection {

    /**
     * Constructs a new client connection.
     *
     * @param  resource  $socket  Socket connection.
     *
     * @return  void
     */
    public function __construct($socket)
    {
        parent::__construct($socket);
        if (false === $this->_connect()) {
            throw_socket_error();
        }
    }

    /**
     * Establishes the socket connection.
     *
     * @return  boolean
     */
    protected function _connect(/* ... */) 
    {
        $this->_socket = @socket_accept($this->_socket);
        if (false === $this->_socket) {
            return false;
        }
        socket_set_nonblock($this->_socket);
        return true;
    }
}