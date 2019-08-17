<?PHP
ob_start();
$path='../../../../';
$imagepath='../../../';
include_once "{$path}config/conf.php";
include_once "../../../pages/html_start.php";
    
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    postextract(extract($_POST));

    $errors= [];
    include '../../../SimpleImageFull.php';
foreach ($_FILES['fileToUpload']['name'] as $f => $name) {
    if ($_FILES['fileToUpload']['error'][$f] == 4) {
        continue; // Skip file if any error found
    }
    if ($_FILES['fileToUpload']['error'][$f] == 0) {
        $file_name = $_FILES['fileToUpload']['name'];
        $file_size = $_FILES['fileToUpload']['size'];
        $file_tmp = $_FILES['fileToUpload']['tmp_name'];
        $file_type = $_FILES['fileToUpload']['type'];

        $rand_name_1 = rand(1000000, 9999999);
        $rand_name_2 = rand(1000000, 9999999);
        $rand = "$rand_name_2$rand_name_1";

        $extension = '.png';
        $file_name = $rand . $extension;

        $paths = "{$path}uploads/gallery/" . $file_name;
        imgUpload($file_tmp[$f], $paths);


        $image = new SimpleImage("{$path}uploads/gallery/" . $file_name);

        $image->thumbnail('350','350');
        $image->save("{$path}uploads/gallery/large/" . $file_name);

        $image->thumbnail('112','112');
        $image->save("{$path}uploads/gallery/medium/" . $file_name);

        $lastorder   =   select("MAX(ordering)","`gallery`","`ordering`","DESC")->fetch(PDO::FETCH_ASSOC);
        $order      =   $lastorder['MAX(ordering)']+1;
    }

    $data = "`product_id` = ?,`image` = ?,`data_create` = ?,`data_update` = ?,`ordering` = ?,`status` = ?";

    $sql = [
        get('product_id'),
        $file_name,
        time(),
        time(),
        $order,
        $status
    ];

    $insertgallery = insert("`gallery`", $data, $sql);
}
    if($insertgallery) {
        redirect('product/'.get('product_id').'/gallery/list/');
    }
    else {
        $errors['errors'] = 'Problem baş verdi, şəkil əlavə olunmadı !';
        $_SESSION['errors'] = $errors;
	    redirect('product/'.get('product_id').'/gallery/create/');
    }

}else{
    $product = prepare("`name`","`product`","`id`=?",[get('product_id')])->fetch(PDO::FETCH_ASSOC);
?>
<div id="wrapper">

    <?PHP include '../../../nav.php';?>

    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
<h1 class="page-header"><b><?=$product['name'];?></b> elanının qalereyasına şəkil əlavə et</h1>

	<a type="button" href="product/<?=get('product_id');?>/gallery/list/" class="btn btn-danger">Qalereyaya qayıt</a>
	<hr>
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
                    <input type="file" class="form-control" name="fileToUpload[]" multiple required id="fileToUpload"/>
                </div>
                <div class="col-md-2 col-md-offset-1">
                    <label for="statusyes">Görünürlüyünü seç</label>
                    <div class="radio form-control">
                        <label id="statusyes" class="mr10"><input type="radio" checked="checked" name="status" value="1"><span class="green glyphicon glyphicon-eye-open"></span></label>
                        <label class="fr"><input type="radio" name="status" value="0"><span class="red glyphicon glyphicon-eye-close"></span></label>
                    </div>
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
<?PHP include '../../../pages/html_end.php';
ob_end_flush();
?>
