<?php
ob_start();
$path='../';
include "{$path}config/conf.php";
if (!empty($_POST)){
    postextract(extract($_POST));
    if(empty($username) || empty($password)) {
        session_create(['error'=>'Bütün xanalar doldurulmalıdır']);
        redirect('login');
    }

//     $password = password_hash($password,PASSWORD_BCRYPT);
//     var_dump($password);exit;

    $admin = prepare("`username`,`password`,`role`","`admin`","`username`=?",[$username])->fetch(PDO::FETCH_ASSOC);

    if (password_verify($password,$admin['password'])){
        session_start();
        session_create(['admin'=>'ok','role'=>$admin['role']]);
        redirect('index.php');
    }else{
        session_create(['error_login'=>'Ad və ya parol səhvdir!']);
        redirect('login');
    }
}
ob_end_flush();
