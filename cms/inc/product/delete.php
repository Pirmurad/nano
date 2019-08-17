<?PHP
ob_start();
$path='../../../';
$imagepath='../../';
include_once "{$path}config/conf.php";
include_once "{$imagepath}checkadmin.php";

if (@$_POST) {
    $delimage = prepare("`image`","`".post("value")."`","`id`=?",[post('id')])->fetch(PDO::FETCH_ASSOC);
    if ($delimage['image']!=null){
        @unlink("{$path}uploads/".post("value")."/{$delimage['image']}");
        @unlink("{$path}uploads/".post("value")."/large/{$delimage['image']}");
        @unlink("{$path}uploads/".post("value")."/medium/{$delimage['image']}");
        @unlink("{$path}uploads/".post("value")."/little/{$delimage['image']}");
    }
    $delete = delete("`".post("value")."`","`id`=?",[post('id')]);
    if ($delete){
        $response['status'] = 'success';
        $response['message'] = 'Müvəffəqiyyətlə silindi!';
    }else{
        $response['status'] = 'error';
        $response['message'] = 'Silmək alınmadı.';
    }
    echo json_encode($response);
}