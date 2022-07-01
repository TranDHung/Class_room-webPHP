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
	
	$check = false;
	$studentE = '';
	$message ='';
	if(isset($_POST['studentE'])){
		$studentE = $_POST['studentE'];
		$nameCre = $_SESSION['creator'];
		$classId = $_SESSION['classId'];
		if(empty($studentE)){
			$message = "<div class='alert alert-danger'>Nhập email học viên</div>";
		}else{
			add_student($studentE,$classId,$nameCre);
			$message = "<div class='alert alert-success'>Đã gửi lời mời</div>";
			$check=true;
		}
	}
	
	
?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5 mt-3">
            <form method="post" action="" class="border rounded w-100 mb-5 mx-auto px-3 pt-3" enctype="multipart/form-data">
				 <h3 class="text-center mt-3 mb-3">Thêm học viên</h3>
				<div class="form-group">
                    <label for="email">Email học viên (mỗi email viết trên một dòng)</label>
                    <textarea name="studentE" id="studentE" value = "<?= $studentE ?>" oninput="auto_grow(this)" class="form-control textarea"></textarea>
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
							<a href="login.php">Quay lại</a>
						</div>
					<?php
					}else{
					?>
						<div class="form-group mb-4">
							<button class="btn btn-success px-4" name="submit" type="submit">Thêm</button>
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


