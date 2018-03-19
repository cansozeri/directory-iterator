<?php

namespace Directory;

use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

class LocalDirectoryIterator extends AbstractDirectoryIterator
{

    public function getIterator()
    {
        return new RecursiveIteratorIterator(new RecursiveDirectoryIterator($this->root,RecursiveDirectoryIterator::SKIP_DOTS),RecursiveIteratorIterator::LEAVES_ONLY);
    }
}
