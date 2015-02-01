<?php
/*===================================================
Module Stream-Info for DataLife Engine
-----------------------------------------------------
NEW AUTHOR: MaD
-----------------------------------------------------
skype:       maddog670
icq:        3216327
-----------------------------------------------------
OLD AUTHOR: ksyd
-----------------------------------------------------
icq: 360486149
skype: tlt.pavel-sergeevich
-----------------------------------------------------
Copyright (c) 2015
=====================================================
������ ��� ������� ���������� �������
=====================================================
����: /engine/inc/stream-info.php
-----------------------------------------------------
����������: ���������� ������ � ������������
=====================================================*/
if (!defined('DATALIFEENGINE') OR !defined('LOGGED_IN') OR $member_id['user_group'] != 1) {
    die("Hacking attempt!");
}

@error_reporting(E_ALL ^ E_WARNING ^ E_NOTICE);
@ini_set('display_errors', true);
@ini_set('html_errors', false);
@ini_set('error_reporting', E_ALL ^ E_WARNING ^ E_NOTICE);

require_once(ENGINE_DIR . '/data/stream_config.php');
require_once(ENGINE_DIR . '/inc/stream-info.fnc.php');
require_once(ENGINE_DIR . '/api/api.class.php');

$act = $_REQUEST['action'];

if (empty($act) OR !isset($act)) {
    /*===============================================================
    ������� �������� ������� | ����������� ���������� | ������������
    ================================================================*/
    echoheader("<i class=\"icon-home\"></i> ������� �������� Stream-Info", "�� ���������� �� ������� �������� ������ Stream-Info");
    echomenu();
    js_code();

    streamList($db->super_query("SELECT id, title, login, service, description, pic, date FROM " . PREFIX . "_streams ORDER BY id", true));

    $calcache = calc_cache(array(
        "stream-info",
        "stream-info-block",
        "stream-info-key"
    ));

    if ($stream_config['allow_stream'] == '1') {
        $allow_stream = '<span style="color: green;">�������</span>';
    } else {
        $offline      = "<div class=\"alert alert-error\"><b>�������� ������ ��������:</b><br> ����� ��� ��������� � ������� ���������, �� ������ ������� � <a href='?mod=stream-info&action=settings' alt='������������ ������'><b>������ �������� ������</b></a>.</div>";
        $allow_stream = '<span style="color: red;">��������</span>';
    }
    echo $offline;
    opentable("����������� ����������");
    echo <<<HTML
<div class="box-content">
   <div class="tab-content">
      <div class="tab-pane active" id="statall">
         <div class="row box-section">
            <div class="col-md-3">����� ������ ������:</div>
            <div class="col-md-9">{$allow_stream}</div>
         </div>
         <div class="row box-section">
            <div class="col-md-3">������ Stream-Info:</div>
            <div class="col-md-9">1.5.2</div>
         </div>
         <div class="row box-section">
            <div class="col-md-3">������ ����:</div>
            <div class="col-md-9" id="cachez">{$calcache}</div>
         </div>
         <div class="row box-section">
            <div class="col-md-12">
               <button id="clearbutton" name="clearbutton" class="btn btn-red"><i class="icon-trash"></i> �������� ���</button>
               <div id="main_box"></div>
            </div>
         </div>
      </div>
   </div>
</div>
HTML;
    closetable();
    opentable("������������");
    echo <<<HTML
<table class="table table-normal table-hover">
<tbody>
<tr style="text-align: center;">
    <td><i><b>����� ����������� ������</b></i></td>
    <td><i style="color:red;">������ ����������� ������</i></td>
</tr>
</tbody>
</table>
<table class="table table-normal table-hover">
<tbody>
        <tr>
            <td style="width: 15.3%">���:</td>
            <td style="width: 35.0%;"><b>������</b></td>
            <td>���:</td>
            <td><b>�����</b></td>
        </tr>

        <tr>
            <td>Skype:</td>
            <td><b>maddog670</b></td>
            <td>Skype:</td>
            <td><b>tlt.pavel-sergeevich</b></td>
        </tr>
        <tr>
            <td>ICQ:</td>
            <td>3216327</td>
            <td>ICQ:</td>
            <td>360486149</td>
        </tr>
        <tr>
            <td>Email:</td>
            <td>BleFF_8989@mail.ru</td>
            <td>Email:</td>
            <td>admin@ksyd.ru</td>
        </tr>
</table>
HTML;
    closetable();
} elseif ($act == 'add') {
    /*===========================
    ���������� ����������
    ============================*/
    echoheader("<i class=\"icon-plus\"></i> ���������� ����������", "���������� ����� ���������� �� ����");
    echomenu();
    js_code();
    opentable("�������� ����������");
    echo <<<HTML
<div class="box-content">
<form action="" method="POST" class="form-horizontal">
<div class="tab-content">
 <div class="tab-pane active">
    <div class="row box-section">

        <div class="form-group">
          <label class="control-label col-lg-2">����� ����������:</label>
          <div class="col-lg-10">
            <input id="login-stream" type="text" style="width:100%;max-width:437px;" name="add[login]" required><span class="help-button" data-rel="popover" data-trigger="hover" data-placement="right" data-content="����� ���������� ���������� � ���������� � ����� ��������� �� ����� 100 ��������." data-original-title="" title="">?</span>
          </div>
        </div>

        <div class="form-group">
          <label class="control-label col-lg-2">������ ����������:</label>
          <div class="col-lg-10">
            <select data-placeholder="�������� ������ ..." name="add[service]" class="chosen-select" style="width: 100%; max-width: 437px;">
                <option value="twitch">Twitch.Tv</option>
                    <option value="cybergame">CyberGame.TV</option>
                <option value="goodgame">GoodGame.Ru</option>
            </select><span class="help-button" data-rel="popover" data-trigger="hover" data-placement="right" data-content="������ ���������� ���������� � ����������." data-original-title="" title="">?</span>
          </div>
        </div>

        <div class="form-group">
          <label class="control-label col-lg-2">��������� ����������:</label>
          <div class="col-lg-10">
            <input id="title-stream" type="text" style="width:100%;max-width:437px;" name="add[title]" required><span class="help-button" data-rel="popover" data-trigger="hover" data-placement="right" data-content="��������� ������ ���������� � ���������� � ����� ��������� �� ����� 200 ��������." data-original-title="" title="">?</span>&nbsp;<input id="set_title" style="margin-left:10px;" type="button" class="btn btn-blue" value="���������� �����">
          </div>
        </div>

        <div class="form-group">
          <label class="control-label col-lg-2">������ ����������:</label>
          <div class="col-lg-10">
            <input type="text" style="width:100%;max-width:437px;" name="add[pic]" required><span class="help-button" data-rel="popover" data-trigger="hover" data-placement="right" data-content="����������� ���������� ���������� � ���������� � ����� ��������� ������ ������ �� �����������" data-original-title="" title="">?</span>
          </div>
        </div>

        <div class="form-group">
          <label class="control-label col-lg-2">������� ��������:</label>
          <div class="col-lg-10">
HTML;
    $bb_editor = true;
    include(ENGINE_DIR . '/inc/include/inserttag.php');
    echo <<<HTML
           {$bb_code}<textarea style="width:100%;max-width: 950px;height:200px;" onfocus="setFieldName(this.name)" name="add[descr]" id="short_story" required></textarea>
        </div>
        </div>
    </div>
</div>
</div>
<div class="padded">
<input type="hidden" name="action" value="doadd">
<input type="submit" class="btn btn-green" value="��������">
    </div>
</form>
</div>
HTML;
    closetable();
} elseif ($act == 'doadd') {
    /*===========================
    ���������� ����������
    ===========================*/
    $data = $_POST['add'];

    switch ($data['service']) {
        case 'twitch':
            $twitch_check = check_twitch($data['login']);
            if (!$twitch_check) {
                msg("error", "������", "���������� � ����� ������� �� �������.", "$PHP_SELF?mod=stream-info&action=add");
                die();
            }
            break;

        case 'cybergame':
            $cybergame_check = getcybergame($data['login']);
            if (!$cybergame_check['thumbnail']) {
                msg("error", "������", "���������� � ����� ������� �� �������.", "$PHP_SELF?mod=stream-info&action=add");
                die();
            }
            break;

        case 'goodgame':
            $goodgame_check = getgoodgame($data['login']);
            if (!$goodgame_check->stream->key) {
                msg("error", "������", "���������� � ����� ������� �� �������.", "?mod=stream-info&action=add");
                die();
            }
            break;
    }

    $dbquery = $db->query("INSERT INTO " . PREFIX . "_streams (title, service, login, description, pic) VALUES ('" . htmlspecialchars($data['title'], ENT_QUOTES) . "', '" . htmlspecialchars($data['service'], ENT_QUOTES) . "', '" . strtolower(htmlspecialchars($data['login'], ENT_QUOTES)) . "', '" . htmlspecialchars($data['descr'], ENT_QUOTES) . "', '" . htmlspecialchars($data['pic'], ENT_QUOTES) . "')");

    if ($dbquery) {
        $dle_api->clean_cache("stream-info");
        $dle_api->clean_cache("stream-info-block");
        msg("info", "������", "���������� ������� ���������.", "?mod=stream-info&action=edit");
    } else {
        msg("error", "������", "�� ������� �������� ����������.", "?mod=stream-info&action=edit");
    }
} elseif ($act == 'edit') {
    /*===========================
    �������������� ����������
    ===========================*/
    $id = (int) $_REQUEST['id'];
    echoheader("<i class=\"icon-edit\"></i> �������������� ����������", "�������������� ���������� �����");
    echomenu();
    js_code();
    if (isset($id) && !empty($id)) {
        $stream = $db->super_query("SELECT id, title, login, service, description, pic, date FROM " . PREFIX . "_streams WHERE id = {$id}");
        opentable("������������� ����������");
        echo <<<HTML
<div class="box-content">
<form action="" method="POST" class="form-horizontal">
<div class="tab-content">
 <div class="tab-pane active">
    <div class="row box-section">

        <div class="form-group">
          <label class="control-label col-lg-2">����� ����������:</label>
          <div class="col-lg-10">
            <input id="login-stream" type="text" style="width:100%;max-width:437px;" name="edit[login]" value="{$stream['login']}" required><span class="help-button" data-rel="popover" data-trigger="hover" data-placement="right" data-content="����� ���������� ���������� � ���������� � ����� ��������� �� ����� 100 ��������." data-original-title="" title="">?</span>
          </div>
        </div>

        <div class="form-group">
          <label class="control-label col-lg-2">������ ����������:</label>
          <div class="col-lg-10">
            <select data-placeholder="�������� ������ ..." name="edit[service]" class="chosen-select" style="width: 100%; max-width: 437px;">
                <option value="{$stream['service']}" selected="">---�������� ��� ��---</option>
                <option value="twitch">Twitch.Tv</option>
                    <option value="cybergame">CyberGame.TV</option>
                <option value="goodgame">GoodGame.Ru</option>
            </select><span class="help-button" data-rel="popover" data-trigger="hover" data-placement="right" data-content="������ ���������� ���������� � ����������." data-original-title="" title="">?</span>
          </div>
        </div>

        <div class="form-group">
          <label class="control-label col-lg-2">��������� ����������:</label>
          <div class="col-lg-10">
            <input id="title-stream" type="text" style="width:100%;max-width:437px;" name="edit[title]" value="{$stream['title']}" required><span class="help-button" data-rel="popover" data-trigger="hover" data-placement="right" data-content="��������� ������ ���������� � ���������� � ����� ��������� �� ����� 200 ��������." data-original-title="" title="">?</span>&nbsp;<input id="set_title" style="margin-left:10px;" type="button" class="btn btn-blue" value="���������� �����">
          </div>
        </div>

        <div class="form-group">
          <label class="control-label col-lg-2">������ ����������:</label>
          <div class="col-lg-10">
            <input type="text" style="width:100%;max-width:437px;" name="edit[pic]" value="{$stream['pic']}" required><span class="help-button" data-rel="popover" data-trigger="hover" data-placement="right" data-content="����������� ���������� ���������� � ���������� � ����� ��������� ������ ������ �� �����������" data-original-title="" title="">?</span>
          </div>
        </div>

        <div class="form-group">
          <label class="control-label col-lg-2">������� ��������:</label>
          <div class="col-lg-10">
HTML;
        $bb_editor = true;
        include(ENGINE_DIR . '/inc/include/inserttag.php');
        echo <<<HTML
           {$bb_code}<textarea style="width:100%;max-width: 950px;height:300px;" onfocus="setFieldName(this.name)" name="edit[descr]" id="short_story" required>{$stream['description']}</textarea>
        </div>
        </div>
    </div>
</div>
</div>
<div class="padded">
<input type="hidden" name="id" value="{$id}">
<input type="hidden" name="action" value="doedit">
<input type="submit" class="btn btn-green" value="��������">
    </div>
</form>
</div>
HTML;
        closetable();
    } else {
        streamList($db->super_query("SELECT id, title, login, service, description, pic, date FROM " . PREFIX . "_streams ORDER BY id", true));
    }
    closetable();
} elseif ($act == 'doedit') {
    /*===========================
    �������������� ����������
    ===========================*/
    $id   = (int) $_POST['id'];
    $data = $_POST['edit'];

    switch ($data['service']) {
        case 'twitch':
            $twitch_check = check_twitch($data['login']);
            if (!$twitch_check) {
                msg("error", "������", "���������� � ����� ������� �� �������.", "?mod=stream-info&action=edit");
                die();
            }
            break;

        case 'cybergame':
            $cybergame_check = getcybergame($data['login']);
            if (!$cybergame_check['thumbnail']) {
                msg("error", "������", "���������� � ����� ������� �� �������.", "?mod=stream-info&action=edit");
                die();
            }
            break;

        case 'goodgame':
            $goodgame_check = getgoodgame($data['login']);
            if (!$goodgame_check->stream->key) {
                msg("error", "������", "���������� � ����� ������� �� �������.", "?mod=stream-info&action=edit");
                die();
            }
            break;
    }

    $dbquery = $db->query("UPDATE " . PREFIX . "_streams SET title = '" . htmlspecialchars($data['title'], ENT_QUOTES) . "', service = '" . htmlspecialchars($data['service'], ENT_QUOTES) . "', login = '" . strtolower(htmlspecialchars($data['login'], ENT_QUOTES)) . "', description = '" . htmlspecialchars($data['descr'], ENT_QUOTES) . "', pic = '" . htmlspecialchars($data['pic'], ENT_QUOTES) . "' WHERE id = '" . $id . "'");

    if ($dbquery) {
        $dle_api->clean_cache("stream-info");
        $dle_api->clean_cache("stream-info-block");
        msg("info", "������", "���������� ������� ����������������.", "?mod=stream-info&action=edit");
    } else {
        msg("error", "������", "�� ������� �������� ��������� � ���� ������.", "?mod=stream-info&action=edit");
    }
    
} elseif ($act == 'dodelete') {
    /*===========================
    �������� ����������
    ===========================*/
	$ids     = $_POST['selected_stream'];
    $deleted = 0;
	print_r($ids);
    foreach ($ids as $id) {
        $db->query("DELETE FROM " . PREFIX . "_streams WHERE id= '" . intval($id) . "'");
        $deleted++;
    }
    msg("info", "������", $deleted . " ��������(��) �������.", "?mod=stream-info&action=edit");
	
} elseif ($act == 'savesettings') {

saveCfg($_POST['savecfg'], $stream_config);

} elseif ($act == 'settings') {
    /*===========================
    ��������� ������
    ===========================*/
    echoheader("<i class=\"icon-cog\"></i> �������� ��������� ������", "������ ��������� ������ Stream-Info �� ��� �����");
    echomenu();
    opentable("��������� ������");

    echo <<<HTML
    <form action="" method="POST">
    <div class="box-content">
    <table class="table table-normal">
HTML;
    showRow("<b>�������� ������?</b>", "������ ����� �������� ���������� ������ �� �����.", CheckBox('savecfg[allow_stream]', "{$stream_config['allow_stream']}"));
    showRow("<b>�������� ����� � ������� ���������� � ����������?</b>", "<span style=\"color:red;\">��������! ������������� ���� ������� ��������� �������.</span>", CheckBox('savecfg[showplayer]', "{$stream_config['showplayer']}"));
    showRow("<b>�������� ����������� ������ ����������?</b>", "������� �������� ����� ������ ����������.", CheckBox('savecfg[cache_allow]', "{$stream_config['cache_allow']}"));
    showRow("����� ����� ����", "� ������� (60/120/180/etc)", "<input type=\"text\" style=\"width:100%;\" name=\"savecfg[cachelife]\" value=\"{$stream_config['cachelife']}\" size=\"25\">");
    showRow("���������� ���������� �� �������", "������� ���������� ���������� � ����� '{stream-info}'.", "<input type=\"text\" style=\"width:100%;\" name=\"savecfg[blocklimit]\" value=\"{$stream_config['blocklimit']}\" size=\"25\">");
    showRow("������ ������", "� ��������.", "<input type=\"text\" style=\"width:100%;\" name=\"savecfg[width]\" value=\"{$stream_config['width']}\" size=\"25\">");
    showRow("������ ������", "� ��������.", "<input type=\"text\" style=\"width:100%;\" name=\"savecfg[height]\" value=\"{$stream_config['height']}\" size=\"25\">");
    showRow("������ ������", "��������� ��� ������ �������.", "<input type=\"text\" style=\"width:100%;\" name=\"savecfg[online]\" value=\"{$stream_config['online']}\" size=\"25\">");
    showRow("������ �������", "��������� ��� ������ �������.", "<input type=\"text\" style=\"width:100%;\" name=\"savecfg[offline]\" value=\"{$stream_config['offline']}\" size=\"25\">");
    showRow("�������� ��� ������", "���� ���������� �������, ������������ �������� (����������� BB-����).", "<input type=\"text\" style=\"width:100%;\" name=\"savecfg[zagluska]\" value=\"{$stream_config['zagluska']}\" size=\"25\">");
    showRow("�������� (�����) ������", "����� ������ ������� ����� ������������ � ��������", "<input type=\"text\" style=\"width:100%;\" name=\"savecfg[stream_title]\" value=\"{$stream_config['stream_title']}\" size=\"25\">");
    showRow("�������� (Description) ������", "������� ��������, �� ����� 200 ��������.", "<input type=\"text\" style=\"width:100%;\" name=\"savecfg[stream_desc]\" value=\"{$stream_config['stream_desc']}\" size=\"25\">");
    showRow("�������� ����� (Keywords) ��� ������", "������� ����� ������� �������� �������� �����.", "<input type=\"text\" style=\"width:100%;\" name=\"savecfg[stream_keywords]\" value=\"{$stream_config['stream_keywords']}\" size=\"25\">");
    showRow("", "", "<input type=\"hidden\" name=\"action\" value=\"savesettings\">", false);
    showRow("<input type=\"submit\" class=\"btn btn-success\" value=\"��������� ���������\">");
    echo <<<HTML
    </table>
    </div>
    </form>
HTML;
    closetable();
}
echofooter();