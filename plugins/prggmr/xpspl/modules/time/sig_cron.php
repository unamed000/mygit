<?php
namespace time;
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */
 
use \XPSPL\idle\Time;

if (!class_exists('\Cron\CronExpression', false)) {
    $file = dirname(realpath(__FILE__)).'/cron/cron.phar';
    if (file_exists($file)) {
        require_once $file;
        define('HAS_CRONEXPRESSION', true);
    } else {
        define('HAS_CRONEXPRESSION', false);
    }
} else {
    define('HAS_CRONEXPRESSION', true);
}

 /**
 * Cron signal
 *
 * Signal based on the UNIX cron definition.
 *
 * Module has been made possible due to Michael Dowling's CronExpression.
 */
class SIG_CRON extends \XPSPL\SIG_Routine {

    /**
     * Cron-Expression object
     * 
     * @var  integer
     */
    protected $_cron = null;

    /**
     * Next runtime of the cron.
     *
     * @var  integer
     */
    protected $_next_run = null;

    /**
     * Constructs a new cron signal.
     *
     * @param  string  $expression  Cron expression
     *
     * @throws  InvalidArgumentException
     *
     * @return  void
     */
    public function __construct($expression)
    {
        if (!HAS_CRONEXPRESSION) {
            throw new \RuntimeException(
                "Cron-Expression library is required for cron signals - https://github.com/mtdowling/cron-expression"
            );
        }
        $this->_cron = \Cron\CronExpression::factory($expression);
        $this->_next_run = $this->_cron->getNextRunDate()->getTimestamp();
        parent::__construct();
    }
    
    /**
     * Determines when the time signal should fire, otherwise returning
     * the processor to idle until it will.
     * 
     * @return  integer
     */
    public function routine(\XPSPL\Routine $routine = null)
    {
        $diff = $this->_next_run - time();
        if ($diff <= 0) {
            $this->_next_run = $this->_cron->getNextRunDate()->getTimestamp();
            $routine->add_signal($this);
        } else {
            $this->_idle = new Time(
                $this->_time, $this->_instruction
            );
        }
        return true;
    }
}