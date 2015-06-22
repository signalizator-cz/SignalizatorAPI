<?php

class Router
{

    static public function get($param, $default = null)
    {
        return isset($_GET[$param]) ? $_GET[$param] : $default;
    }
}