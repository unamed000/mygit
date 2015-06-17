.. /signal_history.php generated using docpx on 04/23/13 11:40pm


Function - signal_history
*************************


.. function:: signal_history()


    Returns the current signal history.
    
    The returned history is stored in an array using the following indexes.
    
    .. code-block:: php
    
       <?php
       $array = [
           0 => Signal Object
           1 => Time in microseconds since Epoch at emittion
       ];

    :rtype: array 


Counting emitted signals
########################

This counts the number of ``SIG('foo')`` signals that were emitted.

.. code-block:: php

   <?php
   $sig = SIG('foo');
   // Emit a few foo objects
   for($i=0;$i<5;$i++){
       emit($sig);
   }
   $emitted = 0;
   foreach(signal_history() as $_node) {
       if ($_node[0] instanceof $sig) {
           $emitted++;
       }
   }
   echo $emitted;




Last updated on 04/23/13 11:40pm