<?php
require("includes/config.inc.php");
require("templates/init.tpl.php"); // Подключаем файл с классом

$template = new template;
$template->set_tpl('templates/index.tpl.html'); //Файл который мы будем парсить
$template->set_vars('PAGE_TITLE','sc.ru');
$template->set_vars('COPYRIGHT','sc.ru &copy; 2014');
//$content = $template->get_file("pages/home.html", true);
$menu = $template->get_file("parts/menu.html");
$slider = $template->get_file("parts/slider.html");
$hello = $template->get_file("parts/hello.html");
$s_hello = $template->get_file("parts/prices_blocks.html");
$template->set_vars('MENU',$menu);
$template->set_vars('SLIDER',$slider,'home');
$template->set_vars('HELLO',$s_hello,'services');
$template->set_vars('HELLO',$hello,'home');

//print_r($template->files);
$template->tpl_parse(); //Парсим
eval (' ?' . '>' . $template->template . '<' . '?php ');

?>