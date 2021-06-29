<?php
/** @noinspection PhpUndefinedVariableInspection */
$EM_CONF[$_EXTKEY] = [
    'title' => 'NotiZ • Powerful notification dispatcher',
    'description' => 'Handle any type of notification in TYPO3 with ease: emails, SMS, Slack and more. Listen to your own events or provided ones (scheduler task finishing, extension installed, etc…).',

    'version' => '3.0.0',
    'state' => 'stable',

    'author' => 'Romain Canon, Nathan Boiron',
    'author_email' => 'team.cuyz@gmail.com',

    'category' => 'be',
    'clearCacheOnLoad' => true,

    'constraints' => [
        'depends' => [
            'typo3' => '10.4.0-10.4.99',
            'configuration_object' => '3.0.0-3.9.99',
        ],
    ],
];
