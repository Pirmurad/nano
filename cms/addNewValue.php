<?php
ob_start();
$path = '../';
include "{$path}config/conf.php";

if ($_SERVER["REQUEST_METHOD"] == "POST"):
    postextract(extract($_POST));

    if (empty($linkname)) {
        $linkname = $name;
    }
    $linkname = dolinkname($linkname, $unwanted_array);



        $lastorder = select("MAX(ordering)", "`value`", "`ordering`", "DESC")->fetch(PDO::FETCH_ASSOC);
        $order = $lastorder['MAX(ordering)'] + 1;
        $status = '1';

        $data = "`name` = ?,`linkname` = ?,`param_id` = ?,`ordering` = ?,`status` = ?";

        $sql = [
            $name,
            $linkname,
            $id,
            $order,
            $status
        ];
    $inserttype = insert("`value`", $data, $sql);
    if($inserttype) {

        $message ='Tebrikler! Əməliyyat uğurla yerinə yetirildi';
    }
    else {
        $message ='Problem baş verdi, dəyər əlavə olunmadı !';
    }
    $param = prepare("`linkname`","`type_param`","`id`=?",[$id])->fetch(PDO::FETCH_ASSOC);

    $new_value = prepare("`name`","`value`","`param_id`=?",[$id])->fetch(PDO::FETCH_ASSOC);


endif;
echo json_encode(array("response" => $message,'param'=>$param,'new_value' =>$new_value ));

ob_end_flush();