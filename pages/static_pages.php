<?PHP
ob_start();
$path = "../";
include_once("{$path}config/conf.php");

$menu = prepare("`title`,`description`,`keyword`,`name`,`text`","`menyu`","`linkname`=? AND `status`=?",[get('linkname'),"1"])->fetch(PDO::FETCH_ASSOC);

if (empty($menu)){redirect('/');}

$title = $menu['title'];
$description = $menu['description'];
$keyword = $menu['keyword'];
$link='http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

include_once("{$path}inc/html_start.php");
include_once("{$path}inc/top_menu.php");
include_once("{$path}inc/header.php");
?>
<!-- about-area start -->
<div class="about-main-area shop-bg">
    <div class="about-title-area ptb-50 bg-img mb-50">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="about-heading">
                        <h1><?=$menu['name']?></h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="about-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="about-content mb-30">
                        <p><?= htmlspecialchars_decode($menu['text']); ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- brand-area end -->
</div>
 <!-- about-area end -->
 <?
include_once("{$path}inc/footer.php");
include_once("{$path}inc/html_end.php");

$out = ob_get_clean();
$out = preg_replace('/(?![^<]*<\/pre>)[\n\r\t]+/', "\n", $out);
$out = preg_replace('/ {2,}/', ' ', $out);
$out = preg_replace('/>[\n]+/', '>', $out);
echo $out;
?>