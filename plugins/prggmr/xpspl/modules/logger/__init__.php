<?php
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */
define('LOGGER_VERSION', 'v1.0.0');
$dir = dirname(realpath(__FILE__));
require_once $dir.'/logger.php';
unset($dir);