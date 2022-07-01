<?php
	session_start();
    if (!isset($_SESSION['user'])) {
        header('Location: login.php');
        exit();
    }
	require_once('database.php');
?>
<DOCTYPE html>
<html lang="en">
<head>
    <title>Tạo lớp</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Lớp học</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
</head>
</head>
<body>
<?php
	
	$message ='';
	$classId = $_SESSION['classId'];
	$conn = open_database();
	$eachId = $_SESSION["classId"];
	$sql = "select * from class where classId = '$eachId'";
	$result = $conn->query($sql);
	$row = $result->fetch_assoc();
	
	$className = $row['className'];
	$courseName = $row['courseName'];
	$creator = $row['creatorname'];
	$room = $row['room'];
	$picture = '';
	$check = false;
	
	
	 if (isset($_POST['classname']) && isset($_POST['Ncouser']) && isset($_POST['room'])) {
		$className = $_POST['classname'];
		$picture = $_POST['picture'];
		$courseName = $_POST['Ncouser'];
		$room = $_POST['room'];
		$name = $_SESSION['name'];
		
		if (empty($className)) {
            $message = "<div class='alert alert-danger'>Nhập tên lớp học</div>";
        }
		else if (empty($courseName)) {
            $message = "<div class='alert alert-danger'>Nhập tên môn học</div>";
        }
		else if (empty($room)) {
            $message = "<div class='alert alert-danger'>Nhập phòng học</div>";
        }
        // else if (empty($picture)) {
            // $message = 'Chọn ảnh lớp học';
        // }
        else{
			$result = edit_class($classId, $className, $creator, $courseName, $room);
			if ($result['code'] ==0){
				$check = true;
				$message = "<div class='alert alert-success'>Cập nhật thành công</div>";
				// header('Location: index.php');
				// exit();
			}else {
				$error = $result['error'];
				$message = "<div class='alert alert-danger'>$error</div>";
			}
        }
	 }

?>
	<nav class="navbar navbar-expand-sm bg-light">
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
					if($_SESSION['type']==1){
						?>
						<a class="dropdown-item" href="create_class.php">Tạo lớp</a>
						<?php
					}
				?>
				<a class="dropdown-item" href="#">Tham gia lớp</a>
				<a class="dropdown-item" href="active.php">Cập nhật tài khoản</a>
				<a class="dropdown-item" href="logout.php">Đăng xuất</a>
			  </div>
			</li>
		  </ul>
		</form>
	  </div>
	</nav>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5 mt-3">
            <form method="post" action="" class="border rounded w-100 mb-5 mx-auto px-3 pt-3">
				 <h3 class="text-center mt-3 mb-3">Sửa lớp</h3>
                <div class="form-group">
                    <label for="email">Người tạo</label>
                    <input readonly name="creator" value='<?= $creator ?>' id="creator" type="text" class="form-control">
                </div>
				<div class="form-group">
                    <label for="email">Tên lớp</label>
                    <input 
					<?php
						if($check){
							?>
							readonly
						<?php
						}
					?>
					name="classname" id="classname" value = "<?= $className ?>" type="text" class="form-control" placeholder="Class Name">
                </div>
				<div class="form-group">
                    <label for="Ncouser">Tên môn học</label>
                    <input 
					<?php
						if($check){
							?>
							readonly
						<?php
						}
					?>
					name="Ncouser" id="Ncouser" value = "<?= $courseName ?>" type="text" class="form-control" placeholder="Course name">
                </div>
				<div class="form-group">
                    <label for="room">Phòng học</label>
                    <input 
					<?php
						if($check){
							?>
							readonly
						<?php
						}
					?>
					name="room" id="room" value = "<?= $room ?>" type="text" class="form-control" placeholder="Classroom">
                </div>
				<div class="form-group">
                    <label for="email">Ảnh lớp: </label><br>
                    <input name="picture" value = "<?= $picture ?>" id="picture" type="file">
                </div>
                <div class="form-group text-center">
                    <?php
                        if (!empty($message)) {
                            echo "$message";
                        }
                    ?>
                </div>
                
				<?php
					if($check){
					?>
						<div class="form-group mb-4">
							<a href="index.php">Quay lại</a>
						</div>
					<?php
					}else{
					?>
						<div class="form-group mb-4">
							<button class="btn btn-success px-4">Lưu thay đổi</button>
						</div>
					<?php
					}
				?>
                
				
            </form>

        </div>
    </div>
</div>
</body>
</html>

</body>
</html>


