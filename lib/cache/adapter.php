<?php

namespace Cache {
    interface Adapter {

        function delete($key);
        function exists($key);
        function expired($key, $modified_at);
        function fetch($key, $block);
        function read($key);
        function write($key, $value);

    }
}