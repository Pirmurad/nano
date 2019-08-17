<?PHP
ob_start();
$path='../../../../../';
include_once "{$path}config/conf.php";

if (@$_POST) {
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