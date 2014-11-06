STREAM-INFO - это модуль DLE, который позволит организовать на вашем сайте раздел прямых трансляций. 
=
На данный момент модуль обновлялся для DATALIFE ENGINE 10.1. На старших или младших версия DLE не проверялся.

##Основные возможности:
1. Поддержка популярных сервисов (twitch.tv, cybergame.tv, goodgame.ru).
2. Вывод информации о прямой трансляции (количество зрителей, статус прямой трансляции, плеер, и т.п.).
3. Заглушка для оффлайн трансляций (устанавливается в конфиге).
4. Вывод трансляций по статусу (сперва онлайн трансляции, затем оффлайн).
5. Собственный установщик модуля (с защитой от повторной установки).
6. Собственные шаблоны для краткой и полной информации о трансляции.
7. Удаление и редактирование трансляций в ПУ.
8. Использование ББ-кодов в описании трансляции.

Установка
--------------
Измените название папки шаблона на свой и загрузите всё из папки upload в корень.
Далее запустите установщик: **http://вашсайт.ru/stream-install.php**
**После удачной установки удалите файл stream-install.php**

1 В **engine/engine.php** после:
```php
case "pm" :
	include ENGINE_DIR . '/modules/pm.php';
	break;
```
Вставить:
```php
case "stream-info" :
	include ENGINE_DIR.'/modules/stream-info.php';
	break;
```
1.1 После:
```php
elseif ($do == 'tags') $nam_e = stripslashes($tag);
```
Вставить:
```php
elseif ($do == 'stream-info') $nam_e = $stream_descr;
```
2 В **index.php** после:
```php
require_once ROOT_DIR . '/engine/init.php';
```
Вставить:
```php
require_once ENGINE_DIR.'/modules/stream-info-block.php';
```
2.1 После:
```php
$tpl->set ( '{speedbar}', $tpl->result['speedbar'] );
```
Вставить:
```php
if( $tpl->result['streams'] != "" ) {
    $tpl->set ( '[stream-info]', "" );
    $tpl->set ( '{stream-info}', $tpl->result['streams'] );
    $tpl->set ( '[/stream-info]', "" );
} else {
    $tpl->set_block ( "'\\[stream-info\\](.*?)\\[/stream-info\\]'si", "" );
}
```
Чтобы использовать ЧПУ в модуле Stream-Info, в файле "**.htaccess**" после:
```ApacheConf
RewriteRule ^page/([0-9]+)(/?)$ index.php?cstart=$1 [L]
```

Вставить:
```ApacheConf
# Stream-Info
RewriteRule ^stream(/?)+$ index.php?do=stream-info [L]
RewriteRule ^stream/([^/]*)(/?)+$ index.php?do=stream-info&stream=$1 [L]
```
Информация по шаблонам
--------------
Модуль включает в себя 3 шаблона:
* stream-all.tpl (краткая информация о трансляции в разделе модуля) 
* stream-full.tpl (полная информация о трансляции в разделе модуля)
* stream-main.tpl (краткая информация о трансляции в блоке ``{stream-info}``)

Шаблон Stream-All
--------------
В шаблонах stream-all.tpl и stream-main.tpl можно использовать теги:
* ``{title}`` - название трансляции (из БД).
* ``{streampic}`` - ссылка на изображение (из БД).
* ``{description}`` - описание трансляции (из БД).
* ``{viewers}`` - количество зрителей (запрос к серверу трансляций).
* ``{streamer}`` - логин автора трансляции (из БД).
* ``{status}`` - статус трансляции (запрос к серверу трансляций). (выводит онлайн\оффлайн сообщение установленное в конфиге)
* ``{player}`` - выводит плеер трансляции для онлайн канала и заглушку из конфига для оффлайн. Заглушка,высота и ширина задаются в конфиге.

Для указания ссылки на страницу трансляции, используйте тег ``{streamer}``. Пример: ``<a href="/stream/{streamer}">{title}</a>``

Шаблон Stream-Full
--------------
В шаблоне stream-full.tpl можно использовать теги:
* ``{title}`` - название трансляции (из БД).
* ``{streampic}`` - ссылка на изображение (из БД).
* ``{description}`` - описание трансляции (из БД).
* ``{viewers}`` - количество зрителей (запрос к серверу трансляций).
* ``{streamer}`` - логин автора трансляции (из БД).
* ``{status}`` - статус трансляции (запрос к серверу трансляций). (выводит онлайн\оффлайн сообщение установленное в конфиге)
* ``{player}`` - выводит плеер трансляции для онлайн канала и заглушку из конфига для оффлайн. Заглушка,высота и ширина задаются в конфиге.

Блок онлайн трансляций можно вызвать тегом ``{stream-info}``.

#TODO
* Чат для трансляций
* Обновление установщика
* Обновление до 10.3 код и шаблона
* Постинг у вк группу при добавлении стрима и когда трансляция online/offline
* Добавление трансляций пользователями
* Ajax плюшки
* Формирование ЧПУ от выбора в настройке

Список изменений 1.5
--------------
* Фикс сервиса twitch.tv, из-за отключения сервиса justin.tv
* Оптимизация кода
* Добавлена новая ajax функция "Получить тайтл из стрима" в ПУ
* Структура шаблона изменена
* Добавлен Description, Title и Keywords
* Убраны дубли страниц
* Подключен WYSING
* Добавлены теги ``[stream-info][/stream-info]`` для главной страницы. При отсутствии странсляций блок будет вырезаться

Список изменений 1.4
--------------
* Полностью переписан весь код модуля (включая установщик).
* Новый дизайн установщика и ПУ.
* Добавлена возможность отключения кэширования.
* Добавлена возможность вставки плеера в список трансляций (включается в ПУ).
* Очистка кэша модуля.
* Проверка обновлений из ПУ.
* Добавлена панель ББ-кодов при редактировании\добавлении трансляции.
* Загрузка изображения на сервер при редактировании\добавлении трансляции.
* Исправление мелких багов.

STREAM-INFO V1.3
--------------
* Добавлено кеширование списка трансляций. Время устанваливается в админ панели.
* Добавлена возможность вывода блока онлайн стримов в другие разделы вашего сайта. Так же, вы можете ограничить колличество выводимых
трансляций в админ панели (по-умолчанию 3 трансляции).
* Добавлена мини-документация по шаблонам.
* Изменён алгоритм проверки ключа. Теперь проверка проходит намного быстрее, чем раньше.

STREAM-INFO V1.2
--------------
* Добавлена проверка ключа. Если ключ не валиден, стримы не выводиться, а вместо них сообщение: 
для пользователей - "Прямые трансляции временно не доступны"
для администраторов - "Модуль STREAM-INFO не зарегистрирован!"
* Теперь при добавлении трансляции совершается проверка на существование логина. Если логин не валиден, выводится сообщение об ошибке!