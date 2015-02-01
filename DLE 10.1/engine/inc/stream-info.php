<?php
/*==================================================
 Module Stream-Info for DataLife Engine
----------------------------------------------------
			NEW AUTHOR: MaD
----------------------------------------------------
 skype: maddog670
 icq:	3216327
----------------------------------------------------
			OLD AUTHOR: ksyd
----------------------------------------------------
 icq: 360486149
 skype: tlt.pavel-sergeevich
----------------------------------------------------
 Copyright (c) 2014
====================================================
 ������ ��� ������� ���������� �������
====================================================
 ����: /engine/inc/stream-info.php
----------------------------------------------------
 ����������: �������� ������� ����������� � ���������
==================================================*/
if( !defined( 'DATALIFEENGINE' ) OR !defined( 'LOGGED_IN' ) OR $member_id['user_group'] != 1 ) {
	die( "Hacking attempt!" );
}

@error_reporting ( E_ALL ^ E_WARNING ^ E_NOTICE );
@ini_set ( 'display_errors', true );
@ini_set ( 'html_errors', false );
@ini_set ( 'error_reporting', E_ALL ^ E_WARNING ^ E_NOTICE );

require_once(ENGINE_DIR.'/inc/stream-info.fnc.php');
require_once(ENGINE_DIR.'/data/stream_config.php');
require_once(ENGINE_DIR.'/api/api.class.php');

if($config['allow_cache'] != 'yes') {
	$config['allow_cache'] = 'yes'; 
	$cache = true;
}
$act = $_REQUEST['action'];

echoheader();
js_code();

if(empty($act) OR !isset($act)){
/*==============================================================
������� �������� ������� | ����������� ���������� | ������������
===============================================================*/
echomenu();
opentable();
tableheader("������ ����������");
streamList($db->super_query("SELECT id, title, service, login, description, pic, date FROM ".PREFIX."_streams ORDER BY id", true));
closetable();

if ($stream_config['allow_stream'] == 'yes'){
	$allow_stream = '<span style="color: green;">�������</span>';
}else{
	$offline = "<div class='ui-state-error ui-corner-all' style='padding:10px;'><b>�������� ������ ��������:</b><br> ����� ��� ��������� � ������� ���������, �� ������ ������� � <a href='$PHP_SELF?mod=stream-info&action=settings' alt='������������ ������'><b>������ �������� ������</b></a>.</div>";
	$allow_stream = '<span style="color: red;">��������</span>';
}
$fileCache = array("stream-info","stream-info-block","stream-info-key");
$calcache = calc_cache($fileCache);

opentable();
tableheader("����������� ���������");
echo<<<HTML
<table width="100%">
    <tbody>
		<tr>
			<td width="265" style="padding: 3px;">����� ������ ������:</td>
			<td>{$allow_stream}</td>
		</tr>
		<tr>
			<td background="engine/skins/images/mline.gif" height="1" colspan="7"></td>
		</tr>
		<tr>
			<td style="padding: 3px;">������ Stream-Info:</td>
			<td>1.5.2</td>
		</tr>
		<tr>
			<td background="engine/skins/images/mline.gif" height="1" colspan="7"></td>
		</tr>
		<tr>
			<td style="padding: 3px;">������ ����:</td>
			<td id="calcc">{$calcache}</td>
		</tr>
		<tr>
			<td background="engine/skins/images/mline.gif" height="1" colspan="7"></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td><input id="clearbutton" name="clearbutton" class="btn btn-danger" type="button" value="�������� ���"></td>
			<td colspan="4"><div id="main_box"></div></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td colspan="2"><div class="hr_line" style="margin:0;"></div></td>
			<td><div class="hr_line" style="margin:0;"></div></td>
		</tr>
		<tr>
			<td colspan="2" align="center" bgcolor="#EFEFEF" height="29"><b>����� ����������� ������</b></td>
			<td align="center" bgcolor="#EFEFEF" height="29"><i style="color:red;">������ ����������� ������</i></td>
		</tr>
		<tr>
			<td colspan="2"><div class="hr_line" style="margin:0 0 -1px 0;"></div></td>
			<td><div class="hr_line" style="margin: 0;"></div></td>
		</tr>
		<tr>
			<td colspan="2">
				<table width="400px">
					<tbody>
						<tr>
							<td width="265px" style="padding:3px;">���:</td>
							<td><b>������</b></td>
						</tr>
						<tr>
							<td background="engine/skins/images/mline.gif" height="1" colspan="7"></td>
						</tr>
						<tr>
							<td width="265px" style="padding:3px;">Skype:</td>
							<td><b>maddog670</b></td>
						</tr>
						<tr>
							<td background="engine/skins/images/mline.gif" height="1" colspan="7"></td>
						</tr>	
						<tr>
							<td style="padding:3px;">ICQ:</td>
							<td>3216327</td>
						</tr>
						<tr>
							<td background="engine/skins/images/mline.gif" height="1" colspan="7"></td>
						</tr>
						<tr>
							<td style="padding:3px;">Email:</td>
							<td>BleFF_8989@mail.ru</td>
						</tr>
					</tbody>
				</table>
			</td>
			<td>
				<table width="420px" style="margin-left:100px;">
					<tbody>
						<tr>
							<td width="170px" style="padding:3px;"><b style="color:red;">���������� ��������</b></td>
							<td><b style="color:red;">� ���������� �������������</b></td>
						</tr>
						<tr>
							<td background="engine/skins/images/mline.gif" height="1" colspan="7"></td>
						</tr>
						<tr>
							<td style="padding:3px;">Skype:</td>
							<td colspan="2">tlt.pavel-sergeevich</td>
						</tr>
						<tr>
							<td background="engine/skins/images/mline.gif" height="1" colspan="7"></td>
						</tr>
						<tr>
							<td style="padding:3px;">ICQ:</td>
							<td>360486149</td>
						</tr>
						<tr>
							<td background="engine/skins/images/mline.gif" height="1" colspan="7"></td>
						</tr>
						<tr>
							<td style="padding:3px;">Email:</td>
							<td>admin@ksyd.ru</td>
						</tr>
					</tbody>
				</table>
			</td>
		</tr>
		<tr>
			<td background="engine/skins/images/mline.gif" height="1" colspan="7"></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td colspan="5">{$offline}</td>
		</tr>
	</tbody>
</table>
HTML;
closetable();
}elseif($act == 'add') {
/*===========================
   ���������� ����������
===========================*/
	echomenu();
	opentable();
	tableheader("�������� ����������");
	echo<<<HTML
<form action="" method="POST">
	<table width="100%">
		<tbody>
			<tr>
				<td width="140" height="29" style="padding-left:5px;">����� ����������:</td>
				<td><input id="login-stream" class="edit bk" type="text" style="width:350px;" name="add[login]" required><a href="#" class="hintanchor" onmouseover="showhint('&lt;b&gt;����� ����������&lt;/b&gt; ���������� � ���������� � ����� ��������� �� ����� 100 ��������.', this, event, '220px')">[?]</a><span id="related_news"></span></td>
			</tr>
			<tr>
				<td width="140" height="29" style="padding-left:5px;">������ ����������:</td>
				<td>
				<select id="service" class="edit bk" style="width: 358px;" name="add[service]" required>
					<option value="twitch" selected="">Twitch.Tv</option>
						<option value="cybergame">CyberGame.TV</option>
					<option value="goodgame">GoodGame.Ru</option>
				</select><a href="#" class="hintanchor" onmouseover="showhint('&lt;b&gt;������ ����������&lt;/b&gt; ���������� � ����������.', this, event, '220px')">[?]</a><span id="related_news"></span></td>
			</tr>
			<tr>
				<td width="140" height="29" style="padding-left:5px;">��������� ����������:</td>
				<td><input id="title-stream" class="edit bk" type="text" style="width:350px;" name="add[title]" required><a href="#" class="hintanchor" onmouseover="showhint('&lt;b&gt;��������� ����������&lt;/b&gt; ���������� � ���������� � ����� ��������� �� ����� 100 ��������.', this, event, '220px')">[?]</a><input id="set_title" style="margin-left:10px;" type="button" class="btn btn-primary" value="���������� �����"><span id="related_news"></span></td>
			</tr>
			<tr>
				<td width="140" height="29" style="padding-left:5px;">������ ����������:</td>
				<td><input class="edit bk" type="text" style="width:350px;" name="add[pic]" required><a href="#" class="hintanchor" onmouseover="showhint('&lt;b&gt;����������� ����������&lt;/b&gt; ���������� � ���������� � ����� ��������� ������ ������ �� �����������.', this, event, '220px')">[?]</a><span id="related_news"></span></td>
			</tr>
			<tr>
				<td width="140" height="29" style="padding-left:5px;">�������� ����������:</td>
HTML;
			if( $config['allow_admin_wysiwyg'] ) {
				include (ENGINE_DIR . '/editor/shortnews.php');
			} else {
			$bb_editor = true;
			include (ENGINE_DIR . '/inc/include/inserttag.php');
			echo <<<HTML
				<td><br />{$bb_code}<textarea style="width: 98%;resize: none;" rows="10" name="add[descr]" id="short_story" required></textarea></td>
HTML;
			}
			echo <<<HTML
			</tr>
			<tr>
				<td></td>
				<td>
					<input type="hidden" name="action" value="doadd">
					<br /><div align="center"><input type="submit" class="btn btn-success" value="&nbsp;&nbsp;�������� ����������&nbsp;&nbsp;"></div>
				</td>
			</tr>
		</tbody>
	</table>
</form>
HTML;
closetable();
}elseif($act == 'doadd'){
/*===========================
   ���������� ����������
===========================*/
	$data = $_POST['add'];
	
	switch($data['service']) {
		case 'twitch':
			$twitch_check = check_twitch($data['login']);
			if(!$twitch_check) {
				streamMsg("������", "���������� � ����� ������� �� �������.<br /><br /><a href=$PHP_SELF?mod=stream-info&action=add>$lang[db_prev]</a>");
				die();
			}
			break;
		
		case 'cybergame':
			$cybergame_check = getcybergame($data['login']);
			if(!$cybergame_check['thumbnail']) {
				streamMsg("������", "���������� � ����� ������� �� �������.<br /><br /><a href=$PHP_SELF?mod=stream-info&action=add>$lang[db_prev]</a>");
				die();
			}
			break;
			
		case 'goodgame':
			$goodgame_check = getgoodgame($data['login']);
			if(!$goodgame_check->stream->key) {
				streamMsg("������", "���������� � ����� ������� �� �������.<br /><br /><a href=$PHP_SELF?mod=stream-info&action=add>$lang[db_prev]</a>");
				die();
			}
			break;
	}
	
	$dbquery = $db->query("INSERT INTO ".PREFIX."_streams (title, service, login, description, pic) VALUES ('".htmlspecialchars($data['title'], ENT_QUOTES)."', '".htmlspecialchars($data['service'], ENT_QUOTES)."', '".strtolower(htmlspecialchars($data['login'], ENT_QUOTES))."', '".htmlspecialchars($data['descr'], ENT_QUOTES)."', '".htmlspecialchars($data['pic'], ENT_QUOTES)."')");
	
	if($dbquery) {
		$dle_api->clean_cache("stream-info");
		$dle_api->clean_cache("stream-info-block");
		streamMsg("������", "���������� ������� ���������.<br /><br /><a href=$PHP_SELF?mod=stream-info&action=edit>$lang[db_prev]</a>");
	} else {
		$dle_api->clean_cache("stream-info");
		$dle_api->clean_cache("stream-info-block");
		streamMsg("������", "�� ������� �������� ����������.<br /><br /><a href=$PHP_SELF?mod=stream-info&action=edit>$lang[db_prev]</a>");
	}
}elseif($act == 'edit') {
/*===========================
 �������������� ����������
===========================*/
	$id = (int)$_REQUEST['id'];
	
	if(isset($id) && !empty($id)) {
		$stream = $db->super_query("SELECT id, title, service, login, description, pic, date   FROM ".PREFIX."_streams WHERE id = '".$id."'");
		echomenu();
		opentable();
		tableheader("������������� ����������");
		echo<<<HTML
<form action="" method="POST">
	<table width="100%">
		<tbody>
			<tr>
				<td width="140" height="29" style="padding-left:5px;">��������� ����������:</td>
				<td><input class="edit bk" type="text" style="width:350px;" name="edit[title]" value="{$stream['title']}" required> <a href="#" class="hintanchor" onmouseover="showhint('&lt;b&gt;��������� ����������&lt;/b&gt; ���������� � ���������� � ����� ��������� �� ����� 100 ��������.', this, event, '220px')">[?]</a><span id="related_news"></span></td>
			</tr>
			<tr>
				<td width="140" height="29" style="padding-left:5px;">����� ����������:</td>
				<td><input class="edit bk" type="text" style="width:350px;" name="edit[login]" value="{$stream['login']}" required> <a href="#" class="hintanchor" onmouseover="showhint('&lt;b&gt;����� ����������&lt;/b&gt; ���������� � ���������� � ����� ��������� �� ����� 100 ��������.', this, event, '220px')">[?]</a><span id="related_news"></span></td>
			</tr>
			<tr>
				<td width="140" height="29" style="padding-left:5px;">������ ����������:</td>
				<td><select class="edit bk" style="width: 358px;" name="edit[service]" required>
				<option value="{$stream['service']}" selected="">---�������� ��� ��---</option>
				<option value="twitch">Twitch.Tv</option>
				<option value="cybergame">CyberGame.TV</option>
				<option value="goodgame">GoodGame.Ru</option>
       </select> <a href="#" class="hintanchor" onmouseover="showhint('&lt;b&gt;������ ����������&lt;/b&gt; ���������� � ����������. ���� �� �������� ��������, ����� ��� ���������� �������.', this, event, '220px')">[?]</a><span id="related_news"></span></td>
			</tr>
			<tr>
				<td width="140" height="29" style="padding-left:5px;">������ ����������:</td>
				<td><input class="edit bk" type="text" style="width:350px;" name="edit[pic]" value="{$stream['pic']}" required><a href="#" class="hintanchor" onmouseover="showhint('&lt;b&gt;����������� ����������&lt;/b&gt; ���������� � ���������� � ����� ��������� ������ ������ �� �����������.', this, event, '220px')">[?]</a><span id="related_news"></span></td>
			</tr>
			<tr>
				<td width="140" height="29" style="padding-left:5px;">�������� ����������:</td>
HTML;
				$bb_editor = true;
				include (ENGINE_DIR . '/inc/include/inserttag.php');
			echo <<<HTML
				<td><br />{$bb_code}<textarea style="width: 98%;resize: none;" rows="10" name="edit[descr]" id="short_story" required>{$stream['description']}</textarea></td>
HTML;
			echo <<<HTML
			</tr>
			<tr>
				<td></td>
				<td>
					<input type="hidden" name="id" value="{$id}">
					<input type="hidden" name="action" value="doedit">
					<br /><div align="center"><input type="submit" class="btn btn-success" value="&nbsp;&nbsp;��������������� ����������&nbsp;&nbsp;"></div>
				</td>
			</tr>
		</tbody>
	</table>
</form>
HTML;
	closetable();
}else{
	echomenu();
	opentable();
	tableheader("�������������� ����������");
	streamList($db->super_query("SELECT id, title, service, login, description, pic, date FROM ".PREFIX."_streams ORDER BY id", true));
	closetable();
}
}elseif($act == 'doedit') {
/*===========================
 �������������� ����������
===========================*/
	$id = (int)$_POST['id'];
	$data = $_POST['edit'];
	
	switch($data['service']) {
		case 'twitch':
			$twitch_check = check_twitch($data['login']);
			if(!$twitch_check) {
				streamMsg("������", "���������� � ����� ������� �� �������.<br /><br /><a href=$PHP_SELF?mod=stream-info&action=edit>$lang[db_prev]</a>");
				die();
			}
			break;
		
		case 'cybergame':
			$cybergame_check = getcybergame($data['login']);
			if(!$cybergame_check['thumbnail']) {
				streamMsg("������", "���������� � ����� ������� �� �������.<br /><br /><a href=$PHP_SELF?mod=stream-info&action=edit>$lang[db_prev]</a>");
				die();
			}
			break;
			
		case 'goodgame':
			$goodgame_check = getgoodgame($data['login']);
			if(!$goodgame_check->stream->key) {
				streamMsg("������", "���������� � ����� ������� �� �������.<br /><br /><a href=$PHP_SELF?mod=stream-info&action=edit>$lang[db_prev]</a>");
				die();
			}
			break;
	}
	
	$dbquery = $db->query("UPDATE ".PREFIX."_streams SET title = '".htmlspecialchars($data['title'], ENT_QUOTES)."', service = '".htmlspecialchars($data['service'], ENT_QUOTES)."', login = '".strtolower(htmlspecialchars($data['login'], ENT_QUOTES))."', description = '".htmlspecialchars($data['descr'], ENT_QUOTES)."', pic = '".htmlspecialchars($data['pic'], ENT_QUOTES)."' WHERE id = '".$id."'");
	
	if($dbquery) {
		$dle_api->clean_cache("stream-info");
		$dle_api->clean_cache("stream-info-block");
		streamMsg("������", "���������� ������� ����������������.<br /><br /><a href=$PHP_SELF?mod=stream-info&action=edit>$lang[db_prev]</a>");
		die();
	} else {
		$dle_api->clean_cache("stream-info");
		$dle_api->clean_cache("stream-info-block");
		streamMsg("������", "�� ������� �������� ��������� � ���� ������.<br /><br /><a href=$PHP_SELF?mod=stream-info&action=edit>$lang[db_prev]</a>");
		die();
	}
}elseif($act == 'dodelete') {
/*===========================
   �������� ����������
===========================*/
	$data = $_POST['selected_stream'];
	$deleted = 0;
	foreach($data as $id) {
		$db->query("DELETE FROM ".PREFIX."_streams WHERE id= '".intval($id)."'");
		$deleted++;
	}
	streamMsg("������", $deleted." ��������(��) �������.<br /><br /><a href=$PHP_SELF?mod=stream-info&action=edit>$lang[db_prev]</a>");
}elseif($act == 'saveconfig') {
/*===========================
   ���������� ��������
===========================*/
	saveConfig($_REQUEST['savecfg'], $stream_config);
	
}elseif($act == 'settings') {
/*===========================
   ��������� ������
===========================*/
	settings($stream_config);
}
echofooter();