<?php

/*
 * Copyright (C) 2018
 * Nathan Boiron <nathan.boiron@gmail.com>
 * Romain Canon <romain.hydrocanon@gmail.com>
 *
 * This file is part of the TYPO3 NotiZ project.
 * It is free software; you can redistribute it and/or modify it
 * under the terms of the GNU General Public License, either
 * version 3 of the License, or any later version.
 *
 * For the full copyright and license information, see:
 * http://www.gnu.org/licenses/gpl-3.0.html
 */

namespace CuyZ\Notiz\View\Slot\Application;

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

class TextSlot extends Slot
{
    /**
     * @var bool
     */
    protected $rte;

    /**
     * The RTE mode that can be used for:
     *
     * - CKEditor: must contain a valid preset that was registered in the global
     *             configuration of the extension.
     * - RTEHtmlArea: extra configuration for the RTE (field `defaultExtras`).
     *
     * @var string
     */
    protected $rteMode;

    /**
     * @param string $name
     * @param string $label
     * @param bool $rte
     * @param string $rteMode
     */
    public function __construct($name, $label, $rte, $rteMode)
    {
        parent::__construct($name, $label);

        $this->rte = $rte;
        $this->rteMode = $rteMode;
    }

    /**
     * @return string
     */
    public function getFlexFormConfiguration()
    {
        $flexForm = '
            <type>text</type>
            <cols>40</cols>
            <rows>15</rows>';

        if (!$this->rte) {
            return $flexForm;
        }

        $flexForm .= '<enableRichtext>1</enableRichtext>';

        if (!$this->rteMode
            || $this->isUsingLegacyRte()
        ) {
            return $flexForm;
        }

        if (isset($GLOBALS['TYPO3_CONF_VARS']['RTE']['Presets'][$this->rteMode])) {
            return $flexForm . "<richtextConfiguration>$this->rteMode</richtextConfiguration>";
        }

        /*
         * If we get to here, the CKEditor preset was not found: we warn the
         * user about it.
         */
        return "
                <type>user</type>
                <userFunc>CuyZ\Notiz\Core\Notification\TCA\User\MissingCkEditorPreset->process</userFunc>
                <parameters>
                    <preset>$this->rteMode</preset>
                </parameters>";
    }

    /**
     * @return string
     */
    public function getFlexFormAdditionalConfiguration()
    {
        $flexForm = '';

        if ($this->rteMode
            && $this->isUsingLegacyRte()
        ) {
            $flexForm .= "<defaultExtras>$this->rteMode</defaultExtras>";
        }

        return $flexForm;
    }

    /**
     * @return bool
     */
    private function isUsingLegacyRte()
    {
        return ExtensionManagementUtility::isLoaded('rtehtmlarea')
            && !ExtensionManagementUtility::isLoaded('rte_ckeditor');
    }
}
