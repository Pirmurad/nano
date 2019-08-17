<?PHP
ob_start();
$path='../';
include_once "{$path}config/conf.php";
include_once 'pages/html_start.php';

if (empty(session('admin') || session('admin')!='ok')){
    redirect('login');
}else{ ?>
    <div id="wrapper">

        <?PHP include 'nav.php';?>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                   <?PHP include 'main.php';?>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->
    <?PHP include 'pages/html_end.php'; }

ob_end_flush();
?>