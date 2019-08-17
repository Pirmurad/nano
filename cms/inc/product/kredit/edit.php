<?PHP
ob_start();
$path='../../../../';
include_once "{$path}config/conf.php";
include_once "../../../pages/html_start.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    postextract(extract($_POST));

    $ay_faiz = [];
    if (!empty($ay)){
        foreach ($ay as $key=>$value){
            $ay_faiz[] = [$key=>$value];
        }
    }

    $ay_faiz = json_encode($ay_faiz);

    $data =	"`ilkin_odenis` = ?,`name` = ?,`ay` = ?,`data_update` = ?";

    $sql =	[
        $ilkin_odenis,$name,$ay_faiz,time(),get('kredit_id')
    ];

    $updatekredit = update("`kredit_product`",$data,"`id` = ?",$sql);
    
    if(!empty($updatekredit)) {
        redirect("product/".get('product_id')."/kredit/list/");
    }
    else {
        $errors['errors'] = 'Problem baş verdi, kampaniya dəyişilmədi !';
        $_SESSION['errors'] = $errors;
        redirect('product/'.get('product_id').'/kredit/edit/'.get('kredit_id'));
    }
}else{
    $kreditfetch = prepare("*","`kredit_product`","`id`=?",[get('kredit_id')])->fetch(PDO::FETCH_ASSOC);
    $kredit_ay = json_decode($kreditfetch['ay'],true);
    $product = prepare("`name`","`product`","`id`=?",[get('product_id')])->fetch(PDO::FETCH_ASSOC);
?>
<div id="wrapper">

    <?PHP include '../../../nav.php';?>

    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header"><b><?= $product['name'] ?></b> məhsulunun kreditinə düzəliş et</h1>
<div class="row">
    <div class="col-lg-12 p10 round_border_goster">
        <form action="" id="kredit_add_submit" method="POST" enctype="multipart/form-data">
            
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
	        <div class="col-lg-12 p10">
                <div class="col-lg-4">
                    <label for="ilkin_odenis"><span>İlkin ödəniş</span></label><br>
                    <input type="number" id="ilkin_odenis" name="ilkin_odenis" required maxlength="6"  class="form-control" value="<?= $kreditfetch['ilkin_odenis'] ?>" step="0.10"/>
                </div>
                <div class="col-lg-4">
                    <label for="name"><span>Kreditin adı</span></label><br>
                    <input type="text" id="name" name="name" maxlength="100"  class="form-control" value="<?= $kreditfetch['name'] ?>" />
                </div>
            </div>
            <div class="col-lg-12 p10">
                <? if (!empty($kredit_ay)):
                    foreach($kredit_ay as $value):
                        foreach($value as $key=>$v):?>
                            <div class="col-md-1">
                                <label for="<?= ++$key ?>_ay"><span><?= $key ?>-ci ay</span></label><br>
                                <input type="number" class="form-control" name="ay[]" id="<?= $key ?>_ay" value="<?= $v ?>"/>
                            </div>
                        <?
                        endforeach;
                    endforeach;
                else:
                    for ($i=1;$i<=18;$i++): ?>
                        <div class="col-md-1">
                            <label for="<?= $i ?>_ay"><span><?= $i ?>-ci ay</span></label><br>
                            <input type="number" class="form-control" name="ay[]" id="<?= $i ?>_ay"/>
                        </div>
                    <? endfor; endif; ?>
            </div>
            <div class="col-lg-12 p10  ">
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
