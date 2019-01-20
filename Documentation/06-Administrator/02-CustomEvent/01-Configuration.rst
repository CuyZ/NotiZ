.. include:: ../../Includes.txt

Custom event configuration
==========================

An event can be enhanced with configuration that is used during runtime to
customize its behaviour.

.. note::

    In this example, we add a ``startTime`` and ``endTime`` properties to configure
    when the event is dispatched.

    This can be used for example to only trigger a Slack notification during
    business hours.

The configuration is done using a FlexForm:

.. code-block:: xml
    :caption: ``my_extension/Configuration/FlexForm/Event/Contact/ContactFormSentEventFlexForm.xml``

    <T3DataStructure>
        <meta>
            <langDisable>1</langDisable>
        </meta>
        <sheets>
            <sDEF>
                <ROOT>
                    <TCEforms>
                        <sheetTitle>Contact form: activation period</sheetTitle>
                    </TCEforms>
                    <type>array</type>
                    <el>
                        <startTime>
                            <TCEforms>
                                <label>LLL:EXT:my_extension/Resources/Private/Language/locallang.xlf:flex_form.start_time</label>
                                <config>
                                    <type>input</type>
                                    <eval>time</eval>
                                </config>
                            </TCEforms>
                        </startTime>
                        <endTime>
                            <TCEforms>
                                <label>LLL:EXT:my_extension/Resources/Private/Language/locallang.xlf:flex_form.end_time</label>
                                <config>
                                    <type>input</type>
                                    <eval>time</eval>
                                </config>
                            </TCEforms>
                        </endTime>
                    </el>
                </ROOT>
            </sDEF>
        </sheets>
    </T3DataStructure>

----

This FlexForm must be saved into a file and configured in the definition
at the path ``notiz.eventGroups.contactEvents.events.messageSent.configuration.flexForm``.

For example in TypoScript:

.. code-block:: typoscript
    :caption: ``my_extension/Configuration/TypoScript/NotiZ.typoscript``

    notiz {
        eventGroups {
            contactEvents {
                label = Events related to contact forms

                events {
                    messageSent {
                        label = Contact form sent

                        className = Acme\MyExtension\Domain\Event\ContactFormSentEvent

                        # Configure your file like this:
                        configuration {
                            flexForm {
                                file = EXT:my_extension/Configuration/FlexForm/Event/Contact/ContactFormSentEventFlexForm.xml
                            }
                        }

                        connection {
                            type = signal

                            className = Acme\MyExtension\Controller\ContactController
                            name = sendMessage
                        }
                    }
                }
            }
        }
    }

----

You can then access the extra configuration inside the event via the
``$this->configuration`` class property.

.. code-block:: php
    :caption: ``my_extension/Classes/Domain/Event/ContactFormSentEvent.php``

    namespace Acme\MyExtension\Domain\Event;

    use CuyZ\Notiz\Core\Event\AbstractEvent;
    use Acme\MyExtension\Form\ContactForm;
    use CuyZ\Notiz\Core\Event\Exception\CancelEventDispatch;
    use DateTime;

    class ContactFormSentEvent extends AbstractEvent
    {
        /**
         * @label The message sent by the user
         * @marker
         *
         * @var string
         */
        private $message;

        /**
         * @label LLL:EXT:my_extension/Resources/Private/Language/locallang.xlf:name
         * @marker
         *
         * @var string
         */
        private $name;

        /**
         * @label The email of the user
         * @email
         *
         * @var string
         */
        private $email;

        /**
         * @param ContactForm $contactForm
         */
        public function run(ContactForm $contactForm)
        {
            $this->shouldRun();

            $this->message = $contactForm->getMessage();
            $this->name = $contactForm->getName();
            $this->email = $contactForm->getEmail();
        }

        /**
         * Checks if this event has a start and end time. If so, it will cancel
         * the dispatching if the current time is not between the start and end.
         *
         * @throws CancelEventDispatch
         */
        private function shouldRun()
        {
            $startTime = $this->getTime('startTime');
            $endTime = $this->getTime('endTime');

            if (null === $startTime || null === $endTime) {
                return;
            }

            $now = new DateTime();

            if ($now < $startTime || $now > $endTime) {
                $this->cancelDispatch();
            }
        }

        /**
         * @param string $key
         * @return DateTime|null
         */
        private function getTime(string $key): ?DateTime
        {
            // We access the FlexForm values here
            if (!isset($this->configuration[$key])) {
                return null;
            }

            return DateTime::createFromFormat('!H:i', $this->configuration[$key]) ?: null;
        }
    }
