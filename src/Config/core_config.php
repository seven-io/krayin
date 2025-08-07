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
    [
        'fields' => [
            [
                'info' => 'seven::app.setting_msg_person_create_after_info',
                'name' => 'msg_person_create_after',
                'title' => 'seven::app.setting_msg_person_create_after',
                'type' => 'text',
            ],
        ],
        'info' => 'seven::app.setting_events_info',
        'key' => 'seven.settings.events',
        'name' => 'seven::app.setting_events',
        'sort' => 1,
    ],
];
