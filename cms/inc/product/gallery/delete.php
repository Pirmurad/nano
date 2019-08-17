<?PHP
ob_start();
$path='../../../../';
include_once "{$path}config/conf.php";
if (isset($_GET['id'])) {
    $delimage = prepare("`image`","`gallery`","`id`=?",[get('id')])->fetch(PDO::FETCH_ASSOC);
    if ($delimage['image']!=null){
        @unlink("{$path}uploads/gallery/{$delimage['image']}");
        @unlink("{$path}uploads/gallery/large/{$delimage['image']}");
        @unlink("{$path}uploads/gallery/medium/{$delimage['image']}");
        @unlink("{$path}uploads/gallery/little/{$delimage['image']}");
    }
    delete("`gallery`","`id`=?",[get('id')]);
    redirect('product/'.$_GET['id'].'/gallery/list/');
}