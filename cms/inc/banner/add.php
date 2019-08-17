<?PHP
ob_start();
$path='../../../';
$imagepath='../../';
include_once "{$path}config/conf.php";
include_once "{$imagepath}pages/html_start.php";

    
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $errors= [];
    postextract(extract($_POST));

    $order=0;
    $ordering = select("MAX(ordering)","`banner`","`ordering`")->fetch(PDO::FETCH_ASSOC);
    $order=$ordering['MAX(ordering)']+1;

    include $imagepath . 'SimpleImageFull.php';

    $file = $_FILES['fileToUpload']['tmp_name'];
    ($category_id=='kicik') ? $resize = ["360","219"] : $resize = ["555","219"];
    $folder = "banner";
    $table = "banner";
    $getId = get('id');
    $errorredirect = "banner/create/";
    $deleteimagecolumn = "image";
    $transparent = "0";

    $file_name = imageupload($file,$path,$imagepath,$resize,$deleteimagecolumn,$table,$getId,$folder,$errorredirect,$transparent);

    $data =	"`image` = ?, `image_name` = ?,`category_id` = ?,`url` = ?,`data_create` = ?,`data_update` = ?,`ordering` = ?,`status` = ?";

    $sql =	[
        $file_name,$image_name,$category_id,$url,time(),time(),$order,$status
    ];

    $insertbanner =	insert("`banner`",$data,$sql);


    if($insertbanner) {
        redirect("banner/list/");
    }
    else {
        $errors['errors'] = 'Problem baş verdi, banner əlavə olunmadı !';
        $_SESSION['errors'] = $errors;
        redirect("banner/create/");
    }

}else{
?>
<div id="wrapper">

    <?PHP include '../../nav.php';?>

    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
<h1 class="page-header">Banner əlavə et</h1>
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
                    <input type="file" class="form-control" name="fileToUpload" required id="fileToUpload"/>
                </div>
                <div class="col-md-4">
                    <label for="image_name"><span>Şəkilin adı</span></label><br>
                    <input type="text" id="image_name" name="image_name" required maxlength="100" class="form-control" placeholder="Şəkilin adı *"/>
                </div>
                <div class="col-md-2">
                    <label for="statusyes">Görünürlüyünü seç</label>
                    <div class="radio form-control">
                        <label id="statusyes" class="mr10"><input type="radio" checked="checked" name="status" value="1"><span class="green glyphicon glyphicon-eye-open"></span></label>
                        <label class="fr"><input type="radio" name="status" value="0"><span class="red glyphicon glyphicon-eye-close"></span></label>
                    </div>
                </div>
            </div>
            <div class="col-md-12 p10">
                <div class="col-md-4">
                    <label for="url"><span>Link</span></label><br>
                    <input type="url" id="url" class="form-control" name="url" maxlength="100" placeholder="bannerin yönlənəcəyi səhifəsinin linki">
                </div>
                <div class="col-lg-4">
                    <label for="category_id"><span>Hansı kateqoriyaya aid oldugunu seç</span></label><br>
                    <select id="category_id" name="category_id" class="form-control">
                        <option value="kicik">Kiçik</option>
                        <option value="boyuk">Böyük</option>
                    </select>
                </div>
            </div>
            <div class="col-md-12 p10  ">
                <input type="submit" id="submit" name="submit" value="Əlavə et" class="btn btn-primary"/>
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
