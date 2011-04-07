<?php

class Cache {

    public $adapter;

    function __construct($adapter) {
        $arguments = func_get_args();
        $adapter = array_shift($arguments);
        $reflection = new ReflectionClass(__CLASS__.'\Adapter\\'.$adapter);
        $this->adapter = $reflection->newInstanceArgs($arguments);
    }

    function __call($method, $arguments) {
        return call_user_func_array(array($this->adapter, $method), $arguments);
    }

}