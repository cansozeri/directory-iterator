<?php

require __DIR__ . '/vendor/autoload.php';

use Directory\HtmlDirectoryRenderer;
use Directory\LocalDirectoryIterator;

$data = new HtmlDirectoryRenderer(
    new LocalDirectoryIterator('/var/www')
);

$data->render();
