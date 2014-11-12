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
 Данный код защищен авторскими правами
==========================================================
 Файл: /engine/modules/stream-info.php
----------------------------------------------------------
 Назначение: Вывод блока стримов всех стримов на ?do=stream
 Назначение: Просмотр стрима определенного юзера
==========================================================*/

if(!defined('DATALIFEENGINE'))
{
  die("Hacking attempt!");
}

require_once(ENGINE_DIR.'/inc/stream-info.fnc.php');
require_once(ENGINE_DIR.'/data/stream_config.php');
require_once(ENGINE_DIR.'/classes/parse.class.php');
require_once(ENGINE_DIR.'/api/api.class.php');

$parse = new ParseFilter();
$full_stream = $_REQUEST['stream'];
$work = TRUE;

/*==============================
Страница трансляции пользователя
==============================*/

if ($stream_config['allow_stream'] == 'yes'){

if($full_stream) {
	$full_stream = strtolower($full_stream);
	$info_stream = getstreaminfo($full_stream);
	/*SEO MODULE*/
	$stream_descr = $info_stream['title'];
	if( $stream_config['stream_keywords'] == '' AND $stream_config['stream_desc'] == '' ) create_keywords( $full_stream );
	else {
		$metatags['keywords'] = stripslashes($stream_config['stream_keywords']);
		$metatags['description'] = stripslashes( strip_tags($stream_config['stream_desc']));
	}
	if ($stream_config['stream_title']) $metatags['header_title'] = $info_stream['title'] . " &raquo; Пользователь ".$full_stream;
	/*SEO MODULE*/
	$tpl->load_template('stream-full.tpl');
	
	/* FIX v1.01 */
	if($full_stream != $info_stream['login']) {
		$tpl->load_template( 'info.tpl' );
		$tpl->set( '{error}', 'Прямая трансляция не найдена' );
		$tpl->set( '{title}', 'Ошибка' );
		$tpl->compile('info');
		$tpl->clear();
		$work = FALSE;
	}
	/* FIX v1.01 */
	
	if($work) {
		switch($info_stream['service']) {
			case 'cybergame':
				$stream_cybergame = getcybergame($info_stream['login']);
				
				if($stream_cybergame['online'] == '1') {
					$tpl->set('{title}', $info_stream['title']);
					$tpl->set('{streamer}', $info_stream['login']);
					$tpl->set('{streampic}', $info_stream['pic']);
					$tpl->set('{description}', $parse->BB_Parse($info_stream['description']));
					$tpl->set('{status}', $stream_config['online']);
					$tpl->set('{viewers}', $stream_cybergame['viewers']);
					$tpl->set('{player}', '<iframe src="http://api.cybergame.tv/p/embed.php?c='.$info_stream['login'].'&w='.$stream_config['width'].'&h='.$stream_config['height'].'&type=embed" width="'.$stream_config['width'].'" height="'.$stream_config['height'].'" frameborder="0"></iframe>');					
					$tpl->compile('content');
					$tpl->clear();
				} else { 
					$tpl->set('{title}', $info_stream['title']);
					$tpl->set('{streamer}', $info_stream['login']);
					$tpl->set('{streampic}', $info_stream['pic']);
					$tpl->set('{description}', $parse->BB_Parse($info_stream['description']));
					$tpl->set('{status}', $stream_config['offline']); 
					$tpl->set('{viewers}', '0');
					$tpl->set('{player}', $parse->BB_Parse($stream_config['gluska']));
					$tpl->compile('content');
					$tpl->clear();
				}
				break;
			case 'goodgame':
				$stream_goodgame = getgoodgame($info_stream['login']);
				
				if($stream_goodgame->stream->status == 'Live') {
					$tpl->set('{title}', $info_stream['title']);
					$tpl->set('{streamer}', $info_stream['login']);
					$tpl->set('{streampic}', $info_stream['pic']);
					$tpl->set('{description}', $parse->BB_Parse($info_stream['description']));
					$tpl->set('{status}', $stream_config['online']);
					$tpl->set('{viewers}', $stream_goodgame->stream->viewers);
					$tpl->set('{player}', '<div style="width: '.$stream_config['width'].'px;height: '.$stream_config['height'].'px;">'.$stream_goodgame->stream->embed.'</div>');
					$tpl->compile('content');
					$tpl->clear();
				} else {
					$tpl->set('{title}', $info_stream['title']);
					$tpl->set('{streamer}', $info_stream['login']);
					$tpl->set('{streampic}', $info_stream['pic']);
					$tpl->set('{description}', $parse->BB_Parse($info_stream['description']));
					$tpl->set('{status}', $stream_config['offline']);
					$tpl->set('{viewers}', '0');
					$tpl->set('{player}', $parse->BB_Parse($stream_config['gluska']));
					$tpl->compile('content');
					$tpl->clear();
				}
			break;
			case 'twitch':
				$stream_twitch = gettwitch($info_stream['login']);

				if($stream_twitch == NULL) {
					$tpl->set('{title}', $info_stream['title']);
					$tpl->set('{streamer}', $info_stream['login']);
					$tpl->set('{streampic}', $info_stream['pic']);
					$tpl->set('{description}', $parse->BB_Parse($info_stream['description']));
					$tpl->set('{viewers}', '0');
					$tpl->set('{status}', $stream_config['offline']);
					$tpl->set('{player}', $parse->BB_Parse($stream_config['gluska']));
					$tpl->compile('content');
					$tpl->clear();
				} else {
					$tpl->set('{title}', $info_stream['title']);
					$tpl->set('{streamer}', $info_stream['login']);
					$tpl->set('{streampic}', $info_stream['pic']);
					$tpl->set('{description}', $parse->BB_Parse($info_stream['description']));
					$tpl->set('{viewers}', $stream_twitch['viewers']);
					$tpl->set('{status}', $stream_config['online']);
					$tpl->set('{player}', '<object type="application/x-shockwave-flash" height="'.$stream_config['height'].'" width="'.$stream_config['width'].'" id="live_embed_player_flash" data="http://www.twitch.tv/widgets/live_embed_player.swf?channel='.$info_stream['login'].'" bgcolor="#000000"><param name="allowFullScreen" value="true" /><param name="allowScriptAccess" value="always" /><param name="allowNetworking" value="all" /><param name="movie" value="http://www.twitch.tv/widgets/live_embed_player.swf" /><param name="flashvars" value="hostname=www.twitch.tv&channel='.$info_stream['login'].'&auto_play=false&start_volume=25" /></object>');
					$tpl->compile('content');
					$tpl->clear();
				}	
			break;
		}
	}
} else {
	/*==============================================
	 Список всех трансляций которые добавлены в базу
	===============================================*/	
	/*SEO MODULE*/
	if( $stream_config['stream_keywords'] == '' AND $stream_config['stream_desc'] == '' ) create_keywords( 'stream-info-main' );
	else {
	$metatags['keywords'] = stripslashes($stream_config['stream_keywords']);
	$metatags['description'] = stripslashes( strip_tags($stream_config['stream_desc']));
	}
	if ($stream_config['stream_title']) $metatags['header_title'] = $stream_config['stream_title'];
	$stream_descr = $stream_config['stream_title'];
	/*SEO MODULE*/
	if($stream_config['cache_allow'] == 'yes') {
            if($config['allow_cache'] != 'yes') {
                    $config['allow_cache'] = 'yes'; 
                    $cache = true; 
            }	
            $tpl->result['content'] = $dle_api->load_from_cache( "stream-info", $stream_config['cachelife']);
	}
	
	if(!$tpl->result['content']) {
		$stream_list = $db->super_query( "SELECT * FROM " . PREFIX . "_streams ORDER BY id", true );
		$stream_count = count($stream_list);
	
		if($stream_count < 1) {
			$tpl->load_template( 'info.tpl' );
			$tpl->set( '{error}', 'Прямых трансляций не найдено ' );
			$tpl->set( '{title}', 'Внимание' );
			$tpl->compile('info');
			$tpl->clear();
		} else {
			$tpl->load_template('stream-all.tpl');
			
			/*============================================
			Блок вывода всех стримов на странице ?do=stream
			=============================================*/
			for($i = 0; $i < $stream_count; $i++) {
				$info_stream = $stream_list[$i];
				switch($info_stream['service']){
					case 'twitch':
                     $stream_twitch = gettwitch($info_stream['login']);                                            
						if($stream_twitch != NULL) {
							$tpl->set('{title}', $info_stream['title']);
							$tpl->set('{streamer}', $info_stream['login']);
							$tpl->set('{streampic}', $info_stream['pic']);
							$tpl->set('{description}', $parse->BB_Parse($info_stream['description']));
							$tpl->set('{viewers}', $stream_twitch['viewers']);
							$tpl->set('{status}', $stream_config['online']);
							if($stream_config['showplayer'] == 'yes') {
								$tpl->set('{player}', '<object type="application/x-shockwave-flash" height="'.$stream_config['height'].'" width="'.$stream_config['width'].'" id="live_embed_player_flash" data="http://www.twitch.tv/widgets/live_embed_player.swf?channel='.$info_stream['login'].'" bgcolor="#000000"><param name="allowFullScreen" value="true" /><param name="allowScriptAccess" value="always" /><param name="allowNetworking" value="all" /><param name="movie" value="http://www.twitch.tv/widgets/live_embed_player.swf" /><param name="flashvars" value="hostname=www.twitch.tv&channel='.$info_stream['login'].'&auto_play=false&start_volume=25" /></object>');
							} else {
								$tpl->set('{player}', 'Вывод плеера отключено в настройках!');
							}
							$tpl->compile('content');
						}elseif($stream_twitch == NULL) {
							$tpl->set('{title}', $info_stream['title']);
							$tpl->set('{streamer}', $info_stream['login']);
							$tpl->set('{streampic}', $info_stream['pic']);
							$tpl->set('{description}', $parse->BB_Parse($info_stream['description']));
							$tpl->set('{viewers}', '0');
							$tpl->set('{status}', $stream_config['offline']);
						}
						$tpl->compile('content');
						break;
					case 'cybergame':
						$stream_cybergame = getcybergame($info_stream['login']);
							
						if($stream_cybergame['online'] == '1') {
							$tpl->set('{title}', $info_stream['title']);
							$tpl->set('{streamer}', $info_stream['login']);
							$tpl->set('{streampic}', $info_stream['pic']);
							$tpl->set('{description}', $parse->BB_Parse($info_stream['description']));
							$tpl->set('{status}', $stream_config['online']);
							$tpl->set('{viewers}', $stream_cybergame['viewers']);
							if($stream_config['showplayer'] == 'yes') {
								$tpl->set('{player}', '<iframe src="http://api.cybergame.tv/p/embed.php?c='.$info_stream['login'].'&w='.$stream_config['width'].'&h='.$stream_config['height'].'&type=embed" width="'.$stream_config['width'].'" height="'.$stream_config['height'].'" frameborder="0"></iframe>');
							} else {
								$tpl->set('{player}', 'Вывод плеера отключено в настройках!');
							}
						}elseif($stream_cybergame['online'] == '0') {
							$tpl->set('{title}', $info_stream['title']);
							$tpl->set('{streamer}', $info_stream['login']);
							$tpl->set('{streampic}', $info_stream['pic']);
							$tpl->set('{description}', $parse->BB_Parse($info_stream['description']));
							$tpl->set('{status}', $stream_config['offline']);
							$tpl->set('{viewers}', '0');
						}
						$tpl->compile('content');
						break;
					case 'goodgame':
						$stream_goodgame = getgoodgame($info_stream['login']);
						
						if($stream_goodgame->stream->status == 'Live') {
							$tpl->set('{title}', $info_stream['title']);
							$tpl->set('{streamer}', $info_stream['login']);
							$tpl->set('{streampic}', $info_stream['pic']);
							$tpl->set('{description}', $parse->BB_Parse($info_stream['description']));
							$tpl->set('{status}', $stream_config['online']);
							$tpl->set('{viewers}', $stream_goodgame->stream->viewers);
							if($stream_config['showplayer'] == 'yes') {
								$tpl->set('{player}', '<div style="width: '.$stream_config['width'].'px;height: '.$stream_config['height'].'px;">'.$stream_goodgame->stream->embed.'</div>');
							} else {
								$tpl->set('{player}', 'Вывод плеера отключено в настройках!');
							}							
						}elseif($stream_goodgame->stream->status == 'Dead') {
							$tpl->set('{title}', $info_stream['title']);
							$tpl->set('{streamer}', $info_stream['login']);
							$tpl->set('{streampic}', $info_stream['pic']);
							$tpl->set('{description}', $parse->BB_Parse($info_stream['description']));
							$tpl->set('{status}', $stream_config['offline']);
							$tpl->set('{viewers}', '0');
						}
						$tpl->compile('content');
						}
						break;
				}
			}
			
			if($stream_config['cache_allow'] == 'yes') {
				$dle_api->save_to_cache ( "stream-info", $tpl->result['content']);
			}
			$tpl->clear();
		}
	}
}
