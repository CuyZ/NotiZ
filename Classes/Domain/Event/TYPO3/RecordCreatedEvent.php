<?php
declare(strict_types=1);

/*
 * Copyright (C)
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

namespace CuyZ\Notiz\Domain\Event\TYPO3;

use CuyZ\Notiz\Core\Event\AbstractEvent;
use CuyZ\Notiz\Core\Event\Exception\CancelEventDispatch;
use CuyZ\Notiz\Core\Event\Support\ProvidesExampleProperties;
use TYPO3\CMS\Core\DataHandling\DataHandler;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\RootlineUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;

final class RecordCreatedEvent extends AbstractEvent implements ProvidesExampleProperties
{
    /**
     * @label Event/TYPO3:record_created.marker.status
     * @marker
     *
     * @var string
     */
    protected $status;

    /**
     * @label Event/TYPO3:record_created.marker.table
     * @marker
     *
     * @var string
     */
    protected $table;

    /**
     * @label Event/TYPO3:record_created.marker.uid
     * @marker
     *
     * @var string
     */
    protected $uid;

    /**
     * @label Event/TYPO3:record_created.marker.record
     * @marker
     *
     * @var array
     */
    protected $record;

    public function run($status, $table, $recordId, array $updatedFields, DataHandler $dataHandler)
    {
        if ($table !== $this->configuration['table']) {
            $this->cancelDispatch();
        }

        $this->checkStatus($status);

        $this->uid = $this->findUid($recordId, $table, $status, $dataHandler);
        $this->record = $dataHandler->recordInfo($table, $this->uid, '*');

        $actualCType = '';

        if (isset($updatedFields['CType']) && is_string($updatedFields['CType'])) {
            $actualCType = $updatedFields['CType'];
        } elseif (isset($this->record['CType']) && is_string($this->record['CType'])) {
            $actualCType = $this->record['CType'];
        }

        if ($table === 'tt_content'
            && !empty($this->configuration['ctype'])
            && !preg_match($this->configuration['ctype'], $actualCType)
        ) {
            $this->cancelDispatch();
        }

        $this->checkPid();

        $this->status = $status;
        $this->table = $table;
    }

    public function getExampleProperties(): array
    {
        return [
            'status' => 'new',
            'table' => $this->configuration['table'],
            'uid' => 1337,
            'record' => [
                'uid' => 1337,
                'pid' => 42,
                'starttime' => 1612014706,
            ],
        ];
    }

    private function findUid($id, $table, $status, DataHandler $dataHandler)
    {
        $uid = $id;

        if ($status === 'new') {
            if (!$dataHandler->substNEWwithIDs[$id]) {
                //postProcessFieldArray
                $uid = 0;
            } else {
                //afterDatabaseOperations
                $uid = $dataHandler->substNEWwithIDs[$id];
                if (isset($dataHandler->autoVersionIdMap[$table][$uid])) {
                    $uid = $dataHandler->autoVersionIdMap[$table][$uid];
                }
            }
        }

        return (int)$uid;
    }

    /**
     * @param string $status Either "new" or "update"
     * @throws CancelEventDispatch
     */
    private function checkStatus($status)
    {
        if (!isset($this->configuration['statuses'])
            || !is_string($this->configuration['statuses'])
        ) {
            return;
        }

        if (strlen($this->configuration['statuses']) === 0) {
            return;
        }

        $statuses = explode(',', $this->configuration['statuses']);

        if (empty($statuses)) {
            return;
        }

        if (!in_array($status, $statuses)) {
            $this->cancelDispatch();
        }
    }

    private function checkPid()
    {
        if (!isset($this->configuration['pids'])) {
            return;
        }

        if (!is_string($this->configuration['pids'])) {
            return;
        }

        $authorizedPids = explode(',', $this->configuration['pids']);

        $currentPid = (int)$this->record['pid'];

        if ($currentPid === 0) {
            if (count($authorizedPids) === 0) {
                return;
            }

            if (in_array($currentPid, $authorizedPids)) {
                return;
            }

            $this->cancelDispatch();
        }

        /** @var ObjectManager $objectManager */
        $objectManager = GeneralUtility::makeInstance(ObjectManager::class);

        /** @var RootlineUtility $rootlineUtility */
        $rootlineUtility = $objectManager->get(RootlineUtility::class, $currentPid);

        $rootline = array_map(function ($page) {
            return $page['pid'];
        }, $rootlineUtility->get());

        $rootline[] = $currentPid;

        foreach ($rootline as $rootlinePid) {
            if (in_array($rootlinePid, $authorizedPids)) {
                return;
            }
        }

        $this->cancelDispatch();
    }
}
