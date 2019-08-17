<? $videonews = prepare("`name`,`id`,`linkname`,`image`,`youtube`,`data_publish`,`user_id`","`news`","`youtube`<>? AND `status`=? AND `data_publish`<?",["","1",time()])->fetchAll(PDO::FETCH_ASSOC);
if (!empty($videonews)):?>
<section class="video-post-inner">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="category-headding ">VIDEO Xəbərlər</h3>
                <div class="headding-border"></div>
            </div>
            <? foreach ($videonews as $video): $user = prepare("`name`","`user`","`id`=?",[$video['user_id']])->fetch(PDO::FETCH_ASSOC); ?>
            <div class="col-sm-4">
                <div class="post-style1">
                    <div class="post-wrapper wow fadeIn" data-wow-duration="1s">
                        <iframe src="<?= $video['youtube'] ?>" width="100%" height="196px" frameborder="0"></iframe>
                    </div>
                    <!-- post title -->
                    <h3><a href="xeber/<?= $video['id'] ?>/<?= $video['linkname'] ?>.html"><?= $video['name'] ?></a></h3>
                    <div class="post-title-author-details">
                        <div class="date">
                            <ul>
                                <li><img src="<?= $video['image'] ?>" class="img-responsive" alt="<?= $video['name'] ?>"></li>
                                <li>Yazar: <a title="<?= $user['name'] ?>" href="javascript:void();"><span><?= $user['name'] ?></span></a> --</li>
                                <li><a title="<?= date("d M Y",$video['data_publish']) ?>" href="tarix/<?= date("d",$video['data_publish']) ?>/<?= date("m",$video['data_publish']) ?>/<?= date("Y",$video['data_publish']) ?>/"><?= date("d M Y",$video['data_publish']) ?></a> --</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <? endforeach; ?>
        </div>
    </div>
</section>
<? endif; ?>