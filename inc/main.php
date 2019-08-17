<div class="container">

    <div class="row">

        <div class="col-md-8 col-sm-8">

            <!-- left content inner -->

            <section class="recent_news_inner">

                <h3 class="category-headding ">Son Xəbərlər</h3>

                <div class="headding-border"></div>

                <div class="row">

                    <div id="content-slide" class="owl-carousel">

                        <? foreach ($news as $n):

                            $category = prepare("`name`,`id`,`linkname`","`category`","`id`=?",[$n['category_id']])->fetch(PDO::FETCH_ASSOC);

                            $user = prepare("`name`","`user`","`id`=?",[$n['user_id']])->fetch(PDO::FETCH_ASSOC);?>

                        <div class="item home2-post">

                            <div class="post-wrapper wow fadeIn" data-wow-duration="1s">

                                <!-- image -->

                                <div class="post-thumb">

                                    <a href="xeber/<?= $n['id'] ?>/<?= $n['linkname'] ?>.html">

                                        <img class="img-responsive" src="uploads/news/large/<?= $n['image'] ?>" alt="<?= $n['name'] ?>">

                                    </a>

                                </div>

                                <div class="post-info meta-info-rn">

                                    <div class="slide">

                                        <a target="_blank" href="kateqoriya/<?= $category['id'] ?>/<?= $category['linkname'] ?>/" class="post-badge btn_<?= $category['id'] ?>"><?= mb_substr($category['name'], 0, 1, 'utf-8') ?></a>

                                    </div>

                                </div>

                            </div>

                            <h3><a href="xeber/<?= $n['id'] ?>/<?= $n['linkname'] ?>.html"><?= $n['name'] ?></a></h3>

                            <div class="post-title-author-details">

                                <div class="date">

                                    <ul>

                                        <li>Yazar: <a title="<?= $user['name'] ?>" href="javascript:void();"><span><?= $user['name'] ?></span></a></li>

                                        <li>  --<a title="<?= date("d M Y",$n['data_publish']) ?>" href="tarix/<?= date("d",$n['data_publish']) ?>/<?= date("m",$n['data_publish']) ?>/<?= date("Y",$n['data_publish']) ?>/"><?= date("d M Y",$n['data_publish']) ?></a>-- </li>

                                    </ul>

                                </div>

                                <p><?= $n['description'] ?><a href="xeber/<?= $n['id'] ?>/<?= $n['linkname'] ?>.html">Ardını oxu...</a></p>

                            </div>

                        </div>

                        <? endforeach; ?>

                    </div>

                </div>

            </section>

            <!-- Politics Area

                ============================================ -->

            <section class="politics_wrapper">

                <h3 class="category-headding ">FTV XƏBƏR</h3>

                <div class="headding-border"></div>

                <div class="row">

                    <div id="content-slide-2" class="owl-carousel">

                        <!-- item-1 -->

                        <div class="item">

                            <div class="row">

                                <!-- main post -->

                                <div class="col-sm-6 col-md-6">

                                    <? $a=0; foreach ($news as $n): if ($n['category_id']==1): $user = prepare("`name`","`user`","`id`=?",[$n['user_id']])->fetch(PDO::FETCH_ASSOC); ?>

                                    <div class="home2-post">

                                        <div class="post-wrapper wow fadeIn" data-wow-duration="1s">

                                            <!-- post image -->

                                            <div class="post-thumb">

                                                <a href="xeber/<?= $n['id'] ?>/<?= $n['linkname'] ?>.html">

                                                    <img src="uploads/news/large/<?= $n['image'] ?>" class="img-responsive" alt="<?= $n['name'] ?>">

                                                </a>

                                            </div>

                                            <!-- post title -->

                                            <h3><a href="xeber/<?= $n['id'] ?>/<?= $n['linkname'] ?>.html"><?= $n['name'] ?></a></h3>

                                        </div>

                                        <div class="post-title-author-details">

                                            <div class="date">

                                                <ul>

                                                    <li>Yazar: <a title="<?= $user['name'] ?>" href="javascript:void();"><span><?= $user['name'] ?></span></a> --</li>

                                                    <li><a title="<?= date("d M Y",$n['data_publish']) ?>" href="tarix/<?= date("d",$n['data_publish']) ?>/<?= date("m",$n['data_publish']) ?>/<?= date("Y",$n['data_publish']) ?>/"><?= date("d M Y",$n['data_publish']) ?></a> --</li>

                                                </ul>

                                            </div>

                                            <p><?= $n['description'] ?><a href="xeber/<?= $n['id'] ?>/<?= $n['linkname'] ?>.html">Ardını oxu...</a></p>

                                        </div>

                                    </div>

                                    <? $a++;if ($a==1){break;} endif;endforeach; ?>

                                </div>

                                <!-- right side post -->

                                <div class="col-sm-6 col-md-6">

                                    <div class="row rn_block">

                                        <? foreach ($news as $n): if ($n['category_id']==1): $user = prepare("`name`","`user`","`id`=?",[$n['user_id']])->fetch(PDO::FETCH_ASSOC);$a++; if ($a==2){continue;}?>

                                        <div class="col-xs-6 col-md-6 col-sm-6 post-padding">

                                            <div class="home2-post">

                                                <!-- post image -->

                                                <div class="post-thumb wow fadeIn" data-wow-duration="1s" data-wow-delay="0.2s">

                                                    <a href="xeber/<?= $n['id'] ?>/<?= $n['linkname'] ?>.html">

                                                        <img src="uploads/news/medium/<?= $n['image'] ?>" class="img-responsive" alt="<?= $n['name'] ?>">

                                                    </a>

                                                </div>

                                                <div class="post-title-author-details">

                                                    <!-- post image -->

                                                    <h5><a href="xeber/<?= $n['id'] ?>/<?= $n['linkname'] ?>.html"><?= $n['name'] ?></a></h5>

                                                    <div class="date">

                                                        <ul>

                                                            <li><a title="<?= $user['name'] ?>" href="javascript:void();"><span><?= $user['name'] ?></span></a> --</li>

                                                            <li><a title="<?= date("d M Y",$n['data_publish']) ?>" href="tarix/<?= date("d",$n['data_publish']) ?>/<?= date("m",$n['data_publish']) ?>/<?= date("Y",$n['data_publish']) ?>/"><?= date("d M Y",$n['data_publish']) ?></a></li>

                                                        </ul>

                                                    </div>

                                                </div>

                                            </div>

                                        </div>

                                        <? endif;if ($a==6){break;} endforeach; ?>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

                <!-- /.row -->

            </section>

            <!-- /.Politics -->

            <div class="ads">

                <? foreach ($ads as $a): if ($a['type']=='728x90 [index-bottom-left]'):?>

                    <a href="<?= (!empty($a)) ? $a['url'] : 'javscript:void();' ?>"><img class="img-responsive center-block" src="uploads/ads/large/<?= $a['image'] ?>" alt="<?= $a['name'] ?>"></a>

                <? endif; endforeach; ?>

            </div>

        </div>

        <!-- /.left content inner -->

        <div class="col-md-4 col-sm-4 left-padding">

            <!-- right content wrapper -->

            <form action="pages/search.php" method="get">

            <div class="input-group search-area">

                <!-- search area -->

                <input type="text" class="form-control" placeholder="Axtarış..." name="searchtext">

                <div class="input-group-btn">

                    <button class="btn btn-search" type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>

                </div>

            </div>

            </form>

            <!-- /.search area -->

            <!-- social icon -->

            <h3 class="category-headding ">SOSİAL ŞƏBƏKƏDƏ BİZ</h3>

            <div class="headding-border"></div>

            <div class="social">

                <ul>

                    <? if (!empty($information['facebook'])): ?>

                        <li><a href="<?= $information['facebook'] ?>" class="facebook"><i class="fa  fa-facebook"></i></a></li>

                    <? endif;

                    if (!empty($information['twitter'])): ?>

                        <li><a href="<?= $information['twitter'] ?>" class="twitter"><i class="fa  fa-twitter"></i></a></li>

                    <? endif;

                    if (!empty($information['google'])): ?>

                        <li><a href="<?= $information['google'] ?>" class="google"><i class="fa  fa-google-plus"></i></a></li>

                    <? endif;

                    if (!empty($information['instagram'])): ?>

                        <li><a href="<?= $information['instagram'] ?>" class="instagram"><i class="fa  fa-instagram"></i></a></li>

                    <? endif; ?>

                </ul>

            </div>

            <!-- /.social icon -->

            <div class="banner-add">

                <!-- add -->

                <span class="add-title">- Reklam -</span>

                <? foreach ($ads as $a): if ($a['type']=='250x250 [index-top-right]'):?>

                    <a href="<?= (!empty($a)) ? $a['url'] : 'javscript:void();' ?>"><img class="center-block img-responsive" src="uploads/ads/large/<?= $a['image'] ?>" alt="<?= $a['name'] ?>"></a>

                <? endif; endforeach; ?>

            </div>

            <div class="tab-inner">

                <ul class="tabs">

                    <li><a href="#">Xəbər Lenti</a></li>

                </ul>

                <hr>

                <!-- tabs -->

                <div class="tab_content">

                    <div class="tab-item-inner">

                        <? $view=1;

                            foreach ($news as $n) {

                            $cat = prepare("`id`,`linkname`,`name`","`category`","`id`=?",[$n['category_id']])->fetch(PDO::FETCH_ASSOC);

                        ?>

                        <div class="box-item wow fadeIn" data-wow-duration="1s" <? ($view!=1) ? 'data-wow-delay="0.'.$view.'s"' : '' ?>>

                            <div class="item-details">

                                <h6 class="sub-category-title bg-color-<?= $view ?>">

                                    <a href="kateqoriya/<?= $cat['id'] ?>/<?= $cat['linkname'] ?>/"><?= $cat['name'] ?></a>

                                </h6>

                                <h3 class="td-module-title"><a href="xeber/<?= $n['id'] ?>/<?= $n['linkname'] ?>.html"><?= $n['name'] ?></a></h3>

                                <div class="post-editor-date">

                                    <!-- post date -->

                                    <div class="post-date">

                                        <i class="pe-7s-clock"></i> <?= date("d M Y",$n['data_publish']) ?>

                                    </div>

                                </div>

                            </div>

                        </div>

                        <? $view++;if ($view==6) {

                           $view=1;

                        } } ?>

                    </div>

                </div>

            </div>

        </div>

        <!-- side content end -->

    </div>

    <!-- row end -->

</div>