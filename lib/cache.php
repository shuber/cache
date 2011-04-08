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

    function expired($key, $modified_at) {
        return $cache_modified_at = $this->adapter->exists($key) && $cache_modified_at < $modified_at;
    }

    function fetch($key, $modified_at, $block = null) {
        if (is_a($modified_at, 'Closure')) {
            $block = $modified_at;
            $modified_at = false;
        }
        if (($cache_modified_at = $this->adapter->exists($key)) && (!$modified_at || $cache_modified_at >= $modified_at)) {
            $value = $this->adapter->read($key);
        } else {
            $value = $this->adapter->write($key, $block());
        }
        return $value;
    }

}