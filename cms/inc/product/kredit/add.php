<?PHP
ob_start();
$path='../../../../';
include_once "{$path}config/conf.php";
include_once "../../../pages/html_start.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    postextract(extract($_POST));
    $errors= [];

    $ay_faiz = [];
    if (!empty($ay)){
        foreach ($ay as $key=>$value){
            $ay_faiz[] = [$key=>$value];
        }
    }

    $ay_faiz = json_encode($ay_faiz);


    $data =	"`product_id` = ?,`kredit_id` = ?,`name` = ?,`ilkin_odenis` = ?,`ay` = ?,`data_create` = ?,`data_update` = ?";

    $sql =	[
        get('product_id'),"0",$name,$ilkin_odenis,$ay_faiz,time(),time()
    ];

    $insertkredit =	insert("`kredit_product`",$data,$sql);


    if(!empty($insertkredit)) {
        redirect("product/".get('product_id')."/kredit/list/");
    }else {
        $errors['error'] = 'Problem baş verdi, kredit əlavə olunmadı !';
        session_create(['error'=>$errors]);
        redirect("product/".get('product_id')."/kredit/create/");
    }

}else{
?>
    <div id="wrapper">

    <?PHP include '../../../nav.php';?>

    <div id="page-wrapper">
    <div class="row">
    <div class="col-lg-12">
    <h1 class="page-header">Kredit əlavə et</h1>
<div class="row">
    <div class="col-lg-12 p10 round_border_goster">
        <form action="" id="kredit_add_submit" method="POST"  enctype="multipart/form-data">
            
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
                    <input type="number" id="ilkin_odenis" name="ilkin_odenis" required maxlength="6"  class="form-control" placeholder="İlkin ödəniş *" step="0.10"/>
                </div>
                <div class="col-lg-4">
                    <label for="name"><span>Kredit adı</span></label><br>
                    <input type="text" id="name" name="name" maxlength="100" class="form-control" placeholder="Kredit adı"/>
                </div>
            </div>
            <div class="col-lg-12 p10">
                <? for ($i=1;$i<=18;$i++): ?>
                    <div class="col-lg-2">
                        <label for="ay<?= $i ?>"><span>Ay <?= $i ?></span></label><br>
                        <input type="number" id="ay<?= $i ?>" name="ay[]" maxlength="3"  class="form-control" placeholder="Ay <?= $i ?> *" step="0.10"/>
                    </div>
                <? endfor; ?>
            </div>
            <div class="col-lg-12 p10  ">
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