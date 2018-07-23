<?php

class MinC_Db_Model
{

    protected $search;
    protected $start;
    protected $length;
    protected $draw;
    protected $order;
    protected $columns;



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
    public function getDraw()
    {
        return $this->draw;
    }

    /**
     * @param mixed $draw
     * @return MinC_Db_Model
     */
    public function setDraw($draw)
    {
        $this->draw = $draw;
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

    /**
     * @return mixed
     */
    public function getColumns()
    {
        return $this->columns;
    }

    /**
     * @param mixed $columns
     * @return MinC_Db_Model
     */
    public function setColumns($columns)
    {
        $this->columns = $columns;
        return $this;
    }

    public function __construct(array $options = null)
    {
        if (is_array($options)) {
            $this->setOptions($options);
        }
    }

    public function __set($name, $value)
    {
        $method = 'set' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid agentes property');
        }
        $this->$method($value);
    }

    public function __get($name)
    {
        $method = 'get' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid agentes property');
        }
        return $this->$method();
    }

    public function setOptions(array $options)
    {
        $methods = get_class_methods($this);
        foreach ($options as $key => $value) {
            foreach ($methods as $methodKey => $method) {
                $metodoTratado = 'set' . strtolower(str_replace(
                        '_',
                        '',
                        $key
                    ));
                if (strtolower($method) == $metodoTratado) {
                    $this->$method($value);
                }
            }
        }
        return $this;
    }

    public function toArray()
    {
        $methods = get_class_methods($this);
        $class_vars = get_class_vars(get_class($this));
        $array = array();
        foreach ($class_vars as $key => $value) {
            $key = str_replace('_', '', $key);
            $method = 'get' . ucfirst($key);
            if (in_array($method, $methods)) {
                $array[$key] = $this->$method();
            }
        }

        return $array;
    }

}