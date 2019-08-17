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
    $resize = ["855", "253"];
    $folder = "slider";
    $table = "slider";
    $getId = get('id');
    $errorredirect = "slider/edit/".get('id')."/";
    $deleteimagecolumn = "image";
    $transparent = "0";

    $file_name = imageupload($file,$path,$imagepath,$resize,$deleteimagecolumn,$table,$getId,$folder,$errorredirect,$transparent);

    $data = "`image` = ?,`image_name` = ?,`url` = ?,`data_update` = ?,`status` = ?";

    $sql = [
        $file_name,
        $image_name,
        $url,
        time(),
        $status,
        get('id')
    ];

    $updateslider = update("`slider`",$data,"`id`=?",$sql);

    if($updateslider) {
        redirect("slider/list/");
    }
    else {
        $errors['errors'] = 'Problem baş verdi, slider dəyişilmədi !';
        $_SESSION['errors'] = $errors;

        redirect("slider/edit/".get('id')."/");
    }

}else{
    $sliderfetch = prepare("*","`slider`","`id`=?",[get('id')])->fetch(PDO::FETCH_ASSOC);
    ?>
<div id="wrapper">

    <?PHP include '../../nav.php';?>

    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
    <h1 class="page-header">Slideri Dəyiş</h1>
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
		                <label for="image_name"><span>Şəkilin adı</span></label><br>
		                <input type="text" id="image_name" name="image_name" required maxlength="100" class="form-control" value="<?= $sliderfetch['image_name'];?>"/>
	                </div>
                    <div class="col-md-4">
                        <label for="fileToUpload"><span>Şəkil yüklə</span></label><br>
                        <input type="file" class="form-control" name="fileToUpload" id="fileToUpload"/>
                    </div>
                    <div class="col-md-2 col-md-offset-1">
                        <label for="statusyes">Görünürlüyünü seç</label>
                        <div class="radio form-control">
                            <label id="statusyes" class="mr10"><input type="radio" name="status" value="1" <?= ($sliderfetch['status']=='1') ? 'checked="checked"' : '' ?>><span class="green glyphicon glyphicon-eye-open"></span></label>
                            <label class="fr"><input type="radio" name="status" value="0" <?= ($sliderfetch['status']=='0') ? 'checked="checked"' : '' ?>><span class="red glyphicon glyphicon-eye-close"></span></label>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 p10">
                    <div class="col-md-4">
                        <label for="url"><span>Link</span></label><br>
                        <input type="url" id="url" name="url" maxlength="255" class="form-control" value="<?= $sliderfetch['url'];?>"/>
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
