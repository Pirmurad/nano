<?PHP
ob_start();
$path='../../../';
$imagepath='../../';
include_once "{$path}config/conf.php";
include_once "../../pages/html_start.php";
include_once "{$imagepath}checkadmin.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $errors= [];
    postextract(extract($_POST));

    include $imagepath . 'SimpleImageFull.php';

    $file = $_FILES['fileToUpload']['tmp_name'];
    $resize = ["173","94"];
    $folder = "brand";
    $table = "brand";
    $getId = get('id');
    $errorredirect = "brand/edit/".get('id')."/";
    $deleteimagecolumn = "image";
    $transparent = "0";

    $file_name = imageupload($file,$path,$imagepath,$resize,$deleteimagecolumn,$table,$getId,$folder,$errorredirect,$transparent);

    if (empty($linkname)){$linkname=$name;}
    $linkname = dolinkname($linkname,$unwanted_array);
    
    $data = "`image` = ?,`name` = ?,`linkname` = ?,`data_update` = ?,`status` = ?";

    $sql = [
        $file_name,
        $name,
        $linkname,
        time(),
        $status,
        get('id')
    ];

    $updatebrand = update("`brand`",$data,"`id`=?",$sql);

    if($updatebrand) {
        $selectbrandtype = prepare("`id`","`brand`","`id`=?",[get('id')])->fetch(PDO::FETCH_ASSOC);
        delete("`brand_type`","`brand_id`=?",[$selectbrandtype['id']]);

        foreach($type_id as $type) {
            $data = "`brand_id` = ?,`type_id` = ?";

            $sql = [
                get('id'),
                $type
            ];

            $insertbrandtype = insert("`brand_type`", $data, $sql);
        }

        redirect("brand/list/");
    }
    else {
        $errors['errors'] = 'Problem baş verdi, brend dəyişilmədi !';
        $_SESSION['errors'] = $errors;

        redirect("brand/edit/".get('id')."/");
    }

}else{
    $brandfetch = prepare("*","`brand`","`id`=?",[get('id')])->fetch(PDO::FETCH_ASSOC);
    $typefetch = select("`id`,`name`","`type`","`id`","ASC")->fetchAll(PDO::FETCH_ASSOC);
    $brandtypefetch = prepare("`type_id`","`brand_type`","`brand_id`=?",[get('id')])->fetchAll(PDO::FETCH_ASSOC);
?>
<div id="wrapper">

    <?PHP include '../../nav.php';?>

    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
    <h1 class="page-header"><?=$brandfetch['name'];?> brendini Dəyiş</h1>
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
                        <label for="name"><span>Adı</span></label><br>
                        <input type="text" id="name" name="name" required maxlength="100" class="form-control" value="<?= $brandfetch['name'];?>"/>
                    </div>
                    <div class="col-md-2 col-md-offset-1">
                        <label for="statusyes">Görünürlüyünü seç</label>
                        <div class="radio form-control">
                            <label id="statusyes" class="mr10"><input type="radio" name="status" value="1" <?= ($brandfetch['status']=='1') ? 'checked="checked"' : '' ?>><span class="green glyphicon glyphicon-eye-open"></span></label>
                            <label class="fr"><input type="radio" name="status" value="0" <?= ($brandfetch['status']=='0') ? 'checked="checked"' : '' ?>><span class="red glyphicon glyphicon-eye-close"></span></label>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 p10">
                    <div class="col-md-4">
                        <label for="linkname"><span>Link adı</span></label><br>
                        <input type="text" id="linkname" name="linkname" maxlength="100" class="form-control" value="<?= $brandfetch['linkname'];?>"/>
                    </div>
                    <div class="col-lg-4">
                        <label for="type_id"><span>Hansı tipə aid oldugunu seç</span></label><br>
                        <select id="type_id" name="type_id[]" multiple class="form-control">
                            <?PHP foreach ($typefetch as $type) { ?>
                            <option value="<?= $type['id'] ?>"
                                <? foreach ($brandtypefetch as $brandtype):
                                    if($brandtype['type_id']==$type['id']){
                                        echo 'selected="selected"';
                                    }
                                endforeach; ?>
                            ><?= $type['name']?></option>
                            <? } ?>
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
