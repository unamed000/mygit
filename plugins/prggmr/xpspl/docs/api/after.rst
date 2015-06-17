.. /after.php generated using docpx on 04/23/13 11:40pm


Function - after
****************


.. function:: after($signal, $process)


    Installs the given process to interrupt the signal ``$signal`` when emitted.
    
    Interruption processes installed using this function interrupt directly 
    after a signal is emitted.
    
    .. warning:: 
    
       Interruptions are not a fix for improperly executing process priorities 
       within a signal.
       
       If unexpected process priority are being executed debug them... 
    
    .. note::
    
       Interruptions use the same prioritizing as the Processor.

    :param callable|process: PHP Callable or \XPSPL\Process.

    :rtype: object Process


Install a interrupt process after foo
#####################################

High priority process will always execute first immediatly following 
interruptions.

.. code-block:: php

   <?php
   
   signal(SIG('foo'), function(){
       echo 'foo';
   });

   after(SIG('foo'), function(){
       echo 'after foo';
   });

   // results when foo is emitted
   // fooafter foo

After Interrupt Process Priority
################################

Install after interrupt processes with priority.

.. code-block:: php

   <?php
   signal(SIG('foo'), function(){
       echo 'foo';
   })
   
   after(SIG('foo'), low_priority(function(){
       echo 'low priority foo';
   }));
   
   after(SIG('foo'), high_priority(function(){
       echo 'high priority foo';
   }));
   
   emit(SIG('foo'));

   // results
   // foo highpriorityfoo lowpriorityfoo




Last updated on 04/23/13 11:40pm