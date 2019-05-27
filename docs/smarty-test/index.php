<?php

// put full path to Smarty.class.php
require('/usr/local/lib/php/Smarty/Smarty.class.php');
$smarty = new Smarty();

$smarty->setTemplateDir('/var/www/books.site/books/smarty/templates');
$smarty->setCompileDir('/var/www/books.site/books/smarty/templates_c');
$smarty->setCacheDir('/var/www/books.site/books/smarty/cache');
$smarty->setConfigDir('/var/www/books.site/books/smarty/configs');



$db  =  new  PDO('mysql:dbname=sql7290753; host=sql7.freemysqlhosting.net; port=3306',"sql7290753","d1waHgPJm2",
	        array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));

$sql = 'SELECT * FROM `titles_images`';
$sth = $db->prepare($sql);
$sth->execute();
$res = $sth->fetchAll(PDO::FETCH_ASSOC);


$smarty->assign('res',$res);

$smarty->display('index.tpl');
$smarty->display('books_dynamic.tpl');

?>