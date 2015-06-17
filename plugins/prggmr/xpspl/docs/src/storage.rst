.. storage.php generated using docpx on 02/01/13 07:27am


Trait - XPSPL\\Storage
**********************

Storage trait.

The Storage trait is designed to allow objects to act as a storage, the
trait only provides an interface to the normal PHP functions used for
transversing an array, keeping all data within a central storage.

See the PHP Manual for more information regarding the functions used
in this trait.

Methods
-------

storage
+++++++

.. function:: storage()


    Returns the current storage array.

    :rtype: array 



merge
+++++

.. function:: merge()


    Merge an array with the current storage.

    :rtype: void 



walk
++++

.. function:: walk()


    Apply the given function to every node in storage.

    :param callable: 

    :rtype: void 



count
+++++

.. function:: count()


    Procedures.



current
+++++++

.. function:: current()



end
+++

.. function:: end()



key
+++

.. function:: key()



next
++++

.. function:: next()



prev
++++

.. function:: prev()



reset
+++++

.. function:: reset()



valid
+++++

.. function:: valid()



sort
++++

.. function:: sort()



usort
+++++

.. function:: usort()



uasort
++++++

.. function:: uasort()




Last updated on 02/01/13 07:27am