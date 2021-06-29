<?php

return [
    \CuyZ\Notiz\Domain\Notification\Email\Application\EntityEmail\EntityEmailNotification::class => [
        'tableName' => 'tx_notiz_domain_model_entityemailnotification',
        'properties' => [
            'backendUser' => [
                'fieldName' => 'cruser_id'
            ]
        ]
    ],
    \CuyZ\Notiz\Domain\Notification\Log\Application\EntityLog\EntityLogNotification::class => [
        'tableName' => 'tx_notiz_domain_model_entitylognotification',
        'properties' => [
            'backendUser' => [
                'fieldName' => 'cruser_id'
            ]
        ]
    ],
    \CuyZ\Notiz\Domain\Notification\Slack\Application\EntitySlack\EntitySlackNotification::class => [
        'tableName' => 'tx_notiz_domain_model_entityslacknotification',
        'properties' => [
            'backendUser' => [
                'fieldName' => 'cruser_id'
            ]
        ]
    ],
];
