<?php

namespace Cache\Adapter {
    class Memory implements \Cache\Adapter {

        public $storage = array();

        function delete($key) {
            unset($this->storage[$key]);
            return true;
        }

        function exists($key) {
            return isset($this->storage[$key]) ? $this->storage[$key]['modified_at'] : false;
        }

        function read($key) {
            return $this->storage[$key]['value'];
        }

        function write($key, $value) {
            $this->storage[$key] = array('value' => $value, 'modified_at' => time());
            return $value;
        }

    }
}