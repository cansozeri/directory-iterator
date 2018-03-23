<?php
namespace Magic;

class HtmlDirectoryRenderer extends AbstractDirectoryRenderer
{

    /**
     * @param $dirs
     */
    protected function renderDirectory($dirs)
    {
        foreach($dirs as $directory)
        {
            /** @var \SplFileInfo $directory */
            if($directory->isReadable())
            {
                $directory = $this->filter($directory);

                if($directory)
                {
                    echo '<p>'.$directory.'</p>';
                }
            }
            else
            {
                echo '<p><span style="color: #761c19;font-weight: bold;">ERROR : </span> '.$directory.' <span style="color: #761c19;font-weight: bold;">could not be opened!!</span></p>';
            }
        }

    }
}