<?php

use Monolog\Logger;
use Monolog\Handler\LogglyHandler;
use Monolog\Handler\SlackHandler;

return [
    'drivers' => [
        'loggly' => [
            'handler' => LogglyHandler::class,
            'args' => [
                env('LOGGLY_TOKEN'),
                Logger::DEBUG,
            ],
        ],
        'slack' => [
            'handler' => SlackHandler::class,
            'args' => [
                env('SLACK_TOKEN'),
                env('SLACK_CHANNEL'),
                'Logger',
                true,
                ':beetle:',
                Logger::WARNING,
                true,
                false,
                true,
            ],
        ],
    ],
];