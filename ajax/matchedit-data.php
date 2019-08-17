<?php
ob_start();
$path = "../";
include_once("{$path}config/conf.php");

$type_id = prepare("`id`","`type`","`name`=?",[substr(post('matchvalue'), 1)])->fetch(PDO::FETCH_ASSOC);

$products = prepare("`id`,`name`,`linkname`,`image`,`eprice`,`price`,`note`","`product`","`type_id`=? AND `status`=?",[$type_id['id'],"1"])->fetchAll(PDO::FETCH_ASSOC);


$form = '';
$a=0;
foreach ($products as $product):
    ($a<5) ? $b='active' : $b='';
$form .= '<div class="product-wrapper bl">
            <div class="product-name"><h3><a href="mehsul/'.$product['id'].'/'.$product['linkname'].'.html">'.$product['name'].'</a></h3></div>
            <div class="product-img">
                <a href="mehsul/'.$product['id'].'/'.$product['linkname'].'.html">
                    <figure>
                        <img src="uploads/product/medium/'.$product['image'].'" alt="'.$product['name'].'"/>
                    </figure>
                </a>
            </div>
            <div class="product-content">
                <div class="product-price">
                    <span>';
                (!empty($product['eprice'])) ? $form .= $product['eprice'] : $form .= $product['price'];
                $form .= '<span class="AZN">M</span></span>';
                if (!empty($product['note'])){
                    $form .= '<h5><i class="fas fa-gift fa-fw"></i>'.$product['note'].'</h5>';
                }

                $form .= '</div>
                <div class="product-process">
                    <a href="mehsul/'.$product['id'].'/'.$product['linkname'].'.html" class="btn btn-default productbutton">Hissə-hissə al</a>
                    <a href="mehsul/'.$product['id'].'/'.$product['linkname'].'.html" class="btn btn-default productbutton">Məhsula keç</a>
                </div>
            </div>
        </div>';
$a++;
endforeach;

echo json_encode(['html'=>$form,'tag'=>post('matchvalue')]);
?>