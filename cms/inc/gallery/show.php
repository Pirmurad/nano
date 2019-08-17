<?PHP
ob_start();
$path='../../../';
include_once "{$path}config/conf.php";
include_once "../../pages/html_start.php";
?>
<div id="wrapper">

    <?PHP include '../../nav.php';?>

    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">

                <?PHP
                $galleryquery=$db->prepare("SELECT * FROM `gallery` WHERE id=:id");
                $galleryquery->execute(array(":id"=>$_GET['id']));
                $gallery=$galleryquery->fetch(PDO::FETCH_ASSOC);
                ?>
<h1 class="page-header">gallery</h1>
	            <a type="button" href="gallery/edit/<?=$gallery['id'];?>/" class="btn btn-success">Düzəliş Et</a>
	            <a type="button" href="gallery/delete/<?=$gallery['id'];?>/" class="btn btn-danger">Sil</a>
	            <hr>
<div class="row">
    <div class="col-lg-12">
        <?PHP
        if (!empty($gallery['image'])) {
            echo "<td><img src='../uploads/gallery/{$gallery['image']}' width='150' style='margin: 15px;'/></td>";
        }
        ?>
        <table class="table table-bordered table-hover text-center">
            <tr>
                <td>Link</td>
                <td><?=$gallery['url']?></td>
            </tr>
            <tr>
                <td>Şəkilin adı</td>
                <td><?=$gallery['image_name']?></td>
            </tr>
	        <tr>
		        <td>İstiqaməti</td>
			        <?PHP
                    if ($gallery['direction']==1) {
                        echo '<td class="textcenter"><span class="glyphicon glyphicon-arrow-up"></span></td>';
                    }else{
                        echo '<td class="textcenter"><span class="glyphicon glyphicon-arrow-left"></span><span class="glyphicon glyphicon-arrow-right"></span></td>';
                    }
                    ?>
	        </tr>
            <tr>
                <td>Status</td>
                <td>
                <?PHP
                if($gallery['status']==1){
                    echo '<span class="green glyphicon glyphicon-eye-open"></span>';
                }else{
                    echo '<span class="red glyphicon glyphicon-eye-close"></span>';
                }
                ?>
                </td>
            </tr>
        </table>
    </div>
    <!-- /.col-lg-12 -->
</div>
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