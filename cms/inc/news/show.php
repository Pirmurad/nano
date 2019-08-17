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
                $news = prepare("*","`news`","`id`=?",[get('id')])->fetch(PDO::FETCH_ASSOC);
                ?>
	            <h1 class="page-header"><b><?=$news['name']?></b> məqaləsi</h1>
	            <a type="button" href="news/edit/<?=$news['id'];?>/" class="btn btn-success">Düzəliş Et</a>
	            <a type="button" href="news/delete/<?=$news['id'];?>/" class="btn btn-danger">Sil</a>
	            <hr>
<div class="row">
    <div class="col-lg-12">
        <?PHP
        if (!empty($news['image'])) {
            echo "<div class='col-md-offset-4'><img src='../uploads/news/large/{$news['image']}' style='margin: 15px;'/></div>";
        }
        ?>
        <table class="table table-bordered table-hover text-center">
	        <tr>
                <td>Adı</td>
                <td><?=$news['name']?></td>
            </tr>
	        <tr>
		        <td>Başlıq</td>
		        <td><?=$news['title']?></td>
	        </tr>
	        <tr>
		        <td>Açar sözlər</td>
		        <td><?=$news['keyword']?></td>
	        </tr>
	        <tr>
		        <td>Elanın təsviri</td>
		        <td><?=$news['description']?></td>
	        </tr>
	        <tr>
		        <td>Qısa mətn</td>
		        <td><?=$news['short_text']?></td>
	        </tr>
            <tr>
                <td>Link</td>
                <td><a href="/<?= $basehref.'meqaleler/'.$news['id'].'/'.$news['linkname']?>.html" target="_blank"><?=$news['linkname']?></a></td>
            </tr>
            <tr>
                <td>Baxış sayı</td>
                <td><?=$news['view_count']?></td>
            </tr>
            <tr>
                <td>Mətn</td>
                <td><?=htmlspecialchars_decode($news['text'])?></td>
            </tr>
            <tr>
                <td>Status</td>
                <td>
                <?PHP
                if($news['status']==1){
                    echo '<span class="green glyphicon glyphicon-eye-open"></span>';
                }else{
                    echo '<span class="red glyphicon glyphicon-eye-close"></span>';
                }
                ?>
                </td>
            </tr>
            <tr>
                <td>Yaradılma vaxtı</td>
                <td><?= date("d.m.Y H:i:s",$news['data_create']);?></td>
            </tr>
	        <tr>
		        <td>Dəyişilmə vaxtı</td>
		        <td><?= date("d.m.Y H:i:s",$news['data_update']);?></td>
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