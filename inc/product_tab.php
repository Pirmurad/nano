<? $type = prepare("`name`,`linkname`","`type`","`status`=?",["1"],"`ordering`","ASC")->fetchAll(PDO::FETCH_ASSOC);
$product = prepare("`name`,`id`,`linkname`,`note`,`price`,`eprice`,`image`","`product`","`type_id`=? AND `status`=?",["1","1"],"`data_create`","DESC","LIMIT 15")->fetchAll(PDO::FETCH_ASSOC);
if (!empty($product)):?>
<div class="tab-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="tab box-shadow bg-fff br20">
                    <div class="product-title home2-bg-1 home2-product-title text-uppercase br12">
                        <div class="icon bg-1 br1"><i class="fas fa-box"></i></div>
                        <h3>Məhsullar</h3>
                        <div class="tab-menu home2-tab-menu floatright hidden-xs">
                            <ul>
                                <? $a=0; foreach ($type as $t): $a++;?>
                                <li <?= ($a==1) ? ' class="active"' : '' ?>><a href="#<?= $t['linkname'] ?>" data-toggle="tab"><?= $t['name'] ?></a></li>
                                <? endforeach; ?>
                            </ul>
                        </div>
                    </div>
                    <div class="tab-content">
                        <? $a=0; foreach ($type as $t): $a++;?>
                        <div role="tabpanel" class="tab-pane <?= ($a==1) ? 'active' : 'fade' ?>" id="<?= $t['linkname'] ?>">
                            <div class="tab-active home2 left-right-angle">
                                <? if ($a==1): foreach ($product as $p): ?>
                                    <div class="product-wrapper bl prtb">
                                        <div class="product-name">
                                            <h3><a href="mehsul/<?= $p['id'] ?>/<?= $p['linkname'] ?>.html"><?= $p['name'] ?></a></h3>
                                        </div>
                                        <div class="product-img">
                                            <a href="mehsul/<?= $p['id'] ?>/<?= $p['linkname'] ?>.html">
                                                <figure>
                                                    <img src="uploads/product/large/<?= $p['image'] ?>" alt="<?= $p['name'] ?>"/>
                                                </figure>
                                            </a>
                                        </div>
                                        <div class="product-content">
                                            <div class="product-price">
                                                <div style="float:left;">
                                                    <? if (!empty($p['eprice'])): ?>
                                                    <span style="font-size: 16px;width: 100%;color: #000;">
                                                        <del><?= $p['eprice'] ?><span class="jisazn" style="color: #000;">M</span></del>
                                                    </span>
                                                    <? endif; ?>
                                                    <span><?= $p['price'] ?> <span class="AZN">M</span></span>
                                                </div>

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
                                <? endforeach;endif; ?>
                            </div>
                        </div>
                        <? endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<? endif; ?>