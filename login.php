<?php

include_once('db.php');

if ($_SERVER['REQUEST_METHOD'] != "POST"){
	 header("HTTP/1.0 405 Method Not Allowed");
	 exit();
 }
 if ($user)
	 exit (json_encode(array('success' => false, "msg" => "Так ты же уже залогинился.")));
 
 $l = $_POST['l'];
 $p = $_POST['p'];
 if (!preg_match('/^[a-zA-Z0-9|_]+$/',$l))
	
/*CWE-1019, CWE-1005
Описаны длина и возможные символы в логине
Это может привести к подбору логина с помощью перебора(bruteforce)
Возможное решение:
json_encode(array('success' => false, "msg" => "Логин содержит недопустимые символы))
*/

	exit (json_encode(array('success' => false, "msg" => "Логин содержит недопустимые символы. Разрешённые символы: a-z, A-Z, _")));
 if (strlen($login) > 20)
	exit (json_encode(array('success' => false, "msg" => "Длина логина не может превышать 20 символов.")));


 $sql = $db->query("SELECT regdate FROM users WHERE login = '$l'");
 $time = false;
 if ($sql->rowCount() != 0){
	$row = $sql->fetch();
	$time = $row['regdate'];
 }

 /*CWE-307, CWE-799
Некорректно прописано ограничение количества неудачных попыток аутентификации 
Возможен подбор(bruteforce) логина
Проблему можно решить ограничением попыток аутентификации 
*/

 if (!$time)
	exit (json_encode(array('success' => false, "msg" => "Такой пары логин / пароль не существует.")));

 $s1 = 'pq9qhxNEXPYnLyF9QQVc';
 $s2 = 'wfAexZgJNQh04fq6mJd8';
 $pass = hash('sha256', $s1.$p.$time.$s2);
 
 $sql = $db->query("SELECT name FROM users WHERE login = '$l' AND password = '$pass'");
 
 if ($sql->rowCount() != 0){
	$db->exec("UPDATE users SET hash = ".$db->quote($_COOKIE['PHPSESSID'])." WHERE login = '$l'");
	exit (json_encode(array('success' => true)));
 }
	exit (json_encode(array('success' => false, "msg" => "Такой пары логин / пароль не существует.")));
?>