<?php
	require_once('database.php');
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Active announce</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link
      rel="stylesheet"
      href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
    />
    <link
      rel="stylesheet"
      href="https://use.fontawesome.com/releases/v5.3.1/css/all.css"
      integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU"
      crossorigin="anonymous"
    />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  </head>
  <body>
  
	<?php
		$error ='';
		$message ='';
		
		if(isset($_GET['email'])){
			$email = $_GET['email'];
			
			if(filter_var($email, FILTER_VALIDATE_EMAIL) === false){
				$error = 'Invalid email address';
			}
			else{
				$result = activeAccount($email);
				if ($result['code'] == 0){
					$message = 'Your account has been activated. Login now';
				}else{
					$error = $result['error'];
				}
			}
		}
		else{
			$error = 'Invalid activation url';
		}
	?>
	
	<?php
		if (!empty($error)){
			?>
				<div class="row">
				<div class="col-md-6 mt-5 mx-auto p-3 border rounded">
					<h4>Cập nhật tài khoản</h4>
					<p class="text-danger"><?=$error ?></p>
					<a href="index.php">Quay lại</a>
				</div>
    </div>
			<?php
		}else{
			?>
				<div class="container">
				  <div class="row">
					<div class="col-md-6 mt-5 mx-auto p-3 border rounded">
						<h4>Cập nhật tài khoản</h4>
						<p class="text-success">Bạn đã cập nhật thành công. Bạn có thể tạo lớp học của mình.</p>
						<?php
							session_start();
							session_destroy();
						?>
						<a href="index.php">Quay lại</a>
					</div>
				  </div>
			<?php
		}
	?>
    

    
    </div>
  </body>
</html>
