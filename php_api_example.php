<?php

// February 07, 2019

// This proof-of-concept has two objectives:
// 1) demonstrates use of the PHP Agent API
// 2) customer trouble reproduction/investigation tool


// SLOW sample functions
function fone() {
	sleep(5);
}
function ftwo() {
	sleep(5);
}

// RUM: Real User Monitoring

////////////////////////////
//// START OF RUM BLOCK ////
////////////////////////////

//// HEADER
if( extension_loaded('newrelic')) { echo newrelic_get_browser_timing_header(); }

//// Set your application name here.
//// WARNING: This will OVERRIDE the name you set when
//// the agent was installed.
if( extension_loaded('newrelic')) { newrelic_set_appname("PHP Application"); }


//// This will cause reporting this script/application as non-web in NR Dashboard
if( extension_loaded('newrelic')) { newrelic_background_job(); }

	////////////////////////////////////////
	//// START OF TRANSACTION SASQUATCH ////
	////////////////////////////////////////

	//// You can set your own Transaction Name
	//// WARNING: It is highly recommended you set your own name.
	//// otherwise transaction names get reported with the 
	//// script's full path:
	//// (i.e. /home/user/project_folder/script.php) 
	if( extension_loaded('newrelic')) { newrelic_name_transaction("/sasquatch"); }

	//// Trace those slow functions in your app.
	if( extension_loaded('newrelic')) { newrelic_add_custom_tracer("fone"); }
	if( extension_loaded('newrelic')) { newrelic_add_custom_tracer("ftwo"); }

	//// Report Custom Metrics
	//// Custom metrics can be reported every minute or so. They
	//// are normally calculations done in long periods of time.
	//// This example below lets you test custom event:
	//// (Custom/thingy/%) in NR Dashboard:
	if( extension_loaded('newrelic')) { newrelic_custom_metric("Custom/thingy/1",4000); }
	if( extension_loaded('newrelic')) { newrelic_custom_metric("Custom/thingy/2",2300); }

	// Custom parameters show up in two places:
	// 1) traces (error/transaction)
	// 2) insights transaction events
	if( extension_loaded('newrelic')) { newrelic_add_custom_parameter ("hi", "mom"); }

	//// Most common payload
	phpinfo();

	//// ATTENTION
	//// All PHP Errors are reported to New Relic.
	//// Make sure they get triggered within a RUM header/footer.
	//// Otherwise they won't be properly formatted and 
	//// will not show nice in New Relic's Dashboard.

	//// This random error (triggered 5% of the time)
	//// is caused on purpose and will be reported to NR.
	if(rand(1,100) > 95) {
	  trigger_error("Random error",E_USER_ERROR);
	}

	//// This random error gets reported too.
	//// However, it will be reported as "NoticedError".
	if(rand(1,100) > 95) {
	  newrelic_notice_error("NR Notice Error");
	}

	//// These functions are traced when they get executed.
	call_user_func("fone");
	ftwo();

	//////////////////////////////////////
	//// END OF TRANSACTION SASQUATCH ////
	//////////////////////////////////////

//// if autoinstrumentation is off && page got header & is eligible, this will generate the necessary RUM footer,  otherwise not. To make sure:
if( extension_loaded('newrelic')) { echo newrelic_get_browser_timing_footer(); }

///////////////////////////
//// END OF RUM BLOCK /////
///////////////////////////


?>

