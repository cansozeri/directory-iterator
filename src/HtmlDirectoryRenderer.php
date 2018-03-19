<?php
namespace Directory;

class HtmlDirectoryRenderer extends AbstractDirectoryRenderer
{
    protected $extenList = array('php', 'html', 'js', 'tpl');

    protected function renderDirectory($directory)
    {
        $ext = pathinfo($directory, PATHINFO_EXTENSION);

        if(in_array($ext, $this->extenList) === true)
        {
            if(is_readable($directory))
            {
                echo '<p>'.$directory.'</p>';
            }
            else
            {
                echo '<p><span style="color: #761c19;font-weight: bold;">ERROR : </span> '.$directory.' <span style="color: #761c19;font-weight: bold;">could not be opened!!</span></p>';
            }
        }

    }
}