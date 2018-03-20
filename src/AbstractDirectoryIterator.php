<?php
namespace Directory;

use IteratorAggregate;

abstract class AbstractDirectoryIterator implements IteratorAggregate
{
    protected $root;
    protected $config=[];


    public function __construct($root = null, array $config = [])
    {
        $this->root = is_null($root)?__DIR__:$root;
        $this->config = $config;

    }
}