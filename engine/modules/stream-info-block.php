<?php
/*=============================================
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
==============================================
 Данный код защищен авторскими правами
==============================================
 Файл: /engine/modules/stream-info-block.php
-----------------------------------------------------
 Назначение: Вывод блока стримов на главной странице
==============================================*/

if(!defined('DATALIFEENGINE'))
{
  die("Hacking attempt!");
}

require_once(ENGINE_DIR.'/inc/stream-info.fnc.php');
require_once(ENGINE_DIR.'/data/stream_config.php');
require_once(ENGINE_DIR.'/classes/parse.class.php');
require_once(ENGINE_DIR.'/api/api.class.php');
$parse = new ParseFilter();

/*=====================================
БЛОК ДЛЯ ВЫВОДА НА ГЛАВНУЮ СТРАНИЦУ
=====================================*/
if ($stream_config['allow_stream'] == 'yes'){// включен модуль или нет

    $stream_list = $db->super_query( "SELECT * FROM " . PREFIX . "_streams ORDER BY id", true );
    $stream_count = count($stream_list);
    $out = 0;

    if($stream_count > 0) {
            if($config['allow_cache'] != 'yes') {
                    $config['allow_cache'] = 'yes';
                    $cache = true;
            }
            if($stream_config['cache_allow'] == 'yes') {
                    $tpl->result['streams'] = $dle_api->load_from_cache( "stream-info-block", $stream_config['cachelife']);
            }
            if(!$tpl->result['streams']) {
                    $tpl->load_template('stream-main.tpl');
                    for($i = 0; $i < $stream_count; $i++) {
                            if($out != $stream_config['blocklimit']){
                                    $info_stream = $stream_list[$i];
                                    switch($info_stream['service']) {
                                            /*********************СПИСОК СТРИМОВ НА ГЛАВНУЮ СТРАНИЦУ ВЫВОД БЛОКА******************/
                                            case 'twitch':
                                                    $stream_twitch = gettwitch($info_stream['login']);

                                                    if($stream_twitch != NULL) {
                                                            $tpl->set('{title}', $info_stream['title']);
                                                            $tpl->set('{streamer}', $info_stream['login']);
                                                            $tpl->set('{streampic}', $info_stream['pic']);
                                                            $tpl->set('{description}', $parse->BB_Parse($info_stream['description']));
                                                            $tpl->set('{viewers}', $stream_twitch['viewers']);
                                                            $tpl->set('{status}', $stream_config['online']);
                                                            $tpl->set('{games}', $stream_twitch['game']);
                                                            if($stream_config['showplayer'] == 'yes') {
                                                                    $tpl->set('{player}', '<object type="application/x-shockwave-flash" height="'.$stream_config['height'].'" width="'.$stream_config['width'].'" id="live_embed_player_flash" data="http://www.twitch.tv/widgets/live_embed_player.swf?channel='.$info_stream['login'].'" bgcolor="#000000"><param name="allowFullScreen" value="true" /><param name="allowScriptAccess" value="always" /><param name="allowNetworking" value="all" /><param name="movie" value="http://www.twitch.tv/widgets/live_embed_player.swf" /><param name="flashvars" value="hostname=www.twitch.tv&channel='.$info_stream['login'].'&auto_play=true&start_volume=25" /></object>');
                                                            } else {
                                                                    $tpl->set('{player}', 'Вывод плеера отключено в настройках!');
                                                            }
                                                            $tpl->compile('streams');
                                                            $out++;
                                                    }	
                                                    break;
                                            /* cybergame.tv */
                                            case 'cybergame':
                                                    $stream_cybergame = getcybergame($info_stream['login']);

                                                    if($stream_cybergame['online'] == '1') {
                                                            $tpl->set('{title}', $info_stream['title']);
                                                            $tpl->set('{streamer}', $info_stream['login']);
                                                            $tpl->set('{streampic}', $info_stream['pic']);
                                                            $tpl->set('{description}', $parse->BB_Parse($info_stream['description']));
                                                            $tpl->set('{status}', $stream_config['online']);
                                                            $tpl->set('{viewers}', $stream_cybergame['viewers']);
                                                            $tpl->set('{games}', $stream_cybergame['channel_game']);
                                                            if($stream_config['showplayer'] == 'yes') {
                                                                    $tpl->set('{player}', '<iframe src="http://api.cybergame.tv/p/embed.php?c='.$info_stream['login'].'&w='.$stream_config['width'].'&h='.$stream_config['height'].'&type=embed" width="'.$stream_config['width'].'" height="'.$stream_config['height'].'" frameborder="0"></iframe>');
                                                            } else {
                                                                    $tpl->set('{player}', 'Вывод плеера отключено в настройках!');
                                                            }
                                                            $tpl->compile('streams');
                                                            $out++;
                                                    }
                                                    break;
                                            /* goodgame.ru */
                                            case 'goodgame':
                                                            $stream_goodgame = getgoodgame($info_stream['login']);

                                                    if($stream_goodgame->stream->status == 'Live') {
                                                            $tpl->set('{title}', $info_stream['title']);
                                                            $tpl->set('{streamer}', $info_stream['login']);
                                                            $tpl->set('{streampic}', $info_stream['pic']);
                                                            $tpl->set('{description}', $parse->BB_Parse($info_stream['description']));
                                                            $tpl->set('{status}', $stream_config['online']);
                                                            $tpl->set('{viewers}', $stream_goodgame->stream->viewers);
                                                            $tpl->set('{games}', $stream_goodgame->stream->games);
                                                            if($stream_config['showplayer'] == 'yes') {
                                                                    $tpl->set('{player}', '<div style="width: '.$stream_config['width'].'px;height: '.$stream_config['height'].'px;">'.$stream_goodgame->stream->embed.'</div>');
                                                            } else {
                                                                    $tpl->set('{player}', 'Вывод плеера отключено в настройках!');
                                                            }
                                                            $tpl->compile('streams');
                                                            $out++;
                                                    }
                                                    break;
                                    }
                            } else { break; }
                    }
                    if($stream_config['cache_allow'] == 'yes') {
                            $dle_api->save_to_cache ( "stream-info-block", $tpl->result['streams']);
                    }
                    $tpl->clear();
            }
    }
}