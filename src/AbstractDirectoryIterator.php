<?php
namespace Directory;

use IteratorAggregate;

abstract class AbstractDirectoryIterator implements IteratorAggregate
{
    protected $root;

    public function __construct($search,$root = null)
    {
        $this->root = is_null($root)?__DIR__:$root;
    }
}
