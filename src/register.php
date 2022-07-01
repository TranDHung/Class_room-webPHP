<?php
	session_start();
    if (isset($_SESSION['user'])) {
        header('Location: login.php');
        exit();
    }
	require_once('database.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Tạo tài khoản</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
</head>

<?php
    $error = '';
	$success = '';
	$user = '';
	$bdate = '';
    $full_name = '';
	$phoneN = '';
    $email = '';
    $pass = '';
    $pass_confirm = '';
	$check = false;

    if (isset($_POST['username']) && isset($_POST['birthd']) &&  isset($_POST['name']) && isset($_POST['email']) && isset($_POST['pass'])
    && isset($_POST['pass-confirm']) && isset($_POST['phoneN']))
    {
		$user = $_POST['username'];
		$bdate = $_POST['birthd'];
		$phoneN = $_POST['phoneN'];
        $full_name = $_POST['name'];
        $email = $_POST['email'];
        $pass = $_POST['pass'];
        $pass_confirm = $_POST['pass-confirm'];
		$type = 2;
		
		if (empty($phoneN)) {
            $error = 'Nhập số điện thoại';
        }
		else if (empty($user)) {
            $error = 'Nhập tên đăng nhập';
        }
		else if (empty($bdate)) {
            $error = 'Nhập ngày sinh';
        }
        else if (empty($full_name)) {
            $error = 'Nhập tên đầy đủ';
        }
        else if (empty($email)) {
            $error = 'Nhập địa chỉ email';
        }
        else if (filter_var($email, FILTER_VALIDATE_EMAIL) == false) {
            $error = 'Không phải địa chỉ email';
        }
        else if (empty($pass)) {
            $error = 'Nhập mật khẩu';
        }
        else if (strlen($pass) < 6) {
            $error = 'Mật khẩu phải nhiều hơn 6 kí tự';
        }
        else if ($pass != $pass_confirm) {
            $error = 'Mật khẩu không khớp';
        }
        else {
            // register a new account
           $result = register($user,$pass,$full_name,$bdate,$email,$phoneN,$type);
		   if ($result['code'] == 0){
			  $check = true;
			   $success = 'Dang ki thanh cong';
		   }else if ($result['code'] ==1){
				$error = 'Email đã tồn tại';
		   }else if ($result['code'] ==3){
				$error = 'Tên đăng nhập đã tồn tại';
		   }else{
			   $error = 'Xảy ra lỗi. Vui lòng thử lại sau';
		   }
        }
    }
?>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-5 col-lg-6 col-md-8 border my-3 p-4 rounded mx-5">
			<?php
				if(!$check){
					?>
                <form method="post" action="" novalidate>
					<h3 class="text-center text-secondary mt-1 mb-2">Tạo tài khoản</h3>
					<div class="form-group">
                        <label for="pass">Tên đăng nhập</label>
                        <input name="username" required class="form-control" value = "<?= $user ?>" type="text" placeholder="Username" id="username">
                    </div>
					<div class="form-group">
                        <label for="pass">Mật khẩu</label>
                        <input name="pass" required class="form-control" value = "<?= $pass ?>" type="password" placeholder="Password" id="pass">
                        <div class="invalid-feedback">Password is not valid.</div>
                    </div>
                    <div class="form-group">
                        <label for="fullname">Họ và Tên</label>
                        <input name="name" required class="form-control" value = "<?= $full_name ?>" type="text" id="fullname">
                    </div>
					<div class="form-group">
                        <label for="birthd">Ngày sinh</label>
                        <input name="birthd" required class="form-control" value = "<?= $bdate ?>" type="date"  id="birthd">
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input name="email" required class="form-control" value = "<?= $email ?>" type="email" placeholder="Email" id="email">
                    </div>
                    <div class="form-group">
                        <label for="phoneN">Số điện thoại</label>
                        <input name="phoneN" required class="form-control" value = "<?= $phoneN ?>" type="text" id="phoneN">
                    </div>
                    <div class="form-group">
                        <label for="pass2">Nhập lại mật khẩu</label>
                        <input name="pass-confirm" required class="form-control" value = "<?= $pass_confirm ?>" type="password" placeholder="Confirm Password" id="pass2">
                        <div class="invalid-feedback">Password is not valid.</div>
                    </div>

                    <div class="form-group mt-4 mr-4">
						<?php
                            if (!empty($error)) {
                                echo "<div class='alert alert-danger'>$error</div>";
                            }
                        ?>
                        <button class="btn btn-success float-right">Đăng kí</button>
						<p><a href="login.php">Quay lại</a></p>
                    </div>
                    <div class="form-group">
                        <p>Đã có tài khoản? <a href="login.php">Login</a> now.</p>
                    </div>
                </form>
				<?php
				}else{
			?>
				<form method="post" action="" novalidate>
					<h3 class="text-center text-secondary mt-1 mb-2">Tạo tài khoản</h3>
					<div class="form-group">
                        <label for="pass">Tên đăng nhập</label>
                        <input readonly name="username" required class="form-control" value = "<?= $user ?>" type="text" placeholder="Username" id="username">
                    </div>
					<div class="form-group">
                        <label for="pass">Mật khẩu</label>
                        <input readonly name="pass" required class="form-control" value = "<?= $pass ?>" type="password" placeholder="Password" id="pass">
                        <div class="invalid-feedback">Password is not valid.</div>
                    </div>
                    <div class="form-group">
                        <label for="fullname">Họ và Tên</label>
                        <input readonly name="name" required class="form-control" value = "<?= $full_name ?>" type="text"  id="fullname">
                    </div>
					<div class="form-group">
                        <label for="birthd">Ngày sinh</label>
                        <input readonly name="birthd" required class="form-control" value = "<?= $bdate ?>" type="date" id="birthd">
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input readonly name="email" required class="form-control" value = "<?= $email ?>" type="email" placeholder="Email" id="email">
                    </div>
                    <div class="form-group">
                        <label for="phoneN">Số điện thoại</label>
                        <input readonly name="phoneN" required class="form-control" value = "<?= $phoneN ?>" type="text" id="phoneN">
                    </div>
                    <div class="form-group">
                        <label for="pass2">Nhập lại mật khẩu</label>
                        <input readonly name="pass-confirm" required class="form-control" value = "<?= $pass_confirm ?>" type="password" placeholder="Confirm Password" id="pass2">
                        <div class="invalid-feedback">Password is not valid.</div>
                    </div>

                    <div class="form-group mt-4 mr-4">
						<?php
                            if (!empty($success)) {
                                echo "<div class='alert alert-success'>$success</div>";
                            }
                        ?>
						<p><a href="login.php">Quay lại</a></p>
                    </div>
                    <div class="form-group">
                        <p>Đã có tài khoản? <a href="login.php">Login</a> now.</p>
                    </div>
                </form>
				<?php
				}
				?>
				
            </div>
        </div>

    </div>
</body>
</html>

