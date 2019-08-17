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
                $category = prepare("*","`category`","`id`=?",[get('id')])->fetch(PDO::FETCH_ASSOC);
                $type = prepare("`name`","`type`","`id`=?",[$category['type_id']])->fetch(PDO::FETCH_ASSOC);
                ?>
<h1 class="page-header">Kateqoriya</h1>
<a type="button" href="category/edit/<?=$category['id'];?>/" class="btn btn-success">Düzəliş Et</a>
<a type="button" href="category/delete/<?=$category['id'];?>/" class="btn btn-danger">Sil</a>
<hr>
<div class="row">
    <div class="col-lg-12">
        <table class="table table-bordered table-hover text-center">
	        <tr>
		        <td>Ana kateqoriyası</td>
		        <?PHP
		        if ($category['parent_id']!=0){
		        	$categoryname = prepare("`name`","`category`","id=?",[$category['parent_id']])->fetch(PDO::FETCH_ASSOC);
		        	echo '<td>'.$categoryname["name"].'</td>';
		        }else{
                    echo '<td class="text-center"><span class="red glyphicon glyphicon-minus"></span></td>';
		        }
		        ?>
	        </tr>
	        <tr>
                <td>Ad</td>
                <td><?=$category['name']?></td>
            </tr>
            <tr>
                <td>Tip</td>
                <td><?=$type['name']?></td>
            </tr>
            <tr>
                <td>Link adi</td>
                <td><?=$category['linkname']?></td>
            </tr>
	        <tr>
		        <td>Basliq</td>
		        <td><?=$category['title']?></td>
	        </tr>
	        <tr>
		        <td>Açar sözlər</td>
		        <td><?=$category['keyword']?></td>
	        </tr>
	        <tr>
		        <td>Səhifə haqqında açıqlama</td>
		        <td><?=$category['description']?></td>
	        </tr>
            <tr>
                <td>Status</td>
                <td>
                <?PHP
                if($category['status']==1){
                    echo '<span class="green glyphicon glyphicon-eye-open"></span>';
                }else{
                    echo '<span class="red glyphicon glyphicon-eye-close"></span>';
                }
                ?>
                </td>
            </tr>
	        <tr>
		        <td>Yaranma tarixi</td>
		        <td><?=date("d.m.Y H:i:s",$category['data_create']);?></td>
	        </tr>
            <tr>
                <td>Dəyişilmə tarixi</td>
                <td><?=date("d.m.Y H:i:s",$category['data_update']);?></td>
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