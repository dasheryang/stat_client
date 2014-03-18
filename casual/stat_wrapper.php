<?php
require_once '../stat_client.php';

require_once 'conf.php';

class CasualStatWrapper{	
	public function user_action( $uri ){
		$sys_id = STAT_SYSTEM_CASUAL_GAME;
		$mod_id = STAT_CASULT_MOD_SDK;
		$act_id = STAT_CASULT_ACT_ACCESS;
		
		$hash_key = $this->_get_hash_key( $sys_id, $mod_id, $act_id );
		
		$hash_entry = $this->_get_hash_entry( $con = array( $uri ) );
		
		$ret = $this->_send_stat($hash_key, $hash_entry, $inc_value = 1);
		return $ret;
	}
	
	
	
	
	private function _get_hash_key( $sys_id, $mod_id, $act_id ){
		$date_str = "STAT_" . date( 'Ymd' );
		$hash_key = "{$date_str}_{$sys_id}_{$mod_id}_{$act_id}";
		return $hash_key;
	}
	
	private function _get_hash_entry( $condation_set ){
		$hash_entry = '';
		$hash_entry .= date('Hi');
		if( empty( $condation_set ) ){
			return $hash_entry;
		}
		
		foreach( $condation_set as $con_str ){
			$tar_con_str = str_replace( '_', '', $con_str );
			$hash_entry .= "_{$tar_con_str}";
		}
		return $hash_entry;
	}
	
	private function _send_stat( $hash_key, $hash_entry, $inc_value ){
		global $stat_server_conf;
		
		$client = new StatClient( $stat_server_conf['ip'], $stat_server_conf['port'] );
		
		$send_result = $client->send( $hash_key, $hash_entry, $inc_value );
		return $send_result;
	}
}