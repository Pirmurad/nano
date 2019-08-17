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

    if(!empty($_GET['directionrow'])){
        if($_GET["directionrow"] === "asagi"){

            $orderthanmore = prepare("`ordering`","`kredit_product`","`ordering`>?",[get('sira')],"`ordering`","ASC","LIMIT 1")->fetch(PDO::FETCH_ASSOC);

            if (!empty($orderthanmore['ordering'])) {

                update("`kredit_product`","`ordering`=?","`ordering`=?",[get('sira'),$orderthanmore['ordering']]);

                update("`kredit_product`","`ordering`=?","`id`=?",[$orderthanmore['ordering'],get('id')]);

            }

        }elseif($_GET["directionrow"] === "yuxari"){

            $orderthanlittle = prepare("`ordering`","`kredit_product`","`ordering`<?",[get('sira')],"`ordering`","DESC","LIMIT 1")->fetch(PDO::FETCH_ASSOC);

            if (!empty($orderthanlittle['ordering'])) {

                update("`kredit_product`","`ordering`=?","`ordering`=?",[get('sira'),$orderthanlittle['ordering']]);

                update("`kredit_product`","`ordering`=?","`id`=?",[$orderthanlittle['ordering'],get('id')]);

            }

        }
    }
    
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST'){
        if(!empty($_POST['check_list'])) {
            foreach($_POST['check_list'] as $check) {
                if(isset($_POST['delete'])) {

                    delete("`kredit_product`","`id`=?",[$check]);

                }

                if(isset($_POST['doactive'])){

                    update("`kredit_product`","`status`=?","`id`=?",['1',$check]);

                }

                if(isset($_POST['dodeactive'])){

                    update("`kredit_product`","`status`=?","`id`=?",['1',$check]);

                }
            }
        }
        if (!empty(post('searchtext'))){
            $where = "`product_id`=? AND `name` LIKE ?";
            $execute = [get('product_id'),"%".post('searchtext')."%"];
        }else{
            $where = "`product_id`=?";
            $execute = [get('product_id')];
        }

        if (empty(post('rowsize'))){$rowsize = "10";}else{$rowsize = post('rowsize');}
        if (isset($_GET["pagination"])) {$page = intval($_GET["pagination"]);} else {$page = 1;};
        $start_from = ($page > 1) ? ($page * $rowsize) - $rowsize : 0;
        $pagination = pagination($rowsize,$page,"2","kredit_product","`product_id`=?",[get('product_id')],"kredit");

        $kreditfetch = prepare("*","`kredit_product`",$where,$execute,"`id`","DESC","LIMIT $start_from,$rowsize");
    }else{
        if (isset($_GET["pagination"])) {$page = intval($_GET["pagination"]);} else {$page = 1;}
        $perpage = 10;
        $start_from = ($page > 1) ? ($page * $perpage) - $perpage : 0;
        $pagination = pagination($perpage,$page,"2","kredit_product","`id`>?",["0"],"kredit");

        $kreditfetch = prepare("*","`kredit_product`","`product_id`=?",[get('product_id')],"`id`","DESC","LIMIT $start_from,$perpage");
    }

?>
<h1 class="page-header">Kredit Kampaniyaları</h1>

	    <form action="" method="POST">
        <table class="table table-bordered table-hover sortable-theme-bootstrap" data-sortable>
            <thead>
                <tr>
                    <th><input type="checkbox" id="checkAll"></th>
                    <th class="textcenter">Id</th>
                    <th class="textcenter">Ad</th>
                    <th class="textcenter">İlkin ödənişi</th>
                    <th class="textcenter">Dəyiş</th>
                </tr>
            </thead>
            <tbody>

            <?PHP
                while ($kredit = fetch($kreditfetch)){

                    echo    '<tr class="Delete'.$kredit['id'].'">'
                        . '<td>
                          <input type="checkbox" id="checkItem" name="check_list[]" value="'.$kredit['id'].'">
                          </td>'
                        . '<td class="text-center">'.$kredit['id'].'</td>'
                        . '<td class="text-center">'.$kredit['name'].'</td>'
                        . '<td class="text-center">'.$kredit['ilkin_odenis'].' AZN</td>';

                echo '<td style="width:112px;">'
                        . '<a href="product/'.get('product_id').'/kredit/edit/'.$kredit['id'].'/"><span class="glyphicon glyphicon-edit"></span></a>'
                        . '<a class="delete-item" onclick="$.deleteAjax($(this))" data-id="'.$kredit['id'].'" data-value="product/kredit" data-url="'.URL.'"><span class="glyphicon glyphicon-remove fr red"></span></a>'
                        . '<a href="product/'.get('product_id').'/kredit/show/'.$kredit['id'].'/"><span class="glyphicon glyphicon-eye-open" style="position: relative;left: 30px;"></span></a>'
                        . '</td>'
                        . '</tr>';
            }
            ?>
	            <div class="row">
		            <div class="mb10">
			            <div class="col-md-4">
				            <a type="button" href="product/<?=get('product_id')?>/kredit/create/" class="btn btn-primary">Əlavə Et</a>
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
            </tbody>
        </table>
	    </form>
	    <div class="col-md-4"></div><?=$pagination;?>
    </div>
    <!-- /.col-lg-12 -->
</div>
    </div>
    <!-- /#page-wrapper -->

</div>
    <!-- /#wrapper -->
<?PHP include '../../../pages/html_end.php';
ob_end_flush();
?>