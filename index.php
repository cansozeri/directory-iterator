<?php

require __DIR__ . '/vendor/autoload.php';

use Magic\TreeDirectoryRenderer;
use Magic\TreeDirectoryIterator;

/*
 *
 * Filter is running recursive - so if you search for a dir, then try to filter by file name - then you get nothing.
 *
*/

$filters = [
    [
        'filter'=>'list_by_type',
        'type'=>'file'
    ]
];

$data = new TreeDirectoryRenderer(
    new TreeDirectoryIterator('/var/www/playground')
);

$data->render();