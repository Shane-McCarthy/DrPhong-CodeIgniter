	
	<head>
		<meta charset="utf-8">
		<title><?php if (isset($title)): ?><?php echo $title ?><?php else: ?>Doctor Phong<?php endif; ?></title>
		
		<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE8" />
		
		<link rel="shortcut icon" type="image/x-icon" href="/favicon.ico" />
		
		<link rel="stylesheet" href="/static/css/screen.css" type="text/css" media="screen, projection" />
		<link rel="stylesheet" href="/static/css/phong.css" type="text/css" media="screen, projection" />
		<link rel="stylesheet" href="/static/css/jquery-ui-1.8.9.custom.css" type="text/css" media="screen" />
		<link rel="stylesheet" href="/static/css/jquery.colorpicker.css" type="text/css" media="screen, projection" />
		<link rel="stylesheet" href="/static/css/jquery.boxy.css" type="text/css" media="screen, projection" />
		<!--[if lt IE 8]><link rel="stylesheet" href="/static/css/ie.css" type="text/css" media="screen, projection" /><![endif]-->
		
		<script type="text/javascript" src="/static/js/jquery.1.5.js"></script>
		<script type="text/javascript" src="/static/js/jquery.bbq.js"></script>
		<script type="text/javascript" src="/static/js/jquery.colorpicker.js"></script>
		<script type="text/javascript" src="/static/js/jquery.boxy.js"></script>
		<script type="text/javascript" src="/static/js/jquery.soundmanager.js"></script>
		<script type="text/javascript" src="/static/js/jquery.player.js"></script>
		<script type="text/javascript" src="/static/js/jquery.domwindow.js"></script>
		<script type="text/javascript" src="/static/js/jquery-ui-1.8.9.custom.min.js"></script>
		
		<link rel="shortcut icon" href="/favicon.ico" >
		 <link rel="icon" type="image/jpeg" href="/favicon.jpg" />
		
        <?php if(isset($keywords)): ?><meta name="KEYWORDS" content="<?php echo $keywords; ?>" /><?php endif; ?>
        <?php if(isset($description)): ?><meta name="DESCRIPTION" content="<?php echo $description; ?>" /><?php endif; ?>
        <meta name="ROBOTS" content="INDEX, FOLLOW, NOODP, NOYDIR" />
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-11440612-1']);
  _gaq.push(['_trackPageview',location.pathname+location.search+location.hash]);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
<!-- Piwik -->
<script type="text/javascript"> 
  var _paq = _paq || [];
  _paq.push(['trackPageView']);
  _paq.push(['enableLinkTracking']);
  (function() {
    var u=(("https:" == document.location.protocol) ? "https" : "http") + "://doctorphong.com/analytics/piwik//";
    _paq.push(['setTrackerUrl', u+'piwik.php']);
    _paq.push(['setSiteId', 1]);
    var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0]; g.type='text/javascript';
    g.defer=true; g.async=true; g.src=u+'piwik.js'; s.parentNode.insertBefore(g,s);
  })();

</script>
<noscript><p><img src="http://doctorphong.com/analytics/piwik/piwik.php?idsite=1" style="border:0" alt="" /></p></noscript>
<!-- End Piwik Code -->
	</head>
