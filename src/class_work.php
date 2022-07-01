<?php
    session_start();
    if (!isset($_SESSION['user'])) {
        header('Location: login.php');
        exit();
    }
	require_once('database.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Lớp học</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
</head>
</head>
<body>
	<nav class="navbar navbar-expand-sm bg-light">
	  <a href="index.php" class="navbar-brand"><img src="home_icon.jpg" class="float-left" width="35px" height="35px"></a>
	  <a class="navbar-brand" href="class_index.php"><?= $_SESSION['className'] ?></a>
	  <button class="navbar-toggler navbar-toggler-right collapsed" type="button" data-toggle="collapse" data-target="#navb" aria-expanded="false">
		<span class="navbar-toggler-icon"></span>
	  </button>

		<div class="navbar-collapse collapse" id="navb" style="">
		<ul class="nav nav-tabs nav-justified mx-auto">
			<li class="nav-item">
			  <a class="nav-link" href="class_index.php">Stream</a>
			</li>
			<li class="nav-item">
			  <a class="nav-link active" href="class_work.php">Classwork</a>
			</li>
			<li class="nav-item">
			  <a class="nav-link" href="class_member.php">People</a>
			</li>
		</ul>
		<form class="form-inline my-2 my-lg-0">
			<td class="text-right">
              <span class = "text-danger"></span>
            </td>
		</form>
	  </div>
	</nav>
	
<div class="container col-lg-7">
	
</div>
</div>
</body>
</html>
