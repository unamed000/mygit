<?php
namespace ftp;
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */

use \XPSPL\idle\Process;

/**
 * Performs an FTP upload of the given file(s) to the given host.
 *
 * Once transfered it will trigger the SIG_FTP_Transfer_Complete signal with 
 * the completed filename.
 */
class SIG_Upload extends \XPSPL\signal\Complex {

    /**
     * Files to be uploaded.
     *
     * @var  array
     */
    protected $_files = [];

    /**
     * Connection options
     *
     * @var  array
     */
    protected $_options = [];

    /**
     * Files that are uploading
     *
     * @var  array
     */
    protected $_uploading = [];

    /**
     * Files that have uploaded.
     *
     * @var  array
     */
    protected $_uploaded = [];

    /**
     * File complete signal.
     *
     * @var  object
     */
    protected $_sig_complete = null;

    /**
     * File failure signal.
     *
     * @var  object
     */
    protected $_sig_failure = null;

     /**
     * Upload finished signal.
     *
     * @var  object
     */
    protected $_sig_finished = null;

    /**
     * Construct the routine that must be run.
     *
     * @param  array  $files  Files to upload
     * @param  array  $options  FTP Connection options.
     * 
     * @return  void
     */
    public function __construct($files, $options = [])
    {   
        parent::__construct();
        $this->signal_this();
        $this->_sig_complete = new SIG_Complete();
        $this->_sig_failure = new SIG_Failure();
        $this->_sig_finished = new SIG_Finished();
        $defaults = [
            'hostname' => null,
            'port' => 21,
            'timeout' => 90,
            'username' => null,
            'password' => null
        ];
        $this->_files = $files;
        $options += $defaults;
        $this->_options = $options;

        /**
         * Upload Idle process
         */
        $this->_routine->set_idle(new Process(function(){
            $this->_init_transfers();
            foreach ($this->_uploading as $_key => $_file) {
                $status = ftp_nb_continue($_file[0]);
                if ($status === FTP_MOREDATA) {
                    continue;
                }
                if ($status === FTP_FINISHED) {
                    emit(
                        $this->_sig_complete,
                        new EV_Complete($_file[1])
                    );
                    // Close the FTP connection to that file
                    ftp_close($_file[0]);
                    $this->_uploaded[] = $_file[1];
                } else {
                    emit(
                        $this->_sig_failure,
                        new EV_Failure($_file[1])
                    );
                    // Close the FTP connection to that file
                    ftp_close($_file[0]);
                }
                unset($this->_uploading[$_key]);
            }
            // Cleanup once finished
            if (count($this->_uploading) == 0) {
                emit(
                    $this->_sig_finished, 
                    new EV_Finished($this)
                );
                delete_signal($this);
                delete_signal($this->_sig_complete);
                delete_signal($this->_sig_failure);
            }

        }));
    }

    public function routine($history = null)
    {
        if (count($this->_files) > 0 || count($this->_uploading) > 0) {
            return true;
        }
        return false;
    }

    /**
     * Processes any files awaiting to upload and attempts to begin the upload 
     * transfer.
     *
     * @todo  Add an emit for failure to connect, incorrect file.
     * 
     * @return  void
     */
    protected function _init_transfers()
    {
        foreach ($this->_files as $_k => $_file) {
            if (!$_file instanceof File) {
                continue;
            }
            $connection = ftp_connect(
                $this->_options['hostname'], 
                $this->_options['port'], 
                $this->_options['timeout']
            );
            if (false === $connection) {
                break;
            }
            $login = ftp_login(
                $connection, 
                $this->_options['username'], 
                $this->_options['password']
            );
            if ($login === false) {
                ftp_close($connection);
                break;
            }
            if (!file_exists($_file->get_full_path())) {
                emit(
                    $this->_sig_failure,
                    new EV_Failure($_file)
                );
            } else {
                $transfer = ftp_nb_put(
                    $connection,
                    $_file->get_name(),
                    $_file->get_full_path(),
                    $_file->get_transfer_mode()
                );
                if ($transfer === FTP_MOREDATA) {
                    $this->_uploading[] = [
                        $connection,
                        $_file
                    ];
                } else {
                    if ($transfer == FTP_FINISHED) {
                        emit(
                            $this->_sig_complete,
                            new EV_Complete($_file)
                        );
                        // Close the FTP connection to that file
                        ftp_close($connection);
                        $this->_uploaded[] = $_file;
                    } else {
                        emit(
                            $this->_sig_failure,
                            new EV_Failure($_file)
                        );
                        // Close the FTP connection to that file
                        ftp_close($connection);
                    }
                }
            }
            unset($this->_files[$_k]);
        }
    }

    /**
     * Returns the SIG_Complete signal for this upload.
     *
     * @return  object
     */
    public function SIG_Complete(/* ... */)
    {
        return $this->_sig_complete;
    }

    /**
     * Returns the SIG_Failure signal for this upload.
     *
     * @return  object
     */
    public function SIG_Failure(/* ... */)
    {
        return $this->_sig_failure;
    }

    /**
     * Returns the SIG_Finished signal for this upload.
     *
     * @return  object
     */
    public function SIG_Finished(/* ... */)
    {
        return $this->_sig_finished;
    }

    /**
     * Returns the files that were uploaded.
     *
     * @return  array
     */
    public function get_uploaded_files(/* ... */)
    {
        return $this->_uploaded;
    }
}