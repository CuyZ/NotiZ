<?php


namespace CuyZ\Notiz\Form\Element;


use CuyZ\Notiz\Core\Notification\Service\NotificationTcaService;
use CuyZ\Notiz\Domain\Notification\Slack\Application\EntitySlack\TCA\EntitySlackTcaService;
use TYPO3\CMS\Backend\Form\Element\AbstractFormElement;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class NoDefinedBotTextElement extends AbstractFormElement
{

    public function render()
    {
        $result = $this->initializeResultArray();
        $serviceClass = $this->data['parameterArray']['fieldConf']['config']['parameters']['serviceClass'];

        /** @var EntitySlackTcaService $service */
        $service = GeneralUtility::makeInstance($serviceClass);
        $result['html'] = $service->getNoDefinedBotText();
        return $result;
    }
}
