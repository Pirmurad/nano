<?PHP
ob_start();
$path='../../../';
include_once "{$path}config/conf.php";
include_once "{$path}helper/func.php";
include_once "../../pages/html_start.php";
if (isset($_GET['id'])) {
    $delimage = prepare("`image`","`themes`","`id`=?",[get('id')]);
    $delimage = $delimage[0];
    if ($delimage['image']!=null){
        @unlink("{$path}uploads/themes/{$delimage['image']}");
    }
    delete("`themes`","`id`=?",[get('id')]);
    redirect("themes/list/");
}