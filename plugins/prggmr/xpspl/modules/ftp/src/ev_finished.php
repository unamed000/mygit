<?php
namespace ftp;
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */

/**
 * EV_Finished
 * 
 * Emitted when a uploader finishes all transfers.
 */
class EV_Finished extends \XPSPL\Event {

    /**
     * SIG_Upload object
     */
    protected $_upload = null;

    /**
     * Constructs a new finished event.
     *
     * @param  object  $upload  Upload object
     * 
     * @return  void
     */
    public function __construct($upload)
    {
        $this->_upload = $upload;
    }

    /**
     * Returns the upload that finished.
     *
     * @return  object
     */
    public function get_upload(/* ... */)
    {
        return $this->_upload;
    }

}