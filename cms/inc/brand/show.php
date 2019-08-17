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
                $brand = prepare("*","`brand`","`id`=?",[get('id')])->fetch(PDO::FETCH_ASSOC);
                $brandtype = prepare("*","`brand_type`","`brand_id`=?",[$brand['id']])->fetchAll(PDO::FETCH_ASSOC);
                ?>
	            <h1 class="page-header"><?= $brand['name'] ?> brendi</h1>
	            <a type="button" href="brand/edit/<?=$brand['id'];?>/" class="btn btn-success">Düzəliş Et</a>
	            <a type="button" href="brand/delete/<?=$brand['id'];?>/" class="btn btn-danger">Sil</a>
	            <hr>
<div class="row">
    <div class="col-lg-12">
        <?PHP
        if (!empty($brand['image'])) {
            echo "<div class='text-center'><img src='../uploads/brand/large/{$brand['image']}' style='margin: 15px;'/></div>";
        }
        ?>
        <table class="table table-bordered table-hover text-center">
            <tr>
                <td>Adı</td>
                <td><?=$brand['name']?></td>
            </tr>
            <tr>
                <td>Link</td>
                <td><a href="<?=$brand['linkname']?>" target="_blank"><?=$brand['linkname']?></a></td>
            </tr>
            <tr>
                <td>Tipləri</td>
                <td>
                    <? foreach ($brandtype as $bt):
                        $type = prepare("`name`","`type`","`id`=?",[$bt['type_id']])->fetch(PDO::FETCH_ASSOC);
                        $types .= $type['name']." , ";
                    endforeach;
                    echo rtrim($types,", "); ?>
                </td>
            </tr>
            <tr>
                <td>Status</td>
                <td>
                <?PHP
                if($brand['status']==1){
                    echo '<span class="green glyphicon glyphicon-eye-open"></span>';
                }else{
                    echo '<span class="red glyphicon glyphicon-eye-close"></span>';
                }
                ?>
                </td>
            </tr>
	        <tr>
		        <td>Yaranma vaxtı</td>
		        <td><?=date("d M Y H:i:s",$brand['data_create']);?></td>
	        </tr>
	        <tr>
		        <td>Dəyişdirilmə vaxtı</td>
		        <td><?=date("d M Y H:i:s",$brand['data_update']);?></td>
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