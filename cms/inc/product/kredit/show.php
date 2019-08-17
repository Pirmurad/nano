<?PHP
ob_start();
$path='../../../../';
include_once "{$path}config/conf.php";
include_once "../../../pages/html_start.php";
?>
<div id="wrapper">

    <?PHP include '../../../nav.php';?>

    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">

                <?PHP
                $kredit = prepare("*","`kredit_product`","`product_id`=?",[get('product_id')])->fetch(PDO::FETCH_ASSOC);
                $kredit_ay = json_decode($kredit['ay'],true);
                $product = prepare("`name`","`product`","`id`=?",[get('product_id')])->fetch(PDO::FETCH_ASSOC);
                ?>
<h1 class="page-header"><b><?= $product['name'] ?></b> məhsulunun krediti</h1>
<a type="button" href="product/<?= get('product_id') ?>/kredit/edit/<?=$kredit['id'];?>/" class="btn btn-success">Düzəliş Et</a>
<a type="button" href="product/<?= get('product_id') ?>/kredit/delete/<?=$kredit['id'];?>/" class="btn btn-danger">Sil</a>
<hr>
<div class="row">
    <div class="col-lg-12">
        <table class="table table-bordered table-hover text-center">
	        <tr>
		        <td>Ilkin ödəniş</td>
		        <td><?=$kredit['ilkin_odenis']?></td>
	        </tr>
            <tr>
		        <td>Ad</td>
		        <td><?=$kredit['name']?></td>
	        </tr>
            <tr>
                <td>Ay</td>
                <td><? foreach (json_decode($kredit['ay'],true) as $key=>$ay){
                        if (!empty($ay[$key])){
                            echo ++$key."-ci ay = ".$ay[--$key]." AZN<br>";
                        }
                    }?></td>
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
<?PHP include '../../../pages/html_end.php';
ob_end_flush();
?>