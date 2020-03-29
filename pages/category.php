<?PHP
ob_start();
$path = "../";
//include_once("{$path}top-cache.php");
include_once("{$path}config/conf.php");

$category = prepare("*","`category`","`linkname`=? AND `status`=?",[get('linkname'),"1"])->fetch(PDO::FETCH_ASSOC);

$brand_type = prepare("`brand_id`","`brand_type`","`type_id`=?",[$category['type_id']])->fetchAll(PDO::FETCH_ASSOC);

$cat = prepare("`id`","`category`","`parent_id`=? AND `status`=?",[$category['id'],"1"])->fetch(PDO::FETCH_ASSOC);


$prepare =	"";
$execute =	[];

if(!empty($_GET['min_price']) || !empty($_GET['max_price'])) {

    $prepare .="`price` BETWEEN ? AND ?  AND";
    array_push($execute, $_GET['min_price'], $_GET['max_price']);
}

if(!empty($_GET['brand_id'])) {

    $brandId=implode(',',$_GET['brand_id']);

    $prepare .="`brand_id` IN (".$brandId.")  AND";
}

if (!empty($_GET['orderby'])){
    $order = explode("-",$_GET['orderby']);
    $o = $order['0'];
    $orderType = $order['1'];

    if ($o=='view'){ $orderingBy = "view_count";}
    if ($o=='date'){ $orderingBy = "data_create";}
    if ($o=='price'){ $orderingBy = "price";}
}

if (empty($orderingBy) && empty($orderType)){
    $orderingBy='ordering';
    $orderType='DESC';
}

$prepare .=" `category_id`=? AND `status`=? GROUP BY id ";
array_push($execute, $category['id'],"1");

$perpage=12;
if (get("pagination")) { $page_number  = intval(get("pagination")); } else { $page_number=1; };
$start_from = ($page_number>1)?($page_number * $perpage)-$perpage:0;

$products = prepare("`id`,`linkname`,`name`,`image`,`price`,`description`,`note`","`product`",$prepare,$execute,$orderingBy,$orderType,"LIMIT $start_from,$perpage")->fetchAll(PDO::FETCH_ASSOC);

$product_count = prepare("COUNT(id)","`product`","`category_id`=? AND `status`=?",[$category['id'],"1"])->fetch(PDO::FETCH_ASSOC);

$productspr = prepare("MAX(price) AS idd,`id`,`linkname`,`name`,`image`,`price`,`description`","`product`","`category_id`=? AND `status`=? GROUP BY id",[$category['id'],"1"],"`ordering`","DESC")->fetchAll(PDO::FETCH_ASSOC);
$maxprice = 0;
for($i=0;$i<$product_count['COUNT(id)'];$i++){
    foreach ($productspr as $p){
        if ($maxprice<$p['idd']){
            $maxprice = $p['idd'];
        }
    }
}

$total_records = $product_count['COUNT(id)'];
$total_pages = ceil($total_records / $perpage);
if (empty($total_pages)){$total_pages=1;}
if($page_number>$total_pages){redirect('/kateqoriya/'.get('linkname').'/');}
$viewpagecount = 6;

$title = $category['title'];
$description = $category['description'];
$keyword = $category['keyword'];
$link='http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

include_once("{$path}inc/html_start.php");
include_once("{$path}inc/top_menu.php");
include_once("{$path}inc/header.php");


?>
<div class="main-container shop-bg">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="woocommerce-breadcrumb mtb-15">
                    <div class="menu">
                        <ul>
                            <li><a href="/">Ana Səhifə</a></li>
                            <li class="active"><?= $category['name'] ?></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div id="filters" class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                <form action="" method="GET">
                    <button type="submit" class="btn btn-block btn-primary mb-10">
                        Filter et
                    </button>
                    <? if($total_records != 0): ?>
                        <!-- filter-by-price-area start -->
                        <div class="filter-by-price-area bg-fff box-shadow br20">
                            <div class="category-title home2-bg-1 text-uppercase home2-category-title br12">
                                <div class="icon bg-1 br1 fl"><i class="fas fa-filter"></i></div>
                                <h3>Qiymətə görə filter</h3>
                            </div>
                            <div class="filter-by-price p-20-15">
                                <p>
                                    Qiymət: <input type="text" id="amount" name="amount" disabled>
                                </p>
                                <input type="hidden" name="category_id" value="<?= $category['id'] ?>">
                                <input type="hidden" name="type_id" value="<?= $category['type_id'] ?>">
                                <input type="hidden" name="min_price" id="min_price" value="<?= isset($_GET['min_price']) ? $_GET['min_price'] : 0 ?>">
                                <input type="hidden" name="max_price" id="max_price" value="<?= isset($_GET['max_price']) ? $_GET['max_price'] : $maxprice ?>">
                                <div id="slider-range"></div>
                            </div>
                        </div>
                    <? endif; if (!empty($brand_type)): ?>
                        <!-- categories-area start -->
                        <div class="categories-area mtb-30 box-shadow bg-fff br20 <?= ($total_records == 0) ? 'mb-30' : ''; ?>">
                            <div class="category-title home2-bg-1 text-uppercase home2-category-title br12">
                                <div class="icon bg-1 br1 fl"><i class="fas fa-bookmark"></i></div>
                                <h3>Brendlər</h3>
                            </div>
                            <div class="shop-categories-menu brandfilter">
                                <ul>
                                    <? foreach ($brand_type as $b):
                                        $brand = prepare("`id`,`name`","`brand`","`id`=?",[$b['brand_id']])->fetch(PDO::FETCH_ASSOC);?>
                                        <li>
                                            <label id="<?= $brand['id'] ?>" class="brand">
                                                <input <?=!empty($_GET['brand_id']) ? in_array($brand['id'], get('brand_id')) ? 'checked' : '' :'' ?> type="checkbox" value="<?= $brand['id'] ?>" name="brand_id[]">
                                                <span><?= $brand['name'] ?></span>
                                            </label>
                                        </li>
                                    <? endforeach;  ?>
                                </ul>
                            </div>
                        </div>
                    <? endif; if (!empty($category['type_id']=='1')): ?>

                    <? endif; if (!empty($cat)): ?>
                        <!-- categories-area start -->
                        <div class="categories-area box-shadow mtb-30 bg-fff br20 <?= ($total_records == 0) ? 'mb-30' : ''; ?>">
                            <div class="category-title home2-bg-1 text-uppercase home2-category-title br12">
                                <div class="icon bg-1 br1 fl"><i class="fas fa-bookmark"></i></div>
                                <h3>Alt Kateqoriyalar</h3>
                            </div>
                            <div class="shop-categories-menu p-20">
                                <ul>
                                    <?= multilevelCat("`category`",$category['id'],get('linkname'),0); ?>
                                </ul>
                            </div>
                        </div>
                    <? endif; ?>

            </div>
            <!-- category-vew area start -->
            <div class="col-lg-9  col-md-9 col-sm-12 col-xs-12">
                <div class="tab-area">
                    <div class="tab-menu-area bg-fff mb-30 box-shadow br20">
                        <div class="row">
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                <? if($total_records != 0){ ?>
                                <div class="shop-tab-menu">
                                    <ul>
                                        <li class="active"><a href="#tab1" data-toggle="tab"><i class="fas fa-th"></i></a></li>
                                        <li><a href="#tab2" data-toggle="tab"><i class="fas fa-th-list"></i></a></li>
                                    </ul>
                                </div>
                                <? } ?>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                <div class="shop-pra text-center">
                                    <? if($total_records != 0){ $ff = $start_from+$perpage; if ($ff>$total_records){ $ff = $total_records;} ?>
                                    <p>Göstərilir <?= ++$start_from.' - '.$ff ?>.<br> Ümumi məhsul <?= $total_records ?></p>
                                    <? }else{ ?>
                                    <p>Məhsul yoxdur</p>
                                    <? } ?>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <? if($total_records != 0){ ?>


                                <div class="woocommerce-ordering text-center">
                                    <select name="orderby">
                                        <option selected="selected">Sırala</option>
                                        <option  <?=$_GET['orderby'] == 'view-desc' ? 'selected' : ''?> value="view-desc">Çox baxılana görə</option>
                                        <option  <?=$_GET['orderby'] == 'view-asc' ? 'selected' : ''?> value="view-asc">Az baxılana görə</option>
                                        <option  <?=$_GET['orderby'] == 'date-desc' ? 'selected' : ''?> value="date-desc">Yenidən köhnəyə qədər</option>
                                        <option  <?=$_GET['orderby'] == 'date-asc' ? 'selected' : ''?> value="date-asc">Köhnədən yeniyə qədər</option>
                                        <option  <?=$_GET['orderby'] == 'price-desc' ? 'selected' : ''?> value="price-desc">Bahadan ucuza qədər</option>
                                        <option  <?=$_GET['orderby'] == 'price-asc' ? 'selected' : ''?> value="price-asc">Ucuzdan bahaya qədər</option>
                                    </select>
                                </div>
                            </div>
                            <? }  ?>
                        </div>
                    </div>
                    </form>
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active" id="tab1">
                            <div class="row">
                                <? foreach ($products as $product): ?>
                                    <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
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
                        <div role="tabpanel" class="tab-pane fade" id="tab2">
                            <div class="row">
                                <? foreach ($products as $product): ?>
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="category-wrapper bg-fff mb-30 ptb-20 box-shadow">
                                        <div class="category-img shop-category-img product-img fl">
                                            <a href="mehsul/<?=$product['id']?>/<?=$product['linkname']?>.html">
                                                <figure><img src="uploads/product/medium/<?=$product['image']?>" alt="<?=$product['name']?>" class="primary"/></figure>
                                            </a>
                                        </div>
                                        <div class="category-content shop-category-content">
                                            <h3><a href="mehsul/<?=$product['id']?>/<?=$product['linkname']?>.html"><?=$product['name']?></a></h3>


                                            <span><?=$product['price']?><span class="jisazn">M</span></span>
                                            <? if (!empty($product['note'])): ?>
                                                <h5><i class="fas fa-gift fa-fw"></i><?= $product['note'] ?></h5>
                                            <? endif; ?>
                                            <p><?=$product['description']?></p>
                                        </div>
                                    </div>
                                </div>
                                <? endforeach;  ?>
                            </div>
                        </div>
                        <!-- woocommerce-pagination-area -->
                        <? if ($total_pages>1): ?>
                        <div class="row">
                            <div class="col-lg-12  col-md-12 col-sm-12 col-xs-12">
                                <div class="woocommerce-pagination-area bg-fff box-shadow ptb-10 mb-30 br20">
                                    <div class="woocommerce-pagination text-center hover-bg">
                                        <ul>
                                            <? if ($page_number>1):?>
                                                <li><a href="/kateqoriya/<?=get('linkname')?>/<?=($page_number-1)?>/" aria-label="Previous" class="br14"> <i class="fa fa-chevron-left"></i></a></li>
                                            <? endif; for ($i=$page_number-$viewpagecount; $i<=$page_number+1+$viewpagecount; $i++): if ($i>0 && $i<=$total_pages):?>
                                                <li <? if ($page_number==$i){ echo 'class="active"';} ?> ><a href="/kateqoriya/<?=get('linkname')?>/<?=$i?>/"><?=$i?><span class="sr-only"></span></a></li>
                                            <? endif; endfor; if ($page_number<$total_pages): ?>
                                                <li><a href="/kateqoriya/<?=get('linkname')?>/<?=($page_number+1)?>/" aria-label="Next"  class="br23"><i class="fa fa-chevron-right"></i></a></li>
                                            <? endif; ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <? endif; ?>
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

//$out = ob_get_clean();
//$out = preg_replace('/(?![^<]*<\/pre>)[\n\r\t]+/', "\n", $out);
//$out = preg_replace('/ {2,}/', ' ', $out);
//$out = preg_replace('/>[\n]+/', '>', $out);
//echo $out;
?>
<script>
    // pricing slider////
    $( "#slider-range" ).slider({
        range: true,
        min: <?= isset($_GET['min_price']) ? $_GET['min_price'] : 0 ?>,
        max: <?= isset($_GET['max_price']) ? $_GET['max_price'] : $maxprice ?>,
        values: [ <?= isset($_GET['min_price']) ? $_GET['min_price'] : 0 ?>, <?= isset($_GET['max_price']) ? $_GET['max_price'] : $maxprice ?>],
        slide: function( event, ui ) {
            $( "#amount" ).val( ui.values[ 0 ] + " AZN - " + ui.values[ 1 ] + " AZN");
            $( "#min_price" ).val( ui.values[0]);
            $( "#max_price" ).val( ui.values[1]);
        }
    });
    $( "#amount" ).val( $( "#slider-range" ).slider( "values", 0 ) +
        " AZN - " + $( "#slider-range" ).slider( "values", 1 ) + " AZN");
</script>
