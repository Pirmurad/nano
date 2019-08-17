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

    if ($_POST['direction']){
        $direction=(int)$_POST['direction'];
    }else{
        $direction=1;
    }

    $order=0;
    $ordering=$db->query("SELECT max(ordering) FROM gallery ORDER BY ordering DESC");
    $lastorder=$ordering->fetch(PDO::FETCH_ASSOC);
    $order=$lastorder['max(ordering)']+1;

    $image_name=htmlspecialchars(trim($_POST['image_name']));
    $data_create=time();
    $errors= [];

//    IMAGE UPLOAD
    $file_name = $_FILES['fileToUpload']['name'];
    $file_size =$_FILES['fileToUpload']['size'];
    $file_tmp =$_FILES['fileToUpload']['tmp_name'];
    $file_type=$_FILES['fileToUpload']['type'];

    if($file_size > 2097152){
       $errors['max_size']='Faylın ölçüsü 2 MB-dan ağır olmaz!';
    }

    $file_name = time().'.png';
    if(empty($errors)==true){
       move_uploaded_file($file_tmp,"{$path}uploads/gallery/".$file_name);
    }else{
        $errors['upload_error']='Şəkil yüklənmədi!';
    }

    if(empty($file_name) || empty($image_name)) {
        $errors['required'] = '* olan xanalar doldurulmalıdır';
    }
   
    
    if(count($errors) > 0) {
        $_SESSION['error'] = $errors;
        
        echo '<META HTTP-EQUIV=REFRESH CONTENT="0; gallery/create/">';
        exit();
    }

    $insertgallery = $db->prepare("INSERT INTO `banner` SET `direction`=:direction,`image`=:file_name,`image_name`=:image_name,`url`=:url,`data_create`=:data_create,`ordering`=:ordering,`status`=:status");
    $insertgallery->execute(array(
        ':direction' => $direction,
        ':file_name' => $file_name,
        ':image_name' => $image_name,
        ':url' => $url,
        ':data_create' => $data_create,
        ':ordering' => $order,
        ':status' => $status
    ));
    if($insertgallery) {
        echo '<META HTTP-EQUIV=REFRESH CONTENT="0; gallery/list/">';
        exit;
    }
    else {
        $errors['error'] = 'Problem baş verdi, gallery əlavə olunmadı !';
        $_SESSION['error'] = $errors;
        echo '<META HTTP-EQUIV=REFRESH CONTENT="0; gallery/create/">';
        exit;
    }

}else{
?>
<h1 class="page-header">gallery əlavə et</h1>
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
                    <input type="url" id="url" class="form-control" name="url" maxlength="100" placeholder="galleryin yönlənəcəyi səhifəsinin linki">
                </div>
                <div class="col-md-4">
                    <div class="checkbox">
                        <h4>Harada olduğunu seç</h4>
                        <label class="col-lg-3"><input type="checkbox" name="direction[]" value="1"><span class="deepskyblue glyphicon glyphicon-menu-up"></span></label>
                        <label class="col-lg-3"><input type="checkbox" name="direction[]" value="2"><span class="deepskyblue glyphicon glyphicon-menu-left"></span><span class="deepskyblue glyphicon glyphicon-menu-right"></span></label>
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
<?PHP include '../../pages/html_end.php';
ob_end_flush();
?>
