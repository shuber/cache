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
            if ($this->exists($key)) return unlink($this->filename_for_key($key));
        }

        function exists($key) {
            $filename = $this->filename_for_key($key);
            return file_exists($filename) ? filemtime($filename) : false;
        }

        function expired($key, $modified_at) {
            return $modified_at && $cache_modified_at = $this->exists($key) && $cache_modified_at < $modified_at;
        }

        function fetch($key, $modified_at = false, $block = null) {
            if (is_a($modified_at, 'Closure')) {
                $block = $modified_at;
                $modified_at = false;
            }
            if (($cache_modified_at = $this->exists($key)) && (!$modified_at || $cache_modified_at >= $modified_at)) {
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
            $this->create_cache_directory($file);
            return file_put_contents($file, json_encode($value));
        }

        protected function create_cache_directory($file) {
            $dir = dirname($file);
            if (!file_exists($dir)) mkdir($dir, 0755, true);
        }

        protected function filename_for_key($key) {
            return $this->path.DIRECTORY_SEPARATOR.$key.$this->extension;
        }

    }
}