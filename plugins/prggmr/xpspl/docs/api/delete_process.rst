.. /delete_process.php generated using docpx on 04/23/13 11:40pm


Function - delete_process
*************************


.. function:: delete_process($signal, $process)


    Removes an installed signal process.

    :param string|integer|object: Signal process is attached to.
    :param object: Process.

    :rtype: void 


Removing installed processes
############################

Removes the installed process from the foo signal.

.. code-block::php

   <?php
   $process = signal('foo', function(){});
   
   delete_process('foo', $process);




Last updated on 04/23/13 11:40pm