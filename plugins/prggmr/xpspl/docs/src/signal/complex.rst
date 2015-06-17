.. signal/complex.php generated using docpx on 02/01/13 07:27am


Class - XPSPL\\signal\\Complex
******************************

Added in v0.3.0

Complex signals are any signals that perform a calculation to determine
signals to trigger, idle time or an idle function.

Methods
-------

__construct
+++++++++++

.. function:: __construct()


    Constructs a new complex signal.
    
    This must be called from a child signal.



evaluate
++++++++

.. function:: evaluate([$signal = false])


    Compares the event signal given aganist itself.

    :param string|integer: Signal to evaluate

    :rtype: boolean|string|array False on failure. True if matches. String
                               or array indicate results to pass handlers



routine
+++++++

.. function:: routine([$history = false])


    Runs the routine calculations which allows for a complex signal to 
    analyze the event history or perform any other computable algorithm
    for determining when a signal should trigger, the processor should idle or
    the processor run the given function for a certain amount of time.
    
    The goal of running routine calculations is to allow for complex event
    processing.
    
    The return of this method is ignored.

    :param array: Event history

    :rtype: void 



get_routine
+++++++++++

.. function:: get_routine()


    Returns the routine object for this complex signal.

    :rtype: object XPSPL\Routine



event
+++++

.. function:: event([$event = false])


    Returns the event assigned to this signal.

    :rtype: object|null 



signal_this
+++++++++++

.. function:: signal_this([$event = false, [$ttl = false]])


    Method for adding this signal to signal itself within a routine.

    :param boolean|object: Create or provide an event. Default = true
    :param integer|null: TTL for the event.

    :rtype: void 




Last updated on 02/01/13 07:27am