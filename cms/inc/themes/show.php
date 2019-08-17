<?PHP
ob_start();
$path='../../../';
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
                $themes = prepare("*","`themes`","`id`=?",[get('id')]);
                $themes = $themes[0];
                ?>
	            <h1 class="page-header"><b><?=$themes['name'];?></b> teması</h1>
	            <a type="button" href="themes/edit/<?=$themes['id'];?>/" class="btn btn-success">Düzəliş Et</a>
	            <a type="button" href="themes/delete/<?=$themes['id'];?>/" class="btn btn-danger">Sil</a>
	            <hr>
<div class="row">
    <div class="col-lg-12">
        <?PHP
        if (!empty($themes['image'])) {
            echo "<div class='col-md-offset-4'><img src='../uploads/themes/{$themes['image']}' width='150' height='200' style='margin: 15px;'/></div>";
        }
        ?>
        <table class="table table-bordered table-hover text-center">
            <tr>
                <td>Adı</td>
                <td><?=$themes['name']?></td>
            </tr>
            <tr>
                <td>Status</td>
                <td>
                <?PHP
                if($themes['status']==1){
                    echo '<span class="green glyphicon glyphicon-eye-open"></span>';
                }else{
                    echo '<span class="red glyphicon glyphicon-eye-close"></span>';
                }
                ?>
                </td>
            </tr>
	        <tr>
		        <td>Yaradılma vaxtı</td>
		        <td><?= date("d.m.Y H:i:s",$themes['data_create']);?></td>
	        </tr>
	        <tr>
		        <td>Dəyişilmə vaxtı</td>
		        <td><?= date("d.m.Y H:i:s",$themes['data_update']);?></td>
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