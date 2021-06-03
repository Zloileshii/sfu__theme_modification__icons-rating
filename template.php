<?php

///////////////////// инициализация переменных /////////////////////
$drupal_version = 5;

if (!function_exists('menu_in_active_trail'))
  $drupal_version = 6;

if (function_exists('menu_set_active_menu_names'))
  $drupal_version = 7;

define('DRUPAL_VERSION', $drupal_version);
define('DRUPAL6', DRUPAL_VERSION > 5);
unset($drupal_version);

///////////////////// подключение JS и CSS /////////////////////
_sfu2016_includes();

// Совместимость с Drupal и Yii.
function _sfu2016_base_path()
{
  return function_exists('base_path') ? base_path() : '';
}

function _sfu2016_path_to_theme()
{

  return _sfu2016_base_path() . path_to_theme();
}

function _sfu2016_includes()
{
  // унификация локали (чтобы в drupal 6, 7 тоже была глобальная переменная $locale)
  global $locale, $language;

  if (DRUPAL_VERSION > 5 && !$locale) {
    $locale = $language->language;
  }

  require('includes/api.inc.php');
  require('includes/pager.inc.php');

  $theme = path_to_theme();

  if (DRUPAL_VERSION == 7) {
    $theme = str_replace('/themes/', '/themes6/', $theme);
  }

  $v = DRUPAL_VERSION == 5 ? '?v27' : ''; // версия CSS/JS для Drupal 5 для очистки кэша браузера при изменениях (глючит, отключено)

  // подключаем JS и CSS файлы темы общие для всех сайтов
  drupal_add_js(array('path_to_theme' => _sfu2016_base_path() . $theme), 'setting'); // путь к теме для использования в JS
  //drupal_add_js("$theme/js/lib/modernizr.custom.js$v", 'theme', 'head'); // подключаем modernizr для возможности поддержки деградации в разных браузерах
  //drupal_add_js("$theme/js/lib/fontfaceobserver.standalone.js$v", 'theme', 'head'); // слежение за загрузкой шрифтов, чтобы скрыть overlay после загрузки
  //drupal_add_js("$theme/js/lib/consolelog.min.js$v", 'theme', 'header', TRUE); // улучшенная консоль браузера, нужно только для разработки и отладки

  $js = array(
    // Скрипты, которым нужен jQuery 1.11 в переменной $ до вызова noConflict()
    'no_conflict' => array(
      "$theme/js/lib/webui-popover/jquery.webui-popover.min.js",
    ),

    // Скрипты, которым достаточно определения в старой в jQuery
    'footer' => array(
      "$theme/js/lib/js-cookie/js.cookie.js",   // универсальная standalone-утилита для работы с куки
      "$theme/js/lib/autocolumnlist/jquery.autocolumnlist.min.js", // разделитель списков
      "$theme/js/lib/photoswipe/photoswipe.min.js", // standalone-фотогалерея с поддержкой мобильных устройств
      "$theme/js/lib/photoswipe/photoswipe-ui-default.min.js",
      "$theme/js/lib/sly/sly.min.js", // слайдер
      "$theme/js/legacy.js", // старый JS-код + код для совместимости (можно потом перенести в common.js)
      "$theme/js/common.js",
    ),
  );

  foreach ($js as $scope => $scripts) {
    foreach ($scripts as $data) {
      if (DRUPAL_VERSION == 7) {
        drupal_add_js($data, array('scope' => $scope));
      } else {
        drupal_add_js("$data$v", 'theme', $scope);
      }
    }
  }

  // //drupal_add_js("$theme/js/lib/chosen/chosen.jquery.js$v", 'theme', 'header', TRUE); // chosen

  // Скомпилированный style.less
  drupal_add_css("$theme/css/style_.css$v", 'theme');
  drupal_add_css("$theme/css/style.css$v", 'theme');
  drupal_add_css("$theme/css/legacy.css$v", 'theme');
  drupal_add_css("$theme/css/print.css$v", 'theme');
  drupal_add_css("$theme/js/lib/photoswipe/photoswipe.css", 'theme');
  drupal_add_css("$theme/js/lib/webui-popover/jquery.webui-popover.min.css", 'theme');
  drupal_add_css("$theme/js/lib/photoswipe/default-skin/default-skin.css", 'theme');
  //drupal_add_css("$theme/js/lib/chosen/chosen.css", 'theme');

  // подключаем файлы для текущего сайта, если они присутствуют в папке sites/домен/
  $site = sfu_domain();

  if (file_exists($file = "$theme/sites/$site/script.js")) {
    drupal_add_js("$file$v", 'theme', 'header', TRUE);
  }

  if (file_exists($file = "$theme/sites/$site/style.css")) {
    drupal_add_css("$file", 'theme');
  }

  if (file_exists($file = "$theme/sites/$site/template.php")) {
    include_once($file);
  }
}

// перевод фразы на текущий язык, используя файл с переводами translations.php (перевод с русского)
// если фразы нет, то используется английский вариант, если его нет — то русский
function custom_t($s, $set_translation = FALSE)
{
  global $locale;
  static $t = NULL;

  if ($t === NULL) {
    $t = require('includes/translations.inc.php');
  }

  if ($set_translation !== FALSE) {
    $t[$s] = $set_translation;
  }

  if ($locale == 'ru') {
    return $s;
  }

  if (isset($t[$s])) {
    foreach (array($locale, 'en') as $key) {
      if (isset($t[$s][$key])) {
        return $t[$s][$key];
      }
    }
  }

  return $s;
}
///////////////////// ПЕРЕМЕННЫЕ ДЛЯ ШАБЛОНОВ *.tpl.php /////////////////////

// переменные, используемые в page.tpl.php
function _sfu2016_page_vars(&$vars)
{
  $vars['portal_page'] = sfu_theme_var('portal_page') || FALSE; // режим "портальной" страницы (без левой колонки)

  // язык на сайте forms.sfu-kras.ru
  if (('forms.sfu-kras.ru' == sfu_domain()) && isset($_GET['language'])) {
    $GLOBALS['locale'] = $_GET['language'];

    if ($GLOBALS['locale'] == 'zh-hans') {
      $GLOBALS['locale'] = 'zh';
    }
  }

  if (!isset($vars['lang_items'])) {
    $vars['lang_items'] = FALSE;
  }

  // ИСПОЛЬЗУЕМЫЕ ПЕРЕМЕННЫЕ ИЗ $vars
  $vars['site_name'] = custom_t($vars['site_name']);               // название сайта

  // классы для body
  if (!isset($vars['page_class'])) {
    $vars['page_class'] = '';
  }

  if (isset($vars['node']) && $vars['node']->nid) {
    $vars['page_class'] .= ' node-page-' . $vars['node']->nid;
  }

  if ($vars['portal_page']) {
    $vars['page_class'] .= ' main';
  }

  if (DRUPAL_VERSION === 6 && !empty($vars['scripts'])) {
    // Хак для Drupal 6: скрипт misc/tabledrag.js работает только с jQuery 1.2 и ломается с jQuery 1.3.
    // Используется версия скрипта из модуля jquery_update.
    $vars['scripts'] = str_replace('src="/misc/tabledrag.js', 'src="/' . _sfu2016_path_to_theme() . '/js/replace/tabledrag_d6_jquery_1.3.js', $vars['scripts']);
  }

  if (isset($vars['scripts'])) {
    $vars['scripts'] = preg_replace("|<script[^>]+/misc/jquery[.]js.*?</script>|", '', $vars['scripts']); // HTML-код скриптов в подвал, вырезаем стандартный jQuery
  } else {
    $vars['scripts'] = '';
  }

  $vars['head_scripts'] = drupal_get_js('head');             // HTML-код скриптов в шапку (редкие)
  $vars['no_conflict_scripts'] = drupal_get_js('no_conflict');    // Скрипты, которые должы быть зарегистрированы в $jq

  // удаление даты из заголовка (если это смотрит не наш поисковик) - не работает нормально, т. к. страницы кешируются
  if (strstr($_SERVER['HTTP_USER_AGENT'], 'Yandex.Server') === FALSE) {
    $vars['title'] = preg_replace("|\(\d+[^)]+\d{4}.*?\)|", "", $vars['title']);
  }

  // удаление тегов и лишних пробелов из заголовка
  $vars['title'] = trim(strip_tags($vars['title']));

  // ДОПОЛНИТЕЛЬНЫЕ ПЕРЕМЕННЫЕ
  $vars['path_to_theme'] = _sfu2016_path_to_theme();                         // путь к теме
  $vars['site'] = sfu_domain();                                                                  // домен сайта, например, edu.sfu-kras.ru
  $links_lang = $GLOBALS['locale'] == 'ru' ? '' : '_en';
  $vars['links_institutes'] = sfu_links("links/institutes$links_lang", '_sfu2016_theme_links');  // ссылки на институты
  $vars['links_branches'] = sfu_links("links/branches$links_lang", '_sfu2016_theme_links');      // ссылки на филиалы
  $vars['links_departments'] = sfu_links("links/departments$links_lang", '_sfu2016_theme_links');            // ссылки на подразделения (с подзаголовками)
  $vars['links_sites'] = sfu_links('links/sites', '_sfu2016_theme_links');                       // ссылки на сайты (с подзаголовками)
  $vars['links_nets'] = sfu_links('links/nets', '_sfu2016_theme_links');                         // ссылки на соцсети
  $vars['links_nets_vk'] = sfu_links('links/nets', '_sfu2016_theme_links_sn', 'vk.com');         // ссылки на соцсеть ВК
  $vars['links_nets_twitter'] = sfu_links('links/nets', '_sfu2016_theme_links_sn', 'twitter.com');         // ссылки на соцсеть Twitter
  $vars['body_prefix'] = sfu_theme_var('body_prefix');                                           // код в начало страницы

  if (isset($vars['custom_mobile_menu'])) {
    $vars['mobile_menu'] = $vars['custom_mobile_menu'];
    unset($vars['custom_mobile_menu']);
  } else {
    $vars['mobile_menu'] = _sfu2016_theme_mobile_menu();                                           // меню для мобильных
  }

  // список языков для сайта forms.sfu-kras.ru
  $_langs = NULL;

  if ($vars['site'] == 'forms.sfu-kras.ru') {
    $_langs = array(
      'ru' => '//forms.sfu-kras.ru?language=ru',
      'en' => '//forms.sfu-kras.ru?language=en',
      'es' => '//forms.sfu-kras.ru?language=es',
      'zh' => '//forms.sfu-kras.ru?language=zh-hans'
    );
  }

  $vars['langs'] = sfu_theme_var('langs', $_langs);                                                       // массив языков (lang=>url), если на сайте/разделе свои языки
  $vars['header_signatures'] = sfu_theme_var('header_signatures');                               // замена картинок с названием сайта (язык=>размер=>формат=>url)

  // язык + ссылки на главную страницу, контакты, сообщение об ошибке
  $vars['language'] = $GLOBALS['locale'];
  $vars['page_class'] .= ($vars['language'] == 'ru' ? ' ru-page' : ' non-ru-page');
  $vars['link_home'] = 'http://www.sfu-kras.ru/';
  $vars['link_contact'] = 'http://about.sfu-kras.ru/contact';
  $vars['link_feedback'] = 'http://smi.sfu-kras.ru/our-smi/site/feedback?page=' . urlencode($GLOBALS['base_url'] . $_SERVER['REQUEST_URI']);

  // для иностранной версии меняем ссылку на главную и язык
  if (function_exists('_sfu_i18n_lang_info')) {
    $lang_info = _sfu_i18n_lang_info();
    $vars['language'] = $lang_info['language'];
    $vars['link_home'] = "http://www.sfu-kras.ru/$lang_info[path_prefix]";
    if ($vars['language'] != 'ru') {
      $vars['link_contact'] = "http://www.sfu-kras.ru/$lang_info[path_prefix]/contact";
    }
  }

  $vars['section_home'] = $vars['site'] == 'www.sfu-kras.ru' ? $vars['link_home'] : url('');

  // признак главной страницы раздела
  $q = $_GET['q'];
  $q_alias = ltrim(url($_GET['q']), '/');
  $homepage = variable_get('site_frontpage', 'node');
  $vars['is_home'] = $q == $homepage || $q_alias == $homepage || isset($lang_info) && ($q == $lang_info['path_prefix'] || $q_alias == $lang_info['path_prefix']);

  $menu_lang = $vars['language'] == 'ru' ? '' : '_en';

  if (isset($vars['custom_menu_primary'])) {
    $vars['menu_primary'] = $vars['custom_menu_primary'];
    unset($vars['custom_menu_primary']);
  } else {
    // главное меню
    $vars['menu_primary'] = sfu_theme_var('menu_primary')
      ? _sfu2016_theme_menu(sfu_theme_var('menu_primary'), $_GET['q'], TRUE)
      : sfu_links("menu/primary$menu_lang", '_sfu2016_theme_menu', $_GET['q']);
  }

  $vars['menu_secondary'] = sfu_links("menu/secondary$menu_lang", '_sfu2016_theme_menu', $_GET['q'], 0); // дополнительное меню
  $vars['menu_audience'] = sfu_links("menu/audience$menu_lang", '_sfu2016_theme_audience_menu', 0);      // меню для целевых аудиторий (без подпунктов)
  $vars['navigator'] = sfu_theme_var('navigator') ? sfu_theme_var('navigator') : array();                    // ссылки для навигатора (помимо стандартных "вверх" и "вниз")

  // картинка в шапке на внутренних страницах
  $vars['header_image'] = sfu_theme_var('header_image');                                                 // опциональная картинка для шапки 970x140, можно перекрыть дефолтную картинку

  if ($vars['header_image'] == '') {
    $header_images = preg_split("/\r?\n/", trim(sfu_var('internal/header-images')));
    $header_image_default = $header_image = '';

    foreach ($header_images as $_header_image) {
      // Пропускаем закомментированные и неправильные строки (без присваивания).
      if (strpos($_header_image, '=') === FALSE || strpos($_header_image, '#') === 0) {
        continue;
      }
      list($header_image_site, $header_image_filename) = explode('=', $_header_image);

      if ($header_image_site == 'default') {
        $header_image_default = $header_image_filename;
      } elseif ($header_image_site == $vars['site']) {
        $header_image = $header_image_filename;
      }
    }

    $vars['header_image'] = 'http://' . (substr($_SERVER['HTTP_HOST'], 0, 4) == 'dev.' ? 'dev.sfu-kras.ru' : 'www.sfu-kras.ru') . "/vars/internal/img/" . ($header_image ? $header_image : $header_image_default);

    // Временная мера для борьбы с mixed content, пока на www.sfu-kras.ru нет правильного сертификата.
    if ($_SERVER['HTTP_HOST'] === 'pay.sfu-kras.ru') {
      $vars['header_image'] = '/vars/internal/img/' . $header_image_default;
    }
  }
}

// подключение функций с переменными в Drupal 5: page.tpl.php
function _phptemplate_variables($hook, &$vars)
{
  if ($hook == 'page') {
    _sfu2016_page_vars($vars);
  }

  return $vars;
}

// подключение функций с переменными в Drupal 6: page.tpl.php
function phptemplate_preprocess_page(&$vars)
{
  if ($vars['left'] != '') $vars['sidebar_left'] = $vars['left'];
  _sfu2016_page_vars($vars);
}

///////////////////// ВСПОМОГАТЕЛЬНЫЕ ФУНКЦИИ /////////////////////

// для указанной абсолютной ссылки возвращает список подразделов (использует карту сайта из переменной vars/links/sitemap)
function _sfu2016_subsections($url, $active_link = FALSE)
{
  static $sitemap, $menu;

  // иностранные версии
  if (sfu_domain() == 'www.sfu-kras.ru' && $GLOBALS['locale'] != 'ru' && substr($url, 0, 22) == 'http://www.sfu-kras.ru') {
    $url = substr($url, 22);
  }

  $links = array();

  // если ссылка с текущего сайта (для хлебных крошек и иностранных версий)
  if ($url[0] == '/' && !DRUPAL6) {
    // код для Drupal 5
    if (!$menu) {
      $menu = menu_get_menu();
    }

    // получаем пункт меню для указанного адреса
    $path = drupal_get_normal_path(ltrim($url, '/'));

    if ($path == '') { // для главной страницы берём верхние пункты текущего меню
      $mid = menu_get_active_nontask_item();

      while ($menu['visible'][$mid] && $menu['visible'][$mid]['pid']) {
        $mid = $menu['visible'][$mid]['pid'];
      }

      $item = $menu['visible'][$mid];
    } else {
      $item = $menu['visible'][$menu['path index'][$path]];
    }

    // если это главная страница иностранной версии, то берем всё иностранное меню
    $lang_info = function_exists('_sfu_i18n_lang_info') ? _sfu_i18n_lang_info() : array('path_prefix' => '');

    if ($lang_info['path_prefix'] != '' && $lang_info['path_prefix'] == $path) {
      $item = $menu['visible'][$item['pid']];
    }

    // получаем подпункты меню для текущего пункта
    if ($item && $item['children']) {
      foreach ($item['children'] as $mid) {
        $child = $menu['visible'][$mid];
        $links[] = l($child['title'], $child['path'], array(), NULL, NULL, TRUE);
      }
    }
  } elseif ($url[0] == '/' && DRUPAL6) {
    // код для Drupal 6
    if (!$menu) {
      $active_menu_name = 'navigation';

      if (DRUPAL_VERSION == 6) {
        $active_menu_name = menu_get_active_menu_name();
      }

      $menu = menu_tree_all_data($active_menu_name);
    }

    $path = drupal_get_normal_path(ltrim($url, '/'));
    $children = _sfu2016_subsections_children($menu, $path);

    if ($children) {
      foreach ($children as $child) {
        if (!$child['link']['hidden']) {
          $links[] = l($child['link']['title'], $child['link']['href'], array('absolute' => TRUE));
        }
      }
    }
  }

  // если ссылка с внешнего сайта (для выпадающего главного меню)
  if (!$links) {
    if (!$sitemap) {
      $sitemap = json_decode(sfu_var('links/sitemap'), TRUE);
    }

    if ($url[0] == '/') {
      $url = DRUPAL6 ? url(substr($url, 1), array('absolute' => TRUE)) : url(substr($url, 1), NULL, NULL, TRUE);
    }

    $links = isset($sitemap[$url]) ? $sitemap[$url] : array();
  }

  // возвращаем форматированный список
  if (!$links) {
    return '';
  }

  $output = "\n<ul class='subitems'>\n";

  foreach ($links as $link) {
    if (preg_match("|href=\"(.*?)\".*?>(.*?)</a>|", $link, $matches)) {
      list($dummy, $url, $title) = $matches;
      $class = $active_link !== FALSE && $url == $active_link ? ' active' : '';
      $title = custom_t($title);
      $output .= "<li class='subitem$class'><a href=\"$url\" class='subitem-link'><span class='subitem-title'><noindex>$title</noindex></span></a></li>\n";
    }
  }

  $output .= "</ul>\n";

  return $output;
}

// рекурсивный поиск пункта меню в Drupal 6
function _sfu2016_subsections_children(&$menu, $path)
{
  if ($path == '') return $menu; // для главной страницы возвращаем все верхние пункты меню
  if ($menu)
    foreach ($menu as $menu_item) {
      if ($menu_item['link']['link_path'] == $path) {
        return $menu_item['below'];
      } else {
        $children = _sfu2016_subsections_children($menu_item['below'], $path);
        if ($children) return $children;
      }
    }
  return array();
}

///////////////////// ФУНКЦИИ ТЕМИЗАЦИИ /////////////////////

// форматирование главного и дополнительного меню (верхних) с выпадающими подменю из карты сайта vars/links/sitemap
// аргумент $active_link=$_GET[q] (чтобы кэширование ссылок было отдельно для каждой страницы, т. к. нужно выделять текущий пункт меню)
// используется в переменных page.tpl.php
function _sfu2016_theme_menu($links, $active_link, $show_subsections = TRUE)
{
  $site = sfu_domain(TRUE);
  $site_url = $site . ltrim(url($_GET['q']), '/');
  $active_link = rtrim($site, '/') . url($active_link);

  if ($main_menu_section = sfu_theme_var('main_menu_section')) {
    $active_link = $site;
    $site = $main_menu_section;
  }

  $output = '';
  foreach ($links as $link) {
    if (is_array($link)) {
      list($url, $title) = $link;
      $class = $url == $site || $url == $site_url || $url == substr($site_url, 0, strlen($url)) && $url != 'http://www.sfu-kras.ru/en' ? ' active' : '';
      $output .= "<li class='item$class'><a class='item-link' href=\"$url\"><span class=\"item-title\"><noindex>$title</noindex></span></a>";
      if ($show_subsections) $output .= _sfu2016_subsections($url, $active_link);
      $output .= "</li>\n";
    }
  }
  return $output;
}

// форматирование меню целевых аудиторий
function _sfu2016_theme_audience_menu($links, $show_links = TRUE)
{
  $category_links = 0;
  $categories = 0;
  $output = "<ul class='items'>\n";

  foreach ($links as $link) {
    if (is_array($link)) {
      if ($show_links) {
        list($url, $title) = $link;

        if ($category_links == 0) {
          $output .= "\n<div class='item-content'><ul class='subitems'>\n";
        }

        $output .= "<li class='subitem'><a href=\"$url\" class='subitem-link'><span class='subitem-title'><noindex>$title</noindex></span></a></li>\n";
      }

      $category_links++;
    } elseif ($link != '') {
      if (preg_match("|class=\"(.*?)\".+?href=\"(.*?)\".*?>(.*?)</a>|", trim($link, " \t*"), $matches)) {
        list($dummy, $link_class, $link_href, $link_title) = $matches;

        if ($category_links != 0 && $show_links) {
          $output .= "</ul>$category_link</div>\n";
        }

        if ($categories) {
          $output .= "</li>\n";
        }

        $category_links = 0;
        $categories++;
        $link_class = $link_class == '' ? 'item' : "item $link_class";
        $output .= "<li class='$link_class'>";
        $hint = $show_links ? '' : " title=\"$link_title\"";
        $category_link = "<a$hint href=\"$link_href\" class=\"item-link\"><span class=\"item-title\"><noindex>$link_title</noindex></span></a>";

        if (!$show_links) {
          $output .= $category_link;
        }
      }
    }
  }
  if ($category_links != 0 && $show_links) {
    $output .= "</ul>$category_link</div>\n";
  }

  if ($categories) {
    $output .= "</li>\n";
  }

  $output .= "</ul>\n";

  return $output;
}

function _sfu2016_theme_links_sn($links, $domain)
{
  $html = '';

  foreach ($links as $link) {
    if (!is_array($link)) {
      continue;
    }

    list($url, $title) = $link;

    if (strpos($url, "/{$domain}/") === FALSE && strpos($url, "/www.{$domain}/") === FALSE) {
      continue;
    }

    $html .= '<li class="subitem-sn"><a href="' . $url . '" class="subitem-link-sn">' . $title . '</a></li>';
  }

  return $html;
}

// форматирование каталога ссылок в верхнем навигационном меню
function _sfu2016_theme_links($links)
{
  $plain_list = TRUE;
  $output = '';

  foreach ($links as $link) {
    if (is_array($link)) {
      list($url, $title) = $link;
      $class = '';

      $link_classes = array(
        '/vk.com/' => 'link-vk',
        'twitter.com' => 'link-twitter',
        'instagram.com' => 'link-instagram',
        'livejournal.com' => 'link-lj',
        'facebook.com' => 'link-facebook',
        '/rss' => 'link-rss',
      );

      foreach ($link_classes as $pattern => $link_class) {
        if (stripos($url, $pattern) !== FALSE) {
          $class .= ' ' . $link_class;
        }
      }

      $output .= "<li class='list-item$class'><a href=\"$url\" class='list-item-link'><span class='list-item-title'><noindex>$title</noindex></span></a></li>\n";
    } elseif ($link != '') {
      $plain_list = FALSE;
      $category = trim($link, " \t*");

      if ($output != '') {
        $output .= "</ul></li>\n";
      }

      $output .= "<li class='subitem'><a href='#' class='subitem-link'><span class='subitem-title'><noindex>$category</noindex></span></a>\n<ul class='list'>\n";
    }
  }

  if (!$plain_list) {
    $output .= "</ul></li>\n";
  }

  return $output;
}

// форматирование списка ссылок как: ul.items > li.item > a.item-link > span.item-title
// на вход массив array(array(path,title), ...) или array(array('path'=>path,'title'=>title),...)
function _sfu2016_theme_links_items($links, $additional_list_class = '')
{
  if (!$links) return '';
  $output = '';
  foreach ($links as $link) {
    if (isset($link['path'])) {
      $url = $link['path'];
      $title = $link['title'];
    } else {
      list($url, $title) = $link;
    }
    $output .= "<li class='item'><a href=\"$url\" class='item-link'><span class='item-title'>$title</span></a></li>\n";
  }
  return $output == '' ? '' : "<ul class='items $additional_list_class'>$output</ul>";
}

// фикс стандартного брэдкрамба для вывода скрытых пунктов меню (пока реализация только для D5)
// вызывается из функции темизации хлебных крошек ниже
function _sfu2016_menu_get_active_breadcrumb()
{
  if (drupal_is_front_page()) {
    return array();
  }
  $links[] = l(t('Home'), '');
  $trail = _menu_get_active_trail();
  foreach ($trail as $mid) {
    $item = menu_get_item($mid);
    if ($item['type'] & MENU_VISIBLE_IN_BREADCRUMB || !($item['type'] & MENU_IS_ROOT) && !($item['type'] & MENU_IS_LOCAL_TASK) && $item['type'] & MENU_CREATED_BY_ADMIN) {
      $links[] = menu_item_link($mid);
    }
  }
  array_pop($links);
  return $links;
}

// темизация хлебных крох
function phptemplate_breadcrumb($breadcrumb)
{
  $site = sfu_domain(TRUE);
  $domain = sfu_domain();
  $active_link = rtrim($site, '/') . url($_GET['q']);

  if (!DRUPAL6) {
    $breadcrumb = _sfu2016_menu_get_active_breadcrumb();
  }

  if (!empty($breadcrumb) && count($breadcrumb) > 0) {
    //if ($breadcrumb[1] == l(t('Home'), $lang_info['path_prefix'])) array_shift($breadcrumb); // удаляем дублируюущуюся ссылку на главную страницу
    $lang_info = function_exists('_sfu_i18n_lang_info') ? _sfu_i18n_lang_info() : array('path_prefix' => '');

    // добавляем ссылку на самую главную страницу и правим заголовок ссылки на главную страницу раздела (как в основном меню или названии сайта)
    // например: главная / о вузе / документы
    if ($site != 'http://www.sfu-kras.ru/') {
      // ссылку на главную страницу раздела называем по названию сайта или пункта главного меню, если сайт есть в главном меню
      $home_title = custom_t(trim(variable_get('site_name', '')));

      if (drupal_substr($home_title, -4) == ' СФУ' && $domain != 'zakupki.sfu-kras.ru') {
        $home_title = drupal_substr($home_title, 0, drupal_strlen($home_title) - 4);
      }

      $primary_menu = sfu_links("menu/primary", FALSE);

      foreach ($primary_menu as $menu_item) {
        if ($menu_item[0] == $site) {
          $home_title = $menu_item[1];
          break;
        }
      }

      $breadcrumb[0] = l($home_title, ''); // меняем ссылку на главную страницу раздела
      array_unshift($breadcrumb, l(t('Home'), "http://www.sfu-kras.ru/$lang_info[path_prefix]")); // добавляем ссылку на главную страницу сайта

      if (count($breadcrumb) > 2 && $breadcrumb[1] === $breadcrumb[2]) {
        unset($breadcrumb[2]);
      }
    } elseif ($lang_info['path_prefix'] != '') {
      $breadcrumb[0] = l(t('Home'), $lang_info['path_prefix']); // меняем ссылку на главную страницу иностранной версии сайта
    } else {
      $breadcrumb[0] = l(t('Home'), 'http://www.sfu-kras.ru/'); // меняем ссылку на главную страницу на абсолютную
    }

    if (count($breadcrumb) <= 1) {
      return '';
    }

    // форматируем список ссылок, добавляя выпадающие меню
    $output = "<ul class='items'>\n";

    foreach ($breadcrumb as $link) {
      if (preg_match("|href=\"(.*?)\".*?>(.*?)</a>|", $link, $matches)) {
        list($dummy, $url, $title) = $matches;
        $output .= "<li class='item'><a href=\"$url\" class='item-link'><span class='item-title'>$title</span></a>";
        $output .= _sfu2016_subsections($url, $active_link);
        $output .= "</li>\n";
      }
    }

    $output .= "</ul>\n";

    return $output;
  }
}

// форматирование меню
if (!DRUPAL6) {
  // добавляем class="current" к текущим разделам всех уровней, а не только к последней странице
  // добавляем иконки +/-
  function phptemplate_menu_item($mid, $children = '', $leaf = TRUE, $level = 0)
  {
    $item = menu_get_item($mid);
    if ($item['title'] == '') return '';

    // добавление иконки внешнего сайта
    if (strstr($item['path'], '://') && !strstr($item['path'], '.sfu-kras.ru')) {
      $space = strrpos($item['title'], ' ');
      $external_icon = '<span class="item-external" title="Переход на другой сайт"></span>';
      if ($space) {
        $item['title'] = substr($item['title'], 0, $space + 1) . '<span class="nobr">' . substr($item['title'], $space + 1) . "$external_icon</span>";
      } else {
        $item['title'] .= $external_icon;
      }
    }

    // генерация ссылки со вложенным span-ом
    $attributes = array(); // атрибуты ссылки
    if (!empty($item['description'])) $attributes['title'] = $item['description']; // hint ссылки
    $active = menu_in_active_trail($mid);
    $current = $_GET['q'] == $item['path'];
    //if ($active) $attributes['class'] = 'active'; // активность у ссылки
    $attributes['class'] = trim("item-lvl-$level-link " . $attributes['class']); // класс ссылки
    $item['title'] = "<span class=\"item-lvl-$level-title\"><noindex>$item[title]</noindex></span>"; // вложенный span в ссылку
    $link = l($item['title'], $item['path'], $attributes, (isset($item['query']) ? $item['query'] : NULL), NULL, FALSE, TRUE);

    // генерация пункта списка
    $class = $leaf ? 'leaf' . ($active ? ' active' : '') : ($children && $active ? 'expanded active' : 'collapsed'); // класс пункта списка
    if ($current /*|| strstr($link, '-link active"')*/) $class .= ' current'; // второе условие для подпунктов меню, являющихся дефолтными (например, "Все документы" в разделе "Документы")
    return "<li class=\"$class item-lvl-$level\">$link$children</li>\n";
  }

  // оформление разворачиваемого меню
  function phptemplate_menu_tree($pid = 1, $level = 1)
  {
    if ($tree = _sfu2016_menu_tree($pid, $level)) {
      $class = $level == 1 && strstr($tree, 'class="collapsed') === FALSE && strstr($tree, 'class="expanded') === FALSE ? ' menu-plain' : '';
      return "\n<ul class=\"items-lvl-$level$class\">\n$tree</ul>\n";
    }
  }

  // рекурсия для генерации меню
  function _sfu2016_menu_tree($pid, $level)
  {
    $menu = menu_get_menu();
    $output = '';
    if (isset($menu['visible'][$pid]) && $menu['visible'][$pid]['children']) {
      foreach ($menu['visible'][$pid]['children'] as $mid) {
        $type = isset($menu['visible'][$mid]['type']) ? $menu['visible'][$mid]['type'] : NULL;
        $children = isset($menu['visible'][$mid]['children']) ? $menu['visible'][$mid]['children'] : NULL;
        $output .= theme('menu_item', $mid, phptemplate_menu_tree($mid, $level + 1), count($children) == 0, $level);
      }
    }
    return $output;
  }
} else {

  // форматирование ссылки в меню
  function phptemplate_menu_item_link($link)
  {
    if ($link['title'] == '') return '';
    $level = $link['depth'];
    if (empty($link['localized_options'])) $link['localized_options'] = array();
    $link['localized_options']['attributes']['class'] = trim("item-lvl-$level-link " . $link['localized_options']['attributes']['class']); // класс ссылки
    if ($link['in_active_trail']) $link['localized_options']['attributes']['class'] .= ' active';
    $link['title'] = "<span class=\"item-lvl-$level-title\"><noindex>$link[title]</noindex></span>"; // вложенный span
    $link['localized_options']['html'] = TRUE;
    if ($link['localized_options']['attributes']['title'] == '') unset($link['localized_options']['attributes']['title']);
    return l($link['title'], $link['href'], $link['localized_options']);
  }

  // форматирование пункта меню (li)
  function phptemplate_menu_item($link, $has_children, $menu = '', $in_active_trail = FALSE, $extra_class = NULL)
  {
    if ($link == '') return '';
    // добавление иконки внешнего сайта
    $href = '#';
    if (preg_match("/href=\"(.*?)\"/", $link, $matches)) $href = $matches[1];
    if (strstr($href, '://') && !strstr($href, '.sfu-kras.ru') && preg_match("|^(<a.*?>.*?>)(.*?)</span></a>$|ms", $link, $matches)) {
      $external_icon = "<span class=\"item-external\" title=\"Переход на другой сайт\"></span>";
      $item['title'] = $matches[2];
      $space = strrpos($item['title'], ' ');
      if ($space) {
        $item['title'] = substr($item['title'], 0, $space + 1) . '<span class="nobr">' . substr($item['title'], $space + 1) . "$external_icon</span>";
      } else {
        $item['title'] .= $external_icon;
      }
      $link = "$matches[1]$item[title]</span></a>";
    }

    $class = trim(($has_children && $menu && $in_active_trail ? 'expanded' : ($has_children && $menu ? 'collapsed' : 'leaf')) . " $extra_class"); // класс пункта меню
    $current = url($_GET['q']) == $href;
    //$current = strstr($link, '-link active"') || $in_active_trail && !$has_children && !$menu;
    if ($in_active_trail) $class .= ' active'; // активность, но не текущность пункта меню
    if ($current) $class .= ' current'; // текущность пункта меню
    $level = preg_match('/item-lvl-(\d+)-link/', $link, $matches) ? $matches[1] : 1; // уровень извлекаем из ссылки
    return "<li class=\"$class item-lvl-$level\">$link$menu</li>\n";
  }

  // форматирование меню (ul)
  function phptemplate_menu_tree($tree)
  {
    $level = preg_match('/item-lvl-(\d+)/', $tree, $matches) ? $matches[1] : 1; // уровень извлекаем из первого пункта меню
    $class = $level == 1 && strstr($tree, 'class="collapsed') === FALSE && strstr($tree, 'class="expanded') === FALSE ? ' menu-plain' : '';
    return "\n<ul class=\"items-lvl-$level$class\">\n$tree</ul>\n";
  }
}

// скрываем ссылку на справку по форматам ввода
function phptemplate_filter_tips_more_info()
{
  return '';
}

// оформление списка прикреплённых файлов
function phptemplate_upload_attachments($files)
{
  $output = '';
  foreach ($files as $file) {
    $file = (object)$file;
    if ($file->list && !$file->remove) {
      $output .= "<li";
      // расширение
      $dot = strrpos($file->filename, ".");
      $ext = $dot ? drupal_strtolower(substr($file->filename, $dot)) : '';
      // класс
      $class = _phptemplate_upload_attachments_document_class($ext); // по расширению
      if ($class == 'link-file') $class = _phptemplate_upload_attachments_document_class($file->filemime); // по mime
      if ($class != '') $output .= " class=\"$class\"";
      $output .= ">";
      // название документа
      $filepath = preg_match("#^(https?|ftp)://#i", $file->filepath) ? $file->filepath : file_create_url($file->filepath);
      $output .= l(($file->description == '' ? $file->filename : $file->description), $filepath) . " (";
      // расширение
      if ($ext) $output .= "$ext, ";
      // размер
      if ($file->filesize) {
        $round = $file->filesize > 1000000 ? 1024 * 102.4 : 1024 * 10;
        $file->filesize = round(round($file->filesize / $round) * $round);
        $output .= trim(drupal_strtoupper(format_size($file->filesize))) . ")$file->prefix";
      } else {
        $output = rtrim($output, ', ') . ")$file->prefix";
      }
      $output .= "</li>";
    }
  }
  if ($output != '') {
    return "<ul class='attachments'>$output</ul>";
  }
}

// определение класса файла по MIME-типу или расширению (с точкой), используется при форматировании списка прикреплённых файлов
function _phptemplate_upload_attachments_document_class($mime)
{
  $mime = strtolower($mime);
  static $extensions = array(
    '.jpg' => "link-photo",
    '.png' => "link-photo",
    '.gif' => "link-photo",
    '.mp3' => "link-video",
    '.wav' => "link-video",
    '.avi' => 'link-video',
    '.mpg' => 'link-video',
    '.mpeg' => 'link-video',
    '.flv' => 'link-video',
    '.mp4' => 'link-video',
    '.txt' => 'link-text',
    '.ppt' => 'link-text',
    '.pptx' => 'link-text',
    '.pdf' => 'link-text',
    '.html' => 'link-text',
    '.htm' => 'link-text',
    '.zip' => 'link-file',
    '.tar' => 'link-file',
    '.rar' => 'link-file',
    '.xls' => 'link-text',
    '.xlsx' => 'link-text',
    '.doc' => 'link-text',
    '.docx' => 'link-text',
    '.rtf' => 'link-text',
  );
  if ($class = $extensions[$mime]) return $class;

  $class = 'link-file';
  if (substr($mime, 0, 6) == 'image/') {
    $class = "link-photo";
  } else if (substr($mime, 0, 6) == 'audio/') {
    $class = 'link-video';
  } else if (substr($mime, 0, 6) == 'video/') {
    $class = 'link-video';
  } else if ($mime == 'text/plain') {
    $class = "link-text";
  } else if ($mime == 'application/vnd.ms-powerpoint' || $mime == 'application/vnd.openxmlformats-officedocument.presentationml.presentation') {
    $class = 'link-text';
  } else if ($mime == 'application/pdf') {
    $class = 'link-text';
  } else if ($mime == 'text/html') {
    $class = 'link-text';
  } else if ($mime == 'application/zip' || $mime == 'application/x-tar' || $mime == 'application/rar') {
    $class = 'link-file';
  } else if ($mime == 'application/vnd.ms-excel' || $mime == 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet') {
    $class = 'link-text';
  } else if ($mime == 'application/x-msdos-program' || $mime == 'application/octet-stream') {
    $class = 'link-file';
  } else if ($mime == 'application/msword' || $mime == 'application/vnd.ms-office' || $mime == 'application/vnd.oasis.opendocument.text' || $mime == 'application/vnd.openxmlformats-officedocument.wordprocessingml.document') {
    $class = "link-text";
  }
  return $class;
}

// форматирование ссылок на соцсети для модуля ru_share
// shares[lj,vk,twitter,facebook]=>[title,link,size]
function sfu2016_ru_share($html_prefix, $html_like, $shares)
{
  if ($html_prefix != '') sfu_theme_var('body_prefix', sfu_theme_var('body_prefix') . $html_prefix);
  $classes = array('lj' => 'livejournal', 'vk' => 'vkontakte', 'twitter' => 'twitter', 'facebook' => 'facebook');
  //$output .= '<div id="bottom-tools"><ul class="items">';
  foreach ($shares as $name => $share) {
    $class = $classes[$name];
    $output .= "<li class='item share $class'><a onclick='window.open(\"$share[link]\",null,\"$share[size]\"); return false;' href='$share[link]' class='item-link' title='$share[title]'><span class='item-title'>$share[title]</span></a></li>";
  }
  if ($html_like) $output .= "<li class='item vkontakte-like'>$html_like</li>";
  //$output .= '</ul></div>';
  return $output;
}

// кнопка для слайдера
function slider_layout($titles, $images, $button)
{
  $styles = "
  <style>
      #main-slider.sfu .signature-ru .quiz-button {
          width: 220px;
          height: 55px;
          position: absolute;
          left: 0;
          top: 220px;
          background: #3b5888;
          border-radius: 0px;
          z-index: 100;
      }

      #main-slider.sfu .signature-ru .quiz-button:hover {
          background: #53688b;
      }

      #main-slider.sfu .signature-ru .quiz-text {
          color: #fff;
          margin-left: 15px;
          font-size: 12px;
          text-transform: uppercase;
          font-weight: 300;
          line-height: 55px;
          font-family: cerapro;
          text-align: center;
          font-weight: 600;
          width: 100%;
          height: 100%;
          position: absolute;
          z-index: 102;
      }

      #main-slider.sfu .signature-ru .quiz-icon {
          position: absolute;
          float: left;
          width: 25px;
          height: 25px;
          margin: 13px 18px;
      }
  </style>
  ";

  $slider_1 = "
  <section id='main-slider' data-autoslide='1' class='sfu'>
    <div class='front'>
        <div class='signature-ru'>
  ";

  $slider_2 = "
        </div>
        <div class='signature-en'></div>
        <div class='mol-sign'></div>
        <div class='front-content'>
            <ul class='item-titles'>
                $titles
            </ul>
            <div class='controls'>
                <a class='control-prev' title='Назад'></a>
                <a class='control-next' title='Вперёд'></a>
                <div class='control-pages'></div>
            </div>
        </div>
    </div>
    <div class='items-wrapper'>
        <div class='items'>"
    . ($GLOBALS['locale'] == 'ru' ? '' : "<div class='item item-signature-en'></div>") .
    "<div class='item item-signature-ru'></div>
            $images
        </div>
    </div>
  </section>
  ";

  echo $styles;
  echo $slider_1;
  echo $button;
  // var_dump($_SERVER['SERVER_NAME']);
  echo $slider_2;
}

// форматирование слайдера для главной страницы или разделов с портальной структурой
// слайды размером 970x440
function _sfu2016_theme_highlights($links,  $default_path = '/vars/home/img/')
{
  if (substr($default_path, -1) != '/') $default_path .= '/';
  $n = 0;
  $titles = $images = '';
  foreach ($links as $link) {
    if (is_array($link)) {
      $n++;
      list($url, $title) = $link;
      list($img, $title) = explode("=", $title);
      if (!strstr($img, '/')) $img = $default_path . $img;
      $url = $url == '' ? '' : "href=\"$url\"";
      if ($title != '') $titles .= "<li class='item-title' data-slide-id='$n'><a $url class='item-title-link'>$title</a></li>";
      $images .= "<div class='item' data-slide-id='$n'><img src=\"$img\" class='item-image' width='970' height='440' alt='' /></div>";
    }
  }

  // кнопка
  $button = '';
  /*
  if (($_SERVER['SERVER_NAME'] === 'dev.sfu-kras.ru' || $_SERVER['SERVER_NAME'] === 'xn--q1aec.xn--p1ai') && $_SERVER['REQUEST_URI'] !== '/en') {
      $button = "
      <div class='quiz-button'>
        <img class='quiz-icon' src='/sites/all/themes/sfu2016/img/like.svg'></img>
        <a class='quiz-link' href='https://raex-rr.com/poll'>
            <span class='quiz-text'>Пройди опрос от Роскомнадзора!</span>
        </a>
      </div>
      ";
    }
  */
  // data-autoslide=1 — автопролистывание для десктопа
  return slider_layout($titles, $images, $button);
}

// форматирование пояса баннеров для главной страницы или разделов с портальной структурой
// слайды размером 630x160
// orange - оранжевый, yellow - желтый, blue - голубой, span в заголовке - выделение белым
function _sfu2016_theme_banners($links, $default_path = '/vars/home/img/', $colors = 'orange,yellow,blue')
{
  $colors = explode(',', $colors);
  $colors_count = count($colors);
  $output = '';
  $links_number = 0;

  foreach ($links as $link) {
    if (is_array($link)) {
      list($url, $title) = $link;
      list($img, $title) = explode("=", $title);

      if (!strstr($img, '/')) {
        $img = $default_path . $img;
      }

      //$alt = check_plain(strip_tags($title));
      $links_number++;
      $color = $colors[($links_number - 1) % $colors_count];
      $class = count($links) == 2 ? 'banner-half' : (count($links) == 1 ? 'banner-full' : 'banner-third');
      $output .= "<a href=\"$url\" class='banner $class banner-$color'>
        <div class='banner-image'><img src=\"$img\" alt=''></div>
        <div class='banner-text'><h3 class='banner-text-content'>$title</h3></div>
      </a>";
    }
  }

  return $output == '' ? '' : "<aside class='banners'><div class='banners-content'>$output</div></aside>";
}

// темизация мобильного меню: собирается главное верхнее меню и все левые меню, кроме системного
function _sfu2016_theme_mobile_menu()
{
  $mobile_menu = sfu_theme_var('mobile_menu');

  // для иностранных версий не объединяем меню с главным
  if ($GLOBALS['locale'] != 'ru') {
    return "<div class='side-menu-items mobile'><ul class='items-lvl-1'>$mobile_menu</ul></div>";
  }

  // левое меню становится подменю в главном
  if ($mobile_menu != '') $mobile_menu = "<ul class='items-lvl-2'>$mobile_menu</ul>";

  // объединяем главное и левое меню
  $primary_menu = array_merge(array(array('http://www.sfu-kras.ru/', 'Главная')), sfu_links("menu/primary", FALSE));
  $current_site = sfu_domain(TRUE);
  $current_site_len = strlen($current_site);
  $site_in_primary_menu = FALSE;
  foreach ($primary_menu as $menu_item) {
    list($menu_item_url, $menu_item_title) = $menu_item;
    $is_this_site = substr($menu_item_url, 0, $current_site_len) == $current_site;
    $site_in_primary_menu |= $is_this_site;
    $class = $is_this_site ? 'expanded active' : 'leaf';
    $content .= "<li class='item-lvl-1 $class'><a href=\"$menu_item_url\" class='item-lvl-1-link'><span class='item-lvl-1-title'>$menu_item_title</span></a>" . ($is_this_site ? $mobile_menu : '') . "</li>\n";
  }

  // если сайт вне главного меню, то добавляем его первым пунктом
  if (!$site_in_primary_menu) {
    $menu_item_url = url('<front>');
    $menu_item_title = variable_get('site_name', '');
    if (trim($menu_item_title) == 'Сибирский федеральный университет') $menu_item_title = 'Разделы сайта';
    $content = "<li class='item-lvl-1 expanded active'><a href=\"$menu_item_url\" class='item-lvl-1-link'><span class='item-lvl-1-title'>$menu_item_title</span></a>$mobile_menu</li>\n$content";
  }

  // оборачиваем пункты меню в <div><ul></ul></div>
  $content = "<div class='side-menu-items mobile'><ul class='items-lvl-1'>$content</ul></div>";
  return $content;
}

// увеличивает уровень пунктов меню в уже отрендеренном меню (для мобильной версии)
function _sfu2016_lvl_up_callback($matches)
{
  return '-lvl-' . ($matches[1] + 1);
}


/**
 * Иконки для хедера
 * Созданы для управления трафиком
 */

 $time = time();
 drupal_add_js(drupal_get_path('theme', 'sfu2016') . "/js/icons.js?$time");
 drupal_add_js(drupal_get_path('theme', 'sfu2016') . "/assets/dragscroll-master/dragscroll.js?$time");
 drupal_add_css(drupal_get_path('theme', 'sfu2016') . "/css/icons.css?$time");
 
 function icons_theme() {
  return "
    <div class='block-icons'>
    <div class='block-icons__container'>
      <div class='block-icons__shadow-left'></div>
      <div class='block-icons__list dragscroll'>
        <div id='ml'></div>
        <a href='https://www.bik.sfu-kras.ru/' class='block-icons__item'>
          <div class='block-icons__item-container'>
            <img class='block-icons__icon' src='/sites/all/themes/sfu2016/img/icons/biblio.png' alt=''>
            <p class='block-icons__text'>библиотечно-издательский комплекс сфу</p>
          </div>
        </a>
        <a href='https://city.sfu-kras.ru/' class='block-icons__item'>
          <div class='block-icons__item-container'>
            <img class='block-icons__icon' src='/sites/all/themes/sfu2016/img/icons/city.png' alt=''>
            <p class='block-icons__text'>афиша событий сфу</p>
          </div>
        </a>
        <a href='http://news.sfu-kras.ru/node/24115' class='block-icons__item'>
          <div class='block-icons__item-container'>
            <img class='block-icons__icon' src='/sites/all/themes/sfu2016/img/icons/covid.png' alt=''>
            <p class='block-icons__text'>вакцинация, режим работы и многое другое</p>
          </div>
        </a>
        <a href='https://ino.sfu-kras.ru/project/1003' class='block-icons__item'>
          <div class='block-icons__item-container'>
            <img class='block-icons__icon' src='/sites/all/themes/sfu2016/img/icons/demography.png' alt=''>
            <p class='block-icons__text'>демография 2021</p>
          </div>
        </a>
        <a href='https://e.sfu-kras.ru/' class='block-icons__item'>
          <div class='block-icons__item-container'>
            <img class='block-icons__icon' src='/sites/all/themes/sfu2016/img/icons/eKourses.png' alt=''>
            <p class='block-icons__text'>екурсы</p>
          </div>
        </a>
        <a href='http://internship.sfu-kras.ru/' class='block-icons__item'>
          <div class='block-icons__item-container'>
            <img class='block-icons__icon' src='/sites/all/themes/sfu2016/img/icons/internship.png' alt=''>
            <p class='block-icons__text'>биржа практик</p>
          </div>
        </a>
        <a href='https://i.sfu-kras.ru/' class='block-icons__item'>
          <div class='block-icons__item-container'>
            <img class='block-icons__icon' src='/sites/all/themes/sfu2016/img/icons/love.png' alt=''>
            <p class='block-icons__text'>мой сфу</p>
          </div>
        </a>
        <a href='https://mail.sfu-kras.ru/' class='block-icons__item'>
          <div class='block-icons__item-container'>
            <img class='block-icons__icon' src='/sites/all/themes/sfu2016/img/icons/mail.png' alt=''>
            <p class='block-icons__text'>корпоративная почта сфу</p>
          </div>
        </a>
        <a href='https://pay.sfu-kras.ru/' class='block-icons__item'>
          <div class='block-icons__item-container'>
            <img class='block-icons__icon' src='/sites/all/themes/sfu2016/img/icons/pay.png' alt=''>
            <p class='block-icons__text'>оплата услуг</p>
          </div>
        </a>
        <a href='http://smi.sfu-kras.ru/' class='block-icons__item'>
          <div class='block-icons__item-container'>
            <img class='block-icons__icon' src='/sites/all/themes/sfu2016/img/icons/smi.png' alt=''>
            <p class='block-icons__text'>наши сми</p>
          </div>
        </a>
        <a href='http://newtimetable.sfu-kras.ru/' class='block-icons__item'>
          <div class='block-icons__item-container'>
            <img class='block-icons__icon' src='/sites/all/themes/sfu2016/img/icons/timetable.png' alt=''>
            <p class='block-icons__text'>новое расписание занятий</p>
          </div>
        </a>
        <div id='mr'></div>
      </div>
      <div class='block-icons__shadow-right'></div>
    </div>
  </div>
  ";
}