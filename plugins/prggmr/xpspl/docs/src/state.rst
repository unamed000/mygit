.. state.php generated using docpx on 02/01/13 07:27am


Trait - XPSPL\\State
********************

Methods
-------

__construct
+++++++++++

.. function:: __construct()


    Constructs a new state object.

    :rtype: void 



get_state
+++++++++

.. function:: get_state()


    Returns the current event state.

    :rtype: integer Current state of this event.



set_state
+++++++++

.. function:: set_state()


    Set the object state.

    :param int: State of the object.

    :throws InvalidArgumentException: 

    :rtype: void 



Constants
---------

STATE_DECLARED
++++++++++++++
State

Added in v0.3.0

A State is as it implies, state of a given object, the following states 
exist. 

STATE_DECLARED
The object has been declared.

STATE_RUNNING
The object is currently running an operation.

STATE_EXITED
The object has finished execution.

STATE_CORRUPTED
An error has occurred during object runtime and depending on the recovery
it has become corrupted.

STATE_RECYCLED
The object has successfully ran through a lifecycle and has been recycled for 
additional use.

STATE_RECOVERED
The object became corrupted during runtime execution and recovery was 
succesful.

STATE_HALTED
The object has declared itself as halted to interrupt any further execution.

STATE_RUNNING
+++++++++++++
STATE_EXITED
++++++++++++
STATE_ERROR
+++++++++++
STATE_RECYCLED
++++++++++++++
STATE_RECOVERED
+++++++++++++++
STATE_HALTED
++++++++++++

Last updated on 02/01/13 07:27am