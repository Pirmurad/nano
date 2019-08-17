<? $banner = prepare("`image`,`url`","`banner`","`category_id`=? AND `status`=?",["boyuk","1"],"`ordering`","DESC","LIMIT 2")->fetchAll(PDO::FETCH_ASSOC);
if (!empty($banner)):?>
<div class="banner-area mtb-35 hidden-xs">
    <div class="container">
        <div class="row">
            <? foreach($banner as $b): ?>
            <div class="col-lg-6  col-md-6 col-sm-6">
                <div class="single-banner">
                    <a href="<?= $b['url'] ?>">
                        <div style="background-image: url('uploads/banner/large/<?= $b['image'] ?>');"></div>
                    </a>
                </div>
            </div>
            <? endforeach; ?>
        </div>
    </div>
</div>
<? endif; ?>