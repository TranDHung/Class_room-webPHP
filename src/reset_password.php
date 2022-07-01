<?php
	require_once('database.php');
?>

<DOCTYPE html>
<html lang="en">
<head>
    <title>Đặt lại mật khẩu</title>
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
	$post_error ='';
    $email = '';
    $pass = '';
    $pass_confirm = '';
	$check = false;
	
	$display_email = filter_input(INPUT_GET, 'email',FILTER_SANITIZE_EMAIL);
	
	if(isset($_GET['email'])){
		$email = $_GET['email'];

		if(filter_var($email, FILTER_SANITIZE_EMAIL)==false){
			$error = 'Địa chỉ email không đúng';
		}
		else{
			if (isset($_POST['email']) && isset($_POST['pass']) && isset($_POST['pass-confirm'])) {

				$email = $_POST['email'];
				$pass = $_POST['pass'];
				$pass_confirm = $_POST['pass-confirm'];

				if (empty($email)) {
					$post_error = 'Please enter your email';
				}
				else if (filter_var($email, FILTER_VALIDATE_EMAIL) == false) {
					$post_error = 'Địa chỉ email không đúng';
				}
				else if (empty($pass)) {
					$post_error = 'NHập mật khẩu mới';
				}
				else if (strlen($pass) < 6) {
					$post_error = 'Mật khẩu phải nhiều hơn 6 kí tự';
				}
				else if ($pass != $pass_confirm) {
					$post_error = 'Mật khẩu không khớp';
				}
				else {
					updatePassword($pass, $email);
					$check = true;
				}
			}
			else {
				//print_r($_POST);
			}
		}
	}
	else{
		$error = 'Invalid email address or token';
	}
    
?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-5">
			<form novalidate method="post" action="" class="border rounded w-100 mb-5 mx-auto px-4 pt-3 bg-light mt-5">
				<div><h3 class="text-center mt-4 mb-3">Đặt lại mật khẩu</h3></div>
				<div class="form-group">
					<label for="email">Email</label>
					<input readonly name="email" value="<?= $email ?>" id="email" type="text" class="form-control">
				</div>
				<div class="form-group">
					<label for="pass">Mật khẩu mới</label>
					<input
					<?php
						if($check){
							?>
							readonly
						<?php
						}
					?>
					name="pass" value="<?= $pass?>" required class="form-control" type="password" placeholder="Password" id="pass">
					<div class="invalid-feedback">Password is not valid.</div>
				</div>
				<div class="form-group">
					<label for="pass2">Nhập lại mật khẩu</label>
					<input 
					<?php
						if($check){
							?>
							readonly
						<?php
						}
					?>
					name="pass-confirm" value="<?= $pass_confirm?>" required class="form-control" type="password" placeholder="Confirm Password" id="pass2">
					<div class="invalid-feedback">Password is not valid.</div>
				</div>
				<div class="form-group mb-4">
					<?php
						if(!$check){
						?>
						<button class="btn btn-success">Lưu thay đổi</button>
						<?php
						}else{
						?>
						<p><a href="login.php">Quay lại</a></p>
						<?php
						}
					?>
				</div>
			</form>
        </div>
    </div>
</div>

</body>
</html>
