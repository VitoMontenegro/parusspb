<?php
require($_SERVER['DOCUMENT_ROOT'].'/wp-load.php');
$recepient = 'testdev@kometatek.ru';
$sender = 'vitaliy060282@gmail.com';
$sitename = "Group.spb";
$name = trim($_POST["name"]);
$email = trim($_POST["email"]);
$text = trim($_POST["message"]);


$excurs = isset($_POST["excurs"]) ? wp_strip_all_tags($_POST["excurs"]) : '';
$rating = isset($_POST["rating"]) ? (int)$_POST["rating"] : '';
;



$message = "Дата: " . $name . "<br/><br/>\r\n";
$message = "Имя: " .  $name . "<br/><br/>\r\n";
$message .= "Экскурсия: " .  $excurs . "<br/><br/>";
$message .= "Рейтинг: " .  $rating . "<br/><br/>";
$message .= "Телефон или Email: " .  $email . "<br/><br/>";
$message .= "Cообщение: " .  $text . "<br/><br/>";
$pagetitle = "Новый отзыв с сайта \"$sitename\"";

$post_data = array(
	'post_title'    => wp_strip_all_tags($name),
	'post_content'  => wp_strip_all_tags($text),
	'post_status'   => 'pending',
	'post_author'   => 1,
	'post_type' => 'reviews',
);
$post_id = wp_insert_post( $post_data );


if ($_FILES['file']){
	$files = array_map('RemapFilesArray',
		$_FILES['file']['name'],
		$_FILES['file']['type'],
		$_FILES['file']['tmp_name'],
		$_FILES['file']['error'],
		$_FILES['file']['size']
	);

	$gallery=array();

	foreach ($files as $file){ //loop through each file
		$att = my_update_attachment($file,$post_id);
		array_push($gallery,$att['attach_id']);
	}
	update_field('field_5fad894783054',$gallery,$post_id);
	update_field('field_5fad895583055',$excurs,$post_id);
	update_field('field_5fad897183057',$rating,$post_id);
	update_field('field_612cc6d2ad914',$email,$post_id);

}

$message .= "Дата:  " . date('d/m/Y') . "<br/><br/>";
$message .= "Ссылка на отзыв : https://groupspb.ru/wp-admin/post.php?post=" . $post_id . "&action=edit<br/><br/>";

//mail($recepient, $pagetitle, $message, "Content-type: text/html; charset=\"utf-8\"\r\n From: admin@parus-peterburg.ru\r\n".'X-Mailer: PHP/' . phpversion());
//mail('world.julia1@gmail.com', $pagetitle, $message, "Content-type: text/html; charset=\"utf-8\"\r\n From: admin@parus-peterburg.ru\r\n".'X-Mailer: PHP/' . phpversion());


//mail('info@parus-peterburg.ru', 'Новый отзыв с сайта parus-peterburg.ru', $message, "Content-type: text/html; charset=\"utf-8\"\r\n From: admin@parus-peterburg.ru\r\n".'X-Mailer: PHP/' . phpversion());
//mail('world.julia1@gmail.com', 'Новый отзыв с сайта parus-peterburg.ru', $message, "Content-type: text/html; charset=\"utf-8\"\r\n From: admin@parus-peterburg.ru\r\n".'X-Mailer: PHP/' . phpversion());
