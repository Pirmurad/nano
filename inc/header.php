<?PHP $information = prepare("*", "`information`", "`id`=?", ["1"])->fetch(PDO::FETCH_ASSOC); ?>
<link rel="stylesheet" type="text/css" href="../css/component.css" />
<script src="../js/modernizr.custom.js"></script>
<header>
    <div class="header-top-area ptb-20">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-6 vr">
                    <div class="home2-logo">
                        <a href="/">
                            <img src="img/logo/1.png" alt="Nano Electronics" title="Nano Electronics" />
                        </a>
                    </div>
                </div>
                <div class="col-lg-7 col-md-4 col-sm-4 col-xs-12 hidden-xs center-block">
                    <form action="pages/search.php" method="get">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Axtarış" name="search" id="search">
                            <div class="input-group-btn">
                                <button class="btn btn-default"><i class="fas fa-search"></i></button>
                            </div>
                        </div>
                    </form>
                    <div class="autocomplete autocomplete-search autocomplete-small autocomplete-hide">
                        <div class="search-results" id="search-results"></div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                    <a href="https://api.whatsapp.com/send?phone=994<?= substr($information['phone'], 1); ?>" class="search-img">
                        <img src="../img/phone.png" alt="call"><?= $information['phone'] ?>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="header-bottom">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 hidden-md  col-sm-12 hidden-xs ">
                    <div class="categories-menu bg-7 text-uppercase <?= (get('linkname')!='ana-sehife') ? 'click' : '' ?> br1">
                        <i class="fas fa-bars"></i>
                        <span>Bütün Kateqoriyalar</span>
                    </div>
                    <div class="menu-container toggole br4" <?= (get('linkname')=='ana-sehife') ? 'style="display: block;"' : '' ?> >
                        <ul>
                            <?= multilevelCat("`category`",0,get('linkname'),0); ?>
                        </ul>

                    </div>
                </div>
                <div class="col-lg-9 col-md-12 hidden-xs hidden-sm ">
                    <div class="mainmenu hover-bg dropdown bg-1 br2">
                        <nav>
                            <ul>
                                <?= multilevelOrtaMenu("menyu","orta",0,get('linkname'),0) ?>
                            </ul>
                        </nav>
                    </div>
                    <div class="child-menu">
                        <ul class="megamenu-2 box-shadow">

                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="mobail-menu-area cbp-spmenu-push hidden-lg">
            <nav class="cbp-spmenu cbp-spmenu-vertical cbp-spmenu-left" id="cbp-spmenu-s1">
               <div class="menu-header">
                   <button type="button" class="close pull-right" data-dismiss="cbp-spmenu-s1" aria-label="Close">
                   </button>
                   <ul>
                       <?= multilevelOrtaMenu("menyu","orta",0,get('linkname'),0) ?>
                   </ul>

               </div>
                <ul>
                    <?= multilevelCat("`category`",0,get('linkname'),0); ?>
                </ul>
            </nav>

                    <div class="nav navbar navbar-default navbar-primary">
                        <button id="showLeft">
                            <img src="../img/menu.png" alt="">
                        </button>
                        <form id="content" action="pages/search.php" method="get">
                            <input type="text"name="search"  class="input" id="search-input">
                            <button type="reset" class="search" id="search-btn"></button>
                        </form>
                        <div class="autocomplete autocomplete-search autocomplete-small autocomplete-hide">
                            <div class="search-results" id="search-results"></div>
                        </div>
                        <a href="/pages/contact.php" class="location">
                            <img src="../img/location.png" alt="">
                        </a>
                    </div>

        </div>
    </div>
</header>
<script src="../js/classie.js"></script>
