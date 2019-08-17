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
                $kredit = prepare("*","`kredit`","`id`=?",[get('id')])->fetch(PDO::FETCH_ASSOC);
                ?>
<h1 class="page-header">Kredit Kampaniyasi</h1>
<a type="button" href="kredit/edit/<?=$kredit['id'];?>/" class="btn btn-success">Düzəliş Et</a>
<a type="button" href="kredit/delete/<?=$kredit['id'];?>/" class="btn btn-danger">Sil</a>
<hr>
<div class="row">
    <div class="col-lg-12">
        <table class="table table-bordered table-hover text-center">
	        <tr>
                <td>Ad</td>
                <td><?=$kredit['name']?></td>
            </tr>
            <tr>
                <td>Risk faizi</td>
                <td><?=$kredit['risk_faizi']?></td>
            </tr>
	        <tr>
		        <td>Ilkin ödəniş</td>
		        <td><?=$kredit['ilkin_odenis']?></td>
	        </tr>
	        <tr>
		        <td>Zəmanət faizi</td>
		        <td><?=$kredit['zemanet_faizi']?></td>
	        </tr>
	        <tr>
		        <td>Xərc 1</td>
		        <td><?=$kredit['xerc1']?></td>
	        </tr>
            <tr>
		        <td>Xərc 2</td>
		        <td><?=$kredit['xerc2']?></td>
	        </tr>
            <tr>
                <td>Ay</td>
                <td><? foreach (json_decode($kredit['ay'],true) as $key=>$ay){
                        echo ++$key."-ci ay = ".$ay[--$key]."% <br>";
                    }?></td>
            </tr>
            <tr>
                <td>Status</td>
                <td>
                <?PHP
                if($kredit['status']==1){
                    echo '<span class="green glyphicon glyphicon-eye-open"></span>';
                }else{
                    echo '<span class="red glyphicon glyphicon-eye-close"></span>';
                }
                ?>
                </td>
            </tr>
	        <tr>
		        <td>Yaranma tarixi</td>
		        <td><?=date("d.m.Y H:i:s",$kredit['data_create']);?></td>
	        </tr>
            <tr>
                <td>Dəyişilmə tarixi</td>
                <td><?=date("d.m.Y H:i:s",$kredit['data_update']);?></td>
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