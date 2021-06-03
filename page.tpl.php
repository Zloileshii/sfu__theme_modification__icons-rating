<? if (!isset($hide_root) || !$hide_root) : ?>
  <!DOCTYPE HTML>
  <!-- Объявление элемента html в стиле HTML5 ★ BOILERPLATE для возможности поддержки разных версий IE -->
  <!--[if lt IE 7]><html lang="<?= $language ?>" class="lt-ie7 lt-ie8 lt-ie9"><![endif]-->
  <!--[if IE 7]><html lang="<?= $language ?>" class="ie7 lt-ie8 lt-ie9"><![endif]-->
  <!--[if IE 8]><html lang="<?= $language ?>" class="ie8 lt-ie9"><![endif]-->
  <!--[if IE 9]><html lang="<?= $language ?>" class="ie9"><![endif]-->
  <!--[if gt IE 9]><!-->
  <html lang="<?= $language ?>">
  <!--<![endif]-->

  <head>
    <!-- Yandex.Metrika counter -->
    <script type="text/javascript">
      (function(m, e, t, r, i, k, a) {
        m[i] = m[i] || function() {
          (m[i].a = m[i].a || []).push(arguments)
        };
        m[i].l = 1 * new Date();
        k = e.createElement(t), a = e.getElementsByTagName(t)[0], k.async = 1, k.src = r, a.parentNode.insertBefore(k, a)
      })
      (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

      ym(67760623, "init", {
        clickmap: true,
        trackLinks: true,
        accurateTrackBounce: true,
        webvisor: true
      });
    </script>
    <noscript>
      <div><img src="https://mc.yandex.ru/watch/67760623" style="position:absolute; left:-9999px;" alt="" /></div>
    </noscript>
    <!-- /Yandex.Metrika counter -->
    <title><?= $title == '' || $is_home ? $site_name : "$title | $site_name" ?></title>
    <meta charset="utf-8">
    <!-- На всякий случай говорим IE использовать движок рендера посвежее -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <!-- Масштаб страницы под экран устройства -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Стиль отображения на мобильных устройствах в режиме приложения -->
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="theme-color" content="#ff6600">
    <meta name="msapplication-navbutton-color" content="#ff6600">
    <meta name="apple-mobile-web-app-status-bar-style" content="#ff6600">
    <meta name="mobile-web-app-status-bar-style" content="#ff6600">
    <meta name="msapplication-TileColor" content="#ff6600" />
    <meta name="application-name" content="<?= $site_name ?>" />
    <!-- Отключаем парсинг и подсветку телефонов на странице Skype-аддоном для IE (он делает это криво, плюс избегаем ложно-положительные сработки) -->
    <meta name="SKYPE_TOOLBAR" content="SKYPE_TOOLBAR_PARSER_COMPATIBLE">
    <!-- Отключаем парсинг и подсветку телефонов в iOS Safari, во избежание ложно-положительных сработок -->
    <meta name="format-detection" content="telephone=no">
    <!-- То же для адресов -->
    <meta name="format-detection" content="address=no">
    <!-- Отключаем парсинг и подсветку телефонов в BlackBerry, во избежание ложно-положительных сработок -->
    <meta http-equiv="x-rim-auto-match" content="none">
    <!-- DNS-prefetch для ajax.googleapis.com, чтобы побыстрее забрать jQuery из CDN -->
    <!--<link rel="dns-prefetch" href="//ajax.googleapis.com">-->
    <!-- Иконки (полный набор) -->
    <link rel="apple-touch-icon" sizes="57x57" href="<?= $path_to_theme ?>/img/favicons/apple-touch-icon-57x57.png" />
    <link rel="apple-touch-icon" sizes="114x114" href="<?= $path_to_theme ?>/img/favicons/apple-touch-icon-114x114.png" />
    <link rel="apple-touch-icon" sizes="72x72" href="<?= $path_to_theme ?>/img/favicons/apple-touch-icon-72x72.png" />
    <link rel="apple-touch-icon" sizes="144x144" href="<?= $path_to_theme ?>/img/favicons/apple-touch-icon-144x144.png" />
    <link rel="apple-touch-icon" sizes="60x60" href="<?= $path_to_theme ?>/img/favicons/apple-touch-icon-60x60.png" />
    <link rel="apple-touch-icon" sizes="120x120" href="<?= $path_to_theme ?>/img/favicons/apple-touch-icon-120x120.png" />
    <link rel="apple-touch-icon" sizes="76x76" href="<?= $path_to_theme ?>/img/favicons/apple-touch-icon-76x76.png" />
    <link rel="apple-touch-icon" sizes="152x152" href="<?= $path_to_theme ?>/img/favicons/apple-touch-icon-152x152.png" />
    <link rel="icon" type="image/png" href="<?= $path_to_theme ?>/img/favicons/favicon-196x196.png" sizes="196x196" />
    <link rel="icon" type="image/png" href="<?= $path_to_theme ?>/img/favicons/favicon-96x96.png" sizes="96x96" />
    <link rel="icon" type="image/png" href="<?= $path_to_theme ?>/img/favicons/favicon-32x32.png" sizes="32x32" />
    <link rel="icon" type="image/png" href="<?= $path_to_theme ?>/img/favicons/favicon-16x16.png" sizes="16x16" />
    <link rel="icon" type="image/png" href="<?= $path_to_theme ?>/img/favicons/favicon-128.png" sizes="128x128" />
    <meta name="msapplication-TileImage" content="<?= $path_to_theme ?>/img/favicons/mstile-144x144.png" />
    <meta name="msapplication-square70x70logo" content="<?= $path_to_theme ?>/img/favicons/mstile-70x70.png" />
    <meta name="msapplication-square150x150logo" content="<?= $path_to_theme ?>/img/favicons/mstile-150x150.png" />
    <meta name="msapplication-wide310x150logo" content="<?= $path_to_theme ?>/img/favicons/mstile-310x150.png" />
    <meta name="msapplication-square310x310logo" content="<?= $path_to_theme ?>/img/favicons/mstile-310x310.png" />
    <meta name="description" content="Сибирский федеральный университет (СФУ) входит в топ-15 вузов России. Ведущие научные школы Красноярска. Лучший в России кампус. Мировые индустриальные партнёры" />
    <link rel="shortcut icon" href="<?= $path_to_theme ?>/img/favicons/favicon.ico" type="image/x-icon">
    <link rel="icon" href="<?= $path_to_theme ?>/img/favicons/favicon.ico" type="image/x-icon">

    <!-- Yandex.Metrika counter -->
    <script type="text/javascript">
      (function(m, e, t, r, i, k, a) {
        m[i] = m[i] || function() {
          (m[i].a = m[i].a || []).push(arguments)
        };
        m[i].l = 1 * new Date();
        k = e.createElement(t), a = e.getElementsByTagName(t)[0], k.async = 1, k.src = r, a.parentNode.insertBefore(k, a)
      })
      (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

      ym(67760623, "init", {
        clickmap: true,
        trackLinks: true,
        accurateTrackBounce: true,
        webvisor: true
      });
    </script>
    <noscript>
      <div><img src="https://mc.yandex.ru/watch/67760623" style="position:absolute; left:-9999px;" alt="" /></div>
    </noscript>
    <!-- /Yandex.Metrika counters -->

    <!--
  <link rel="icon" sizes="16x16" href="<?= $path_to_theme ?>/img/favicons/favicon-16x16.png">
  <link rel="icon" sizes="32x32" href="<?= $path_to_theme ?>/img/favicons/favicon-32x32.png" type="image/png">
  <link rel="icon" sizes="192x192" href="<?= $path_to_theme ?>/img/favicons/favicon-192x192.png" type="image/png">
  -->
    <!-- / Иконки -->
    <!-- Отключаем всплывающий тулбар для картинок во всяких IE -->
    <!--[if IE]><meta http-equiv="imagetoolbar" content="no"><![endif]-->
    <!-- Подключаем стили проекта -->
    <?= $head ?>
    <?= $styles ?>
    <!-- замена стандартного названия сайта -->
    <?php if ($header_signatures) : ?>
      <style>
        <?php foreach (array('ru', 'en') as $lang) : ?>#main-slider.sfu .item-signature-<?= $lang ?>:before {
          background-image: url(<?= $header_signatures[$lang]['large']['svg'] ?>) !important;
        }

        .mz-no-svg #main-slider.sfu .item-signature-<?= $lang ?>:before {
          background-image: url(<?= $header_signatures[$lang]['large']['png'] ?>) !important;
        }

        @media (min-device-height:992px) and (orientation:landscape),
        screen and (min-device-width: 992px) {
          #main-slider.sfu .signature-<?= $lang ?>:before {
            background-image: url(<?= $header_signatures[$lang]['large']['svg'] ?>) !important;
          }

          .mz-no-svg #main-slider.sfu .signature-<?= $lang ?>:before {
            background-image: url(<?= $header_signatures[$lang]['large']['png'] ?>) !important;
          }
        }

        #header-visual.sfu .header-signature-<?= $lang ?>:before {
          background-image: url(<?= $header_signatures[$lang]['small']['svg'] ?>) !important;
        }

        .mz-no-svg #header-visual.sfu .header-signature-<?= $lang ?>:before {
          background-image: url(<?= $header_signatures[$lang]['small']['png'] ?>) !important;
        }

        <?php endforeach; ?>
      </style>
    <?php endif; ?>
    <script type="text/javascript">
      if (!document.implementation.hasFeature("http://www.w3.org/TR/SVG11/feature#Image", "1.1"))
        document.documentElement.className += " mz-no-svg";
    </script>
    <script type="text/javascript">
      window.jQuery || document.write('<script src="<?= $path_to_theme ?>/js/lib/jquery/jquery-1.11.3.min.js"><\/script>');
    </script>

    <?= @$no_conflict_scripts ?>

    <script type="text/javascript">
      var $jq = jQuery.noConflict();
      window.jQuery = null;
      window.$ = null;
    </script>
    <script type="text/javascript">
      document.write('<script src="<?= $path_to_theme ?>/js/lib/jquery/jquery-1.3.2.min.js"><\/script>');
    </script>
    <?= $head_scripts ?>
  </head>

  <body class="<?= $page_class ? $page_class : '' ?>">
  <? endif; ?>

  <? if (!isset($hide_body) || !$hide_body) : ?>
    <script>
      <? $overlayHtml = '<div id="overlay-spinner">'
        . '<div class="overlay-spinner-dot dot-1"></div>'
        . '<div class="overlay-spinner-dot dot-2"></div>'
        . '<div class="overlay-spinner-dot dot-3"></div>'
        . '<div class="overlay-spinner-dot dot-4"></div>'
        . '<div class="overlay-spinner-dot dot-5"></div>'
        . '<div class="overlay-spinner-dot dot-6"></div>'
        . '<div class="overlay-spinner-dot dot-7"></div>'
        . '<div class="overlay-spinner-line line-1"></div>'
        . '<div class="overlay-spinner-line line-2"></div>'
        . '<div class="overlay-spinner-line line-3"></div>'
        . '<div class="overlay-spinner-line line-4"></div>'
        . '<div class="overlay-spinner-line line-5"></div>'
        . '</div>';
      ?>

      document.write((document.cookie.indexOf('sfu_inverted_overlay=1') >= 0 ? '<div id="special-overlay" class="inverted-overlay">' : '<div id="special-overlay">') + '<?= $overlayHtml ?></div>');
    </script>
    <noscript>
      <div id="special-overlay">
        <?= $overlayHtml ?>
      </div>
    </noscript>

    <?= $body_prefix ?>

    <header id="header">
      <div class="top-back"></div>
      <div class="header-top">
        <h1 id="main-logo">
          <a href="<?= $link_home ?>" class="main-logo-link" title="<?= custom_t('На главную страницу сайта') ?>">
            <img src="<?= $path_to_theme ?>/img/svg/main-logo-mobile.svg?v=1" onerror="this.onerror=null; this.src='<?= $path_to_theme ?>/img/main-logo-mobile.png?v=1'" width="300" height="48" class="main-logo-image mobile" alt="<?= custom_t('Сибирский федеральный университет') ?>">
            <img src="<?= $path_to_theme ?>/img/svg/main-logo-short.svg?v=1" onerror="this.onerror=null; this.src='<?= $path_to_theme ?>/img/main-logo-short.png?v=1'" width="70" height="61" class="main-logo-image short" alt="<?= custom_t('Сибирский федеральный университет') ?>">
            <img src="<?= $path_to_theme ?>/img/svg/main-logo.svg?v=1" onerror="this.onerror=null; this.src='<?= $path_to_theme ?>/img/main-logo.png?v=1'" width="252" height="61" class="main-logo-image" alt="<?= custom_t('Сибирский федеральный университет') ?>">
            <?= custom_t('Сибирский федеральный университет') ?>
          </a>
        </h1> <!-- /main-logo -->
        <nav id="main-menu">
          <ul class="items"><?= $menu_primary ?></ul>
          <a href="#" id="scroll-2-top"><?= custom_t('Наверх') ?></a>
        </nav> <!-- /main-menu -->
      </div>
      <!--/header-top-->

      <!-- header bottom -->
      <?php if ($_SERVER['REQUEST_URI'] == '/test' || $_SERVER['REQUEST_URI'] == '/user/238') : ?>
        <!-- new header bottom -->
        <?= icons_theme(); ?>
        <!-- /new header bottom -->
      <?php else : ?>
        <!-- old header bottom -->
        <div class="bottom-back"></div>
        <div class="header-bottom">
          <div class="slogan"><?= custom_t('Управляй своим будущим') ?></div>
          <nav id="additional-menu">
            <ul class="items">
              <?= $menu_secondary ?>
              <li class="item special"><a href="#" itemprop="copy" class="item-link" title="<?= custom_t('Версия для слабовидящих') ?>"><span class="item-title"><?= custom_t('Версия для слабовидящих') ?></span></a></li>
            </ul>
          </nav>
        </div>
        <!-- /old header bottom -->
      <?php endif; ?>
      <!-- /header bottom -->

    </header>

    <?php if (!$portal_page) : ?>
      <a href="<?= ($section_home == '') ? '/' : $section_home ?>" id="header-visual" class="sfu">
        <div class="header-visual-image">
          <img src="<?= $header_image ?>" width="970" height="140" alt="">
        </div>
        <div class="header-signatures">
          <div class="header-signature-ru"></div>
          <div class="header-signature-en"></div>

          <?php if (FALSE) : ?>
            <div class="header-signature-crape"></div>
          <?php endif; ?>
        </div>
      </a> <!-- /header-visual -->

      <?php if ($breadcrumb != '') : ?>
        <noindex>
          <div id="breadcrumbs"><?= $breadcrumb ?></div>
        </noindex>
      <?php else : ?>
        <div id="breadcrumbs">
          <ul class='items'></ul>
        </div>
      <?php endif; ?>
    <?php endif; ?>

    <?php if ($portal_page) : ?>
      <?= $help ?>
      <div class="text"><?= $messages ?></div>

      <?= $content ?>
      <?= $feed_icons ?>

      <?php if ($sidebar_left != '' || $mobile_menu != '') : ?>
        <nav id="side-menu" class="main">
          <?= $mobile_menu ?>
          <?= $sidebar_left ?>
        </nav>
      <?php endif; ?>
    <?php else : ?>
      <div id="content-body">
        <section id="page-content" class="<?= ($sidebar_left ? 'with-side-menu' : 'with-hidden-side-menu') ?>">
          <?php if (isset($long_title) && $long_title != '') : ?>
            <?= $long_title ?>
            <?php $title = ''; ?>
          <?php endif; ?>

          <?php if ($title != '') : ?>
            <h2><?= $title ?></h2>
          <?php endif; ?>

          <?php if ($tabs != '') : ?>
            <div class="tabs"><?= $tabs ?></div>
          <?php endif; ?>

          <?= $help ?>

          <?php if ($messages != '') : ?>
            <div class='text'><?= $messages ?></div>
          <?php endif; ?>

          <div class='text'><?= $content ?></div>

          <?= $feed_icons ?>
        </section> <!-- /page-content -->

        <?php if ($sidebar_left || $mobile_menu) : ?>
          <nav id="side-menu">
            <?= $mobile_menu ?>
            <?= $sidebar_left ?>
          </nav>
        <?php endif; ?>

      </div> <!-- /content-body -->

      <?php if ($language == 'ru') : ?>
        <div id="side-fast-nav">
          <?= $menu_audience ?>
          <a class="side-fast-nav-switcher"></a>
        </div>
      <?php endif; ?>

    <?php endif; ?>

    <?php
    // Заказ обратного звонка. Отключен по просьбе Куприяна 08-12-2020
    // if ($_SERVER['HTTP_HOST'] == 'admissions.sfu-kras.ru') {
    //     require('includes/mango-callback.php');
    //   }
    ?>

    <!--  Плавающая кнопка на английской версии -->
    <?php if ($language == 'en') : ?>
      <div class="fab">
        <!-- <a class='fab-text' href='http://welcome.sfu-kras.ru/?utm=en'>HOW TO APPLY</a> -->
        <a class='fab-text' href='http://www.sfu-kras.ru/en/education/admission'>APPLY NOW</a>
      </div>
      <a href='http://www.sfu-kras.ru/en/education/admission'>
        <img class="fab-icon" src="<?= $path_to_theme ?>/img/globe.svg"></img>
        <p class="fab-link" style="display: none">&nbsp;</p>
      </a>
    <?php endif; ?>

    <footer id="footer">
      <div class="footer-top">
        <div class="footer-top-content">
          <nav id="footer-fast-nav">
            <?= $menu_audience ?>
          </nav>
          <div id="footer-contacts">
            <div class="footer-contacts-links">
              <p>
                <a href='http://smi.sfu-kras.ru/our-smi/site'><?= custom_t('Редакция сайта') ?></a><br>
                <a href="<?= $link_contact ?>"><?= custom_t('Контактная информация') ?></a>
              </p>
              <p><a href="<?= $link_feedback ?>"><?= custom_t('Сообщить об ошибке') ?></a></p>
            </div>
            <div class="footer-contacts-phones">
              <p>
                <?= custom_t('Единая справочная служба') ?>:
                <span class="tel" data-tel="+7 (391) 206-22-22">+7 (391) 206-22-22</span>
              </p>
              <p>
                <?= custom_t('Приёмная комиссия') ?>:
                <span class="tel" data-tel="+7 (800) 550-22-24">+7 (800) 550-22-24</span>
                <span class="tel" data-tel="+7 (391) 206-20-04">+7 (391) 206-20-04</span>
                <span class="tel" data-tel="*4024">*4024 <small>(только с мобильного)</small></span>
              </p>
            </div>
            <div class="footer-contacts-bottom">
              <p class="info">
                <a href='http://www.sfu-kras.ru/sveden'><?= custom_t('Сведения об образовательной организации') ?></a>
                <a href='http://my.sfu-kras.ru/anti-corruption' target="_blank"><?= custom_t('Противодействие коррупции') ?></a>
              </p>
            </div>
          </div> <!-- /footer-contacts -->
        </div> <!-- /footer-top-content -->
      </div> <!-- /footer-top -->
      <div class="footer-bottom">
        <div class="footer-bottom-content">
          <div id="footer-legal-info">
            <p class="copyright">&copy; <?= custom_t('Сибирский федеральный университет') ?>, 2006-<?= date('Y') ?></p>
            <p class="terms"><?= custom_t('При использовании текстовых и графических материалов ссылка на сайт обязательна') ?></p>
          </div>
          <div id="sintonika">
            <noindex>
              <p>
                <a class="sintonika-link" href="http://sintonika.ru/">
                  <?= custom_t('Разработка дизайна сайта') ?>:<br>
                  <?= custom_t('компания «<span>SINTONIKA</span>»') ?>
                </a>
              </p>
            </noindex>
          </div>
          <form id="footer-search" name="footer-search" action="<?= $_SERVER['HTTP_HOST'] === 'pay.sfu-kras.ru' ? '//' : 'http://' ?>search.sfu-kras.ru/" method="get">
            <div class="form-elem">
              <input type="search" name="q" id="footer-search-query" autocomplete="on" spellcheck="true" autocapitalize="off" autocorrect="off" required="required" maxlength="140">
              <label for="footer-search-query"><?= custom_t('Что ищем?') ?></label>
              <input type='hidden' name='lang' value='<?= $language ?>'>
              <input type='hidden' name='domain' value='<?= $site == 'www.sfu-kras.ru' ? 'sfu-kras.ru' : $site ?>'>
              <button type="submit" class="button" title="<?= custom_t('Найти') ?>"><span class="button-title"><?= custom_t('Найти') ?></span></button>
            </div>
          </form>
        </div>
      </div> <!-- /footer-bottom -->
    </footer>

    <div id="topbar">
      <a class="header-link-special" href="#special-version" itemprop="copy"></a>

      <nav id="header-links">

        <ul class="items">
          <li class="item">
            <a class="item-link">
              <span class="item-title"><?= custom_t('Институты') ?></span>
            </a>

            <div class="item-content">
              <ul class="list">
                <?= $links_institutes ?>
                <?= $links_branches ?>
              </ul>
            </div> <!-- /item-content -->
          </li> <!-- /item -->

          <?php if ($language == 'ru') : ?>
            <noindex>
              <li class="item"><a class="item-link"><span class="item-title"><?= custom_t('Подразделения') ?></span></a>
                <div class="item-content">
                  <ul class='subitems'><?= $links_departments ?></ul>
                </div>
              </li>

              <li class="item"><a class="item-link"><span class="item-title"><?= custom_t('Сайты') ?></span></a>
                <div class="item-content">
                  <ul class='subitems'><?= $links_sites ?></ul>
                </div>
              </li>

              <li class="item visible-max-phone"><a class="item-link"><span class="item-title"><?= custom_t('Соц. сети') ?></span></a>
                <div class="item-content">
                  <ul class='list'><?= $links_nets ?></ul>
                </div>
              </li>

              <li class="item">
                <a class="item-link single" href="http://sfu-kras.ru/sveden"><span class="item-title"><?= custom_t('Сведения о вузе') ?></span></a>
              </li>

              <!-- Социальные сети. -->
              <!-- vk.com -->
              <li class="item visible-min-desktop">
                <a class="item-link-sn list vk"></a>
                <ul class="subitems-sn">
                  <li class="subitem-sn"><a class="subitem-link-sn" href="https://vk.com/siberianfederal">ВКонтакте</a></li>
                  <li class="subitem-sn"><a class="subitem-link-sn" href="https://vk.com/dovuz_sfu">ВКонтакте — абитуриенту</a></li>
                  <li class="subitem-sn"><a class="subitem-link-sn" href="https://vk.com/sfu_news">ВКонтакте — новости</a></li>
                </ul>
              </li>
              <!-- instagram.com -->
              <li class="item visible-min-desktop">
                <a class="item-link-sn list instagram"></a>
                <ul class="subitems-sn">
                  <li class="subitem-sn"><a class="subitem-link-sn" href="https://www.instagram.com/sfuniversity">Instagram</a></li>
                  <li class="subitem-sn"><a class="subitem-link-sn" href="https://www.instagram.com/dovuz.sfu">Instagram — абитуриенту</a></li>
                </ul>
              </li>
              <!-- telegram.com -->
              <li class="item visible-min-desktop">
                <a class="item-link-sn list telegram"></a>
                <ul class="subitems-sn">
                  <li class="subitem-sn"><a class="subitem-link-sn" href="https://web-telegram.ru/#/im?p=@SibFUofficial" target="_blank"><strong>@SibFUofficial</strong> — официальный аккаунт СФУ</a></li>
                  <li class="subitem-sn"><a class="subitem-link-sn" href="https://web-telegram.ru/#/im?p=@dovuz_sfu" target="_blank"><strong>@dovuz_sfu</strong> — для абитуриентов</a></li>
                  <!-- <li class="subitem-sn"><a class="subitem-link-sn" href="https://web-telegram.ru/#/im?p=@sibfuisthereforyou" target="_blank"><strong>@sibfuisthereforyou</strong> — для иностранных студентов</a></li> -->
                  <li class="subitem-sn"><a class="subitem-link-sn" href="https://web-telegram.ru/#/im?p=@SibFU_admission" target="_blank"><strong>@SibFU_admission</strong> — для иностранных абитуриентов</a></li>
                </ul>
              </li>
              <!-- twitter.com -->
              <li class="item visible-min-desktop">
                <a class="item-link-sn list twitter"></a>
                <ul class="subitems-sn">
                  <li class="subitem-sn"><a class="subitem-link-sn" href="https://twitter.com/SibFULive">Twitter</a></li>
                  <li class="subitem-sn"><a class="subitem-link-sn" href="https://twitter.com/sfu_news">Twitter — новости</a></li>
                </ul>
              </li>
              <!-- youtube.com -->
              <li class="item visible-min-desktop">
                <a class="item-link-sn youtube" href="https://www.youtube.com/user/dovuz"></a>
              </li>
              <!-- facebook.com -->
              <li class="item visible-min-desktop">
                <a class="item-link-sn facebook" href="https://www.facebook.com/SibFULive"></a>
              </li>
              <!-- Социальные сети. -->

            </noindex>
          <?php endif; ?>

          <?php if ($language == 'en') : ?>
            <noindex>
              <!-- Социальные сети. -->
              <!-- facebook.com -->
              <li class="item visible-min-desktop">
                <a class="item-link-sn facebook" href="https://www.facebook.com/siberianfederal"></a>
              </li>
              <!-- instagram.com -->
              <li class="item visible-min-desktop">
                <a class="item-link-sn instagram" href="https://www.instagram.com/sibfu_world/?hl=ru"></a>
              </li>
              <!-- telegram.com -->
              <li class="item visible-min-desktop">
                <a class="item-link-sn telegram" href="https://t.me/AdmissionSIB_bot"></a>
              </li>
              <!-- weibo.com -->
              <li class="item visible-min-desktop">
                <a class="item-link-sn weibo" href="https://weibo.com/p/1005057480812009/home?from=page_100505&mod=TAB&is_all=1#place"></a>
              </li>
              <!-- vk.com -->
              <li class="item visible-min-desktop">
                <a class="item-link-sn vk" href="https://vk.com/internationalsibfu"></a>
              </li>
              <!-- youtube.com -->
              <li class="item visible-min-desktop">
                <a class="item-link-sn youtube" href="https://www.youtube.com/channel/UCDLwDnS0jD1j_yfpW4z3dBQ/featured"></a>
              </li>
              <!-- twitter.com -->
              <li class="item visible-min-desktop">
                <a class="item-link-sn twitter" href="https://twitter.com/SibFUniversity"></a>
              </li>
              <!-- Социальные сети. -->

            </noindex>
          <?php endif; ?>
        </ul>

      </nav> <!-- /header-links -->

      <form id="header-search" name="header-search" action="<?= $_SERVER['HTTP_HOST'] === 'pay.sfu-kras.ru' ? '//' : 'http://' ?>search.sfu-kras.ru/" method="get">
        <input type="search" name="q" id="header-search-query" autocomplete="on" spellcheck="true" autocapitalize="off" autocorrect="off" required="required" maxlength="140">
        <label for="header-search-query"><?= custom_t('Поиск') ?></label>
        <input type="hidden" name="lang" value="<?= $language ?>">
        <input type="hidden" name="domain" value="<?= ($site == 'www.sfu-kras.ru') ? 'sfu-kras.ru' : $site ?>">
        <button type="submit" class="button" title="<?= custom_t('Найти') ?>">
          <span class="button-title"><?= custom_t('Найти') ?></span>
        </button>
      </form> <!-- /header-search -->

      <nav id="lang-select">
        <ul class="items <?= !$lang_items ? ('count-' . count($langs)) : '' ?>">

          <?php if ($lang_items) : ?>
            <?= $lang_items ?>
          <?php else : ?>
            <?php
            $langs_data = array(
              'zh' => array(
                'system' => 'zh-hans',
                'link' => '//www.sfu-kras.ru/cn',
                'title' => 'In Chinese / 中国',
              ),
              'es' => array(
                'system' => 'es',
                'link' => '//www.sfu-kras.ru/es',
                'title' => 'In Spanish / En Español',
              ),
              'de' => array(
                'system' => 'de',
                'link' => '//www.sfu-kras.ru/de',
                'title' => 'In German / Auf Deutsch',
              ),
              'en' => array(
                'system' => 'en',
                'link' => '//www.sfu-kras.ru/en',
                'title' => 'In English',
              ),
              'ru' => array(
                'system' => 'ru',
                'link' => '//www.sfu-kras.ru/',
                'title' => 'In Russian / На русском',
              ),
            );
            ?>

            <?php foreach ($langs_data as $lang => $data) : ?>
              <?php if (!$langs || isset($langs[$lang])) : ?>
                <li class="item <?= $lang ?> <?= ($data['system'] === $language ? 'current' : '') ?>">
                  <a href="<?= $langs ? $langs[$lang] : $data['link'] ?>" class="item-link" title="<?= $data['title'] ?>">
                    <span class="item-title"><?= ucfirst($lang) ?></span>
                  </a>
                </li>
              <?php endif; ?>
            <?php endforeach; ?>
          <?php endif; ?>

        </ul>
      </nav> <!-- /lang-select -->
    </div>

    <nav id="navigator" class="<?= (!$portal_page ? 'inside' : '') ?>">
      <ul class="items">
        <li class="item">
          <a href="#header" class="item-link">
            <span class="item-title"><?= custom_t('ВВЕРХ') ?></span>
          </a>
        </li>

        <?php foreach ($navigator as $nav_href => $nav_title) : ?>
          <li class="item">
            <a href="<?= $nav_href ?>" class="item-link">
              <span class="item-title"><?= $nav_title ?></span>
            </a>
          </li>
        <?php endforeach; ?>

        <li class="item">
          <a href="#footer" class="item-link">
            <span class="item-title"><?= custom_t('ВНИЗ') ?></span>
          </a>
        </li>
      </ul>
    </nav> <!-- /navigator -->

    <!--  photoswipe -->
    <div class="pswp" tabindex="-1" role="dialog" aria-hidden="true">
      <!-- Background of PhotoSwipe -->
      <div class="pswp__bg"></div>
      <!-- Slides wrapper with overflow:hidden -->
      <div class="pswp__scroll-wrap">
        <!-- Container that holds slides -->
        <div class="pswp__container">
          <div class="pswp__item"></div>
          <div class="pswp__item"></div>
          <div class="pswp__item"></div>
        </div>
        <!-- Default interface on top of sliding area -->
        <div class="pswp__ui pswp__ui--hidden">
          <div class="pswp__top-bar">
            <!-- Order can be changed. -->
            <div class="pswp__counter"></div>
            <button class="pswp__button pswp__button--close" title="Закрыть (клавиша «Esc»)"></button>
            <button class="pswp__button pswp__button--fs" title="Полноэкранный режим вкл/выкл"></button>
            <button class="pswp__button pswp__button--zoom" title="Зум +/–"></button>
            <button class="pswp__button pswp__button--src" title="Скачать оригинал фотографии"></button>
            <button class="pswp__button pswp__button--dl" title="Скачать эту фотографию"></button>
            <button class="pswp__button pswp__button--info" title="Информация об условиях съёмки"></button>
            <div class="pswp__preloader">
              <div class="pswp__preloader__icn">
                <div class="pswp__preloader__cut">
                  <div class="pswp__preloader__donut"></div>
                </div>
              </div>
            </div>
          </div>
          <div class="pswp__share-modal pswp__share-modal--hidden pswp__single-tap">
            <div class="pswp__share-tooltip"></div>
          </div>
          <button class="pswp__button pswp__button--arrow--left" title="Предыдущее изображение (клавиша «Влево»)">
          </button>
          <button class="pswp__button pswp__button--arrow--right" title="Следующее изображение (клавиша «Вправо»)">
          </button>
          <div class="pswp__caption">
            <div class="pswp__caption__center"></div>
          </div>
        </div>
      </div>
    </div>
    <!-- /photoswipe -->
    <noindex>
      <nav id="special-panel">
        <ul class="special-panel-items">
          <li class="special-panel-item">
            <span class="special-panel-item-title"><?= custom_t('Размер шрифта') ?>:</span>

            <ul id="special-font" class="options">
              <li class="option option-1"><a class="option-link"><span class="option-title">A</span></a></li>
              <li class="option option-2"><a class="option-link"><span class="option-title">A</span></a></li>
              <li class="option option-3"><a class="option-link"><span class="option-title">A</span></a></li>
            </ul>
          </li>
          <li class="special-panel-item" id='special-panel-scheme'>
            <span class="special-panel-item-title"><?= custom_t('Цветовая схема') ?>:</span>

            <ul id="special-scheme" class="options">
              <li class="option option-1">
                <a class="option-link">
                  <span class="option-title"><?= custom_t('Ц') ?></span>
                </a>
              </li>
              <li class="option option-2">
                <a class="option-link">
                  <span class="option-title"><?= custom_t('Ц') ?></span>
                </a>
              </li>
            </ul>
          </li>
          <li class="special-panel-item">
            <span class="special-panel-item-title"><?= custom_t('Изображения') ?>:</span>

            <ul id="special-images" class="options">
              <li class="option option-1">
                <a class="option-link">
                  <span class="option-title"><?= custom_t('Вкл') ?></span>
                </a>
              </li>
              <li class="option option-2">
                <a class="option-link">
                  <span class="option-title"><?= custom_t('Выкл') ?></span>
                </a>
              </li>
            </ul>
          </li>
        </ul>
      </nav>
    </noindex>

    <?= $scripts ?>
  <?php else : // hide_body 
  ?>
    <?= $page_top ?>
    <?= $page ?>
    <?= $page_bottom ?>
  <?php endif; ?>

  <?php if (!isset($hide_root) || !$hide_root) : ?>
    <!-- Коды счетчиков и проч. -->
    <?php if (isset($script)) : ?>
      <?= $script ?>
    <?php endif; ?>

    <?= $closure ?>
    <!-- /Код счетчиков и проч. -->
    <?= sfu_icons_rating__links(); ?>
  </body>

  </html>
<?php endif; ?>