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
  <script src="main.js"></script>
</head>
</head>
</head>
<body>
	<?php
		if(isset($_POST['card'])){
			$username = $_POST['card'];
			$conn = open_database();
			$sql = "select * from user where username = '$username'";
			$result = $conn->query($sql);
			$row = $result->fetch_assoc();
			$_SESSION["username"] = $row['username'];
			header('Location: edit_account.php');
			exit();
		}
	?>
	<nav class="navbar navbar-expand-sm bg-light">
	  <a href="index.php" class="navbar-brand"><img src="./image/home_icon.jpg" class="float-left" width="35px" height="35px"></a>
	  <a class="navbar-brand" href="index.php"><h3>Lớp học</h3></a>
	  <button class="navbar-toggler navbar-toggler-right collapsed" type="button" data-toggle="collapse" data-target="#navb" aria-expanded="false">
		<span class="navbar-toggler-icon"></span>
	  </button>

	  <div class="navbar-collapse collapse" id="navb" style="">
		
		<form class="form-inline my-2 my-lg-0 ml-auto">
			<td class="text-right">
              <span class = "text-danger"><?= $_SESSION['name'] ?></span>
            </td>
		  <ul class="nav">
			<li class="nav-item dropdown">
			  <a class="nav-link dropdown-toggler" href="#" data-toggle="dropdown">Tùy chọn</a>
			  <div class="dropdown-menu dropdown-menu-right">
				<?php
					if($_SESSION['type']==1 || $_SESSION['type']==0){
						?>
						<a class="dropdown-item" href="create_class.php">Tạo lớp</a>
						<?php
					}
				?>
				
				<a class="dropdown-item" href="add_class.php">Tham gia lớp</a>
				<?php
					if($_SESSION['type']==2){
						?>
						<a class="dropdown-item" href="active.php">Cập nhật tài khoản</a>
						<?php
					}
					if($_SESSION['type']!=0){
						?>
						<a class="dropdown-item" href="active_admin.php">Xét làm admin</a>
						<?php
					}
					if($_SESSION['type']==0){
						?>
						<a class="dropdown-item" href="class_manager.php">Quản lý lớp học</a>
						<?php
					}
					if($_SESSION['type']==0){
						?>
						<a class="dropdown-item" href="account_manager.php">Quản lý tài khoản</a>
						<?php
					}
				?>
				<a class="dropdown-item" href="logout.php">Đăng xuất</a>
			  </div>
			</li>
		  </ul>
		</form>
	  </div>
	</nav>
<div class="container mt-4">
    <div class="row">
		<?php
			$conn = open_database();
			$sql = "select * from user";
			$result = $conn->query($sql);
			if($_SESSION['type']==0){
				while($row = $result->fetch_assoc()){
					$type = "Học sinh";
					if($row["type"]==0){
						$type = "Admin";
					}
					if($row["type"]==1){
						$type = "Giảng viên";
					}
		?>
			<div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 col-12">
			<form method="post" action="">
				<button class="btn" name ="card" value = "<?= $row["username"] ?>">
				<div class="account bg-secondary px-5 py-4">
					<div class="">
						<div class=""><a class = "text-light"><?= $row["username"] ?></a></div>
						<div class="" ><?= $type ?></div>
					</div>
				</div>
				</button>
			</form>
			</div>
		<?php
				}
			}
		$conn->close();
		?>
	</div>
</div>
</body>

</html>