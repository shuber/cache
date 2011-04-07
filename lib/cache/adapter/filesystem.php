<?php

namespace Cache\Adapter {
    class Filesystem implements \Cache\Adapter {

        public $extension;
        public $path;

        function __construct($path = '/tmp', $extension = '.json') {
            $this->path = $path;
            $this->extension = $extension;
            $this->create_cache_directory();
        }

        function delete($key) {
            if ($this->exists($key)) return unlink($this->filename_for_key($key));
        }

        function exists($key) {
            $filename = $this->filename_for_key($key);
            return file_exists($filename) ? filemtime($filename) : false;
        }

        function expired($key, $modified_at) {
            return ($cache_modified_at = $this->exists($key)) && $cache_modified_at < $modified_at;
        }

        function fetch($key, $block) {
            if ($this->exists($key)) {
                $value = $this->read($key);
            } else {
                $value = $block();
                $this->write($key, $value);
            }
            return $value;
        }

        function read($key) {
            return json_decode(file_get_contents($this->filename_for_key($key)));
        }

        function write($key, $value) {
            $file = $this->filename_for_key($key);
            return file_put_contents($file, json_encode($value));
        }

        protected function create_cache_directory() {
            if (!file_exists($this->path)) mkdir($this->path, 0755, true);
        }

        protected function filename_for_key($key) {
            return $this->path.DIRECTORY_SEPARATOR.$key.$this->extension;
        }

    }
}