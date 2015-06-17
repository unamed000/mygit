<?php
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */


/**
 * Cleans any exhausted signal queues from the processor.
 * 
 * @param  boolean  $history  Erase any history of the signals cleaned.
 * 
 * @return  void
 */
function clean($history = false)
{
    return XPSPL::instance()->clean($history);
}

/**
 * Delete a signal from the processor.
 * 
 * @param  string|object|int  $signal  Signal to delete.
 * @param  boolean  $history  Erase any history of the signal.
 * 
 * @return  boolean
 */
function delete_signal($signal, $history = false)
{
    return XPSPL::instance()->delete_signal($storage, $history);
}

/**
 * Erases any history of a signal.
 * 
 * @param  string|object  $signal  Signal to be erased from history.
 * 
 * @return  void
 */
function erase_signal_history($signal)
{
    return XPSPL::instance()->erase_signal_history($signal);
}

/**
 * Disables the exception process.
 *
 * @param  boolean  $history  Erase any history of exceptions signaled.
 *
 * @return  void
 */
function disable_signaled_exceptions($history = false)
{
    return XPSPL::instance()->disable_signaled_exceptions($history);
}

/**
 * Cleans out the entire event history.
 *
 * @return  void
 */
function erase_history()
{
    return XPSPL::instance()->erase_history();
}

/**
 * Sets the flag for storing the event history.
 *
 * @param  boolean  $flag
 *
 * @return  void
 */
function set_signal_history($flag)
{
    return XPSPL::instance()->set_signal_history($flag);
}

/**
 * Registers a new event listener object in the processor.
 * 
 * @param  object  $listener  The event listening object
 * 
 * @return  void
 */
function listen($listener)
{
    return XPSPL::instance()->listen($listener);
}

/**
 * Performs a inclusion of the entire directory content, including 
 * subdirectories, with the option to start a listener once the file has been 
 * included.
 *
 * @param  string  $dir  Directory to include.
 * @param  boolean  $listen  Start listeners.
 * @param  string  $path  Path to ignore when starting listeners.
 *
 * @return  void
 */
function dir_include($dir, $listen = false, $path = null)
{
    /**
     * This is some pretty narly code but so far the fastest I have been able 
     * to get this to run.
     */
    $iterator = new \RegexIterator(
        new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($dir)
        ), '/^.+\.php$/i', \RecursiveRegexIterator::GET_MATCH
    );
    foreach ($iterator as $_file) {
        array_map(function($i) use ($path, $listen){
            include $i;
            if (!$listen) {
                return false;
            }
            if (WINDOWS) {
                $x = '\\';
            } else {
                $x = '/';
            }
            $data = explode($x, str_replace([$path, '.php'], '', $i));
            $class = array_pop($data);
            $namespace = implode('\\', $data);
            $process = $namespace.'\\'.ucfirst($class);
            if (class_exists($process, false) && 
                is_subclass_of($process, '\XPSPL\Listener')) {
                listen(new $process());
            }
        }, $_file);
    }
}

/**
 * Returns the current signal in execution.
 *
 * @param  integer  $offset  In memory hierarchy offset +/-.
 *
 * @return  object
 */
function current_signal($offset = 0)
{
    return XPSPL::instance()->current_signal($offset);
}

/**
 * Returns the current event in execution.
 *
 * @param  integer  $offset  In memory hierarchy offset +/-.
 *
 * @return  object
 */
function current_event($offset = 0)
{
    return XPSPL::instance()->current_event($offset);
}

/**
 * Call the provided function on processor shutdown.
 * 
 * @param  callable|object  $function  Function or process object
 * 
 * @return  object  \XPSPL\Process
 */
function on_shutdown($function)
{
    return signal(new \XPSPL\processor\SIG_Shutdown(), $function);
}

/**
 * Call the provided function on processor start.
 * 
 * @param  callable|object  $function  Function or process object
 * 
 * @return  object  \XPSPL\Process
 */
function on_start($function)
{
    return signal(new \XPSPL\processor\SIG_Startup(), $function);
}

/**
 * Empties the storage, history and clears the current state.
 *
 * @return void
 */
function XPSPL_flush(/* ... */)
{
    return XPSPL::instance()->flush();
}