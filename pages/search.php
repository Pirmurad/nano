<?PHP
ob_start();
$path = "../";
//include_once("{$path}top-cache.php");
include_once("{$path}config/conf.php");

$products = prepare("`id`,`linkname`,`name`,`image`,`price`,`description`,`note`","`product`","`name` LIKE ? AND `status`=?",["%".get('search')."%","1"],"`ordering`","DESC")->fetchAll(PDO::FETCH_ASSOC);

$title = $category['title'];
$description = $category['description'];
$keyword = $category['keyword'];
$link='http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

include_once("{$path}inc/html_start.php");
include_once("{$path}inc/top_menu.php");
include_once("{$path}inc/header.php");
?>
<div class="main-container shop-bg mt-35">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <h3 class="headpage">Axtarışın nəticəsi</h3>
                <div class="tab-area">
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active" id="tab1">
                            <div class="row">
                                <? foreach ($products as $product): ?>
                                    <div class="col-lg-15 col-md-15 col-sm-4 col-xs-12">
                                        <div class="category-wrapper mh290 bg-fff mb-30 br20">
                                            <div class="category-img product-img">
                                                <a href="mehsul/<?=$product['id']?>/<?=$product['linkname']?>.html">
                                                    <figure><img src="uploads/product/medium/<?=$product['image']?>" alt="<?=$product['name']?>" class="primary"/></figure>
                                                </a>
                                            </div>
                                            <div class="category-content">
                                                <h4><a href="mehsul/<?=$product['id']?>/<?=$product['linkname']?>.html"><?=$product['name']?></a></h4>
                                                <span><?=$product['price']?><span class="jisazn">M</span></span>
                                                <? if (!empty($product['note'])): ?>
                                                    <h5><i class="fas fa-gift fa-fw"></i><?= $product['note'] ?></h5>
                                                <? endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                <? endforeach;  ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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