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
 Данный код защищен авторскими правами
===============================================
 Файл: /engine/inc/stream-info.fnc.php
-----------------------------------------------------
 Назначение: Основные функции админпанели и модуля
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
HTML шаблон Навигации и меню
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
          <div class="navigation">Навигация</div></td>
    </tr>
</table>
<div class="unterline"></div>
<table style="text-align:center;" width="100%" height="35px">
<tbody><tr style="vertical-align:middle;">
 <td class="tableborder"><a href="$PHP_SELF?mod=stream-info"><img title="Общая информация" src="engine/skins/images/stream-module.png" border="0"></a>
 </td><td class="tableborder"><a href="$PHP_SELF?mod=stream-info&action=add"><img title="Добавить трансляцию" src="engine/skins/images/stream-add.png" border="0"></a>
 </td><td class="tableborder"><a href="$PHP_SELF?mod=stream-info&action=edit"><img title="Редактирование трансляций" src="engine/skins/images/stream-edit.png" border="0"></a>
 </td><td class="tableborder"><a href="$PHP_SELF?mod=stream-info&action=settings"><img title="Настройки" src="engine/skins/images/stream-option.png" border="0"></a>
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
Открытие таблицы
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
Закрытие таблицы
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
Сообщение после выполнения определенной операции
------------------------------------------------
Аналог дле-шной msg, только урезанная версия
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
Вставка inputа
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
Генерация списка стримов которые сейчас online
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
							<th>&nbsp;&nbsp;Заголовок</th>
							<th width="210">Автор</th>
							<th width="120">Сервис</th>
							<!-- <th width="120">Транслирует?</th> -->
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
					{$stream['date']} <a title="Редактировать {$stream['title']}" class="list" href="{$PHP_SELF}?mod=stream-info&action=edit&id={$stream['id']}">{$stream['title']}</a>
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
					<input name="selected_stream[]" value="{$stream['id']}" type="checkbox"><!-- <input class="btn btn-danger btn-mini" type="button" value="Удалить"> -->
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
									<option value="">--Действие--</option>
									<option value="dodelete">Удалить</option>
								</select>
								<input class="btn btn-warning btn-mini" type="submit" value="Выполнить">
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
HTML шаблон настроек модуля
------------------------------
@stream_config - конфиг модуля
============================*/
function settings($stream_config){

if($stream_config['showplayer'] == 'yes') {
		$option1 = "Да";
		$option2 = "Нет";
		$option3 = "no";
	} else {
		$option1 = "Нет";
		$option2 = "Да";
		$option3 = "yes";
	}
	if($stream_config['cache_allow'] == 'yes') {
		$option4 = "Да";
		$option5 = "Нет";
		$option6 = "no";
	} else {
		$option4 = "Нет";
		$option5 = "Да";
		$option6 = "yes";
	}
	if($stream_config['allow_stream'] == 'yes') {
		$option7 = "Да";
		$option8 = "Нет";
		$option9 = "no";
	} else {
		$option7 = "Нет";
		$option8 = "Да";
		$option9 = "yes";
	}
	echomenu();
	opentable();
	tableheader("Настройки модуля");
	echo<<<HTML
<form action="" method="POST">
	<table width="100%">
		<tbody>
                        <tr>
				<td style="padding:4px" class="option">
					<div style="padding-bottom:5px;"><b>Включить модуль?</b></div>
					<div class="small">Данная опция позволит показывать стримы на сайте.</div>
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
					<div style="padding-bottom:5px;"><b>Выводить плеер в краткой информации о трансляции</b></div>
					<div class="small">Внимание! Использование этой функции нагружает браузер.</div>
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
					<div style="padding-bottom:5px;"><b>Включить кэширование списка трансляций</b></div>
					<div class="small">Заметно ускоряет вывод списка трансляций.</div>
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
showRow("Время жизни кэша","В минутах.","<input class=\"edit bk\" type=\"text\" style=\"text-align: center;width: 350px;\" name=\"savecfg[cachelife]\" value=\"{$stream_config['cachelife']}\" size=\"25\">");
showRow("Количество трансляций в блоке","Укажите количество трансляций в блоке '{stream-info}'.","<input class=\"edit bk\" type=\"text\" style=\"text-align: center;width: 350px;\" name=\"savecfg[blocklimit]\" value=\"{$stream_config['blocklimit']}\" size=\"25\">");
showRow("Ширина плеера","В пикселях.","<input class=\"edit bk\" type=\"text\" style=\"text-align: center;width: 350px;\" name=\"savecfg[width]\" value=\"{$stream_config['width']}\" size=\"25\">");
showRow("Высота плеера","В пикселях.","<input class=\"edit bk\" type=\"text\" style=\"text-align: center;width: 350px;\" name=\"savecfg[height]\" value=\"{$stream_config['height']}\" size=\"25\">");
showRow("Статус онлайн","Сообщение для вывода статуса.","<input class=\"edit bk\" type=\"text\" style=\"text-align: center;width: 350px;\" name=\"savecfg[online]\" value=\"{$stream_config['online']}\" size=\"25\">");
showRow("Статус оффлайн","Сообщение для вывода статуса.","<input class=\"edit bk\" type=\"text\" style=\"text-align: center;width: 350px;\" name=\"savecfg[offline]\" value=\"{$stream_config['offline']}\" size=\"25\">");
showRow("Заглушка для плеера","Если трансляция оффлайн, показывается заглушка (используйте BB-коды).","<input class=\"edit bk\" type=\"text\" style=\"text-align: center;width: 350px;\" name=\"savecfg[zagluska]\" value=\"{$stream_config['zagluska']}\" size=\"25\">");
showRow("Время жизни кэша","В минутах","<input class=\"edit bk\" type=\"text\" style=\"text-align: center;width: 350px;\" name=\"savecfg[cachelife]\" value=\"{$stream_config['cachelife']}\" size=\"25\">");
showRow("Название(Тайтл) модуля","Тайтл модуля который будет отображаться в браузере","<input class=\"edit bk\" type=\"text\" style=\"text-align: center;width: 350px;\" name=\"savecfg[stream_title]\" value=\"{$stream_config['stream_title']}\" size=\"25\">");
showRow("Описание (Description) модуля","Краткое описание, не более 200 символов.","<input class=\"edit bk\" type=\"text\" style=\"text-align: center;width: 350px;\" name=\"savecfg[stream_desc]\" value=\"{$stream_config['stream_desc']}\" size=\"25\">");
showRow("Ключевые слова (Keywords) для модуля","Введите через запятую основные ключевые слова.","<input class=\"edit bk\" type=\"text\" style=\"text-align: center;width: 350px;\" name=\"savecfg[stream_keywords]\" value=\"{$stream_config['stream_keywords']}\" size=\"25\">");
showRow("","","<input type=\"hidden\" name=\"action\" value=\"saveconfig\">", false);
showRow("<input type=\"submit\" class=\"btn btn-success\" value=\"Сохранить\">");
echo <<<HTML
		</tbody>
	</table>
</form>
HTML;
closetable();
}
/*==========================
Js для ajax получения тайтла
----------------------------
Ajax очистка кеша модуля
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
			DLEalert("<p>Введите логин стримера или его ID</p>", "Информация");
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
				DLEalert("<p>"+response.status+"</p>", "Ошибка");
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
Выводим всю информацию по стриму
===============================*/
function getstreaminfo($login) {
	$login = totranslit($login);
	$db = new db();
	$stream_list = $db->super_query("SELECT * FROM " . PREFIX . "_streams WHERE login = '".$login."'", true);
	$info_stream = $stream_list[0];
	return $info_stream;
}
/*============================================================================
Получаем json из сервиса с количеством просмотров, какая игра, тайтл TWITCH.TV
=============================================================================*/
function gettwitch($login, $flag = false) {
	$path = ($flag) ? "channels/" : "streams/";
	$data = curl_init('https://api.twitch.tv/kraken/'.$path.totranslit($login));
	
	curl_setopt($data, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($data, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($data, CURLOPT_SSL_VERIFYHOST, false);
	@$stream_twitch = curl_exec($data); // при маленькой скорости инета вылетает Maximum execution time
	$stream_twitch = json_decode($stream_twitch, true);
	
	$st = ($flag) ? $stream_twitch : $stream_twitch['stream'];
	return $st;
}
/*==============================================================================
Получаем json из сервиса с количеством просмотров, какая игра, тайтл CYBERGAME.TV
===============================================================================*/
function getcybergame($login) {
	$stream_cybergame = file_get_contents('http://api.cybergame.tv/w/streams2.php?channel='.totranslit($login));
	$stream_cybergame = json_decode($stream_cybergame, true);
	return $stream_cybergame;
}
/*==============================================================================
Получаем xml из сервиса с количеством просмотров, какая игра, тайтл GOODGAME.RU
===============================================================================*/
function getgoodgame($login) {
	$stream_goodgame = simplexml_load_file('http://goodgame.ru/api/getchannelstatus?id='.totranslit($login));
	return $stream_goodgame;
}
/*=======================================================
Чекаем пользователя на существование на сервисе TWITCH.TV
----------------------------------------------------------
Если Not Found или 404 отдаем False, в остальных True
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
Получаем json посредством костыля xml для GOODGAME.RU
-----------------------------------------------------
Шатал разработчиков GG и кто придумал ключем массива
-----------------------------------------------------
ставить ID канала и отсуствие метода получения id 
===================================================*/
function setTitleGG($login){
	$stream_goodgame = file_get_contents("http://goodgame.ru/api/getchannelstatus?id=".totranslit($login)."&fmt=json");
	$stream_goodgame = json_decode($stream_goodgame, true);
	$idXml = getgoodgame(totranslit($login));
	$id = explode("=>", $idXml->stream->stream_id);
	return $stream_goodgame[$id[0]];
}
/*======================================================
Сохранение настроек модуля после нажатия кнопки отправить
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
		streamMsg("Готово", "Конфигурация успешно сохранена.<br /><br /><a href=$PHP_SELF?mod=stream-info&action=settings>{$lang['db_prev']}</a>");
	} else {
		streamMsg("Ошибка", "Не удалось записать конфиг в файл.<br /><br /><a href={$PHP_SELF}?mod=stream-info&action=settings>{$lang['db_prev']}</a>");
	}
	die();
}
/*=====================================
Конверт кодировки с windows в utf ибо
ajax работает только в UTF-8 цука =/
======================================*/
function inv($str){
	if (function_exists('iconv')){
		$str = iconv('windows-1251','utf-8',$str);
	}
	return $str;
}
/*==================================================
Подсчет размера определенных *.tmp файлов,
задается как массив array('file1', 'file2', 'file3')
===================================================*/
function calc_cache($caches = array()){
	$sum = array();
	foreach($caches as $cache){
			$sum[] = filesize(ENGINE_DIR . "/cache/{$cache}.tmp");
	}
	return round(array_sum($sum) / 1024, 2). " Кб";
}