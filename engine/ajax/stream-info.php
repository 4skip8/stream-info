<?php
/*=====================================================
 Module Stream-Info for DataLife Engine
-----------------------------------------------------
			NEW AUTHOR: MaD
-----------------------------------------------------
 skype:  	 maddog670
 icq:   	 3216327
-----------------------------------------------------
			OLD AUTHOR: ksyd
-----------------------------------------------------
 icq: 360486149
 skype: tlt.pavel-sergeevich
-----------------------------------------------------
 Copyright (c) 2014
=====================================================
 Данный код защищен авторскими правами
=====================================================
 Файл: /engine/ajax/stream-info.php
-----------------------------------------------------
 Назначение: Выполнение различных функций админпанели и модуля
=====================================================*/
@error_reporting ( E_ALL ^ E_WARNING ^ E_NOTICE );
@ini_set ( 'display_errors', true );
@ini_set ( 'html_errors', false );
@ini_set ( 'error_reporting', E_ALL ^ E_WARNING ^ E_NOTICE );

define( 'DATALIFEENGINE', true);
define( 'ROOT_DIR', substr( dirname(  __FILE__ ), 0, -12 ) );
define( 'ENGINE_DIR', ROOT_DIR . '/engine' );

require_once ENGINE_DIR . '/data/config.php';
header( "Content-type: text/html; charset=" . $config['charset'] );

if ($config['http_home_url'] == "") {
	$config['http_home_url'] = explode("engine/ajax/stream-info.php", $_SERVER['PHP_SELF']);
	$config['http_home_url'] = reset($config['http_home_url']);
	$config['http_home_url'] = "http://".$_SERVER['HTTP_HOST'].$config['http_home_url'];
}

require_once ENGINE_DIR.'/inc/stream-info.fnc.php';
require_once ENGINE_DIR.'/classes/mysql.php';
require_once ENGINE_DIR.'/inc/include/functions.inc.php';
require_once ENGINE_DIR.'/api/api.class.php';

dle_session();

//################# Определение групп пользователей
$user_group = get_vars( "usergroup" );

if( ! $user_group ) {
	$user_group = array ();
	
	$db->query( "SELECT * FROM " . USERPREFIX . "_usergroups ORDER BY id ASC" );
	
	while ( $row = $db->get_row() ) {
		
		$user_group[$row['id']] = array ();
		
		foreach ( $row as $key => $value ) {
			$user_group[$row['id']][$key] = stripslashes($value);
		}
	
	}
	set_vars( "usergroup", $user_group );
	$db->free();
}

require_once ENGINE_DIR.'/modules/sitelogin.php';

if( !$is_logged OR !$user_group[$member_id['user_group']]['allow_admin'] ) { die ("error"); }

$buffer = "";

if ($_REQUEST['action'] == "clearCache") {

	if ( $member_id['user_group'] != 1 ) die ("error");
	
	$dle_api->clean_cache("stream-info");
	$dle_api->clean_cache("stream-info-key");
	$dle_api->clean_cache("stream-info-block");

	$buffer = "<font color=\"green\">Кеш стрима успешно очищен.</font>";

}elseif($_REQUEST['action'] == 'setTitle'){

	$login = totranslit($_POST['login']);
	$error = array();
	$service = $_POST['service'];
	switch ($service){
		case "twitch":
			$titleTW = gettwitch($login, true);
			if ($titleTW['status'] == '404'){
				$setTitle = false;
				$error = array("status" => inv("Данного логина не существует в этом сервисе стримминга. Проверьте правильность веденного логина пользователя."), "code" => 404);
			}else{ 
				$setTitle = $titleTW['status'];
			}
			break;
		case "goodgame":
			$titleGG = setTitleGG($login);			
			if (!$titleGG){
				$setTitle = false;
				$error = array("status" => inv("Данного логина не существует в этом сервисе стримминга. Проверьте правильность веденного логина пользователя."), "code" => 404);
			}else{
				$setTitle = $titleGG['title'];
			}
			break;
		case "cybergame":
			$titleCG = getcybergame($login);
			if (!$titleCG){
				$cgTitle = false;
				$setTitle = false;
				$error = array("status" => inv("Данного логина не существует в этом сервисе стримминга. Проверьте правильность веденного логина пользователя."), "code" => 404);
			}else{
				$setTitle = inv("Играем в игру ").$titleCG['channel_game']. inv(" с пользователем ").$titleCG['channel name'];
			}
			break;
		default:
			$setTitle = false;
			$error = array("status" => inv("Такого сервиса стримминга не существует! Выбирите из списка сервис стримминга!"), "code" => 404);
			break;
	}
	$title = array("title" => $setTitle);
	$json = array_merge($title, $error);
	
	echo json_encode($json);
}

echo $buffer;