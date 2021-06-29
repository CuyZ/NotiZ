<?php


namespace CuyZ\Notiz\Form\Element;

use TYPO3\CMS\Backend\Form\Element\AbstractFormElement;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class DefaultSenderElement extends AbstractFormElement
{

    public function render()
    {
        $result = $this->initializeResultArray();
        $serviceClass = $this->data['parameterArray']['fieldConf']['config']['parameters']['serviceClass'];

        $service = GeneralUtility::makeInstance($serviceClass);
        if (\method_exists($service, 'getDefaultSender')) {
            $result['html'] = $service->getDefaultSender();
        }
        return $result;
    }
}
