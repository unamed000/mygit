.. handle.php generated using docpx on 02/01/13 07:27am


Class - XPSPL\\Handle
*********************

A handle is the function which will execute upon a signal call.

Though attached to a signal the object itself contains no
information on what a signal even is, it is possible to couple
it within the object, but the handle will unknownly receive an
event which contains the same.

As of v0.3.0 handles are now designed with an exhausting of 1
by default, this is done under the theory that any handle which
is registered is done so to run at least once, otherwise it wouldn't
exist.

Methods
-------

__construct
+++++++++++

.. function:: __construct($function, [$exhaust = 1, [$priority = false]])


    Constructs a new handle object.

    :param mixed: A callable php variable.
    :param integer: Count to set handle exhaustion.
    :param null|integer: Priority of the handle.

    :rtype: void 



decrement_exhaust
+++++++++++++++++

.. function:: decrement_exhaust()


    Decrements the exhaustion counter.

    :rtype: void 



exhaustion
++++++++++

.. function:: exhaustion()


    Returns count until handle becomes exhausted

    :rtype: integer 



is_exhausted
++++++++++++

.. function:: is_exhausted()


    Determines if the handle has exhausted.

    :rtype: boolean 



get_priority
++++++++++++

.. function:: get_priority()


    Returns the priority of the handle.

    :rtype: integer 



get_function
++++++++++++

.. function:: get_function()


    Returns the function for the handle.

    :rtype: closure|array 



set_exhaust
+++++++++++

.. function:: set_exhaust($rate)


    Sets the handle exhaust rate.

    :param integer: Exhaust rate

    :rtype: void 



set_priority
++++++++++++

.. function:: set_priority($priority)


    Sets the handle priority.

    :param integer: Integer Priority

    :rtype: void 




Last updated on 02/01/13 07:27am