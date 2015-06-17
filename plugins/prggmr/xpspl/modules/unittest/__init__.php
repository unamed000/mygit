<?php
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */

define('UNITTEST_VERSION', 'v1.0.0');

/**
 * Output colors
 */
if (!defined('OUTPUT_COLORS')) {
    define('OUTPUT_COLORS', true);
}

/**
 * Maximum depth to transverse a tree or object while outputting.
 */
if (!defined('MAX_DEPTH')) {
    define('MAX_DEPTH', 2);
}

/**
 * Use shorterned variables within the output
 */
if (!defined('SHORT_VARS')) {
    define('SHORT_VARS', true);
}

/**
 * Level of verbosity for output
 */
if (!defined('VERBOSITY_LEVEL')) {
    define('VERBOSITY_LEVEL', 1);
}

$dir = dirname(realpath(__FILE__));
require_once $dir.'/sig_test.php';
require_once $dir.'/sig_suite.php';
require_once $dir.'/output.php';
require_once $dir.'/assertions.php';
require_once $dir.'/api.php';
require_once $dir.'/assertions/default.php';
unset($dir);