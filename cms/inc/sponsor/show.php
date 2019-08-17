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
                $sponsor = prepare("*","`sponsor`","`id`=?",[get('id')])->fetch(PDO::FETCH_ASSOC);
                ?>
	            <h1 class="page-header">Sponsor</h1>
	            <a type="button" href="sponsor/edit/<?=$sponsor['id'];?>/" class="btn btn-success">Düzəliş Et</a>
	            <a type="button" href="sponsor/delete/<?=$sponsor['id'];?>/" class="btn btn-danger">Sil</a>
	            <hr>
<div class="row">
    <div class="col-lg-12">
        <?PHP
        if (!empty($sponsor['image'])) {
            echo "<div class='text-center'><img src='../uploads/sponsor/large/{$sponsor['image']}' style='margin: 15px;'/></div>";
        }
        ?>
        <table class="table table-bordered table-hover text-center">
            <tr>
                <td>Adı</td>
                <td><?=$sponsor['image_name']?></td>
            </tr>
            <tr>
                <td>Link</td>
                <td><a href="<?=$sponsor['link']?>" target="_blank"><?=$sponsor['link']?></a></td>
            </tr>
            <tr>
                <td>Status</td>
                <td>
                <?PHP
                if($sponsor['status']==1){
                    echo '<span class="green glyphicon glyphicon-eye-open"></span>';
                }else{
                    echo '<span class="red glyphicon glyphicon-eye-close"></span>';
                }
                ?>
                </td>
            </tr>
	        <tr>
		        <td>Yaranma vaxtı</td>
		        <td><?=date("d M Y H:i:s",$sponsor['data_create']);?></td>
	        </tr>
	        <tr>
		        <td>Dəyişdirilmə vaxtı</td>
		        <td><?=date("d M Y H:i:s",$sponsor['data_update']);?></td>
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