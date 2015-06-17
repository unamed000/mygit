.. queue.php generated using docpx on 02/01/13 07:27am


Class - XPSPL\\Queue
********************

As of v0.3.0 Queues no longer maintain a reference to a signal.

The Queue is still a representation of a PriorityQueue and will remain so 
until the issues with PHP's current implementation are addressed.

The queue can also be explicity set to a MIN or MAX heap upon construction.

Methods
-------

enqueue
+++++++

.. function:: enqueue($node, [$priority = false])


    Pushes a new handler into the queue.

    :param mixed: Variable to store
    :param integer: Priority of the callable

    :throws OverflowException: If max size exceeded

    :rtype: void 



dequeue
+++++++

.. function:: dequeue($node)


    Removes a handle from the queue.

    :param mixed: Reference to the node.

    :throws InvalidArgumentException: 

    :rtype: boolean 



sort
++++

.. function:: sort()


    Sorts the queue.

    :rtype: void 



Constants
---------

QUEUE_MAX_SIZE
++++++++++++++
Defines the maximum number of handlers allowed within a Queue.

QUEUE_DEFAULT_PRIORITY
++++++++++++++++++++++
Defines the default priority of queue nodes


Last updated on 02/01/13 07:27am