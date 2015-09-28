$(document).ready(function(){
    add_contact_info();
    toggle_location_sub_menu('.location-indiv-tab');
    cdip_get_data();
    wunderground_data_call();

   $(".location-sub-menu li a").click(function(){
       console.log('You clicked a location sub-menu item');
       var loc_id = $(this).attr('loc_id');
       pull_relevant_buoy_by_location(loc_id);
       get_tide_data(loc_id);
   });
});

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

/***************************
 * functionName: toggle_location_sub_menu();
 * @purpose: toggles the sub_menus from visible to invisible on click of the locations tab.
 * @param: location_tab
 * @globals: N/A
 * @return: N/A
 */
function toggle_location_sub_menu(location_tab){
    $(location_tab).click(function(){
        var toggle_parent = "#"+this.getAttribute("id");
        var sub_menu = $(toggle_parent + "+ul");
        sub_menu.slideToggle("slow");
    });
}

/***************************
 * functionName: noaa_ajax_call();
 * @purpose: Calls noaa api to obtain buoy data
 * @param:
 * @globals:
 * @return:
 */

function noaa_ajax_call() {
    $.ajax({
        url: "http://www.ncdc.noaa.gov/cdo-web/api/v2/datasets",
        headers:{
          token: "OcJDgFIwRvIxJoMBOrBzoWELwwTrTjzp"
        },
        data:{
            stationid:"COOP:010957"
        },
        method: "GET",
        cache: false,
        dataType: 'json',
        success: function(response) {
           console.log(response);

        }
    });
}

var buoy_array = [];

/***************************
 * functionName: cdip_curl_request();
 * @purpose: calls and then organizes CDIP data into a usable object. There are several functions within this function that handle
 * individual pieces of data. I will comment those as well.
 * @params: N/A
 * @globals: buoy_array
 * @returns: N/A
 */

function cdip_get_data(){
    $.ajax({
        url: "data_handlers/cdip_get_data.php",
        cache: false,
        dataType: 'text',
        success: function(response) {
            var split_by_line = response.split("\n");
            var all_buoy_info = [];
            var buoy_object = function(stationNum, stationNameParam, stationDOM, stationTime, stationPeriod, swellDirection, swellheight, waterTemp){
                this.stationNum = stationNum;
                this.stationName = stationNameParam;
                this.datePST = stationDOM;
                this.readTime = stationTime;
                this.peakPeriod = stationPeriod;
                this.swellDirection = swellDirection;
                this.swellHeight = swellheight;
                this.waterTemp = waterTemp;
            };

            for(var i=3; i < split_by_line.length-4; i++){ //eliminates headers and other unnecessary data
                all_buoy_info.push(split_by_line[i]);
            }

            /********************
             * This for loop constructs the buoy object and inserts it into the buoy_array
             */

            for(var i =0; i < all_buoy_info.length; i++){
                get_station_number(i);
                get_station_name(i);
                get_day_of_month(i);
                get_time_PST(i);
                get_period(i);
                get_swell_direction(i);
                get_swell_height(i);
                get_water_temp(i);
                buoy_array[i] = new buoy_object(get_station_number(i),get_station_name(i), get_day_of_month(i),get_time_PST(i), get_period(i), get_swell_direction(i), get_swell_height(i), get_water_temp(i));
            }

            /********************
             * functionName: get_station_number()
             * @purpose: pulls the stationNumber from the ajax data
             * @param index
             * @returns stationId
             */

            function get_station_number(index){
                var stationId = '';
                for (var i = 0; i <= 2; i++){
                    stationId = stationId + all_buoy_info[index][i];
                }
                return stationId;
            }

            /********************
             * functionName: get_station_name()
             * @purpose: pulls the stationName from the ajax data
             * @param index
             * @returns stationName
             */

            function get_station_name(index){
                var stationName = '';
                for (var i = 4; i <= 29; i++){
                    stationName = stationName + all_buoy_info[index][i];
                }
                return stationName;
            }

            /********************
             * functionName: get_day_of_month()
             * @purpose: pulls the day of month from the ajax data
             * @param index
             * @returns dayOfMonth
             */

            function get_day_of_month(index){
                var dayOfMonth = '';
                for(var i = 30; i<=31; i++){
                    dayOfMonth+=all_buoy_info[index][i];
                }
                return dayOfMonth;
            }

            /********************
             * functionName: get_time_PST()
             * @purpose: pulls the time from the ajax return data
             * @param index
             * @returns time
             */

            function get_time_PST(index){
                var time = '';
                for(var i = 33; i <= 36; i++){
                    time+=all_buoy_info[index][i];
                }
                return time;
            }

            /********************
             * functionName: get_period()
             * @purpose: pulls the peak period data from the ajax data
             * @param index
             * @returns period
             */

            function get_period(index){
                var period='';
                for(var i = 51; i<=52; i++){
                    period+=all_buoy_info[index][i];
                }
                return period;
            }

            /********************
             * functionName: get_swell_direction()
             * @purpose: pulls the peak direction from ajax data
             * @param index
             * @returns direction
             */

            function get_swell_direction(index){
                var direction = '';
                for(var i = 54; i <=56; i++){
                    direction+=all_buoy_info[index][i];
                }
                return direction;
            }

            /********************
             * functionName: get_swell_height
             * @purpose: pulls the swell height from the ajax data
             * @param index
             * @returns height
             */

            function get_swell_height(index){
                var height = '';
                for(var i = 47; i <= 49; i++ ){
                    height+=all_buoy_info[index][i];
                }
                height = (height*0.39370)/12;
                height = height.toFixed(1);
                return height;
            }

            /********************
             * functionName: get_water_temp
             * @purpose: pulls the water temp from the ajax data
             * @param index
             * @returns height
             */

            function get_water_temp(index) {
                var temp = '';
                for(var i = 64; i <= 67; i++){
                    temp+=all_buoy_info[index][i];
                }
                return temp;
            }

            console.log(buoy_array);
            cycle_and_send_buoy_data();
        }
    });
}

function wunderground_data_call(){
    $.ajax({
        url : "data_handlers/weather_data_call.php",
        dataType : "json",
        success : function(response) {
           console.log(response);

        }
    });
}

function cycle_and_send_buoy_data() {
    for(var i = 0; i < buoy_array.length; i++){
        var important_data = {datePST: buoy_array[i].datePST, peakPeriod: buoy_array[i].peakPeriod, readTime: buoy_array[i].readTime, swellHeight: buoy_array[i].swellHeight, swellDirection: buoy_array[i].swellDirection, waterTemp: buoy_array[i].waterTemp};
        $.ajax({
           url: "data_handlers/buoy_data_send.php",
            method: "POST",
            dataType: "text",
            data: {
                stationName: buoy_array[i].stationName,
                stationNum: buoy_array[i].stationNum,
                buoy_data: important_data, //this is an object with all of the other important information
            },
            success: function(response){
                console.log(response);
            }
        });
    }
}

var $content_container = $('#content-container');
function pull_relevant_buoy_by_location(location_id){
    $.ajax({
        url: "data_handlers/default_location_page.php",
        method: "POST",
        dataType: "text",
        data: {
            location_index: location_id
        },
        success: function(response){
            remove_content();
            $content_container.html(response);
            build_buoy_chart();
        }

    });
}


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
            for(var i = 0; i < response.predictions.length; i++){
                console.log(response.predictions[i].t);
                data.labels[i] = "";
                for(var j = 11; j < 16; j++) {
                    console.log(response.predictions[i].t[j]);
                    data.labels[i] += response.predictions[i].t[j];
                }
            }
            console.log(data.labels);
        }

    });
}

function remove_content() {
    $content_container.empty();
}

/************************
 * chart stuff
 *
 */


var data = {
    labels: [],//this creates the x-axis of the graph
    datasets: [
        {
            label: "My Second dataset",
            fillColor: "rgba(151,187,205,0.2)",
            strokeColor: "rgba(151,187,205,1)",
            pointColor: "rgba(151,187,205,1)",
            pointStrokeColor: "#fff",
            pointHighlightFill: "#fff",
            pointHighlightStroke: "rgba(151,187,205,1)",
            data: [1.0,2.0,1.0, 1.6, 1.7,1.8] //this creates the y-axis of the graph
        }
    ]
};

function build_buoy_chart(){
    var my_chart_node = $("#myChart").get(0);
    var ctx = my_chart_node.getContext("2d");

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
    Chart.defaults.global = {
        // Boolean - Whether to animate the chart
        animation: true,

        // Number - Number of animation steps
        animationSteps: 60,

        // String - Animation easing effect
        // Possible effects are:
        // [easeInOutQuart, linear, easeOutBounce, easeInBack, easeInOutQuad,
        //  easeOutQuart, easeOutQuad, easeInOutBounce, easeOutSine, easeInOutCubic,
        //  easeInExpo, easeInOutBack, easeInCirc, easeInOutElastic, easeOutBack,
        //  easeInQuad, easeInOutExpo, easeInQuart, easeOutQuint, easeInOutCirc,
        //  easeInSine, easeOutExpo, easeOutCirc, easeOutCubic, easeInQuint,
        //  easeInElastic, easeInOutSine, easeInOutQuint, easeInBounce,
        //  easeOutElastic, easeInCubic]
        animationEasing: "easeOutQuart",

        // Boolean - If we should show the scale at all
        showScale: true,

        // Boolean - If we want to override with a hard coded scale
        scaleOverride: false,

        // ** Required if scaleOverride is true **
        // Number - The number of steps in a hard coded scale
        scaleSteps: null,
        // Number - The value jump in the hard coded scale
        scaleStepWidth: null,
        // Number - The scale starting value
        scaleStartValue: null,

        // String - Colour of the scale line
        scaleLineColor: "rgba(0,0,0,.1)",

        // Number - Pixel width of the scale line
        scaleLineWidth: 1,

        // Boolean - Whether to show labels on the scale
        scaleShowLabels: true,

        // Interpolated JS string - can access value
        scaleLabel: "<%=value%>",

        // Boolean - Whether the scale should stick to integers, not floats even if drawing space is there
        scaleIntegersOnly: true,

        // Boolean - Whether the scale should start at zero, or an order of magnitude down from the lowest value
        scaleBeginAtZero: false,

        // String - Scale label font declaration for the scale label
        scaleFontFamily: "'Helvetica Neue', 'Helvetica', 'Arial', sans-serif",

        // Number - Scale label font size in pixels
        scaleFontSize: 12,

        // String - Scale label font weight style
        scaleFontStyle: "normal",

        // String - Scale label font colour
        scaleFontColor: "#666",

        // Boolean - whether or not the chart should be responsive and resize when the browser does.
        responsive: false,

        // Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
        maintainAspectRatio: true,

        // Boolean - Determines whether to draw tooltips on the canvas or not
        showTooltips: true,

        // Function - Determines whether to execute the customTooltips function instead of drawing the built in tooltips (See [Advanced - External Tooltips](#advanced-usage-custom-tooltips))
        customTooltips: false,

        // Array - Array of string names to attach tooltip events
        tooltipEvents: ["mousemove", "touchstart", "touchmove"],

        // String - Tooltip background colour
        tooltipFillColor: "rgba(0,0,0,0.8)",

        // String - Tooltip label font declaration for the scale label
        tooltipFontFamily: "'Helvetica Neue', 'Helvetica', 'Arial', sans-serif",

        // Number - Tooltip label font size in pixels
        tooltipFontSize: 14,

        // String - Tooltip font weight style
        tooltipFontStyle: "normal",

        // String - Tooltip label font colour
        tooltipFontColor: "#fff",

        // String - Tooltip title font declaration for the scale label
        tooltipTitleFontFamily: "'Helvetica Neue', 'Helvetica', 'Arial', sans-serif",

        // Number - Tooltip title font size in pixels
        tooltipTitleFontSize: 14,

        // String - Tooltip title font weight style
        tooltipTitleFontStyle: "bold",

        // String - Tooltip title font colour
        tooltipTitleFontColor: "#fff",

        // Number - pixel width of padding around tooltip text
        tooltipYPadding: 6,

        // Number - pixel width of padding around tooltip text
        tooltipXPadding: 6,

        // Number - Size of the caret on the tooltip
        tooltipCaretSize: 8,

        // Number - Pixel radius of the tooltip border
        tooltipCornerRadius: 6,

        // Number - Pixel offset from point x to tooltip edge
        tooltipXOffset: 10,

        // String - Template string for single tooltips
        tooltipTemplate: "<%if (label){%><%=label%>: <%}%><%= value %>",

        // String - Template string for multiple tooltips
        multiTooltipTemplate: "<%= value %>",

        // Function - Will fire on animation progression.
        onAnimationProgress: function(){},

        // Function - Will fire on animation completion.
        onAnimationComplete: function(){}
    };
    Chart.defaults.global.responsive = true;
    var myLineChart = new Chart(ctx).Line(data, options);
}



/**************
 *
 *End chart stuff
 */

function get_current_time(){
    var new_date = new Date();
    var hour = new Date().getHours();
    var minute = new Date().getMinutes();
    return (hour + ":" + minute);
}