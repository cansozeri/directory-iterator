<?php
namespace Magic;


class Filters
{
    protected $filtered;
    protected $filters;

    public function __construct(\SplFileInfo $filtered)
    {
        $this->filtered = $filtered;
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

            if(!$this->filtered)
            {
                break;
            }

            $this->filtered =  $this->createFilter($filter);
        }

        return $this->filtered;
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
     * Filters must return SPL filtered File Info ( $this->filtered ) or false (break out filter queue)
     *
     * */

    /**
     * @param $filter
     * @return bool|\SplFileInfo
     */

    protected function ExtensionFilter($filter)
    {
        $extensions = $filter['extensions'];

        return in_array($this->filtered->getExtension(), $extensions) === true?$this->filtered:false;
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
            if(!$this->ListByTypeFilter($filter))
            {
                return false;
            }
        }

        return $this->search($this->filtered->getFilename(),$filter['needle']);

    }

    /**
     * @param $filter
     * @return bool|\SplFileInfo
     */
    protected function SearchInFileFilter($filter)
    {
        if(!$this->filtered->isFile())
        {
            return false;
        }

        $content = file_get_contents($this->filtered);

        return $this->search($content,$filter['needle']);
    }

    /**
     * @param $filter
     * @return bool|\SplFileInfo
     */
    protected function ListByTypeFilter($filter)
    {
        if(!isset($filter['type']))
        {
            throw new \InvalidArgumentException('Please specify type as [file|dir]');
        }

        return $this->filtered->getType()==$filter['type']?$this->filtered:false;
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

            return !empty($found)?$this->filtered:false;
        }
        else
        {
            return $this->isMatch($content,$needle)?$this->filtered:false;
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