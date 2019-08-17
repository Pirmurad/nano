<?php
ob_start();
$path = "../";
include_once("{$path}config/conf.php");

$input = get('input');
$type = get('type');
$product1 = get('product1');
$product2 = get('product2');
$product3 = get('product3');
$form = get('form');

if (empty($product1)){
    if (empty($product2)){
        if (empty($product3)){
            $productzz = 0;
        }else{
            $productzz = $product3;
        }
    }else{
        $productzz = $product2;
    }
}else{
    $productzz = $product1;
}

if ($type && $input){
    echo '<ul class="">';
    $products = prepare("`id`,`name`,`image`","`product`","`id`!=? AND `type_id`=? AND `name` LIKE ? AND `status`=?",[$productzz,$type,"%".$input."%","1"])->fetchAll(PDO::FETCH_ASSOC);
     foreach ($products as $product) { ?>
         <?
         if($form==1){
             $product1 = $product['id'];
         }elseif($form==2){
             $product2 = $product['id'];
         }else{
             $product3 = $product['id'];
         }
         ?>
             <li>
                 <a href="muqayise.php?type_id=<?= $type ?>&id1=<?= $product1 ?>&id2=<?= $product2 ?>&id3=<?= $product3 ?>">
                     <img src="uploads/product/medium/<?= $product['image'] ?>">
                     <span><?= $product['name'] ?></span>
                 </a>
             </li>

    <?}
    echo '</ul>';
}