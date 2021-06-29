<?php


namespace CuyZ\Notiz\Form\Element;


use CuyZ\Notiz\Domain\Notification\Log\Application\EntityLog\TCA\EntityLogTcaService;
use TYPO3\CMS\Backend\Form\Element\AbstractFormElement;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class LogLevelsDescriptionsElement extends AbstractFormElement
{

    public function render()
    {
        $result = $this->initializeResultArray();
        $service = GeneralUtility::makeInstance(EntityLogTcaService::class);
        $result['html'] = $service->getLogLevelsDescriptions();
        return $result;
    }
}
