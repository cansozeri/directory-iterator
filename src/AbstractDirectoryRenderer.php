<?php
namespace Directory;

use IteratorAggregate;

abstract class AbstractDirectoryRenderer implements DirectoryRendererInterface
{
    protected $iterator;

    public function __construct(IteratorAggregate $iterator)
    {
        $this->iterator = $iterator;
    }

    public function render()
    {
        $dirs = $this->iterator->getIterator();

        foreach ($dirs as $dir) {
            $this->renderDirectory($dir);
        }
    }

    public function isExists($content,$value)
    {
        return strpos($content, $value) !== false;
    }

    abstract protected function renderDirectory($directory);
}
