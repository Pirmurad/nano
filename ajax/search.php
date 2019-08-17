<?php
ob_start();
$path = "../";
include_once("{$path}config/conf.php");

$input = post('input');

if ($input){
    echo '<ul class="">';
    $products = prepare("`id`,`name`,`image`,`linkname`","`product`","`name` LIKE ? AND `status`=?",["%".$input."%","1"])->fetchAll(PDO::FETCH_ASSOC);
     foreach ($products as $product) { ?>
         <li>
             <a href="mehsul/<?= $product['id'] ?>/<?= $product['linkname'] ?>.html">
                 <img src="uploads/product/medium/<?= $product['image'] ?>">
                 <span><?= $product['name'] ?></span>
             </a>
         </li>
    <?}
    echo '</ul>';
}