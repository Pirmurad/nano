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
            $orderthanmore=$db->query("SELECT MIN(ordering) FROM gallery WHERE ordering>'".$_GET['sira']."'");
            $a=$orderthanmore->fetch();
            if (!empty($a[0])) {
            $db->query("UPDATE gallery SET ordering='".$_GET['sira']."'  WHERE ordering='".$a[0]."'");
            $db->query("UPDATE gallery SET ordering='".$a[0]."' WHERE id='".$_GET['id']."'");
            }
        }elseif($_GET["directionrow"] === "yuxari"){
            $orderthanlittle=$db->query("SELECT MAX(ordering) FROM gallery WHERE ordering<'".$_GET['sira']."'");
            $b=$orderthanlittle->fetch();
            if (!empty($b[0])) {
            $db->query("UPDATE gallery SET ordering='".$_GET['sira']."'  WHERE ordering='".$b[0]."'");
            $db->query("UPDATE gallery SET ordering='".$b[0]."' WHERE id='".$_GET['id']."'");
            }
    }}
    
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST'){
        if(!empty($_POST['check_list'])) {
            foreach($_POST['check_list'] as $check) {
                if(isset($_POST['delete'])) {
                    $deleteimage = prepare("`image`","`gallery`","`id`=?",[$check]);
                    $deleteimage = $deleteimage[0];
                    if (!empty($deleteimage['image'])){
                        unlink("{$path}uploads/gallery/{$deleteimage['image']}");
                        unlink("{$path}uploads/gallery/large/{$deleteimage['image']}");
                        @unlink("{$path}uploads/gallery/medium/{$deleteimage['image']}");
                        @unlink("{$path}uploads/gallery/little/{$deleteimage['image']}");
                    }
                    delete("`gallery`","`id`=?",[$check]);
                }
                if(isset($_POST['doactive'])){
                    $db->query("UPDATE gallery SET `status`='1' WHERE id='".$check."'");
                }
                if(isset($_POST['dodeactive'])){
                    $db->query("UPDATE gallery SET `status`='0' WHERE id='".$check."'");
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
        $start_from = ($page > 1) ? ($page * $perpage) - $perpage : 0;
        $pagination = pagination($rowsize,$page,"2","gallery","gallery");

        $galleryfetch = prepare("*","`gallery`",$where,$execute,"`ordering`","DESC","LIMIT $start_from,$rowsize");
    }else{
        if (isset($_GET["pagination"])) {$page = intval($_GET["pagination"]);} else {$page = 1;}
        $perpage = 10;
        $start_from = ($page > 1) ? ($page * $perpage) - $perpage : 0;
        $pagination = pagination($perpage,$page,"2","gallery","gallery");

        $galleryfetch = select("*","`gallery`","`ordering`","DESC","LIMIT $start_from,$perpage");
    }

?>
<h1 class="page-header">gallery</h1>

        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th><input type="checkbox" id="checkAll"></th>
                    <th>Id</th>
                    <th>Şəkil</th>
                    <th>Şəkilin adı</th>
                    <th>Link</th>
                    <th>Istiqamət</th>
                    <th>Sıra</th>
                    <th>Status</th>
                    <th>Dəyiş</th>
                </tr>
            </thead>
            <tbody>
            <form action="" method="POST">
            <?PHP
            if (!empty($galleryfetch)){
                foreach ($galleryfetch as $gallery){

                    echo    '<tr>'
                        . '<td>
                          <input type="checkbox" id="checkItem" name="check_list[]" value="'.$gallery['id'].'">
                          </td>'
                        . '<td>'.$gallery['id'].'</td>';
                    echo   "<td><img src='../uploads/gallery/{$gallery['image']}' width='100'/></td>";
                    echo '<td style="overflow: auto;">'.$gallery['image_name'].'</td>';

                if (!empty($gallery['url'])) {
                    echo '<td>'.$gallery['url'].'</td>';
                }else{
                    echo '<td class="textcenter"><span class="glyphicon glyphicon-alert darkorange"></span></td>';
                }

                if ($gallery['direction']==1) {
                    echo '<td class="textcenter"><span class="glyphicon glyphicon-arrow-up"></span></td>';
                }else{
                    echo '<td class="textcenter"><span class="glyphicon glyphicon-arrow-left"></span><span class="glyphicon glyphicon-arrow-right"></span></td>';
                }



                echo '<td class="textcenter">';
                if ($gallery['ordering']!=1) {
                    echo '<a href="gallery/list/up/'.$gallery['id'].'/'.$gallery["ordering"].'/"><span class="glyphicon glyphicon-arrow-up"></span></a>';
                }
                echo $gallery['ordering'];
                
                if ($gallery['ordering']!=Count($galleryfetch)) {
                    echo '<a href="gallery/list/down/'.$gallery['id'].'/'.$gallery["ordering"].'/"><span class="glyphicon glyphicon-arrow-down"></span></a>';
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
                        . '<a href="gallery/edit/'.$gallery['id'].'/"><span class="glyphicon glyphicon-edit"></span></a>'
                        . '<a href="gallery/delete/'.$gallery['id'].'/"><span class="glyphicon glyphicon-remove fr red"></span></a>'
                        . '<a href="gallery/show/'.$gallery['id'].'/"><span class="glyphicon glyphicon-eye-open" style="position: relative;left: 30px;"></span></a>'
                        . '</td>'
                        . '</tr>';
            }}
            ?>
	            <div class="row">
	                <div class="mb10">
		                <div class="col-md-4">
			                <a type="button" href="gallery/create/" class="btn btn-primary">Əlavə Et</a>
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