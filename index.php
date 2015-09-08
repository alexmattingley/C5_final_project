<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>C5 final project</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="hero_banner">
        <nav class="navbar">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed pull-left" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="glyphicon glyphicon-menu-hamburger"></span>
                    </button>
                    <div class="right-side-nav pull-right">
                        <button class="btn btn-default">Login</button>
                    </div>
                </div>
                <div class="collapse navbar-collapse left-side-nav pull-left" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav">
                        <li><a href="index.php">Home</a></li>
                        <li><a href="#">About</a></li>
                        <li><a href="">Contact Us</a></li>
                </div>
            </div>
        </nav>
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
                <li id="socal-tab pills">Southern California<i class="glyphicon glyphicon-chevron-down"></i></li>
                <ul class="location-sub-menu list-unstyled">
                    <li><a href="javascript:;">Santa Barbara</a></li>
                    <li><a href="javascript:;">Ventura</a></li>
                    <li><a href="javascript:;">Los Angeles</a></li>
                    <li><a href="javascript:;">North Orange County</a></li>
                    <li><a href="javascript:;">South Orange County</a></li>
                    <li><a href="javascript:;">North San Diego</a></li>
                    <li><a href="javascript:;">South San Diego</a></li>
                </ul>
            </ul>
            <ul class=" list-unstyled">
                <li id="socal-tab pills">Central California<i class="glyphicon glyphicon-chevron-down"></i></li>
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
    <footer class="clearfix">
        <p class="col-xs-12 col-sm-12 text-center copyright">Copyright &copy; <?php echo date('Y'); ?> . All rights reserved.</p>
    </footer>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script src="main.js"></script>
</body>
</html>