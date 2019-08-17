<?PHP
ob_start();
$path = "../";
include_once("{$path}config/conf.php");

$title = $menu['title'];
$description = $menu['description'];
$keyword = $menu['keyword'];
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
        <div class="main-container">
            <div class="google-map-area mb-50">
                <div id="googleMap"></div>
            </div>
            <div class="contuct-area">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <div class="contuct mb-50 bg-fff box-shadow p-20 br20">
                                <div class="contuct-title">
                                    <h2>Bizimlə Əlaqə</h2>
                                </div>
                                <div class="contuct-form form-style">
                                    <form action="form/mail.php" method="post" id="mailsend">
                                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                            <label for="name">Adınız</label>
                                            <input type= "text" required="" name="name" id="name" />
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                            <label for="email">Elektron poçt adresiniz</label>
                                            <input type="email" required="" name="email" id="email" />
                                        </div>
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
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <div class="contuct-detail mb-50 p-20 bg-fff box-shadow br20">
                                    <div class="contuct-title">
                                        <h2>Əlaqə Məlumatları</h2>
                                    </div>
                                    <div class="same">
                                        <h5>Ünvanımız</h5>
                                        <p><?= $information['address'] ?></p>
                                    </div>
                                    <div class="same">
                                        <h5>Elektron poçt adresimiz</h5>
                                        <p><a href="mailto:<?= $information['mail'];?>"><?= $information['mail'];?></a></p>
                                    </div>
                                    <div class="same">
                                        <h5>Telefon nömrəsi</h5>
                                        <p><a href="https://api.whatsapp.com/send?phone=994<?= substr($information['phone'], 1); ?>"><?= $information['phone'] ?></a></p>
                                    </div>
                            </div>
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