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
     * @var   string  $type ['file'|'dir']
     * @return bool|\SplFileInfo
     */
    protected function SearchByNameFilter($filter)
    {
        if(isset($filter['type']))
        {
            if($this->directory->getType()!=$filter['type'])
            {
                return false;
            }
        }

        return $this->search($this->directory->getFilename(),$filter['needle']);

    }

    /**
     * @param $filter
     * @return bool|\SplFileInfo
     */
    protected function SearchInFileFilter($filter)
    {
        if(!$this->directory->isFile())
        {
            return false;
        }

        $content = file_get_contents($this->directory);

        return $this->search($content,$filter['needle']);
    }

    /**
     * @return bool|\SplFileInfo
     */
    protected function DirectoryFilter()
    {
        return $this->directory->isDir()?$this->directory:false;
    }

    /**
     * @param $content
     * @param $needle
     * @return bool|\SplFileInfo
     */
    protected function search($content, $needle)
    {
        if(is_array($needle))
        {
            $found = [];

            foreach ($needle as $value)
            {
                if($this->isMatch($content,$value)) $found[$value]=1;
            }

            return !empty($found)?$this->directory:false;
        }
        else
        {
            return $this->isMatch($content,$needle)?$this->directory:false;
        }
    }

    /**
     * @param $content
     * @param $value
     * @return bool
     */
    protected function isMatch($content, $value)
    {
        return strpos($content, $value) !== false;
    }

}