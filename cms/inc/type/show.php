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
                $type = prepare("*","`type`","`id`=?",[get('id')])->fetch(PDO::FETCH_ASSOC);
                ?>
	            <h1 class="page-header">Tip</h1>
	            <a type="button" href="type/edit/<?=$type['id'];?>/" class="btn btn-success">Düzəliş Et</a>
	            <a type="button" href="type/delete/<?=$type['id'];?>/" class="btn btn-danger">Sil</a>
	            <hr>
<div class="row">
    <div class="col-lg-12">
        <table class="table table-bordered table-hover text-center">
            <tr>
                <td>Adı</td>
                <td><?=$type['image_name']?></td>
            </tr>
            <tr>
                <td>Teqlər</td>
                <td><?=$type['tags']?></td>
            </tr>
            <tr>
                <td>Status</td>
                <td>
                <?PHP
                if($type['status']==1){
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