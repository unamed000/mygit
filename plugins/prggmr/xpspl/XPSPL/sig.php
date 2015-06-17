<?php
namespace XPSPL;
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */

/**
 * SIG
 * 
 * The SIG is the representation of a signal.
 *
 * Every SIG object is represented as an index, with each index being a valid 
 * indexable value.
 *
 * By default a SIG will generate it's index based on its name to allow for a 
 * class based signal architecture.
 *
 * The SIG object allows for unique signals by declaring a subclass with the 
 * property of unique set as true.
 *
 * It is also possible to provide the SIG an index value to represent itself as.
 *
 * .. note::
 *    
 *    When a SIG is declared unique any index assigned to the SIG on construct 
 *    will be ignored.
 *
 * @since 0.3.0
 *
 * @example
 *
 * Class based SIGs.
 *
 * Using class based SIGs allows for having all possible signals represented as an 
 * object.
 *
 * All class based SIGs are non-unique by default.
 *
 * .. code-block:: php
 *    
 *    <?php
 *    // Create the SIG Foo
 *    class Foo extends \XPSPL\SIG {}
 *    // Then install a process to it
 *    signal(new Foo(), function(){
 *        echo 'Foo is emitted';
 *    });
 *    // We can also install interruptions
 *    before(new Foo(), function(){
 *        echo 'Foo is about to be emitted';
 *    });
 *    emit(new Foo());
 *    // Results when foo is emitted
 *    // Foo is about to be emitted
 *    // Foo is emitted
 *
 * .. note::
 *    
 *    When using object signals always provide a new object to the 
 *    operation you are performing.
 *    
 *    The processor is optimized to detect object new SIGs and discard any which 
 *    are not needed.
 * 
 *     
 * @example 
 *
 * Non-Unique and Provided SIG indexes.
 *
 * Providing the SIG its index is similar to using object based SIGs only the 
 * index is giving to the SIG on construction.
 *
 * All given index based SIGs are non-unique by default.
 *
 * All non-unique SIGs with the same index will point to the same address in 
 * the processor.
 *
 * As in the example below we create two separate SIG objects with the same 
 * index.
 *
 * When we install a process for each object because they represent the same 
 * index they will be installed to the same SIG.
 *
 * When we emit either object both installed processes will execute.
 *
 * .. code-block:: php
 *
 *    <?php
 *    // non-unique SIG can be created by initiating a new SIG object.
 *    $sig_1 = new \XPSPL\SIG('foo');
 *    $sig_2 = new \XPSPL\SIG('foo');
 *    signal($sig_1, function(){
 *        echo 'Sig1!';
 *    });
 *    signal($sig_2, function(){
 *        echo 'Sig2';
 *    });
 *    // emit $sig_1
 *    emit($sig_1);
 *    // results
 *    // Sig1Sig2
 *
 * @example
 *
 * A unique SIG object.
 *
 * All unique SIG objects are completely unique. 
 * 
 * Their index is generated automatically based their internal object identifier.
 *
 * Unique SIG can only be object based signals.
 *
 * Given the example below.
 *
 * .. code-block:: php
 *
 *    <?php
 *    // Create a subclass of SIG that declares itself unique
 *    class Foo extends \XPSPL\SIG {
 *        // Set the unique property to true
 *        protected $_unique = true;
 *    }
 *    
 *    // Each new Foo SIG is now unique
 *    $foo_1 = new Foo();
 *    $foo_2 = new Foo();
 *    signal($foo_1, function(){
 *        echo 'Foo 1 Emitted';
 *    });
 *    signal($foo2, function(){
 *        echo 'Foo 2 Emitted';
 *    });
 *    // We can now emit foo_1 and foo_2 separately 
 *    emit($foo_1);
 *    emit($foo_2);
 *    // results
 *    // Foo 1 Emitted
 *    // Foo 2 Emitted
 *
 * .. note::
 *     
 *     When using unique SIGs they must always be identified by their object.
 *    
 */
class SIG {

    use State;

    /**
     * Signal index.
     *
     * @var  string|integer
     */
    protected $_index = null;

    /**
     * Parent signal.
     * 
     * @var  object
     */
    protected $_parent = null;

    /**
     * Declare this SIG as unique.
     *
     * @var  boolean
     */
    protected $_unique = false;

    /**
     * Constructs a new signal.
     *
     * @param  string|integer  $index  Signal Index
     *
     * @return  void
     */
    public function __construct($index = null)
    {
        $this->set_state(STATE_DECLARED);
        if ($this->_unique) {
            $this->_index = $this->_index . spl_object_hash($this);
            return;
        }
        if (null === $index) {
            $this->_index = get_class($this);
            return;
        }
        $this->_index = $index;
    }

    /**
     * Returns the signal index.
     *
     * @return  boolean
     */
    public function get_index(/* ... */) 
    {
        return $this->_index;
    }

    /**
     * Halts the signal execution.
     * 
     * @return  void
     */
    public function halt(/* ... */)
    {
        $this->_state = STATE_HALTED;
    }

    /**
     * Determines if the signal is a child of another signal.
     * 
     * @return  boolean
     */
    public function is_child(/* ... */)
    {
        return null !== $this->_parent;
    }

    /**
     * Sets the parent signal.
     * 
     * @param  object  $signal  \XPSPL\Signal
     * 
     * @return  void
     */
    public function set_parent(SIG $signal)
    {
        // Detect if parent is itself to avoid circular referencing
        if ($this === $signal) $signal = SIGNAL_SELF_PARENT;
        $this->_parent = $signal;
    }

    /**
     * Retrieves this signal's parent.
     * 
     * @return  null|object 
     */
    public function get_parent(/* ... */)
    {
        return ($this->_parent === SIGNAL_SELF_PARENT) ? $this : $this->_parent;
    }

    // --------------------------------------------------------------------- \\
    // INTERNAL FUNCTIONS
    // --------------------------------------------------------------------- \\

    /**
     * Get a variable in the signal.
     *
     * @param  mixed  $key  Variable name.
     *
     * @return  mixed|null
     */
    public function __get($key)
    {
        throw new \LogicException(sprintf(
            "Call to undefined signal property %s",
            $key
        ));
    }

    /**
     * Checks for a variable in the signal.
     *
     * @param  mixed  $key  Variable name.
     *
     * @return  boolean
     */
    public function __isset($key)
    {
        return isset($this->$key);
    }

    /**
     * Set a variable in the signal.
     *
     * @param  string  $key  Name of variable
     *
     * @param  mixed  $value  Value to variable
     *
     * @return  boolean  True
     */
    public function __set($key, $value)
    {
        $this->$key = $value;
        return true;
    }

    /**
     * Deletes a variable in the signal.
     *
     * @param  mixed  $key  Variable name.
     *
     * @return  boolean
     */
    public function __unset($key)
    {
        if (!isset($this->$key)) return false;
        if (stripos($key, '_') === 0) {
            throw new \LogicException(sprintf(
                "%s is a read-only signal property", 
                $key
            ));
        }
        unset($this->$key);
    }

    /**
     * String representation.
     *
     * @return  string
     */
    public function __toString(/* ... */)
    {
        return sprintf('INDEX(%s) - CLASS(%s) - HASH(%s)',
            $this->_index,
            get_class($this),
            spl_object_hash($this)
        );
    }
}