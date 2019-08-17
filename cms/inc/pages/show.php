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
                $pages = prepare("*","`pages`","`id`=?",[get('id')]);
                $pages = $pages[0];

                ?>
	            <h1 class="page-header"><b><?=$pages['name_az']?></b> səhifəsi</h1>
	            <a type="button" href="pages/edit/<?=$pages['id'];?>/" class="btn btn-success">Düzəliş Et</a>
	            <a type="button" href="pages/delete/<?=$pages['id'];?>/" class="btn btn-danger">Sil</a>
	            <hr>
<div class="row">
    <div class="col-lg-12">
        <table class="table table-bordered table-hover text-center">

	        <tr>
                <td>Adı [az]</td>
                <td><?=$pages['name_az']?></td>
            </tr>
	        <tr>
		        <td>Adı [ru]</td>
		        <td><?=$pages['name_ru']?></td>
	        </tr>
	        <tr>
		        <td>Başlıq [az]</td>
		        <td><?=$pages['title_az']?></td>
	        </tr>
	        <tr>
		        <td>Başlıq [ru]</td>
		        <td><?=$pages['title_ru']?></td>
	        </tr>
	        <tr>
		        <td>Açar sözlər [az]</td>
		        <td><?=$pages['keyword_az']?></td>
	        </tr>
	        <tr>
		        <td>Açar sözlər [ru]</td>
		        <td><?=$pages['keyword_ru']?></td>
	        </tr>
	        <tr>
		        <td>Elanın təsviri [az]</td>
		        <td><?=$pages['description_az']?></td>
	        </tr>
	        <tr>
		        <td>Elanın təsviri [ru]</td>
		        <td><?=$pages['description_ru']?></td>
	        </tr>
            <tr>
                <td>Link</td>
                <td><a href="/pages/<?=$pages['linkname']?>/" target="_blank"><?=$pages['linkname']?></a></td>
            </tr>
            <tr>
                <td>Mətn [az]</td>
                <td><?=htmlspecialchars_decode($pages['text_az'])?></td>
            </tr>
	        <tr>
		        <td>Mətn [ru]</td>
		        <td><?=htmlspecialchars_decode($pages['text_ru'])?></td>
	        </tr>
            <tr>
                <td>Status</td>
                <td>
                <?PHP
                if($pages['status']==1){
                    echo '<span class="green glyphicon glyphicon-eye-open"></span>';
                }else{
                    echo '<span class="red glyphicon glyphicon-eye-close"></span>';
                }
                ?>
                </td>
            </tr>
            <tr>
                <td>Yaradılma vaxtı</td>
                <td><?= date("d.m.Y H:i:s",$pages['data_create']);?></td>
            </tr>
	        <tr>
		        <td>Dəyişilmə vaxtı</td>
		        <td><?= date("d.m.Y H:i:s",$pages['data_update']);?></td>
	        </tr>
        </table>
    </div>
    <!-- /.col-lg-12 -->
</div>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /#page-wrapper -->

</div>
    <!-- /#wrapper -->
<?PHP include '../../pages/html_end.php';
ob_end_flush();
?>