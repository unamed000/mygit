<?php
namespace XPSPL;
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */

import('logger');
import('time');

use \XPSPL\processor\exception as exceptions,
    \XPSPL\database\Signals,
    \XPSPL\database\Processes;

/**
 * Processor
 *
 * The brainpower of XPSPL.
 * 
 * @since v0.3.0 
 * 
 * The loop is now run in respect to the currently available processes,
 * this prevents the processor from running continuously forever when there is not
 * anything that it needs to do.
 *
 * To achieve this the processor uses routines.
 *
 * @since v3.0.0
 *
 * Signal storages have been upgraded to a database object, the routine and 
 * evaluation methods for the complex signal have also been moved into their 
 * own classes.
 *
 * The loop has been replaced with a goto statement, measurements indicate that 
 * it performs faster than a loop ... though should it? 
 */
class Processor {

    /**
     * Stateful and storage object
     */
    use State;

    /**
     * SIG storage database.
     *
     * @var  array
     */
    private $_sig_index = null;
    /**
     * SIG_Complex storage database.
     *
     * @var  array
     */
    private $_sig_complex = null;
    /**
     * SIG_Routine storage database.
     * 
     * @var  array
     */
    private $_sig_routine = null;
    /**
     * Interruption before execution storage.
     *
     * @var  array
     */
    private $_int_before = null;
    /**
     * Interruption before execution storage.
     *
     * @var  array
     */
    private $_int_after = null;
    /**
     * Interruption before emittion
     *
     * @var  integer
     */
    const INTERRUPT_PRE = 0;
    /**
     * Interruption after emittion
     *
     * @var  integer
     */
    const INTERRUPT_POST = 1;
    /**
     * Signal history.
     * 
     * @var  boolean|array
     */
    protected $_history = false;

    /**
     * Currently executing signal and hierachy
     */
    private $_signal = [];

    /**
     * The routine
     */
    private $_routine = null;

    /**
     * Starts the processor.
     *
     * @return  void
     */
    public function __construct()
    {
        if (XPSPL_DEBUG) {
            logger(XPSPL_LOG)->debug(sprintf(
                'Starting XPSPL Judy Support %s',
                (XPSPL_JUDY_SUPPORT) ? 'true' : 'false'
            ));
        }
        $this->set_state(STATE_DECLARED);
        $this->flush(); 
    }

    /**
     * Cleans out the signal history.
     *
     * @return  void
     */
    public function erase_history()
    {
        if (false === $this->_history) {
            return;
        }
        $this->_history = [];
    }

    /**
     * Analyzes the processor runtime and shutdowns when no activity is 
     * detected.
     *
     * @param  object  $sig_awake  SIG_Awake
     *
     * @return  void
     */
    public function anaylze_runtime(SIG_Awake $sig_awake)
    {
        if (!isset($sig_awake->analysis)) {
            $sig_awake->analysis = microseconds();
            $sig_awake->count = 0;
        } else {
            if (XPSPL_DEBUG) {
                logger(XPSPL_LOG)->debug('Analyzing runtime');
            }
            if (0 === ($sig_awake - microseconds()) >> 10) {
                if ($sig_awake->count > 5) {
                    $this->shutdown();
                }
                $sig_awake->count = $sig_awake->count + 1;
            } else {
                $sig_awake->count = 0;
            }
            $sig_awake->analysis = microseconds();
        }
    }

    /**
     * Waits for the next signal to occur.
     *
     * @todo unittest
     * 
     * @return  void
     */
    public function wait_loop()
    {
        /**
         * The original method found in the loop has been replaced
         * with an intelligent time based analysis.
         */
        $this->emit(new processor\SIG_Startup());
        routine:
        if (XPSPL_DEBUG) {
            logger(XPSPL_LOG)->debug(sprintf(
                'Entering Wait Loop'
            ));
        }
        if ($this->_routine()) {
            if (count($this->_routine->get_signals()) !== 0) {
                foreach ($this->_routine->get_signals() as $_signal) {
                    $this->emit($_signal);
                }
            }
            // check for idle function
            if (null !== $this->_routine->get_idle()) {
                foreach ($this->_routine->get_idles_available() as $_idle) {
                    if (false === $this->has_signal_exhausted($_idle)) {
                        $_idle->idle($this);
                        $this->_routine->reset();
                        goto routine;
                    }
                }
            }
        }
        $this->emit(new processor\SIG_Shutdown());
    }

    /**
     * Runs the signal routine for the processor loop.
     *
     * @todo unittest
     * 
     * @return  boolean|array
     */
    private function _routine()
    {
        // allow for external shutdown signal before running anything
        if ($this->get_state() === STATE_HALTED) {
            if (XPSPL_DEBUG) {
                logger(XPSPL_LOG)->debug(sprintf(
                    'Halting processor due to halt state'
                ));
            }
            return false;
        }
        // run the routines
        foreach ($this->_sig_routine as $_routine) {
            $_routine[0]->routine($this->_routine);
        }
        return $this->_routine->is_stale();
        // Check signals
        if (count($this->_routine->get_signals()) != 0) {
            // This checks only for one possible signal that has not exhausted
            // it still leaves the possibility for triggering exhausted signals
            foreach ($this->_routine->get_signals() as $_signal) {
                if (false === $this->has_signal_exhausted($_signal)) {
                    if (XPSPL_DEBUG) {
                        logger(XPSPL_LOG)->debug(sprintf(
                            '%s emittable signal detected',
                            $_signal
                        ));
                    }
                    return true;
                }
            }
        }
        // Check idle
        if (null !== $this->_routine->get_idle()) {
            if (XPSPL_DEBUG) {
                logger(XPSPL_LOG)->debug(sprintf(
                    '%s idle function detected', 
                    $this->_routine->get_idle()
                ));
            }
            return true;
        }
        if (XPSPL_DEBUG) {
            logger(XPSPL_LOG)->debug(sprintf(
                'No activity found halting'
            ));
        }
        return false;
    }

    /**
     * Returns the current routine object.
     *
     * @todo unittest
     *
     * @return  null|object
     */
    public function get_routine(/* ... */)
    {
        return $this->_routine;
    }

    /**
     * Determines if the given signal has exhausted.
     * 
     * @param  object  $signal  \XPSPL\SIG
     * 
     * @return  boolean
     */
    public function has_signal_exhausted(SIG $signal)
    {
        $db = $this->find_signal_database($signal);
        if (null === $db || $db->count() === 0) {
            return true;
        }
        return true === $this->are_processes_exhausted($db);
    }

    /**
     * Determine if the given database processes are exhausted.
     *
     * @param  object  $queue  \XPSPL\database\Processes
     * 
     * @return  boolean
     */
    public function are_processes_exhausted(\XPSPL\database\Processes $database)
    {
        if ($database->count() === 0) {
            return true;
        }
        $database->reset();
        while($database->valid()) {
            if ($database->current() instanceof \XPSPL\database\Processes) {
                if (!$this->are_processes_exhausted($database->current())) {
                    return false;
                }
            } elseif (!$database->current()->is_exhausted()) {
                return false;
            }
            $database->next();
        }
        return true;
    }

    /**
     * Removes a signal process.
     *
     * @param  mixed  $signal  Signal instance or signal.
     * @param  mixed  $process  Process instance or identifier.
     * 
     * @return  boolean
     */
    public function delete_process(SIG $signal, Process $process)
    {
        $database = $this->find_signal_database($signal);
        if (null === $database) {
            return false;
        }
        return $database->delete($process);
    }

    /**
     * Flush
     *
     * Resets the signal databases, the routine object and cleans the history 
     * if tracked.
     *
     * @return void
     */
    public function flush(/* ... */)
    {
        // Databases to flush
        $database = [
            '_sig_index', 
            '_sig_complex',
            '_sig_routine',
            '_int_before', 
            '_int_after'
        ];
        foreach ($database as $_db) {
            if (is_object($this->{$_db})) {
                if (XPSPL_JUDY_SUPPORT) {
                    logger(XPSPL_LOG)->debug(sprintf(
                        'Memory Before Flush: %s',
                        $this->{$_db}->get_storage()->memoryUsage()
                    ));
                }
                $this->{$_db}->free();
                if (XPSPL_DEBUG) {
                    if (XPSPL_JUDY_SUPPORT) {
                        logger(XPSPL_LOG)->debug(sprintf(
                            'Memory After Flush : %s',
                            $this->{$_db}->get_storage()->memoryUsage()
                        ));
                    }
                }
            } else {
                $this->{$_db} = new Signals();
            }
        }
        if (false !== $this->_history){
            $this->_history = [];
        }
        if (null === $this->_routine) {
            $this->_routine = new Routine();
        }
    }

    /**
     * Listen
     * 
     * Registers an object listener.
     *
     * @param  object  $listener  XPSPL\Listener
     *
     * @return  void
     */
    public function listen(Listener $listener)
    {
        foreach ($listener->_get_signals() as $_signal) {
            $this->signal($_signal, new Process([$listener, $_signal->get_index()]));
        }
        $listener->_reset();
    }

    /**
     * Creates a new signal process.
     *
     * @param  string|int|object  $signal  Signal to attach the process.
     * @param  object  $callable  Signal process
     *
     * @return  object|boolean  Process, boolean if error
     */
    public function signal(SIG $signal, Process $process)
    {
        if (!$signal instanceof SIG) {
            $signal = new SIG($signal);
        }
        if (!$process instanceof Process) {
            $process = new Process($process);
        }
        $db = $this->find_signal_database($signal);
        if (null === $db) {
            if (XPSPL_DEBUG) {
                logger(XPSPL_LOG)->debug(sprintf(
                    'Registering signal %s',
                    $signal
                ));
            }
            $db = $this->register_signal($signal);
        }
        $db->install($process, $process->get_priority());
        return $process;
    }

    /**
     * Registers a signal into the processor.
     *
     * @param  string|integer|object  $signal  Signal
     *
     * @return  boolean|object  false|XPSPL\database\Processes
     */
    public function register_signal(SIG $signal)
    {
        if (!$signal instanceof SIG) {
            $signal = new SIG($signal);
        }
        $db = new \XPSPL\database\Processes();
        $sig_db = $this->get_database($signal);
        $sig_db->register_signal($signal, $db);
        return $db;
    }

    /**
     * Returns the signal database for the given signal.
     *
     * @param  object  $signal
     * 
     * @return  array
     */
    public function get_database(SIG $signal)
    {
        if ($signal instanceof SIG_Complex) {
            return $this->_sig_complex;
        }
        if ($signal instanceof SIG_Routine) {
            return $this->_sig_routine;
        }
        if ($signal instanceof SIG) {
            return $this->_sig_index;
        }
    }

    /**
     * Finds an installed signals processes database.
     *
     * @param  object  $signal  SIG
     * 
     * @return  null|object  \XPSPL\database\Signals
     */
    public function find_signal_database(SIG $signal)
    {
        $db = $this->get_database($signal);
        $memory = $db->find_processes_database($signal);
        if (null !== $memory) {
            return $memory;
        }
        return null;
    }

    /**
     * Perform the evaluation for all registered complex signals.
     *
     * @param  string|object|int  $signal  Signal to evaluate
     *
     * @return  array|null  [[[signal, queue], eval_return]]
     */
    public function evaluate_signals(SIG $signal)
    {
        if ($this->_sig_complex->count() == 0) {
            return null;
        }
        $signals = [];
        foreach ($this->_sig_complex as $_node) {
            $eval = $_node[0]->evaluate($signal);
            if (false !== $eval) {
                $signals[] = $_node[1];
            }
        }
        if (count($signals) !== 0) {
            return $signals;
        }
        return null;
    }

    /**
     * Emits a signal.
     *
     * @param  object  $signal  \XPSPL\SIG
     *
     * @return  object  Event
     */
    public function emit(SIG $signal)
    {
        if (XPSPL_DEBUG) {
            logger(XPSPL_LOG)->debug(sprintf(
                '%s emitted',
                $signal
            ));
        }
        if ($this->has_signal_exhausted($signal)) {
            if (XPSPL_DEBUG) {
                logger(XPSPL_LOG)->debug(
                    'Non emittable signal emitted'
                );
            }
            return $signal;
        }
        // Store the history of the signal
        if (false !== $this->_history) {
            $this->_history[] = [$signal, microtime()];
        }
        // Set child status
        if (count($this->_signal) > 1)  {
            $signal->set_parent($this->current_signal());
        }
        // Check if signal is installed
        $memory = $this->find_signal_database($signal);
        if (null === $memory) {
            return $signal;
        }
        // Set as currently emitted signal
        $this->_signal[] = $signal;
        // evaluate
        $evaluated = $this->evaluate_signals($signal);
        if (null !== $evaluated) {
            foreach ($evaluated as $_db) {
                $memory->merge($_db);
            }
        }
        $this->_execute($signal, $memory);
        // Remove the last signal
        array_pop($this->_signal);
        return $signal;
    }

    /**
     * Executes a database of processes.
     * 
     * This will monitor the signal status and break on a HALT or ERROR state.
     *
     * @param  object  $signal  \XPSPL\SIG
     * @param  object  $db  \XPSPL\database\Processes
     * @param  boolean  $interupt  Run the interrupt functions.
     *
     * @return  void
     */
    private function _execute(SIG $signal, Processes $db, $interrupt = true)
    {
        // process pre interupt functions
        if ($interrupt) {
            $this->_interrupt($signal, self::INTERRUPT_PRE);
        }
        // execute the processes database
        $this->_processes_execute($signal, $db);
        // process interupt functions
        if ($interrupt) {
            $this->_interrupt($signal, self::INTERRUPT_POST);
        }
    }

    /**
     * Executes a processes database.
     *
     * If XPSPL_EXHAUSTION_PURGE is true processes will be purged once they 
     * reach exhaustion.
     *
     * @param  object  $sig \XPSPL\SIG
     * @param  object  $db  \XPSPL\database\Processes
     *
     * @return  void
     */
    private function _processes_execute(SIG $signal, Processes $db)
    {
        if (XPSPL_DEBUG) {
            logger(XPSPL_LOG)->debug(sprintf(
                '%s Process DB Executing %s processes',
                $db,
                $db->count()
            ));
        }
        $db->reset();
        foreach ($db as $_process) {
            # Always check state first
            if ($signal->get_state() === STATE_HALTED) {
                break;
            }
            # n+1 constant
            if ($_process instanceof Processes) {
                if (XPSPL_DEBUG) {
                    logger(XPSPL_LOG)->debug(
                        'Descending into a sub-database executing '.$_process->count().' processes'
                    );
                }
                $this->_processes_execute($signal, $_process);
            } else {
                if (XPSPL_DEBUG) {
                    logger(XPSPL_LOG)->debug(sprintf(
                        'Executing Process %s',
                        get_class($_process) . ' : ' . $_process
                    ));
                }
                $_process->decrement_exhaust();
                if (false === $this->_process_exec(
                    $signal,
                    $_process->get_function()
                )) {
                    if (XPSPL_DEBUG) {
                        logger(XPSPL_LOG)->debug(sprintf(
                            'Halting Signal %s due to false return from %s',
                            $signal,
                            get_class($_process) . ' : ' . $_process
                        ));
                    }
                    $signal->halt();
                }
                if ($_process->is_exhausted()) {
                    if (XPSPL_DEBUG) {
                        logger(XPSPL_LOG)->debug(sprintf(
                            'Process %s Exhausted',
                            get_class($_process) . ' : ' . $_process
                        ));
                    }
                    $db->delete($_process);
                }
            }
        }
    }

    /**
     * Executes a callable processor function.
     *
     * This currently uses a hand built method in PHP ... really this 
     * should be done in C within the core ... but call_user_* is slow ...
     *
     * @param  object  $signal  \XPSPL\SIG
     * @param  mixed  $function  Callable variable
     * 
     * @return  boolean
     */
    private function _process_exec(SIG $signal, $function = null)
    {
        if (null === $function) {
            return;
        }
        if (is_array($function)) {
            if (count($function) >= 2) {
                if (is_object($function[0])) {
                    return $function[0]->$function[1]($signal);
                } else {
                    return (new $function[0])->$function[1]($signal);
                }
            }
            return $function[0]($signal);
        }
        return $function($signal);
    }
    
    /**
     * Returns the signal history.
     *
     * @todo Make this a database.
     * 
     * @return  array
     */
    public function signal_history(/* ... */)
    {
        return $this->_history;
    }

    /**
     * Sends the processor the shutdown signal.
     *
     * @return  void
     */
    public function shutdown()
    {
        $this->set_state(STATE_HALTED);
    }

    /**
     * Registers a function to interrupt the signal stack before a signal emits.
     * 
     * This allows for manipulation of the signal before it is passed to any 
     * processes.
     *
     * @param  string|object  $signal  Signal instance or class name
     * @param  object  $process  Process to execute
     * 
     * @return  boolean  True|False false is failure
     */
    public function before(SIG $signal, Process $process)
    {
        return $this->_signal_interrupt($signal, $process, Processor::INTERRUPT_PRE);
    }

    /**
     * Registers a function to interrupt the signal stack after a signal emits.
     * 
     * @param  string|object  $signal  Signal instance or class name
     * @param  object  $process  Process to execute
     * 
     * @return  boolean  True|False false is failure
     */
    public function after(SIG $signal, Process $process)
    {
        return $this->_signal_interrupt($signal, $process, Processor::INTERRUPT_POST);
    }

    /**
     * Registers a function to interrupt the signal stack before or after a 
     * signal emits.
     *
     * @param  string|object  $signal
     * @param  object  $process  Process to execute
     * @param  int|null  $place  Interuption location. INTERUPT_PRE|INTERUPT_POST
     * 
     * @return  boolean  True|False false is failure
     */
    protected function _signal_interrupt(SIG $signal, Process $process, $interrupt = null) 
    {
        if (XPSPL_DEBUG) {
            logger(XPSPL_LOG)->debug(sprintf(
                '%s %d interrupt installed',
                $signal, $interrupt
            ));
        }
        if (!$signal instanceof SIG) {
            $sig = new SIG($signal);
        }
        if (!$process instanceof Process) {
            $process = new Process($process);
        }
        $memory = $this->find_signal_database($signal);
        if (null === $signal) {
            throw new exceptions\Unregistered_Signal(sprintf(
                'Signal %s must be registered before installing interruptions',
                (is_object($signal)) ? get_class($signal) : $signal
            ));
        }
        $database = $this->_get_int_database($interrupt);
        $db = $database->find_processes_database($signal);
        if (null === $db) {
            $db = new \XPSPL\database\Processes();
            $database->register_signal($signal, $db);
        }
        $db->install($process);
        return true;
    }

    /**
     * Returns the interruption storage database.
     * 
     * @param  integer  $type  The interruption type
     * 
     * @return  object  \XPSPL\Database
     *
     * @since  v4.0.0
     */
    private function _get_int_database($interrupt)
    {
        if (Processor::INTERRUPT_PRE === $interrupt) {
            return $this->_int_before;
        }
        if (Processor::INTERRUPT_POST === $interrupt) {
            return $this->_int_after;
        }
        throw new LogicException("Unknown interruption $interrupt");
    }

    /**
     * Process signal interuption functions.
     * 
     * @param  object  $signal  Signal
     * @param  int  $interupt  Interupt type
     * 
     * @return  boolean
     */
    private function _interrupt(SIG $signal, $interrupt = null)
    {
        $db = $this->_get_int_database($interrupt)->find_processes_database(
            $signal
        );
        if (null === $db) {
            return;
        }
        if (XPSPL_DEBUG) {
            logger(XPSPL_LOG)->debug(sprintf(
                '%s %s interruption processes executing',
                $signal, ($interrupt == 0) ? 'before' : 'after'
            ));
        }
        $this->_execute($signal, $db, false);
    }

    /**
     * Cleans any exhausted signals from the processor.
     * 
     * @param  boolean  $history  Erase any history of the signals cleaned.
     * 
     * @return  void
     *
     * @todo
     *
     * Clean this ugly code ... 
     */
    public function clean($history = false)
    {
        throw new \Exception('Not Implemented');
        $storages = [
            self::SIG_STORAGE, self::COMPLEX_STORAGE, self::INTERRUPT_STORAGE
        ];
        foreach ($storages as $_storage) {
            if (count($this->_storage[$_storage]) == 0) continue;
            foreach ($this->_storage[$_storage] as $_index => $_node) {
                if ($_node[1] instanceof Process && $_node[1]->is_exhausted() ||
                    $_node[1] instanceof Queue && $this->queue_exhausted($_node[1])) {
                    unset($this->_storage[$_storage][$_index]);
                    if ($history) {
                        $this->erase_signal_history(
                            ($_node[0] instanceof signal\Complex) ?
                                $_node[0] : $_node[0]->get_index()
                        );
                    }
                }
            }
        }
    }

    /**
     * Delete a signal from the processor.
     * 
     * @param  string|object|int  $signal  Signal to delete.
     * @param  boolean  $history  Erase any history of the signal.
     * 
     * @return  void
     */
    public function delete_signal(SIG $signal, $history = false)
    {
        $db = $this->get_database($signal);
        $db->delete_signal($signal);
        if ($history) {
            $this->erase_signal_history($signal);
        }
        return;
    }

    /**
     * Erases any history of a signal.
     * 
     * @param  string|object  $signal  Signal to be erased from history.
     * 
     * @return  void
     */
    public function erase_signal_history($signal)
    {
        if (!$this->_history) {
            return false;
        }
        // recursivly check if any signals are a child of the given signal
        // because if the chicken doesn't exist neither does the egg ...
        // or does it?
        $descend_destory = function($_event, $_signal) use ($signal, &$descend_destory) {
            // child and not a child of itself
            if ($_event->is_child() && $_event->get_parent() !== $_event) {
                return $descend_destory($_event->get_parent(), $_signal);
            }
            if ($_signal === $signal) {
                return true;
            }
        };
        foreach ($this->_history as $_key => $_node) {
            if ($_node[1] === $signal) {
                unset($this->_history[$_key]);
            } elseif ($_node[0]->is_child() && $_node[0]->get_parent() !== $_node[0]) {
                if ($descend_destory($_node[0]->get_parent(), $_node[1])) {
                    unset($this->_history[$_key]);
                }
            }
        }
    }

    /**
     * Sets the flag for storing the signal history.
     *
     * Note that this will delete the current if reset.
     *
     * @param  boolean  $flag
     *
     * @return  void
     */
    public function set_signal_history($flag)
    {
        if ($flag === true) {
            if (!$this->_history) {
                $this->_history = [];
            }
            return;
        }
        $this->_history = false;
    }

    /**
     * Returns the current signal in execution.
     *
     * @param  integer  $offset  In memory hierarchy offset +/-.
     *
     * @return  object
     */
    public function current_signal($offset = 1)
    {
        $count = count($this->_signal);
        if ($count === 0) {
            return null;
        }
        if ($count === 1) {
            return $this->_signal[0];
        }
        return array_slice($this->_signal, $offset, 1)[0];
    }
}