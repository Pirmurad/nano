<?PHP
ob_start();
$path='../../../../';
include_once "{$path}config/conf.php";
include_once "{$path}helper/func.php";
include_once "../../../pages/html_start.php";
?>
<div id="wrapper">

    <?PHP include '../../../nav.php';?>

    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">

                <?PHP
                $gallery = prepare("*","`gallery`","`id`=?",[get('gallery_id')]);
                $gallery = $gallery[0];
                $advertisement = prepare("`name_az`,`id`","`advertisement`","`id`=?",[get('advertisement_id')]);
                $advertisement = $advertisement[0];
                ?>
	            <h1 class="page-header"><b><?=$advertisement['name_az']?></b> elanının qalereyasından <b><?=$gallery['image_name'];?></b> şəkili </h1>
	            <a type="button" href="advertisement/<?=$advertisement['id'];?>/gallery/edit/<?=$gallery['id'];?>/" class="btn btn-success">Düzəliş Et</a>
	            <a type="button" href="advertisement/<?=$advertisement['id'];?>/gallery/delete/<?=$gallery['id'];?>/" class="btn btn-danger">Sil</a>
	            <hr>
<div class="row">
    <div class="col-lg-12">
        <?PHP
        if (!empty($gallery['image'])) {
            echo "<div class='col-md-4 col-md-offset-4'><img src='../uploads/advertisement/gallery/large/{$gallery['image']}' width='250' style='margin: 15px;'/></div>";
        }
        ?>
        <table class="table table-bordered table-hover text-center">
            <tr>
                <td>Elanın adı</td>
                <td><?=$advertisement['name_az']?></td>
            </tr>
            <tr>
                <td>Şəkilin adı</td>
                <td><?=$gallery['image_name']?></td>
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
	        <tr>
		        <td>Yaradılma vaxtı</td>
		        <td><?= date("d.m.Y H:i:s",$gallery['data_create']);?></td>
	        </tr>
	        <tr>
		        <td>Dəyişilmə vaxtı</td>
		        <td><?= date("d.m.Y H:i:s",$gallery['data_update']);?></td>
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
<?PHP include '../../../pages/html_end.php';
ob_end_flush();
?>