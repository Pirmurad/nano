<?php
ob_start();
$path = "../";
include_once("{$path}config/conf.php");

$amount = get('amount');
$brand = get('brands');
$rams = get('rams');
$id = get('id');
$category_id = get('category_id');
$type_id = get('type_id');
$prepare = "";
$execute = array();

$json1 = "";
$json2 = "";

if ($id){
    $order = explode("-",$id);
    $o = $order['0'];
    $r = $order['1'];

    if ($o=='view'){ $orders = "view_count";}
    if ($o=='date'){ $orders = "data_create";}
    if ($o=='price'){ $orders = "price";}
}
if ($amount){
    $price = explode("-", $amount);
    $minprice = intval(trim($price[0]));
    $maxprice = intval(trim($price[1]));

    $prepare .= "`price` BETWEEN  ? AND ? AND ";
    array_push($execute,$minprice,$maxprice);
}

if ($brand){
    $prepare .= "`brand_id` IN (".implode(',',$brand).") AND ";
//    array_push($execute,);
}

if ($rams){
    $prepare .= "`param`->'$.\"operativ-yaddash--ram-\"' in (?) AND ";
    array_push($execute,$rams);
}

if ($category_id){
    $prepare .= "`category_id`=? AND ";
    array_push($execute,$category_id);
}
if ($type_id){
    $prepare .= "`type_id`=? AND ";
    array_push($execute,$type_id);
}
$prepare .= "`status`=?";
array_push($execute,"1");
if (empty($orders) && empty($r)){
    $orders = "data_create";
    $r = "DESC";
}

//var_dump($prepare,$execute,$products);
//die;
    $products = prepare("`id`,`linkname`,`name`,`image`,`price`,`description`", "`product`",$prepare,$execute,$orders,$r)->fetchAll(PDO::FETCH_ASSOC);

    foreach ($products as $product):

        $json1 .= '<div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
            <div class="category-wrapper mh290 bg-fff mb-30">
                <div class="category-img product-img">
                    <a href="mehsul/' . $product['id'] . '/' . $product['linkname'] . '.html">
                        <figure><img src="uploads/product/medium/' . $product['image'] . '" alt="' . $product['name'] . '" class="primary"/></figure>
                    </a>
                </div>
                <div class="category-content">
                    <h4><a href="mehsul/' . $product['id'] . '/' . $product['linkname'] . '.html">' . $product['name'] . '</a></h4>
                    <span>' . $product['price'] . '<span class="jisazn">M</span></span>
                </div>
            </div>
        </div>';

        $json2 .= '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="category-wrapper mh290 bg-fff mb-30 ptb-20 box-shadow">
                <div class="category-img shop-category-img product-img fl">
                    <a href="mehsul/' . $product['id'] . '/' . $product['linkname'] . '.html">
                        <figure><img src="uploads/product/medium/' . $product['image'] . '" alt="' . $product['name'] . '" class="primary"/></figure>
                    </a>
                </div>
                <div class="category-content shop-category-content">
                    <h3><a href="mehsul/' . $product['id'] . '/' . $product['linkname'] . '.html">' . $product['name'] . '</a></h3>
                    <span>' . $product['price'] . '<span class="jisazn">M</span></span>
                    <p>' . $product['description'] . '</p>
                </div>
            </div>
        </div>';
        ?>

    <? endforeach;
echo json_encode(['json1'=>$json1,'json2'=>$json2]);