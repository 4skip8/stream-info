<?php
/*=============================================
 Module Stream-Info for DataLife Engine
-----------------------------------------------------
			NEW AUTHOR: MaD
-----------------------------------------------------
 skype: maddog670
 icq:	3216327
-----------------------------------------------------
			OLD AUTHOR: ksyd
-----------------------------------------------------
 icq: 360486149
 skype: tlt.pavel-sergeevich
-----------------------------------------------------
 Copyright (c) 2014
===============================================
 Äàííûé êîä çàùèùåí àâòîðñêèìè ïðàâàìè
===============================================
 Ôàéë: /engine/inc/stream-info.fnc.php
-----------------------------------------------------
 Íàçíà÷åíèå: Îñíîâíûå ôóíêöèè àäìèíïàíåëè è ìîäóëÿ
===============================================*/
if (!defined('DATALIFEENGINE')) {
    die("Hacking attempt!");
}

function tableheader($value) {
echo <<<HTML
<table width="100%">
    <tr>
        <td bgcolor="#EFEFEF" height="29" style="padding-left:10px;">
          <div class="navigation">{$value}</div></td>
    </tr>
</table>
<div class="unterline"></div>
HTML;
}
/*==========================
HTML øàáëîí Íàâèãàöèè è ìåíþ
============================*/
function echomenu() {
echo<<<HTML
<table width="100%">
    <tr>
        <td width="4"><img src="engine/skins/images/tl_lo.gif" width="4" height="4" border="0"></td>
        <td background="engine/skins/images/tl_oo.gif"><img src="engine/skins/images/tl_oo.gif" width="1" height="4" border="0"></td>
        <td width="6"><img src="engine/skins/images/tl_ro.gif" width="6" height="4" border="0"></td>
    </tr>
    <tr>
        <td background="engine/skins/images/tl_lb.gif"><img src="engine/skins/images/tl_lb.gif" width="4" height="1" border="0"></td>
        <td style="padding:5px;" bgcolor="#FFFFFF">
<table width="100%">
    <tbody><tr>
        <td style="padding:2px;">
		<table width="100%">
    <tr>
        <td bgcolor="#EFEFEF" height="29" style="padding-left:10px;">
          <div class="navigation">Íàâèãàöèÿ</div></td>
    </tr>
</table>
<div class="unterline"></div>
<table style="text-align:center;" width="100%" height="35px">
<tbody><tr style="vertical-align:middle;">
 <td class="tableborder"><a href="$PHP_SELF?mod=stream-info"><img title="Îáùàÿ èíôîðìàöèÿ" src="engine/skins/images/stream-module.png" border="0"></a>
 </td><td class="tableborder"><a href="$PHP_SELF?mod=stream-info&action=add"><img title="Äîáàâèòü òðàíñëÿöèþ" src="engine/skins/images/stream-add.png" border="0"></a>
 </td><td class="tableborder"><a href="$PHP_SELF?mod=stream-info&action=edit"><img title="Ðåäàêòèðîâàíèå òðàíñëÿöèé" src="engine/skins/images/stream-edit.png" border="0"></a>
 </td><td class="tableborder"><a href="$PHP_SELF?mod=stream-info&action=settings"><img title="Íàñòðîéêè" src="engine/skins/images/stream-option.png" border="0"></a>
 </td></tr>
</tbody></table>
</td>
    </tr>
</tbody></table>
<div class="hr_line"></div>
    </td>
        <td background="engine/skins/images/tl_rb.gif"><img src="engine/skins/images/tl_rb.gif" width="6" height="1" border="0"></td>
    </tr>
    <tr>
        <td><img src="engine/skins/images/tl_lu.gif" width="4" height="6" border="0"></td>
        <td background="engine/skins/images/tl_ub.gif"><img src="engine/skins/images/tl_ub.gif" width="1" height="6" border="0"></td>
        <td><img src="engine/skins/images/tl_ru.gif" width="6" height="6" border="0"></td>
    </tr>
</table>
HTML;
}
/*==============
Îòêðûòèå òàáëèöû
===============*/
function opentable() {
echo <<<HTML
<table width="100%">
    <tr>
        <td width="4"><img src="engine/skins/images/tl_lo.gif" width="4" height="4" border="0"></td>
        <td background="engine/skins/images/tl_oo.gif"><img src="engine/skins/images/tl_oo.gif" width="1" height="4" border="0"></td>
        <td width="6"><img src="engine/skins/images/tl_ro.gif" width="6" height="4" border="0"></td>
    </tr>
    <tr>
        <td background="engine/skins/images/tl_lb.gif"><img src="engine/skins/images/tl_lb.gif" width="4" height="1" border="0"></td>
        <td style="padding:5px;" bgcolor="#FFFFFF">
HTML;
}
/*==============
Çàêðûòèå òàáëèöû
===============*/
function closetable() {
echo <<<HTML
    </td>
        <td background="engine/skins/images/tl_rb.gif"><img src="engine/skins/images/tl_rb.gif" width="6" height="1" border="0"></td>
    </tr>
    <tr>
        <td><img src="engine/skins/images/tl_lu.gif" width="4" height="6" border="0"></td>
        <td background="engine/skins/images/tl_ub.gif"><img src="engine/skins/images/tl_ub.gif" width="1" height="6" border="0"></td>
        <td><img src="engine/skins/images/tl_ru.gif" width="6" height="6" border="0"></td>
    </tr>
</table>
HTML;
}
/*==============================================
Ñîîáùåíèå ïîñëå âûïîëíåíèÿ îïðåäåëåííîé îïåðàöèè
------------------------------------------------
Àíàëîã äëå-øíîé msg, òîëüêî óðåçàííàÿ âåðñèÿ
===============================================*/
function streamMsg($title, $text, $back = FALSE) {
	global $lang;	
	if( $back ) {
		$back = "<br /><br> <a class=\"main\" href=\"$back\">$lang[func_msg]</a>";
	}	
	echo <<<HTML
<div style="padding-top:5px;padding-bottom:2px;">
<table width="100%">
    <tr>
        <td width="4"><img src="engine/skins/images/tl_lo.gif" width="4" height="4" border="0"></td>
        <td background="engine/skins/images/tl_oo.gif"><img src="engine/skins/images/tl_oo.gif" width="1" height="4" border="0"></td>
        <td width="6"><img src="engine/skins/images/tl_ro.gif" width="6" height="4" border="0"></td>
    </tr>
    <tr>
        <td background="engine/skins/images/tl_lb.gif"><img src="engine/skins/images/tl_lb.gif" width="4" height="1" border="0"></td>
        <td style="padding:5px;" bgcolor="#FFFFFF">
<table width="100%">
    <tr>
        <td bgcolor="#EFEFEF" height="29" style="padding-left:10px;"><div class="navigation">{$title}</div></td>
    </tr>
</table>
<div class="unterline"></div>
<table width="100%">
    <tr>
        <td height="100" align="center">{$text} {$back}</td>
    </tr>
</table>
</td>
        <td background="engine/skins/images/tl_rb.gif"><img src="engine/skins/images/tl_rb.gif" width="6" height="1" border="0"></td>
    </tr>
    <tr>
        <td><img src="engine/skins/images/tl_lu.gif" width="4" height="6" border="0"></td>
        <td background="engine/skins/images/tl_ub.gif"><img src="engine/skins/images/tl_ub.gif" width="1" height="6" border="0"></td>
        <td><img src="engine/skins/images/tl_ru.gif" width="6" height="6" border="0"></td>
    </tr>
</table>
</div>
HTML;
	
	echofooter();
	die();
}
/*============================
Âñòàâêà inputà
==============================*/
function showRow($title = "", $description = "", $field = "", $flag = true) {
	echo "<tr>
	<td style=\"padding:4px\" class=\"option\">
		<div style=\"padding-bottom:5px;\"><b>{$title}</b></div><div class=\"small\">{$description}</div>
		<td width=\"400\" align=middle >
			$field
		</tr>";
	if($flag){
	echo "<tr>
			<td background=\"engine/skins/images/mline.gif\" height=1 colspan=2></td>
		</tr>";
	}
}
/*============================================
Ãåíåðàöèÿ ñïèñêà ñòðèìîâ êîòîðûå ñåé÷àñ online
=============================================*/
function streamList($streams){
echo<<<HTML
<form action="" method="POST">
<table width="100%">
    <tbody>
		<tr>
			<td>
				<table width="100%" id="newslist">
					<tbody>
						<tr class="thead">
							<th>&nbsp;&nbsp;Çàãîëîâîê</th>
							<th width="210">Àâòîð</th>
							<th width="120">Ñåðâèñ</th>
							<!-- <th width="120">Òðàíñëèðóåò?</th> -->
HTML;
						if ($_REQUEST['action'] == 'edit'){
						echo '<th width="10" style="text-align: center;"><input id="all" name="all" value="" type="checkbox"></th>';
						}
							
echo<<<HTML
						</tr>
						<tr class="tfoot">
							<th colspan="7">
								<div class="hr_line"></div>
							</th>
						</tr>
						<tr class="">
							<td background="engine/skins/images/mline.gif" height="1" colspan="7"></td>
						</tr>
HTML;
	foreach($streams as $stream) {
		$stream['date'] = date("d.m.Y", strtotime($stream['date']));
		echo<<<HTML
			<tr class="">
				<td class="list" style="padding:4px;">
					{$stream['date']} <a title="Ðåäàêòèðîâàòü {$stream['title']}" class="list" href="{$PHP_SELF}?mod=stream-info&action=edit&id={$stream['id']}">{$stream['title']}</a>
				</td>
				<td class="list">
					<a class="list">{$stream['login']}</a>
				</td>
					<td class="list">
					<a class="list">{$stream['service']}</a>
				</td>       
				<!-- <td class="list">
					<a class="list">Yes/No</a>
				</td> -->
HTML;
				if ($_REQUEST['action'] == 'edit'){
				echo <<<HTML
				<td align="center" width="80px">
					<input name="selected_stream[]" value="{$stream['id']}" type="checkbox"><!-- <input class="btn btn-danger btn-mini" type="button" value="Óäàëèòü"> -->
				</td>
HTML;
				}
echo <<<HTML
			</tr>
				<tr>
					<td background="engine/skins/images/mline.gif" height="1" colspan="7">
				</td>
			</tr>	
HTML;
	}
			echo <<<HTML
			<tr class="tfoot hoverRow">
							<th colspan="7">
								<div class="hr_line"></div>
							</th>
						</tr>
HTML;
						if ($_REQUEST['action'] == 'edit'){
						
						echo <<<HTML
						<tr class="tfoot">
							<th>
								<div class="news_navigation" style="margin-bottom:5px; margin-top:5px;"></div>
							</th>
							<th colspan="5" valign="top">
								<div style="margin-bottom:5px; margin-top:5px; text-align: right;">
								<select name="action">
									<option value="">-- Äåéñòâèå --</option>
									<option value="dodelete">Óäàëèòü</option>
								</select>
								<input class="btn btn-warning btn-mini" type="submit" value="Âûïîëíèòü">
							</div>
							</th>
						</tr>
HTML;
						}
					echo <<<HTML
					</tbody>
				</table>
			</td>
		</tr>
	</tbody>
</table>
</form>
HTML;
}
/*============================
HTML øàáëîí íàñòðîåê ìîäóëÿ
------------------------------
@stream_config - êîíôèã ìîäóëÿ
============================*/
function settings($stream_config){

if($stream_config['showplayer'] == 'yes') {
		$option1 = "Äà";
		$option2 = "Íåò";
		$option3 = "no";
	} else {
		$option1 = "Íåò";
		$option2 = "Äà";
		$option3 = "yes";
	}
	if($stream_config['cache_allow'] == 'yes') {
		$option4 = "Äà";
		$option5 = "Íåò";
		$option6 = "no";
	} else {
		$option4 = "Íåò";
		$option5 = "Äà";
		$option6 = "yes";
	}
	if($stream_config['allow_stream'] == 'yes') {
		$option7 = "Äà";
		$option8 = "Íåò";
		$option9 = "no";
	} else {
		$option7 = "Íåò";
		$option8 = "Äà";
		$option9 = "yes";
	}
	echomenu();
	opentable();
	tableheader("Íàñòðîéêè ìîäóëÿ");
	echo<<<HTML
<form action="" method="POST">
	<table width="100%">
		<tbody>
                        <tr>
				<td style="padding:4px" class="option">
					<div style="padding-bottom:5px;"><b>Âêëþ÷èòü ìîäóëü?</b></div>
					<div class="small">Äàííàÿ îïöèÿ ïîçâîëèò ïîêàçûâàòü ñòðèìû íà ñàéòå.</div>
				</td>
				<td width="400" align="middle">
					<select name="savecfg[allow_stream]">
							<option value="{$stream_config['allow_stream']}" selected="">{$option7}</option>
							<option value="{$option9}">{$option8}</option>
					</select>
				</td>
			</tr>
				<tr>
					<td background="engine/skins/images/mline.gif" height="1" colspan="2"></td>
				</tr>
			<tr>
				<td style="padding:4px" class="option">
					<div style="padding-bottom:5px;"><b>Âûâîäèòü ïëååð â êðàòêîé èíôîðìàöèè î òðàíñëÿöèè</b></div>
					<div class="small">Âíèìàíèå! Èñïîëüçîâàíèå ýòîé ôóíêöèè íàãðóæàåò áðàóçåð.</div>
				</td>
				<td width="400" align="middle">
					<select name="savecfg[showplayer]">
						<option value="{$stream_config['showplayer']}" selected="">{$option1}</option>
						<option value="{$option3}">{$option2}</option>
					</select>
				</td>
			</tr>
			<tr>
				<td background="engine/skins/images/mline.gif" height="1" colspan="2"></td>
			</tr>
			<tr>
				<td style="padding:4px" class="option">
					<div style="padding-bottom:5px;"><b>Âêëþ÷èòü êýøèðîâàíèå ñïèñêà òðàíñëÿöèé</b></div>
					<div class="small">Çàìåòíî óñêîðÿåò âûâîä ñïèñêà òðàíñëÿöèé.</div>
				</td>
				<td width="400" align="middle">
					<select name="savecfg[cache_allow]">
						<option value="{$stream_config['cache_allow']}" selected="">{$option4}</option>
						<option value="{$option6}">{$option5}</option>
					</select>
				</td>
			</tr>
			<tr>
				<td background="engine/skins/images/mline.gif" height="1" colspan="2"></td>
			</tr>
HTML;
showRow("Âðåìÿ æèçíè êýøà","Â ìèíóòàõ.","<input class=\"edit bk\" type=\"text\" style=\"text-align: center;width: 350px;\" name=\"savecfg[cachelife]\" value=\"{$stream_config['cachelife']}\" size=\"25\">");
showRow("Êîëè÷åñòâî òðàíñëÿöèé â áëîêå","Óêàæèòå êîëè÷åñòâî òðàíñëÿöèé â áëîêå '{stream-info}'.","<input class=\"edit bk\" type=\"text\" style=\"text-align: center;width: 350px;\" name=\"savecfg[blocklimit]\" value=\"{$stream_config['blocklimit']}\" size=\"25\">");
showRow("Øèðèíà ïëååðà","Â ïèêñåëÿõ.","<input class=\"edit bk\" type=\"text\" style=\"text-align: center;width: 350px;\" name=\"savecfg[width]\" value=\"{$stream_config['width']}\" size=\"25\">");
showRow("Âûñîòà ïëååðà","Â ïèêñåëÿõ.","<input class=\"edit bk\" type=\"text\" style=\"text-align: center;width: 350px;\" name=\"savecfg[height]\" value=\"{$stream_config['height']}\" size=\"25\">");
showRow("Ñòàòóñ îíëàéí","Ñîîáùåíèå äëÿ âûâîäà ñòàòóñà.","<input class=\"edit bk\" type=\"text\" style=\"text-align: center;width: 350px;\" name=\"savecfg[online]\" value=\"{$stream_config['online']}\" size=\"25\">");
showRow("Ñòàòóñ îôôëàéí","Ñîîáùåíèå äëÿ âûâîäà ñòàòóñà.","<input class=\"edit bk\" type=\"text\" style=\"text-align: center;width: 350px;\" name=\"savecfg[offline]\" value=\"{$stream_config['offline']}\" size=\"25\">");
showRow("Çàãëóøêà äëÿ ïëååðà","Åñëè òðàíñëÿöèÿ îôôëàéí, ïîêàçûâàåòñÿ çàãëóøêà (èñïîëüçóéòå BB-êîäû).","<input class=\"edit bk\" type=\"text\" style=\"text-align: center;width: 350px;\" name=\"savecfg[zagluska]\" value=\"{$stream_config['zagluska']}\" size=\"25\">");
showRow("Âðåìÿ æèçíè êýøà","Â ìèíóòàõ","<input class=\"edit bk\" type=\"text\" style=\"text-align: center;width: 350px;\" name=\"savecfg[cachelife]\" value=\"{$stream_config['cachelife']}\" size=\"25\">");
showRow("Íàçâàíèå(Òàéòë) ìîäóëÿ","Òàéòë ìîäóëÿ êîòîðûé áóäåò îòîáðàæàòüñÿ â áðàóçåðå","<input class=\"edit bk\" type=\"text\" style=\"text-align: center;width: 350px;\" name=\"savecfg[stream_title]\" value=\"{$stream_config['stream_title']}\" size=\"25\">");
showRow("Îïèñàíèå (Description) ìîäóëÿ","Êðàòêîå îïèñàíèå, íå áîëåå 200 ñèìâîëîâ.","<input class=\"edit bk\" type=\"text\" style=\"text-align: center;width: 350px;\" name=\"savecfg[stream_desc]\" value=\"{$stream_config['stream_desc']}\" size=\"25\">");
showRow("Êëþ÷åâûå ñëîâà (Keywords) äëÿ ìîäóëÿ","Ââåäèòå ÷åðåç çàïÿòóþ îñíîâíûå êëþ÷åâûå ñëîâà.","<input class=\"edit bk\" type=\"text\" style=\"text-align: center;width: 350px;\" name=\"savecfg[stream_keywords]\" value=\"{$stream_config['stream_keywords']}\" size=\"25\">");
showRow("","","<input type=\"hidden\" name=\"action\" value=\"saveconfig\">", false);
showRow("<input type=\"submit\" class=\"btn btn-success\" value=\"Ñîõðàíèòü\">");
echo <<<HTML
		</tbody>
	</table>
</form>
HTML;
closetable();
}
/*==========================
Js äëÿ ajax ïîëó÷åíèÿ òàéòëà
----------------------------
Ajax î÷èñòêà êåøà ìîäóëÿ
============================*/
function js_code(){
global $lang;
echo <<<HTML
<script type="text/javascript">
$(function(){
	$('#clearbutton').click(function() {
		$('#main_box').html('{$lang['dle_updatebox']}');
		$.get("engine/ajax/stream-info.php?action=clearCache", function( data ){
			$('#main_box').html(data);

		});
		return false;
	});
	$('#set_title').click(function(){
		var titles = $("#title-stream");
		var service = $("#service option:selected").val();
		var login = $("#login-stream").val();		
		
		if ($.trim(login) == ''){
			DLEalert("<p>Ââåäèòå ëîãèí ñòðèìåðà èëè åãî ID</p>", "Èíôîðìàöèÿ");
			return false;
		}
		ShowLoading('');
		$.ajax({
			url: "engine/ajax/stream-info.php",
			type: "POST",
			dataType:'json',
			data:{login:login, service:service, action:"setTitle"},
		}).done(function(response){
			if (response.code == 404 || response.title == false){
				DLEalert("<p>"+response.status+"</p>", "Îøèáêà");
				return false;
			}else{
				if (titles.val() == '' || (titles.val() != response.title)){
					titles.val(response.title);
				}
			}
		});
		HideLoading('');
		return false;
	});
	$('#all').on('change', function(){
    if ($(this).is(':checked'))
        $('input[type=checkbox]').each(function(){
            this.checked = true;
        });
    else
        $('input[type=checkbox]').removeAttr('checked');
	});
});
</script>
HTML;
}

/*===============================
Âûâîäèì âñþ èíôîðìàöèþ ïî ñòðèìó
===============================*/
function getstreaminfo($login) {
	$login = totranslit($login);
	$db = new db();
	$stream_list = $db->super_query("SELECT * FROM " . PREFIX . "_streams WHERE login = '".$login."'", true);
	$info_stream = $stream_list[0];
	return $info_stream;
}
/*============================================================================
Ïîëó÷àåì json èç ñåðâèñà ñ êîëè÷åñòâîì ïðîñìîòðîâ, êàêàÿ èãðà, òàéòë TWITCH.TV
=============================================================================*/
function gettwitch($login, $flag = false) {
	$path = ($flag) ? "channels/" : "streams/";
	$data = curl_init('https://api.twitch.tv/kraken/'.$path.totranslit($login));
	
	curl_setopt($data, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($data, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($data, CURLOPT_SSL_VERIFYHOST, false);
	@$stream_twitch = curl_exec($data); // ïðè ìàëåíüêîé ñêîðîñòè èíåòà âûëåòàåò Maximum execution time
	$stream_twitch = json_decode($stream_twitch, true);
	
	$st = ($flag) ? $stream_twitch : $stream_twitch['stream'];
	return $st;
}
/*==============================================================================
Ïîëó÷àåì json èç ñåðâèñà ñ êîëè÷åñòâîì ïðîñìîòðîâ, êàêàÿ èãðà, òàéòë CYBERGAME.TV
===============================================================================*/
function getcybergame($login) {
	$stream_cybergame = file_get_contents('http://api.cybergame.tv/w/streams2.php?channel='.totranslit($login));
	$stream_cybergame = json_decode($stream_cybergame, true);
	return $stream_cybergame;
}
/*==============================================================================
Ïîëó÷àåì xml èç ñåðâèñà ñ êîëè÷åñòâîì ïðîñìîòðîâ, êàêàÿ èãðà, òàéòë GOODGAME.RU
===============================================================================*/
function getgoodgame($login) {
	$stream_goodgame = simplexml_load_file('http://goodgame.ru/api/getchannelstatus?id='.totranslit($login));
	return $stream_goodgame;
}
/*=======================================================
×åêàåì ïîëüçîâàòåëÿ íà ñóùåñòâîâàíèå íà ñåðâèñå TWITCH.TV
----------------------------------------------------------
Åñëè Not Found èëè 404 îòäàåì False, â îñòàëüíûõ True
=========================================================*/
function check_twitch($login) {
	$data = curl_init('https://api.twitch.tv/kraken/channels/'.totranslit($login));
	curl_setopt($data, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($data, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($data, CURLOPT_SSL_VERIFYHOST, false);
	$result = curl_exec($data);
	$result = json_decode($result, true);

	if($result['status'] == '404') {
		return FALSE;
	} elseif($result['status'] == '422') {
		return TRUE;
	} else {
		return TRUE;
	}
}
/*===================================================
Ïîëó÷àåì json ïîñðåäñòâîì êîñòûëÿ xml äëÿ GOODGAME.RU
-----------------------------------------------------
Øàòàë ðàçðàáîò÷èêîâ GG è êòî ïðèäóìàë êëþ÷åì ìàññèâà
-----------------------------------------------------
ñòàâèòü ID êàíàëà è îòñóñòâèå ìåòîäà ïîëó÷åíèÿ id 
===================================================*/
function setTitleGG($login){
	$stream_goodgame = file_get_contents("http://goodgame.ru/api/getchannelstatus?id=".totranslit($login)."&fmt=json");
	$stream_goodgame = json_decode($stream_goodgame, true);
	$idXml = getgoodgame(totranslit($login));
	$id = explode("=>", $idXml->stream->stream_id);
	return $stream_goodgame[$id[0]];
}
/*======================================================
Ñîõðàíåíèå íàñòðîåê ìîäóëÿ ïîñëå íàæàòèÿ êíîïêè îòïðàâèòü
========================================================*/
function saveConfig($post, $stream_config){
	global $lang;
    if(!$stream_config['savecfg']['allow_stream']) $stream_config['allow_stream'] = 'no';
    $config = array_merge($stream_config, $post);
    $text = "<?php\n\$stream_config = " . var_export( $config, true ) . ";\n?>";
    $file = @fopen( ENGINE_DIR . '/data/stream_config.php', 'w+' );
    if (!$file) return false;
    else {
        @fwrite($file, $text);
        @fclose($file);
    }
	
    if($file) {
		streamMsg("Ãîòîâî", "Êîíôèãóðàöèÿ óñïåøíî ñîõðàíåíà.<br /><br /><a href=$PHP_SELF?mod=stream-info&action=settings>{$lang['db_prev']}</a>");
	} else {
		streamMsg("Îøèáêà", "Íå óäàëîñü çàïèñàòü êîíôèã â ôàéë.<br /><br /><a href={$PHP_SELF}?mod=stream-info&action=settings>{$lang['db_prev']}</a>");
	}
	die();
}
/*=====================================
Êîíâåðò êîäèðîâêè ñ windows â utf èáî
ajax ðàáîòàåò òîëüêî â UTF-8 öóêà =/
======================================*/
function inv($str){
	if (function_exists('iconv')){
		$str = iconv('windows-1251','utf-8',$str);
	}
	return $str;
}
/*==================================================
Ïîäñ÷åò ðàçìåðà îïðåäåëåííûõ *.tmp ôàéëîâ,
çàäàåòñÿ êàê ìàññèâ array('file1', 'file2', 'file3')
===================================================*/
function calc_cache($caches = array()){
	$sum = array();
	foreach($caches as $cache){
			$sum[] = filesize(ENGINE_DIR . "/cache/{$cache}.tmp");
	}
	return round(array_sum($sum) / 1024, 2). " Êá";
}
