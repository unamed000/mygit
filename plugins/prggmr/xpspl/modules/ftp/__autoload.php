<?php
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */
$dir = dirname(realpath(__FILE__));

/**
 * Autoload the ftp signals.
 */
require_once $dir.'/src/api.php';
set_include_path(
    dirname(realpath(__FILE__)) . '/../' .
    PATH_SEPARATOR . 
    get_include_path()
);