<?php
namespace network;
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */

import('time');

use \XPSPL\Idle as idle;

/**
 * Connection
 *
 * Socket connection.
 */
class Connection {

    /**
     * Socket that is connected.
     *
     * @var  resource
     */
    protected $_socket = null;

    /**
     * Read Buffer
     *
     * @var  string|null
     */
    protected $_read_buffer = null;

    /**
     * Read Attempts
     *
     * @var  integer
     */
    protected $_read_attempted = 0;


    /**
     * Constructs a new connection.
     *
     * @param  resource  $socket  Socket connection.
     *
     * @return  void
     */
    public function __construct($socket)
    {
        $this->_socket = $socket;
    }

    /**
     * Returns the socket resource.
     *
     * @return  resource
     */
    public function get_resource(/* ... */)
    {
        return $this->_socket;
    }

    /**
     * Writes data to the socket.
     *
     * @param  string  $string  String to send.
     * @param  integer  $flags  Send flags - php.net/socket_send
     *
     * @return  integer|boolean  Number of bytes written, False on error
     */
    public function write($string, $flags = null)
    {
        if ($flags !== null) {
            return socket_send(
                $this->get_resource(), $string, strlen($string), $flags
            );
        }
        return socket_write($this->get_resource(), $string);
    }

    /**
     * Reads the given length of data from the socket.
     *
     * @param  integer  $length  Maximum number of bytes to read in.
     *                           Default = 2MB
     * @param  integer  $flags  See php.net/socket_recv
     *
     * @return  string
     */
    public function read($length = XPSPL_SOCKET_READ_LENGTH, $flags = MSG_DONTWAIT) 
    {
        $r = null;
        $read = @socket_recv($this->get_resource(), $r, $length, $flags);
        // Gracefull disconnect
        if ($read === 0) {
            return false;
        }
        if ($read === false) {
            $error = socket_last_error($this->get_resource());
            if ($error == SOCKET_EWOULDBLOCK) {
                if ($this->_read_attempted >= 10) {
                    return false;
                } else {
                    ++$this->_read_attemped;
                }
                return;
            }
            return false;
        }
        $this->_read_attempted = 0;
        return $r;
    }

    /**
     * Returns if the socket is currently connected.
     * 
     * @return  boolean
     */
    public function is_connected(/* ... */)
    {
        if (!is_resource($this->get_resource())) {
            return false;
        }
        // peek into the connection reading 1 byte
        if (false === $this->read(1, MSG_DONTWAIT ^ MSG_PEEK)) {
            return false;
        }
        if (null !== $this->_read_buffer) {
            return true;
        }
        $read = $this->read();
        if (false === $read) {
            return false;
        }
        $this->_read_buffer = $read;
        return true;
    }

    /**
     * Send the signal to disconnect this socket.
     *
     * @param  integer  $how
     *
     * @return  event\Disconnect
     */
    public function disconnect(/* ... */)
    {
        socket_close($this->_socket);
        return emit(new SIG_Disconnect(null, $this));
    }

    /**
     * Returns the address of the socket.
     *
     * @return  string|null
     */
    public function get_address(/* ... */)
    {
        $r = null;
        /**
         * This is documented as stating this should only be used
         * for socket_connect'ed sockets ... for now this seems to work.
         */
        socket_getsockname($this->get_resource(), $r);
        return $r;
    }

    /**
     * Establishes the socket connection.
     *
     * @return  void
     */
    protected function _connect(/* ... */) {
        throw new \RuntimeException;
    }
}

/**
 * Disconnects a socket signal.
 *
 * @param  object  $sig_disconnect  \network\SIG_Disconnect
 * 
 * @return  void
 */
function system_disconnect(SIG_Disconnect $sig_disconnect) 
{
    if (is_resource($sig_disconnect->socket->get_resource())) {
        socket_close($sig_disconnect->socket->get_resource());
    }
}

/**
 * Register the disconnect
 *
 * This fires as a last priority to allow pushing content to the host.
 *
 * Though it should be noted that pushing content to a disconnected socket might 
 * not get the data.
 */
signal(
    new SIG_Disconnect(), 
    low_priority(null_exhaust('\network\system_disconnect'))
);
