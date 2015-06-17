.. /emit.php generated using docpx on 04/23/13 11:40pm


Function - emit
***************


.. function:: emit($signal, [$context = false])


    Emit a signal. 
    
    This will execute all processes and interruptions installed to the signal. 
    
    The executed ``SIG`` object is returned.
    
    .. note::
    
       When emitting unique signals, e.g.. complex, routines or defined uniques 
       the unique sig object installed must be given.
    
    Once a signal is emitted the following execution chain takes place.
    
    1. Before process interruptions
    2. Installed processes
    3. After process interruptions

    :param signal: Signal to emit.
    :param object: Signal context.

    :rtype: object SIG


Emitting a unique signal
########################

When a unique signal is emitted

.. code-block:: php

   <?php
   // Create a unique Foo signal.
   class Foo extends \XPSPL\SIG {
       // declare it as unique
       protected $_unique = true;
   }
   // Install a null exhaust process for the Foo signal
   $foo = new Foo();
   signal($foo, null_exhaust(function(){
       echo "Foo";
   }));
   // Emit foo and new Foo
   emit($foo);
   emit(new Foo());
   // Results
   // Foo




Last updated on 04/23/13 11:40pm