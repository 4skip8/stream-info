<?php
/*===================================================
Module Stream-Info for DataLife Engine
-----------------------------------------------------
NEW AUTHOR: MaD
-----------------------------------------------------
skype: maddog670
icq:    3216327
-----------------------------------------------------
OLD AUTHOR: ksyd
-----------------------------------------------------
icq: 360486149
skype: tlt.pavel-sergeevich
-----------------------------------------------------
Copyright (c) 2015
=====================================================
Данный код защищен авторскими правами
=====================================================
Файл: /engine/inc/stream-info.fnc.php
-----------------------------------------------------
Назначение: Основные функции админпанели и модуля
====================================================*/
if (!defined('DATALIFEENGINE')) {
    die("Hacking attempt!");
}
/*==========================
HTML шаблон Навигации и меню
============================*/
function echomenu()
{
    echo <<<HTML
<div class="box">
  <div class="box-content">
    <div class="row box-section">
        <div class="action-nav-normal action-nav-line" style="width: 780px;margin: 0 auto;">
          <div class="row action-nav-row">            
            <div class="col-sm-1 action-nav-button" style="width: 180px;">
              <a href="?mod=stream-info" class="tip" title="" data-original-title="Общая информация по модулю. Техническая информация, разработчики.">
                <i class="icon-bar-chart"></i>
                <span>Общая информация</span>
              </a>
            </div>            
            <div class="col-sm-1 action-nav-button" style="width: 200px;">
              <a href="?mod=stream-info&action=add" class="tip" title="" data-original-title="Раздел для добавления новой трансляции на сайт.">
                <i class="icon-plus"></i>
                <span>Добавить трансляцию</span>
              </a>
            </div>          
            <div class="col-sm-1 action-nav-button" style="width: 220px;">
              <a href="?mod=stream-info&action=edit" class="tip" title="" data-original-title="Редактивание как отдельной, так и всего списка трансляций. Удаление массовое.">
                <i class="icon-edit"></i>
                <span>Редактирование трансляций</span>
              </a>
            </div>            
            <div class="col-sm-1 action-nav-button" style="width: 180px;">
              <a href="?mod=stream-info&action=settings" class="tip" title="" data-original-title="Выключение модуля, выключение кеша, размеры плеера, заглушки. Настройка всего модуля">
                <i class="icon-cog"></i>
                <span>Настройка модуля</span>
              </a>
            </div>    
          </div>    
        </div>
     </div>
   </div>
</div>
HTML;
}
/*==============
Открытие таблицы
===============*/
function opentable($header)
{
    echo <<<HTML
<div class="box">
  <div class="box-header">
    <div class="title">{$header}</div>
  </div>
  <div class="box-content">
HTML;
}
/*==============
Закрытие таблицы
===============*/
function closetable()
{
    echo <<<HTML
   <div class="box-footer padded"></div>
    </div>
</div>
HTML;
}
/*===========================
Генерация полей для настройки
============================*/
function showRow($title = "", $description = "", $field = "")
{
    echo "<tr>
    <td class=\"col-xs-10 col-sm-6 col-md-7\"><h6>{$title}</h6><span class=\"note large\">{$description}</span></td>
    <td class=\"col-xs-2 col-md-5 settingstd\">{$field}</td>
    </tr>";
}
/*===============================
Генерация чекбоксов для настройки
================================*/
function CheckBox($name, $selected)
{
    $selected = $selected ? "checked" : "";
    return "<input class=\"iButton-icons-tab\" type=\"checkbox\" name=\"$name\" value=\"1\" {$selected}>";
}
/*==============================================
Генерация всего списка стримов которые есть в бд
===============================================*/
function streamList($streams)
{	
	echo '<form action="" method="POST">';
    opentable("Список трансляций");
    echo <<<HTML
<table class="table table-normal table-hover">
<thead>
<tr style="text-align: center;">
<td>Дата:</td>
<td>Заголовок:</td>
<td>Автор:</td>
<td>Сервис:</td>
<td><input id="all" type="checkbox" name="all"></td>
</tr>
</thead>
<tbody>
HTML;
    foreach ($streams as $stream) {
        $stream['date'] = date("d.m.Y", strtotime($stream['date']));
        echo <<<HTML
   <tr style="text-align: center;">
    <td>{$stream['date']}</td>
    <td><a title="Редактировать {$stream['title']}" class="list" href="?mod=stream-info&action=edit&id={$stream['id']}">{$stream['title']}</a></td>
    <td>{$stream['login']}</td>
    <td>{$stream['service']}</td>
    <td><input name="selected_stream[]" value="{$stream['id']}" type="checkbox"><!-- <input class="btn btn-danger btn-mini" type="button" value="Удалить"> --></td>
    </tr>
HTML;
    }
    echo "</tbody>
</table>
</div>";
    
    if ($_REQUEST['action'] == 'edit') {
        echo <<<HTML
<div class="box-footer padded">
          <div class="pull-left"> </div>
          <div class="pull-right">
            <select name="action" class="uniform">
                <option value="">-- Действие --</option>
                <option value="dodelete">Удалить</option>
            </select>
            &nbsp;<input class="btn btn-gold" type="submit" value="Выполнить">
          </div>
		  </form>
</div>
HTML;
    }
    echo <<<HTML
    <div class="box-footer padded"></div>
    </div>
HTML;
echo '</form>';
}
/*==========================
jQuery для ajax обработки
============================*/
function js_code()
{
    echo <<<HTML
<script type="text/javascript">
$(function(){
    $('#clearbutton').click(function() {
        $('#cachez').html('0 b');
        $.get("engine/ajax/stream-info.php?action=clearCache", function( data ){
            Growl.info({
                title: 'Информация',
                text: data
            });
        });
        return false;
    });
    $('#set_title').on('click', function(){
        var titles = $("#title-stream");
        var service = $(".chosen-select option:selected").val();
        var login = $("#login-stream").val();        
        
        if ($.trim(login) == ''){
            DLEalert("<p>Введите логин стримера или его ID</p>", "Информация");
            return false;
        }
        ShowLoading('');
        $.ajax({
            url: "engine/ajax/stream-info.php",
            type: "POST",
            dataType:"json",
            data:{login:login, service:service, action:"setTitle"},
        }).done(function(response){
            if (response.code == 404 || response.title == false){
                DLEalert("<p>"+response.status+"</p>", "Ошибка");
                return false;
            }else{
                if (titles.val() == "" || (titles.val() != response.title)){
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
    $(".chosen-select").chosen();
});
</script>
HTML;
}

/*===============================
Выводим всю информацию по стриму
===============================*/
function getstreaminfo($login)
{
    $login       = totranslit($login);
    $db          = new db();
    $stream_list = $db->super_query("SELECT id, title, login, service, description, pic, date FROM " . PREFIX . "_streams WHERE login = '" . $login . "'", true);
    $info_stream = $stream_list[0];
    return $info_stream;
}
/*============================================================================
Получаем json из сервиса с количеством просмотров, какая игра, тайтл TWITCH.TV
=============================================================================*/
function gettwitch($login, $flag = false)
{
    $path = ($flag) ? "channels/" : "streams/";
    $data = curl_init('https://api.twitch.tv/kraken/' . $path . totranslit($login));
    
    curl_setopt($data, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($data, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($data, CURLOPT_SSL_VERIFYHOST, false);

    $stream_twitch = @curl_exec($data); // при маленькой скорости инета вылетает Maximum execution time
    $stream_twitch = json_decode($stream_twitch, true);
    
    $st = ($flag) ? $stream_twitch : $stream_twitch['stream'];
    curl_close($data);
    return $st;
}
/*==============================================================================
Получаем json из сервиса с количеством просмотров, какая игра, тайтл CYBERGAME.TV
===============================================================================*/
function getcybergame($login)
{
    $stream_cybergame = file_get_contents('http://api.cybergame.tv/w/streams2.php?channel=' . totranslit($login));
    $stream_cybergame = json_decode($stream_cybergame, true);
    return $stream_cybergame;
}
/*==============================================================================
Получаем xml из сервиса с количеством просмотров, какая игра, тайтл GOODGAME.RU
===============================================================================*/
function getgoodgame($login)
{
    $stream_goodgame = simplexml_load_file('http://goodgame.ru/api/getchannelstatus?id=' . totranslit($login));
    return $stream_goodgame;
}
/*=======================================================
Чекаем пользователя на существование на сервисе TWITCH.TV
----------------------------------------------------------
Если Not Found или 404 отдаем False, в остальных True
=========================================================*/
function check_twitch($login)
{
    $data = curl_init('https://api.twitch.tv/kraken/channels/' . totranslit($login));
    
    curl_setopt($data, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($data, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($data, CURLOPT_SSL_VERIFYHOST, false);
    
    $result = curl_exec($data);
    $result = json_decode($result, true);
    curl_close($data);
    if ($result['status'] == '404') {
        return false;
    } elseif ($result['status'] == '422') {
        return true;
    } else {
        return true;
    }
}
/*===================================================
Получаем json посредством костыля xml для GOODGAME.RU
-----------------------------------------------------
Шатал разработчиков GG и кто придумал ключем массива
-----------------------------------------------------
ставить ID канала и отсуствие метода получения id 
===================================================*/
function setTitleGG($login)
{
    $stream_goodgame = file_get_contents("http://goodgame.ru/api/getchannelstatus?id=" . totranslit($login) . "&fmt=json");
    $stream_goodgame = json_decode($stream_goodgame, true);
    $idXml           = getgoodgame(totranslit($login));
    $id              = explode("=>", $idXml->stream->stream_id);
    return $stream_goodgame[$id[0]];
}
/*======================================================
Сохранение настроек модуля после нажатия кнопки отправить
========================================================*/
function saveCfg($savecfg, $stream_config)
{
    //$savecfg = $_POST['savecfg'];
    $savecfg['allow_stream'] = intval($savecfg['allow_stream']);
    $savecfg['showplayer'] = intval($savecfg['showplayer']);
    $savecfg['cache_allow'] = intval($savecfg['cache_allow']);
    $savecfg['cachelife'] = intval($savecfg['cachelife']);
    $savecfg['blocklimit'] = intval($savecfg['blocklimit']);
    $savecfg['width'] = intval($savecfg['width']);
    $savecfg['height'] = intval($savecfg['height']);

    $savecfg = $savecfg + $stream_config;
    
    $filecfg = fopen( ENGINE_DIR . '/data/stream_config.php', "w+" );
    
    fwrite( $filecfg, "<?php \n//Stream\n\$stream_config = array (\n" );
    foreach ( $savecfg as $name => $value ) {
                
        $value = str_replace( "$", "&#036;", $value );
        $value = str_replace( "{", "&#123;", $value );
        $value = str_replace( "}", "&#125;", $value );
        $value = str_replace( chr(0), "", $value );
        $value = str_replace( chr(92), "", $value );
        $value = str_ireplace( "base64_decode", "base64_dec&#111;de", $value );
        
        $name = str_replace( "$", "&#036;", $name );
        $name = str_replace( "{", "&#123;", $name );
        $name = str_replace( "}", "&#125;", $name );
        $name = str_replace( chr(0), "", $name );
        $name = str_replace( chr(92), "", $name );
        $name = str_replace( '(', "", $name );
        $name = str_replace( ')', "", $name );
        $name = str_ireplace( "base64_decode", "base64_dec&#111;de", $name );
        
        fwrite( $filecfg, "'{$name}' => '{$value}',\n" );
    
    }
    fwrite( $filecfg, ");\n?>" );
    fclose( $filecfg );

    if($filecfg) {
        msg("info", "Готово", "Конфигурация успешно сохранена.", "?mod=stream-info&action=settings");
    } else {
        msg("error", "Ошибка", "Не сохранена конфигурация!", "?mod=stream-info&action=settings");
    }
}
/*=====================================
Конверт кодировки с windows в utf-8 ибо
ajax работает только в UTF-8 цука =/
======================================*/
function inv($str)
{
    if (function_exists('iconv')) {
        $str = iconv('windows-1251', 'utf-8', $str);
    }
    return $str;
}
/*==================================================
Подсчет размера определенных *.tmp файлов,
задается как массив array('file1', 'file2', 'file3')
===================================================*/
function calc_cache($caches = array())
{
    $sum = array();
    foreach ($caches as $cache) {
        $sum[] = filesize(ENGINE_DIR . "/cache/".$cache.".tmp");
    }
    return round(array_sum($sum) / 1024, 2) . " Кб";
}