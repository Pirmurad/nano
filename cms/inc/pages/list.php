<?PHP
ob_start();
$path='../../../';
include_once "{$path}config/conf.php";
include_once "{$path}helper/func.php";
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
            $orderthanmore=$db->query("SELECT MIN(ordering) FROM pages WHERE ordering>'".$_GET['sira']."'");
            $a=$orderthanmore->fetch();
            if (!empty($a[0])) {
            $db->query("UPDATE pages SET ordering='".$_GET['sira']."'  WHERE ordering='".$a[0]."'");
            $db->query("UPDATE pages SET ordering='".$a[0]."' WHERE id='".$_GET['id']."'");
            }
        }elseif($_GET["directionrow"] === "yuxari"){
            $orderthanlittle=$db->query("SELECT MAX(ordering) FROM pages WHERE ordering<'".$_GET['sira']."'");
            $b=$orderthanlittle->fetch();
            if (!empty($b[0])) {
            $db->query("UPDATE pages SET ordering='".$_GET['sira']."'  WHERE ordering='".$b[0]."'");
            $db->query("UPDATE pages SET ordering='".$b[0]."' WHERE id='".$_GET['id']."'");
            }
    }}

    if (!empty(post('searchtext'))){
        $where = "`name_az` LIKE ?";
        $execute = ["%".post('searchtext')."%"];
    }else{
        $where = "`status`=?";
        $execute = ["1"];
    }


    if ($_SERVER['REQUEST_METHOD'] === 'POST'){
        if(isset($_POST['check_list'])) {
            foreach($_POST['check_list'] as $check) {
                if(isset($_POST['delete'])) {
                    $deleteimage = prepare("`image`","`pages`","`id`=?",[$check]);
                    $deleteimage = $deleteimage[0];
	                if (!empty($deleteimage['image'])){
                    	unlink("{$path}uploads/pages/{$deleteimage['image']}");
	                    unlink("{$path}uploads/pages/large/{$deleteimage['image']}");
                    	@unlink("{$path}uploads/pages/medium/{$deleteimage['image']}");
                    	@unlink("{$path}uploads/pages/little/{$deleteimage['image']}");
                    }
                    delete("`pages`","`id`=?",[$check]);
                }
                if(isset($_POST['doactive'])){
                    update("`pages`","`status`=?","`id`=?",['1',$check]);
                }
                if(isset($_POST['dodeactive'])){
                    update("`pages`","`status`=?","`id`=?",['0',$check]);
                }
            }
        }

        if (empty(post('rowsize'))){$rowsize = "10";}else{$rowsize = post('rowsize');}
        if (isset($_GET["pagination"])) {$page = intval($_GET["pagination"]);} else {$page = 1;};
        $start_from = ($page > 1) ? ($page * $perpage) - $perpage : 0;
        $pagination = pagination($rowsize,$page,"2","pages","pages");

        $pagesfetch = prepare("*","`pages`",$where,$execute,"`id`","DESC","LIMIT $start_from,$rowsize");
    }else{
        if (isset($_GET["pagination"])) {$page = intval($_GET["pagination"]);} else {$page = 1;}
        $perpage = 10;
        $start_from = ($page > 1) ? ($page * $perpage) - $perpage : 0;
        $pagination = pagination($perpage,$page,"2","pages","pages");

        $pagesfetch = prepare("*","`pages`",$where,$execute,"`id`","DESC","LIMIT $start_from,$perpage");
    }

?>
<h1 class="page-header">Səhifələr</h1>

        <table class="table table-bordered table-hover sortable-theme-bootstrap" data-sortable>
            <thead>
                <tr>
                    <th><input type="checkbox" id="checkAll"></th>
                    <th class="textcenter">Id</th>
                    <th class="textcenter">Ad</th>
                    <th class="textcenter">Sıra</th>
                    <th class="textcenter">Status</th>
                    <th class="textcenter">Dəyiş</th>
                </tr>
            </thead>
	        <tbody>
		        <form action="" method="POST" id="pages">
		        <?PHP
		        if (!empty($pagesfetch)){
                foreach ($pagesfetch as $pages){

                    echo    '<tr>'
                        . '<td>
                          <input type="checkbox" id="checkItem" name="check_list[]" value="'.$pages['id'].'">
                          </td>'
                        . '<td class="textcenter">'.$pages['id'].'</td>'
                        . '<td class="textcenter">'.$pages['name_az'].'</td>';

                    echo '<td class="textcenter">';
                if ($pages['ordering']!=1) {
                    echo '<a href="pages/list/up/'.$pages['id'].'/'.$pages["ordering"].'/"><span class="glyphicon glyphicon-arrow-up"></span></a>';
                }
                echo $pages['ordering'];
                
                if ($pages['ordering']!=Count($pagesfetch)) {
                    echo '<a href="pages/list/down/'.$pages['id'].'/'.$pages["ordering"].'/"><span class="glyphicon glyphicon-arrow-down"></span></a>';
                }
                echo '</td>';
                echo    '<td class="textcenter">';

                        if($pages['status']==1){
                            echo '<span class="green glyphicon glyphicon-eye-open"></span>';
                        }else{
                            echo '<span class="red glyphicon glyphicon-eye-close"></span>';
                        }
                
                echo
                        '</td>'
                        . '<td style="width:112px;">'
                        . '<a href="pages/edit/'.$pages['id'].'/"><span class="glyphicon glyphicon-edit"></span></a>'
                        . '<a href="pages/delete/'.$pages['id'].'/"><span class="glyphicon glyphicon-remove fr red"></span></a>'
                        . '<a href="pages/show/'.$pages['id'].'/"><span class="glyphicon glyphicon-eye-open" style="position: relative;left: 30px;"></span></a>'
                        . '</td>'
                        . '</tr>';
                    }
		        }else{
		        	echo "<div class='col-md-offset-4 no-result'><h2>Heç bir məlumat tapılmadı !</h2></div>";
		        }
            ?>
		        <div class="row">
	                <div class="mb10">
		                <div class="col-md-4">
			                <a type="button" href="pages/create/" class="btn btn-primary">Əlavə Et</a>
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