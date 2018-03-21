<?php

require __DIR__ . '/vendor/autoload.php';

use Directory\HtmlDirectoryRenderer;
use Directory\LocalDirectoryIterator;

/*
 *
 * Filter is running recursive - so if you search for a dir, then try to filter by file name - then you get nothing.
 *
*/

$filters = [
    [
        'filter'=>'search_by_name',
        'needle'=>['isotope','jquery']
    ]
];

$data = new HtmlDirectoryRenderer(
    new LocalDirectoryIterator('/var/www/playground'),
    $filters
);

$data->render();