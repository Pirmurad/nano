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


    if ($_SERVER['REQUEST_METHOD'] === 'POST'){
        if(!empty($_POST['check_list'])) {
            foreach($_POST['check_list'] as $check) {
                if(isset($_POST['delete'])) {
                    delete("`subscribeme`","`id`=?",[$check]);
                }
            }
        }
        if (!empty(post('searchtext'))){
            $where = "`mail` LIKE ?";
            $execute = ["%".post('searchtext')."%"];
        }else{
            $where = "`id`>?";
            $execute = ["0"];
        }

        if (empty(post('rowsize'))){$rowsize = "10";}else{$rowsize = post('rowsize');}
        if (isset($_GET["pagination"])) {$page = intval($_GET["pagination"]);} else {$page = 1;};
        $start_from = ($page > 1) ? ($page * $rowsize) - $rowsize : 0;
        $pagination = pagination($rowsize,$page,"2","subscribeme","`id`>?",['0'],"subscribeme");

        $subscribemefetch = prepare("*","`subscribeme`",$where,$execute,"`datepicker`","DESC","LIMIT $start_from,$rowsize");
    }else{

        if (isset($_GET["pagination"])) {$page = intval($_GET["pagination"]);} else {$page = 1;}
        $perpage = 10;
        $start_from = ($page > 1) ? ($page * $perpage) - $perpage : 0;
        $pagination = pagination($perpage,$page,"2","subscribeme","`id`>?",['0'],"subscribeme");

        $subscribemefetch = select("*","`subscribeme`","`datepicker`","DESC","LIMIT $start_from,$perpage");
    }
?>
<h1 class="page-header">Abunələr</h1>

        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th><input type="checkbox" id="checkAll"></th>
                    <th>Id</th>
                    <th>E-mail</th>
                    <th>Tarix</th>
                </tr>
            </thead>
            <tbody>
            <form action="" method="POST">
            <?PHP
            while($subscribeme = fetch($subscribemefetch)){

                echo  '<tr class="Delete'.$subscribeme['id'].'">'
                        . '<td>
                              <input type="checkbox" id="checkItem" name="check_list[]" value="'.$subscribeme['id'].'">
                           </td>'
                        . '<td>'.$subscribeme['id'].'</td>';
                echo '<td>'.$subscribeme['mail'].'</td>';
                echo '<td>'.date("d-m-Y H:i:s",$subscribeme['datepicker']).'</td>';
                echo
                        '<td>'
                        .'<a class="delete-item" onclick="$.deleteAjax($(this))" data-id="'.$subscribeme['id'].'" data-value="subscribeme" data-url="'.URL.'"><span class="glyphicon glyphicon-remove fr red"></span></a>'
                        . '</td>'
                        . '</tr>';
            }
            ?>
	            <div class="row">
		            <div class="mb10">
			            <div class="col-md-4">
				            <button type="submit" name="delete" class="btn btn-danger">Sil</button>
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