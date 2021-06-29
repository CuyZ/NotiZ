<?php


namespace CuyZ\Notiz\Form\Element;


use CuyZ\Notiz\Backend\FormEngine\DataProvider\DefinitionError;
use TYPO3\CMS\Backend\Form\Element\AbstractFormElement;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class DefinitionErrorMessageElement extends AbstractFormElement
{

    public function render()
    {
        $result = $this->initializeResultArray();
        $definitionError = GeneralUtility::makeInstance(DefinitionError::class);
        $result['html'] = $definitionError->getDefinitionErrorMessage();
        return $result;
    }
}
