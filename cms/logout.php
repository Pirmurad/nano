<?php
ob_start();
$path='../';
include_once "{$path}config/conf.php";
session_destroy();
redirect('/cms/login.php');