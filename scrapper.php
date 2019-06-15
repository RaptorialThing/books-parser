<?php /*
echo 'Scrapper was started. When new results will inserted to database you will see it 
<script>f = function() {document.location.href="main.php";}; setTimeout(function() {f();},5000); </script>
';*/
class Scrapper
	{

			/* createDB */
			function __construct() {
			$url = "https://www.litmir.me/bs";
			$ch = curl_init();
			curl_setopt($ch,CURLOPT_URL,$url);
			curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
			$returned = curl_exec($ch);
			curl_close($ch);

			$db  =  new  PDO('mysql:dbname=sql7290753; host=localhost;',"ruzal","Hepfkm2016",
	        array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));

	  		$sql = "
					DROP TABLE titles_images_descriptions ;

					CREATE database IF NOT EXISTS `sql7290753`;

					use `sql7290753`;

					CREATE TABLE IF NOT EXISTS `titles_images_descriptions` ( `id` int(11) NOT NULL AUTO_INCREMENT,  `title` TEXT  NOT NULL, `image` varchar(255) NOT NULL,  `description` TEXT NOT NULL,  PRIMARY KEY (`id`) ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
					
					alter table titles_images_descriptions add fulltext (description);
					alter table titles_images_descriptions add fulltext (title);

					";

					$sth=$db->prepare($sql);
	  				$sth->execute();
			

			/* ScrapWriteDB */

					$dom = new DOMDocument();
					@$dom->loadHTML($returned);
					$xpath = new DOMXPath($dom);

					$query = './/img[contains(@class,"lt32 lazy")]'; 
					$query2 = './/div[contains(@class,"item_description")]/div/div/div/div[contains(@class,"BBHtmlCodeInne")]';

					$entries = $xpath->query($query);
					$entries2 = $xpath->query($query2);  

					$titles_images_descriptions = array();

					$book=0;
					foreach ($entries as $entry) {
						# img->attributes->NamedMap (item(6) - src)
						/*$attr = $entry->attributes; 
						$under_attr = $attr->item(6);
						
						$images[] = $under_attr->textContent;
						$image = $under_attr->textContent;

						$name = $entry->getAttribute('alt');

						$names[] = $name;

					  	$description = $entry->textContent;

					  	$descriptions[] = $entry->textContent;

				*/		$titles_images_descriptions['book'.$book] = array();
						$title = $entry->getAttribute('alt');
						$titles_images_descriptions['book'.$book]['title'] = $title;
						$src = $entry->getAttribute('data-src');
						$titles_images_descriptions['book'.$book]['image'] = $src;
						$book = $book+1;
					}

					function DOMinnerHTML(DOMNode $element) {
						$innerHTML = "";
						$children = $element->childNodes;
						foreach ($children as $child) {
							$innerHTML .= $element->ownerDocument->saveHTML($child);
						}
						return $innerHTML;
					}
					$book=0;
					foreach ($entries2 as $entry2) {
						$desc = DOMinnerHTML($entry2);
						$titles_images_descriptions['book'.$book]['description'] = $desc;
						$book = $book+1;
					}
					//var_dump($titles_images_descriptions);
					

						try {
							foreach ($titles_images_descriptions as $book) {

							$db  =  new  PDO('mysql:dbname=sql7290753; host=localhost;',"ruzal","Hepfkm2016",
							        array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));

						    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
							$stmt = $db->prepare("INSERT INTO titles_images_descriptions (title,image,description) VALUES (:title,:image,:description)");
							$stmt->bindParam(':title',$title);
							$stmt->bindParam(':image',$image);
							$stmt->bindParam(':description',$description);

							$title = $book['title'];
							$image = $book['image'];
							$description = $book['description'];

							$stmt->execute();
						}
							
						}

						catch(PDOException $e) {
							echo "Error:".$e->getMessage();
						}

						$db = null;

					}
	}

	$parser = new Scrapper();
?>