.. include:: ../../Includes.txt

.. _administrator-definition-file:

Add file Definition
===================

Using a new definition file requires two steps:

1. Adding a definition file registration in the ``ext_localconf.php`` file of a
   custom extension.

2. Creating and filling the file with definition values.

.. hint::

    Sometimes more complex logic may be needed, in that case see chapter
    “:ref:`administrator-definition-advanced`”.

TypoScript definition file
--------------------------

.. code-block:: php
    :caption: ``my_extension/ext_localconf.php``

    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['NotiZ']['Definition']['Source'][\CuyZ\Notiz\Domain\Definition\Builder\Component\Source\TypoScriptDefinitionSource::class][]
        = 'EXT:my_extension/Configuration/TypoScript/MyCustomDefinition.typoscript';

.. code-block:: typoscript
    :caption: ``my_extension/Configuration/TypoScript/MyCustomDefinition.typoscript``

    notiz {
        notifications {
            /*
             * Modifying the provided email notification settings…
             */
            entityEmail {
                settings {
                    /*
                     * These recipients will be available by default in every
                     * email notification record.
                     */
                    globalRecipients {
                         10 = webmaster@acme.com
                    }
                }
            }
        }

        eventGroups {
            /*
             * We add a new event group for our custom events.
             */
            my_extension {
                label = Events for My Extension

                events {
                    /*
                     * Contact form is sent
                     * --------------------
                     *
                     * This event is bound to a signal sent by the contact
                     * controller. It contains data about the user who submitted
                     * the form, that will be available in the notifications
                     * markers.
                     */
                    contactFormSent {
                        label = Contact form sent

                        className = MyVendor\MyExtension\Event\ContactFormSentEvent

                        connection {
                            type = signal

                            className = MyVendor\MyContactExtension\Controller\ContactController
                            name = contactFormSent
                        }
                    }
                }
            }
        }
    }
