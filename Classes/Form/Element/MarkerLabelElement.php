<?php


namespace CuyZ\Notiz\Form\Element;


use CuyZ\Notiz\Core\Notification\Service\NotificationTcaService;
use TYPO3\CMS\Backend\Form\Element\AbstractFormElement;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class MarkerLabelElement extends AbstractFormElement
{

    public function render()
    {
        $result = $this->initializeResultArray();
        $serviceClass = $this->data['parameterArray']['fieldConf']['config']['parameters']['serviceClass'];

        /** @var NotificationTcaService $service */
        $service = GeneralUtility::makeInstance($serviceClass);

        $result['html'] = $service->getMarkersLabel($this->data['databaseRow']);
        return $result;
    }
}
