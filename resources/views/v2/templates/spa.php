<!DOCTYPE html>
<html>
<head>
  <!-- Google Tag Manager -->
  <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
          new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
          j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
          'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
      })(window,document,'script','dataLayer','GTM-WKBPN7L');</script>
  <!-- End Google Tag Manager -->
  <meta charset=utf-8>
  <meta name="description" content="">
  <meta name=viewport content="width=device-width,initial-scale=1">
  <meta http-equiv="Cache-Control" content="max-age=300, must-revalidate" />
  <meta name="csrf-token" content="<?= csrf_token() ?>">
  <!-- <title>Окна</title> -->
  <link rel="shortcut icon" href="/img/favicon.ico" type="image/x-icon">
  <link rel="preload" href="/css/app.css" as="style" />
  <link href="/css/app.css" rel="stylesheet">
  <link rel="preload" href="/fonts/Montserrat-Bold.woff" as="font" type="font/woff" crossorigin="anonymous">
  <link rel="preload" href="/fonts/Montserrat-Medium.woff" as="font" type="font/woff" crossorigin="anonymous">
  <link rel="preload" href="/fonts/Montserrat-SemiBold.woff" as="font" type="font/woff" crossorigin="anonymous">
  <link rel="preload" href="/fonts/Montserrat-ExtraBold.woff" as="font" type="font/woff" crossorigin="anonymous">
  <link rel="preload" href="/fonts/Montserrat-Light.woff" as="font" type="font/woff" crossorigin="anonymous">
  <link rel="preload" href="/fonts/Montserrat-Regular.woff" as="font" type="font/woff" crossorigin="anonymous">

  <link href='<?= route('sitemap') ?>' rel='alternate' title='Sitemap' type='application/rss+xml'/>
</head>
<body>
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-WKBPN7L"
                  height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
  <div id="app"></div>
  <?php //if(app()->environment('production')): ?>
    <? $mangoWidget = getMangoWidgetId(); ?>
    <div id="js-backend-parameters" data-mango-widget-id="<?=$mangoWidget?>" data-yandex-metrika="<?=SITE_CONTACTS[getUrlPathFirstPart()]['yandexMetrika']?>"></div>
  <?php //endif; ?>
<!-- <script type="text/javascript" src="/js/manifest.js"></script>
<script type="text/javascript" src="/js/vendor.js"></script> -->

<script type="text/javascript" src="/js/app.js" async></script>

</body>
</html>