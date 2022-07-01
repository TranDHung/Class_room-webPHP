<?php
	session_start();
    if (!isset($_SESSION['email'])) {
        header('Location: login.php');
        exit();
    }
	require_once('database.php');
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Tham gia lớp học</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  </head>
  <body>
  <?php
	$classId = '';
	$check = false;
	$error = '';
	$message = '';
	
	if (isset($_POST['classId'])) {
		$classId = $_POST['classId'];
		$email = $_SESSION['email'];
		$name = $_SESSION['name'];
		if (empty($classId)) {
            $message = "<div class='alert alert-danger'>Nhập mã lớp học</div>";
        }
        else{
			if(check_class_of_user($classId,$email)){
				$message = "<div class='alert alert-danger'>Bạn đã tham gia lớp học này</div>";
			}else{
				$check = true;
				$result=find_Creator($classId, $email, $name);
				if($result['code'] === 1)
					$message = "<div class='alert alert-danger'>Mã lớp không tồn tại</div>";
				else
					$message = "<div class='alert alert-success'>Đã gửi yêu cầu</div>";
				
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
	
	<div class="row justify-content-center">
        <div class="col-lg-4">
            <h3 class="text-center mt-5 mb-3">Tham gia lớp</h3>
            <form method="post" action="" class="border rounded w-100 mb-5 mx-auto px-3 pt-3">
				<div class="form-group">
                    <label for="classId">Mã lớp</label>
                    <input <?php
						if($check){
							?>
							readonly
						<?php
						}
					?> name="classId" value = "<?= $classId ?>" id="classId" type="text" class="form-control">
                </div>
				<div class="form-group">
                    <?php
						echo "$message";
					?>
                </div>
				<?php
					if(!$check){
					?>
					<div class="form-group text-right">
						<button class="btn btn-success px-5">Gửi yêu cầu</button>
					</div>
					<?php
					}else{
					?>
					<div class="form-group">
						<a href="index.php">Quay lại</a>
					</div>	
					<?php
					}
				?>
					
			</form>
        </div>
    </div>
  </body>
</html>