<?php
namespace Magic;

use RecursiveTreeIterator;

class TreeDirectoryRenderer extends AbstractDirectoryRenderer
{

    /**
     * @param RecursiveTreeIterator $tree
     */
    protected function renderDirectory($tree)
    {
        $prefixParts = [
            RecursiveTreeIterator::PREFIX_LEFT         => ' ',
            RecursiveTreeIterator::PREFIX_MID_HAS_NEXT => '│ ',
            RecursiveTreeIterator::PREFIX_END_HAS_NEXT => '├ ',
            RecursiveTreeIterator::PREFIX_END_LAST     => '└ '
        ];

        foreach ($prefixParts as $part => $string) {
            $tree->setPrefixPart($part, $string);
        }

        foreach ([0, -1] as $level)
        {
            $tree->setMaxDepth($level);
            echo "[tree]<br>";
            foreach ($tree as $filename => $line)
            {
                echo $tree->getPrefix(), $filename, "<br>";
            }
        }
    }
}