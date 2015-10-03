<?php include "inc/header.php"; ?>
<body>
    <div id="content-container">
        <div class="hero_banner">
           <div class="container-fluid">
            <?php include "inc/basic_nav.php"; ?>
           </div>
            <div class="hero-text text-center col-xs-10 col-xs-offset-1">
                <h1>Green Room Hunter</h1>
                <h3>A no frills tool to help you get barreled.</h3>
                <a id="socal-tab" class="location-indiv-tab">Where are you surfing today?<i class="glyphicon glyphicon-chevron-down"></i></a>
            </div>
        </div>
        <div class="location-tabs">
            <div class="col-xs-10 col-xs-offset-1">
                <h3>Select your location:</h3>
                <ul class="list-unstyled">
                    <li class="santa-barbara"><a href="#" loc_id="1">Santa Barbara</a></li>
                    <li class="ventura"><a href="#" loc_id="2">Ventura</a></li>
                    <li class="los-ang"><a href="#" loc_id="3">Los Angeles</a></li>
                    <li class="n-oc"><a href="javascript:;" loc_id="4">N. Orange County</a></li>
                    <li class="s-oc"><a href="javascript:;" loc_id="5">S. Orange County</a></li>
                    <li class="n-sd"><a href="javascript:;" loc_id="5">N. San Diego</a></li>
                    <li class="s-sd"><a href="javascript:;" loc_id="5">S. San Diego</a></li>
                </ul>


                <!--                <ul class=" list-unstyled">-->
<!--                    <li id="socal-tab" class="location-indiv-tab">Southern California<i class="glyphicon glyphicon-chevron-down"></i></li>-->
<!--                    <ul class="location-sub-menu list-unstyled">-->
<!--                        <li><a href="javascript:;" loc_id="1">Santa Barbara</a></li>-->
<!--                        <li><a href="javascript:;" loc_id="2">Ventura</a></li>-->
<!--                        <li><a href="javascript:;" loc_id="3">Los Angeles</a></li>-->
<!--                        <li><a href="javascript:;" loc_id="4">North Orange County</a></li>-->
<!--                        <li><a href="javascript:;" loc_id="5">South Orange County</a></li>-->
<!--                        <li><a href="javascript:;" loc_id="6">North San Diego</a></li>-->
<!--                        <li><a href="javascript:;" loc_id="7">South San Diego</a></li>-->
<!--                    </ul>-->
<!--                </ul>-->
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
    <?php include "inc/footer.php"; ?>