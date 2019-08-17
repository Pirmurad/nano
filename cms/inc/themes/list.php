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
            $orderthanmore=$db->query("SELECT MIN(ordering) FROM themes WHERE ordering>'".$_GET['sira']."'");
            $a=$orderthanmore->fetch();
            if (!empty($a[0])) {
            $db->query("UPDATE themes SET ordering='".$_GET['sira']."'  WHERE ordering='".$a[0]."'");
            $db->query("UPDATE themes SET ordering='".$a[0]."' WHERE id='".$_GET['id']."'");
            }
        }elseif($_GET["directionrow"] === "yuxari"){
            $orderthanlittle=$db->query("SELECT MAX(ordering) FROM themes WHERE ordering<'".$_GET['sira']."'");
            $b=$orderthanlittle->fetch();
            if (!empty($b[0])) {
            $db->query("UPDATE themes SET ordering='".$_GET['sira']."'  WHERE ordering='".$b[0]."'");
            $db->query("UPDATE themes SET ordering='".$b[0]."' WHERE id='".$_GET['id']."'");
            }
    }}
    
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST'){
        if(!empty($_POST['check_list'])) {
            foreach($_POST['check_list'] as $check) {
                if(isset($_POST['delete'])) {
                    $deleteimage = prepare("`image`","`themes`","`id`=?",[$check]);
                    $deleteimage = $deleteimage[0];
                    if (!empty($deleteimage['image'])){
                        unlink("{$path}uploads/themes/{$deleteimage['image']}");
                    }
                    delete("`themes`","`id`=?",[$check]);
                }
                if(isset($_POST['doactive'])){
                    $db->query("UPDATE themes SET `status`='1' WHERE id='".$check."'");
                }
                if(isset($_POST['dodeactive'])){
                    $db->query("UPDATE themes SET `status`='0' WHERE id='".$check."'");
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
        $start_from = ($page > 1) ? ($page * $perpage) - $perpage : 0;
        $pagination = pagination($rowsize,$page,"2","themes","themes");

        $themesfetch = prepare("*","`themes`",$where,$execute,"`id`","DESC","LIMIT $start_from,$rowsize");
    }else{
        if (isset($_GET["pagination"])) {$page = intval($_GET["pagination"]);} else {$page = 1;}
        $perpage = 10;
        $start_from = ($page > 1) ? ($page * $perpage) - $perpage : 0;
        $pagination = pagination($perpage,$page,"2","themes","themes");

        $themesfetch = select("*","`themes`","`id`","DESC","LIMIT $start_from,$perpage");
    }

?>
<h1 class="page-header">Temalar</h1>

        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th><input type="checkbox" id="checkAll"></th>
                    <th>Id</th>
                    <th>Ad</th>
                    <th>Şəkil</th>
                    <th>Status</th>
                    <th>Dəyiş</th>
                </tr>
            </thead>
            <tbody>
            <form action="" method="POST">
            <?PHP
            if (!empty($themesfetch)){
                foreach ($themesfetch as $themes){

                    echo    '<tr>'
                        . '<td>
                          <input type="checkbox" id="checkItem" name="check_list[]" value="'.$themes['id'].'">
                          </td>'
                        . '<td>'.$themes['id'].'</td>'
                        . '<td>'.$themes['name'].'</td>';
                    echo   "<td><img src='../uploads/themes/{$themes['image']}' width='100' height='200'/></td>";

                echo    '<td class="textcenter">';

                        if($themes['status']==1){
                            echo '<span class="green glyphicon glyphicon-eye-open"></span>';
                        }else{
                            echo '<span class="red glyphicon glyphicon-eye-close"></span>';
                        }
                
                echo
                        '</td>'
                        . '<td style="width:112px;">'
                        . '<a href="themes/edit/'.$themes['id'].'/"><span class="glyphicon glyphicon-edit"></span></a>'
                        . '<a href="themes/delete/'.$themes['id'].'/"><span class="glyphicon glyphicon-remove fr red"></span></a>'
                        . '<a href="themes/show/'.$themes['id'].'/"><span class="glyphicon glyphicon-eye-open" style="position: relative;left: 30px;"></span></a>'
                        . '</td>'
                        . '</tr>';
            }}
            ?>
	            <div class="row">
	                <div class="mb10">
		                <div class="col-md-4">
			                <a type="button" href="themes/create/" class="btn btn-primary">Əlavə Et</a>
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