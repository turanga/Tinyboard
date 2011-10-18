<?php

/*
 *  Instance Configuration
 *  ----------------------
 *  Edit this file and not config.php for imageboard configuration.
 *
 *  You can copy values from config.php (defaults) and paste them here.
 */


	$config['db']['type'] = 'mysql';
	$config['db']['server'] = 'localhost';
	$config['db']['database'] = '';
	$config['db']['user'] = '';
	$config['db']['password'] = '';


	$config['cookies']['session'] = 'imgboard';
	$config['cookies']['time'] = 'arrived';
	$config['cookies']['hash'] = 'hash';
	$config['cookies']['mod'] = 'mod';
	$config['cookies']['salt'] = '';

	$config['flood_time'] = 10;
	$config['flood_time_ip'] = 120;
	$config['flood_time_same'] = 30;
	$config['max_body'] = 1800;
	$config['reply_limit'] = 250;
	$config['max_links'] = 20;
	$config['max_filesize'] = 10485760;
	$config['thumb_width'] = 255;
	$config['thumb_height'] = 255;
	$config['max_width'] = 10000;
	$config['max_height'] = 10000;
	$config['threads_per_page'] = 10;
	$config['max_pages'] = 10;
	$config['threads_preview'] = 5;
	$config['root'] = '/';

	$config['dir']['img'] = 'src/';
	$config['dir']['thumb'] = 'thumb/';
	$config['dir']['res'] = 'res/';

	$config['secure_trip_salt'] = '';


	$config['stylesheets'] = Array(
		'futaba' => 'futaba.css',
		'burichan' => 'burichan.css',
		'darkchan' => 'darkchan.css',
		'armedbastards' => 'armedbastards.css',
		'awsum' => 'awsum.css',
		'neutron' => 'neutron.css',
		'photon' => 'photon.css',
		'uboachan' => 'uboachan.css',
		'Yotsuba B' => 'default.css',
		'Yotsuba' => 'yotsuba.css'
	);
	$config['default_stylesheet'] = Array('neutron', $config['stylesheets']['neutron']);

	// Display the file's original filename
	$config['show_filename']= false;
	$config['enable_embedding'] = true;
	$config['url_favicon'] = '/static/yobafav.png';

	// Boardlinks
	// You can group, order and place the boardlist at the top of every page, using the following template.	
	$config['boards'] = Array(
		Array('bn', 'a', 'b' , 'bu' , 'rm' , 'nyan'),
		Array('nyanchat' => '/chat.html' , 'FAQ' => '/faq.html' , 'recent' => '/recent.html' , 'announce' => '/index.html')

	);
	
	// Categories
	// Required for the Categories theme. Array of the names of board groups in order, from $config['boards'].
	//$config['categories'] = Array('groupname', 'name', 'anothername', 'kangaroos');
	
	// Custom_categories
	// Optional for the Categories theme. Array of name => (title, url) groups for categories with non-board links.
	//$config['custom_categories'] = Array( 'Links' =>
	//	Array('Tinyboard' => 'http://tinyboard.org',
	//	'AnotherName' => 'url')
	//);

	$config['blotter'] = 'Board is under active developement. Welcome and discuss features.';

	$config['timezone'] = 'Europe/Moscow';
 	// The string passed to date() for post times
	// http://php.net/manual/en/function.date.php

	$config['post_date']	= 'd M Y D H:i:s';


	// Always act as if they had typed "noko" in the email field no mattter what
	$config['always_noko']	= true;
	// Optional spoiler images
	$config['spoiler_images'] = true;
	$config['dir']['static']	= $config['root'] . 'static/';
	$config['image_sticky']		= $config['dir']['static'] . 'sticky.png';
	$config['image_locked']		= $config['dir']['static'] . 'locked.png';

	$config['mod']['sticky'] = JANITOR;
	// Lock a thread
	$config['mod']['lock'] = JANITOR;
	// Post in a locked thread
	$config['mod']['postinlocked'] = JANITOR;
	// Post to the moderator noticeboard
	$config['mod']['noticeboard_post'] = JANITOR;
	// Post news entries
	$config['mod']['news'] = JANITOR;



	$config['embedding'] = Array(
		Array(
			'/^https?:\/\/(\w+\.)?prostopleer\.com\/tracks\/([a-zA-Z0-9-]{10,11})(&.+)?$/i',
			'<object width="411" height="28"><param name="movie" value="http://embed.prostopleer.com/track?id=$2"></param><embed src="http://embed.prostopleer.com/track?id=$2" type="application/x-shockwave-flash" width="411" height="28"></embed></object>'
		),
		Array(
			'/^https?:\/\/(\w+\.)?youtube\.com\/watch\?v=([a-zA-Z0-9-]{10,11})(&.+)?$/i',
			'<object style="float: left;margin: 10px 20px;" width="%%tb_width%%" height="%%tb_height%%"><param name="movie" value="http://www.youtube.com/v/$2?fs=1&amp;hl=en_US"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="http://www.youtube.com/v/$2?fs=1&amp;hl=en_US" type="application/x-shockwave-flash" width="%%tb_width%%" height="%%tb_height%%" allowscriptaccess="always" allowfullscreen="true"></embed></object>'
		),
		Array(
			'/^https?:\/\/(\w+\.)?xvideos\.com\/video(\d{5,8})\/([a-zA-Z0-9_\-.]+)?$/i',
			'<div class="floatiframe"><iframe src="http://flashservice.xvideos.com/embedframe/$2" frameborder=0 width=300 height="235" scrolling=no></iframe></div>'
		),
		Array(
			'/^https?:\/\/(\w+\.)?xhamster\.com\/movies\/(\d{5,8})\/([a-zA-Z0-9_\-.]+)?$/i',
			'<div class="floatiframe"><iframe width="300" height="235" src="http://xhamster.com/xembed.php?video=$2" frameborder="0" scrolling="no"></iframe></div>'
		),
		Array(
			'/^https?:\/\/(\w+\.)?vimeo\.com\/(\d{2,10})(\?.+)?$/i',
			'<object style="float: left;margin: 10px 20px;" width="%%tb_width%%" height="%%tb_height%%"><param name="allowfullscreen" value="true" /><param name="allowscriptaccess" value="always" /><param name="movie" value="http://vimeo.com/moogaloop.swf?clip_id=$2&amp;server=vimeo.com&amp;show_title=0&amp;show_byline=0&amp;show_portrait=0&amp;color=00adef&amp;fullscreen=1&amp;autoplay=0&amp;loop=0" /><embed src="http://vimeo.com/moogaloop.swf?clip_id=$2&amp;server=vimeo.com&amp;show_title=0&amp;show_byline=0&amp;show_portrait=0&amp;color=00adef&amp;fullscreen=1&amp;autoplay=0&amp;loop=0" type="application/x-shockwave-flash" allowfullscreen="true" allowscriptaccess="always" width="%%tb_width%%" height="%%tb_height%%"></embed></object>'
		),
		Array(
			'/^https?:\/\/(\w+\.)?dailymotion\.com\/video\/([a-zA-Z0-9]{2,10})(_.+)?$/i',
			'<object style="float: left;margin: 10px 20px;" width="%%tb_width%%" height="%%tb_height%%"><param name="movie" value="http://www.dailymotion.com/swf/video/$2"></param><param name="allowFullScreen" value="true"></param><param name="allowScriptAccess" value="always"></param><param name="wmode" value="transparent"></param><embed type="application/x-shockwave-flash" src="http://www.dailymotion.com/swf/video/$2" width="%%tb_width%%" height="%%tb_height%%" wmode="transparent" allowfullscreen="true" allowscriptaccess="always"></embed></object>'
		),
		Array(
			'/^https?:\/\/(\w+\.)?metacafe\.com\/watch\/(\d+)\/([a-zA-Z0-9_\-.]+)\/(\?.+)?$/i',
			'<div style="float:left;margin:10px 20px;width:%%tb_width%%px;height:%%tb_height%%px"><embed flashVars="playerVars=showStats=no|autoPlay=no" src="http://www.metacafe.com/fplayer/$2/$3.swf" width="%%tb_width%%" height="%%tb_height%%" wmode="transparent" allowFullScreen="true" allowScriptAccess="always" name="Metacafe_$2" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash"></embed></div>'
		),
		Array(
			'/^https?:\/\/video\.google\.com\/videoplay\?docid=(\d+)([&#](.+)?)?$/i',
			'<embed src="http://video.google.com/googleplayer.swf?docid=$1&hl=en&fs=true" style="width:%%tb_width%%px;height:%%tb_height%%px;float:left;margin:10px 20px" allowFullScreen="true" allowScriptAccess="always" type="application/x-shockwave-flash"></embed>'
		)

	);

	 $config['google_analytics'] = '';
	// Keep the Google Analytics cookies to one domain -- ga._setDomainName()
	$config['google_analytics_domain'] = '';
        // Max body length
	$config['max_body']                     = 64000;
		
        // Enable reCaptcha to make spam even harder
        $config['recaptcha'] = false;
        // Public and private key pair from https://www.google.com/recaptcha/admin/create
        $config['recaptcha_public'] = '6LcXTcUSAAAAAKBxyFWIt2SO8jwx4W7wcSMRoN3f';
        $config['recaptcha_private'] = '6LcXTcUSAAAAAOGVbVdhmEM1_SyRF4xTKe8jbzf_';
					
					
        // Custom capcodes, by example:
        // "## Custom" becomes lightgreen, italic and bold
        //$config['custom_capcode']['Custom'] ='<a class="capcode" style="color:lightgreen;font-style:italic;font-weight:bold"> ## %s</a>';
        // "## Mod" makes everything purple, including the name and tripcode
        $config['custom_capcode']['Mod'] = Array(
              '<a class="capcode" style="color:purple"> ## %s</a>',
              'color:purple', // Change name style; optional
              'color:purple' // Change tripcode style; optional
        );
        // "## Admin" makes everything red and bold, including the name and tripcode
        $config['custom_capcode']['Admin'] = Array(
              '<a class="capcode" style="color:red;font-weight:bold"> ## %s</a>',
              'color:red;font-weight:bold', // Change name style; optional
              'color:red;font-weight:bold' // Change tripcode style; optional
	);

//	setlocale(LC_TIME, 'ru_RU.utf8');
	$config['locale'] = 'ru_RU.utf8';

	// Recommend picture 
	$config['mod']['link_recommend'] = '[+R]';
	$config['mod']['link_unrecommend'] = '[-R]';
	$config['mod']['recommend'] = JANITOR;
	$config['mod']['view_recommend'] = JANITOR;
//	$config['debug'] = true;
?>

