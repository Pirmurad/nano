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
    $errors= [];
    $order=0;
    $lastorder = select("MAX(ordering)","`category`","`ordering`","DESC")->fetch(PDO::FETCH_ASSOC);
    $order=$lastorder['MAX(ordering)']+1;

    if (empty($linkname)){$linkname=$name;}
    $linkname = dolinkname($linkname,$unwanted_array);

    $find = fetchColumn("COUNT(id)","`category`","`linkname`=?",[$linkname]);
    if($find > 0) {
        $errors['exists'] = 'Belə kateqoriya artıq var';
    }
    
    if(count($errors) > 0) {
        session_create(['errors'=>$errors]);
        redirect("category/create/");
    }


    $data =	"`parent_id` = ?,`type_id` = ?,`name` = ?,`linkname` = ?,`icon` = ?, `title` = ?,`description` = ?,`keyword` = ?,`data_create` = ?,`data_update` = ?,`protected` = ?,`ordering` = ?,`status` = ?";

    $sql =	[
        $category_id, $type_id,$name,$linkname,$icon,$title,$description,$keyword,time(),time(),"0",$order,$status
    ];

    $insertcategory =	insert("`category`",$data,$sql);

    if(!empty($insertcategory)) {
        redirect("category/list/");
    }
    else {
        $errors['error'] = 'Problem baş verdi, kateqoriya əlavə olunmadı !';
        session_create(['error'=>$errors]);
        redirect("category/create/");
    }

}else{
    $typefetch = select("`id`,`name`","`type`","`id`","ASC")->fetchAll(PDO::FETCH_ASSOC);
?>
<h1 class="page-header">Kateqoriya əlavə et</h1>
<div class="row">
    <div class="col-lg-12 p10 round_border_goster">
        <form action="" id="category_add_submit" method="POST"  enctype="multipart/form-data">
            
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
                <div class="col-lg-4">
		            <label for="title"><span>Başlıq</span></label><br>
		            <input type="text" id="title" name="title" required maxlength="60"  class="form-control" placeholder="Başlıq *"/>
	            </div>
                <div class="col-lg-4">
                    <label for="keyword"><span>Açar sözlər</span></label><br>
                    <input type="text" id="keyword" name="keyword" required maxlength="150"  class="form-control" placeholder="Açar sözlər *"/>
                </div>
            </div>
            <div class="col-lg-12 p10">
                <div class="col-lg-4">
                    <label for="linkname"><span>Link Adı</span></label><br>
                    <input type="text" id="linkname" name="linkname" maxlength="50"  class="form-control" placeholder="Link adı *"/>
                </div>
	            <div class="col-lg-4">
		            <label for="category_id"><span>Hansı kateqoriyaya aid oldugunu seç</span></label><br>
		            <select id="category_id" name="category_id" class="form-control">
			            <option value="0">--Ana Kateqoriyadır--</option>
                        <?PHP
                        echo multilevelMenu("`category`",0,"",0,0,0);
                        ?>
		            </select>
	            </div>
                <div class="col-lg-2 col-lg-offset-1">
                    <label for="statusyes">Görünürlüyünü seç</label>
                    <div class="radio form-control">
                        <label id="statusyes" class="mr10"><input type="radio" checked="checked" name="status" value="1"><span class="green glyphicon glyphicon-eye-open"></span></label>
                        <label class="fr"><input type="radio" name="status" value="0"><span class="red glyphicon glyphicon-eye-close"></span></label>
                    </div>
                </div>
            </div>
            <div class="col-lg-12 p10">
                <div class="col-lg-4">
                    <label for="description"><span>Səhifə haqqında açıqlama</span></label><br>
                    <input type="text" id="description" required name="description" maxlength="160" class="form-control" placeholder="Səhifə haqqında açıqlama *"/>
                </div>
                <div class="col-lg-4">
                    <label for="type_id"><span>Hansı tipə aid oldugunu seç</span></label><br>
                    <select id="type_id" name="type_id" class="form-control">
                        <?PHP
                        foreach ($typefetch as $type) {
                            echo '<option value="'.$type['id'].'">'.$type['name'].'</option>';
                        }
                        ?>
                    </select>
                </div>
                <div class="col-lg-4">
                    <label for="icon"><span>Icon</span></label><br>
                    <input type="text" id="icon" required name="icon" maxlength="160" class="form-control" placeholder="Icon *"/>
                </div>
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