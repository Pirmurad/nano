<?PHP
ob_start();
$path='../../../';
$imagepath='../../';
include_once "{$path}config/conf.php";
include_once "../../pages/html_start.php";
include_once "{$imagepath}checkadmin.php";
?>
    <div id="wrapper">

        <?PHP include '../../nav.php';?>
	    <div id="page-wrapper">
		    <div class="row">
			    <div class="col-lg-12">

<?PHP
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	postextract(extract($_POST));

	$title = mb_substr(strip_tags($name), 0, 60);
	$description = mb_substr(strip_tags($text), 0, 160);

    $param = [];

    if (!empty($product)){
        foreach ($product as $key=>$value){
            $param[] = [$key=>$value];
        }
    }

    $par = json_encode($param);

    $order=0;
    $ordering = select("MAX(ordering)","`product`","`ordering`")->fetch(PDO::FETCH_ASSOC);
    $order=$ordering['MAX(ordering)']+1;

    if (empty($linkname)){$linkname=$name;}
    $linkname = dolinkname($linkname,$unwanted_array);

    include $imagepath . 'SimpleImageFull.php';

    $errors= [];

    $file = $_FILES['fileToUpload']['tmp_name'];
	$resize = ['350','350','226','226'];
	$folder = "product";
    $table = "product";
    $getId = get('id');
    $errorredirect = "product/create/";
    $deleteimagecolumn = "image";
    $transparent = "0";

    $file_name = imageupload($file,$path,$imagepath,$resize,$deleteimagecolumn,$table,$getId,$folder,$errorredirect,$transparent);

    if(count($errors) > 0) {$_SESSION['errors'] = $errors;redirect("product/create/");}

    $data =	"`type_id` = ?,`category_id` = ?,`brand_id` = ?,`kredit_id` = ?,`param` = ?,`name` = ?,`linkname` = ?, `image` = ?, `price` = ?,`eprice` = ?,`xprice` = ?, `note` = ?,`title` = ?,`description` = ?,`keyword` = ?,`view_count` = ?,`data_create` = ?,`data_update` = ?,`ordering` = ?,`status` = ?";

    $sql =	[
    		$type_id,$category_id,$brand_id,intval($kredit_id),$par,$name,$linkname,$file_name,$price,intval($eprice),intval($xprice),$note,$title,$description,$keyword,"0",time(),time(),$order,$status
    ];

	$insertproduct = insert("`product`",$data,$sql);


    if($insertproduct) {
        $kredit = prepare("*","`kredit`","`id`=?",[$kredit_id])->fetch(PDO::FETCH_ASSOC);
        $kredit_ay = json_decode($kredit['ay'],true);

        $risk_faizi = $price*$kredit['risk_faizi']/100;
        $zemanet_faizi = $price*$kredit['zemanet_faizi']/100;

        $baza = $price + $risk_faizi;

        $ilkin_odenis = floor($baza*$kredit['ilkin_odenis']/100);
        $hesab = $baza - $ilkin_odenis;

        $ay = [];
        foreach ($kredit_ay as $key => $k) {
            if (intval($k[$key])>0){
                $ay_faiz = $k[$key];
                $faiz = $hesab*$ay_faiz/100;
                $hesab1 = $hesab + $faiz;
                $hesab2 = $hesab1 + $zemanet_faizi + $kredit['xerc1'] + $kredit['xerc2'];
                $hesab3 = $hesab2/(++$key);
                $ay[] = [--$key=>ceil($hesab3)];
                $faizsiz .= "";
            }elseif($k[$key]=="0"){
                $hesab3 = $hesab/(++$key);
                $ay[] = [--$key=>ceil($hesab3)];
                $faizsiz .= ++$key.",";
            }elseif(empty($k[$key])){
                $ay[] = [--$key=>''];
                $faizsiz .= "";
            }
        }
        $ay_kr = json_encode($ay);

        $data =	"`kredit_id` = ?,`product_id` = ?,`ilkin_odenis` = ?,`ay` = ?,`faizsiz` = ?,`data_create` = ?,`data_update` = ?";

        $sql =	[
            intval($kredit_id),intval($insertproduct),$ilkin_odenis,$ay_kr,time(),time()
        ];

        $insertkredit = insert("`kredit_product`",$data,$sql);

        redirect("product/list/");
    }
    else {
        $errors['errors'] = 'Problem baş verdi, elan əlavə olunmadı !';
        $_SESSION['errors'] = $errors;
        redirect("product/create/");
    }

}else{
    $typefetch = select("`id`,`name`","`type`","`id`","ASC")->fetchAll(PDO::FETCH_ASSOC);
    $brands    = select("`id`,`name`","`brand`","`id`","ASC");
    $kreditfetch    = select("`id`,`name`","`kredit`","`id`","ASC");
?>

<h1 class="page-header">Məhsul əlavə et</h1>
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
	            <?PHP
	            	$name='name';
	            	$placeholder = 'Məhsulun adı *';
                    echo addInput("col-md-4",$placeholder,$name,$placeholder,0,"text","100","1");
	            ?>
                <div class="col-md-4">
                    <label for="linkname"><span>Link adı</span></label><br>
                    <input type="text" id="linkname" name="linkname" required maxlength="100" class="form-control" placeholder="Link adı *"/>
                </div>
                <?PHP
                $name='keyword';
                $placeholder = 'Açar Sözlər *';
                echo addInput("col-md-4",$placeholder,$name,$placeholder,0,"text","150","1");
                ?>

            </div>
	        <div class="col-md-12 p10">

                <div class="col-md-4">
                    <label for="eprice"><span>Bazar Qiyməti</span></label><br>
                    <input type="number" id="eprice" name="eprice" maxlength="100" class="form-control" placeholder="Bazar Qiyməti *" step="0.01"/>
                </div>
                <div class="col-md-4">
                    <label for="price"><span>Qiyməti</span></label><br>
                    <input type="number" id="price" name="price" required maxlength="100" class="form-control" placeholder="Qiyməti *" step="0.01"/>
                </div>
                <div class="col-md-4">
                    <label for="xprice"><span>Xüsusi Qiyməti</span></label><br>
                    <input type="number" id="xprice" name="xprice" maxlength="100" class="form-control" placeholder="Xüsusi Qiyməti *" step="0.10"/>
                </div>
	        </div>
	        <div class="col-md-12 p10">
		        <div class="col-lg-4">
			        <label for="type_id"><span>Hansı tipə aid oldugunu seç</span></label><br>
			        <select  id="type_id" name="type_id"  class="form-control selectpicker" data-live-search="true">
                        <option value="0">--Tip seçin--</option>
                        <?PHP
                        foreach ($typefetch as $type) {
                            echo '<option value="'.$type['id'].'">'.$type['name'].'</option>';
                        }
                        ?>
			        </select>
		        </div>
		        <div class="col-lg-4">
			        <label for="category_id"><span>Hansı kateqoriyaya aid oldugunu seç</span></label><br>
			        <select id="category_id" name="category_id" class="form-control selectpicker" data-live-search="true">
                        <?PHP
                        echo multilevelMenu("category",0,"",0,0,0);
                        ?>
			        </select>
		        </div>
                <div class="col-lg-4">
                    <label for="brand_id"><span>Hansı brendə aid oldugunu seç</span></label><br>
                    <select id="brand_id" name="brand_id" class="form-control selectpicker" data-live-search="true">
                        <? while($brand = fetch($brands)):?>
                            <option value="<?= $brand['id'] ?>"><?= $brand['name'] ?></option>
                        <? endwhile; ?>
                    </select>
                </div>
            </div>
            <div class="col-md-12 p10">
                <div class="col-lg-4">
                    <label for="kredit_id"><span>Kredit kampaniyasını seç</span></label><br>
                    <select id="kredit_id" name="kredit_id" class="form-control selectpicker" data-live-search="true">
                        <option value="0">--Kredit kampaniyası seçin--</option>
                        <? while($kredit = fetch($kreditfetch)):?>
                            <option value="<?= $kredit['id'] ?>"><?= $kredit['name'] ?></option>
                        <? endwhile; ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="fileToUpload"><span>Şəkil yüklə</span></label><br>
                    <input type="file" class="form-control" name="fileToUpload" required id="fileToUpload"/>
                </div>
                <div class="col-md-2 col-md-offset-1">
                    <label for="statusyes">Görünürlüyünü seç</label>
                    <div class="radio form-control">
                        <label id="statusyes" class="mr10"><input type="radio" checked="checked" name="status" value="1"><span class="green glyphicon glyphicon-eye-open"></span></label>
                        <label class="fr"><input type="radio" name="status" value="0"><span class="red glyphicon glyphicon-eye-close"></span></label>
                    </div>
                </div>
            </div>
            <div class="col-md-12 p10">
                <?PHP
                $name='note';
                $placeholder = 'Not *';
                echo addInput("col-md-12",$placeholder,$name,$placeholder,0,"text","100","0");
                ?>
            </div>
            <div id="tip_product" class="tipler"></div>
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
            <div class="modal fade" id="newParamVAlue" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                    </div>
                </div>
            </div>
        </div>
        <!-- /#page-wrapper -->

    </div>
<!-- /#wrapper -->
<?PHP include '../../pages/html_end.php';
ob_end_flush();
?>
