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
                    $errors= [];
                    postextract(extract($_POST));

                    $title = mb_substr(strip_tags($name), 0, 60);
                    $description = mb_substr(strip_tags($text), 0, 160);

                    if (empty($linkname)){$linkname=$name;}
                    $linkname = dolinkname($linkname,$unwanted_array);

                    include $imagepath . 'SimpleImageFull.php';

                    $file = $_FILES['fileToUpload']['tmp_name'];
                    $resize = ['350','350','226','226'];
                    $folder = "product";
                    $table = "product";
                    $getId = get('id');
                    $errorredirect = "product/edit/".get('id')."/";
                    $deleteimagecolumn = "image";
                    $transparent = "0";

                    $file_name = imageupload($file,$path,$imagepath,$resize,$deleteimagecolumn,$table,$getId,$folder,$errorredirect,$transparent);

                    if(count($errors) > 0) {$_SESSION['errors'] = $errors;redirect("product/edit/".get('id')."/");}

                    $param = [];
                    if (!empty($product)){
                        foreach ($product as $key=>$value){
                            $param[] = [$key=>$value];
                        }
                    }

                    $par = json_encode($param);



                    $data =	"`category_id` = ?,`brand_id` = ?,`kredit_id` = ?,`param` = ?,`name` = ?,`linkname` = ?, `image` = ?, `price` = ?,`eprice` = ?,`xprice` = ?, `note` = ?,`title` = ?,`description` = ?,`keyword` = ?,`data_update` = ?,`status` = ?";

                    $sql =	[
                            $category_id,$brand_id,$kredit_id,$par,$name,$linkname,$file_name,$price,$eprice,$xprice,$note,$title,$description,$keyword,time(),$status,get('id')
                    ];

	                $updateproduct = update("`product`",$data,"`id` = ?",$sql);

                    if($updateproduct) {
                        if ($kredit_id){
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
                            $kredit_product = prepare("*","`kredit_product`","`kredit_id`=? AND `product_id`=?",[$kredit_id,get('id')])->fetch(PDO::FETCH_ASSOC);
                            if ($kredit_product){
                                $data =	"`ilkin_odenis` = ?,`ay` = ?,`faizsiz` = ?,`data_update` = ?";

                                $sql =	[
                                    $ilkin_odenis,$ay_kr,$faizsiz,time(),get('id'),$kredit_id
                                ];

                                $updatekredit = update("`kredit_product`",$data,"`product_id` = ? AND `kredit_id`=?",$sql);
                            }else{
                                $data =	"`kredit_id` = ?,`product_id` = ?,`ilkin_odenis` = ?,`ay` = ?,`faizsiz` = ?,`data_create` = ?,`data_update` = ?";

                                $sql =	[
                                    intval($kredit_id),get('id'),$ilkin_odenis,$ay_kr,$faizsiz,time(),time()
                                ];

                                $insertkredit = insert("`kredit_product`",$data,$sql);
                            }
                        }

                        redirect("product/list/");
                    }else {
                        $errors['errors'] = 'Problem baş verdi, məhsul dəyişdirilə bilmədi !';
                        $_SESSION['errors'] = $errors;
                        redirect("product/edit/".get('id')."/");
                    }

                }else{
                    $product  =  prepare("*","`product`","`id`=?",[get('id')])->fetch(PDO::FETCH_ASSOC);
                    $params   =  prepare("`id`,`name`,`linkname`","`type_param`","`type_id`=?",[$product['type_id']],"`ordering`","ASC")->fetchAll(PDO::FETCH_ASSOC);
                    $param = json_decode($product['param'],true);
                    $kreditfetch    = select("`id`,`name`","`kredit`","`id`","ASC");
                    $brands    = select("`id`,`name`","`brand`","`id`","ASC");
                    ?>
	                <h1 class="page-header"><b><?=$product['name'];?></b> məhsulunu dəyiş</h1>
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
	                                    $title       = 'Ad *';
	                                    $name        = 'name';
	                                    $placeholder = $product['name'];
                                        echo addInput("col-md-4",$title,$name,$placeholder,1,"text","100","1");
                                        $title       = 'Açar sözlər *';
                                        $name        = 'keyword';
                                        $placeholder = $product['keyword'];
                                        echo addInput("col-md-4",$title,$name,$placeholder,1,"text","150","1");
                                    ?>
                                    <div class="col-md-2 col-md-offset-1">
                                        <label for="statusyes">Görünürlüyünü seç</label>
                                        <div class="radio form-control">
                                            <label id="statusyes" class="mr10"><input type="radio" name="status" value="1" <?= ($product['status']=='1') ? 'checked="checked"' : '' ?>><span class="green glyphicon glyphicon-eye-open"></span></label>
                                            <label class="fr"><input type="radio" name="status" value="0" <?= ($product['status']=='0') ? 'checked="checked"' : '' ?>><span class="red glyphicon glyphicon-eye-close"></span></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 p10">
                                    <div class="col-md-4">
                                        <label for="xprice"><span>Xüsusi Qiyməti</span></label><br>
                                        <input type="number" id="xprice" name="xprice" maxlength="100" class="form-control" value="<?= $product['xprice'] ?>" step="0.01"/>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="price"><span>Qiyməti</span></label><br>
                                        <input type="number" id="price" name="price" required maxlength="100" class="form-control" value="<?= $product['price'] ?>" step="0.01"/>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="eprice"><span>Bazar Qiyməti</span></label><br>
                                        <input type="number" id="eprice" name="eprice" maxlength="100" class="form-control" value="<?= $product['eprice'] ?>" step="0.01"/>
                                    </div>
								</div>
								<div class="col-md-12 p10">
									<div class="col-lg-4">
										<label for="category_id"><span>Hansı kateqoriyaya aid oldugunu seç</span></label><br>
										<select id="category_id" name="category_id" class="form-control">
                                            <?PHP
                                            multilevelMenu("category",0,"",0,0,$product['category_id']);
                                            ?>
										</select>
									</div>
                                    <div class="col-lg-4">
                                        <label for="brand_id"><span>Hansı brendə aid oldugunu seç</span></label><br>
                                        <select id="brand_id" name="brand_id" class="form-control">
                                            <? while($brand = fetch($brands)):?>
                                                <option value="<?= $brand['id'] ?>" <?= ($brand['id']==$product['brand_id']) ? 'selected="selected"' : '' ?>><?= $brand['name'] ?></option>
                                            <? endwhile; ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="fileToUpload"><span>Şəkil yüklə</span></label><br>
                                        <input type="file" class="form-control" name="fileToUpload" id="fileToUpload"/>
                                    </div>
                                </div>
                                <div class="col-md-12 p10">
                                    <div class="col-md-4">
                                        <label for="linkname"><span>Link adı</span></label><br>
                                        <input type="text" id="linkname" name="linkname" required maxlength="100" class="form-control" value="<?=$product['linkname'];?>"/>
                                    </div>
                                    <?PHP
                                    $title       = 'Not *';
                                    $name        = 'note';
                                    $placeholder = $product['note'];
                                    echo addInput("col-md-4",$title,$name,$placeholder,1,"text","150","0");
                                    ?>
                                    <div class="col-lg-4">
                                        <label for="kredit_id"><span>Kredit kampaniyasını seç</span></label><br>
                                        <select id="kredit_id" name="kredit_id" class="form-control">
                                            <option value="0">--Kredit kampaniyası seçin--</option>
                                            <? while($kredit = fetch($kreditfetch)):?>
                                                <option value="<?= $kredit['id'] ?>" <?= ($kredit['id']==$product['kredit_id']) ? 'selected' : '' ?>><?= $kredit['name'] ?></option>
                                            <? endwhile; ?>
                                        </select>
                                    </div>
                                </div>
                                <div id="tip_product" class="tipler">
                                    <div class="col-lg-12">
                                    <? $key=0;  foreach ($params as $k=>$par){
                                    $value = prepare("`name`,`linkname`", "`value`", "`param_id`=?", [$par['id']])->fetchAll(PDO::FETCH_ASSOC);
                                    if (empty($value)) { ?>
                                        <div class="col-md-4">
                                            <label for="<?= $par['linkname'] ?>"><span><?= $par['name'] ?></span></label><br>
                                            <input type="text" id="<?= $par['linkname'] ?>"
                                                   name="product[<?= $par['linkname'] ?>]"
                                                   maxlength="100" class="form-control" value="<?
                                            foreach ($param as $p):
                                                if (!empty($p[$par['id']])) {
                                                    echo $p[$par['id']];
                                                }
                                            endforeach; ?>"/>
                                        </div>
                                    <? }else{  ?>
                                    <div class="col-md-4">
                                        <label for="<?= $par['linkname'] ?>"><span><?= $par['name'] ?></span></label><br>
                                        <select name="product[<?= $par['linkname'] ?>]" id="<?= $par['linkname'] ?>" class="form-control">
                                            <? foreach ($value as $key=>$val): ?>
                                            <option value="<?=$val['name']?>"
                                                <? foreach ($param as $p){
                                                    if ($val['name']==$p[$par['linkname']]){
                                                        echo 'selected';
                                                    }
                                                }?> >
                                                <?= $val['name']?>
                                            </option>
                                            <? endforeach;
                                        echo '</select>';
                                    echo '</div>';
                                    }
                                }
                        ?>
                                </div>
                                    </div>
								<div class="col-md-12 p10  ">
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