<?php

return [
    [
        'info' => 'seven::app.name',
        'key' => 'seven',
        'name' => 'seven::app.name',
        'sort' => 1,
    ],
    [
        'info' => 'seven::app.settings_info',
        'key'  => 'seven.settings',
        'name' => 'seven::app.settings',
        'sort' => 1,
    ],
    [
        'fields' => [
            [
                'info' => 'seven::app.api_key_info',
                'name' => 'api_key',
                'title' => 'seven::app.api_key',
                'type' => 'password',
            ],
        ],
        'info' => 'seven::app.general_settings',
        'key' => 'seven.settings.general',
        'name' => 'seven::app.general_settings',
        'sort' => 1,
    ],
    [
        'fields' => [
            [
                'info' => 'seven::app.sms_from_info',
                'name' => 'from',
                'title' => 'seven::app.sms_from',
                'type' => 'text',
                'validation' => 'max:16',
            ],
        ],
        'info' => 'seven::app.settings_sms_info',
        'key' => 'seven.settings.sms',
        'name' => 'seven::app.settings_sms',
        'sort' => 1,
    ],
];
