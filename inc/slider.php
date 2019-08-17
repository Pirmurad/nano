<? $slider = prepare("`id`,`image`,`image_name`,`url`","`slider`","`status`=?",["1"])->fetchAll(PDO::FETCH_ASSOC);
if (!empty($slider)):?>
<div class="sloder-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div id="slider-active">
                    <? foreach ($slider as $s): ?>
                    <img src="uploads/slider/large/<?= $s['image'] ?>" alt="<?= $s['image_name'] ?>" title="#active<?= $s['id'] ?>"/>
                    <? endforeach; ?>
                </div>
                <? foreach ($slider as $s): ?>
                <!-- <div id="active<?= $s['id'] ?>" class="nivo-html-caption">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-10 col-md-offset-2 col-sm-11 col-sm-offset-1 hidden-xs ">
                                <div class="slide1-text home2-slide1-text text-left">
                                    <div class="middle-text">
                                        <div class="cap-readmore animated">
                                            <a href="<?= $s['url'] ?>">Məhsula Keç</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="slider-progress"></div>
                </div> -->
                <? endforeach; ?>
            </div>
        </div>
    </div>
</div>
<? endif; ?>