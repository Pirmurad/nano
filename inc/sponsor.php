<? $sponsor = prepare("`image`,`link`","`sponsor`","`status`=?",["1"])->fetchAll(PDO::FETCH_ASSOC);
if (!empty($sponsor)):?>
<div class="brand-area mb-35">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="brand-active  box-shadow p-15 bg-fff br20">
                    <? foreach ($sponsor as $s): ?>
                    <div class="single-brand">
                        <a href="<?= $s['link'] ?>">
                            <div style="background-image: url('uploads/sponsor/large/<?= $s['image'] ?>')"></div>
                        </a>
                    </div>
                    <? endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<? endif; ?>