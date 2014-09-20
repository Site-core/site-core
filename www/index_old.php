<?php
include ("templates/variables.php");

// Включить класс шаблона
require ("templates/init.tpl.php");

// Создать новый экземпляр класса
$template = new template;

$tpl = "index"; // название экземпляра
// Регистрация файлов
$template->set_content();
$template->register_file($tpl, "templates/index.tpl.html");

$template->set_menu('parts/menu.html');

// Присвоить значения переменным
$page_title = "site-core";

// Регистрация переменных
$template->register_variables($tpl, "page_title,user_name,content,copyright,hello,menu,slider");

$template->file_parser($tpl);
// Вывод готовой страницы
print $template->get_file($tpl);
?>