<? $product = prepare("`name`,`id`,`linkname`,`note`,`price`,`eprice`,`image`","`product`","`status`=?",["1"],"`data_create`","DESC","LIMIT 15")->fetchAll(PDO::FETCH_ASSOC);
if (!empty($product)):?>
<div class="product-area mtb-35">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-xs-12 col-sm-12 col-md-12">
                <div class="product box-shadow bg-fff br20" id="vvv">
                    <div class="product-title home2-bg-1 text-uppercase home2-product-title br12">
                        <div class="icon bg-1 br1"><i class="fas fa-box"></i></div>
                        <h3>Yeni Məhsullar</h3>
                    </div>
                    <div id="demo">
                        <div id="testing" class="product-active left-right-angle home2">
                            <? foreach ($product as $p): ?>
                            <div class="product-wrapper bl pr">
                                <div class="product-name"><h3><a href="mehsul/<?= $p['id'] ?>/<?= $p['linkname'] ?>.html"><?= $p['name'] ?></a></h3></div>
                                <div class="product-img">
                                    <a href="mehsul/<?= $p['id'] ?>/<?= $p['linkname'] ?>.html">
                                        <figure>
                                            <img src="uploads/product/large/<?= $p['image'] ?>" alt="<?= $p['name'] ?>"/>
                                        </figure>
                                    </a>
                                </div>
                                <div class="product-content">
                                    <div class="product-price">
                                        <? if (!empty($p['eprice'])): ?>
                                        <span>
                                            <del><?= $p['eprice'] ?><span class="jisazn">M</span></del>
                                        </span>
                                        <? endif; ?>
                                        <span><?= $p['price'] ?> <span class="AZN">M</span></span>
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
                </div>
            </div>
        </div>
    </div>
</div>
<? endif; ?>