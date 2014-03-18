<?php
require_once('protobuf/message/pb_message.php');

class StatClient{
	private $_ip;
	private $_port;
	
	public function __construct( $ip, $port ){
		$this->_ip = $ip;
		$this->_port = $port;
	}
	
	public function send( $hash_key, $hash_entry, $inc_value ){
		$sock = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);
		
		$message_buf_obj = new StatMessageProto();
		
		$message_buf_obj->set_hash_key( $hash_key );
		$message_buf_obj->set_hash_entry( $hash_entry );
		$message_buf_obj->set_hash_inc_value( $inc_value );
		
		$buf_string = $message_buf_obj->SerializeToString();
		
		$len = strlen( $buf_string );
		socket_sendto( $sock, $buf_string, $len, 0, $this->_ip, $this->_port ) ;
		socket_close($sock);
		
		return true;
	}
}

class StatMessageProto extends PBMessage
{
	public function __construct( $reader=null )
	{
		parent::__construct( $reader );
		$this->fields["1"] = "PBString";
		$this->_set_value("1", 'default');
		
		$this->fields["2"] = "PBString";
		$this->_set_value("2", 'default');
		
		$this->fields["3"] = "PBString";
		$this->_set_value("3", '1.0');
		return;
	}
	
	public function set_hash_key( $hash_key ){
		$this->_set_value("1", $hash_key);
	}
	
	public function set_hash_entry( $hash_entry ){
		$this->_set_value("2", $hash_entry);
	}
	
	public function set_hash_inc_value( $value ){
		$float_val = floatval( $value );
		$this->_set_value("3", $float_val );
	}
}
