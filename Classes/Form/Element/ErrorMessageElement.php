<?php


namespace CuyZ\Notiz\Form\Element;


use CuyZ\Notiz\Core\Notification\TCA\Processor\GracefulProcessor;
use TYPO3\CMS\Backend\Form\Element\AbstractFormElement;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class ErrorMessageElement extends AbstractFormElement
{

    public function render()
    {
        $result = $this->initializeResultArray();
        $serviceClass = $this->data['parameterArray']['fieldConf']['config']['parameters']['serviceClass'];
        $exception = $this->data['parameterArray']['fieldConf']['config']['parameters']['exception'];

        /** @var GracefulProcessor $service */
        $service = GeneralUtility::makeInstance($serviceClass);
        $result['html'] = $service->getErrorMessage($exception);
        return $result;
    }
}
