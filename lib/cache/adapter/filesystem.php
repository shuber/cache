<?php

namespace Cache\Adapter {
    class Filesystem implements \Cache\Adapter {

        public $extension;
        public $path;

        function __construct($path = '/tmp', $extension = '.json') {
            $this->path = $path;
            $this->extension = $extension;
        }

        function delete($key) {
            return unlink($this->file_for_key($key));
        }

        function exists($key) {
            $file = $this->file_for_key($key);
            return file_exists($file) ? filemtime($file) : false;
        }

        function read($key) {
            return json_decode(file_get_contents($this->file_for_key($key)));
        }

        function write($key, $value) {
            $file = $this->file_for_key($key);
            $this->create_cache_directory($file);
            file_put_contents($file, json_encode($value));
            chmod($file, 0777);
            return $value;
        }

        protected function create_cache_directory($file) {
            $dir = dirname($file);
            if (!file_exists($dir)) mkdir($dir, 0777, true);
        }

        protected function file_for_key($key) {
            return $this->path.DIRECTORY_SEPARATOR.$key.$this->extension;
        }

    }
}