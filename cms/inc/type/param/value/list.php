<?PHP
ob_start();
$path='../../../../../';
include_once "{$path}config/conf.php";
include_once "../../../../pages/html_start.php";
?>
    <div id="wrapper">

        <?PHP include '../../../../nav.php';?>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <?PHP

                    if(!empty($_GET['directionrow'])){
                        if($_GET["directionrow"] === "asagi"){

                            $orderthanmore = prepare("`ordering`","`value`","`ordering`>?",[get('sira')],"`ordering`","ASC","LIMIT 1")->fetch(PDO::FETCH_ASSOC);

                            if (!empty($orderthanmore['ordering'])) {

                                update("`value`","`ordering`=?","`ordering`=?",[get('sira'),$orderthanmore['ordering']]);

                                update("`value`","`ordering`=?","`id`=?",[$orderthanmore['ordering'],get('id')]);

                            }

                        }elseif($_GET["directionrow"] === "yuxari"){

                            $orderthanlittle = prepare("`ordering`","`value`","`ordering`<?",[get('sira')],"`ordering`","DESC","LIMIT 1")->fetch(PDO::FETCH_ASSOC);

                            if (!empty($orderthanlittle['ordering'])) {

                                update("`value`","`ordering`=?","`ordering`=?",[get('sira'),$orderthanlittle['ordering']]);

                                update("`value`","`ordering`=?","`id`=?",[$orderthanlittle['ordering'],get('id')]);

                            }

                        }
                    }


                    if ($_SERVER['REQUEST_METHOD'] === 'POST'){
                        if(!empty($_POST['check_list'])) {
                            foreach($_POST['check_list'] as $check) {
                                if(isset($_POST['delete'])) {
                                    delete("`value`","`id`=?",[$check]);
                                    redirect($_SERVER['HTTP_REFERER']);
                                }
                                if(isset($_POST['doactive'])){
                                    update("`value`","`status`=?","`id`=?",["1",$check]);
                                }
                                if(isset($_POST['dodeactive'])){
                                    update("`value`","`status`=?","`id`=?",["0",$check]);
                                }
                            }
                        }
                        if (!empty(post('searchtext'))){
                            $where = "`param_id`=? AND `name` LIKE ?";
                            $execute = [get('param_id'),"%".post('searchtext')."%"];
                        }else{
                            $where = "`param_id`=?";
                            $execute = [get('param_id')];
                        }
                        if (empty(post('rowsize'))){$rowsize = "10";}else{$rowsize = post('rowsize');}
                        if (isset($_GET["pagination"])) {$page = intval($_GET["pagination"]);} else {$page = 1;};
                        $start_from = ($page > 1) ? ($page * $rowsize) - $rowsize : 0;
                        $pagination = pagination($rowsize,$page,"2","value","`param_id`=?",[get('param_id')],"type/".get('type_id')."/param/".get('param_id')."/value");

                        $valuefetch = prepare("*","`value`",$where,$execute,"`name`","ASC","LIMIT $start_from,$rowsize");
                    }else{
                        if (isset($_GET["pagination"])) {$page = intval($_GET["pagination"]);} else {$page = 1;}
                        $perpage = 100;
                        $start_from = ($page > 1) ? ($page * $perpage) - $perpage : 0;
                        $pagination = pagination($perpage,$page,"2","value","`param_id`=?",[get('param_id')],"type/".get('type_id')."/param/".get('param_id')."/value");

                        $valuefetch = prepare("*","`value`","`param_id`=?",[get('param_id')],"`name`","ASC","LIMIT $start_from,$perpage");
                    }
                    $param = prepare("`name`,`id`","`type_param`","`id`=?",[get('param_id')])->fetch(PDO::FETCH_ASSOC);

                    ?>
                    <h1 class="page-header"><strong><?= ucfirst($param['name']) ?></strong> paramterinin dəyərləri</h1>

                    <div class="col-md-12">
                        <table class="table table-bordered table-hover sortable-theme-bootstrap" data-sortable>
                            <thead>
                            <tr>
                                <th><input type="checkbox" id="checkAll"></th>
                                <th>Id</th>
                                <th>Ad</th>
                                <th>Sıra</th>
                                <th>Status</th>
                                <th>Dəyiş</th>
                            </tr>
                            </thead>
                            <tbody>
                            <form action="" method="POST">
                                <?PHP
                                while ($value= fetch($valuefetch)){

                                    echo    '<tr class="Delete'.$value['id'].'">'
                                        . '<td>
                          <input type="checkbox" id="checkItem" name="check_list[]" value="'.$value['id'].'">
                          </td>'
                                        . '<td>'.$value['id'].'</td>';
                                    echo   "<td>".$value['name']."</td>";
                                    echo '<td class="textcenter">';
                                    if ($value['ordering']!=1) {
                                        echo '<a href="type/'.get('type_id').'/param/'.get('param_id').'/value/list/up/'.$value['id'].'/'.$value["ordering"].'/"><span class="glyphicon glyphicon-arrow-up"></span></a>';
                                    }
                                    echo $value['ordering'];

                                    if ($value['ordering']!=Count($value)) {
                                        echo '<a href="type/'.get('type_id').'/param/'.get('param_id').'/value/list/down/'.$value['id'].'/'.$value["ordering"].'/"><span class="glyphicon glyphicon-arrow-down"></span></a>';
                                    }
                                    echo '</td>';
                                    echo    '<td class="textcenter">';

                                    if($value['status']==1){
                                        echo '<span class="green glyphicon glyphicon-eye-open"></span>';
                                    }else{
                                        echo '<span class="red glyphicon glyphicon-eye-close"></span>';
                                    }

                                    echo
                                        '</td>'
                                        . '<td style="width:112px;">'
                                        . '<a href="type/'.get('type_id').'/param/'.get('param_id').'/value/edit/'.$value['id'].'/"><span class="glyphicon glyphicon-edit"></span></a>'
                                        . '<a class="delete-item" onclick="$.deleteAjax($(this))" data-id="'.$value['id'].'" data-value="value" data-url="'.URL.'"><span class="glyphicon glyphicon-remove fr red"></span></a>'
                                        . '<a href="type/'.get('type_id').'/param/'.get('param_id').'/value/show/'.$value['id'].'/"><span class="glyphicon glyphicon-eye-open" style="position: relative;left: 30px;"></span></a>'
                                        . '</td>'
                                        . '</tr>';
                                }

                                ?>
                                <div class="row">
                                    <div class="mb10">
                                        <div class="col-md-4">
                                            <a type="button" href="type/<?= get('type_id') ?>/param/<?=get('param_id')?>/value/create/" class="btn btn-primary">Əlavə Et</a>
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
<?PHP include '../../../../pages/html_end.php';
ob_end_flush();
?>