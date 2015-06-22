<?php

class Response
{

    public static function asJson($data)
    {
        $string = json_encode($data, JSON_FORCE_OBJECT);
        return $string;
    }
}