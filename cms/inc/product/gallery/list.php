<?PHP
ob_start();
$path='../../../../';
include_once "{$path}config/conf.php";
include_once "../../../pages/html_start.php";
    
    if(!empty($_GET['directionrow'])){
        if($_GET["directionrow"] === "asagi"){
            $orderthanmore = prepare("`ordering`","`gallery`","`product_id`=? AND `ordering`>?",[get('product_id'),get('sira')],"`ordering`","ASC","LIMIT 1")->fetch(PDO::FETCH_ASSOC);
            if (!empty($orderthanmore['ordering'])) {
                update("`gallery`","`ordering`=?","`ordering`=?",[get('sira'),$orderthanmore['ordering']]);
                update("`gallery`","`ordering`=?","`id`=?",[$orderthanmore['ordering'],get('id')]);
            }
        }elseif($_GET["directionrow"] === "yuxari"){
            $orderthanlittle = prepare("`ordering`","`gallery`","`product_id`=? AND `ordering`<?",[get('product_id'),get('sira')],"`ordering`","DESC","LIMIT 1")->fetch(PDO::FETCH_ASSOC);
            if (!empty($orderthanlittle['ordering'])) {
                update("`gallery`","`ordering`=?","`ordering`=?",[get('sira'),$orderthanlittle['ordering']]);
                update("`gallery`","`ordering`=?","`id`=?",[$orderthanlittle['ordering'],get('id')]);
            }
        }
    }
    
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST'){
        if(!empty($_POST['check_list'])) {
            foreach($_POST['check_list'] as $check) {
                if(isset($_POST['delete'])) {
                    $deleteimage = prepare("`image`","`gallery`","`id`=?",[$check])->fetch(PDO::FETCH_ASSOC);
                    if (!empty($deleteimage['image'])){
                        @unlink("{$path}uploads/gallery/{$deleteimage['image']}");
                        @unlink("{$path}uploads/gallery/large/{$deleteimage['image']}");
                        @unlink("{$path}uploads/gallery/medium/{$deleteimage['image']}");
                        @unlink("{$path}uploads/gallery/little/{$deleteimage['image']}");
                    }
                    delete("`gallery`","`id`=?",[$check]);
                    redirect('product/'.get('product_id').'/gallery/list/');
                }
                if(isset($_POST['doactive'])){
                    update("`gallery`","`status`=?","`id`=?",['1',$check]);
                }
                if(isset($_POST['dodeactive'])){
                    update("`gallery`","`status`=?","`id`=?",['0',$check]);
                }
            }
        }
        if (!empty(post('searchtext'))){
            $where = "`image` LIKE ?";
            $execute = ["%".post('searchtext')."%"];
        }else{
            $where = "`id`>?";
            $execute = ["0"];
        }

        if (empty(post('rowsize'))){$rowsize = "10";}else{$rowsize = post('rowsize');}
        if (isset($_GET["pagination"])) {$page = intval($_GET["pagination"]);} else {$page = 1;};
        $start_from = ($page > 1) ? ($page * $perpage) - $perpage : 0;
        $pagination = pagination($rowsize,$page,"2","gallery","`id`>?",["0"],"product/".get('product_id')."/gallery");

        $galleryfetch = prepare("*","`gallery`",$where,$execute,"`ordering`","DESC","LIMIT $start_from,$rowsize");
    }else{
        if (isset($_GET["pagination"])) {$page = intval($_GET["pagination"]);} else {$page = 1;}
        $perpage = 10;
        $start_from = ($page > 1) ? ($page * $perpage) - $perpage : 0;
        $pagination = pagination($perpage,$page,"2","gallery","`id`>?",["0"],"product/".get('product_id')."/gallery");

        $galleryfetch = prepare("*","`gallery`","`product_id`=?",[get('product_id')],"`ordering`","DESC","LIMIT $start_from,$perpage");
        $product = prepare("`name`","`product`","`id`=?",[get('product_id')])->fetch(PDO::FETCH_ASSOC);
    }

?>
<div id="wrapper">

<?PHP include '../../../nav.php';?>

    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
<h1 class="page-header"><b><?=$product['name'];?></b> elanının qalereyası</h1>

	    <form action="" method="POST">
        <table class="table table-bordered table-hover" id="gallerydatatable">
            <thead>
                <tr>
                    <th><input type="checkbox" id="checkAll"></th>
                    <th class="text-center">Id</th>
                    <th class="text-center">Şəkil</th>
                    <th class="text-center">Sıra</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Dəyiş</th>
                </tr>
            </thead>
            <tbody>

            <?
              while($gallery = fetch($galleryfetch)){

                    echo    '<tr class="Delete'.$gallery['id'].'">'
                        . '<td>
                          <input type="checkbox" id="checkItem" name="check_list[]" value="'.$gallery['id'].'">
                          </td>'
                        . '<td class="text-center">'.$gallery['id'].'</td>';
                    echo   "<td class=\"text-center\"><img src='../uploads/gallery/large/{$gallery['image']}' width='100'/></td>";
                echo '<td class="textcenter">';
                if ($gallery['ordering']!=1) {
                    echo '<a href="product/'.$gallery['product_id'].'/gallery/list/up/'.$gallery['id'].'/'.$gallery["ordering"].'/"><span class="glyphicon glyphicon-arrow-up"></span></a>';
                }
                echo $gallery['ordering'];
                
                if ($gallery['ordering']!=Count($gallery)) {
                    echo '<a href="product/'.$gallery['product_id'].'/gallery/list/down/'.$gallery['id'].'/'.$gallery["ordering"].'/"><span class="glyphicon glyphicon-arrow-down"></span></a>';
                }
                echo '</td>';
                echo    '<td class="textcenter">';

                        if($gallery['status']==1){
                            echo '<span class="green glyphicon glyphicon-eye-open"></span>';
                        }else{
                            echo '<span class="red glyphicon glyphicon-eye-close"></span>';
                        }
                
                echo
                        '</td>'
                        . '<td style="width:112px;">'
                        . '<a href="product/'.$_GET['product_id'].'/gallery/edit/'.$gallery['id'].'/"><span class="glyphicon glyphicon-edit"></span></a>'
                        . '<a href="product/'.$_GET['product_id'].'/gallery/delete/'.$gallery['id'].'/"><span class="glyphicon glyphicon-remove fr red"></span></a>'
                        . '<a href="product/'.$_GET['product_id'].'/gallery/show/'.$gallery['id'].'/"><span class="glyphicon glyphicon-eye-open" style="position: relative;left: 30px;"></span></a>'
                        . '</td>'
                        . '</tr>';
            }
            ?>
            <div class="row">
                <div class="mb10">
                    <div class="col-md-4">
                        <a type="button" href="product/<?= get('product_id') ?>/gallery/create/" class="btn btn-primary">Əlavə Et</a>
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

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

<?PHP include '../../../pages/html_end.php';
ob_end_flush();
?>