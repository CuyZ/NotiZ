.. include:: ../../Includes.txt

Definition
==========

This extension is based on a configuration object, called the “**definition**”.
It allows administrators to manage how events and notifications will be
processed during runtime.

In order to register a new event or configure notifications, the definition must
be extended. Definition values can be written inside files in custom extensions.

.. important::

    The validity of the definition is really important. If an error is found
    when the definition is being built, the whole notification system will be
    deactivated until the definition is valid again.

    If errors are found, a module allows to have details about it, see chapter
    “:ref:`administrator-definition-preview`” for more information.

.. hint::

    The simplest way to register a definition file is to add a piece of code in
    the ``ext_localconf.php`` file of a custom extension; find more information
    in the chapter “:ref:`administrator-definition-file`”.

.. hint::

    If more complex logic is needed, a so-called “definition component service”
    can be used; see chapter “:ref:`administrator-definition-advanced`” for more
    information.

.. toctree::
    :hidden:
    :titlesonly:
    :glob:

    *
