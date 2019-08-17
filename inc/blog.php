<? $news = prepare("`name`,`id`,`linkname`,`data_create`,`description`,`image`","`news`","`status`=?",["1"],"`ordering`","DESC","LIMIT 9")->fetchAll(PDO::FETCH_ASSOC);
if (!empty($news)):?>
<div class="blog-test-area mt-35">
    <div class="container">
        <div class="row">
            <!-- blog-area start -->
            <div class="col-lg-12">
                <div class="blog-area box-shadow bg-fff mb-35 br20">
                    <div class="product-title home2-bg-1 text-uppercase home2-product-title br12">
                        <div class="icon bg-1 br1"><i class="fab fa-blogger-b"></i></div>
                        <h3>Məqalələr</h3>
                    </div>
                    <div class="home2-blog-active home2 left-right-angle">
                        <? foreach ($news as $n): ?>
                        <div class="blog-wrapper">
                            <div class="blog-img mb-10">
                                <a href="xeber/<?= $n['id'] ?>/<?= $n['linkname'] ?>.html">
                                    <div class="bloghover"><i class="far fa-image"></i></div>
                                    <div style="background-image: url('uploads/news/medium/<?= $n['image'] ?>')" class="blogimg"></div>
                                </a>
                            </div>
                            <div class="blog-content">
                                <h3><a href="xeber/<?= $n['id'] ?>/<?= $n['linkname'] ?>.html"><?= $n['name'] ?></a></h3>
                                <div class="blog-meta">
                                    <span><?= date("d M Y",$n['data_create']); ?></span>
                                </div>
                                <p><?= $n['description'] ?></p>
                            </div>
                        </div>
                        <? endforeach; ?>
                    </div>
                </div>
            </div>
            <!-- blog-area end -->
        </div>
    </div>
</div>
<? endif; ?>