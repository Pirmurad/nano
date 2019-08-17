<?PHP
ob_start();
$path='../../../';
include_once "{$path}config/conf.php";
if (@$_POST) {
    $delimage = prepare("`image`","`" . post("value") . "`","`id`=?",[post('id')])->fetch(PDO::FETCH_ASSOC);
    if ($delimage['image']!=null){
        @unlink("{$path}uploads/banner/{$delimage['image']}");
        @unlink("{$path}uploads/banner/large/{$delimage['image']}");
        @unlink("{$path}uploads/banner/medium/{$delimage['image']}");
        @unlink("{$path}uploads/banner/little/{$delimage['image']}");
    }

    $delete = delete("`" . post("value") . "`", "`id`=?", [post('id')]);

    if ($delete){

        $response['status'] = 'success';

        $response['message'] = 'Müvəffəqiyyətlə silindi!';

    }else{

        $response['status'] = 'error';

        $response['message'] = 'Silmək alınmadı.';

    }
    echo json_encode($response);
}