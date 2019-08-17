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

    
    if(!empty($_GET['directionrow'])){
        if($_GET["directionrow"] === "asagi"){

            $orderthanmore = prepare("`ordering`","`banner`","`ordering`>?",[get('sira')],"`ordering`","ASC","LIMIT 1")->fetch(PDO::FETCH_ASSOC);

            if (!empty($orderthanmore['ordering'])) {

                update("`banner`","`ordering`=?","`ordering`=?",[get('sira'),$orderthanmore['ordering']]);

                update("`banner`","`ordering`=?","`id`=?",[$orderthanmore['ordering'],get('id')]);

            }

        }elseif($_GET["directionrow"] === "yuxari"){

            $orderthanlittle = prepare("`ordering`","`banner`","`ordering`<?",[get('sira')],"`ordering`","DESC","LIMIT 1")->fetch(PDO::FETCH_ASSOC);

            if (!empty($orderthanlittle['ordering'])) {

                update("`banner`","`ordering`=?","`ordering`=?",[get('sira'),$orderthanlittle['ordering']]);

                update("`banner`","`ordering`=?","`id`=?",[$orderthanlittle['ordering'],get('id')]);

            }

        }
    }
    
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST'){
        if(!empty($_POST['check_list'])) {
            foreach($_POST['check_list'] as $check) {
                if(isset($_POST['delete'])) {
                    $deleteimage = prepare("`image`","`banner`","`id`=?",[$check])->fetch(PDO::FETCH_ASSOC);
                    if (!empty($deleteimage['image'])){
                        @unlink("{$path}uploads/banner/{$deleteimage['image']}");
                        @unlink("{$path}uploads/banner/large/{$deleteimage['image']}");
                        @unlink("{$path}uploads/banner/medium/{$deleteimage['image']}");
                        @unlink("{$path}uploads/banner/little/{$deleteimage['image']}");
                    }
                    delete("`banner`","`id`=?",[$check]);
                }
                if(isset($_POST['doactive'])){
                    update("`banner`","`status`=?","`id`=?",["1",$check]);
                }
                if(isset($_POST['dodeactive'])){
                    update("`banner`","`status`=?","`id`=?",["0",$check]);
                }
            }
        }
        if (!empty(post('searchtext'))){
            $where = "`image_name` LIKE ?";
            $execute = ["%".post('searchtext')."%"];
        }else{
            $where = "`id`>?";
            $execute = ["0"];
        }
        if (empty(post('rowsize'))){$rowsize = "10";}else{$rowsize = post('rowsize');}
        if (isset($_GET["pagination"])) {$page = intval($_GET["pagination"]);} else {$page = 1;};
        $start_from = ($page > 1) ? ($page * $rowsize) - $rowsize : 0;
        $pagination = pagination($rowsize,$page,"2","banner","`id`>?",["0"],"banner");

        $bannerfetch = prepare("*","`banner`",$where,$execute,"`ordering`","DESC","LIMIT $start_from,$rowsize");
    }else{
        if (isset($_GET["pagination"])) {$page = intval($_GET["pagination"]);} else {$page = 1;}
        $perpage = 10;
        $start_from = ($page > 1) ? ($page * $perpage) - $perpage : 0;
        $pagination = pagination($perpage,$page,"2","banner","`id`>?",["0"],"banner");

        $bannerfetch = select("*","`banner`","`ordering`","DESC","LIMIT $start_from,$perpage");
    }

?>
<h1 class="page-header">Banner</h1>

        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th><input type="checkbox" id="checkAll"></th>
                    <th>Id</th>
                    <th>Şəkil</th>
                    <th>Şəkilin adı</th>
                    <th>Link</th>
                    <th>Sıra</th>
                    <th>Status</th>
                    <th>Dəyiş</th>
                </tr>
            </thead>
            <tbody>
            <form action="" method="POST">
            <?PHP
            while ($banner = fetch($bannerfetch)){

                echo    '<tr class="Delete'.$banner['id'].'">'
                        . '<td>
                          <input type="checkbox" id="checkItem" name="check_list[]" value="'.$banner['id'].'">
                          </td>'
                        . '<td>'.$banner['id'].'</td>';
                    echo   "<td><img src='../uploads/banner/{$banner['image']}' width='100'/></td>";
                    echo '<td style="overflow: auto;">'.$banner['image_name'].'</td>';

                if (!empty($banner['url'])) {
                    echo '<td>'.$banner['url'].'</td>';
                }else{
                    echo '<td class="textcenter"><span class="glyphicon glyphicon-alert darkorange"></span></td>';
                }

                echo '<td class="textcenter">';
                if ($banner['ordering']!=1) {
                    echo '<a href="banner/list/up/'.$banner['id'].'/'.$banner["ordering"].'/"><span class="glyphicon glyphicon-arrow-up"></span></a>';
                }
                echo $banner['ordering'];
                
                if ($banner['ordering']!=Count($banner)) {
                    echo '<a href="banner/list/down/'.$banner['id'].'/'.$banner["ordering"].'/"><span class="glyphicon glyphicon-arrow-down"></span></a>';
                }
                echo '</td>';
                echo    '<td class="textcenter">';

                        if($banner['status']==1){
                            echo '<span class="green glyphicon glyphicon-eye-open"></span>';
                        }else{
                            echo '<span class="red glyphicon glyphicon-eye-close"></span>';
                        }
                
                echo
                        '</td>'
                        . '<td style="width:112px;">'
                        . '<a href="banner/edit/'.$banner['id'].'/"><span class="glyphicon glyphicon-edit"></span></a>'
                        . '<a class="delete-item" onclick="$.deleteAjax($(this))" data-id="'.$banner['id'].'" data-value="banner" data-url="'.URL.'"><span class="glyphicon glyphicon-remove fr red"></span></a>'
                        . '<a href="banner/show/'.$banner['id'].'/"><span class="glyphicon glyphicon-eye-open" style="position: relative;left: 30px;"></span></a>'
                        . '</td>'
                        . '</tr>';
            }
            ?>
	            <div class="row">
	                <div class="mb10">
		                <div class="col-md-4">
			                <a type="button" href="banner/create/" class="btn btn-primary">Əlavə Et</a>
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

        <!-- /.row -->
    </div>
    <!-- /#page-wrapper -->

</div>
    <!-- /#wrapper -->
<?PHP include '../../pages/html_end.php';
ob_end_flush();
?>