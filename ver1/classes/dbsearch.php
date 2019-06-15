<?php
	class DBSearch
	{
		public function fetchRes($sql){

			$db  =  new  PDO('mysql:dbname=Books; host=localhost;',"ruzal","Hepfkm2016",array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));

			$sth = $db->prepare($sql);
			$sth->execute();
			$res = $sth->fetchAll(PDO::FETCH_ASSOC);

			return $res;
		}
	}
?>