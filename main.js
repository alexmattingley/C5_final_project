$(document).ready(function(){
    add_contact_info();
    toggle_location_sub_menu('.location-indiv-tab');
    //noaa_ajax_call();
    cdip_curl_request();

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

var buoy_static = {};

function cdip_curl_request(){
    $.ajax({
        url: "data_handlers/cdip_curl_request.php",
        cache: false,
        dataType: 'text',
        success: function(response) {
            var split_by_line = response.split("\n");
            var all_buoy_info = [];
            for(var i=3; i < split_by_line.length-4; i++){ //eliminates headers and other unnecessary data
                all_buoy_info.push(split_by_line[i]);
            }
            //console.log(all_buoy_info); //so this each line of the table.
            for(var i = 0; i < all_buoy_info[0].length; i++){ //this loops through the individual
                var index_indentifier_object = {};
                index_indentifier_object[i] = all_buoy_info[0][i];
                //console.log("index_indetifier_object" , index_indentifier_object); //this prints out each indiv character with an assoc number
                //station #: 0-3
                //station name: 4-29
                //DOM PST: 30-31
                //Time PST: 33-36
                //Peak Period(TP): 51-52
                //Peak Direction(DP): 55-56
                //wave-heigh(Meters)t: 47-49
            }

            function get_station_number(){
                var stationId = '';
                for (var i = 0; i < 3; i++){
                    stationId = stationId + all_buoy_info[0][i];
                }
                return stationId;
            }

            function get_station_name(){
                var stationName = '';
                for (var i = 4; i < 29; i++){
                    stationName = stationName + all_buoy_info[0][i];
                }
                return stationName;
            }


            var buoy_object = function(stationNum, stationNameParam){
                this.stationNum = stationNum;
                this.stationName = stationNameParam;
            };

            var buoy_guam = new buoy_object(get_station_number(),get_station_name());
            console.log(buoy_guam);



            //for(var i = 0; i <= 234; i++){
            //    //console.log(response[i]);
            //    var buoy_object = {};
            //    buoy_object[i] = response[i];
            //    console.log(buoy_object);
            //
            //}
        }
    });
}