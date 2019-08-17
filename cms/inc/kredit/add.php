<?PHP
ob_start();
$path='../../../';
$imagepath='../../';
include_once "{$path}config/conf.php";
include_once "../../pages/html_start.php";
include_once "{$imagepath}checkadmin.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    postextract(extract($_POST));
    $errors= [];

    $order=0;
    $lastorder = select("MAX(ordering)","`kredit`","`ordering`","DESC")->fetch(PDO::FETCH_ASSOC);
    $order=$lastorder['MAX(ordering)']+1;

    $ay_faiz = [];
    if (!empty($ay)){
        foreach ($ay as $key=>$value){
            $ay_faiz[] = [$key=>$value];
        }
    }

    $ay_faiz = json_encode($ay_faiz);

    if(count($errors) > 0) {
        session_create(['errors'=>$errors]);
        redirect("kredit/create/");
    }

    $data =	"`name` = ?,`risk_faizi` = ?,`ilkin_odenis` = ?, `zemanet_faizi` = ?,`xerc1` = ?,`xerc2` = ?,`note` = ?,`ay` = ?,`data_create` = ?,`data_update` = ?,`ordering` = ?,`status` = ?";

    $sql =	[
        $name,$risk_faizi,$ilkin_odenis,$zemanet_faizi,$xerc1,$xerc2,$note,$ay_faiz,time(),time(),$order,$status
    ];

    $insertkredit =	insert("`kredit`",$data,$sql);

    if(!empty($insertkredit)) {
        redirect("kredit/list/");
    }else {
        $errors['error'] = 'Problem baş verdi, kredit kampaniyası əlavə olunmadı !';
        session_create(['error'=>$errors]);
        redirect("kredit/create/");
    }

}else{
?>
    <div id="wrapper">

    <?PHP include '../../nav.php';?>

    <div id="page-wrapper">
    <div class="row">
    <div class="col-lg-12">
    <h1 class="page-header">Kampaniya əlavə et</h1>
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
                    <label for="name"><span>Adı</span></label><br>
                    <input type="text" id="name" name="name" required maxlength="100" class="form-control" placeholder="Adı *"/>
                </div>
                <div class="col-lg-2">
		            <label for="risk_faizi"><span>Risk faizi</span></label><br>
		            <input type="number" id="risk_faizi" name="risk_faizi" required maxlength="4"  class="form-control" placeholder="Risk faizi *" step="0.10"/>
	            </div>
                <div class="col-lg-2">
                    <label for="ilkin_odenis"><span>İlkin ödəniş</span></label><br>
                    <input type="number" id="ilkin_odenis" name="ilkin_odenis" required maxlength="6"  class="form-control" placeholder="İlkin ödəniş *" step="0.10"/>
                </div>
                <div class="col-lg-2">
                    <label for="zemanet_faizi"><span>Zemanet faizi</span></label><br>
                    <input type="number" id="zemanet_faizi" name="zemanet_faizi" required maxlength="4"  class="form-control" placeholder="zemanet faizi *" step="0.10"/>
                </div>
                <div class="col-lg-2">
                    <label for="statusyes">Görünürlüyünü seç</label>
                    <div class="radio form-control">
                        <label id="statusyes" class="mr10"><input type="radio" checked="checked" name="status" value="1"><span class="green glyphicon glyphicon-eye-open"></span></label>
                        <label class="fr"><input type="radio" name="status" value="0"><span class="red glyphicon glyphicon-eye-close"></span></label>
                    </div>
                </div>
            </div>
            <div class="col-lg-12 p10">
                <div class="col-lg-2">
                    <label for="xerc1"><span>Xərc 1</span></label><br>
                    <input type="number" id="xerc1" name="xerc1" required maxlength="6"  class="form-control" placeholder="Xərc 1 *" step="0.10"/>
                </div>
                <div class="col-lg-2">
                    <label for="xerc2"><span>Xərc 2</span></label><br>
                    <input type="number" id="xerc2" name="xerc2" required maxlength="6"  class="form-control" placeholder="Xərc 2 *" step="0.10"/>
                </div>
                <div class="col-lg-8">
                    <label for="note"><span>Not</span></label><br>
                    <input type="text" id="note" name="note" class="form-control" value="*Məhsul nisyə satılan zaman məhsulun rəsmiləşdirilməsi üçün 5-8% xidmət haqqı əlavə olunur.<br>**Məhsul nisyə satılan zamanı sistemdə yuvarlaqlaşdırma tətbiq olunduğuna görə ümumi qiymətdə fərq alına bilər."/>
                </div>
            </div>
            <div class="col-lg-12 p10">
                <? for ($i=1;$i<=18;$i++): ?>
                    <div class="col-lg-2">
                        <label for="ay<?= $i ?>"><span>Ay <?= $i ?></span></label><br>
                        <input type="number" id="ay<?= $i ?>" name="ay[]" maxlength="3"  class="form-control" placeholder="Ay <?= $i ?> *" step="0.10" value="0"/>
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
<?PHP include '../../pages/html_end.php';
ob_end_flush();
?>