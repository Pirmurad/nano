<?PHP
$countcategory      = fetchColumn("COUNT(id)","`category`");
$countmenyu         = fetchColumn("COUNT(id)","`menyu`");
$countbanner        = fetchColumn("COUNT(id)","`banner`");
$countslider        = fetchColumn("COUNT(id)","`slider`");
$countnews          = fetchColumn("COUNT(id)","`news`");
$countsponsor       = fetchColumn("COUNT(id)","`sponsor`");
$countsubscribeme   = fetchColumn("COUNT(id)","`subscribeme`");
$countproduct       = fetchColumn("COUNT(id)","`product`");
$countnews          = fetchColumn("COUNT(id)","`news`");

?>

<div class="container mt40">
    <div class="row">
        <? if (session('role')=='admin'): ?>
        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
            <a href="category/list/">
            <div class="panel panel-primary">

                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-bars fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge"><?= $countcategory;?></div>
                            <div class="fs18">Kateqoriya</div>
                        </div>
                    </div>
                </div>
                <div class="panel-footer">
                    <span class="pull-left">Məlumatlara bax</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </div>
            </a>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
            <a href="menyu/list/">
            <div class="panel panel-cc">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-database fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge"><?=$countmenyu;?></div>
                            <div class="fs18">Menyu</div>
                        </div>
                    </div>
                </div>
                <div class="panel-footer">
                    <span class="pull-left">Məlumatlara bax</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </div>
            </a>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
            <a href="news/list/">
                <div class="panel panel-sienna">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-newspaper-o fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="huge"><?=$countnews;?></div>
                                <div class="fs18">Məqalələr</div>
                            </div>
                        </div>
                    </div>
                    <div class="panel-footer">
                        <span class="pull-left">Məlumatlara bax</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </a>
        </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                <a href="subscribeme/list/">
                    <div class="panel panel-green">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-bookmark fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?=$countsubscribeme;?></div>
                                    <div class="fs18">Abunə</div>
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer">
                            <span class="pull-left">Məlumatlara bax</span>
                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                <a href="sponsor/list/">
                    <div class="panel panel-palid">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-spoon fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?=$countsponsor;?></div>
                                    <div class="fs18">Sponsor</div>
                                </div>
                            </div>
                        </div>

                        <div class="panel-footer">
                            <span class="pull-left">Məlumatlara bax</span>
                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                            <div class="clearfix"></div>
                        </div>

                    </div>
                </a>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                <a href="product/list/">
                    <div class="panel panel-green">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-barcode fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?=$countproduct;?></div>
                                    <div class="fs18">Məhsullar</div>
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer">
                            <span class="pull-left">Məlumatlara bax</span>
                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </a>
            </div>
        <? endif; ?>
        <? if (session('role')=='admin' || session('role')=='editor'): ?>
        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
            <a href="slider/list/">
                <div class="panel panel-red">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-sliders fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="huge"><?=$countslider;?></div>
                                <div class="fs18">Slider</div>
                            </div>
                        </div>
                    </div>
                    <div class="panel-footer">
                        <span class="pull-left">Məlumatlara bax</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
            <a href="banner/list/">
                <div class="panel panel-sienna">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-picture-o fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="huge"><?=$countbanner;?></div>
                                <div class="fs18">Banner</div>
                            </div>
                        </div>
                    </div>
                    <div class="panel-footer">
                        <span class="pull-left">Məlumatlara bax</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </a>
        </div>
        <? endif; ?>
    </div>
</div>