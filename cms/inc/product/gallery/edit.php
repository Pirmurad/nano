<?PHP
ob_start();
$path='../../../../';
$imagepath='../../../';
include_once "{$path}config/conf.php";
include_once "../../../pages/html_start.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    postextract(extract($_POST));
    
    $errors= [];

    include $imagepath . 'SimpleImageFull.php';

    $file = $_FILES['fileToUpload']['tmp_name'];
    $resize = ['350','350','112','112'];
    $folder = "gallery";
    $table = "gallery";
    $getId = get('product_id');
    $errorredirect = 'product/'.get('product_id').'/gallery/edit/'.get('gallery_id').'/';
    $deleteimagecolumn = "image";
    $transparent = "0";

    $file_name = imageupload($file,$path,$imagepath,$resize,$deleteimagecolumn,$table,$getId,$folder,$errorredirect,$transparent);

    $data =	"`product_id` = ?,`image` = ?,`data_update` = ?,`status` = ?";

    $sql =	[
        get('product_id'),$file_name,time(),$status,get('gallery_id')
    ];

    $updategallery = update("`gallery`",$data,"`id` = ?",$sql);

    if($updategallery) {
        redirect('product/'.get('product_id').'/gallery/list/');
    }
    else {
        $errors['errors'] = 'Problem baş verdi, şəkil dəyişilmədi !';
        $_SESSION['errors'] = $errors;

        redirect('product/'.get('product_id').'/gallery/edit/'.get('gallery_id').'/');
    }

}else{
    $galleryfetch = prepare("*","`gallery`","`id`=?",[get('gallery_id')])->fetch(PDO::FETCH_ASSOC);
    $product = prepare("`name`","`product`","`id`=?",[get('product_id')])->fetch(PDO::FETCH_ASSOC);
    ?>
<div id="wrapper">

    <?PHP include '../../../nav.php';?>

    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
	<h1 class="page-header"><b><?=$product['name'];?></b> elanının qalereyasının şəkilini dəyiş</h1>
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
                    <div class="col-md-2 col-md-offset-1">
                        <label for="statusyes">Görünürlüyünü seç</label>
                        <div class="radio form-control">
                            <?PHP
                            if ($galleryfetch['status']==0) {
                                echo '<label id="statusyes" class="mr10"><input type="radio" name="status" value="1"><span class="green glyphicon glyphicon-eye-open"></span></label>';
                                echo '<label class="fr"><input type="radio" name="status" value="0" checked="checked"><span class="red glyphicon glyphicon-eye-close"></span></label>';
                            }elseif($galleryfetch['status']==1){
                                echo '<label id="statusyes" class="mr10"><input type="radio" name="status" checked="checked" value="1"><span class="green glyphicon glyphicon-eye-open"></span></label>';
                                echo '<label class="fr"><input type="radio" name="status" value="0"><span class="red glyphicon glyphicon-eye-close"></span></label>';
                            }
                            ?>
                        </div>
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
<?PHP include '../../../pages/html_end.php';
ob_end_flush();
?>
