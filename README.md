# C5_final_project // Green Room Hunter
As a surfer I am always looking at raw data about wind and waves in order to make an informed decision about where I will surf on any given day. If you take a look at the websites that are out there now that cater to surfers, the focus is really on the analysis of raw data and telling people what they should or shouldn’t think with only a little bit of access to raw data and information. This ultimately leads to inaccuracies in forecasting which create all sorts of problems.

The purpose of this site is to bring pertinent raw data for surfers all into a single application. A given person will be able to log into the site and see a set of data that is relevant to the location that they live in, and then they will eventually be able to customize that data to be relevant to their interests. This will allow surfers to make better decisions about where and when to surf.

##Site Challenges and fun problems

Although simple, creating this website presented a number of challenges and fun problems that needed to be worked through, most of which had to do with data handling.

As you can imagine, most of the data that is being used for this site is coming from websites outside of this one. I do not have the capital, nor do I have the desire to set up dozens
of data points throughout the state of California. This means that I need to pull data from external sources and I often needed to work with data limits or data which was formatted for other
uses. I think one of my favorite moments from the project was learning about how to work with the buoy data. In its rawest form, the data from CDIP was simply a text file which was organized
into a table with only pre tags to delineate the table structure. This meant that I needed to figure out how effectively parse the data into usable pieces. I really enjoyed writing the
cdip_get_data function, which organized all of the data into an object which then can be easily parsed and used on different pages.

Pulling weather data from Wunderground was challenging as well, namely because Wunderground has ajax call limits. It was here that I learned about cron jobs, which allow you to activate a
file periodically in order to perform a certain task. Every 2-3 minutes the cron job calls a file which then makes a call for one data point in California. The data point which is called
is determined by which data point was last updated. It was really cool learning all about managing databases as well as about data handling.

Lastly, the creation of the tide charts and buoy charts were a fun challenge as well. I had never worked with a plugin like chartjs before, so it was fun getting to work with a plugin built by someone else.
The data that was being returned to me by NOAA was also very very dense and difficult to work with. The find_highs_low as well as the remove_duplicate_data function are responsible for
simplifying the tidal data into just high and low tide points. I also realized quickly that although the tide chart looks very pretty in mobile, it doesn't really work properly at the
smallest screen sizes, hence the tide table in mobile.


##Site Languages and Skills Used

HTML & CSS

Javascript, Jquery, AJAX, SOAP, OOP

PHP, Curl requests, MySQL, PhpMyAdmin, MAMP, AWS(server), Ubuntu, Cron Job

Git & Github


##Scope

###v1.0 (finished 11/2/2015)

Site displays realtime buoy, tide, wind, water temperature,  and weather information for major surfing areas in southern California, including San Diego, Orange County, Los Angeles County, Ventura County, Santa Barbara County.

Site is entirely mobile first, one of the biggest pitfalls of modern surfing sites, is the lack of accessibility on a phone.

Detailed explanations of how how certain conditions effect certain areas. I want the site to be educational for people who are new the sport.

###v1.2 (Finished 3/22/16)

In addition to having current data, we now also have data from the past 24 hours which is populating into graphs. This gives the user a general trend as to what has been happening in their area. This is sort of an intermediarity step that will eventually allow me to get to v1.5.

###v1.5

A surfer would be able to create an account and then customize the data that he or she sees to make it relevant to their specific location.

The ability to log information from a given day and time. This information would stay in your account and be private to you. It would allow you to reference that information in the future so you could make informed decisions on where to surf on a given day.

###v2.0

Allow a user to set up a text message or email alert if certain conditions are met. So basically a user could select that they want to receive a text message at 6:00 am (or any time for that matter) if the conditions are what they need to be, saving the hassle of getting up in the morning and checking six different web sites for the information that they are looking for.

###V2.5

Increase accuracy of buoy information to include swell breakdowns. Increase the number of locations to encompass Central and Northern California.

######See Issues for known issues and future revisions on this project
