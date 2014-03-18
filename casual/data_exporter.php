<?php
require_once 'conf.php';

function main(){
	$tar_keys = get_stat_cache_keys();
	if( empty( $tar_keys ) ){
		return;
	}
	
	foreach ( $tar_keys as $cache_key ){
		$entries = get_stat_cache_entries( $cache_key );
		if( empty( $entries ) ){
			continue;
		}
		
		foreach ( $entries as $entry => $stat_val ){
			dump_data_2_database( $cache_key, $entry, $stat_val );
		}
	}
}
main();




function get_stat_cache_keys(){
	$date_str = '20140208';
	$sys_id = STAT_SYSTEM_CASUAL_GAME;
	$cache_prefix = "STAT_{$date_str}_{$sys_id}";
	
	global $cache_server_conf;
	$redis_svr = new Redis();
	$con_ret = $redis_svr->connect( $cache_server_conf['ip'], $cache_server_conf['port'] );
	if( !$con_ret ){
		return false;
	}
	
	$tar_keys = $redis_svr->keys("{$cache_prefix}*");
	return $tar_keys;
}

function get_stat_cache_entries( $cache_keys ){
	global $cache_server_conf;
	$redis_svr = new Redis();
	$con_ret = $redis_svr->connect( $cache_server_conf['ip'], $cache_server_conf['port'] );
	if( !$con_ret ){
		return false;
	}
	
	$entries = $redis_svr->hGetAll( $cache_keys );
	return $entries;
}

function dump_data_2_database( $cache_key, $cache_entry, $stat_val ){
// 	var_dump( $cache_keys, $cache_entry, $stat_val  );
	$key_part = explode( '_', $cache_key );
	$date_str = $key_part[1];
	$sys_id = intval( $key_part[2] );
	$mod_id = intval( $key_part[3] );
	$act_id = intval( $key_part[4] );
	
	$entry_part = explode( '_', $cache_entry );
	$time_str = $entry_part[0];
	
	$stat_val = floatval( $stat_val );
	
}





