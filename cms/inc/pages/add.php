<?PHP
ob_start();
$path='../../../';
$imagepath='../../';
include_once "{$path}config/conf.php";
include_once "{$path}helper/func.php";
include_once "../../pages/html_start.php";
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
    $ordering = select("MAX(ordering)","`pages`","`ordering`");
    $order=$ordering['max(ordering)']+1;

    $data_create=time();
    $data_update=time();

    if (empty($linkname)){$linkname=$name_az;}
    $linkname = dolinkname($linkname,$unwanted_array);

    if(count($errors) > 0) {$_SESSION['errors'] = $errors;redirect("pages/create/");}

    $data =	"`name_az` = ?,`name_ru` = ?, `linkname` = ?, `title_az` = ?, `title_ru` = ?, `description_az` = ?,`description_ru` = ?,`keyword_az` = ?,`keyword_ru` = ?,`text_az` = ?,`text_ru` = ?,`data_create` = ?,`data_update` = ?,`ordering` = ?,`status` = ?";

    $sql =	[
    		$name_az,$name_ru,$linkname,$title_az,$title_ru,$description_az,$description_ru,$keyword_az,$keyword_ru,$text_az,$text_ru,$data_create,$data_update,$order,$status
    ];

	$insertpages =	insert("`pages`",$data,$sql);


    if($insertpages) {
        redirect("pages/list/");
    }
    else {
        $errors['errors'] = 'Problem baş verdi, səhifə əlavə olunmadı !';
        $_SESSION['errors'] = $errors;
        redirect("pages/create/");
    }

}else{
?>

<h1 class="page-header">Səhifə əlavə et</h1>
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
	            foreach ($langs as $lang){
	            	$name='name_'.$lang;
	            	$placeholder = 'Ad ['.$lang.'] *';
                    echo addInput("col-md-4",$placeholder,$name,$placeholder,0,"text","100","1");
	            }
	            ?>
                <div class="col-md-4">
                    <label for="linkname"><span>Link adı</span></label><br>
                    <input type="text" id="linkname" name="linkname" required maxlength="100" class="form-control" placeholder="Link adı *"/>
                </div>
            </div>
	        <div class="col-md-12 p10">
                <?PHP
                foreach ($langs as $lang){
                    $name='title_'.$lang;
                    $placeholder = 'Başlıq ['.$lang.'] *';
                    echo addInput("col-md-4",$placeholder,$name,$placeholder,0,"text","60","1");
                }
                ?>
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
                foreach ($langs as $lang){
                    $name='keyword_'.$lang;
                    $placeholder = 'Açar Sözlər ['.$lang.'] *';
                    echo addInput("col-md-6",$placeholder,$name,$placeholder,0,"text","150","1");
                }
                ?>
	        </div>
	        <div class="col-md-12 p10">
                <?PHP
                $name='description_az';
                $placeholder = 'Elanın təsviri [az] *';
                echo addInput("col-md-12",$placeholder,$name,$placeholder,0,"text","150","1");
                ?>
	        </div>
	        <div class="col-md-12 p10">
                <?PHP
                $name='description_ru';
                $placeholder = 'Elanın təsviri [ru] *';
                echo addInput("col-md-12",$placeholder,$name,$placeholder,0,"text","150","1");
                ?>
	        </div>
            <div class="col-lg-12 p10">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#text_az" data-toggle="tab">Mətn [az]</a></li>
                    <li><a href="#text_ru" data-toggle="tab">Mətn [ru]</a></li>
                </ul>
                <div class="tab-content">
                    <div id="text_az" class="tab-pane fade in active">
                        <textarea class="summernote" name="text_az"></textarea>
                    </div>
	                <div id="text_ru" class="tab-pane fade in">
		                <textarea class="summernote" name="text_ru"></textarea>
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
