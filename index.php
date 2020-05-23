<?php
 include_once('db.php');
 session_start();
 session_destroy();
?>


<html>
	<head>
		<title>Крутой заголовок</title>
		<script src="/js/jQuery.js"></script>
		<script src="/js/jquery.dataTables.min.js"></script>
		<script src="/js/bootstrap.min.js"></script>
		<script src="/js/expanding.js"></script>
		<script src="/js/dataTables.bootstrap.js"></script>
		<script src="/js/brackets.min.js"></script>
		<script src="/js/all.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.js"></script>
		<script src="/js/main.js?v=<?=time()?>"></script>
		<link rel="stylesheet" type="text/css" href="/css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="/css/all.min.css">
		<link rel="stylesheet" type="text/css" href="/css/main.css?v=<?=time()?>">
		<link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">
		<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.css" rel="stylesheet">
		<meta charset="utf-8">
	</head>
	<body>
		<?php
			include_once('TopMenu.php');
		?>
		<div class = "col-12">
			<?php include_once('modals.php'); ?>
			<div class = "container text-center" id = "main">

<!--CWE-242 Программа вызывает функцию, которая никогда не сможет работать безопасно. 
В данном случае функция include использует в качестве параметра данные, не проверенные доплнительно 
Выявить можно по сообщению об ошибке типа "failed opening required"
На выходе можно получить содержимое файла password сервера  
-->
				<?php if (isset($_POST['id'])) include('Tournament.php'); else include('TournList.php'); ?>
			</div>
		</div>
	</body>
</html>