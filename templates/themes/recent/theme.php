<?php
	require 'info.php';
	
	function recentposts_build($action, $settings) {
		// Possible values for $action:
		//	- all (rebuild everything, initialization)
		//	- news (news has been updated)
		//	- boards (board list changed)
		//	- post (a post has been made)
		
		$b = new RecentPosts();
		$b->build($action, $settings);
	}
	
	// Wrap functions in a class so they don't interfere with normal Tinyboard operations
	class RecentPosts {
		public function build($action, $settings) {
			global $config, $_theme;
			
			if($action == 'all') {
				copy($config['dir']['themes'] . '/' . $_theme . '/recent.css', $config['dir']['home'] . 'recent.css');
			}
			
			$this->excluded = explode(' ', $settings['exclude']);
			
			if($action == 'all' || $action == 'post')
			//	file_put_contents($config['dir']['home'] . $config['file_index'], $this->homepage($settings));
				file_write($config['dir']['home'] . 'recent.html', $this->homepage($settings));
		}
		
		// Build news page
		public function homepage($settings) {
			global $config, $board;
			
			// HTML5
			$body = '<!DOCTYPE html><html>'
			. '<head>'
				.'<link href="/static/yobafav.png" rel="shortcut icon">'
				. '<link rel="stylesheet" media="screen" href="' . $config['url_stylesheet'] . '"/>'
				.'<link href="/stylesheets/neutron.css" id="stylesheet" type="text/css" rel="stylesheet">'
				. '<link rel="stylesheet" media="screen" href="' . $config['root'] . 'recent.css"/>'
				. '<title>' . $settings['title'] . '</title>'
			. '</head><body>';
			
			$boardlist = createBoardlist();
			$body .= '<div class="boardlist1">' . $boardlist['top'] . '</div>';
			
/*			$body .= '<h1>' . $settings['title'] . '</h1>';*/
			
			
			$boards = listBoards();
			

			$body .= '<div class="box-top1"> <div class="box-topinner">';
			$body .= '<div class="inner2"><img src="/static/1.png" alt="" /><ul class="ul1"><li><a href="/b/">/b/ - бред</a></li><li><a href="/b/">/b/ - бред</a></li><li><a href="/b/">/b/ - бред</a></li><li><a href="/b/">/b/ - бред</a></li><li><a href="/b/">/b/ - бред</a></li><li><a href="/b/">/b/ - бред</a></li><li><a href="/b/">/b/ - бред</a></li><li><a href="/b/">/b/ - бред</a></li><li><a href="/b/">/b/ - бред</a></li><li><a href="/b/">/b/ - бред</a></li></ul></div>';
			$body .= '<div class="inner3">Rechan — это система форумов, где можно общаться быстро и свободно, где любая точка зрения имеет право на жизнь. Здесь нет регистрации и подписываться не нужно, хотя это не избавляет вас от необходимости соблюдать правила. Все форумы (кроме /Б/реда), а их список находится снизу, имеют собственную чётко ограниченную тематику. Словом, всё, что не запрещено правилами отдельно взятого форума и относится к его тематике, на этом форуме разрешено.</div>';
			$body .= '</div> </div> ';

			// Wrap
			$body .= '<div class="box-wrap">';
			
			// Recent images
			$body .= '<div class="box left"><h2>Recent Images</h2><ul>';
				$query = '';
				foreach($boards as &$_board) {
					if(in_array($_board['uri'], $this->excluded))
						continue;
					$query .= sprintf("SELECT *, '%s' AS `board` FROM `posts_%s` WHERE `file` IS NOT NULL AND `recommend` = 1 UNION ALL ", $_board['uri'], $_board['uri']);
				}
				$query = preg_replace('/UNION ALL $/', 'ORDER BY `time` DESC LIMIT 5', $query);
				$query = query($query) or error(db_error());
				
				while($post = $query->fetch()) {
					openBoard($post['board']);
					
					$body .= '<li><a href="' . 
						$config['root'] . $board['dir'] . $config['dir']['res'] . ($post['thread']?$post['thread']:$post['id']) . '.html#' . $post['id'] .
					'"><img src="' . $config['uri_thumb'] . $post['thumb'] . '" style="width:' . $post['thumbwidth'] . 'px;height:' . $post['thumbheight'] . 'px;" alt=""/></a></li>';
				}
			$body .= '</ul></div>';
			
			$body .= '<div class="box right">';


			// Latest posts
			$body .= '<div class="innerbox"><h2>Breaking news</h2><ul>';
				$query = '';
				foreach($boards as &$_board) {
					if(in_array($_board['uri'], $this->excluded))
						continue;
//					$query .= sprintf("SELECT *, '%s' AS `board` FROM `posts_%s` UNION ALL ", $_board['uri'], $_board['uri']);
					$query .= sprintf("SELECT *, 'b' AS `board` FROM `posts_b` UNION ALL ");
				}
//				$query = preg_replace('/UNION ALL $/', 'WHERE thread IS NULL ORDER BY `time` DESC LIMIT 10', $query);
				$query = "SELECT *, 'b' AS `board` FROM `posts_b` WHERE thread IS NULL ORDER BY `time` DESC LIMIT 5";

				$query = query($query) or error(db_error());
				
				while($post = $query->fetch()) {

						$query1 = "SELECT COUNT(*) as num FROM `posts_b` WHERE thread = ".$post['id'];
						$query1 = query($query1) or error(db_error());
						$post1 = $query1->fetch();
					openBoard($post['board']);
					$path_thumbfile=$config['root'] . $board['dir'] . $config['dir']['thumb'] . $post['thumb'];
					$ext=($post['thumbwidth']<$post['thumbheight']?'height':'width');
					if($ext=='height')
							$extsize=($post['thumbheight']<100?$post['thumbheight']:100); else
						$extsize=($post['thumbwidth']<100?$post['thumbwidth']:100); 
					$path_thread=	$config['root'] . $board['dir'] . $config['dir']['res'] . ($post['thread']?$post['thread']:$post['id']) . '.html#';
					$body .= '<li><a href="' . $path_thread . $post['id'] .
					'"><h3>'.($post['subject']?$post['subject']:'Thread #'.$post['id']).' &rarr;</h3></a>' .($post['thumb']?'<img src="'. $path_thumbfile .'" '.$ext.'='.$extsize.' alt="" />':''). 
					truncate_news($post['body'], 1024) . '<br/><a href="'. $path_thread .'">comments: '.$post1['num'].'</a><br/><span class="timedate">written on '.date($config['post_date'], $post['time']).' by '.$post['name'].$post['trip'].'</span></li><hr/>';
				}
				
			$body .= '</ul></div>';
			

/*

			$body .= '<div class="innerbox"><h2>About</h2>';
			$body .= '<div class="innerbox1">Имиджборд (англ. imageboard, «доска изображений», также имиджборда, борда, чан от англ. chan, channel) — разновидность веб-форума с возможностью прикреплять к сообщениям графические файлы.Несмотря на схожесть слов, имиджборды не имеют отношения к имиджу. Оба слова восходят к английскому image (изображение, копия, образ).Отличительные особенности Имиджборды отличаются от прочих типов форумов по нескольким параметрам. анонимность — возможность оставлять сообщения без каких-либо регистраций и учётных записей. В некоторых разделах некоторых имиджбордов разрешены только анонимные сообщения. Если разрешены неанонимные сообщения, то вместо регистрации обычно применяется система трипкодов.    прикрепление файлов — возможность прикрепить к каждому сообщению файл (реже — несколько файлов). Обычно можно прикреплять только графические файлы, но встречаются и другие варианты, например прикрепление файлов flash или MP3. Прикрепленные файлы хранятся на сервере имиджборда.    отсутствие архивации по умолчанию — каждый раздел имиджборда может содержать не больше определённого количества тредов. Новое сообщение в треде поднимает его наверх. При создании нового треда самый нижний, то есть тот, в который писали наиболее давно, удаляется.    возможность архивации — каждый раздел имиджборда может быть настроен на архивацию тредов, которые вместо удаления переносятся в отдельную директорию.</div>';
			$body .= '</div>';
*/

			// Stats
/*			$body .= '<div class="innerbox"><h2>Stats</h2><ul>';
			
				// Total posts
				$query = 'SELECT SUM(`top`) AS `count` FROM (';
				foreach($boards as &$_board) {
					if(in_array($_board['uri'], $this->excluded))
						continue;
					$query .= sprintf("SELECT MAX(`id`) AS `top` FROM `posts_%s` UNION ALL ", $_board['uri']);
				}
				$query = preg_replace('/UNION ALL $/', ') AS `posts_all`', $query);
				$query = query($query) or error(db_error());
				$res = $query->fetch();
				$body .= '<li>Total posts: ' . number_format($res['count']) . '</li>';
				
				// Unique IPs
				$query = 'SELECT COUNT(DISTINCT(`ip`)) AS `count` FROM (';
				foreach($boards as &$_board) {
					if(in_array($_board['uri'], $this->excluded))
						continue;
					$query .= sprintf("SELECT `ip` FROM `posts_%s` UNION ALL ", $_board['uri']);
				}
				$query = preg_replace('/UNION ALL $/', ') AS `posts_all`', $query);
				$query = query($query) or error(db_error());
				$res = $query->fetch();
				$body .= '<li>Unique posters: ' . number_format($res['count']) . '</li>';
				
				// Active content
				$query = 'SELECT SUM(`filesize`) AS `count` FROM (';
				foreach($boards as &$_board) {
					if(in_array($_board['uri'], $this->excluded))
						continue;
					$query .= sprintf("SELECT `filesize` FROM `posts_%s` UNION ALL ", $_board['uri']);
				}
				$query = preg_replace('/UNION ALL $/', ') AS `posts_all`', $query);
				$query = query($query) or error(db_error());
				$res = $query->fetch();
				$body .= '<li>Active content: ' . format_bytes($res['count']) . '</li>';
				$body .= '</ul></div>';				

*/
$body .= '</div>';			

			$body .= '<div class="box right3"><h2>Announces</h2>';
			$query = query("SELECT * FROM `news` ORDER BY `time` DESC  LIMIT 6") or error(db_error());
			if($query->rowCount() == 0) {
				$body .= '<p style="text-align:center" class="unimportant">(No news to show.)</p>';
			} else {
				// List news
				while($news = $query->fetch()) {
					$body .= '<h3 id="' . $news['id'] . '">' .
						($news['subject'] ?
							$news['subject']
						:
							'<em>no subject</em>'
						) .
					'<span class="unimportant">'.
/* &mdash; by ' .
						$news['name'] .*/
					' at ' .
						date($config['post_date'], $news['time']) .
					'</span></h3><p>' . $news['body'] . '</p>';
				}
			}
			
			$body .= '</div>';

			// End wrap
			$body .= '</div>';
			
			// Finish page
			$body .= '<div class="footer">Powered by Nyan Cat <img src="/static/nyan.gif" alt="nyan"/></div></body></html>';
			
			return $body;
		}
	};
function truncate_news($body, $max_chars = false) {
		$original_body = $body;
		$body = substr($body, 0, $max_chars);
		if($body != $original_body) {
			// Remove any corrupt tags at the end
			$body = preg_replace('/<([\w]+)?([^>]*)?$/', '', $body);
			// Open tags
			if(preg_match_all('/<([\w]+)[^>]*>/', $body, $open_tags)) {
				$tags = Array();
				for($x=0;$x<count($open_tags[0]);$x++) {
					if(!preg_match('/\/(\s+)?>$/', $open_tags[0][$x]))
						$tags[] = $open_tags[1][$x];
				}
				// List successfully closed tags
				if(preg_match_all('/(<\/([\w]+))>/', $body, $closed_tags)) {
					for($x=0;$x<count($closed_tags[0]);$x++) {
						unset($tags[array_search($closed_tags[1][$x], $tags)]);
					}
				}
				// Close any open tags
				foreach($tags as &$tag) {
					$body .= "</{$tag}>";
				}
			}
		}
		return $body;
}	
?>
