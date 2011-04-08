<?php

namespace Cache {
    interface Adapter {

        function delete($key);
        function exists($key);
        function read($key);
        function write($key, $value);

    }
}