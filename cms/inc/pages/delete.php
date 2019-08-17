<?PHP
ob_start();
$path='../../../';
include_once "{$path}config/conf.php";
include_once "{$path}helper/func.php";
include_once "../../pages/html_start.php";

if (!empty(get('id'))) {
    delete("`pages`","`id`=?",[get('id')]);
    redirect("pages/list/");
}