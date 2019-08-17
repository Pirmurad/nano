<?PHP
ob_start();
$path='../../../';
$imagepath='../../';
include_once "{$path}config/conf.php";
include_once "../../pages/html_start.php";
include_once "{$imagepath}checkadmin.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    postextract(extract($_POST));

    $ay_faiz = [];
    if (!empty($ay)){
        foreach ($ay as $key=>$value){
            $ay_faiz[] = [$key=>$value];
        }
    }

    $ay_faiz = json_encode($ay_faiz);

    $data =	"`name` = ?,`risk_faizi` = ?,`ilkin_odenis` = ?, `zemanet_faizi` = ?,`xerc1` = ?,`xerc2` = ?,`note` = ?,`ay` = ?,`data_update` = ?,`status` = ?";

    $sql =	[
        $name,$risk_faizi,$ilkin_odenis,$zemanet_faizi,$xerc1,$xerc2,$note,$ay_faiz,time(),$status,get('id')
    ];

    $updatekredit = update("`kredit`",$data,"`id` = ?",$sql);
    
    if(!empty($updatekredit)) {
        redirect("kredit/list/");
    }
    else {
        $errors['errors'] = 'Problem baş verdi, kampaniya dəyişilmədi !';
        $_SESSION['errors'] = $errors;
        redirect('kredit/edit/'.get('id'));
    }
}else{
    $kreditfetch = prepare("*","`kredit`","`id`=?",[get('id')])->fetch(PDO::FETCH_ASSOC);
    $kredit_ay = json_decode($kreditfetch['ay'],true);
?>
<div id="wrapper">

    <?PHP include '../../nav.php';?>

    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header"><b><?=$kreditfetch['name'];?></b> kampaniyasina düzəliş et</h1>
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
			        <label for="name"><span>Adı</span></label><br>
			        <input type="text" id="name" name="name" required maxlength="100" class="form-control" value="<?= $kreditfetch['name'];?>"/>
		        </div>
                <div class="col-lg-2">
                    <label for="risk_faizi"><span>Risk faizi</span></label><br>
                    <input type="number" id="risk_faizi" name="risk_faizi" required maxlength="4"  class="form-control" value="<?= $kreditfetch['risk_faizi'] ?>" step="0.10"/>
                </div>
                <div class="col-lg-2">
                    <label for="ilkin_odenis"><span>İlkin ödəniş</span></label><br>
                    <input type="number" id="ilkin_odenis" name="ilkin_odenis" required maxlength="6"  class="form-control" value="<?= $kreditfetch['ilkin_odenis'] ?>" step="0.10"/>
                </div>
                <div class="col-lg-2">
                    <label for="zemanet_faizi"><span>Zemanet faizi</span></label><br>
                    <input type="number" id="zemanet_faizi" name="zemanet_faizi" required maxlength="4"  class="form-control" value="<?= $kreditfetch['zemanet_faizi'] ?>" step="0.10"/>
                </div>
                <div class="col-lg-2">
                    <label for="statusyes">Görünürlüyünü seç</label>
                    <div class="radio form-control">
                        <label id="statusyes" class="mr10"><input type="radio" name="status" value="1" <?= ($kreditfetch['status']=='1') ? 'checked="checked"' : '' ?>><span class="green glyphicon glyphicon-eye-open"></span></label>
                        <label class="fr"><input type="radio" name="status" value="0" <?= ($kreditfetch['status']=='0') ? 'checked="checked"' : '' ?>><span class="red glyphicon glyphicon-eye-close"></span></label>
                    </div>
                </div>
	        </div>
            <div class="col-lg-12 p10">
                <div class="col-lg-2">
                    <label for="xerc1"><span>Xərc 1</span></label><br>
                    <input type="number" id="xerc1" name="xerc1" required maxlength="6"  class="form-control" value="<?= $kreditfetch['xerc1'] ?>" step="0.10"/>
                </div>
                <div class="col-lg-2">
                    <label for="xerc2"><span>Xərc 2</span></label><br>
                    <input type="number" id="xerc2" name="xerc2" required maxlength="6"  class="form-control" value="<?= $kreditfetch['xerc2'] ?>" step="0.10"/>
                </div>
                <div class="col-lg-8">
                    <label for="note"><span>Not</span></label><br>
                    <input type="text" id="note" name="note" class="form-control" value="<?= $kreditfetch['note'] ?>"/>
                </div>
            </div>
            <div class="col-lg-12 p10">
                <? if (!empty($kredit_ay)):
                    foreach($kredit_ay as $value):
                        foreach($value as $key=>$v):?>
                            <div class="col-md-1">
                                <label for="<?= $key+1 ?>_ay"><span><?= $key+1 ?>-ci ay</span></label><br>
                                <input type="number" class="form-control" name="ay[]" id="<?= $key+1 ?>_ay" value="<?= $v ?>"/>
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
<?PHP include '../../pages/html_end.php';
ob_end_flush();
?>
