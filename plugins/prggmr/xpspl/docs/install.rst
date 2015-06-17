.. _install:

Installing XPSPL
----------------

Requirements
============

XPSPL requires  **>= PHP 5.4**.

XPSPL does not require **any** additional modules or configuration options.

Install
=======

XPSPL installation is over the network with a CLI. (link_)

.. _link: https://raw.github.com/prggmr/xpspl/master/install

The installation requires the **CURL** and **ZIP** libraries to be installed 
on the system.

.. code-block:: console

    curl -s https://raw.github.com/prggmr/xpspl/master/install | sudo sh

Once installed the ``xpspl`` command becomes available.

Updates
=======

Peform updates by running ``xpspl`` with option ``--update``.

.. code-block:: console

    xpspl --update

Optional
========

C Judy 1.0.4
PECL Judy 0.1.4

The Judy library demonstrates improving the database by giving storage a linear 
scale of ~39us up to the tested 262144.

The Judy C library is bundled in the ``library`` folder with XPSPL.

For installation of Judy C see the README.

For installation of Judy PECL visit here_.

.. _here: http://pecl.php.net/package/Judy

Windows
=======

Currently a Windows installation guide does not exist.

.. todo::

    Add windows install guide.
