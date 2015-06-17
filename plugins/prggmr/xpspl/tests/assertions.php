<?php
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */

/**
 * Processor Error Assertions
 */

/**
 * Asserts the given processor error signal emits.
 */
unittest\create_assertion(function($signal, \Closure $function){
    ob_start();
    $function = $function->bindTo($test);
    $function();
    $contents = ob_get_contents();
    ob_end_clean();
    return stripos($contents, 'Exception: '.$signal) !== false;
}, 'processor_error_emit', 'Error %s was not signaled');

/**
 * Asserts the given processor error signal was not emitted.
 */
unittest\create_assertion(function($signal, \Closure $function){
    ob_start();
    $function = $function->bindTo($test);
    $function();
    $contents = ob_get_contents();
    ob_end_clean();
    return stripos($contents, 'Exception: '.$signal) === false;
}, 'processor_error_not_emit', 'Error %s was signaled');