<?php
	class DBSearch
	{
		public function fetchRes($sql){

			$db  =  new  PDO('mysql:dbname=sql7290753; host=sql7.freemysqlhosting.net; port=3306',"sql7290753","d1waHgPJm2",array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));

			$sth = $db->prepare($sql);
			$sth->execute();
			$res = $sth->fetchAll(PDO::FETCH_ASSOC);

			return $res;
		}
	}
?>