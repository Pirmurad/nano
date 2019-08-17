<?PHP
ob_start();
$path='../';
include_once "{$path}config/conf.php";
include_once "{$path}config/csrf.class.php";

$csrf = new csrf();

// Generate Token Id and Valid
$token_id = $csrf->get_token_id();
$token_value = $csrf->get_token($token_id);
if($csrf->check_valid('post')) {

    $insertsubscribe = $db->prepare("INSERT INTO `subscribeme` SET `mail`=:mail,`datepicker`=:datepicker");
    $insertsubscribe->execute(array(":mail" => post('mail'), ":datepicker" => time()));

    if ($insertsubscribe) {
        $success['success'] = 'Müvəffəqiyyətlə əlavə olundu !';
        $_SESSION['success'] = $success;
        echo '<META HTTP-EQUIV=REFRESH CONTENT="0; /">';
        exit();
    } else {
        $errors['errors'] = 'Problem baş verdi, əlavə olunmadı !';
        $_SESSION['errors'] = $errors;
        echo '<META HTTP-EQUIV=REFRESH CONTENT="0; /">';
        exit();
    }
}

ob_end_flush();
?>