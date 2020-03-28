<?PHP
ob_start();
$path = "";
//include_once("{$path}top-cache.php");
include_once("{$path}config/conf.php");

if (!empty(get('id1'))){
    $product1 = prepare("*","`product`","`id`=? AND `status`=?",[get('id1'),"1"])->fetch(PDO::FETCH_ASSOC);
    $param1 = json_decode($product1['param'],true);
}
if (!empty(get('id2'))){
    $product2 = prepare("*","`product`","`id`=? AND `status`=?",[get('id2'),"1"])->fetch(PDO::FETCH_ASSOC);
    $param2 = json_decode($product2['param'],true);
}
if (!empty(get('id3'))){
    $product3 = prepare("*","`product`","`id`=? AND `status`=?",[get('id3'),"1"])->fetch(PDO::FETCH_ASSOC);
    $param3 = json_decode($product3['param'],true);
}

$params   =  prepare("`id`,`name`,`linkname`","`type_param`","`type_id`=?",[get('type_id')],"`ordering`","ASC")->fetchAll(PDO::FETCH_ASSOC);

$title = $product['title'];
$description = $product['description'];
$keyword = $product['keyword'];
$link='http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

include_once("{$path}inc/html_start.php");
include_once("{$path}inc/top_menu.php");
include_once("{$path}inc/header.php");
?>
    <style>
        <link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.1/themes/base/minified/jquery-ui.min.css" type="text/css" />
    </style>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <header class="compare-candidates">

                <div class="diff-toggle-box">
                </div>

                <div class="compare-candidate compare-col">
                    <div class="candidate-search candidate-search-1">
                        <form class="clearfix" action="" method="get">
                            <strong class="cmp-with floatLeftDisplay movecmpwith">Məhsul seç</strong><br>
                            <input type="hidden" name="id1" value="<?= get('id1') ?>">
                            <input type="hidden" name="id2" value="<?= get('id2') ?>">
                            <input type="hidden" name="id3" value="<?= get('id3') ?>">
                            <input type="hidden" name="type_id" id="type_id" value="<?= get('type_id') ?>">
                            <input type="text" id="sSearch1" class="st-input-cmp float-left" name="sSearch1" value=""
                                   autocomplete="off">
                            <input type="submit" class="button button-small float-left" value="Axtar">
                            <i>Zəhmət olmasa məhsulun adını daxil edin</i>
                        </form>

                        <div class="autocomplete autocomplete-search autocomplete-small autocomplete-hide">
                            <div class="phone-results" id="phone-results1"></div>
                        </div>
                    </div>
                    <? if (!empty($product1)): ?>
                    <h3><a href="mehsul/<?= $product1['id'] ?>/<?= $product1['linkname'] ?>.html"><span data-spec="modelname"><?= $product1['name'] ?></span></a></h3>

                    <div class="compare-media-wrap float-left clearfix">
                        <img src="uploads/product/medium/<?= $product1['image'] ?>" alt="<?= $product1['name'] ?>">
                        <p style="font-size: 20px;background-color: #65b9b9;margin: 10px 0 0px;color: white;"><?= $product1['price'] ?><span class="jisazn" style="color: white;">M</span></p>
                    </div>
                    <? endif; ?>
                </div>

                <div class="compare-candidate compare-col">
                    <div class="candidate-search candidate-search-1">
                        <form class="clearfix" action="" method="get">
                            <strong class="cmp-with floatLeftDisplay movecmpwith">Məhsul seç</strong><br>
                            <input type="hidden" name="id1" value="<?= get('id1') ?>">
                            <input type="hidden" name="id2" value="<?= get('id2') ?>">
                            <input type="hidden" name="id3" value="<?= get('id3') ?>">
                            <input type="hidden" name="type_id" id="type_id" value="<?= get('type_id') ?>">
                            <input type="text" id="sSearch2" class="st-input-cmp float-left" name="sSearch2" value=""
                                   autocomplete="off">
                            <input type="submit" class="button button-small float-left" value="Axtar">
                            <i>Zəhmət olmasa məhsulun adını daxil edin</i>
                        </form>

                        <div class="autocomplete autocomplete-search autocomplete-small autocomplete-hide">
                            <div class="phone-results" id="phone-results2"></div>
                        </div>
                    </div>
                    <? if (!empty($product2)): ?>
                    <h3><a href="mehsul/<?= $product2['id'] ?>/<?= $product2['linkname'] ?>.html"><span data-spec="modelname"><?= $product2['name'] ?></span></a></h3>

                    <div class="compare-media-wrap float-left clearfix">
                        <img src="uploads/product/medium/<?= $product2['image'] ?>" alt="<?= $product2['name'] ?>">
                        <p style="font-size: 20px;background-color: #65b9b9;margin: 10px 0 0px;color: white;"><?= $product2['price'] ?><span class="jisazn" style="color: white;">M</span></p>
                    </div>
                    <? endif; ?>
                </div>

                <div class="compare-candidate compare-col">
                    <div class="candidate-search candidate-search-3">
                        <form class="clearfix" action="" method="get">
                            <strong class="cmp-with floatLeftDisplay movecmpwith">Məhsul seç</strong><br>
                            <input type="hidden" name="id1" value="<?= get('id1') ?>">
                            <input type="hidden" name="id2" value="<?= get('id2') ?>">
                            <input type="hidden" name="id3" value="<?= get('id3') ?>">
                            <input type="hidden" name="type_id" id="type_id" value="<?= get('type_id') ?>">
                            <input type="text" id="sSearch3" class="st-input-cmp float-left" name="sSearch3" value=""
                                   autocomplete="off">
                            <input type="submit" class="button button-small float-left" value="Axtar">
                            <i>Zəhmət olmasa məhsulun adını daxil edin</i>
                        </form>

                        <div class="autocomplete autocomplete-search autocomplete-small autocomplete-hide">
                            <div class="phone-results" id="phone-results3"></div>
                        </div>
                    </div>
                    <? if (!empty($product3)): ?>
                    <h3><a href="mehsul/<?= $product3['id'] ?>/<?= $product3['linkname'] ?>.html"><span data-spec="modelname"><?= $product3['name'] ?></span></a></h3>

                    <div class="compare-media-wrap float-left clearfix">
                        <img src="uploads/product/medium/<?= $product3['image'] ?>" alt="<?= $product3['name'] ?>">
                        <p style="font-size: 20px;background-color: #65b9b9;margin: 10px 0 0px;color: white;"><?= $product3['price'] ?><span class="jisazn" style="color: white;">M</span></p>
                    </div>
                    <? endif; ?>
                </div>

                </div>
                <div id="specs-list" class="compare-specs-list col-md-12 mb-20">


                    <table cellspacing="0">
                        <tbody>
                            <? foreach ($params as $par): ?>
                            <tr>
                                <td class="ttl"><?= $par['name'] ?></td>
                                <td class="nfo" data-spec="nettech">
                                    <? if(!empty($param1)){ foreach ($param1 as $p1){
                                        if ($p1[$par['linkname']] != NULL){
                                            echo $p1[$par['linkname']];
                                        };
                                    }} ?>
                                </td>
                                <td class="nfo" data-spec="nettech">
                                    <? if(!empty($param2)){ foreach ($param2 as $p2){
                                        if ($p2[$par['linkname']] != NULL){
                                            echo $p2[$par['linkname']];
                                        };
                                    }} ?>
                                </td>
                                <td class="nfo" data-spec="nettech">
                                    <? if(!empty($param3)){ foreach ($param3 as $p3){
                                        if ($p3[$par['linkname']] != NULL){
                                            echo $p3[$par['linkname']];
                                        };
                                    }}?>
                                </td>
                            </tr>
                            <? endforeach; ?>
                        </tbody>
                    </table>

                </div>
            </header>
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
<script type="text/javascript" src="http://code.jquery.com/ui/1.10.1/jquery-ui.min.js"></script>