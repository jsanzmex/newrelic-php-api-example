<?php

// February 07, 2019

// This proof-of-concept has two objectives:
// 1) demonstrates use of the PHP Agent API
// 2) customer trouble reproduction/investigation tool


// SLOW sample functions
function fthree() {
	sleep(1);
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

	//////////////////////////////////////
	//// START OF TRANSACTION BIGFOOT ////
	//////////////////////////////////////

	//// Set Transaction Name
	if( extension_loaded('newrelic')) { newrelic_name_transaction("/bigfoot"); }

	//// Trace those slow functions in your app.
	if( extension_loaded('newrelic')) { newrelic_add_custom_tracer("fthree"); }
	
	// Custom parameters (key-value pairs) show up in two places:
	// 1) traces (error/transaction)
	// 2) insights transaction events
	if( extension_loaded('newrelic')) { newrelic_add_custom_parameter ("hello", "world"); }

	//// Echo a different payload
	echo "Second transaction payload.";

	//// This random error (triggered 2% of the time)
	//// is caused on purpose and will be reported to NR.
	if(rand(1,100) > 98) {
	  trigger_error("Bigfoot Random error",E_USER_ERROR);
	}

	//// This function is traced 
	fthree();

	////////////////////////////////////
	//// END OF TRANSACTION BIGFOOT ////
	////////////////////////////////////

//// if autoinstrumentation is off && page got header & is eligible, this will generate the necessary RUM footer,  otherwise not. To make sure:
echo newrelic_get_browser_timing_footer();

///////////////////////////
//// END OF RUM BLOCK /////
///////////////////////////


?>
