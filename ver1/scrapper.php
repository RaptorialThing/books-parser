<?php
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

	     

	$db  =  new  PDO('mysql:dbname=Books; host=localhost;',"ruzal","Hepfkm2016",
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
?>