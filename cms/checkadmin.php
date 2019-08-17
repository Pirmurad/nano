<?php
ob_start();

include "{$path}config/conf.php";

if(session('role')!='admin'){
    redirect('index.php');
}

ob_end_flush();
