<?php
ob_start();
$path = "../";
include_once "{$path}config/conf.php";
include_once "{$path}config/csrf.class.php";

$csrf = new csrf();

// Generate Token Id and Valid
$token_id = $csrf->get_token_id();
$token_value = $csrf->get_token($token_id);
if($csrf->check_valid('post')) {
    postextract(extract($_POST));
    $informationfetch = prepare("`mail`","`information`","`id`=?",["1"])->fetch(PDO::FETCH_ASSOC);

    // Check for empty fields
    if(empty($_POST['name']) || empty($_POST['mail']) || empty($_POST['message']) || !filter_var($_POST['mail'],FILTER_VALIDATE_EMAIL)){
        echo "Xanalar boş ola bilməz!";
        redirect($_SERVER['HTTP_REFERER'],"5");
    }

    // Create the email and send the message
    $to = $informationfetch['mail']; // Add your email address inbetween the '' replacing yourname@yourdomain.com - This is where the form will send a message to.
    $email_subject = "Veb saytdan göndərən şəxsin adı:  $name";
    $email_body = "Sizin veb saytından gələn mesajınız var.\n\n"."Detalları:\n\nAdı: $name\n\nTelefonu: $phone\n\nMövzu: $subject\n\nE-poçt ünvanı: $mail\n\nMesajı:\n$message";
    $headers = "Bu mesaj avtomatik göndərilmişdir,cavab yazmağa ehtiyac yoxdur\n";
    $headers .= "Göndərən: $mail";
    $send = mail($to,$email_subject,$email_body,$headers);
    if ($send == true) {
        $_SESSION['success'] = 'Mesajınız müvəffəqiyyətlə göndərilmişdir';
        if (!empty($_SESSION['inputs'])) {
            unset($_SESSION['inputs']);
        }
        redirect($_SERVER['HTTP_REFERER']);
    } else {
        $errors['errors'] = 'Bir problem baş verdi,mesajınız göndərilmədi';
        $_SESSION['errors'] = $errors;
        $_SESSION['inputs'] = $arr_input;

        redirect($_SERVER['HTTP_REFERER']);
    }
} else {
    $errors['errors'] = 'CSRF attak qəbul edilmir !';
    $_SESSION['errors'] = $errors;
    $_SESSION['inputs'] = $arr_input;

    redirect($_SERVER['HTTP_REFERER']);
}
ob_end_flush();
?>