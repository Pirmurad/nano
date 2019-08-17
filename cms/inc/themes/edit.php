<?PHP
ob_start();
$path='../../../';
$imagepath='../../';
include_once "{$path}config/conf.php";
include_once "{$path}helper/func.php";
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
    $data_update=time();

    include $imagepath . 'SimpleImageFull.php';

    $errors= [];

    $file = $_FILES['fileToUpload']['tmp_name'];
    $resize = [];
    $folder = "themes";
    $table = "themes";
    $getId = get('id');
    $errorredirect = "themes/edit/".get('id')."/";
    $deleteimagecolumn = "image";

    $file_name = imageupload($file,$path,$imagepath,$resize,$deleteimagecolumn,$table,$getId,$folder,$errorredirect);

    $data =	"`image` = ?, `name` = ?,`data_update` = ?,`status` = ?";

    $sql =	[
        $file_name,$name,$data_update,$status,get('id')
    ];

    $updatethemes = update("`themes`",$data,"id=?",$sql);

    if($updatethemes) {
        redirect("themes/list/");
    }
    else {
        $errors['errors'] = 'Problem baş verdi, tema əlavə olunmadı !';
        $_SESSION['errors'] = $errors;
        redirect("themes/edit/".get('id')."/");
    }

}else{
    $themesfetch = prepare("*","`themes`","`id`=?",[get('id')]);
    $themesfetch = $themesfetch[0];
    ?>
	<h1 class="page-header"><b><?=$themesfetch['name'];?></b> temasını dəyiş</h1>
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
		                <label for="name"><span>Adı</span></label><br>
		                <input type="text" id="name" name="name" required maxlength="100" class="form-control" value="<?= $themesfetch['name'];?>"/>
	                </div>
                    <div class="col-md-4">
                        <label for="fileToUpload"><span>Şəkil yüklə</span></label><br>
                        <input type="file" class="form-control" name="fileToUpload" id="fileToUpload"/>
                    </div>

                    <div class="col-md-4">
                        <label for="statusyes">Görünürlüyünü seç</label>
                        <div class="radio">
                            <?PHP
                            if ($themesfetch['status']==0) {
                                echo '<label id="statusyes" class="mr10"><input type="radio" name="status" value="1"><span class="green glyphicon glyphicon-eye-open"></span></label>';
                                echo '<label><input type="radio" name="status" value="0" checked="checked"><span class="red glyphicon glyphicon-eye-close"></span></label>';
                            }elseif($themesfetch['status']==1){
                                echo '<label id="statusyes" class="mr10"><input type="radio" name="status" checked="checked" value="1"><span class="green glyphicon glyphicon-eye-open"></span></label>';
                                echo '<label><input type="radio" name="status" value="0"><span class="red glyphicon glyphicon-eye-close"></span></label>';
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
<?PHP include '../../pages/html_end.php';
ob_end_flush();
?>
