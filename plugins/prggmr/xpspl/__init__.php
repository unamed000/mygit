<?php
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */

// library version
define('XPSPL_VERSION', '4.0.1');

// The creator
define('XPSPL_MASTERMIND', 'Nickolas Whiting');

// start'er up
// utils & traits
require dirname(realpath(__FILE__)).'/XPSPL/utils.php';
require dirname(realpath(__FILE__)).'/XPSPL/const.php';

set_include_path(
    XPSPL_MODULE_DIR . PATH_SEPARATOR .
    XPSPL_PATH . PATH_SEPARATOR . 
    get_include_path()
);

// Load the API
// believe it or not this is the fastest way to do this
$dir = new \RegexIterator(
    new \RecursiveIteratorIterator(
        new \RecursiveDirectoryIterator(XPSPL_PATH.'/api')
    ), '/^.+\.php$/i', \RecursiveRegexIterator::GET_MATCH
);
foreach ($dir as $_file) {
    array_map(function($i){
        require_once $i;
    }, $_file);
}

// dev mode
if (XPSPL_DEBUG) {
    define('LOGGER_DATE_FORMAT', 'm-d-y H:i:s.u');
    error_reporting(E_ALL ^ E_STRICT);
    import('logger');
    $log = logger(XPSPL_LOG);
    $formatter = new \logger\Formatter(
        '[{date}] [{str_code}] {message}'.PHP_EOL
    );
    $log->add_handler(new \logger\Handler(
        $formatter, STDOUT
    ));
}

/**
 * XPSPL
 * 
 * XPSPL is a globally available singleton used for communication access via the 
 * API.
 */
final class XPSPL extends \XPSPL\Processor {
    use XPSPL\Singleton;
}

$timing = [];
for($i=0;$i<1000;$i++) {
    $start = microseconds();
    wait_loop();
    $timing[] = microseconds() - $start;
}
define('XPSPL_AVERAGE_LOOPTIME', (array_sum($timing) / count($timing)));

/**
 * Start the processor VROOOOOOM!
 */
set_signal_history(XPSPL_SIGNAL_HISTORY);