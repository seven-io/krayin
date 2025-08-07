<?php

return [
    [
        'info' => 'seven::app.name',
        'key' => 'seven',
        'name' => 'seven::app.name',
        'sort' => 1,
    ],
    [
        'key'  => 'seven.settings',
        'name' => 'seven::app.settings',
        'info' => 'seven::app.settings_info',
        'sort' => 1,
    ],
    [
        'fields' => [
            [
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
];
