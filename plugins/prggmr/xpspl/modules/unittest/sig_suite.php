<?php
namespace unittest;
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */

use \XPSPL\SIG_Routine;

/**
 * SIG_Suite
 * 
 * The suite is designed to run a group of tests together.
 *
 * It is registered as a routine in the processor.
 *
 * All registered tests are registered into a SIG_Test signal constructed when 
 * the suite is registered in the processor.
 */
class SIG_Suite extends SIG_Routine {

    /**
     * Teardown function
     * 
     * @var  object  Closure
     */
    protected $_teardown = null;

    /**
     * Constructs a new suite.
     */
    public function __construct($function)
    {
        if ($function instanceof Closure) {
            throw new InvalidArgumentException;
        }
        parent::__construct();
        $this->_test = new SIG_Test();
        $function($this);
    }

    /**
     * Registers a setup function.
     * 
     * @param  object  $function  Closure
     * 
     * @return  void
     */
    public function setup($function)
    {
        before($this->_test, null_exhaust($function));
    }

    /**
     * Registers a teardown function.
     * 
     * @param  object  $function  Closure
     * 
     * @return  void
     */
    public function teardown($function)
    {
        after($this->_test, null_exhaust($function));
    }

    /**
     * Creates a new test case in the suite.
     * 
     * @param  object  $function  Test function
     * @param  string  $name  Test name
     *
     * @return  object  SIG_Test
     */
    function test($function) 
    {
        signal($this->_test, $function);
    }

    /**
     * Routine function.
     */
    public function routine(\XPSPL\Routine $routine)
    {
        if (null === $this->_test) {
            return false;
        }
        $routine->add_signal($this);
        $routine->add_signal($this->_test);
        $this->_test = null;
        return true;
    }
}