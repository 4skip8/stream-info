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
 ������ ��� ������� ���������� �������
==========================================================
 ����: /engine/modules/stream-info.php
----------------------------------------------------------
 ����������: ����� ����� ������� ���� ������� �� ?do=stream
 ����������: �������� ������ ������������� �����
==========================================================*/

session_start();
define('DATALIFEENGINE', true);
include('engine/api/api.class.php');
include('engine/inc/include/init.php');
include('engine/inc/stream-info.fnc.php');

/*
===================================
	������� ��� ������ �������
===================================
*/
function openhtml($title) {
	echo<<<HTML
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>{$title}</title>
	<link rel="stylesheet" href="http://necolas.github.io/normalize.css/2.1.3/normalize.css">
	<style>
	/* ���� */
	* {
		margin: 0 auto;
		padding: 0;
		font-family: 'Arial', regular;
	}

	body {
		width: 100%;
		min-width: 1200px;
		background: #F1F1F1;
	}
	/* ���� ����� */

	/* ����� */
	header {
		width: 100%;
		height: 50px;
		background: #6DB5E5;
	}

	.header-content {
		width: 1200px;
		height: 50px;
	}

	.header-content h1 {
		display: inline;
		position: relative;
		top: 10px;
		font-size: 18pt;
		color: #FFFFFF;
	}
	/* ����� ����� */

	/* ������� */
	.content {
		width: 530px;
		background: #FFFFFF;
		border-radius: 10px;
		border: 1px solid #D4D4D4;
		padding-left: 10px;
		padding-top: 20px;
		padding-bottom: 20px;
		margin-top: 50px;
	}

	.content h1 {
		font-size: 18pt;
		color: #6DB5E5;
		padding: 0;
		margin: 0;
	}

	.text-input {
		width: 350px;
		height: 25px;
		margin-top: 10px;
	}

	.submit-input {
		width: 150px;
		height: 29px;
		background: #6DB5E5;
		color: #FFFFFF;
	}

	.textarea-class {
		width: 520px;
		height: 150px;
		resize: none;
		color: #000000;
	}
	/* �������� ����� */
	</style>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
</head>
<body>
	<header>
		<div class="header-content">
			<h1>��������� ������ STREAM-INFO</h1>
		</div>
	</header>
HTML;
}

function closehtml() {
	echo<<<HTML
</body>
</html>
HTML;
}

/*
===================================
		���� ���������
===================================
*/

## �������� ���������
if(file_exists("stream_data")) {
	openhtml("������ ��� ����������");
echo<<<HTML
	<section class="content">
		<h1>������</h1>
		<p>������ ��� ����������.</p>
		<p>���� �� ���������� �������������, ������� ���� <b>stream_data</b>.</p>
HTML;
	closehtml();
	exit();
}

## �������� ����������� � ������
if(!$_COOKIE['dle_user_id']) {
	openhtml("������");
	echo<<<HTML
	<section class="content">
		<h1>������</h1>
		<p>��� ��������� ��� ���������� ���� ��������������!</p>
	</section>
HTML;
	closehtml();
	exit();
} else {
	$user = $dle_api->take_user_by_id($_COOKIE['dle_user_id']);
	if($user['user_group'] != "1") {
		openhtml("������");
		echo<<<HTML
	<section class="content">
		<h1>������</h1>
		<p>�������� ������ ��� ��������������.</p>
	</section>
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
		$installadm = $dle_api->install_admin_module('stream-info', 'Stream-Info', '����� ������ ���������� �� ����.', 'stream-info.png', 1);
		
		if(!$installdb OR !$installadm) {
			openhtml("������");
			echo<<<HTML
	<section class="content">
		<form action="" method="POST">
			<h1>������</h1>
			<p>�� ������� ���������� ������. �������� ��� �������� ������ � ��.</p>
			<input type="hidden" name="action" value="">
			<div align="center"><br /><input type="submit" class="submit-input" value="� ������"></div>
		</form>
	</section>
HTML;
			closehtml();
			exit();
		}
		
		openhtml("��������� ������");
		echo<<<HTML
	<section class="content">
		<form action="" method="POST">
			<h1>�� � ��</h1>
			<p>v ������� � �� �������</p>
			<p>v ������ �������� � ��</p>
			<input type="hidden" name="action" value="components">
			<div align="center"><br /><input type="submit" class="submit-input" value="�����"></div>
		</form>
	</section>
HTML;
		closehtml();
		exit();
	} elseif($action == 'components') {
		openhtml("���������� ���� � DLE");
		echo<<<HTML
	<section class="content">
		<form action="" method="POST">
			<h1>����������� �����������</h1>
			<textarea class="textarea-class" disabled>1. � engine/engine.php �����:
case "pm" :
	include ENGINE_DIR . '/modules/pm.php';
	break;

��������:
case "stream-info" :
	include ENGINE_DIR.'/modules/stream-info.php';
	break;
	
2. � engine/engine.php �����:
elseif (\$do == 'tags') \$nam_e = stripslashes(\$tag);

��������:
elseif (\$do == 'stream-info') \$nam_e = \$stream_page_title;

3. � index.php �����:
require_once ROOT_DIR . '/engine/init.php';

��������:
require_once ENGINE_DIR.'/modules/stream-info-main.php';

4. � index.php �����:
\$tpl->set ( '{speedbar}', \$tpl->result['speedbar'] );

��������:
\$tpl->set ( '{stream-info}', \$tpl->result['streams'] );

����� ������������ ��� � ������ Stream-Info, � ����� ".htaccess" �����:
RewriteRule ^page/([0-9]+)(/?)$ index.php?cstart=$1 [L]

��������:
# Stream-Info
RewriteRule ^stream(/?)+$ index.php?do=stream-info [L]
RewriteRule ^stream/([^/]*)(/?)+$ index.php?do=stream-info&stream=$1 [L]
			</textarea>
			<input type="hidden" name="action" value="end">
			<div align="center"><br /><input type="submit" class="submit-input" value="�����"></div>
		</form>
	</section>
HTML;
		closehtml();
		exit();
	} elseif($action == 'end') {
		openhtml("��������� ���������");
		echo<<<HTML
	<section class="content">
		<h1>�����</h1>
		<p>������ ������� ����������!</p>
		<p style="color:red;">������� ���� stream-install.php</p>
	</section>
HTML;
		closehtml();
		$installfile = "stream_data";
		$fileopen = fopen($installfile, "w");
		fwrite($fileopen, date('l jS \of F Y h:i:s A'));
		fclose($fileopen);
		exit();
	}
}

$_SESSION['sinstall'] = TRUE;
openhtml("��������� ������ STREAM-INFO");
echo<<<HTML
	<section class="content">
		<form action="" method="POST">
			<h1>���������</h1>
			<p>������� �� ������ ����� ��� ������ ��������� ������.</p>
			<p>
			<input type="hidden" name="action" value="install">
			<input type="submit" class="submit-input" value="�����">
			</p>
		</form>
	</section>
HTML;
closehtml();
?>