<?php
    session_start();
    if (isset($_SESSION['user'])) {
        header('Location: index.php');
        exit();
    }
	require_once('database.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Login</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>

<?php

    $error = '';
    $user = '';
    $pass = '';

    if (isset($_POST['user']) && isset($_POST['pass'])) {
        $user = $_POST['user'];
        $pass = $_POST['pass'];

        if (empty($user)) {
            $error = 'Please enter your username';
        }
        else if (empty($pass)) {
            $error = 'Please enter your password';
        }
        else if (strlen($pass) < 6) {
            $error = 'Password must have at least 6 characters';
        }
        else{
			$result = login($user, $pass);
			if ($result['code'] ==0){
				$data = $result['data'];
				$_SESSION['user'] = $user;
				$_SESSION['name'] = $data['fullname'];
				$_SESSION['email'] = $data['email'];
				$_SESSION['type'] = $data['type'];
				header('Location: index.php');
				exit();
			}else {
				$error = $result['error'];
			}
        }
    }
?>

	<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5 mt-4">
            <form method="post" action="" class="border rounded w-100 mb-5 mx-auto bg-light px-4 pt-3 mt-5">
                <h1 class="text-center mt-4 mb-3">Đăng nhập</h1>
				<div class = "text-center mb-4 text-info font-weight-bold">Sử dụng Tài khoản Hệ thống của bạn</div>
				
				<div class="form-group">
                    <label for="user">Tên đăng nhập</label>
                    <input  name="user" value="<?= $user ?>" id="user" type="text" class="form-control" placeholder="Tên đăng nhập">
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input name="pass" value="<?= $pass ?>" id="password" type="password" class="form-control" placeholder="Password">
                </div>
                <!-- <div class="form-group custom-control custom-checkbox"> -->
                    <!-- <input  name="remember" type="checkbox" class="custom-control-input" id="remember"> -->
                    <!-- <label class="custom-control-label" for="remember">Remember login</label> -->
                <!-- </div> -->
                <div class="form-group text-right">
					<?php
                        if (!empty($error)) {
                            echo "<div class='alert alert-danger'>$error</div>";
                        }
                    ?>
                    <button class="btn btn-primary px-3 mt-4 mb-4">Đăng nhập</button>
                </div>
                <div class="form-group">
                    <p>Bạn chưa có tài khoản? <a href="register.php" class = "font-italic font-weight-bold">Tạo tài khoản</a>.</p>
                    <p>Quên mật khẩu? <a href="forgot.php" class = "font-italic font-weight-bold">Đặt lại mật khẩu</a>.</p>
                </div>
            </form>
            
        </div>
    </div>
</div>
</body>
</html>