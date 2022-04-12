<?php

return [
    'admin' => [
        ['title' => 'Dashboard', 'route' => 'admin.dashboard', 'icon' => 'fe fe-home'],
        [
            'title' => 'Manage User',
            'icon' => 'fe fe-users',
            'route' => 'admin.user',
            // 'children' => [['title' => 'View User', 'route' => 'admin.user']],
        ],
        [
            'title' => 'Address', 'icon' => 'fe fe-map-pin',
            'children' => [
                ['title' => 'Province', 'route' => 'admin.address.province'],
                ['title' => 'Regencie', 'route' => 'admin.address.regencie'],
                ['title' => 'District', 'route' => 'admin.address.district'],
                ['title' => 'Village', 'route' => 'admin.address.village'],
            ]
        ],
        [
            'title' => 'Mail Box', 'icon' => 'fe fe-mail',
            'children' => [
                ['title' => 'Inbox'],
                ['title' => 'Compose'],
                ['title' => 'Read']
            ]
        ],
        // ['title' => 'Separator', 'separator' => true],
        ['title' => 'Company', 'icon' => 'fe fe-grid'],
        [
            'title' => 'Projects', 'icon' => 'fe fe-crosshair',
            'children' => [
                ['title' => 'Alerts'],
                ['title' => 'Badge'],
                ['title' => 'Buttons'],
                ['title' => 'Sliders'],
                ['title' => 'Dropdown'],
                ['title' => 'Modal'],
                ['title' => 'Nestable'],
                ['title' => 'Progress Bars']
            ]
        ]
    ],
    'user' => [
        ['title' => 'Dashboard', 'route' => 'user.dashboard', 'icon' => 'fe fe-home'],
    ]

];
