<?php

// ViewControl is  here
	require_once('classes/classes.php');


	if (isset($_POST['book_name'])) {
		// var_dump($_POST);
		// var_dump($books);
		$find = empty($_POST['book_name']) ? 'all' : $_POST['book_name'];
		$render_dynamic_html = new ViewDynamic;
		$render_dynamic_html->render_html($find);
	}
	else {
		$render_static_html = new ViewStatic;
		$render_static_html->render_html();

	}

?>