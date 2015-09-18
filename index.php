<?php include "inc/header.php"; ?>
<body>
    <div class="hero_banner">
       <?php include "inc/basic_nav.php"; ?> 
        <div class="hero-text text-center col-xs-10 col-xs-offset-1">
            <h1>Goggles' Data</h1>
            <h3>A no frills tool to help you get barreled.</h3>
        </div>
    </div>
    <div class="create-account-block text-center">
       <div class="col-xs-10 col-xs-offset-1">
           <div class="account-cta">
               <p>Create an account if you would like to be able to customize your data (don't worry its free).</p>
               <button class="btn btn-info">Create an account</button>
           </div>
           <h4>-Or-</h4>
           <div class="default-cta">
               <p>Select a location below to see what this is all about.</p>
           </div>
       </div>
       <div class="clearfix"></div>
    </div>
    <div class="location-tabs">
        <div class="col-xs-10 col-xs-offset-1">
            <h3>Select your location:</h3>
            <ul class=" list-unstyled">
                <li id="socal-tab" class="location-indiv-tab">Southern California<i class="glyphicon glyphicon-chevron-down"></i></li>
                <ul class="location-sub-menu list-unstyled">
                    <li><a href="javascript:;" loc_id="1">Santa Barbara</a></li>
                    <li><a href="javascript:;">Ventura</a></li>
                    <li><a href="javascript:;">Los Angeles</a></li>
                    <li><a href="javascript:;">North Orange County</a></li>
                    <li><a href="javascript:;">South Orange County</a></li>
                    <li><a href="javascript:;">North San Diego</a></li>
                    <li><a href="javascript:;">South San Diego</a></li>
                </ul>
            </ul>
            <ul class=" list-unstyled">
                <li id="cencal-tab" class="location-indiv-tab">Central California<i class="glyphicon glyphicon-chevron-down"></i></li>
                <ul class="location-sub-menu list-unstyled">
                    <li><a href="javascript:;">SLO County</a></li>
                    <li><a href="javascript:;">Big Sur</a></li>
                    <li><a href="javascript:;">Santa Cruz</a></li>
                    <li><a href="javascript:;">San Fransisco</a></li>
                </ul>
            </ul>
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="place-here"></div>
    <?php include "inc/footer.php"; ?> 