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

            $orderthanmore = prepare("`ordering`","`category`","`ordering`>?",[get('sira')],"`ordering`","ASC","LIMIT 1")->fetch(PDO::FETCH_ASSOC);

            if (!empty($orderthanmore['ordering'])) {

                update("`category`","`ordering`=?","`ordering`=?",[get('sira'),$orderthanmore['ordering']]);

                update("`category`","`ordering`=?","`id`=?",[$orderthanmore['ordering'],get('id')]);

            }

        }elseif($_GET["directionrow"] === "yuxari"){

            $orderthanlittle = prepare("`ordering`","`category`","`ordering`<?",[get('sira')],"`ordering`","DESC","LIMIT 1")->fetch(PDO::FETCH_ASSOC);

            if (!empty($orderthanlittle['ordering'])) {

                update("`category`","`ordering`=?","`ordering`=?",[get('sira'),$orderthanlittle['ordering']]);

                update("`category`","`ordering`=?","`id`=?",[$orderthanlittle['ordering'],get('id')]);

            }

        }
    }
    
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST'){
        if(!empty($_POST['check_list'])) {
            foreach($_POST['check_list'] as $check) {
                if(isset($_POST['delete'])) {

                    delete("`category`","`id`=?",[$check]);

                }

                if(isset($_POST['doactive'])){

                    update("`category`","`status`=?","`id`=?",['1',$check]);

                }

                if(isset($_POST['dodeactive'])){

                    update("`category`","`status`=?","`id`=?",['1',$check]);

                }
            }
        }
        if (!empty(post('searchtext'))){
            $where = "`name` LIKE ?";
            $execute = ["%".post('searchtext')."%"];
        }else{
            $where = "`id`>?";
            $execute = ["0"];
        }

        if (empty(post('rowsize'))){$rowsize = "10";}else{$rowsize = post('rowsize');}
        if (isset($_GET["pagination"])) {$page = intval($_GET["pagination"]);} else {$page = 1;};
        $start_from = ($page > 1) ? ($page * $rowsize) - $rowsize : 0;
        $pagination = pagination($rowsize,$page,"2","category","`id`>?",["0"],"category");

        $categoryfetch = prepare("*","`category`",$where,$execute,"`ordering`","DESC","LIMIT $start_from,$rowsize");
    }else{

        if (isset($_GET["pagination"])) {$page = intval($_GET["pagination"]);} else {$page = 1;}
        $perpage = 10;
        $start_from = ($page > 1) ? ($page * $perpage) - $perpage : 0;
        $pagination = pagination($perpage,$page,"2","category","`id`>?",["0"],"category");

        $categoryfetch = select("*","`category`","`ordering`","DESC","LIMIT $start_from,$perpage");
    }

?>
<h1 class="page-header">Kateqoriya</h1>

	    <form action="" method="POST">
        <table class="table table-bordered table-hover" id="categorydatatable">
            <thead>
                <tr>
                    <th><input type="checkbox" id="checkAll"></th>
                    <th class="textcenter">Id</th>
                    <th class="textcenter">Ad</th>
                    <th class="textcenter">Link Adı</th>
                    <th class="textcenter">Ana kateqoriyası</th>
                    <th class="textcenter">Sıra</th>
                    <th class="textcenter">Status</th>
                    <th class="textcenter">Dəyiş</th>
                </tr>
            </thead>
            <tbody>

            <?PHP
                while ($category = fetch($categoryfetch)){
					$parentcategory = prepare("`name`","`category`","`id`=?",[$category['parent_id']])->fetch(PDO::FETCH_ASSOC);

                    if($category['parent_id']!=0){
                        $level='<span class="glyphicon glyphicon-level-up"></span>  ';
                    }else{
                        $level='';
                    };
                    
                    echo    '<tr>'
                        . '<td>
                          <input type="checkbox" id="checkItem" name="check_list[]" value="'.$category['id'].'">
                          </td>'
                        . '<td class="text-center">'.$category['id'].'</td>'
                        . '<td class="text-center">'.$level.$category['name'].'</td>'
                        . '<td class="text-center">'.$category['linkname'].'</td>';
                    if (!empty($parentcategory['name'])){
                    	echo '<td class="text-center">'.$parentcategory['name'].'</td>';
                    }else{
                    	echo '<td class="text-center"><span class="red glyphicon glyphicon-minus"></span></td>';
                    }


                echo
                        '<td class="textcenter">';
                if ($category['ordering']!=1) {
                    echo '<a href="category/list/up/'.$category['id'].'/'.$category["ordering"].'/"><span class="glyphicon glyphicon-arrow-up"></span></a>';
                }
                echo $category['ordering'];
                
                if ($category['ordering']!=Count($category)) {
                    echo '<a href="category/list/down/'.$category['id'].'/'.$category["ordering"].'/"><span class="glyphicon glyphicon-arrow-down"></span></a>';
                }
                                
                echo    '<td class="textcenter">';
                        
                        if($category['status']==1){
                            echo '<span class="green glyphicon glyphicon-eye-open"></span>';
                        }else{
                            echo '<span class="red glyphicon glyphicon-eye-close"></span>';
                        }
                
                echo
                        '</td>'
                        . '<td style="width:112px;">'
                        . '<a href="category/edit/'.$category['id'].'/"><span class="glyphicon glyphicon-edit"></span></a>'
                        . '<a class="delete-item" onclick="$.deleteAjax($(this))" data-id="'.$category['id'].'" data-value="category" data-url="'.URL.'"><span class="glyphicon glyphicon-remove fr red"></span></a>'
                        . '<a href="category/show/'.$category['id'].'/"><span class="glyphicon glyphicon-eye-open" style="position: relative;left: 30px;"></span></a>'
                        . '</td>'
                        . '</tr>';
            }
            ?>
	            <div class="row">
		            <div class="mb10">
			            <div class="col-md-4">
				            <a type="button" href="category/create/" class="btn btn-primary">Əlavə Et</a>
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
<?PHP include '../../pages/html_end.php';
ob_end_flush();
?>