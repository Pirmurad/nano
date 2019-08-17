<?PHP
ob_start();
$path = "";
//include_once("{$path}top-cache.php");
include_once("{$path}config/conf.php");

$menu = prepare("`title`,`keyword`,`description`","`menyu`","`linkname`=? AND `status`=?",[get('linkname'),"1"])->fetch(PDO::FETCH_ASSOC);

$title = "Nano Electronics";
$description = "Nano Electronics - mobil telefonlar, məişət texnikası və elektronika Bakıda almaq, kreditlə, pulsüz çatdırılma ilə";
$keyword = "mobil telefonlar,məişət texnikası,elektronika,telefon satisi,";
$link='http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

include_once("{$path}inc/html_start.php");
include_once("{$path}inc/top_menu.php");
include_once("{$path}inc/header.php");
include_once("{$path}inc/slider.php");
//include_once("{$path}inc/banner.php");
include_once("{$path}inc/product.php");
include_once("{$path}inc/product_tab.php");
include_once("{$path}inc/banner2.php");
include_once("{$path}inc/blog.php");
include_once("{$path}inc/sponsor.php");
//include_once("{$path}inc/order-area.php");
include_once("{$path}inc/footer.php");
include_once("{$path}inc/html_end.php");
//include_once("{$path}bottom-cache.php");

//$out = ob_get_clean();
//$out = preg_replace('/(?![^<]*<\/pre>)[\n\r\t]+/', "\n", $out);
//$out = preg_replace('/ {2,}/', ' ', $out);
//$out = preg_replace('/>[\n]+/', '>', $out);
//echo $out;
?>