<?PHP
ob_start();
$path='../../../../../';
$imagepath='../../../../';
include_once "{$path}config/conf.php";
include_once "../../../../pages/html_start.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $errors= [];
    postextract(extract($_POST));

    if (empty($linkname)){$linkname=$name;}
    $linkname = dolinkname($linkname,$unwanted_array);

    $data = "`name` = ?,`linkname` = ?,`status` = ?";

    $sql = [
        $name,
        $linkname,
        $status,
        get('value_id')
    ];

    $updatetype = update("`value`",$data,"`id`=?",$sql);

    if($updatetype) {
        redirect("type/".get('type_id')."/param/".get('param_id')."/value/list/");
    }
    else {
        $errors['errors'] = 'Problem baş verdi, dəyər dəyişilmədi !';
        $_SESSION['errors'] = $errors;

        redirect("type/".get('type_id')."/param/".get('param_id')."/value/edit/".get('value_id')."/");
    }

}else{
$valuefetch = prepare("*","`value`","`id`=?",[get('value_id')])->fetch(PDO::FETCH_ASSOC);
$param = prepare("`name`","`type_param`","`id`=?",[get('param_id')])->fetch(PDO::FETCH_ASSOC);
    ?>
<div id="wrapper">

    <?PHP include '../../../../nav.php';?>

    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
    <h1 class="page-header"><strong><?= ucfirst($param['name']) ?></strong> parametrinin <strong><?=ucfirst($valuefetch['name']);?></strong> dəyərini Dəyiş</h1>
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
                        <label for="name"><span>Adı</span></label><br>
                        <input type="text" id="name" name="name" required maxlength="100" class="form-control" value="<?= $valuefetch['name'];?>"/>
                    </div>
                    <div class="col-md-2 col-md-offset-1">
                        <label for="statusyes">Görünürlüyünü seç</label>
                        <div class="radio form-control">
                            <label id="statusyes" class="mr10"><input type="radio" name="status" value="1" <?= ($valuefetch['status']=='1') ? 'checked="checked"' : '' ?>><span class="green glyphicon glyphicon-eye-open"></span></label>
                            <label class="fr"><input type="radio" name="status" value="0" <?= ($valuefetch['status']=='0') ? 'checked="checked"' : '' ?>><span class="red glyphicon glyphicon-eye-close"></span></label>
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
<?PHP include '../../../../pages/html_end.php';
ob_end_flush();
?>
