<?php

return [
    'providers_list' => [
        [
            'reader' =>  \App\Readers\JsonReaders\DataProviderXReader::class,
            'path' => storage_path('app'),
            'files' => ['DataProviderX.json'],
        ],

        [
            'reader' => \App\Readers\JsonReaders\DataProviderYReader::class,
            'path' => storage_path('app'),
            'files' => ['DataProviderY.json'],
        ],
    ]
];
