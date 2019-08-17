<? $banner = prepare("`image`,`url`,`category_id`","`banner`","`status`=?",["1"],"`ordering`","ASC","LIMIT 5")->fetchAll(PDO::FETCH_ASSOC);
if (!empty($banner)):?>
<div class="banner-area mt-35 hidden-xs">
    <div class="container">
        <div class="row">
            <? foreach ($banner as $k=>$ban): if ($ban['category_id']=='kicik'):?>
            <div class="col-lg-4  col-md-4 col-sm-6 hidden-xs">
                <div class="single-banner">
                    <a href="<?= $ban['url'] ?>">
                        <div style="background-image: url('uploads/banner/large/<?= $ban['image'] ?>');"></div>
                    </a>
                </div>
            </div>
            <? endif; if ($k==3){break;} endforeach; ?>
        </div>
    </div>
</div>
<? endif; ?>