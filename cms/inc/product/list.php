<?PHP
ob_start();
$path='../../../';
$imagepath='../../';
include_once "{$path}config/conf.php";
include_once "../../pages/html_start.php";
include_once "{$imagepath}checkadmin.php";
?>
<div id="wrapper">

    <?PHP include '../../nav.php';?>

    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
    <?PHP

    if(!empty($_GET['directionrow'])){
        if($_GET["directionrow"] === "asagi"){
            $orderthanmore = prepare("`ordering`","`product`","`ordering`>?",[get('sira')],"`ordering`","ASC","LIMIT 1")->fetch(PDO::FETCH_ASSOC);
            if (!empty($orderthanmore['ordering'])) {
                update("`product`","`ordering`=?","`ordering`=?",[get('sira'),$orderthanmore['ordering']]);
                update("`product`","`ordering`=?","`id`=?",[$orderthanmore['ordering'],get('id')]);
            }
        }elseif($_GET["directionrow"] === "yuxari"){
            $orderthanlittle = prepare("`ordering`","`product`","`ordering`<?",[get('sira')],"`ordering`","DESC","LIMIT 1")->fetch(PDO::FETCH_ASSOC);
            if (!empty($orderthanlittle['ordering'])) {
                update("`product`","`ordering`=?","`ordering`=?",[get('sira'),$orderthanlittle['ordering']]);
                update("`product`","`ordering`=?","`id`=?",[$orderthanlittle['ordering'],get('id')]);
            }
        }
    }

    if (!empty(post('searchtext'))){
        $where = "`name` LIKE ?";
        $execute = ["%".post('searchtext')."%"];
    }else{
        $where = "`status`=?";
        $execute = ["1"];
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST'){
        if(isset($_POST['check_list'])) {
            foreach($_POST['check_list'] as $check) {
                if(isset($_POST['delete'])) {
                    $deleteimage = prepare("`image`","`product`","`id`=?",[$check])->fetch(PDO::FETCH_ASSOC);
	                if (!empty($deleteimage['image'])){
                    	@unlink("{$path}uploads/product/{$deleteimage['image']}");
	                    @unlink("{$path}uploads/product/large/{$deleteimage['image']}");
                    	@unlink("{$path}uploads/product/medium/{$deleteimage['image']}");
                    	@unlink("{$path}uploads/product/little/{$deleteimage['image']}");
                    }
                    delete("`product`","`id`=?",[$check]);
                }
                if(isset($_POST['doactive'])){
                    update("`product`","`status`=?","`id`=?",['1',$check]);
                }
                if(isset($_POST['dodeactive'])){
                    update("`product`","`status`=?","`id`=?",['0',$check]);
                }
            }
        }

        if (empty(post('rowsize'))){$rowsize = "10";}else{$rowsize = post('rowsize');}
        if (isset($_GET["pagination"])) {$page = intval($_GET["pagination"]);} else {$page = 1;};
        $start_from = ($page > 1) ? ($page * $rowsize) - $rowsize : 0;
        $pagination = pagination($rowsize,$page,"2","product","`id`>?",["0"],"product");

        $productfetch = prepare("*","`product`",$where,$execute,"`id`","DESC");
    }else{
        if (isset($_GET["pagination"])) {$page = intval($_GET["pagination"]);} else {$page = 1;}
        $perpage = 10;
        $start_from = ($page > 1) ? ($page * $perpage) - $perpage : 0;
        $pagination = pagination($perpage,$page,"2","product","`id`>?",["0"],"product");

        $productfetch = prepare("*","`product`",$where,$execute,"`id`","DESC","LIMIT $start_from,$perpage");
    }

?>
<h1 class="page-header">Məhsullar</h1>
<?= post('searchtext'); ?>
        <table class="table table-bordered table-hover sortable-theme-bootstrap" data-sortable>
            <thead>
                <tr>
                    <th><input type="checkbox" id="checkAll"></th>
                    <th class="textcenter">Id</th>
                    <th class="textcenter">Ad</th>
                    <th class="textcenter">Şəkil</th>
                    <th class="textcenter">Qiyməti</th>
                    <th class="textcenter">Kredit</th>
                    <th class="textcenter">Qalereya</th>
                    <th class="textcenter">Sıra</th>
                    <th class="textcenter">Status</th>
                    <th class="textcenter">Dəyiş</th>
                </tr>
            </thead>
	        <tbody>
		        <form action="" method="POST" id="product">
		        <?PHP
		        while ($product = fetch($productfetch)){

                    echo    '<tr class="Delete'.$product['id'].'">'
                        . '<td>
                          <input type="checkbox" id="checkItem" name="check_list[]" value="'.$product['id'].'">
                          </td>'
                        . '<td class="textcenter">'.$product['id'].'</td>'
                        . '<td class="textcenter">'.$product['name'].'</td>';
                    echo   "<td class='textcenter'><img src='../uploads/product/large/{$product['image']}' width='150'/></td>";
                    echo   '<td class="textcenter">'.$product['price'].'</td>';
                    echo   "<td class='textcenter'><a href='product/".$product['id']."/kredit/list/' class='btn btn-success'>Kredit keç</a></td>";
                    echo   "<td class='textcenter'><a href='product/".$product['id']."/gallery/list/' class='btn btn-success'>Qalereya keç</a></td>";

                    echo '<td class="textcenter">';
                if ($product['ordering']!=1) {
                    echo '<a href="product/list/up/'.$product['id'].'/'.$product["ordering"].'/"><span class="glyphicon glyphicon-arrow-up"></span></a>';
                }
                echo $product['ordering'];
                
                if ($product['ordering']!=Count($product)) {
                    echo '<a href="product/list/down/'.$product['id'].'/'.$product["ordering"].'/"><span class="glyphicon glyphicon-arrow-down"></span></a>';
                }
                echo '</td>';
                echo    '<td class="textcenter">';

                        if($product['status']==1){
                            echo '<span class="green glyphicon glyphicon-eye-open"></span>';
                        }else{
                            echo '<span class="red glyphicon glyphicon-eye-close"></span>';
                        }
                
                echo
                        '</td>'
                        . '<td style="width:112px;">'
                        . '<a href="product/edit/'.$product['id'].'/"><span class="glyphicon glyphicon-edit"></span></a>'
                        . '<a class="delete-item" onclick="$.deleteAjax($(this))" data-id="'.$product['id'].'" data-value="product" data-url="'.URL.'"><span class="glyphicon glyphicon-remove fr red"></span></a>'
                        . '<a href="product/show/'.$product['id'].'/"><span class="glyphicon glyphicon-eye-open" style="position: relative;left: 30px;"></span></a>'
                        . '</td>'
                        . '</tr>';
                }
            ?>
		        <div class="row">
	                <div class="mb10">
		                <div class="col-md-4">
			                <a type="button" href="product/create/" class="btn btn-primary">Əlavə Et</a>
			                <button type="submit" name="delete" class="btn btn-danger">Sil</button>
			                <button type="submit" name="doactive" class="btn btn-success">Aktiv Et</button>
			                <button type="submit" name="dodeactive" class="btn btn-danger">Deaktiv Et</button>
		                </div>

	                    <?=$pagination;?>
		                <div class="col-md-4">
			                <select name="rowsize" id="rowsize" onchange="this.form.submit()" class="form-control rowsize">
				                <option value="0">--</option>
				                <option value="10">10 </option>
				                <option value="25">25</option>
				                <option value="50">50</option>
				                <option value="100">100</option>
			                </select>
			                <div class="inner-addon left-addon search">
				                <i class="glyphicon glyphicon-search"></i>
				                <input type="search" placeholder="Axtarış et" name="searchtext" class="form-control">
			                </div>
		                </div>
	                </div>
                </div>
		        </form>

            </tbody>
        </table>
        <div class="col-md-4"></div><?=$pagination;?>
    </div>

    </div>
    <!-- /#page-wrapper -->

</div>
    <!-- /#wrapper -->

<?PHP include '../../pages/html_end.php';
ob_end_flush();
?>