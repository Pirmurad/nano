<?php
ob_start();
$path = "../";
include_once("{$path}config/conf.php");

$input = post('input');

if ($input){
    echo '<ul class="">';
    $products = prepare("`id`,`name`,`price`,`image`,`linkname`","`product`","`name` LIKE ? AND `status`=?",["%".$input."%","1"])->fetchAll(PDO::FETCH_ASSOC);
     foreach ($products as $product) { ?>
         <li class="seraching_item">
             <a href="mehsul/<?= $product['id'] ?>/<?= $product['linkname'] ?>.html">
                 <img src="uploads/product/medium/<?= $product['image'] ?>">
                 <span><?= $product['name'] ?></span>
                 <div class="product-price">
                     <span class="price_m"><?= $product['price'] ?> <span class="AZN">M</span></span>
                 </div>
             </a>
         </li>
    <?}
    echo '</ul>';
}