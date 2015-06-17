.. event.php generated using docpx on 02/01/13 07:27am


Class - XPSPL\\Event
********************

Event

Represents an executed/executable XPSPL event signal.

As of v0.3.0 the event now inherits the State and Storage traits.

Methods
-------

__construct
+++++++++++

.. function:: __construct([$ttl = false])


    Construction allow for setting the event TTL.

    :param integer: TTL in milliseconds for the event.

    :rtype: object XPSPL\Event



has_expired
+++++++++++

.. function:: has_expired()


    Returns if the event's TTL has passed.

    :rtype: boolean 



get_signal
++++++++++

.. function:: get_signal()


    Returns the event signal.

    :rtype: int|string|object 



set_result
++++++++++

.. function:: set_result($result)


    Sets the result of the event.

    :param mixed: 



get_result
++++++++++

.. function:: get_result()


    Returns the result of the event.

    :rtype: mixed 



halt
++++

.. function:: halt()


    Halts the event execution.

    :rtype: void 



is_child
++++++++

.. function:: is_child()


    Determines if the event is a child of another event.

    :rtype: boolean 



set_parent
++++++++++

.. function:: set_parent($event)


    Sets the parent event.

    :param object: \XPSPL\Event

    :rtype: void 



get_parent
++++++++++

.. function:: get_parent()


    Retrieves this event's parent.

    :rtype: null|object 



__get
+++++

.. function:: __get($key)


    Get a variable in the event.

    :param mixed: Variable name.

    :rtype: mixed|null 



__isset
+++++++

.. function:: __isset($key)


    Checks for a variable in the event.

    :param mixed: Variable name.

    :rtype: boolean 



__set
+++++

.. function:: __set($key, $value)


    Set a variable in the event.

    :param string: Name of variable
    :param mixed: Value to variable

    :rtype: boolean True



__unset
+++++++

.. function:: __unset($key)


    Deletes a variable in the event.

    :param mixed: Variable name.

    :rtype: boolean 



Constants
---------

EVENT_SELF_PARENT
+++++++++++++++++

Last updated on 02/01/13 07:27am