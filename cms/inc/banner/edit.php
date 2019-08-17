<?PHP
ob_start();
$path='../../../';
$imagepath='../../';
include_once "{$path}config/conf.php";
include_once "../../pages/html_start.php";
?>
<div id="wrapper">

    <?PHP include '../../nav.php';?>

    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">

<?PHP

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    postextract(extract($_POST));

    include $imagepath . 'SimpleImageFull.php';

    $errors= [];

    $file = $_FILES['fileToUpload']['tmp_name'];
    ($category_id=='kicik') ? $resize = ["360","219"] : $resize = ["555","219"];
    $folder = "banner";
    $table = "banner";
    $getId = get('id');
    $errorredirect = "banner/create/";
    $deleteimagecolumn = "image";
    $transparent = "0";

    $file_name = imageupload($file,$path,$imagepath,$resize,$deleteimagecolumn,$table,$getId,$folder,$errorredirect,$transparent);


    $data =	"`image` = ?, `image_name` = ?,`category_id` = ?, `url` = ?,`data_update` = ?,`status` = ?";

    $sql =	[
        $file_name,$image_name,$category_id,$url,time(),$status,get('id')
    ];

    $updatebanner = update("`banner`",$data,"id=?",$sql);

    if($updatebanner) {
        redirect("banner/list/");
    }
    else {
        $errors['errors'] = 'Problem baş verdi, banner dəyişdirilmədi !';
        $_SESSION['errors'] = $errors;
        redirect("banner/edit/".get('id')."/");
    }

}else{
    $bannerfetch = select("*","`banner`")->fetch(PDO::FETCH_ASSOC);
    ?>
    <h1 class="page-header">Banner Dəyiş</h1>
    <div class="row">
        <div class="col-md-12 p10 round_border_goster">
            <form action="" method="POST"  enctype="multipart/form-data">

                <?php
                if (!empty($_SESSION['success'])) {
                    echo '<div class="alert alert-success">' . $_SESSION['success'] . '</div>';

                    unset($_SESSION['success']);
                }
                if (!empty($_SESSION['error'])) {
                    echo '<div class="alert alert-warning">';
                    echo '<ul class="list-group">';
                    foreach ($_SESSION['error'] as $key=>$value) {
                        echo '<li class="list-group-item">' . $value . '</li>';
                    }
                    echo '</ul>';
                    unset($_SESSION['error']);
                    echo '</div>';
                }
                ?>

                <div class="col-md-12 p10  ">
                    <div class="col-md-4">
                        <label for="fileToUpload"><span>Şəkil yüklə</span></label><br>
                        <input type="file" class="form-control" name="fileToUpload" id="fileToUpload"/>
                    </div>
                    <div class="col-md-4">
                        <label for="image_name"><span>Şəkilin adı</span></label><br>
                        <input type="text" id="image_name" name="image_name" required maxlength="100" class="form-control" value="<?= $bannerfetch['image_name'];?>"/>
                    </div>
                    <div class="col-md-2 col-lg-offset-1">
                        <label for="statusyes">Görünürlüyünü seç</label>
                        <div class="radio form-control">
                            <label id="statusyes" class="mr10"><input type="radio" name="status" value="1" <?= ($bannerfetch['status']=='1') ? 'checked="checked"' : '' ?>><span class="green glyphicon glyphicon-eye-open"></span></label>
                            <label class="fr"><input type="radio" name="status" value="0" <?= ($bannerfetch['status']=='0') ? 'checked="checked"' : '' ?>><span class="red glyphicon glyphicon-eye-close"></span></label>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 p10">
                    <div class="col-md-4">
                        <label for="url"><span>Link</span></label><br>
                        <input type="url" id="url" class="form-control" name="url" maxlength="100" value="<?= $bannerfetch['url'];?>">
                    </div>
                    <div class="col-lg-4">
                        <label for="category_id"><span>Hansı kateqoriyaya aid oldugunu seç</span></label><br>
                        <select id="category_id" name="category_id" class="form-control">
                            <option value="kicik" <?= ($bannerfetch['category_id']=='kicik') ? 'selected="selected"' : '' ?>>Kiçik</option>
                            <option value="boyuk" <?= ($bannerfetch['category_id']=='boyuk') ? 'selected="selected"' : '' ?>>Böyük</option>
                        </select>
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
