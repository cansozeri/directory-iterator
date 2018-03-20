<?php

require __DIR__ . '/vendor/autoload.php';

use Directory\HtmlDirectoryRenderer;
use Directory\LocalDirectoryIterator;

$filters = [
    [
        'filter'=>'extension',
        'extensions'=>['php', 'html', 'js', 'tpl']
    ],
    [
        'filter'=>'search_in_file',
        'needle'=>'youtube'
    ]
];

$data = new HtmlDirectoryRenderer(
    new LocalDirectoryIterator('/var/www/playground'),
    $filters
);

$data->render();