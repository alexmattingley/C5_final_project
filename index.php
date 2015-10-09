<?php include "inc/header.php"; ?>
<body>
    <div id="content-container">
        <div class="container-fluid col-sm-10 col-sm-offset-1">
            <?php include "inc/basic_nav.php"; ?>
        </div>
        <div class="clearfix"></div>
        <div class="hero_banner">
            <div class="hero-text text-center col-xs-10 col-xs-offset-1">
                <img class = "mobile-logo col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3" src="images/logo.png" alt="">
                <h3 class="col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3">A no frills tool to help you get barreled.</h3>
            </div>
        </div>
        <div class="location-tabs">
            <div class="col-xs-12">
                <h3>Where are you surfing today?</h3>
                <ul class="list-unstyled">
                    <li class="santa-barbara col-sm-6 col-md-4"><a href="javascript:;" loc_id="1">Santa Barbara</a></li>
                    <li class="ventura col-sm-6 col-md-4"><a href="javscript:;" loc_id="2">Ventura</a></li>
                    <li class="los-ang col-sm-6 col-md-4"><a href="javascript:;" loc_id="3">Los Angeles</a></li>
                    <li class="n-oc col-sm-6 col-md-4"><a href="javascript:;" loc_id="4">N. Orange County</a></li>
                    <li class="s-oc col-sm-6 col-md-4"><a href="javascript:;" loc_id="5">S. Orange County</a></li>
                    <li class="n-sd col-sm-6 col-md-4"><a href="javascript:;" loc_id="5">N. San Diego</a></li>
                    <li class="s-sd col-sm-6 col-md-4"><a href="javascript:;" loc_id="5">S. San Diego</a></li>
                </ul>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
    <?php include "inc/footer.php"; ?>