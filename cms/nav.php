<?PHP
$actual_link = "http://{$_SERVER['HTTP_HOST']}/{$basehref}";
define("URL",$actual_link);

if (session('admin')!='ok' || empty(session('role'))){
    redirect('login');
}
?>
<!-- Navigation -->
<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="index.php">Admin Panel</a><a class="btn btn-info mt8" target="_blank" href="<?=$actual_link;?>"><i class="fa fa-external-link fa-fw" aria-hidden="true"></i>Sayta keçid</a>
    </div>
    <!-- /.navbar-header -->

    <ul class="nav navbar-top-links navbar-right">
        <!-- /.dropdown -->
        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
            </a>
            <ul class="dropdown-menu dropdown-user">
                <li><a href="logout.php"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                </li>
            </ul>
            <!-- /.dropdown-user -->
        </li>
        <!-- /.dropdown -->
    </ul>
    <!-- /.navbar-top-links -->

    <div class="navbar-default sidebar" role="navigation">
        <div class="sidebar-nav navbar-collapse">
            <ul class="nav" id="side-menu">
                <li>
                    <a href="index.php"><i class="fa fa-dashboard fa-fw"></i> Ana Səhifə</a>
                </li>
                <? if (session('role')=='admin'): ?>
                <li>
                    <a href="menyu/list/"><i class="fa fa-bars fa-fw"></i>Menyu</a>
                </li>
                <li>
                    <a href="category/list/"><i class="fa fa-bars fa-fw"></i>Kateqoriya</a>
                </li>
                <li>
		            <a href="brand/list/"><i class="fa fa-picture-o fa-fw"></i>Brend</a>
	            </li>
                <li>
		            <a href="product/list/"><i class="fa fa-barcode fa-fw"></i>Məhsullar</a>
	            </li>
                <li>
                    <a href="kredit/list/"><i class="fa fa-credit-card fa-fw"></i>Kredit</a>
                </li>
                <li>
		            <a href="news/list/"><i class="fa fa-newspaper-o fa-fw"></i>Məqalələr</a>
	            </li>
                <li>
		            <a href="type/list/"><i class="fa fa-tags fa-fw"></i>Məhsul Tipləri</a>
	            </li>
                <li>
		            <a href="sponsor/list/"><i class="fa fa-spoon fa-fw"></i>Sponsor</a>
	            </li>
                <li>
                    <a href="subscribeme/list/"><i class="fa fa-bookmark fa-fw"></i>Abunə</a>
                </li>
                <li>
                    <a href="info/"><i class="fa fa-wrench fa-fw" aria-hidden="true"></i>Saytın Məlumatları</a>
                </li>
                <? endif; if(session('role')=='editor' || session('role')=='admin'): ?>
                <li>
                    <a href="slider/list/"><i class="fa fa-sliders fa-fw"></i>Slider</a>
                </li>
                <li>
                    <a href="banner/list/"><i class="fa fa-picture-o fa-fw"></i>Banner</a>
                </li>
                <? endif; ?>
            </ul>
        </div>
        <!-- /.sidebar-collapse -->
    </div>
    <!-- /.navbar-static-side -->
</nav>