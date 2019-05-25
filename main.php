	<?php

	abstract class View
	{
	public function render_html(){} 
	}

	class ViewDynamic extends View 
	{
		public function render_html($res)
		{
			if (is_array($res)){

				foreach ($res as $row){

					if(isset($row["image"]) and isset($row["title"]) and isset($row["description"])) {

	    				printf(" <center><img src='https://www.litmir.me/%s' max-width='216' max-height='335'></center> <center><h2>-- %s --</h2></center><p style='text-align:center;'>%s</p> <br/> <br/>", $row["image"],$row["title"],$row["description"]);
					}
				}
			
			}

		}
	}

	class ViewStatic extends View
	{
		public function render_html()
		{
			echo
					'
						<html>
	<head>
		<meta charset="utf-8">
		<script type="text/javascript" src="https://code.jquery.com/jquery-git.min.js"></script>
	<style>
	a
	{
		color:#3CB371;
	}
	a:visited;
	{
		color:#8FBC8F;
	}
	.spoiler {position:relative;} 
	.spoiler a.spoiler-head {
		display:block; float:left; margin:10px 0 2px 0; text-decoration:none;
		} 
	.spoiler a.spoiler-head span {
		padding:0; border-bottom:dashed 1px #71C83B; font-size:16px; color:#71C83B;
			} 
	.spoiler .spoiler-body {
		display:none; position:relative; padding:6px 0 0 0; margin:0; clear:both;} 
	</style>
	</head>
	<body>
	    <div style="margin-left:auto;margin-right: auto; width: 50%; text-align: center;">
	    <form id="filter" method="POST" action="">
	    	 <input type="text" name="book_name" id="title" placeholder="название книги">
	    	 <input type="submit" name="Update" id="search" value="search" />
	    	 <br/>
	    	 <br/>
	    <fieldset>
	    	<div class="spoiler"> <a class="spoiler-head" href="#">	<legend>Жанры</legend></a> 
	    	<div class="spoiler-body">
	    <input type="checkbox" id="fantastic" name="genre" value="fantastic">
	    <label for="fantastic">Fantastic</label>
	    <input type="checkbox" id="classic" name="genre" value="classic">
	    <label for="fantastic">Classic</label>
		</fieldset>
		<div class="clear"></div>
		<fieldset>
	    	<div class="spoiler"> <a class="spoiler-head" href="#">	<legend>Авторы</legend></a> 
	    	<div class="spoiler-body">
	    <input type="checkbox" id="Rowling" name="author" value="Rowling">
	    <label for="fantastic">Rowling</label>
	    <input type="checkbox" id="Astafiev" name="author" value="Astafiev">
	    <label for="fantastic">Astafiev</label>
		</fieldset>
		 <div class="clear"></div>
	</form>
	</div>
	<div style="margin-left: auto;margin-right: auto; width: 50%; color:gray; margin-bottom: 20px;" id="results"></div>
	</div>
	<script type="text/javascript">
		$(document).ready(function() {
			$(\'a.spoiler-head\').click(function()
				{ 
					$(this).next().toggle(200); return false; });
		});

		$(document).ready(function() {

		function showValues() {
	    var str = $( "form" ).serialize();
	    var str = decodeURIComponent(str);
	    $( "#results" ).text( str );
	    var str = encodeURIComponent(str);
	  }
	  $( "input[type=\'checkbox\'], input[type=\'text\']" ).on( "click", showValues );
	  $( "select" ).on( "change", showValues );
	  $( "#search" ).focusout(showValues);
	  showValues();


	document.body.onmouseover = document.body.onmouseout = handler;

	function handler(event) {
		  if (event.type == \'mouseout\') {
	    showValues();
	  }
	}

		});


	</script>
	</body>
	</html>

					'
			;
		}
	}

	class Scrapper
	{
		function __construct()
		{
			$url = "https://www.litmir.me/bs";
	$ch = curl_init();
	curl_setopt($ch,CURLOPT_URL,$url);
	curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
	$returned = curl_exec($ch);
	curl_close($ch);

	     

	$db  =  new  PDO('mysql:dbname=sql7290753; host=sql7.freemysqlhosting.net; port=3306',"sql7290753","d1waHgPJm2",
	        array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));

	$sql = "

	DROP TABLE titles_images, authors_genres_descr ;  

	";
	  $sth=$db->prepare($sql);
	  $sth->execute();



	  $sql = "

	CREATE database IF NOT EXISTS `sql7290753`;

	use `sql7290753`;

	CREATE TABLE IF NOT EXISTS `titles_images` ( `id` int(11) NOT NULL AUTO_INCREMENT, `title` varchar(255) NOT NULL, `image` varchar(255),  `description` TEXT NOT NULL,  PRIMARY KEY (`id`) ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

	CREATE TABLE IF NOT EXISTS `authors_genres` ( `id` int(11) NOT NULL AUTO_INCREMENT, `authors_genres` TEXT NOT NULL, PRIMARY KEY (`id`) ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ; 

	";

	  $sth=$db->prepare($sql);
	  $sth->execute();

	$pattern = '/[s]+[r]+[c]+[^\s]+[\.]+[j]+[p]+[g]/';
	$image_src = preg_match_all($pattern,$returned,$match);

	$dom = new DOMDocument();
	@$dom->loadHTML($returned);
	$xpath = new DOMXPath ($dom);

	$query = './/img[@class="lt32 lazy"]|.//div[@class="lt37"]'; 
	#В одном цикле все обработать или вынести один запрос отдельно и тогда каждый массив
	#images,names,descriptions будут содержать от 0 до 24 элементов соответственно относящихся к одной #книге. Сейчас записи images и names соответсвенно совпадают, записи descriptions смещены на 1 вперед.
	$query2 = './/div[contains(@class,"desc_container")]';

	$entries = $xpath->query($query);

	$entries2 = $xpath->query($query2);  

	$images = array();

	$names = array();

	$descriptions = array();

	$authors_genres = array();

	foreach ($entries as $index=>$entry) {
		# img->attributes->NamedMap (item(6) - src)
		$attr = $entry->attributes; 
		$under_attr = $attr->item(6);
		
		$images[] = $under_attr->textContent;
		$image = $under_attr->textContent;

		$name = $entry->getAttribute('alt');

		$names[] = $name;

	  $description = $entry->textContent;

	  $descriptions[] = $entry->textContent;


	  $sql = "
	INSERT INTO `titles_images` #одним запросом нужно
	(`id`,`title`,`image`,`description`) 
	VALUES 
	(NULL,'".$name."','".$image."','".$description."')
	";
	  $sth=$db->prepare($sql);
	  $sth->bindValue(':title', $titles_images['title']);
	  $sth->bindValue(':image', $titles_images['image']);
	  $sth->bindValue(':description', $titles_images['description']);
	  $sth->execute();


	}

	foreach ($entries2 as $entry) {
		$authors_genres[] = $entry->textContent;

	  $sql = "
	INSERT INTO `authors_genres` #одним запросом нужно
	(`id`,`authors_genres`) 
	VALUES 
	(NULL,'".$authors_genres."')
	";
	  $sth=$db->prepare($sql);
	  $sth->bindValue(':authors_genres', $authors_genres['authors_genres']);
	  $sth->execute();

	}

	var_dump($images,$names,$descriptions,$authors_genres);

	$sql = 'SELECT * FROM `titles_images`';
	$sth = $db->prepare($sql);
	$sth->execute();
	$result = $sth->fetchAll(PDO::FETCH_ASSOC);
	foreach ($result as $row){
	    echo $row['title'] . ' | ' . $row['image'] . ' | ' . $row['description'] . "\n";
	}
	 
	/*
	MariaDB [Books]> explain titles_images;
	+-------+--------------+------+-----+---------+----------------+
	| Field | Type         | Null | Key | Default | Extra          |
	+-------+--------------+------+-----+---------+----------------+
	| id    | int(11)      | NO   | PRI | NULL    | auto_increment |
	| title | varchar(255) | NO   |     | NULL    |                |
	| image | varchar(255) | YES  |     | NULL    |                |
	+-------+--------------+------+-----+---------+----------------+
	3 rows in set (0.00 sec)

	MariaDB [Books]> explain authors_genres_descr;
	+----------------+---------+------+-----+---------+----------------+
	| Field          | Type    | Null | Key | Default | Extra          |
	+----------------+---------+------+-----+---------+----------------+
	| id             | int(11) | NO   | PRI | NULL    | auto_increment |
	| authors_genres | text    | NO   |     | NULL    |                |
	| description    | text    | NO   |     | NULL    |                |
	+----------------+---------+------+-----+---------+----------------+
	3 rows in set (0.00 sec)


	*/

		}
	}

	class DBControl
	{
		public function fetchRes($sql){

			$db  =  new  PDO('mysql:dbname=sql7290753; host=sql7.freemysqlhosting.net; port=3306',"sql7290753","d1waHgPJm2",array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));

			$sth = $db->prepare($sql);
			$sth->execute();
			$res = $sth->fetchAll(PDO::FETCH_ASSOC);

			return $res;
		}
	}

	class ViewControl 
	{

		function __construct() 
		{
	$_POST['book_name'] = isset($_POST['book_name']) ? $_POST['book_name'] : '';
	$sql = "SELECT * FROM `titles_images` WHERE `title` LIKE lower('%".$_POST['book_name']."%') or title LIKE lower('% ".$_POST['book_name']."%') or title LIKE lower('% ".$_POST['book_name']." %')";
				
	$render_static_html = new ViewStatic;
	$render_static_html->render_html();	
	$dbnew = new DBControl;
	$res = $dbnew->fetchRes($sql);
	$render_dymamic_html = new ViewDynamic;
	$render_dymamic_html->render_html($res);

			}

		}
	
	$start = new ViewControl;

?>