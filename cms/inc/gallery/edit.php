<?PHP
ob_start();
$path='../../../';
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
    $status=htmlspecialchars(trim($_POST['status']));
    $url=htmlspecialchars(trim($_POST['url']));
    $image_name=htmlspecialchars(trim($_POST['image_name']));
    if ($_POST['direction']){
        $direction=(int)$_POST['direction'];
    }else{
        $direction=1;
    }

    $errors= array();

//    IMAGE UPLOAD
    if ($_FILES['fileToUpload']['name']){
        $file_name = $_FILES['fileToUpload']['name'];
        $file_size =$_FILES['fileToUpload']['size'];
        $file_tmp =$_FILES['fileToUpload']['tmp_name'];
        $file_type=$_FILES['fileToUpload']['type'];

        if($file_size > 2097152){
            $errors[]='File size must be excately 2 MB';
        }

        $file_name = time().'.png';
    }else{

        $file_name='';
    }

    if(empty($image_name)) {
        $errors['required'] = '* olan xanalar doldurulmalıdır';
    }

    if(count($errors) > 0) {
        $_SESSION['error'] = $errors;

        echo '<META HTTP-EQUIV=REFRESH CONTENT="0; gallery/edit/'.$_GET['id'].'">';
        exit();
    }

    if(empty($errors)==true){
        if (empty($file_name)){
            $deleteimage = $db->prepare("SELECT `image` FROM `gallery` WHERE `id`=:id");
            $deleteimage->execute(array(":id"=>$_GET['id']));
            $delimage = $deleteimage->fetch(PDO::FETCH_ASSOC);
            $file_name = $delimage['image'];
        }else {
            if ($delimage['image'] != null) {
                unlink("{$path}uploads/gallery/{$delimage['image']}");
            }
            move_uploaded_file($file_tmp, "{$path}uploads/gallery/" . $file_name);
        }
    }else{
        print_r($errors);
        exit();
    }

    $updategallery = $db->prepare("UPDATE `gallery` SET `direction`=:direction,`image`=:file_name,`image_name`=:image_name,`url`=:url,`status`=:status WHERE `id`=:id");
    $updategallery->execute(array(
        ':direction' => $direction,
        ':file_name' => $file_name,
        ':image_name' => $image_name,
        ':url' => $url,
        ':status' => $status,
        ':id' => $_GET['id']
    ));
    if($updategallery) {
        echo '<META HTTP-EQUIV=REFRESH CONTENT="0; gallery/list/">';
    }
    else {
        $errors['error'] = 'Problem baş verdi, gallery dəyişilmədi !';
        $_SESSION['error'] = $errors;

        echo '<META HTTP-EQUIV=REFRESH CONTENT="0; gallery/edit/'.$_GET['id'].'/">';
    }

}else{
    $galleryquery=$db->query("SELECT * FROM `gallery`");
    $galleryfetch=$galleryquery->fetch(PDO::FETCH_ASSOC);
    ?>
    <h1 class="page-header">gallery Dəyiş</h1>
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
                        <input type="text" id="image_name" name="image_name" required maxlength="100" class="form-control" value="<?= $galleryfetch['image_name'];?>"/>
                    </div>
                    <div class="col-md-4">
                        <label for="statusyes">Görünürlüyünü seç</label>
                        <div class="radio">
                            <?PHP
                            if ($galleryfetch['status']==0) {
                                echo '<label id="statusyes" class="mr10"><input type="radio" name="status" value="1"><span class="green glyphicon glyphicon-eye-open"></span></label>';
                                echo '<label><input type="radio" name="status" value="0" checked="checked"><span class="red glyphicon glyphicon-eye-close"></span></label>';
                            }elseif($galleryfetch['status']==1){
                                echo '<label id="statusyes" class="mr10"><input type="radio" name="status" checked="checked" value="1"><span class="green glyphicon glyphicon-eye-open"></span></label>';
                                echo '<label><input type="radio" name="status" value="0"><span class="red glyphicon glyphicon-eye-close"></span></label>';
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 p10">
                    <div class="col-md-4">
                        <label for="url"><span>Link</span></label><br>
                        <input type="url" id="url" class="form-control" name="url" maxlength="100" value="<?= $galleryfetch['url'];?>">
                    </div>
                    <div class="col-md-4">
                        <div class="checkbox">
                            <h4>Harada olduğunu seç</h4>
                            <?PHP
                            if ($galleryfetch['direction']==1){
                            echo "<label class='col-lg-3'><input type='checkbox' checked='checked' name='direction[]' value='1'><span class='deepskyblue glyphicon glyphicon-menu-left'></span></label>";
                            }else{
                            echo "<label class='col-lg-3'><input type='checkbox' name='direction[]' value='1'><span class='deepskyblue glyphicon glyphicon-menu-left'></span></label>";
                            }
                            if ($galleryfetch['direction']==2){
                                echo "<label class='col-lg-3'><input type='checkbox' checked='checked' name='direction[]' value='2'><span class='deepskyblue glyphicon glyphicon-menu-right'></span></label>";
                            }else{
                                echo "<label class='col-lg-3'><input type='checkbox' name='direction[]' value='2'><span class='deepskyblue glyphicon glyphicon-menu-right'></span></label>";
                            }
                            if ($galleryfetch['direction']==3){
                                echo "<label class='col-lg-3'><input type='checkbox' checked='checked' name='direction[]' value='1'><span class='deepskyblue glyphicon glyphicon-menu-left'></span></label>";
                                echo "<label class='col-lg-3'><input type='checkbox' checked='checked' name='direction[]' value='2'><span class='deepskyblue glyphicon glyphicon-menu-right'></span></label>";
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
