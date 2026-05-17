<?php

$path = __DIR__ . '/countries.json';

if (! file_exists($path)) {
    return [
        'default' => 'global',
        'countries' => [],
    ];
}

$data = json_decode(file_get_contents($path), true) ?: [];

return [
    'default' => $data['default'] ?? 'global',
    'countries' => $data['countries'] ?? [],
];
