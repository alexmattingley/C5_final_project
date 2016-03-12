$(document).ready(function(){
    var current_url = window.location.href;
    var url_index = current_url.length-1;
    var last_value = current_url[url_index];
    set_top_padding('.hero_banner');
    add_contact_info();
    wunderground_data_call();


    //if location_id is a number then pull a locations page.
    if(!isNaN(last_value)) {
        pull_relevant_page_location(last_value);
        get_tide_data(last_value);
        get_buoy_array(last_value);
    }else if(!getQueryVariable('current_page') == false) {
       var non_location_page = getQueryVariable('current_page');
        get_non_location_pages(non_location_page);
    }


   $(".location-tabs li a").click(function(){
       var loc_id = $(this).attr('loc_id');
       pull_relevant_page_location(loc_id);
       get_tide_data(loc_id);
       get_buoy_array(loc_id);
   });

   $('body').on('click', '.navbar-nav a', function(){
       var current_page = $(this).attr('page');
       get_non_location_pages(current_page);
   });

});


/**************************
 * functionName: getQueryVariable();
 * @purpose: Searches through the url finds the query variables
 * @param variable
 * @returns {*}
 * @globals: N/A
 */

    function getQueryVariable(variable)
    {
        var query = window.location.search.substring(1);
        var vars = query.split("&");
        for (var i=0;i<vars.length;i++) {
            var pair = vars[i].split("=");
            if(pair[0] == variable){
                return pair[1];
            }
        }
        return(false);
    }


/**********************
 * functionName: add_contact_info();
 * @purpose: dynamically adds contact information
 * @params: N/A;
 * @globals: N/A
 * @return: N/A;
 */

function add_contact_info() {
    var email_add = $('.email_add');
    var e_icon = '<span class="glyphicon glyphicon-envelope"></span>';
    var e_name = ' alexmattingley';
    var server_name = '@gmail.com';
    var phe_class = $('.p_Num');
    var phe_icon = '<span class="glyphicon glyphicon-phone-alt"></span>';
    var pNum = ' (949) 280-6557';
    email_add.html(e_icon + e_name + server_name);
    phe_class.html(phe_icon + pNum);
}




/*****************
 * functionName: wunderground_data_call
 * @purpose: This function calls the wind/weather database
 * @param: N/A
 * @returns: N/A
 */

function wunderground_data_call(){
    $.ajax({
        url : "data_handlers/weather_data_call.php",
        dataType : "json",
        success : function(response) {
           console.log(response);

        }
    });
}

/*****************
 * functionName: pull_relevant_page_location
 * @purpose: This function pulls the relevant html page for each location and then appends that page to the content-container. Location_id is set on the home page.
 * @param: location_id
 * @returns: N/A
 */

var $content_container = $('#content-container');
function pull_relevant_page_location(location_id){
    $.ajax({
        url: "data_handlers/default_location_page.php",
        method: "POST",
        dataType: "text",
        data: {
            location_index: location_id
        },
        success: function(response){
            $content_container.empty();
            $content_container.html(response);
            window.history.pushState('test', 'test', 'index.php?current_page=' + location_id);
            set_top_padding('.header-page');
            $('body').scrollTop(0);
            even_height_cols();
        }

    });
}

/********************
 * functionName: get_non_location_pages
 * @purpose: Pulls relevant html pages for non locational pages.
 * @param current_page
 * @returns: N/A
 * @globals: N/A
 */

function get_non_location_pages(current_page) {
    $.ajax({
        url: current_page,
        method: "POST",
        dataType: "html",
        success: function(response){
            $content_container.empty();
            $content_container.html(response);
            window.history.pushState('test', 'test', 'index.php?current_page=' + current_page);
            set_top_padding('.header-page');
            $('body').scrollTop(0);
        }

    });
}


/********************
 * functionName: get_buoy_array()
 * @purpose: communicate with the historical buoy data file, get the up-to-date data for the past 24 hours.
 * @param location_id
 * @returns: N/A
 * @globals: raw_buoy_data
 */

var raw_buoy_data;

 function get_buoy_array(location_id){
    $.ajax({
        url: "data_handlers/get_historical_buoy_data.php",
        method: "POST",
        dataType: "json",
        data: {
            location_index: location_id
        },
        cache: "false",
        success: function(response){
            raw_buoy_data = response;
            console.log(raw_buoy_data);
            create_buoy_instance();
        }
    });
    
 }

 /********************
 * object contstructor: The purpose of this function is construct the buoy_objects
 */

 var buoy_object = function(stationName, stationNum, readTimeArray, heightArray, periodArray, dirArray, waterTempArray){
    this.stationName = stationName;
    this.stationNum = stationNum;
    this.readTimeArray = readTimeArray;
    this.heightArray = heightArray;
    this.periodArray = periodArray;
    this.dirArray = dirArray;
    this.waterTempArray = waterTempArray;
 }



/********************
 * functionName: create_buoy_instance()
 * @purpose: Create the buoy object and then put pieces of that object in an array which can be used by the charts
 * @param
 * @returns: N/A
 * @globals: buoy_array
 */

var buoy_array = [];

 function create_buoy_instance(){
    for(var prop in raw_buoy_data){
        var buoyInfoArray = raw_buoy_data[prop];
        var buoyName = buoyInfoArray[0].station_name;
        var buoyNum = buoyInfoArray[0].station_num;
        var buoyTime = create_buoy_arrays(buoyInfoArray, "read_time");
        var buoyHeightArray = create_buoy_arrays(buoyInfoArray, "swell_height");
        var buoyPeriodArray = create_buoy_arrays(buoyInfoArray, "peak_period");
        var buoydirArray = create_buoy_arrays(buoyInfoArray, "swell_direction");
        var buoyWaterTempArray = create_buoy_arrays(buoyInfoArray, "water_temp");
        var buoy = new buoy_object(buoyName, buoyNum, buoyTime, buoyHeightArray, buoyPeriodArray, buoydirArray, buoyWaterTempArray);
        buoy_array.push(buoy);
    }
    create_buoy_charts();
 }

/********************
 * functionName: create_buoy_arrays
 * @purpose: Create an array of values from buoy object so it can be used for the charts.
 * @param specific_array, property
 * @returns: return_array
 * @globals: N/A
 */

 function create_buoy_arrays(specific_array, property){
    var return_array = [];
    for(var i = 0; i < specific_array.length; i++){
        return_array[i] = specific_array[i][property];
    }
    return return_array;
 }

 /********************
 * functionName: create_buoy_charts
 * @purpose: Create charts from chart js plugin for each indivdual buoy_object
 * @param N/A
 * @returns: N/A
 * @globals: N/A
 */

 function create_buoy_charts(){

    var options = {
        ///Boolean - Whether grid lines are shown across the chart
        scaleShowGridLines : true,

        //String - Colour of the grid lines
        scaleGridLineColor : "rgba(0,0,0,.05)",

        //Number - Width of the grid lines
        scaleGridLineWidth : 1,

        //Boolean - Whether to show horizontal lines (except X axis)
        scaleShowHorizontalLines: true,

        //Boolean - Whether to show vertical lines (except Y axis)
        scaleShowVerticalLines: true,

        //Boolean - Whether the line is curved between points
        bezierCurve : true,

        //Number - Tension of the bezier curve between points
        bezierCurveTension : 0.4,

        //Boolean - Whether to show a dot for each point
        pointDot : true,

        //Number - Radius of each point dot in pixels
        pointDotRadius : 4,

        //Number - Pixel width of point dot stroke
        pointDotStrokeWidth : 1,

        //Number - amount extra to add to the radius to cater for hit detection outside the drawn point
        pointHitDetectionRadius : 20,

        //Boolean - Whether to show a stroke for datasets
        datasetStroke : true,

        //Number - Pixel width of dataset stroke
        datasetStrokeWidth : 2,

        //Boolean - Whether to fill the dataset with a colour
        datasetFill : true,

        //String - A legend template
        legendTemplate : "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].strokeColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>"

    };

    var data = {
        labels:[],
        datasets:[
        {
            label:"buoy height",
            fillColor: "rgba(151,187,205,.5)",
            strokeColor: "rgba(151,187,205,1)",
            pointColor: "rgba(151,187,205,1)",
            pointStrokeColor: "#fff",
            pointHighlightFill: "#fff",
            pointHighlightStroke: "rgba(220,220,220,1)",
            data: []
        },
        {
            label: "buoy period",
            fillColor: "rgba(0,0,0,0)",
            strokeColor: "rgba(128, 222, 217, 1)",
            pointColor: "rgba(128, 222, 217, 1)",
            pointStrokeColor: "#fff",
            pointHighlightFill: "#fff",
            pointHighlightStroke: "rgba(151,187,205,1)",
            data: []
        }
        ]
    };
    console.log(buoy_array);
    for(var i = 0; i < buoy_array.length; i++){
        data.datasets[0].data = [];
        data.datasets[1].data = [];
        data.labels = [];
        create_structure_buoy_row(buoy_array[i].stationNum, buoy_array[i].stationName);
        var last_value = buoy_array[i].readTimeArray.length-1;
        create_current_buoy_info(buoy_array[i].stationNum,buoy_array[i].readTimeArray[last_value], buoy_array[i].heightArray[last_value], buoy_array[i].periodArray[last_value], buoy_array[i].dirArray[last_value], buoy_array[i].waterTempArray[last_value]);
        data.datasets[0].data = buoy_array[i].heightArray;
        data.datasets[1].data = buoy_array[i].periodArray;

        for (var j = 0; j < data.datasets[0].data.length; j++) {
            data.labels.push(j);
        }

        var chart_selector = "." + buoy_array[i].stationNum + " canvas";
        var ctx = $(chart_selector).get(0).getContext('2d');
        Chart.defaults.global.responsive = true;
        var buoyHeightChart = new Chart(ctx).Line(data,options);
    }
    set_canvas_dims();
 }

/********************
 * functionName: create_structure_buoy_row
 * @purpose: creates structure for the current buoy reading box
 * @param className, buoyName
 * @returns: N/A
 * @globals: N/A
 */ 

 function create_structure_buoy_row(className, buoyName){
    
    var row = $('<div>',{
        class: "buoy-row " + className
    });

    var graph_container = $('<div>',{
        class: "col-sm-7"
    });

    var graph_title = $('<h5>', {
        text: "Wave period & height in the past 24 hours"
    });

    var color_square_period = $('<span>', {
        class: "color_period color-square"
    });

    var graph_description_period = $('<p>', {
        text: "wave period = "
    });

     var color_square_height = $('<span>', {
        class: "color_height color-square"
    });

    var graph_description_height = $('<p>', {
        text: "wave height = "
    });

    var current_info_container = $('<div>', {
        class: "col-sm-5 current-info"
    });

    var buoy_title = $('<h4>', {
        text: buoyName,
        class: "col-sm-12"
    });

    var clearfix = $('<div>',{
        class: "clearfix"
    });

    var canvas = $('<canvas>',{
        class: className
    });
    $('.buoy-charts').append(row);
    row.append(buoy_title, graph_container, current_info_container, clearfix);
    graph_container.append(graph_title, graph_description_period, graph_description_height, canvas);
    graph_description_period.append(color_square_period);
    graph_description_height.append(color_square_height);
 }

/********************
 * functionName: create_current_buoy_info
 * @purpose: populates the current buoy info boxes with the current data
 * @param className, readTime, swellHeight, swellPeriod, swellDirection, waterTemp
 * @returns: N/A
 * @globals: N/A
 */

 function create_current_buoy_info(className, readTime, swellHeight, swellPeriod, swellDirection, waterTemp){
    var block_title = $('<h4>',{
        text: "Current buoy reading"
    });
    
    var taken_at = $('<p>',{
        text: "Taken at: " + readTime
    });
    var current_height = $('<p>',{
        text: "Current Height: " + swellHeight + " ft"
    });
    var current_period = $('<p>',{
        text: "Current Period: " + swellPeriod + " seconds"
    });
    var current_swell_direction = $('<p>',{
        text: "Current Swell Direction: " + swellDirection + "°"
    });
    var current_water_temp = $('<p>', {
        text: "Current Water Temp: " + waterTemp + " °F"
    });

    var second_col_select = "." + className + " .col-sm-5";
    $(second_col_select).append(block_title, taken_at, current_height, current_period, current_swell_direction, current_water_temp);
    //Need to select sibiling
 }

/********************
 * functionName: set_canvas_dims
 * @purpose: stops the canvas element from overflowing its container
 * @param: N/A
 * @returns: N/A
 * @globals: N/A
 */

 function set_canvas_dims(){
    console.log('set_canvas_dims');
    $('canvas').css({
        "width":"100%",
        "height": "100%"
    });
 }


/********************
 * Tide related functions and variables.
 *
 */


    //Globals related to the tidal functions
    var tidal_levels = [];
    var tidal_times = [];
    var time_indeces = [];


    /*************************
     * functionName: get_tide_data
     * purpose: this function handles the noaa tidal data that is received by the noaa curl call. It organizes the data into a useable format for chart generation. Is called in doc ready
     * @param: location_id
     * @globals: tidal_levels, tidal_times
     * @return: N/A
     *
     */

    function get_tide_data(location_id) {

        $.ajax({
            url: "data_handlers/noaa_tide_call.php",
            method: "POST",
            dataType: "json",
            data: {
              location_index: location_id
            },
            cache: "false",
            success: function(response){
                console.log(response);
                var x = -1;
                for(var i = 0; i < response.predictions.length; i++){
                    tidal_levels[x] = parseFloat(response.predictions[i].v); //create the tidal levels array
                    x++;
                    tidal_times[x] = "";
                    for(var j = 11; j < 16; j++) {
                        tidal_times[x] += response.predictions[i].t[j]; //create the tidal times array
                    }

                }
                console.log("tidal_levels: " ,tidal_levels);
                console.log("tidal_times: " ,tidal_times);
                find_highs_lows(tidal_levels);
                build_buoy_chart();
                create_mobile_tide_table();
            }

        });
    }

    /**************************
     * functionName: find_highs_lows
     * @purpose: this function finds the high and low values that are returned by the NOAA tide data and therefore the high and low tides of each day. It also creates the data for the tidal chart
     * @param: values
     * @globals: time_indices
     */

    function find_highs_lows(values) {

        var next_index = 0;
        var flag_array = []; //this will store whether the value is an increasing or a decreasing value
        for(var i = 0; i < values.length; i++){ //setting up the indicator array- this will tell us whether its increasing or decreasing
            next_index = i+1;
            var direction = values[i]-values[next_index];
            if(direction > 0) {
                flag_array[i] = "";
                flag_array[i] = "decreasing";
            }
            else if(direction < 0) {
                flag_array[i] = "";
                flag_array[i] = "increasing";
            }

            if(i == values.length-1){ //resetting next index so it will work for the next for loop
                next_index = 0;
            }
        }
        var highs_and_lows = [values[0]]; //this variable will store the refined tidal_levels array which will be used for our data for the tidal chart
        var x_count = 1; //this will serve as the index for the following for loop

        time_indeces[0] = 0;
        for(var i = 1; i < flag_array.length; i++){
            next_index = i+1;
            if(flag_array[i] !== flag_array[next_index]){ //If the current value in the flag array is not equal to the next value
                highs_and_lows[x_count] = "";
                highs_and_lows[x_count] = values[next_index];
                time_indeces[x_count] = next_index;
                x_count++;
            }
        }

        for(var i = 0; i < time_indeces.length; i++){
            tide_data.labels[i] = "";
            tide_data.labels[i] = tidal_times[time_indeces[i]];
        }

        remove_duplicate_data(highs_and_lows,tide_data.labels);
        tide_data.datasets[0].data = highs_and_lows;
        console.log(tide_data.datasets[0].data);
        console.log(tide_data.labels);
    }


    /************************
     * functionName: remove_duplicate_data
     * @purpose: removes duplicate data from our relevant tidal arrays so the chart actually looks correct.
     * @param levels
     * @param times
     */
    function remove_duplicate_data(levels,times) {
        for(var i = 0; i < levels.length; i++){
            if(levels[i]-levels[(i+1)] == 0){
                levels.splice(i,1);
                times.splice(i,1)
            }
        }
    }

    /********************
     * functionName: create_mobile_tide_table
     * @purpose: creates a tide table
     * @param N/A
     * @returns: N/A
     * @globals: N/A
     */

    function create_mobile_tide_table() {
        var table_body = $(".tide-table tbody")
        for(var i = 1; i < tide_data.labels.length-1; i++){
            //create tr for each value in the array
            var table_row = $("<tr>");
            //create td for each value of relevance
            var td_1 = $("<td>").text(tide_data.labels[i]);
            var td_2 = $("<td>").text(tide_data.datasets[0].data[i]);
            //append td to tr
            table_row.append(td_1);
            table_row.append(td_2);
            //append tr to tbody
            table_body.append(table_row);
        }
    }

    /************************
     * This is the data that will be used to build the buoy chart
     *
     */


    var tide_data = {
        labels: [],//this will create the x-axis of the graph
        datasets: [
            {
                label: "My Second dataset",
                fillColor: "rgba(109, 157, 197, .5)",
                strokeColor: "#001011",
                pointColor: "#001011",
                pointStrokeColor: "#fff",
                pointHighlightFill: "#fff",
                pointHighlightStroke: "rgba(151,187,205,1)",
                data: [] //this will create the y-axis of the graph
            }
        ]
    };


    /*************************
     * functionName: build_buoy_chart
     * @purpose: this function builds the buoy chart using the data above.
     * @params: N/A
     * @globals: chart
     * @returns: N/A
    */


    function build_buoy_chart(){
        var my_chart_node = $("#tideChart").get(0);
        var ctx = my_chart_node.getContext("2d");

        var tide_options = {
            ///Boolean - Whether grid lines are shown across the chart
            scaleShowGridLines : true,

            //String - Colour of the grid lines
            scaleGridLineColor : "rgba(0,0,0,.05)",

            //Number - Width of the grid lines
            scaleGridLineWidth : 1,

            //Boolean - Whether to show horizontal lines (except X axis)
            scaleShowHorizontalLines: true,

            //Boolean - Whether to show vertical lines (except Y axis)
            scaleShowVerticalLines: true,

            //Boolean - Whether the line is curved between points
            bezierCurve : true,

            //Number - Tension of the bezier curve between points
            bezierCurveTension : 0.4,

            //Boolean - Whether to show a dot for each point
            pointDot : true,

            //Number - Radius of each point dot in pixels
            pointDotRadius : 4,

            //Number - Pixel width of point dot stroke
            pointDotStrokeWidth : 1,

            //Number - amount extra to add to the radius to cater for hit detection outside the drawn point
            pointHitDetectionRadius : 20,

            //Boolean - Whether to show a stroke for datasets
            datasetStroke : true,

            //Number - Pixel width of dataset stroke
            datasetStrokeWidth : 2,

            //Boolean - Whether to fill the dataset with a colour
            datasetFill : true,

            //String - A legend template
            legendTemplate : "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].strokeColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>"

        };
        
        Chart.defaults.global.responsive = true;
        var myLineChart = new Chart(ctx).Line(tide_data, tide_options);
        console.log(ctx.canvas.width);
    }

/**************
 *
 *End tidal stuff
 */

/****************
 *
 * Single Page Fuctionality
 * The following block of code handles single page functionality and the back/forward buttons. There maybe a better solution to this,
 * but for now this was the best solution I could come up with.
 */

var doc_switch = true;

document.onmouseover = function() {
    doc_switch = true;
};

document.onmouseleave = function() {
    doc_switch = false;
};


var counter = 0;
var current_url = [];

function get_current_url() {
    current_url[counter] = location.search;
    if(counter > 1 && current_url[counter] !== current_url[counter-1]){
        console.log(current_url);
        if(doc_switch == false) {
            location.reload(true);
        }
    }
    if(counter > 100) {
        current_url = [];
        counter = 0;
    }
    counter++;
}

window.setInterval(get_current_url, 100);

/******
 * End Single page functionality
 */

/**********************
 * design related functions.
 *
 */

 function even_height_cols(){
    var col_height = $('.even-col').outerHeight();
    console.log(col_height);
 }


function topPaddingBanners() {
    var navigation_height = $('.header-container').height();
    var topPadding = navigation_height + 40;
    return topPadding;
}

function set_top_padding(element) {
    $(element).css("padding-top", (topPaddingBanners() + "px"));
}

function detect_resize(){
    $( window ).resize(function() {
        set_canvas_dims();
    });
}

detect_resize();

/***************************
 * End design related functions
 */


