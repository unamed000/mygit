<?php
namespace ftp;
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */


/**
 * Performs an FTP upload of the giving files.
 *
 * @param  array  $files  Files to be uploaded
 * @param  array  $options  Connection options
 * @param  callable  $callback  Function to call when upload starts
 * @param  callable  $failure  Function to call when a file fails
 *
 * @return  void
 */
function upload($files, $options, $callback = null)
{
    $uploadf = [];
    foreach ($files as $_file) {
        if (!$_file instanceof File) {
            $_file = new File($_file);
        }
        $uploadf[] = $_file;
    }
    $upload = new SIG_Upload($uploadf, $options);
    if (null === $callback) {
        $callback = function(){};
    }
    signal($upload, $callback);
    return $upload;
}

/**
 * Installs a function for file complete signal.
 *
 * @param  object  $upload  Upload signal object.
 * @param  callable  $callable  Function to call.
 *
 * @return  object  Process
 */
function complete(SIG_Upload $upload, $callback)
{
    return signal($upload->SIG_Complete(), $callback);
}

/**
 * Installs a function for file failure signal.
 *
 * @param  object  $upload  Upload signal object.
 * @param  callable  $callable  Function to call.
 *
 * @return  object  Process
 */
function failure(SIG_Upload $upload, $callback)
{
    return signal($upload->SIG_Failure(), $callback);
}

/**
 * Installs a process to run when an upload finishes completely.
 *
 * @param  callable  $callback  Callback function to call.
 *
 * @return  object  Process
 */
function finished(SIG_Upload $upload, $callback)
{
    return signal($upload->SIG_Finished(), $callback);
}