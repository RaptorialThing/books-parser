<?php
abstract class View
	{
	/*public function render_html(){} */
	}

class ViewStatic extends View
	{
		public function render_html()
		{
			$smarty = new Smarty();
			$smarty->setTemplateDir('/var/www/books.site/books/smarty/templates');
			$smarty->setCompileDir('/var/www/books.site/books/smarty/templates_c');
			$smarty->setCacheDir('/var/www/books.site/books/smarty/cache');
			$smarty->setConfigDir('/var/www/books.site/books/smarty/configs'); 
			$smarty->display('index.tpl');
		}
	}

	class ViewDynamic extends View 
	{
		public function render_html($find)
		{		
				if ($find == 'all') {
				$sql = "SELECT `title`,`image`,`description` FROM `titles_images_descriptions`";
				}
				else{
				$sql = "SELECT `title`,`image`,`description` FROM `titles_images_descriptions` WHERE MATCH (description) AGAINST ('".$find."') or match(title) against ('".$find."');";
				}
				$search = new DBSearch;	
				$res = $search->fetchRes($sql); 

				$smarty = new Smarty();
				$smarty->setTemplateDir('/var/www/books.site/books/smarty/templates');
				$smarty->setCompileDir('/var/www/books.site/books/smarty/templates_c');
				$smarty->setCacheDir('/var/www/books.site/books/smarty/cache');
				$smarty->setConfigDir('/var/www/books.site/books/smarty/configs');
				$smarty->assign('res',$res);
				$smarty->display('books_dynamic.tpl');
		}
	}


?>