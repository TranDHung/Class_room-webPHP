<?php
    session_start();
    if (!isset($_SESSION['user'])) {
        header('Location: login.php');
        exit();
    }
	require_once('database.php');
	
	$root = "./admin";
      if(!file_exists($root)){
        mkdir($root);
    }
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
			$name = $_SESSION['name'];
			$conn = open_database();
			$sql = "select * from class where creatorname = '$name'";
			$result = $conn->query($sql);
			$arrId = array();
			$arry = array();
			$i = 0;
			if($_SESSION['type']==1 || $_SESSION['type']==0){
				if ($result->num_rows > 0) {
				  while($row = $result->fetch_assoc()) {
						$classId = $row['classId'];
						$pathpicture = $root."/".$row['picture'];
						$arry[$i] = $i+1;
						$arrId[$i+1] = $classId;
						$amnt = $arry[$i];
						$i++;
						$count = 0;
						$sql = "select * from user";
						$result1 = $conn->query($sql);
						if ($result1->num_rows > 0) {
							while($data = $result1->fetch_assoc()){
								$arr = explode(",",$data['class']);
								$x = 0;
							  while($x<count($arr)) {
								if($classId === $arr[$x]){
									$count++;
								}
								$x++;
							  }
						  }
						}
				if(isset($_POST['card'])){
					$card = $_POST['card'];
					$_SESSION["classId"] = $arrId[$card];
					header('Location: class_index.php');
				}
				
		?>
			<div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 col-12">
			<form method="post" action="">
				<button class="btn" name ="card" value = "<?= $amnt ?>">
				<div class="card" >
					<img class="card-img-top" src="<?= $pathpicture ?>" height="70px">
					<div class="card-img-overlay">
						<span class="card-text1"><a class = "text-light"><?= $row["className"] ?></a></span>
						<span class="card-text2 text-light" >GV: <?= $row["creatorname"] ?></span>
						<span class="card-text3 text-light" ><?= $count ?> students</span>
						
					</div>
					<div class="card-body1" style="padding-top: 110px; outline-color: grey"></div>
					<div class="card-body2" ></div>
				</div>
				</button>
			</form>
			</div>
		<?php
				}
			}
		}
			
			$name = $_SESSION['name'];
			$conn = open_database();
			$sql = "select class from user where fullname = '$name'";
			$result = $conn->query($sql);
			$data = $result->fetch_assoc();
			$arr = explode(",",$data['class']);
			$sql = "SELECT * FROM class";
			$result = $conn->query($sql);
			if ($result->num_rows > 0) {
				while($row = $result->fetch_assoc()){
					$x = 0;
				  while($x<count($arr)) {
					if($row["classId"] === $arr[$x]){
						$classId = $row["classId"];
						$pathpicture = $root."/".$row['picture'];
						$arry[$i] = $i+1;
						$arrId[$i+1] = $classId;
						$amnt = $arry[$i];
						$i++;
						$count = 0;
						$sql1 = "select * from user";
						$result1 = $conn->query($sql1);
						if ($result1->num_rows > 0) {
							while($data1 = $result1->fetch_assoc()){
								$arr1 = explode(",",$data1['class']);
								$x1 = 0;
							  while($x1<count($arr1)) {
								if($classId === $arr1[$x1]){
									$count++;
								}
								$x1++;
							  }
							if(isset($_POST['card'])){
								$card = $_POST['card'];
								$_SESSION["classId"] = $arrId[$card];
								header('Location: class_index.php');
							}
						  }
						}
						 ?>
							<div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 col-12">
							<form method="post" action="">
							<button class="btn" name ="card" value = "<?= $amnt ?>">
								<div class="card" >
									<img class="card-img-top" src="<?= $pathpicture ?>" height="70px">
									<div class="card-img-overlay">

										<span class="card-text1"><a class = "text-light"><?= $row["className"] ?></a></span>
										<span class="card-text2 text-light">GV: <?= $row["creatorname"] ?></span>
										<span class="card-text3 text-light"><?= $count ?> students</span>
										
									</div>
									<div class="card-body1" style="padding-top: 110px; outline-color: grey"></div>
									<div class="card-body2" ></div>
								</div>
							</button>
							</form>
							</div>
						<?php
					}
					 $x++;
				  }
				}
			}
		$conn->close();
		?>
	</div>
</div>
</body>

</html>