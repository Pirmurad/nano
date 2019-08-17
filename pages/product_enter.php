<?PHP
ob_start();
$path = "../";
//include_once("{$path}top-cache.php");
include_once("{$path}config/conf.php");

$product = prepare("*","`product`","`id`=? AND `linkname`=? AND `status`=?",[get('id'),get('name'),"1"])->fetch(PDO::FETCH_ASSOC);
$param = json_decode($product['param'],true);
$gallery = prepare("`image`,`id`","`gallery`","`product_id`=?",[$product['id']])->fetchAll(PDO::FETCH_ASSOC);
$kredit = prepare("`note`","`kredit`","`id`=?",[$product['kredit_id']])->fetch(PDO::FETCH_ASSOC);

update("`product`","`view_count`=?","`id`=?",[++$product['view_count'],$product['id']]);

$params   =  prepare("`id`,`name`,`linkname`","`type_param`","`type_id`=?",[$product['type_id']],"`ordering`","ASC")->fetchAll(PDO::FETCH_ASSOC);

$category = prepare("`name`,`linkname`","`category`","`id`=?",[$product['category_id']])->fetch(PDO::FETCH_ASSOC);

$kredit_product = prepare("*","`kredit_product`","`kredit_id`!=? AND `product_id`=?",["0",get('id')])->fetch(PDO::FETCH_ASSOC);

$skredit_product = prepare("*","`kredit_product`","`name`!=? AND `product_id`=?",["",$product['id']])->fetch(PDO::FETCH_ASSOC);

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
                                <li><a href="/kateqoriya/<?= $category['linkname'] ?>"><?= $category['name'] ?></a></li>
                                <li class="active"><?= $product['name'] ?></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <form action="pages/product_buy.php" method="get" id="product-buy">
                <div class="col-lg-9">
                    <div class="row">
                        <div class="col-lg-5">
                            <div class="symple-product">
                                <div class="single-product-tab  box-shadow mb-20">
                                    <div class="tab-content">
                                        <? if (!empty($gallery)): foreach ($gallery as $key=>$g): ?>
                                        <div role="tabpanel" class="tab-pane <?= ($key==0) ? 'active' : '' ?>" id="<?= $g['id'] ?>">
                                            <a class="popup" href="javascript:void(0)">
                                                <img src="../uploads/gallery/large/<?= $g['image'] ?>" alt="<?= $product['name'] ?>" class="zoomImg"/>
                                            </a>
                                        </div>
                                        <? endforeach;else: ?>
                                        <div role="tabpanel" class="tab-pane active">
                                            <a class="popup" href="javascript:void(0)">
                                                <img src="../uploads/product/large/<?= $product['image'] ?>" alt="<?= $product['name'] ?>" class="zoomImg"/>
                                            </a>
                                        </div>
                                        <? endif; ?>
                                    </div>
                                </div>
                                <div class="single-product-menu mb-30 box-shadow">
                                    <div class="single-product-active clear owl-carousel owl-theme owl-loaded">
                                        <? foreach ($gallery as $key=>$g): ?>
                                        <div class="owl-item <?= ($key<3) ? 'active' : '' ?>">
                                            <div class="single-img floatleft">
                                                <a href="#<?= $g['id'] ?>" data-toggle="tab">
                                                    <img src="/uploads/gallery/medium/<?= $g['image'] ?>" alt="<?= $product['name'] ?>">
                                                </a>
                                            </div>
                                        </div>
                                        <? endforeach; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-5">
                            <div class="symple-product">
                                <? if (!empty($skredit_product)): ?>
                                    <div class="categories-area box-shadow bg-fff br20">
                                        <div class="product-title br12 home2-bg-1 text-uppercase home2-product-title">
                                            <div class="icon bg-1 br1"><i class="fas fa-bookmark"></i></div>
                                            <h3><?= $skredit_product['name'] ?></h3>
                                        </div>
                                        <div class="shop-categories-menu">
                                            <div id="specs-list" class="compare-specs-list">
                                                <table cellspacing="0">
                                                    <tbody>
                                                    <tr>
                                                        <td class="ttl"></td>
                                                        <td class="ttl">Müddət</td>
                                                        <td class="ttl">İlkin ödəniş</td>
                                                        <td class="nfo" data-spec="nettech">
                                                            Aylıq ödəniş
                                                        </td>
                                                    </tr>
                                                    <? foreach (json_decode($skredit_product['ay'],true) as $key=>$ay): ?>
                                                        <? if (!empty($ay[$key])): ?>
                                                            <tr>
                                                                <td class="ttl"><input type="radio" name="product" value="xt-<?= $key+1 ?>"></td>
                                                                <td class="ttl"><?= ++$key." ay" ?></td>
                                                                <td class="ttl"><?= $skredit_product['ilkin_odenis'] ?> <span class="jisazn">M</span></td>
                                                                <td class="nfo" data-spec="nettech">
                                                                    <?= $ay[--$key] ?> <span class="jisazn">M</span>
                                                                </td>
                                                            </tr>
                                                        <? endif;  ?>
                                                    <? endforeach;?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                <? endif; ?>
                                <? if (!empty($kredit_product)): ?>
                                    <div class="categories-area box-shadow bg-fff br12">
                                        <div class="product-title br12 home2-bg-1 text-uppercase home2-product-title">
                                            <div class="icon bg-1 br1"><i class="fas fa-bookmark"></i></div>
                                            <h3>Hissə-hissə ödəniş şərtləri</h3>
                                        </div>
                                        <div class="shop-categories-menu">
                                            <div id="specs-list" class="compare-specs-list">
                                                <table cellspacing="0" class="table-responsive table-hover">
                                                    <tbody>
                                                    <tr>
                                                        <td class="ttl"></td>
                                                        <td class="ttl">Müddət</td>
                                                        <td class="ttl">İlkin ödəniş</td>
                                                        <td class="ttl nfo" data-spec="nettech">
                                                            Aylıq ödəniş
                                                        </td>
                                                    </tr>

                                                    <? foreach (json_decode($kredit_product['ay'],true) as $key=>$ay): ?>

                                                        <? if (!empty($ay[$key])): ?>
                                                            <tr>
                                                                <td class="ttl"><input type="radio" name="product" value="hh-<?= $key+1 ?>" required></td>
                                                                <td class="ttl"><?= ++$key." ay" ?> <?= (in_array($key,explode(",",$kredit_product['faizsiz']))) ? '<span style="color: #F4473A;font-weight: bold;font-family: Avant Garde, Avantgarde, Century Gothic, CenturyGothic, AppleGothic, sans-serif;margin-left: 5px;font-size:15px;">0</span><img src="https://img.icons8.com/color/18/000000/discount.png" alt="percentage" style="margin-top: -5px;">' : '' ?></td>
                                                                <td class="nfo"><?= $kredit_product['ilkin_odenis'] ?> <span class="jisazn">M</span></td>
                                                                <td class="nfo" data-spec="nettech">
                                                                    <?= $ay[--$key] ?> <span class="jisazn">M</span>
                                                                </td>
                                                            </tr>
                                                        <? endif;  ?>
                                                    <? endforeach;?>
                                                    </tbody>
                                                </table>
                                                <input type="hidden" name="id" value="<?= $product['id'] ?>">
                                                <input type="hidden" name="name" value="<?= $product['linkname'] ?>">
                                            </div>
                                        </div>
                                    </div>
                                <? endif;if (!empty($kredit_product) || !empty($skredit_product)): ?>
                                <button type="submit" id="hisse-hisse-ode" class="btn-white btn br20 w100 mtb-10">
                                    <img src="/img/sifaris.png" alt="sifaris et"> HİSSƏ-HİSSƏ ÖDƏNİŞLƏ SİFARİŞ
                                </button>
                                <? endif; ?>
                                <div class="product_meta">
                                    <div class="footer-content share-product pt-15 text-uppercase">
                                        <p>Məhsulu paylaş:</p>
                                        <ul class="list-inline">
                                            <li>
                                                <a href="https://www.facebook.com/sharer/sharer.php?u=<?= $link ?>" data-toggle="tooltip" title="Facebook" target="_blank"><i class="fab fa-facebook-square fs18"></i></a>
                                            </li>
                                            <li>
                                                <a href="https://twitter.com/intent/tweet?url=<?= $link ?>&text=<?= $product['name'] ?>" data-toggle="tooltip" title="Twitter" target="_blank"><i class="fab fa-twitter-square fs18"></i></a>
                                            </li>
                                            <li>
                                                <a href="https://plus.google.com/share?url=<?= $link ?>" data-toggle="tooltip" title="Google-Plus" target="_blank"><i class="fab fa-google-plus-square fs18"></i></a>
                                            </li>
                                            <li>
                                                <a href="https://api.whatsapp.com/send?text=<?= $product['name'] ?> - <?= $link ?>" data-toggle="tooltip" title="Whatsapp" target="_blank"><i class="fab fa-whatsapp-square fs18"></i></a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <? if ($product['eprice']!=0): ?>
                            <div class="btn-white btn br20 w100">
                                <span>
                                    <del style="font-size: 20px;"><?= $product['eprice'] ?><span class="jisazn">M</span></del>
                                </span>
                            </div>
                            <? endif; ?>
                            <div class="btn-white btn br20 w100 h90 mt-10" style="background-color: #e0dddd52;border-width: 3px;">
                                <span>
                                    <span style="font-size: 32px;color: #000;font-family: fantasy;"><?= $product['price'] ?><span class="jisazn" style="font-size: 32px;color: #000;font-weight: bold;font-size: 20px !important;display: block;">M</span></span>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="row mtb-20">
                        <div class="col-lg-12">
                            <div class="simple-product-tab box-shadow">
                                <div class="simple-product-tab-menu clear">
                                    <ul>
                                        <li class="active"><a href="#description" data-toggle="tab">Məhsul Haqqında</a></li>
                                        <li><a href="#reviews" data-toggle="tab">Rəylər</a></li>
                                    </ul>
                                </div>
                                <div class="tab-content  bg-fff">
                                    <div class="tab-pane active" id="description">
                                        <div class="product-description p-20 bt">
                                            <h2><strong><?= $product['name'] ?></strong> Texniki göstəriciləri</h2>
                                            <div id="specs-list" class="compare-specs-list col-md-12 mb-20">
                                                <table cellspacing="0">
                                                    <tbody>
                                                    <? foreach ($params as $par): ?>
                                                        <tr>

                                                            <td class="ttl"><?= $par['name'] ?></td>
                                                            <td class="nfo" data-spec="nettech">
                                                                <? if(!empty($param)){ foreach ($param as $p1){
                                                                    if ($p1[$par['linkname']] != NULL){
                                                                        echo $p1[$par['linkname']];
                                                                    };
                                                                }} ?>
                                                            </td>
                                                        </tr>
                                                    <? endforeach; ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="reviews">
                                        <div class="product-reviews p-20 bt">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="review-form form-style">
                                                        <div class="fb-comments" data-href="<?=$link?>" data-width="100%"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <? $products = prepare("`name`,`id`,`linkname`,`note`,`price`,`eprice`,`image`","`product`","`category_id`=? AND `id`!=? AND `status`=?",[$product['category_id'],$product['id'],"1"],"`data_create`","DESC","LIMIT 15")->fetchAll(PDO::FETCH_ASSOC);
                    if (!empty($products)): ?>
                        <div class="product box-shadow bg-fff br20 mtb-50" id="related_product">
                            <div class="product-title home2-bg-1 text-uppercase home2-product-title br12">
                                <div class="icon bg-1 br1"><i class="fas fa-box"></i></div>
                                <h3>Bənzər məhsullar</h3>
                            </div>
                            <div class="new-product-active left-right-angle home2">
                                <? foreach ($products as $p):?>
                                    <div class="product-wrapper bl">
                                        <h3><a href="mehsul/<?= $p['id'] ?>/<?= $p['linkname'] ?>.html"></a></h3>
                                        <div class="product-img">
                                            <a href="mehsul/<?= $p['id'] ?>/<?= $p['linkname'] ?>.html">
                                                <figure>
                                                    <img src="uploads/product/large/<?= $p['image'] ?>" alt="<?= $p['name'] ?>"/>
                                                </figure>
                                            </a>
                                        </div>
                                        <div class="product-content">
                                            <div class="product-price">
                                                <span><?= (!empty($p['price'])) ? $p['price'] : $p['eprice'] ?> <span class="AZN">M</span></span>
                                                <? if (!empty($p['note'])): ?>
                                                    <h5><i class="fas fa-gift fa-fw"></i><?= $p['note'] ?></h5>
                                                <? endif; ?>
                                            </div>
                                            <div class="product-process">
                                                <a href="mehsul/<?= $p['id'] ?>/<?= $p['linkname'] ?>.html" class="btn btn-default productbutton">Hissə-hissə al</a>
                                                <a href="mehsul/<?= $p['id'] ?>/<?= $p['linkname'] ?>.html" class="btn btn-default productbutton">Məhsula keç</a>
                                            </div>
                                        </div>
                                    </div>
                                <? endforeach; ?>
                            </div>
                        </div>
                    <? endif; ?>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                    <a href="muqayise.php?type_id=<?= $product['type_id'] ?>&id1=<?= $product['id'] ?>" class="btn-white btn br20 w100 mb-10">
                        <img src="/img/muqayise.png" alt="muqayise et"> MÜQAYİSƏ ET
                    </a>

                    <a href="mehsul/<?= get('id')?>/<?= get('name') ?>/sifaris-et/" class="btn-white btn br20 w100 mb-30">
                        <img src="/img/sifaris.png" alt="muqayise et"> NAĞD AL
                    </a>
                    <h5><i><?= $kredit['note'] ?></i></h5>
                    <br>
                    <? if (!empty($product['note'])): ?>
                        <h5 class="effecttext"><i class="fas fa-gift fa-fw"></i><?= $product['note'] ?></h5>
                    <? endif; ?>
                </div>
                </form>
            </div>
        </div>
    </div>
    <!-- simple product area end -->
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