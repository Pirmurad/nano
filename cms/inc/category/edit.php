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

    if (empty($linkname)){$linkname=$name;}
    $linkname = dolinkname($linkname,$unwanted_array);


    $data =	"`parent_id` = ?,`type_id` = ?,`name` = ?,`linkname` = ?, `icon` = ?, `title` = ?,`description` = ?,`keyword` = ?,`data_update` = ?,`status` = ?";

    $sql =	[
        $category_id,$type_id,$name,$linkname,$icon,$title,$description,$keyword,time(),$status,get('id')
    ];

    $updatecategory = update("`category`",$data,"`id` = ?",$sql);
    
    if(!empty($updatecategory)) {
        redirect("category/list/");
    }
    else {
        $errors['errors'] = 'Problem baş verdi, kateqoriya dəyişilmədi !';
        $_SESSION['errors'] = $errors;
        redirect('category/edit/'.get('id'));
    }
}else{
    $categoryfetch = prepare("*","`category`","`id`=?",[get('id')])->fetch(PDO::FETCH_ASSOC);
    $typefetch = select("`id`,`name`","`type`","`id`","ASC")->fetchAll(PDO::FETCH_ASSOC);
?>
	<h1 class="page-header"><b><?=$categoryfetch['name'];?></b> kateqoriyasına düzəliş et</h1>
<div class="row">
    <div class="col-lg-12 p10 round_border_goster">
        <form action="" id="category_add_submit" method="POST" enctype="multipart/form-data">
            
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
			        <input type="text" id="name" name="name" required maxlength="100" class="form-control" value="<?= $categoryfetch['name'];?>"/>
		        </div>
		        <div class="col-lg-4">
			        <label for="title"><span>Başlıq</span></label><br>
			        <input type="text" id="title" name="title" required maxlength="60"  class="form-control" value="<?= $categoryfetch['title'];?>"/>
		        </div>
		        <div class="col-lg-4">
			        <label for="keyword"><span>Açar sözlər</span></label><br>
			        <input type="text" id="keyword" name="keyword" required maxlength="150"  class="form-control" value="<?= $categoryfetch['keyword'];?>"/>
		        </div>
	        </div>
            <div class="col-lg-12 p10">
                <div class="col-lg-4">
                    <label for="linkname"><span>Link Adı</span></label><br>
                    <input type="text" id="linkname" name="linkname" maxlength="100" <?PHP if($categoryfetch['protected']==1){echo "disabled";}?> class="form-control" value="<?= $categoryfetch['linkname'];?>"/>
                </div>
                <div class="col-lg-4">
                    <label for="category_id"><span>Alt kateqoriya oldugunu seç</span></label><br>
                    <select id="category_id" name="category_id" class="form-control">
                        <option value="0">--Ana menyudur--</option>
                        <?PHP
                        echo multilevelMenu("`category`",0,"",0,0,$categoryfetch['parent_id']);
                        ?>
	                </select>
                </div>
                <div class="col-lg-2 col-lg-offset-1">
                    <label for="statusyes">Görünürlüyünü seç</label>
                    <div class="radio form-control">
                        <label id="statusyes" class="mr10"><input type="radio" name="status" value="1" <?= ($categoryfetch['status']=='1') ? 'checked="checked"' : '' ?>><span class="green glyphicon glyphicon-eye-open"></span></label>
                        <label class="fr"><input type="radio" name="status" value="0" <?= ($categoryfetch['status']=='0') ? 'checked="checked"' : '' ?>><span class="red glyphicon glyphicon-eye-close"></span></label>
                    </div>
                </div>
            </div>
            <div class="col-lg-12 p10">
                <div class="col-lg-4">
                    <label for="description"><span>Səhifə haqqında açıqlama</span></label><br>
                    <input type="text" id="description" name="description" required maxlength="160" class="form-control" value="<?= $categoryfetch['description'];?>"/>
                </div>
                <div class="col-lg-4">
                    <label for="type_id"><span>Hansı tipə aid oldugunu seç</span></label><br>
                    <select id="type_id" name="type_id" class="form-control">
                        <?PHP foreach ($typefetch as $type) { ?>
                            <option value="<?= $type['id'] ?>" <?= ($type['id']==$categoryfetch['type_id']) ? 'selected' : '' ?>><?= $type['name']?></option>
                        <? } ?>
                    </select>
                </div>
                <div class="col-lg-4">
                    <label for="icon"><span>Icon</span></label><br>
                    <input type="text" id="icon" required name="icon" maxlength="160" class="form-control" value="<?= $categoryfetch['icon'];?>"/>
                </div>
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
