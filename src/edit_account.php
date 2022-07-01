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
	$conn = open_database();
	
	$message ='';
	$username = $_SESSION['username'];
	$eachId = $_SESSION["username"];
	$sql = "select * from user where username = '$username'";
	$result = $conn->query($sql);
	$row = $result->fetch_assoc();
	
	$type = $row['type'];
	$email = $row['email'];
	$check = false;
	
	if(isset($_POST['delete'])){
		$sql = "DELETE FROM user WHERE username='$eachId'";
		$result = $conn->query($sql);
		if($result === true){
			echo "<div class='alert alert-success'>Đã xóa một tài khoản</div>";
			header('Location: thu.php');
		}
	}
	
	 if (isset($_POST['username']) && isset($_POST['type']) && isset($_POST['email'])) {
		$username = $_POST['username'];
		$type = $_POST['type'];
		$email = $_POST['email'];
		
		if ($type==="") {
            $message = "<div class='alert alert-danger'>Nhập kiểu tài khoản</div>";
        }
		else if (!($type==0||$type==1||$type==2)) {
            $message = "<div class='alert alert-danger'>Sai kiểu tài khoản</div>";
        }
		else if (empty($email)) {
            $message = "<div class='alert alert-danger'>Nhập email</div>";
        }
       
        else{
			$result = edit_account($username, $type, $email);
			if ($result['code'] ==0){
				$check = true;
				$message = "<div class='alert alert-success'>Cập nhật thành công</div>";
			}else {
				$error = $result['error'];
				$message = "<div class='alert alert-danger'>$error</div>";
			}
        }
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
	<div class="modal fade" id="confirm-delete">
        <div class="modal-dialog">
          <div class="modal-content">
          
            <div class="modal-header">
              <h4 class="modal-title">Xóa tập tin</h4>
              <button type="button" class="close" data-dismiss="modal"></button>
            </div>

            <div class="modal-body">
              Bạn có chắc rằng muốn xóa lớp học
            </div>
        
            <div class="modal-footer">
				<form method="post">
                <button type="submit" name="delete" class="btn btn-danger">Xóa</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Không</button>
				</form>
            </div>            
            </div>
        </div>
    </div>	
<div class="container">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-5 col-lg-6 col-md-8 border my-3 p-4 rounded mx-5">
			<?php
				if(!$check){
					?>
                <form method="post" action="" novalidate>
					<h3 class="text-center text-secondary mt-1 mb-2">Sửa tài khoản</h3>
					<div class="form-group">
                        <label for="pass">Tên đăng nhập</label>
                        <input readonly name="username" required class="form-control" value = "<?= $username ?>" type="text" placeholder="Username" id="username">
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input name="email" required class="form-control" value = "<?= $email ?>" type="email" placeholder="Email" id="email">
                    </div>
					<div class="form-group">
                        <label for="type">Kiểu tài khoản</label>
                        <input name="type" required class="form-control" value = "<?= $type ?>" type="type" placeholder="Kiểu tài khoản" id="type">
                    </div>
                    <div class="form-group mt-4 mr-4">
						<?php
                            if (!empty($message)) {
                                echo "$message";
                            }
                        ?>
                        <button class="btn btn-success float-right">Xác nhận</button>
						<p><a href="login.php">Quay lại</a></p>
                    </div>
                </form>
				<button class=" btn-sm btn btn-danger" data-toggle="modal" data-target="#confirm-delete">Xóa tài khoản</button>
				<?php
				}else{
			?>
				<form method="post" action="" novalidate>
					<h3 class="text-center text-secondary mt-1 mb-2">Tạo tài khoản</h3>
					<div class="form-group">
                        <label for="pass">Tên đăng nhập</label>
                        <input name="username" required class="form-control" value = "<?= $username ?>" type="text" placeholder="Username" id="username">
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input name="email" required class="form-control" value = "<?= $email ?>" type="email" placeholder="Email" id="email">
                    </div>
					<div class="form-group">
                        <label for="type">Kiểu tài khoản</label>
                        <input name="type" required class="form-control" value = "<?= $type ?>" type="type" placeholder="Kiểu tài khoản" id="type">
                    </div>
                    <div class="form-group mt-4 mr-4">
						<?php
                            if (!empty($message)) {
                                echo "$message";
                            }
                        ?>
                        <button class="btn btn-success float-right">Xác nhận</button>
						<p><a href="login.php">Quay lại</a></p>
                    </div>
                </form>
				<button class=" btn-sm btn btn-danger" data-toggle="modal" data-target="#confirm-delete">Xóa tài khoản</button>
				<?php
				}
				?>
				
            </div>
        </div>

    </div>
</body>
</html>

</body>
</html>


