<?php
namespace ftp;
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */

/**
 * EV_Complete
 * 
 * Emitted when a file has completed transfer.
 */
class EV_Complete extends \XPSPL\Event {

    /**
     * File that completed.
     */
    protected $_file = null;

    /**
     * Constructs a new complete event.
     *
     * @param  object  $file  File object
     * 
     * @return  void
     */
    public function __construct($file)
    {
        $this->_file = $file;
    }

    /**
     * Returns the file that completed.
     *
     * @return  object
     */
    public function get_file(/* ... */)
    {
        return $this->_file;
    }

}