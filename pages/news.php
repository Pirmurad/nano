<?PHP
ob_start();
$path = "../";
//include_once("{$path}top-cache.php");
include_once("{$path}config/conf.php");

$news = prepare("`id`,`name`,`linkname`,`data_create`,`description`,`image`","`news`","`status`=?",["1"])->fetchAll(PDO::FETCH_ASSOC);

$title = $product['title'];
$description = $product['description'];
$keyword = $product['keyword'];
$link='http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

include_once("{$path}inc/html_start.php");
include_once("{$path}inc/top_menu.php");
include_once("{$path}inc/header.php");
?>
<!-- simple product area start -->
<div class="simple-product-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="woocommerce-breadcrumb mtb-15">
                    <div class="menu">
                        <ul>
                            <li><a href="/">Ana Səhifə</a></li>
                            <li class="active">Xəbərlər</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <? foreach ($news as $n): ?>
            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                <div class="blog-wrapper bg-fff box-shadow mb-50">
                    <div class="blog-img mb-25">
                        <a href="xeber/<?= $n['id'] ?>/<?= $n['linkname'] ?>.html">
                            <img src="uploads/news/medium/<?= $n['image'] ?>" alt="<?= $n['name'] ?>">
                        </a>
                    </div>
                    <div class="blog-content">
                        <h3><a href="xeber/<?= $n['id'] ?>/<?= $n['linkname'] ?>.html"><?= $n['name'] ?></a></h3>
                        <div class="blog-meta">
                            <span><?= date("d M Y",$n['data_create']) ?></span>
                        </div>
                        <p><?= $n['description'] ?></p>
                    </div>
                </div>
            </div>
            <? endforeach; ?>
        </div>
    </div>
</div>
<?
include_once("{$path}inc/sponsor.php");
include_once("{$path}inc/order-area.php");
include_once("{$path}inc/footer.php");
include_once("{$path}inc/html_end.php");
//include_once("{$path}bottom-cache.php");

$out = ob_get_clean();
$out = preg_replace('/(?![^<]*<\/pre>)[\n\r\t]+/', "\n", $out);
$out = preg_replace('/ {2,}/', ' ', $out);
$out = preg_replace('/>[\n]+/', '>', $out);
echo $out;
?>