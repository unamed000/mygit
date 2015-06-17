<?php
namespace ftp;
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */

/**
 * File
 * 
 * Represents an FTP file.
 */
class File {

    /**
     * Filename
     *
     * @var  string
     */
    protected $_name = null;

    /**
     * Full path to the file.
     *
     * @var  string
     */
    protected $_path = null;

    /**
     * Mode the file must be transfered in.
     *
     * @var  integer
     */
    protected $_transfer_mode = FTP_BINARY;

    /**
     * Constructs a new file.
     *
     * @param  string  $name  Filename
     * @param  integer  $model  Transfer Mode
     *
     * @return  void
     */
    public function __construct($name, $mode = FTP_BINARY)
    {
        $path = explode("/", $name);
        $this->_name = array_pop($path);
        $this->_path = implode("/", $path);
        $this->_transfer_mode = $mode;
    }

    /**
     * Returns the filename.
     *
     * @return  string
     */
    public function get_name(/* ... */)
    {
        return $this->_name;
    }

    /**
     * Returns the file path.
     *
     * @return  string
     */
    public function get_path(/* ... */)
    {
        return $this->_path;
    }

    /**
     * Returns the full path.
     *
     * @return  string
     */
    public function get_full_path(/* ... */)
    {
        return sprintf('%s/%s', $this->_path, $this->_name);
    }

    /**
     * Returns the transfer mode.
     *
     * @return  integer
     */
    public function get_transfer_mode(/* ... */)
    {
        return $this->_transfer_mode;
    }
}