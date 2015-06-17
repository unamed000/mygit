<?php
namespace time;
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */

use XPSPL\idle\Time;

 /**
 * Awake Routine
 *
 * Sends an awake signal after a specified amount of time has passed.
 */
class SIG_Awake extends \XPSPL\SIG_Routine {

    /**
     * Time to awake in.
     *
     * @param  integer
     */
    protected $_time = null;

    /**
     * Time instruction.
     *
     * @param  integer
     */
    protected $_instruction = null;

    /**
     * Constructs a awake signal.
     *
     * @param  int  $time  Amount of time before emitting the signal.
     *
     * @throws  InvalidArgumentException
     *
     * @return  void
     */
    public function __construct($time, $instruction = TIME_SECONDS)
    {
        if ((!is_int($time) || !is_float($time)) && $time < 0) {
            throw new \InvalidArgumentException(
                "Time must be greater than 0"
            );
        }
        parent::__construct();
        $this->_time = $time;
        $this->_instruction = $instruction;
        $this->_idle = new Time($time, $instruction);
    }
    
    /**
     * Runs the routine.
     *
     * This checks if the appriorate amount of time has passed and emits the 
     * awake signal if so.
     * 
     * @return  boolean
     */
    public function routine(\XPSPL\Routine $routine = null)
    {
        if ($this->_idle->has_time_passed()) {
            $routine->add_signal($this);
            $this->_idle = new Time(
                $this->_time, $this->_instruction
            );
        }
        $routine->add_idle($this);
        return true;
    }

    /**
     * Returns the time for the signal.
     *
     * @return  integer
     */
    public function get_time(/* ... */)
    {
        return $this->_time;
    }

    /**
     * String representation.
     *
     * @return  string
     */
    public function __toString(/* ... */)
    {
        return sprintf('INDEX(%s) - CLASS(%s) - HASH(%s) - TIME(%s) - INSTRUCT(%s)',
            $this->_index,
            get_class($this),
            spl_object_hash($this),
            $this->_time,
            $this->_instruction
        );
    }
}