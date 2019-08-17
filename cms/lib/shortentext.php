<?php

function shortentext($text, $str = 10)
{
    if (strlen($text) > $str)
    {
        if (function_exists("mb_substr")) $kelime = mb_substr($text, 0, $str, "UTF-8").'..';
        else $kelime = substr($text, 0, $str).'..';
    }
    return $text;
}