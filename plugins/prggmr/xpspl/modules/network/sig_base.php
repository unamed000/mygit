<?php
namespace network;
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */

/**
 * Base
 * 
 * Base socket signal.
 */
class SIG_Base extends \XPSPL\SIG {

    /**
     * Unique
     */
    protected $_unique = false;

    /**
     * Socket connected for signal.
     * 
     * @var  resource
     */
    public $socket = null;

    /**
     * Socket signals use the connection and socket hash for an index.
     *
     * For global socket signal the info can be left null.
     * 
     * @return  void
     */
    public function __construct($connection = null, $socket = null)
    {
        if (null !== $socket) {
            $this->socket = $socket;
        }
        parent::__construct();
        if (null === $connection) {
            return;
        }
        $this->_index = spl_object_hash($connection).'.'.get_class($this);
    }

}