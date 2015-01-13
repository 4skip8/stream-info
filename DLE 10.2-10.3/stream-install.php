<?php
/*========================================================
 Module Stream-Info for DataLife Engine
----------------------------------------------------------
			NEW AUTHOR: MaD
----------------------------------------------------------
 skype:  	 maddog670
 icq:   	 3216327
----------------------------------------------------------
			OLD AUTHOR: ksyd
----------------------------------------------------------
 icq: 360486149
 skype: tlt.pavel-sergeevich
----------------------------------------------------------
 Copyright (c) 2014
==========================================================
 Äàííûé êîä çàùèùåí àâòîðñêèìè ïðàâàìè
==========================================================
 Ôàéë: stream-install.php
----------------------------------------------------------
 Íàçíà÷åíèå: Óñòàíîâùèê ìîäóëÿ
==========================================================*/

@error_reporting ( E_ALL ^ E_WARNING ^ E_NOTICE );
@ini_set ( 'display_errors', true );
@ini_set ( 'html_errors', false );
@ini_set ( 'error_reporting', E_ALL ^ E_WARNING ^ E_NOTICE );

session_start();

define( 'ROOT_DIR', '.' );
define( 'ENGINE_DIR', './engine' );

require_once(ENGINE_DIR. '/api/api.class.php');
require_once(ENGINE_DIR. '/inc/include/init.php');
require_once(ENGINE_DIR. '/inc/stream-info.fnc.php');

/*===================================
	Ôóíêöèè äëÿ âûçîâà øàáëîíà
===================================*/
function openhtml($title) {
	echo<<<HTML
<!DOCTYPE html>
<html>
<head>
	<meta charset="{$config['charset']}">
	<title>{$title}</title>
	<link href='http://fonts.googleapis.com/css?family=Open+Sans+Condensed:300&subset=cyrillic' rel='stylesheet' type='text/css'>
	<style>*{margin:0 auto;padding:0;font-family: 'Open Sans Condensed', sans-serif;font-size:16px;}body{width:100%;background:#F1F1F1}header{width:100%;height:50px;background:#6DB5E5}.header-content{margin-left:20px;height:50px}.header-content h1{display:inline;position:relative;top:10px;font-size:18pt;color:#FFF}.content{width:530px;background:#FFF;border-radius:10px;border:1px solid #D4D4D4;padding-left:10px;padding-top:20px;padding-bottom:20px;margin-top:50px}.content h1{font-size:18pt;color:#6DB5E5;padding:0;margin:0}.text-input{width:350px;height:25px;margin-top:10px}.submit-input{margin-top: 10px;border:0;width:150px;height:29px;background:#6DB5E5;color:#FFF}.submit-input:hover{background:#639CBE;}.textarea-class{width:520px;height:450px;resize:none;color:#000}</style>
</head>
<body>
	<header>
		<div class="header-content">
			<h1>Óñòàíîâêà ìîäóëÿ STREAM-INFO</h1>
		</div>
	</header>
	<section class="content">
HTML;
}
function closehtml() {
	echo<<<HTML
	</section>
</body>
</html>
HTML;
}

$code = '1. Â engine/engine.php ïîñëå:
case "pm" :
	include ENGINE_DIR . \'/modules/pm.php\';
	break;

1.1 Âñòàâèòü:
case "stream-info" :
	include ENGINE_DIR.\'/modules/stream-info.php\';
	break;
	
2. Â engine/engine.php ïîñëå:
elseif ($do == \'tags\') $nam_e = stripslashes($tag);

2.1 Âñòàâèòü:
elseif ($do == \'stream-info\') $nam_e = $stream_tpage;

3. Â index.php ïîñëå:
require_once ROOT_DIR . \'/engine/init.php\';

3.1 Âñòàâèòü:
require_once ENGINE_DIR.\'/modules/stream-info-main.php\';

4. Â index.php ïîñëå:
$tpl->set ( \'{speedbar}\', $tpl->result[\'speedbar\'] );

4.1 Âñòàâèòü:
if( $tpl->result[\'streams\'] != \"\" && $do != \"stream-info\") {
    $tpl->set ( \'[stream-info]\', "" );
    $tpl->set ( \'{stream-info}\', $tpl->result[\'streams\'] );
    $tpl->set ( \'[/stream-info]\', "" );
} else {
    $tpl->set_block ( "\'\\[stream-info\\](.*?)\\[/stream-info\\]\'si", "" );
}

5.×òîáû èñïîëüçîâàòü ×ÏÓ â ìîäóëå Stream-Info, â ôàéëå ".htaccess" ïîñëå:
RewriteRule ^page/([0-9]+)(/?)$ index.php?cstart=$1 [L]

5.1 Âñòàâèòü:
# Stream-Info
RewriteRule ^stream(/?)+$ index.php?do=stream-info [L]
RewriteRule ^stream/([^/]*)(/?)+$ index.php?do=stream-info&stream=$1 [L]';

/*===================================
		Ñàìà óñòàíîâêà
===================================*/
## Ïðîâåðêà óñòàíîâêè

if(file_exists(ENGINE_DIR. '/data/stream_config.php')) {
	openhtml("Ìîäóëü óæå óñòàíîâëåí");
echo<<<HTML
		<h1>Îøèáêà</h1>
		<p>Ìîäóëü óæå óñòàíîâëåí.</p>
		<p>Åñëè âû ñîâåðøàåòå ïåðåóñòàíîâêó, óäàëèòå ôàéë <b>stream_config.php</b>.</p>
HTML;
	closehtml();
	exit();
}
## Ïðîâåðêà àâòîðèçàöèè è ãðóïïû
if(!$_COOKIE['dle_user_id']) {
	openhtml("Îøèáêà");
	echo<<<HTML
		<h1>Îøèáêà</h1>
		<p>Äëÿ óñòàíîâêè âàì íåîáõîäèìî áûòü àâòîðèçîâàííûì!</p>
HTML;
	closehtml();
	exit();
} else {
	$user = $dle_api->take_user_by_id($_COOKIE['dle_user_id']);
	if($user['user_group'] != "1") {
		openhtml("Îøèáêà");
		echo<<<HTML
		<h1>Îøèáêà</h1>
		<p>Äîñòóïíî òîëüêî äëÿ àäìèíèñòðàòîðà.</p>
HTML;
		closehtml();
		exit();
	}
}
$action = $_REQUEST['action'];
if($_SESSION['sinstall']) {
	if($action == 'install') {
		$dbquery = $db->query("SHOW TABLES LIKE '" . PREFIX . "_streams'");
		
		if($dbquery->num_rows >= 1) {
			$table = "ALTER TABLE " . PREFIX . "_streams ADD `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP";
		} else {
		$table = "CREATE TABLE IF NOT EXISTS `" . PREFIX . "_streams` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `title` varchar(100) NOT NULL,
 `service` varchar(100) NOT NULL,
 `login` varchar(100) NOT NULL,
 `description` text NOT NULL,
 `pic` text NOT NULL,
 `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
 PRIMARY KEY (`id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */ AUTO_INCREMENT=1 ;";
}
		$installdb = $db->query($table);
		$installadm = $dle_api->install_admin_module('stream-info', 'Stream-Info', 'Âûâîä ïðÿìûõ òðàíñëÿöèé íà ñàéò.', 'stream-info.png', 1);
		$installdb = true;
		$installadm = true;
		if(!$installdb OR !$installadm) {
			openhtml("Îøèáêà");
			echo<<<HTML
		<form action="" method="POST">
			<h1>Îøèáêà</h1>
			<p>Íå óäàëîñü óñòàíîâèòü ìîäóëü. Ïðîáëåìà ïðè çàãðóçêå òàáëèöû â ÁÄ.</p>
			<input type="hidden" name="action" value="">
			<div align="center"><br /><input type="submit" class="submit-input" value="Â íà÷àëî"></div>
		</form>
HTML;
			closehtml();
			exit();
		}
		
		openhtml("Óñòàíîâêà ìîäóëÿ");
		echo<<<HTML
		<form action="" method="POST">
			<h1>ÁÄ è ÏÓ</h1>
			<p>v Òàáëèöà â ÁÄ ñîçäàíà</p>
			<p>v Ìîäóëü äîáàâëåí â ÏÓ</p>
			<input type="hidden" name="action" value="components">
			<div align="center"><br /><input type="submit" class="submit-input" value="Äàëåå"></div>
		</form>
HTML;
		closehtml();
		exit();
	} elseif($action == 'components') {
		openhtml("Äîáàâëåíèå êîäà â DLE");
		echo<<<HTML
		<form action="" method="POST">
			<h1>Ïîäêëþ÷åíèå êîìïîíåíòîâ</h1>
			<textarea class="textarea-class" disabled>{$code}</textarea>
			<input type="hidden" name="action" value="end">
			<div align="center"><br /><input type="submit" class="submit-input" value="Äàëåå"></div>
		</form>
HTML;
		closehtml();
		exit();
	} elseif($action == 'end') {
		openhtml("Óñòàíîâêà çàâåðøåíà");
		echo<<<HTML
		<h1>Óñòàíîâêà çàâåðøåíà</h1>
		<p>Ìîäóëü óñïåøíî óñòàíîâëåí!</p>
		<form action="" method="POST">
			<input type="hidden" name="action" value="delete">
			<input type="submit" class="submit-input" value="Óäàëèòü óñòàíîâùèê">
		</form>		
HTML;
		closehtml();
		$config = array();
		$configfile = ENGINE_DIR . '/data/stream_config.php';
		$cfg = fopen($configfile, "w+" );
		$config['allow_stream'] = (VERSIONID < '10.2') ? "yes": "1";
		$config['showplayer'] = (VERSIONID < '10.2') ? "no": "0";
		$config['cache_allow'] = (VERSIONID < '10.2') ? "yes": "1";;
		$config['cachelife'] = "60";
		$config['blocklimit'] = "5";
		$config['width'] = "640";
		$config['height'] = "480";
		$config['online'] = "Online";
		$config['offline'] = "Offline";
		$config['zagluska'] = "Ïîëüçîâàòåëü íå ñòðèììèò â äàííûé ìîìåíò";
		$config['stream_title'] = "Òðàíñëÿöèè by MaD";
		$config['stream_desc'] = "Çäåñü ìîæíî ïîñìîòðåòü òðàíñëÿöèè";
		$config['stream_keywords'] = "òðàíñëÿöèè, by mad";
		$contents = "<?php\n \$stream_config = " . var_export( $config, true ) . ";\n?>";
		@fwrite($cfg, $contents);
		@fclose($cfg);
		exit();
	}elseif($action == 'delete'){
	unlink('stream-install.php');
	openhtml("Óñòàíîâêà çàâåðøåíà");
	echo <<<HTML
	<h1>Êîíåö</h1>
	<p>Óñòàíîâùèê óäàëåí</p>
HTML;
	closehtml();
	exit();
	}
}

$_SESSION['sinstall'] = TRUE;
openhtml("Óñòàíîâêà ìîäóëÿ STREAM-INFO");
echo<<<HTML
<form action="" method="POST">
	<h1>Óñòàíîâêà</h1>
	<p>Íàæìèòå íà êíîïêó äàëåå äëÿ íà÷àëà óñòàíîâêè ìîäóëÿ.</p>
	<p>
	<input type="hidden" name="action" value="install">
	<input type="submit" class="submit-input" value="Äàëåå">
	</p>
</form>
HTML;
closehtml();
