<?PHP
ob_start();
$path='../../../';
$imagepath='../../';
include_once "{$path}config/conf.php";
include_once "../../pages/html_start.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $errors= [];
    postextract(extract($_POST));

    include $imagepath . 'SimpleImageFull.php';

    $file = $_FILES['fileToUpload']['tmp_name'];
    $resize = ["173","94"];
    $folder = "sponsor";
    $table = "sponsor";
    $getId = get('id');
    $errorredirect = "sponsor/edit/".get('id')."/";
    $deleteimagecolumn = "image";
    $transparent = "1";

    $file_name = imageupload($file,$path,$imagepath,$resize,$deleteimagecolumn,$table,$getId,$folder,$errorredirect,$transparent);

    $data = "`image` = ?,`image_name` = ?,`link` = ?,`data_update` = ?,`status` = ?";

    $sql = [
        $file_name,
        $image_name,
        $link,
        time(),
        $status,
        get('id')
    ];

    $updatesponsor = update("`sponsor`",$data,"`id`=?",$sql);

    if($updatesponsor) {
        redirect("sponsor/list/");
    }
    else {
        $errors['errors'] = 'Problem baş verdi, sponsor dəyişilmədi !';
        $_SESSION['errors'] = $errors;

        redirect("sponsor/edit/".get('id')."/");
    }

}else{
    $sponsorfetch = prepare("*","`sponsor`","`id`=?",[get('id')])->fetch(PDO::FETCH_ASSOC);
    ?>
<div id="wrapper">

    <?PHP include '../../nav.php';?>

    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
    <h1 class="page-header"><?=$sponsorfetch['image_name'];?> sponsorunu Dəyiş</h1>
    <div class="row">
        <div class="col-md-12 p10 round_border_goster">
            <form action="" method="POST"  enctype="multipart/form-data">

                <?php
                if (!empty($_SESSION['success'])) {
                    echo '<div class="alert alert-success">' . $_SESSION['success'] . '</div>';

                    unset($_SESSION['success']);
                }
                if (!empty($_SESSION['errors'])) {
                    echo '<div class="alert alert-warning">';
                    echo '<ul class="list-group">';
                    foreach ($_SESSION['errors'] as $key=>$value) {
                        echo '<li class="list-group-item">' . $value . '</li>';
                    }
                    echo '</ul>';
                    unset($_SESSION['errors']);
                    echo '</div>';
                }
                ?>

                <div class="col-md-12 p10">
                    <div class="col-md-4">
                        <label for="fileToUpload"><span>Şəkil yüklə</span></label><br>
                        <input type="file" class="form-control" name="fileToUpload" id="fileToUpload"/>
                    </div>
                    <div class="col-md-4">
                        <label for="image_name"><span>Adı</span></label><br>
                        <input type="text" id="image_name" name="image_name" required maxlength="100" class="form-control" value="<?= $sponsorfetch['image_name'];?>"/>
                    </div>
                    <div class="col-md-2 col-md-offset-1">
                        <label for="statusyes">Görünürlüyünü seç</label>
                        <div class="radio form-control">
                            <label id="statusyes" class="mr10"><input type="radio" name="status" value="1" <?= ($sponsorfetch['status']=='1') ? 'checked="checked"' : '' ?>><span class="green glyphicon glyphicon-eye-open"></span></label>
                            <label class="fr"><input type="radio" name="status" value="0" <?= ($sponsorfetch['status']=='0') ? 'checked="checked"' : '' ?>><span class="red glyphicon glyphicon-eye-close"></span></label>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 p10">
                    <div class="col-md-12">
                        <label for="link"><span>Link</span></label><br>
                        <input type="text" id="link" name="link" maxlength="100" class="form-control" value="<?= $sponsorfetch['link'];?>"/>
                    </div>
                </div>
                <div class="col-md-12 p10">
                    <input type="submit" id="submit" name="submit" value="Dəyiş" class="btn btn-primary"/>
                </div>
            </form>
        </div>
            </div>
<?PHP } ?>
</div>
<!-- /.col-lg-12 -->
</div>
<!-- /.row -->
</div>
<!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->
<?PHP include '../../pages/html_end.php';
ob_end_flush();
?>
