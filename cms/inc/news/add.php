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
    $ordering = select("MAX(ordering)","`news`","`ordering`")->fetch(PDO::FETCH_ASSOC);
    $order=$ordering['MAX(ordering)']+1;

    $description = $short_text;

    if (empty($linkname)){$linkname=$name;}
    $linkname = dolinkname($linkname,$unwanted_array);

    include $imagepath . 'SimpleImageFull.php';

    $file = $_FILES['fileToUpload']['tmp_name'];
	$resize = ['345','205'];
	$folder = "news";
    $table = "news";
    $getId = get('id');
    $errorredirect = "news/create/";
    $deleteimagecolumn = "image";
    $transparent = "0";

    $file_name = imageupload($file,$path,$imagepath,$resize,$deleteimagecolumn,$table,$getId,$folder,$errorredirect,$transparent);

    if(count($errors) > 0) {$_SESSION['errors'] = $errors;redirect("news/create/");}

    $data =	"`name` = ?,`linkname` = ?, `image` = ?, `short_text` = ?,`text` = ?,`title` = ?, `description` = ?,`keyword` = ?,`view_count` = ?,`data_create` = ?,`data_update` = ?,`ordering` = ?,`status` = ?";

    $sql =	[
    	$name,$linkname,$file_name,$short_text,$text,$title,$description,$keyword,"0",time(),time(),$order,$status
    ];

	$insertnews = insert("`news`",$data,$sql);

    if($insertnews) {
        redirect("news/list/");
    }else {
        $errors['errors'] = 'Problem baş verdi, elan əlavə olunmadı !';
        $_SESSION['errors'] = $errors;
        redirect("news/create/");
    }

}else{
?>

<h1 class="page-header">Məqalə əlavə et</h1>
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
                $placeholder = 'Ad *';
                echo addInput("col-md-4",$placeholder,$name,$placeholder,0,"text","100","1");
                $name='linkname';
                $placeholder = 'Link adı *';
                echo addInput("col-md-4",$placeholder,$name,$placeholder,0,"text","100","1");
                $name='title';
                $placeholder = 'Başlıq *';
                echo addInput("col-md-4",$placeholder,$name,$placeholder,0,"text","60","1");
	            ?>
            </div>
            <div class="col-md-12 p10">
                <?PHP
                $name='keyword';
                $placeholder = 'Açar Sözlər *';
                echo addInput("col-md-4",$placeholder,$name,$placeholder,0,"text","150","1");
                ?>
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
                $name='short_text';
                $placeholder = 'Qısa mətn *';
                echo addInput("col-md-12",$placeholder,$name,$placeholder,0,"text","150","1");
                ?>
	        </div>
            <div class="col-lg-12 p10">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#text" data-toggle="tab">Mətn</a></li>
                </ul>
                <div class="tab-content">
                    <div id="text" class="tab-pane fade in active">
                        <textarea class="summernote" name="text"></textarea>
                    </div>
                </div>
            </div>
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
        </div>
        <!-- /#page-wrapper -->

    </div>
<!-- /#wrapper -->
<?PHP include '../../pages/html_end.php';
ob_end_flush();
?>
