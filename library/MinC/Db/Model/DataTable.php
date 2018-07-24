<?php

namespace MinC\Db;

class DataTable  extends MinC_Db_Model
{
    protected $search;
    protected $start;
    protected $length;
    protected $order;

    /**
     * @return mixed
     */
    public function getSearch()
    {
        return $this->search;
    }

    /**
     * @param mixed $search
     * @return MinC_Db_Model
     */
    public function setSearch($search)
    {
        $this->search = $search;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getStart()
    {
        return $this->start;
    }

    /**
     * @param mixed $start
     * @return MinC_Db_Model
     */
    public function setStart($start)
    {
        $this->start = $start;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLength()
    {
        return $this->length;
    }

    /**
     * @param mixed $length
     * @return MinC_Db_Model
     */
    public function setLength($length)
    {
        $this->length = $length;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * @param mixed $order
     * @return MinC_Db_Model
     */
    public function setOrder($order)
    {
        $this->order = $order;
        return $this;
    }

}