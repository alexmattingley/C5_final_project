$(document).ready(function(){
    add_contact_info();
    toggle_location_sub_menu('.location-indiv-tab');
    cdip_get_data();
    wunderground_data_call();


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
            var buoy_object = function(stationNum, stationNameParam, stationDOM, stationTime, stationPeriod, swelldirection, swellheight){
                this.stationNum = stationNum;
                this.stationName = stationNameParam;
                this.datePST = stationDOM;
                this.readTime = stationTime;
                this.peakPeriod = stationPeriod;
                this.swelldirection = swelldirection;
                this.swellHeight = swellheight;
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
                buoy_array[i] = new buoy_object(get_station_number(i),get_station_name(i), get_day_of_month(i),get_time_PST(i), get_period(i), get_swell_direction(i), get_swell_height(i));
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

            console.log(buoy_array);

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





function get_current_time(){
    var new_date = new Date();
    var hour = new Date().getHours();
    var minute = new Date().getMinutes();
    return (hour + ":" + minute);
}