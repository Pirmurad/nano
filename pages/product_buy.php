<?PHP
ob_start();
$path = "../";
include_once("{$path}config/conf.php");
$kredit = explode('-',get('product'));
//var_dump($kredit);
//die;
$product = prepare("`name`,`title`,`keyword`,`description`,`id`,`kredit_id`,`linkname`,`image`","`product`","`id`=? AND `linkname`=? AND `status`=?",[get('id'),get('name'),"1"])->fetch(PDO::FETCH_ASSOC);

$kredit_product = prepare("`ay`,`ilkin_odenis`","`kredit_product`","`kredit_id`=? AND `product_id`=?",[$product['kredit_id'],$product['id']])->fetch(PDO::FETCH_ASSOC);

$ay = json_decode($kredit_product['ay'],true);


$title = $product['title'];
$description = $product['description'];
$keyword = $product['keyword'];
$link='http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

include_once("{$path}inc/html_start.php");
include_once("{$path}inc/top_menu.php");
include_once("{$path}inc/header.php");
include_once "{$path}config/csrf.class.php";

$csrf = new csrf();
$token_id = $csrf->get_token_id();
$token_value = $csrf->get_token($token_id);
?>

<!-- contuct-area start -->
<div class="main-container mt-35">
    <div class="contuct-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <div class="contuct mb-50 bg-fff box-shadow p-20 br20">
                        <div class="contuct-title">
                            <h4><b><a href="mehsul/<?= $product['id'] ?>/<?= $product['linkname'] ?>.html"><?= $product['name'] ?></a></b> məhsulunu
                                <? if($kredit[0]=='hh'): ?>
                                <b>hissə-hissə ödəmək</b> şərti ilə <b><?= $kredit[1] ?> ay</b> olmaqla
                                <? elseif ($kredit[0]=='xt'): ?>
                                <b>xüsusi təklif</b> şərti ilə <b><?= $kredit[1] ?> ay</b> olmaqla
                                <? endif; ?>
                                sifariş et
                            </h4><br>
                        </div>
                        <div class="contuct-form form-style">
                            <form action="form/buy.php" method="post" id="buysend">
                                <input type="hidden" name="product" value="<?= $product['name'] ?>">
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <label for="name">Adınız</label>
                                    <input type= "text" required="" name="name" id="name" />
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <label for="email">Elektron poçt adresiniz</label>
                                    <input type="email" required="" name="email" id="email" />
                                </div>
                                <? if (!empty($kredit[0])): ?>
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <label for="seriya">Şəxsiyyət vəsiqənin seriyası</label>
                                    <input type= "text" required="" name="seriya" id="seriya" value="AZE № "/>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <label for="fin">Fərdi İdentifikasiya Nömrəsi (FİN)</label>
                                    <input type="text" required="" name="fin" id="fin" />
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <label for="address">Faktiki yaşadığı ünvan</label>
                                    <input type="text" required="" name="address" id="address" />
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <label for="phone">Telefon</label>
                                    <input type="number" required="" name="phone" id="phone" />
                                </div>
                                <? endif; ?>
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <label for="subject">Mövzu</label>
                                    <input type="text" name="subject" id="subject" />
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <label for="message">Mesajınız</label>
                                    <textarea name="message" id="message" cols="30" rows="10" style="max-width: 100%;"></textarea>
                                </div>
                                <button>Göndər</button>
                            </form>
                        </div>
                    </div>
                </div>
                <? if (!empty($kredit[0])): ?>
                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                    <div class="contuct-detail mb-50 p-20 bg-fff box-shadow br20">
                        <div class="contuct-title">
                            <h2>Seçdiyiniz ödəmə şərtləri</h2>
                        </div>

                        <div class="same">
                            <h5>Ödəmə müddəti</h5>
                            <p><?= $kredit[1] ?> ay</p>
                        </div>
                        <div class="same">
                            <h5>İlkin ödəniş</h5>
                            <p><?= $kredit_product['ilkin_odenis']; ?> <span class="jisazn">M</span></p>
                        </div>
                        <div class="same">
                            <h5>Aylıq ödəniş</h5>
                            <p><?= $ay[$kredit[1]-1][$kredit[1]-1] ?> <span class="jisazn">M</span></p>
                        </div>
                    </div>
                </div>
                <? endif; ?>
                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                    <div class="contuct-detail mb-50 p-20 bg-fff box-shadow br20">
                        <div class="panel-body text-center">
                            <h4 class="nm-t font-w-normal blue-title section">Seçdiyiniz məhsul</h4>
                            <a href="mehsul/<?= $product['id'] ?>/<?= $product['linkname'] ?>.html">
                                <div class="image-holder section">
                                    <img class="img-responsive-custom" src="/uploads/product/large/<?= $product['image'] ?>" alt="<?= $product['name'] ?>">
                                </div>
                                <!-- /.image-holder -->
                                <strong class="blue-title"><?= $product['name'] ?></strong>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                    <img class="img-responsive-custom" src="/img/sexsiyyet_vesiqesi.png" alt="sexsiyyet vesiqesi">
                </div>
            </div>
        </div>
    </div>
</div>
<!-- contuct-area end -->
   
<?
include_once("{$path}inc/footer.php");
include_once("{$path}inc/html_end.php");

$out = ob_get_clean();
$out = preg_replace('/(?![^<]*<\/pre>)[\n\r\t]+/', "\n", $out);
$out = preg_replace('/ {2,}/', ' ', $out);
$out = preg_replace('/>[\n]+/', '>', $out);
echo $out;
?>