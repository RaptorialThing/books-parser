<?php
// ViewControl is  here
	require_once('classes/classes.php');



	if (isset($_POST['book_name'])) {
		$sql = "SELECT * FROM `titles_images` WHERE `title` LIKE lower('%".$_POST['book_name']."%') or `description` LIKE lower('% ".$_POST['book_name']." %')";
		$search = new DBSearch;	
		$books = $search->fetchRes($sql);
		//$v = var_dump($_POST);
		//$f = var_dump($books);
		//echo $v;
		//echo $f;
		$render_dynamic_html = new ViewDynamic;
		$render_dynamic_html->render_html($books);

	}
	else {
		$render_static_html = new ViewStatic;
		$render_static_html->render_html();
	}

	
	
	

?>
