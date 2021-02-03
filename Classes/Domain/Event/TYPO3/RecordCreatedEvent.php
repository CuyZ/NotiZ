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
use CuyZ\Notiz\Core\Event\Support\ProvidesExampleProperties;
use InvalidArgumentException;
use TYPO3\CMS\Core\DataHandling\DataHandler;

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

        if ($status === 'new') {
            $this->uid = $dataHandler->substNEWwithIDs[$recordId];
        } elseif ($status === 'update') {
            $this->uid = $recordId;
        } else {
            throw new InvalidArgumentException('$status must be `new` or `update`');
        }

        $this->record = $dataHandler->recordInfo($table, $this->uid, '*');

        if ($table === 'tt_content'
            && !empty($this->configuration['ctype'])
            && !preg_match($this->configuration['ctype'], $this->record['CType'])
        ) {
            $this->cancelDispatch();
        }

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
}
