<?php

function redirect($url, $time = 0){
    if ($time) header("Refresh: {$time}; url={$url}");
    else header("Location: {$url}");
}