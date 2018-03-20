<?php
namespace Directory;


class Filters
{
    protected $directory;
    protected $filters;
    protected $result;

    public function __construct(\SplFileInfo $directory)
    {
        $this->directory = $directory;
    }

    /**
     * @param array $filters
     * @return mixed|\SplFileInfo
     */
    public function filter(array $filters)
    {

        foreach ($filters as $filter)
        {
            if(!isset($filter['filter']))
            {
                throw new \InvalidArgumentException('There is no filter option. Please use filter option in your array');
            }

            if(!$this->directory)
            {
                break;
            }

            $this->directory =  $this->createFilter($filter);
        }

        return $this->directory;
    }

    /**
     * @param array $filter
     * @return mixed
     */
    private function createFilter(array $filter)
    {

        $value = str_replace(' ','',ucwords(str_replace(['-', '_'], ' ', $filter['filter'])));

        $method = $value.'Filter';

        if (method_exists($this, $method)) {
            return $this->$method($filter);
        }

        throw new \InvalidArgumentException('Filter [ '.$filter["filter"].' ] not supported.');

    }

    /*
     *
     * Filters must return SPL directory File Info ( $this->directory ) or false (break out filter queue)
     *
     * */

    /**
     * @param $filter
     * @return bool|\SplFileInfo
     */

    protected function ExtensionFilter($filter)
    {
        $extensions = $filter['extensions'];

        return in_array($this->directory->getExtension(), $extensions) === true?$this->directory:false;
    }

    /**
     * @param $filter
     * @return bool|\SplFileInfo
     */
    protected function SearchInFileFilter($filter)
    {

        if(!$this->directory->isFile())
        {
            return $this->directory;
        }

        $content = file_get_contents($this->directory);

        if(is_array($filter['needle']))
        {
            foreach ($filter['needle'] as $value)
            {
               return $this->isExists($content,$value)?$this->directory:false;
            }
        }
        else
        {
            return $this->isExists($content,$filter['needle'])?$this->directory:false;
        }

        return $this->directory;
    }

    /**
     * @param $content
     * @param $value
     * @return bool
     */
    protected function isExists($content, $value)
    {
        return strpos($content, $value) !== false;
    }

}