<?php

require __DIR__ . '/vendor/autoload.php';

use Magic\HtmlDirectoryRenderer;
use Magic\LocalDirectoryIterator;

/*
 *
 * Filter is running recursive - so if you search for a dir, then try to filter by file name - then you get nothing.
 *
*/

$filters = [
    [
        'filter'=>'list_by_type',
        'type'=>'dir'
    ]
];

$data = new HtmlDirectoryRenderer(
    new LocalDirectoryIterator('/var/www/playground'),
    $filters
);

$data->render();