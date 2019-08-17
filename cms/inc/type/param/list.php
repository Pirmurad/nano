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


            $orderthanmore = prepare("`ordering`","`type_param`","`type_id`=? AND `ordering`>?",[get('type_id'),get('sira')],"`ordering`","ASC","LIMIT 1")->fetch(PDO::FETCH_ASSOC);

            if (!empty($orderthanmore['ordering'])) {

                update("`type_param`","`ordering`=?","`type_id`=? AND `ordering`=?",[get('sira'),get('type_id'),$orderthanmore['ordering']]);

                update("`type_param`","`ordering`=?","`type_id`=? AND `id`=?",[$orderthanmore['ordering'],get('type_id'),get('id')]);

            }

        }elseif($_GET["directionrow"] === "yuxari"){

            $orderthanlittle = prepare("`ordering`","`type_param`","`type_id`=? AND `ordering`<?",[get('type_id'),get('sira')],"`ordering`","DESC","LIMIT 1")->fetch(PDO::FETCH_ASSOC);

            if (!empty($orderthanlittle['ordering'])) {

                update("`type_param`","`ordering`=?","`type_id`=? AND `ordering`=?",[get('sira'),get('type_id'),$orderthanlittle['ordering']]);

                update("`type_param`","`ordering`=?","`type_id`=? AND `id`=?",[$orderthanlittle['ordering'],get('type_id'),get('id')]);

            }

        }
    }


    if ($_SERVER['REQUEST_METHOD'] === 'POST'){
        if(!empty($_POST['check_list'])) {
            foreach($_POST['check_list'] as $check) {
                if(isset($_POST['delete'])) {
                    delete("`type_param`","`id`=?",[$check]);
                }
                if(isset($_POST['doactive'])){
                    update("`type_param`","`status`=?","`id`=?",["1",$check]);
                }
                if(isset($_POST['dodeactive'])){
                    update("`type_param`","`status`=?","`id`=?",["0",$check]);
                }
            }
        }
        if (!empty(post('searchtext'))){
            $where = "`type_id`=? AND `name` LIKE ?";
            $execute = [get('type_id'),"%".post('searchtext')."%"];
        }else{
            $where = "`type_id`=?";
            $execute = [get('type_id')];
        }
        if (empty(post('rowsize'))){$rowsize = "10";}else{$rowsize = post('rowsize');}
        if (isset($_GET["pagination"])) {$page = intval($_GET["pagination"]);} else {$page = 1;};
        $start_from = ($page > 1) ? ($page * $rowsize) - $rowsize : 0;
        $pagination = pagination($rowsize,$page,"2","type_param","`type_id`=?",[get('type_id')],"type/".get('type_id')."/param");

        $type_paramfetch = prepare("*","`type_param`",$where,$execute,"`ordering`","ASC","LIMIT $start_from,$rowsize");
    }else{
        if (isset($_GET["pagination"])) {$page = intval($_GET["pagination"]);} else {$page = 1;}
        $perpage = 50;
        $start_from = ($page > 1) ? ($page * $perpage) - $perpage : 0;
        $pagination = pagination($perpage,$page,"2","type_param","`type_id`=?",[get('type_id')],"type/".get('type_id')."/param");

        $type_paramfetch = prepare("*","`type_param`","`type_id`=?",[get('type_id')],"`ordering`","ASC","LIMIT $start_from,$perpage");
    }
    $type = prepare("`name`,`id`","`type`","`id`=?",[get('type_id')])->fetch(PDO::FETCH_ASSOC);

?>
<h1 class="page-header"><strong><?= ucfirst($type['name']) ?></strong> tipinin parametrləri</h1>

    <div class="col-md-12">
        <table class="table table-bordered table-hover sortable-theme-bootstrap" data-sortable>
            <thead>
                <tr>
                    <th><input type="checkbox" id="checkAll"></th>
                    <th>Id</th>
                    <th>Ad</th>
                    <th>Dəyərlər</th>
                    <th>Sıra</th>
                    <th>Status</th>
                    <th>Dəyiş</th>
                </tr>
            </thead>
            <tbody>
            <form action="" method="POST">
            <?PHP
                while ($type_param= fetch($type_paramfetch)){

                    echo    '<tr class="Delete'.$type_param['id'].'">'
                        . '<td>
                          <input type="checkbox" id="checkItem" name="check_list[]" value="'.$type_param['id'].'">
                          </td>'
                        . '<td>'.$type_param['id'].'</td>';
                    echo   "<td>".$type_param['name']."</td>";
                    echo   "<td><a href='type/".$type['id']."/param/".$type_param['id']."/value/list/' class='btn btn-default'>Dəyərlərə keçid</td>";
                echo '<td class="textcenter">';
                if ($type_param['ordering']!=1) {
                    echo '<a href="type/'.get('type_id').'/param/list/up/'.$type_param['id'].'/'.$type_param["ordering"].'/"><span class="glyphicon glyphicon-arrow-up"></span></a>';
                }
                echo $type_param['ordering'];

                if ($type_param['ordering']!=Count($type_param)) {
                    echo '<a href="type/'.get('type_id').'/param/list/down/'.$type_param['id'].'/'.$type_param["ordering"].'/"><span class="glyphicon glyphicon-arrow-down"></span></a>';
                }
                echo '</td>';
                echo    '<td class="textcenter">';

                        if($type_param['status']==1){
                            echo '<span class="green glyphicon glyphicon-eye-open"></span>';
                        }else{
                            echo '<span class="red glyphicon glyphicon-eye-close"></span>';
                        }

                echo
                        '</td>'
                        . '<td style="width:112px;">'
                        . '<a href="type/'.get('type_id').'/param/edit/'.$type_param['id'].'/"><span class="glyphicon glyphicon-edit"></span></a>'
                        . '<a class="delete-item" onclick="$.deleteAjax($(this))" data-id="'.$type_param['id'].'" data-value="type_param" data-url="'.URL.'"><span class="glyphicon glyphicon-remove fr red"></span></a>'
                        . '<a href="type/'.get('type_id').'/param/show/'.$type_param['id'].'/"><span class="glyphicon glyphicon-eye-open" style="position: relative;left: 30px;"></span></a>'
                        . '</td>'
                        . '</tr>';
                }

            ?>
	            <div class="row">
		            <div class="mb10">
			            <div class="col-md-4">
                            <a type="button" href="type/<?= get('type_id') ?>/param/create/" class="btn btn-primary">Əlavə Et</a>
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