    <div class="header-page">
        <div class="container-fluid">
            <div class=" col-sm-10 col-sm-offset-1 ">
                <?php include "inc/basic_nav.php"; ?>
                <h2>About Green Room hunter</h2>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="container-fluid about-text">
        <div class="col-sm-10 col-sm-offset-1">
            <div class="intro">
                <h4>Note: If you are looking for information about how this site was built, checkout the <a
                        href="https://github.com/alexmattingley/C5_final_project">github repo</a></h4>
                <p>Many years ago, long before I was ever a web developer, I fell in love surf forecasting and data. I have always lived and thrived in places with fickle waves, so it was in these places that I learned how valuable live weather data is for surfers and how often surf forecasters were wrong despite their best intentions.
                </p>
                <p>This application compiles the most important buoy and wind information into one, easy to use site. I am not here to tell you what to think, or tell you how big or how good it will be at your spot. Each surf spot is different and unique and it takes years of careful observation to learn what each unique swell will be doing at a beach near you. In fact one of the most beautiful things about the ocean is that it will never be the same two days in a row. It will continue to confound day after day, and there is something magical about that.
                </p>
                <p>The purpose of this application is to help you get barreled.
                </p>
            </div>
            <h2>A little bit of information about the different pieces of the puzzle:</h2>
            <div class="block">
                <h3>Buoys and wave height readings</h3>
                <p>Buoys measure raw swell at a variety of points throughout the ocean. Buoy height and period combine to create wave heights at your local beach. Depending on what spot you call home, you can get a wide variety of different sizes and shapes from a given swell height, period, direction combination.
                </p>
                <h4>Let’s do a quick example:</h4>
                <h4>The Harvest Buoy is 4 ft @ 18 seconds from 295 degrees.</h4>
                <p>A swell at this height and direction is interesting because of how much disparity there will be between each area.
                    If you were to check any of the spots in Goleta or Santa Barbara county you would probably find small weak waves at
                    just about every wave north of Rincon. Rincon and the gold coast beach breaks wouldn’t be much better but there would
                    be rideable waves. In fact you wouldn’t really start to see a disparity in size until you got south of Ventura Overhead.
                    However, if you happened to check Santa Clara or Ventura harbor because you like closeouts and death barrels, you would
                    find large surf and treacherous conditions. </p>
                <h4>There are really three factors at play here:</h4>
                <p>The period length, the direction, and bathymetry. At 295 most of the northern points are sheltered from the swell, while
                    many of the wide open beach breaks are feeling more of the energy. The period length and the bathymetry are interrelated,
                    and with a longer period swell (over 16 seconds) you are going to see a greater disparity between surf breaks depending
                    on that break’s bottom contour or bathymetry.
                </p>
                <p>In this case both ventura Harbor and Santa Clara have very deep water just offshore which pulls in all types of swell,
                    but long period swell in particular likes to focus here. With a little bit of observation, you can figure out which
                    places respond well to long period swell and which ones do not.</p>
            </div>
            <div class="block">
                <h3>Wind Readings</h3>
                <p>Wind readings are pretty self explanatory. It is however important to note that the wind readings are only
                    taken once an hour so pay attention to the updated time field. I have chosen strategic wind points in each
                    county to reflect different sections of coast. For example in North Orange County, I have chosen a wind point
                    at Magnolia street and at the wedge. Even though these two places are close to one another, they are usually different.</p>
            </div>
            <div class="block">
                <h3>Buoy Prediction Models</h3>
                <p>These models originate from cdip and they are very useful for determining if a swell is on time or if it is bigger or smaller than predicted. The red line is the actual reading, and the blue line is the predicted sea height.
                </p>
            </div>
            <div class="block">
                <h3>CDIP color models</h3>
                <p>These models are good for getting a general overview of what is going on out at sea. They are models, so they are not as accurate as the buoys, but I find them useful for figuring out if swell is reaching into certain sections of the coast.
                </p>
            </div>
            <div class="block">
                <h3>Offshore wind models</h3>
                <p>These models allow you to see what is going on off the coast of california. If the wind is light on the coast, but it is windy out at sea, this is usually an indicator of morning sickness.
                </p>
            </div>
            <div class="block">
                <h3>Tides</h3>
                <p>These tide charts are being created uniquely for each area and they are not perfect yet, but they look pretty and they do have accurate readings for the high and low tides of each day.
                </p>
            </div>
            <h4>I hope this application will be useful to you, and that you can use it to help you get barreled!</h4>
        </div>
    </div>
