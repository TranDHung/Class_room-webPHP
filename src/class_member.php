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
<?php
	if(isset($_POST['delete'])){
		$classId = $_SESSION['classId'];
		$conn = open_database();
		$userN = $_POST['delete'];
		$sql ="select class from user where username = '$userN'";
		$result = $conn->query($sql);
		$row = $result->fetch_assoc();
		
		$arr = explode(",",$row['class']);
		$x = 0;
		while($x<count($arr)) {
			if($classId === $arr[$x]){
				array_splice($arr,$x,1);
			}
			$x++;
		}
		$str = implode(",",$arr);
		$sql ="update user set class = '$str' where username = '$userN'";
		$result = $conn->query($sql);
	}
?>
	<nav class="navbar navbar-expand-sm bg-light">
	  <a href="index.php" class="navbar-brand"><img src="./image/home_icon.jpg" class="float-left" width="35px" height="35px"></a>
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
			  <a class="nav-link" href="class_work.php">Classwork</a>
			</li>
			<li class="nav-item">
			  <a class="nav-link active" href="class_member.php">People</a>
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
	<div class="mb-5 mt-5">
    <table class="table">
		<thead class="table-borderless">
		  <tr>
			<th><h2>Teachers</h2></th>
		  </tr>
		</thead>
		<tbody>
		  <tr>
			<td><?= $_SESSION['creator'] ?></td>
		  </tr>
		</tbody>
    </table>
	</div>
	<?php
		$count = 0;
		$classId = $_SESSION['classId'];
		$conn = open_database();
		$sql = "select * from user";
		$result = $conn->query($sql);
		//$data = $result->fetch_assoc();
		
		if ($result->num_rows > 0) {
			// $arr = explode(",",$data['class']);
			// $x = 0;
			while($row = $result->fetch_assoc()){
				$arr = explode(",",$row['class']);
				$x = 0;
			  while($x<count($arr)) {
				if($classId === $arr[$x]){
					$count++;
				}
				$x++;
			  }
		  }
		}
	?>
	<div class="mb-5 ">
	<table class="table">
		<thead class="table-borderless">
		  <tr>
			<th><h2>Classmates</h2></th>
			<?php
				if($_SESSION['type'] ==2){
					?>
					<th class="text-right"><?= $count ?> students</th>
					<?php
				}else{
					?>
					<th class="text-right"><a href="add_student.php" ><img src="./image/add_mem.jpg" width="35px" height="35px"></a></th>
					<?php
				}
			?>
		  </tr>
		</thead>
		<tbody>
		<?php
			$classId = $_SESSION['classId'];
			$conn = open_database();
			$sql = "select * from user";
			$result = $conn->query($sql);
			if ($result->num_rows > 0) {
				// $arr = explode(",",$data['class']);
				// $x = 0;
				while($row = $result->fetch_assoc()){
					$arr = explode(",",$row['class']);
					$x = 0;
					$student = $row['fullname'];
				  while($x<count($arr)) {
					if($classId === $arr[$x]){
						?>
						<tr>
							<td><?= $student ?></td>
							<?php
								if(($_SESSION['type'] ===1 && $_SESSION['name']===$_SESSION['creator']) || $_SESSION['type']===0 ){
								?>
								<td class="text-right"><form method="post"><button class="btn btn-sm btn-danger" value="<?= $row['username'] ?>" name="delete">Xóa</button></form>
								<?php
								}
							?>
								
						</tr>
						<?php
					}
					$x++;
				  }
			  }
			}
		?>
		</tbody>
    </table>
	</div>
</div>
</body>
</html>
