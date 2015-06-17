<?php
namespace XPSPL;
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */

use XPSPL\exception\Module_Load_Failure;

/**
 * Library
 * 
 * Loads and tracks XPSPL modules.
 */
class Library extends Database {

    use Singleton;

    /**
     * Loads a XPSPL module.
     * 
     * @param  string  $name  Module name.
     * @param  string|null  $dir  Location of the module. 
     * 
     * @return  void
     */
    public function load($name, $dir = null) 
    {
        // already loaded
        if (isset($this->_storage[$name])) return;
        if ($dir === null) {
            $dir = XPSPL_MODULE_DIR;
        }
        if (!is_dir($dir)) {
            throw new Module_Load_Failure(sprintf(
                "Module directory %s does not exist", $dir
            ));
        }
        $path = $dir.'/'.$name;
        $this->_storage[$name] = true;
        require_once $path.'/__init__.php';
        if (!defined(strtoupper(sprintf('%s_version', $name)))) {
            throw new \RuntimeException(sprintf(
                'Module %s does not specify a version',
                $name
            ));
        }
    }
}