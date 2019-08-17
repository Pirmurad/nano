<style>
    /* Whatsapp start*/
    .whatsappme {
        position: fixed;
        z-index: 400;
        right: 20px;
        bottom: 20px;
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen, Ubuntu, Cantarell, "Open Sans", "Helvetica Neue", sans-serif;
        font-size: 16px;
        line-height: 26px;
        color: #262626;
        transform: scale3d(0, 0, 0);
        transition: transform .3s ease-in-out;
        user-select: none;
        -ms-user-select: none;
        -moz-user-select: none;
        -webkit-user-select: none;
    }

    .whatsappme--show {
        transform: scale3d(1, 1, 1);
        transition: transform .5s cubic-bezier(0.18, 0.89, 0.32, 1.28);
    }

    .whatsappme__button {
        position: absolute;
        z-index: 2;
        bottom: 8px;
        right: 8px;
        height: 60px;
        min-width: 60px;
        max-width: 95vw;
        background-color: #25D366;
        color: #fff;
        border-radius: 30px;
        box-shadow: 1px 6px 24px 0 rgba(7, 94, 84, .24);
        cursor: pointer;
        transition: background-color 0.2s linear;
    }

    .whatsappme__button:hover {
        background-color: #128C7E;
        transition: background-color 1.5s linear;
    }

    .whatsappme--dialog .whatsappme__button {
        transition: background-color 0.2s linear;
    }

    .whatsappme__button:active {
        background-color: #075E54;
        transition: none;
    }

    .whatsappme__button svg {
        width: 36px;
        height: 60px;
        margin: 0 12px;
    }

    .whatsappme__badge {
        position: absolute;
        top: -4px;
        right: -4px;
        width: 20px;
        height: 20px;
        border: none;
        border-radius: 50%;
        background: #e82c0c;
        font-size: 12px;
        font-weight: 600;
        line-height: 20px;
        text-align: center;
        box-shadow: none;
        opacity: 0;
        pointer-events: none;
    }

    .whatsappme__badge.whatsappme__badge--in {
        animation: badge--in 500ms cubic-bezier(0.27, 0.9, 0.41, 1.28) 1 both;
    }

    .whatsappme__badge.whatsappme__badge--out {
        animation: badge--out 400ms cubic-bezier(0.215, 0.61, 0.355, 1) 1 both;
    }

    .whatsappme--dialog .whatsappme__button {
        box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.3);
    }

    .whatsappme__box {
        position: absolute;
        bottom: 0;
        right: 0;
        z-index: 1;
        width: calc(100vw - 40px);
        max-width: 400px;
        min-height: 280px;
        padding-bottom: 60px;
        border-radius: 32px;
        background: #ede4dd url(../img/background.png) center repeat-y;
        background-size: 100% auto;
        box-shadow: 0 2px 6px 0 rgba(0, 0, 0, .5);
        overflow: hidden;
        transform: scale3d(0, 0, 0);
        opacity: 0;
        transition: opacity 400ms ease-out, transform 0ms linear 300ms;
    }

    .whatsappme--dialog .whatsappme__box {
        opacity: 1;
        transform: scale3d(1, 1, 1);
        transition: opacity 200ms ease-out, transform 0ms linear;
    }

    .whatsappme__header {
        display: block;
        position: static;
        width: 100%;
        height: 70px;
        padding: 0 26px;
        margin: 0;
        background-color: #2e8c7d;
        color: rgba(255, 255, 255, .5);
    }

    .whatsappme__header svg {
        height: 100%;
    }

    .whatsappme__close {
        position: absolute;
        top: 18px;
        right: 24px;
        width: 34px;
        height: 34px;
        border-radius: 50%;
        background: #000;
        color: #fff;
        line-height: 30px;
        font-size: 25px;
        text-align: center;
        opacity: .4;
        cursor: pointer;
        transition: opacity 300ms ease-out;
    }

    .whatsappme__close:hover {
        opacity: .6;
    }

    .whatsappme__message {
        position: relative;
        min-height: 80px;
        padding: 20px 22px;
        margin: 34px 26px;
        border-radius: 32px;
        background-color: #fff;
        color: #4A4A4A;
        box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.3);
    }

    .whatsappme__message:before {
        content: '';
        display: block;
        position: absolute;
        bottom: 30px;
        left: -18px;
        width: 18px;
        height: 18px;
        background-image: url('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADcAAAA1CAYAAADlE3NNAAAEr0lEQVRo3t2aT0gjVxzHf++9mcn8zWhW6bpELWzcogFNaRar7a4tBNy2WATbHpacpdZ6redeZE+9CL02B1ktXsRD/xwsilhoSwsqag/xYK09hCQlmCiTf28vGRnGmZhE183MFx5vmGQy7zO/P/P7PYLAHUIAQCqDAwDPxMREG3IpHL+zs/MZcgkYAgAMAIwOl8lkYm6xGgYAFgAEAGgZHx9/vVwun7nJJTkAEAGgdW9v73NKKXWLSzIA4AEAGQDazs/P/3ALnNEl1a2trY9oRW6wmu6SEgC0ZrPZn9wCp2dIHgCU1dXVtymlZafDIatEksvlfqYGueG9xgOAcnBw8JSa5GR3vIi1aDTaUSwWj5wOZ3RHPUN6U6nUN9RCTnZHDwDI+/v745TSkpPhrOpHcWlpqbdcLieojZwGpseZMDo66svn87/RKnIaGAsAfCAQ8J6dnX1Pr5DjwABAzmazMVqDHAd2enr6La1RjgGLRCJqLpeL0TrUjFDGrMgCAD8/P38vn8//QutUs1pLT/fC5ubmQKFQOKANqNmspbuhBwDEZDL5BaX0lDaoZoK62NxZXFzs1DRthV5TrxrKGFue/v5+KZ1Of1kul5P0BtQUUAAgxOPx9wuFwl/0BvWq3O8C6vDw8F1N036gL0G3ZaVLUEdHRxFN036kL1E3DWMHxAEAPzc3dyedTk+XSqUdegu6CRijy5mBPLOzs2oikfhU07RFSmmG3qKuaxkdxuhy/MzMjDeRSHyiadrz2wYyClUBMh9bzRfAu7u7PX6//z1RFB9zHBcBALUZKoRqUMgEgyvHeHt7+353d/cjQRBGWJZ9jBDqaMYKHKpYBAEAXltbawsGg2FFUd7iOO4hIeQhQuiOEzpdOzCSTCaftLS0fEUIGXbiHiBjU5njVCr1sc/nW6wkDcduS1u1HKRUKv2KMR4ABwvbAWKMA+BwYbsasFgs/uMWuEtxd3x8/J3b4C4Ag8Hg83g8/iyfz//n5IRi1eZzla00HgA8oijyDMNwlFJCCGH0axiGQQAAXq+XyLLMeL1eRlEURpZlRpIkhud5oigK297eLvl8Prm1tVVSFEWSJEkWRVESBMGrqupriqLcFQThLsaYu612n6vUip4KMFv5HJssjhooEi5laoZh0NjYWNvw8PC9np6ejkAg8MDv9w+oqnrfxsNqhgNTh2wE1MGYChyyWGA9RYJVFWTM3MhwjMPhsDw9PT0QDocHOjs731RV9Y1rv+cMlb4Oiy3garWW1b2sPMfceZgHmZqa6pycnPywr6/vA47jfPXAWbU0xOCOqE44u2K8Wl9oBUfMa+rq6hIWFhbGBwcHn9pBohogcRWwRiCRTUiACQ6ZYpxY9JAkFAopy8vLM4FAYKyRrgA1GGf1JperLGgEM4cNG4vF3olGo18TQkT9JsRmAdQw66NsGlbn7Ibdd0um2XzOblz6/ZWVlX8JIb8PDQ090gFJDU+e2sBeZ1hBU9NcqvIQzDMFALq+vp7GGP85MjLyBCHE1tPO1LP4eq4FG/hqnlGyeSiwsbHxfygUOu7t7Y00059JUY3ZHFm8k1lT0cGfnJw8c0ojepWFzd6CMpnM3y8AJPEkZ9khO4IAAAAASUVORK5CYII=');
        background-size: 100%;
    }

    /* Align left */

    .whatsappme--left {
        right: auto;
        left: 20px;
    }

    .whatsappme--left .whatsappme__button {
        right: auto;
        left: 8px;
    }

    .whatsappme--left .whatsappme__box {
        right: auto;
        left: 0;
    }

    @media (max-width: 480px) {
        .whatsappme {
            bottom: 6px;
            right: 6px;
        }

        .whatsappme--left {
            right: auto;
            left: 6px;
        }

        .whatsappme__box {
            width: calc(100vw - 12px);
            min-height: 0;
        }

        .whatsappme__header {
            height: 55px;
        }

        .whatsappme__close {
            top: 13px;
            width: 28px;
            height: 28px;
            line-height: 28px;
        }

        .whatsappme__message {
            padding: 14px 20px;
            margin: 15px 21px 20px;
            line-height: 24px;
        }
    }

    @keyframes badge--in {
        from {
            opacity: 0;
            transform: translateY(50px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes badge--out {
        0% {
            opacity: 1;
            transform: translateY(0);
        }
        100% {
            opacity: 0;
            transform: translateY(-20px);
        }
    }
    /* Whatsapp end*/
</style>
<footer class="bg-fff bt">
    <div class="footer-top-area ptb-35 bb">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <div class="footer-widget">
                        <div class="footer-logo mb-25" style="background-image: url('img/logo/1.png');width: 263px;height: 66px;background-size: 100% 100%;background-position: center;">
                        </div>
                        <div class="footer-content">
                            <p><?= $information['about']?></p>
                            <ul class="list-unstyled">
                                <li>
                                    <div class="contuct-content">
                                        <div class="contuct-icon">
                                            <i class="fas fa-map-marker-alt"></i>
                                        </div>
                                        <div class="contuct-info">
                                            <span><?= $information['address'] ?></span>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="contuct-content">
                                        <div class="contuct-icon">
                                            <i class="fas fa-phone"></i>
                                        </div>
                                        <div class="contuct-info">
                                            <span><a href="https://api.whatsapp.com/send?phone=994<?= substr($information['phone'], 1); ?>"><?= $information['phone'] ?></a></span>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="contuct-content">
                                        <div class="contuct-icon">
                                            <i class="fas fa-at"></i>
                                        </div>
                                        <div class="contuct-info">
                                            <span><a href="mailto:<?= $information['mail'] ?>"><?= $information['mail'] ?></a></span>
                                        </div>
                                    </div>
                                </li>
                            </ul>

                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                    <div class="footer-widget">
                        <h3 class="footer-title mb-20">Şirkət Haqqında</h3>
                        <div class="footer-menu home3-hover">
                            <ul>
                                <?= multilevelBottomCat('menyu',"haqqinda","0"); ?>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                    <div class="footer-widget">
                        <h3 class="footer-title mb-20">Servis Xidməti</h3>
                        <div class="footer-menu home3-hover">
                            <ul>
                                <?= multilevelBottomCat('menyu',"servis","0"); ?>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                    <div class="footer-widget">
                        <h3 class="footer-title mb-20">Müştəri üçün</h3>
                        <div class="footer-menu">
                            <ul>
                                <?= multilevelBottomCat('menyu',"musteri","0"); ?>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                    <h3 class="footer-title mb-20">Sosial şəbəkələrdə</h3>
                    <div class="footer-menu">
                        <ul class="list-unstyled">
                            <? if (!empty($information['facebook'])): ?>
                            <li>
                                <a href="<?= $information['facebook'] ?>" target="_blank" title="Facebook" class="footer-social fb"><i class="fab fa-facebook-f fa-fw"></i> Facebook</a>
                            </li>
                            <? endif;if (!empty($information['twitter'])): ?>
                            <li>
                                <a href="<?= $information['twitter'] ?>" target="_blank" title="Twitter" class="footer-social tw"><i class="fab fa-twitter fa-fw"></i> Twitter</a>
                            </li>
                            <? endif;if (!empty($information['instagram'])): ?>
                            <li>
                                <a href="<?= $information['instagram'] ?>" target="_blank" title="Instagram" class="footer-social ins"><i class="fab fa-instagram fa-fw"></i> Instagram</a>
                            </li>
                            <? endif;if (!empty($information['youtube'])): ?>
                            <li>
                                <a href="<?= $information['youtube'] ?>" target="_blank" title="Youtube" class="footer-social you"><i class="fab fa-youtube fa-fw"></i> Youtube</a>
                            </li>
                            <? endif;if (!empty($information['whatsapp'])): ?>
                            <li>
                                <a href="<?= $information['whatsapp'] ?>" target="_blank" title="Whatsapp" class="footer-social wp"><i class="fab fa-whatsapp fa-fw"></i> Whatsapp</a>
                            </li>
                            <? endif; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-bottom ptb-20">
        <div class="container">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <div class="copyright">
                    <span>Copyright &copy; 2018 <a href="http://mrsadiq.info/" target="_blank" title="MrSadiq.info Portfolio Site"><img src="img/mrsadiq.info.png" alt="MrSadiq.info Portfolio Site" style="width: 30px;margin-top: -5px;margin-left: 5px;margin-right: 5px;"></a> Bütün hüquqlar qorunur</span>
                </div>
            </div>
        </div>
    </div>
</footer>
<!-- whatsapp start
<div class="whatsappme whatsappme--left" data-settings="{&quot;telephone&quot;:&quot;994558034499&quot;,&quot;message_text&quot;:&quot;Salam!\nSiz\u0259 nec\u0259 k\u00f6m\u0259k ed\u0259 bil\u0259rik?&quot;,&quot;message_delay&quot;:10000,&quot;message_badge&quot;:true,&quot;message_send&quot;:&quot;Salam,ayıq sürücü sifariş etmək istəyirəm!&quot;,&quot;mobile_only&quot;:false}">
    <div class="whatsappme__button">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z" fill="currentColor"></path></svg>
        <div class="whatsappme__badge whatsappme__badge--in">1</div>
    </div>
    <div class="whatsappme__box">
        <header class="whatsappme__header">
            <svg xmlns="http://www.w3.org/2000/svg" width="120" height="28" viewBox="0 0 120 28"><path d="M117.2 17c0 .4-.2.7-.4 1-.1.3-.4.5-.7.7l-1 .2c-.5 0-.9 0-1.2-.2l-.7-.7a3 3 0 0 1-.4-1 5.4 5.4 0 0 1 0-2.3c0-.4.2-.7.4-1l.7-.7a2 2 0 0 1 1.1-.3 2 2 0 0 1 1.8 1l.4 1a5.3 5.3 0 0 1 0 2.3zm2.5-3c-.1-.7-.4-1.3-.8-1.7a4 4 0 0 0-1.3-1.2c-.6-.3-1.3-.4-2-.4-.6 0-1.2.1-1.7.4a3 3 0 0 0-1.2 1.1V11H110v13h2.7v-4.5c.4.4.8.8 1.3 1 .5.3 1 .4 1.6.4a4 4 0 0 0 3.2-1.5c.4-.5.7-1 .8-1.6.2-.6.3-1.2.3-1.9s0-1.3-.3-2zm-13.1 3c0 .4-.2.7-.4 1l-.7.7-1.1.2c-.4 0-.8 0-1-.2-.4-.2-.6-.4-.8-.7a3 3 0 0 1-.4-1 5.4 5.4 0 0 1 0-2.3c0-.4.2-.7.4-1 .1-.3.4-.5.7-.7a2 2 0 0 1 1-.3 2 2 0 0 1 1.9 1l.4 1a5.4 5.4 0 0 1 0 2.3zm1.7-4.7a4 4 0 0 0-3.3-1.6c-.6 0-1.2.1-1.7.4a3 3 0 0 0-1.2 1.1V11h-2.6v13h2.7v-4.5c.3.4.7.8 1.2 1 .6.3 1.1.4 1.7.4a4 4 0 0 0 3.2-1.5c.4-.5.6-1 .8-1.6.2-.6.3-1.2.3-1.9s-.1-1.3-.3-2c-.2-.6-.4-1.2-.8-1.6zm-17.5 3.2l1.7-5 1.7 5h-3.4zm.2-8.2l-5 13.4h3l1-3h5l1 3h3L94 7.3h-3zm-5.3 9.1l-.6-.8-1-.5a11.6 11.6 0 0 0-2.3-.5l-1-.3a2 2 0 0 1-.6-.3.7.7 0 0 1-.3-.6c0-.2 0-.4.2-.5l.3-.3h.5l.5-.1c.5 0 .9 0 1.2.3.4.1.6.5.6 1h2.5c0-.6-.2-1.1-.4-1.5a3 3 0 0 0-1-1 4 4 0 0 0-1.3-.5 7.7 7.7 0 0 0-3 0c-.6.1-1 .3-1.4.5l-1 1a3 3 0 0 0-.4 1.5 2 2 0 0 0 1 1.8l1 .5 1.1.3 2.2.6c.6.2.8.5.8 1l-.1.5-.4.4a2 2 0 0 1-.6.2 2.8 2.8 0 0 1-1.4 0 2 2 0 0 1-.6-.3l-.5-.5-.2-.8H77c0 .7.2 1.2.5 1.6.2.5.6.8 1 1 .4.3.9.5 1.4.6a8 8 0 0 0 3.3 0c.5 0 1-.2 1.4-.5a3 3 0 0 0 1-1c.3-.5.4-1 .4-1.6 0-.5 0-.9-.3-1.2zM74.7 8h-2.6v3h-1.7v1.7h1.7v5.8c0 .5 0 .9.2 1.2l.7.7 1 .3a7.8 7.8 0 0 0 2 0h.7v-2.1a3.4 3.4 0 0 1-.8 0l-1-.1-.2-1v-4.8h2V11h-2V8zm-7.6 9v.5l-.3.8-.7.6c-.2.2-.7.2-1.2.2h-.6l-.5-.2a1 1 0 0 1-.4-.4l-.1-.6.1-.6.4-.4.5-.3a4.8 4.8 0 0 1 1.2-.2 8.3 8.3 0 0 0 1.2-.2l.4-.3v1zm2.6 1.5v-5c0-.6 0-1.1-.3-1.5l-1-.8-1.4-.4a10.9 10.9 0 0 0-3.1 0l-1.5.6c-.4.2-.7.6-1 1a3 3 0 0 0-.5 1.5h2.7c0-.5.2-.9.5-1a2 2 0 0 1 1.3-.4h.6l.6.2.3.4.2.7c0 .3 0 .5-.3.6-.1.2-.4.3-.7.4l-1 .1a21.9 21.9 0 0 0-2.4.4l-1 .5c-.3.2-.6.5-.8.9-.2.3-.3.8-.3 1.3s.1 1 .3 1.3c.1.4.4.7.7 1l1 .4c.4.2.9.2 1.3.2a6 6 0 0 0 1.8-.2c.6-.2 1-.5 1.5-1a4 4 0 0 0 .2 1H70l-.3-1v-1.2zm-11-6.7c-.2-.4-.6-.6-1-.8-.5-.2-1-.3-1.8-.3-.5 0-1 .1-1.5.4a3 3 0 0 0-1.3 1.2v-5h-2.7v13.4H53v-5.1c0-1 .2-1.7.5-2.2.3-.4.9-.6 1.6-.6.6 0 1 .2 1.3.6.3.4.4 1 .4 1.8v5.5h2.7v-6c0-.6 0-1.2-.2-1.6 0-.5-.3-1-.5-1.3zm-14 4.7l-2.3-9.2h-2.8l-2.3 9-2.2-9h-3l3.6 13.4h3l2.2-9.2 2.3 9.2h3l3.6-13.4h-3l-2.1 9.2zm-24.5.2L18 15.6c-.3-.1-.6-.2-.8.2A20 20 0 0 1 16 17c-.2.2-.4.3-.7.1-.4-.2-1.5-.5-2.8-1.7-1-1-1.7-2-2-2.4-.1-.4 0-.5.2-.7l.5-.6.4-.6v-.6L10.4 8c-.3-.6-.6-.5-.8-.6H9c-.2 0-.6.1-.9.5C7.8 8.2 7 9 7 10.7c0 1.7 1.3 3.4 1.4 3.6.2.3 2.5 3.7 6 5.2l1.9.8c.8.2 1.6.2 2.2.1.6-.1 2-.8 2.3-1.6.3-.9.3-1.5.2-1.7l-.7-.4zM14 25.3c-2 0-4-.5-5.8-1.6l-.4-.2-4.4 1.1 1.2-4.2-.3-.5A11.5 11.5 0 0 1 22.1 5.7 11.5 11.5 0 0 1 14 25.3zM14 0A13.8 13.8 0 0 0 2 20.7L0 28l7.3-2A13.8 13.8 0 1 0 14 0z" fill="currentColor" fill-rule="evenodd"></path></svg>
            <div class="whatsappme__close">×</div>
        </header>
        <div class="whatsappme__message">Salam!<br>Sizə necə kömək edə bilərik?</div>
    </div>
</div>
 whatsapp end -->
