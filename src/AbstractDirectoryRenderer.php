<?php
namespace Magic;

use IteratorAggregate;

abstract class AbstractDirectoryRenderer implements DirectoryRendererInterface
{
    protected $iterator;
    protected $filters;

    public function __construct(IteratorAggregate $iterator,array $filters = [])
    {
        $this->iterator = $iterator;
        $this->filters = $filters;
    }

    public function render()
    {
        $this->renderDirectory($this->iterator->getIterator());
    }

    protected function filter($directory)
    {
        if(empty($this->filters))
        {
            return $directory;
        }

        $filter =  new Filters($directory);

        return $filter->filter($this->filters);
    }

    protected function isExists($content,$value)
    {
        return strpos($content, $value) !== false;
    }

    abstract protected function renderDirectory($directory);
}