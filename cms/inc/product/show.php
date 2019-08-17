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
                $product = prepare("*","`product`","`id`=?",[get('id')])->fetch(PDO::FETCH_ASSOC);
                $type = prepare("`name`","`type`","`id`=?",[$product['type_id']])->fetch(PDO::FETCH_ASSOC);
                $category = prepare("`name`","`category`","`id`=?",[$product['category_id']])->fetch(PDO::FETCH_ASSOC);
                ?>
	            <h1 class="page-header"><b><?=$product['name']?></b> elanı</h1>
	            <a type="button" href="product/edit/<?=$product['id'];?>/" class="btn btn-success">Düzəliş Et</a>
	            <a type="button" href="product/delete/<?=$product['id'];?>/" class="btn btn-danger">Sil</a>
	            <hr>
<div class="row">
    <div class="col-lg-12">
        <?PHP
        if (!empty($product['image'])) {
            echo "<div class='col-md-offset-4'><img src='../uploads/product/large/{$product['image']}' style='margin: 15px;'/></div>";
        }
        ?>
        <table class="table table-bordered table-hover text-center">
	        <tr>
		        <td>Aid olduğu tip</td>
		        <td><?=$type['name']?></td>
	        </tr>
	        <tr>
		        <td>Aid olduğu kateqoriya</td>
		        <td><?=$category['name']?></td>
	        </tr>
	        <tr>
                <td>Adı</td>
                <td><?=$product['name']?></td>
            </tr>
	        <tr>
		        <td>Başlıq</td>
		        <td><?=$product['title']?></td>
	        </tr>
	        <tr>
		        <td>Açar sözlər</td>
		        <td><?=$product['keyword']?></td>
	        </tr>
	        <tr>
		        <td>Elanın təsviri</td>
		        <td><?=$product['description']?></td>
	        </tr>

            <tr>
                <td>Qiyməti</td>
                <td><?=$product['price']?> azn</td>
            </tr>
            <tr>
                <td>Link</td>
                <td><a href="/mehsullar/<?=$product['id']?>/<?=$product['linkname']?>/" target="_blank"><?=$product['linkname']?></a></td>
            </tr>
            <tr>
                <td>Baxış sayı</td>
                <td><?=$product['view_count']?></td>
            </tr>
            <tr>
                <td>Status</td>
                <td>
                <?PHP
                if($product['status']==1){
                    echo '<span class="green glyphicon glyphicon-eye-open"></span>';
                }else{
                    echo '<span class="red glyphicon glyphicon-eye-close"></span>';
                }
                ?>
                </td>
            </tr>
            <tr>
                <td>Yaradılma vaxtı</td>
                <td><?= date("d.m.Y H:i:s",$product['data_create']);?></td>
            </tr>
	        <tr>
		        <td>Dəyişilmə vaxtı</td>
		        <td><?= date("d.m.Y H:i:s",$product['data_update']);?></td>
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