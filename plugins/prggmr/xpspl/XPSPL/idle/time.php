<?php
namespace XPSPL\idle;
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */

/**
 * Idles the processor for a specific amount of time.
 *
 * The amount of time can be specified in seconds or milliseconds.
 *
 * @todo Add microseconds.
 */
class Time extends \XPSPL\Idle {

    /**
     * Length of time to idle
     * 
     * @var  integer
     */
    protected $_idle_length = null;

    /**
     * Time instruction type.
     *
     * @var  integer
     */
    protected $_instruction = null;

    /**
     * Time to stop the idle.
     *
     * @var  integer
     */
    protected $_stop_time = null;

    /**
     * Priority of this idle function.
     *
     * @var  integer
     */
    protected $_priority = 2;

    /**
     * Allow override of this function.
     *
     * When set to true the "override" method will be called otherwise the 
     * processor will signal a Idle_Function_Overflow.
     *
     * @var  boolean
     */
    protected $_allow_override = true;
    

    /**
     * Constructs the time idle.
     */
    public function __construct($time, $instruction)
    {
        if ($instruction <= 0 || $instruction >= 5) {
            throw new \InvalidArgumentException(
                "Invalid idle time instruction"
            );
        }
        $this->_idle_length = $time;
        $this->_instruction = $instruction;
        switch ($this->_instruction) {
            case TIME_SECONDS:
                $this->_stop_time = $time + time();
                break;
            case TIME_MILLISECONDS:
                $this->_stop_time = $time + milliseconds();
                break;
            case TIME_MICROSECONDS:
                $this->_stop_time = ($time * 0.000001) + microtime(true);
                break;
            // case TIME_NANOSECONDS:
            //     $this->_stop_time = ($time)
        }
    }

    /**
     * Runs the idle function, this will call either sleep or usleep
     * depending upon the type.
     *
     * @return  void
     */
    public function idle($processor)
    {
        if (XPSPL_DEBUG) {
            logger(XPSPL_LOG)->debug(sprintf(
                'Idle using %s for %s',
                $this->_instruction, $this->get_time_left()
            ));
        }
        if ($this->get_time_left() <= 0) {
            return;
        }
        switch ($this->_instruction) {
            case TIME_SECONDS:
                sleep($this->get_time_left());
                break;
            case TIME_MILLISECONDS:
                usleep($this->get_time_left() * 1000);
                break;
            case TIME_MICROSECONDS:
                var_dump($this->get_time_left() <= 0);
                if ($this->get_time_left() <= 0) {
                    echo $this->get_time_left();
                    return;
                }
                if ($this->get_time_left() > 0 && 1 > $this->get_time_left()) {
                    echo $this->get_time_left();;
                    time_nanosleep(0, $this->get_time_left() * 1000);
                } else {
                    usleep($this->get_time_left());
                }
                break;

        }
    }

    /**
     * Returns the length of time to idle.
     *
     * @return  integer
     */
    public function get_length(/* ... */)
    {
        return $this->_idle_length;
    }

    /**
     * Returns the length of time to idle until.
     *
     * @return  integer
     */
    public function get_time_until(/* ... */)
    {
        return $this->_stop_time;
    }

    /**
     * Returns the type of time.
     *
     * @return  integer
     */
    public function get_instruction(/* ... */)
    {
        return $this->_instruction;
    }

    /**
     * Returns the amount of time left until the idle should stop.
     *
     * @return  integer|float
     */
    public function get_time_left()
    {
        switch ($this->_instruction) {
            case TIME_SECONDS:
                return $this->_stop_time - time();
                break;
            case TIME_MILLISECONDS:
                return $this->_stop_time - milliseconds();
                break;
            case TIME_MICROSECONDS:
                return ($this->_stop_time - microtime(true)) / 0.000001;
                break;
        } 
    }

    /**
     * Converts length of times from and to seconds, milliseconds and 
     * microseconds.
     *
     * @param  integer|float  $length
     * @param  integer  $to  To instruction
     *
     * @return  integer|float
     */
    public function convert_length($length, $to)
    {
        switch ($this->_instruction) {
            case TIME_SECONDS:
                switch($to) {
                    case TIME_MILLISECONDS:
                        return $length / 1000;
                        break;
                    case TIME_MICROSECONDS:
                        return $length / 1000000;
                }
                break;
            case TIME_MILLISECONDS:
                switch($to) {
                    case TIME_SECONDS:
                        return $length * .0001;
                        break;
                    case TIME_MICROSECONDS:
                        return $length * 1000;
                }
                break;
            case TIME_MICROSECONDS:
                switch($to) {
                    case TIME_SECONDS:
                        return $length * .000001;
                        break;
                    case TIME_MILLISECONDS:
                        return $length * .0001;
                        break;
                }
        }
        return $length;
    }

    /**
     * Determines if the time to idle until has passed.
     *
     * @return  boolean
     */
    public function has_time_passed(/* ... */)
    {
        switch ($this->_instruction) {
            case TIME_SECONDS:
                return $this->_stop_time <= time();
                break;
            case TIME_MILLISECONDS:
                return $this->_stop_time <= milliseconds();
                break;
            case TIME_MICROSECONDS:
                return $this->_stop_time <= microtime(true);
                break;
        }
    }

    /**
     * Determine if the given time idle function is less than the current.
     *
     * @param  object  $time  Time idle object
     *
     * @return  boolean
     */
    public function override($time)
    {
        if ($this->has_time_passed()) {
            return true;
        }
        $this_left = $this->convert_length(
            $this->get_time_left(), 
            TIME_SECONDS
        );
        $time_left = $time->convert_length(
            $time->get_time_left(),
            TIME_SECONDS
        );
        return $time_left < $this_left;
    }
}
