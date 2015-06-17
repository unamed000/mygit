<?php
/**
 * Created by PhpStorm.
 * User: gento
 * Date: 16/5/2015
 * Time: 2:14 PM
 */?>


<html>
<head>
    <?= $head ?>
</head>
<body ng-app="mine">
<header style="max-height:10%">
    <div class="top-nav">
        <?= $header ?>
    </div>
<!--    <ul class="side-nav fixed">--><?//= $navigation ?><!--</ul>-->
</header>

<main style="max-height:80%">
    <?= $content ?>
    <?= $footer ?>
</main>
</body>
</html>

<script>
    var base_url = '<?= base_url() ?>';
    var site_url = '<?= site_url()?>';
    var REQUEST_SUCCESS = '<?= REQUEST_SUCCESS?>';
    var REQUEST_FAIL = '<?= REQUEST_FAIL?>';

    window.fbAsyncInit = function() {
        FB.init({
            appId      : '1429332237373438',
            xfbml      : true,
            version    : 'v2.3'
        });
    };
    (function(d, s, id){
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) {return;}
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/en_US/sdk.js";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
</script>
<script src="<?= base_url('assets/system/helper.js') ?>"></script>
<script src="<?= base_url('assets/system/system.js') ?>"></script>
<script src="<?= base_url('assets/angularjs/js/angular.min.js') ?>"></script>
<script src="<?= base_url('assets/angularjs/app/app.js') ?>"></script>



