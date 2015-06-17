<?php
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */

// Add this to include path
if (!defined('XPSPL_PATH')) {
    define('XPSPL_PATH', dirname(realpath(__FILE__)).'/..');
}

if (!defined('XPSPL_DEBUG')) {
    /**
     * XPSPL Debug mode
     *
     * When turned on XPSPL generates a log of all activity to STDOUT.
     * 
     * When turned off XPSPL removes its processor traces from uncaught exceptions.
     */
    define('XPSPL_DEBUG', false);
}

if (!defined('XPSPL_SIGNAL_HISTORY')) {
    /**
     * Signal History
     * 
     * Default setting for the saving the signal history. 
     * 
     * By default this is ``false``.
     */
    define('XPSPL_SIGNAL_HISTORY', false);
}

if (!defined('XPSPL_PURGE_EXHAUSTED')) {
    /**
     * Remove Exhausted processes
     * 
     * When turned on this automatically removes installed processes from the 
     * processor once it determines they can no longer be used.
     *
     * By default this settings is ``true``.
     */
    define('XPSPL_PURGE_EXHAUSTED', true);
}

if (!defined('XPSPL_MODULE_DIR')) {
    /**
     * Module Directory
     * 
     * Directory to look for modules.
     *
     * By default it is set to the ``module`` directory in XPSPL.
     */
    define('XPSPL_MODULE_DIR', XPSPL_PATH . '/modules');
}

if (!defined('XPSPL_PROCESS_DEFAULT_EXHAUST')) {
    /**
     * Default process exhaustion
     *
     * Integer option defining the default exhausting of a process.
     *
     * By default it is ``1``.
     */
    define('XPSPL_PROCESS_DEFAULT_EXHAUST', 1);
}

if (!defined('XPSPL_PROCESS_DEFAULT_PRIORITY')) {
    /**
     * Process default priority
     * 
     * Integer option defining the default priority of all processes.
     *
     * By default it is ``10``.
     */
    define('XPSPL_PROCESS_DEFAULT_PRIORITY', 10);
}

if (!defined('XPSPL_JUDY_SUPPORT')) {
    /**
     * Judy is an optional database configuration.
     *
     * http://xpspl.prggmr.org/en/xspel/install.html#optional
     *
     * Currently this is experimental as an attempt to improve performance.
     *
     * Once stable this will automatically be enabled if Judy is detected.
     */
    define('XPSPL_JUDY_SUPPORT', false);
    //define('XPSPL_JUDY_SUPPORT', class_exists('Judy', false));
}

if (!defined('XPSPL_ANALYZE_TIME')) {
    /**
     * **UNUSED**
     * 
     * This is an unused configuration option that will later add support 
     * for analyzing the processor timing to auto correct signal timing.
     */
    define('XPSPL_ANALYZE_TIME', class_exists('Judy', false));
}

/**
 * XPSPL Log
 *
 * Logger identifier for XPSPL's log.
 */
define('XPSPL_LOG', 0);
/**
 * Seconds second timing instruction
 * 
 * This declares operations based on time in seconds.
 */
define('TIME_SECONDS', 4);
/**
 * Millisecond timing instruction
 * 
 * This declares operations based on time in milliseconds.
 */
define('TIME_MILLISECONDS', 3);
/**
 * Microsecond timing instruction
 * 
 * This declares operations based on time in microseconds.
 */
define('TIME_MICROSECONDS', 2);
/**
 * Nanosecond timing instruction
 * 
 * This declares operations based on time in nanoseconds.
 */
define('TIME_NANOSECONDS', 1);
/**
 * Declared for use.
 */
define('STATE_DECLARED' , 0x00001);
/**
 * Currently running in execution.
 */
define('STATE_RUNNING'  , 0x00002);
/**
 * Execution finised.
 */
define('STATE_EXITED'   , 0x00003);
/**
 * Error encountered.
 */
define('STATE_ERROR'    , 0x00004);
/**
 * Successfully ran through a lifecycle and reused.
 */
define('STATE_RECYCLED' , 0x00005);
/**
 * Corrupted during runtime execution and recovery was succesful.
 */
define('STATE_RECOVERED', 0x00006);
/**
 * The object has declared to stop any further execution.
 */
define('STATE_HALTED'   , 0x00007);
/**
 * Signal is a parent of itself.
 */
define('SIGNAL_SELF_PARENT', 0x01);
/**
 * Default priority for subdatabase processes
 */
define('XPSPL_SUBDATABASE_DEFAULT_PRIORITY', 1);