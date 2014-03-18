<?php
require_once '../system_resource.php';
require_once 'mod_act_resource.php';

define('SERVER_DEPLOY_TYPE_DEVELOP',	'dev');	//开发环境
define('SERVER_DEPLOY_TYPE_RELEASE',	'rel');	//开发环境

$server_deploy_type = get_cfg_var( 'server_deploy_type' );
//默认加载生产环境配置
if( empty( $server_deploy_type ) ){
	$server_deploy_type = SERVER_DEPLOY_TYPE_RELEASE;
}
if( SERVER_DEPLOY_TYPE_DEVELOP == $server_deploy_type ){
	require_once 'conf_dev.php';
}else{
	require_once 'conf_rel.php';
}

