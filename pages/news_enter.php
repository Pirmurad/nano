<?PHP
ob_start();
$path = "../";


include_once("{$path}top-cache.php");

include_once("{$path}config/conf.php");



$news_enter = prepare("`title`,`keyword`,`description`,`name`,`text`,`image`,`user_id`,`category_id`,`data_publish`,`view_count`,`youtube`","`news`","`id`=? AND `linkname`=? AND `status`=?  AND `data_publish`<?",[get('id'),get('linkname'),"1",time()])->fetch(PDO::FETCH_ASSOC);

$user = prepare("`name`","`user`","`id`=?",[$news_enter['user_id']])->fetch(PDO::FETCH_ASSOC);



$v_count=intval($news_enter['view_count'])+1;

update("`news`","`view_count`=?","`id`=?",[$v_count,get('id')]);



$title = $news_enter['title'];

$description = $news_enter['description'];

$keyword = $news_enter['keyword'];

$link='http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];



include_once("{$path}inc/html_start.php");

include_once("{$path}inc/header.php");

?>



    <div class="container">

        <div class="row">

            <div class="col-sm-8">

                <article class="content">

                    <div class="post-thumb hover">

                        <? if (empty($news_enter['youtube'])): ?>

                        <img src="uploads/news/large/<?= $news_enter['image'] ?>" class="img-responsive post-image" alt="<?= $news['name'] ?>">

                        <? else: ?>

                            <div class="videoWrapper">

                                <iframe width="560" height="349" src="<?= $news_enter['youtube'] ?>" frameborder="0" allowfullscreen=""></iframe>

                            </div>

                        <? endif; ?>



                        <div class="social">

                            <ul>

                                <li><a href="https://www.facebook.com/sharer/sharer.php?u=<?= $link; ?>" class="facebook" target="_blank"><i class="fa  fa-facebook"></i></a></li>

                                <li><a href="https://twitter.com/intent/tweet?url=<?= $link; ?>&text=<?= $news_enter['name'] ?>" class="twitter"><i class="fa  fa-twitter"></i></a></li>

                                <li><a href="https://plus.google.com/share?url=<?= $link; ?>" class="google"><i class="fa  fa-google-plus"></i></a></li>

                                <li><a href="https://api.whatsapp.com/send?text=<?= $news_enter['name'] ?> - <?= $link; ?>" class="instagram" target="_blank"><i class="fa  fa-whatsapp"></i></a></li>

                            </ul>

                        </div>

                        <!-- /.social icon -->

                    </div>

                    <h1><?= $news_enter['name'] ?></h1>

                    <div class="date">

                        <ul>

                            <li>Yazar: <a title="" href="javscript:void();"><span><?=$user['name'];?></span></a> --</li>

                            <li><a title="<?=date("d M Y",$news_enter['data_publish'])?>" href="tarix/<?=date("d",$news_enter['data_publish'])?>/<?=date("m",$news_enter['data_publish'])?>/<?=date("Y",$news_enter['data_publish'])?>/"><?=date("d M Y",$news_enter['data_publish'])?></a> --</li>

                            <li>Baxış sayı : <?=$news_enter['view_count'];?></li>

                        </ul>

                    </div>

                    <p><?=htmlspecialchars_decode($news_enter['text']);?></p>

                    <!-- gallery-->



                    <div class="newsgallery">

                        <?

                        $gallery = prepare("`image`","`gallery`","`news_id`=?",[get('id')]);

                        while ($gal = fetch($gallery)){?>

                            <div class="col-md-4 col-xs-4 mb10">

                                <a href="uploads/gallery/large/<?= $gal['image'] ?>"  data-rel="lightcase:myCollection:slideshow" class="showcase" title="<?= $news_enter['name'] ?>">

                                    <img src="uploads/gallery/medium/<?= $gal['image'] ?>" alt="<?= $news_enter['name'] ?>" style="width: 100%;">

                                </a>

                            </div>

                        <? } ?>

                    </div>



                    <!-- tags -->

                    <div class="tags">

                        <ul>

                            <? foreach(explode(",",$news_enter['keyword']) as $tag):?>

                            <li> <a href="pages/search.php?searchtext=<?=$tag;?>"><?=$tag;?></a></li>

                            <? endforeach;?>

                        </ul>

                    </div>

                    <!-- form

                        ============================================ -->

                    <div class="form-area">

                        <h3 class="category-headding ">Rəylər</h3>

                        <div class="headding-border"></div>

                        <div class="row">

                            <div class="col-md-12">

                                <div class="fb-comments" data-href="<?='http://'.$_SERVER['HTTP_HOST'].'/'.$_SERVER['REQUEST_URI'];?>" data-width="100%"></div>

                            </div>

                        </div>

                    </div>

                    <!-- Related news area

                        ============================================ -->

                    <? $othernews = prepare("`name`,`id`,`linkname`,`data_publish`,`view_count`,`category_id`,`image`","`news`","`id`!=? AND `category_id`=? AND `youtube`=? AND `status`=? AND `data_publish`<?",[get('id'),$news_enter['category_id'],"","1",time()],"`ordering`","DESC","LIMIT 3")->fetchAll(PDO::FETCH_ASSOC);

                    if (!empty($othernews)):?>

                    <div class="related-news-inner">

                        <h3 class="category-headding ">Təklif olunan xəbərlər</h3>

                        <div class="headding-border"></div>

                        <div class="row">

                            <div id="content-slide-5" class="owl-carousel owl-theme">

                                <!-- item-1 -->

                                    <div class="owl-wrapper">

                                        <div class="owl-item">

                                            <div class="item">

                                                <div class="row rn_block">

                                                    <? foreach ($othernews as $other): $cat = prepare("`id`,`linkname`,`name`","`category`","`id`=?",[$other['category_id']])->fetch(PDO::FETCH_ASSOC);?>

                                                    <div class="col-xs-12 col-md-4 col-sm-4 padd">

                                                        <div class="post-wrapper wow fadeIn" data-wow-duration="2s">

                                                            <!-- image -->

                                                            <div class="post-thumb">

                                                                <a href="xeber/<?= $other['id'] ?>/<?= $other['linkname'] ?>.html">

                                                                    <img class="img-responsive"

                                                                         src="uploads/news/medium/<?= $other['image'] ?>" alt="<?= $other['name'] ?>">

                                                                </a>

                                                            </div>

                                                            <div class="post-info meta-info-rn">

                                                                <div class="slide">

                                                                    <a target="_blank" href="kateqoriya/<?= $cat['id'] ?>/<?= $cat['linkname'] ?>/"

                                                                   class="post-badge btn_<?= $cat['id'] ?>"><?= substr($cat['name'],0,1) ?></a>

                                                                </div>

                                                            </div>

                                                        </div>

                                                        <div class="post-title-author-details">

                                                            <h4><a href="xeber/<?= $other['id'] ?>/<?= $other['linkname'] ?>.html"><?= $other['name'] ?></a></h4>

                                                            <div class="post-editor-date">

                                                                <div class="post-date">

                                                                    <i class="pe-7s-clock"></i> <?= date("d M Y",$other['data_publish']); ?>

                                                                </div>

                                                                <div class="post-author-comment"><i

                                                                            class="pe-7s-display2"></i><?= $other['view_count'] ?>

                                                                </div>

                                                            </div>

                                                        </div>

                                                    </div>

                                                    <? endforeach; ?>

                                                </div>

                                            </div>

                                        </div>

                                    </div>





                            </div>

                        </div>

                    </div>

                    <? endif; ?>



                </article>

            </div>

            <div class="col-sm-4 left-padding">

                <aside class="sidebar">

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

                    <div class="banner-add">

                        <!-- add -->

                        <span class="add-title">- Reklam -</span>

                        <?

                        foreach ($ads as $a): if ($a['type']=='250x250 [index-top-right]'):?>

                            <a href="<?= (!empty($a)) ? $a['url'] : 'javscript:void();' ?>"><img class="center-block img-responsive" src="uploads/ads/large/<?= $a['image'] ?>" alt="<?= $a['name'] ?>"></a>

                        <? endif; endforeach; ?>

                    </div>

                    <div class="tab-inner">

                        <ul class="tabs active">

                            <li class="current"><a href="#">Xəbər Lenti</a></li>

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

                                    <? $view++;if ($view==7) {

                                    	$view=1;

                                    } } ?>

                            </div>

                        </div>

                        <!-- / tab_content -->

                    </div>

                    <!-- / tab -->

                </aside>

            </div>

        </div>

    </div>



<?

include_once("{$path}inc/bottommenu.php");

include_once("{$path}inc/footer.php");

include_once("{$path}inc/html_end.php");

include_once("{$path}bottom-cache.php");



$out = ob_get_clean();

$out = preg_replace('/(?![^<]*<\/pre>)[\n\r\t]+/', "\n", $out);

$out = preg_replace('/ {2,}/', ' ', $out);

$out = preg_replace('/>[\n]+/', '>', $out);

echo $out;

?>