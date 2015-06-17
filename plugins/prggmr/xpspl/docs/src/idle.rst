.. idle.php generated using docpx on 02/01/13 07:27am


Class - XPSPL\\Idle
*******************

Idle

The idle class is used for idling the processor, the base provides no 
functionality in itself and must be extended.

What it does provide is a base for writing an idle object, with this it
gives the default functions of setting the maximum of itself allowed per 
loop, the priority of the idling function and allow override of the same
idle.

The base provides the rules that only one type of the given idle function
should exist and a default priority of zero for all.

Methods
-------

idle
++++

.. function:: idle($processor)


    Idle's the processor.
    
    This function is purely responsible for providing the processor the ability
    to idle, typically this will be done through either a call to sleep or a
    wait with a specific timeout.
    
    This method is provided an instance of the processor which is wishing to 
    idle and should respect the processors current specifications for the amount
    of time that it needs to idle, if set.
    
    You have been warned that,
    
    Creating a function that does not properly idle, does not respect the
    processor specs or is poorly designed will result in terrible performance, 
    unexpected results and damage to your system ... use caution.

    :param object: The processor that wishes to idle.

    :rtype: void 



get_priority
++++++++++++

.. function:: get_priority()


    Returns the priority of this idle function.

    :rtype: integer 



allow_override
++++++++++++++

.. function:: allow_override()


    Return if this function allows itself to be overwritten in the limit
    is met or exceeded.

    :rtype: boolean 



override
++++++++

.. function:: override($idle)


    Returns if the given function can override this in the processor.

    :param object: Idle function object

    :rtype: boolean 




Last updated on 02/01/13 07:27am