<?php
	session_start();
	require_once('database.php');
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Active</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous"/>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  </head>
  <body>
  <?php
		$mess = "Tính năng này dành cho admin.";
		$email = $_SESSION['email'];
		if(isset($_POST['email'])){
			$check_value = isset($_POST['check']) ? 1 : 0;
			if ($check_value == 0) {
				$mess = "<div class='alert alert-danger'>Vui lòng điền đủ thông tin</div>";
			}else{
				$conn = open_database();
				$sql = "select email from user where type = 0";
				$result = $conn->query($sql);
				while($row = $result->fetch_assoc()) {
					sendAdminActivationEmail($email, $row['email']);// Add a recipient
				}
			}
		}		
  ?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <form method="post" action="" class="border rounded w-100 mb-5 mx-auto px-3 pt-3 mt-5">
				<h3 class="text-center mt-3 mb-3">Cập nhật tài khoản</h3>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input readonly name="email" value="<?= $_SESSION['email'] ?>" id="email" type="text" class="form-control">
                </div>
				<div class="form-group">
                    <label for="name">Họ & tên</label>
                    <input readonly name="name" id="name" value="<?= $_SESSION['name'] ?>" type="text" class="form-control">
                </div>
				<div class="form-group">
                    <input name="check" id="check" type="checkbox"> Bạn là admin
                </div>
                <div class="form-group">
                    <?php
						echo "$mess";
					?>
                </div>
                <div class="form-group text-right">
                    <button class="btn btn-success px-5">Gửi yêu cầu</button>
                </div>
            </form>

        </div>
    </div>
</div>
  </body>
</html>
