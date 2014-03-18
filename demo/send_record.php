<?php

require_once '../stat_client.php';
function main(){
// 	$client = new StatClient( '192.168.0.29', 9300 );
// 	$str_message = $client->send( 'th', 'te', 1.11 );

// 	echo "$str_message\n";

	test_casual();
}
main();

function test_casual(){
	require_once '../casual/stat_wrapper.php';
	$stat_wrapper = new CasualStatWrapper();
	
	$ret = $stat_wrapper->user_action( '/app/init' );
	var_dump( $ret );
}


