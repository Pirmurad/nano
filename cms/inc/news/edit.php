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
                    $data_update=time();
                    if (empty($linkname)){$linkname=$name;}
                    $linkname = dolinkname($linkname,$unwanted_array);

                    include $imagepath . 'SimpleImageFull.php';
                    
                    $description = $short_text;

                    $file = $_FILES['fileToUpload']['tmp_name'];
                    $resize = ['345','205'];
                    $folder = "news";
                    $table = "news";
                    $getId = get('id');
                    $errorredirect = "news/edit/".get('id')."/";
                    $deleteimagecolumn = "image";
                    $transparent = "0";

                    $file_name = imageupload($file,$path,$imagepath,$resize,$deleteimagecolumn,$table,$getId,$folder,$errorredirect,$transparent);
                    if(count($errors) > 0) {$_SESSION['errors'] = $errors;redirect("news/edit/".get('id')."/");}
                    
                    $data =	"`name` = ?,`linkname` = ?, `image` = ?, `short_text` = ?,`text` = ?,`title` = ?, `description` = ?,`keyword` = ?,`data_update` = ?,`status` = ?";

                    $sql =	[
                        $name,$linkname,$file_name,$short_text,$text,$title,$description,$keyword,time(),$status,get('id')
                    ];

	                $updatenews = update("`news`",$data,"`id` = ?",$sql);

                    if($updatenews) {
                        redirect("news/list/");
                    }
                    else {
                        $errors['errors'] = 'Problem baş verdi, məqalə dəyişdirilə bilmədi !';
                        $_SESSION['errors'] = $errors;
                        redirect("news/edit/".get('id')."/");
                    }

                }else{
                    $news  =  prepare("*","`news`","`id`=?",[get('id')])->fetch(PDO::FETCH_ASSOC);
                    ?>
	                <h1 class="page-header"><b><?=$news['name'];?></b> məqaləsini dəyiş</h1>
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
                                    $placeholder = $news['name'];
                                    echo addInput("col-md-4",$title,$name,$placeholder,1,"text","100","1");
                                    $title       = 'Link adı *';
                                    $name        = 'linkname';
                                    $placeholder = $news['linkname'];
                                    echo addInput("col-md-4",$title,$name,$placeholder,1,"text","100","1");
                                    $title       = 'Başlıq *';
                                    $name        = 'title';
                                    $placeholder = $news['title'];
                                    echo addInput("col-md-4",$title,$name,$placeholder,1,"text","60","1");
                                    ?>
								</div>
								<div class="col-md-12 p10">
                                    <?PHP
                                        $title       = 'Açar sözlər *';
                                        $name        = 'keyword';
                                        $placeholder = $news['keyword'];
                                        echo addInput("col-md-4",$title,$name,$placeholder,1,"text","150","1");

                                    ?>
                                    <div class="col-md-4">
                                        <label for="fileToUpload"><span>Şəkil yüklə</span></label><br>
                                        <input type="file" class="form-control" name="fileToUpload" id="fileToUpload"/>
                                    </div>
                                    <div class="col-md-2 col-md-offset-1">
                                        <label for="statusyes">Görünürlüyünü seç</label>
                                        <div class="radio form-control">
                                            <?PHP
                                            if ($news['status']==0) {
                                                echo '<label id="statusyes" class="mr10"><input type="radio" name="status" value="1"><span class="green glyphicon glyphicon-eye-open"></span></label>';
                                                echo '<label class="fr"><input type="radio" name="status" value="0" checked="checked"><span class="red glyphicon glyphicon-eye-close"></span></label>';
                                            }elseif($news['status']==1){
                                                echo '<label id="statusyes" class="mr10"><input type="radio" name="status" checked="checked" value="1"><span class="green glyphicon glyphicon-eye-open"></span></label>';
                                                echo '<label class="fr"><input type="radio" name="status" value="0"><span class="red glyphicon glyphicon-eye-close"></span></label>';
                                            }
                                            ?>
                                        </div>
                                    </div>
								</div>
								<div class="col-md-12 p10">
                                    <?PHP
                                    $title       = 'Qısa mətn *';
                                    $name        = 'short_text';
                                    $placeholder = $news['short_text'];;
                                    echo addInput("col-md-12",$title,$name,$placeholder,1,"text","150","1");
                                    ?>
								</div>
								<div class="col-lg-12 p10">
									<ul class="nav nav-tabs">
										<li class="active"><a href="#text" data-toggle="tab">Mətn</a></li>
									</ul>
									<div class="tab-content">
										<div id="text" class="tab-pane fade in active">
											<textarea class="summernote" name="text"><?=$news['text'];?></textarea>
										</div>
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