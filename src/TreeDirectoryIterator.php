<?php

namespace Magic;

use RecursiveDirectoryIterator;
use RecursiveTreeIterator;

class TreeDirectoryIterator extends AbstractDirectoryIterator
{
    public function getIterator()
    {
        return new RecursiveTreeIterator(new RecursiveDirectoryIterator($this->root, RecursiveDirectoryIterator::SKIP_DOTS));
    }
}