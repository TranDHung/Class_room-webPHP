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
	<script src="main.js"></script>
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
	$message = '';
	$check = false;
	$content = $_SESSION['content'];
	$obId = $_SESSION['objectId'];
	if(isset($_POST['content'])){
		$content=$_POST['content'];
		if(empty($content)){
			$message = "<div class='alert alert-danger'>Chưa có thông tin</div>";
		}else{
			$conn = open_database();
			$sql = "UPDATE object SET content='$content' WHERE objectId='$obId'";
			$result = $conn->query($sql);
			if($result){
				$check=true;
				$message = "<div class='alert alert-success'>Cập nhật thành công</div>";
			}
		}
	}
?>
	<nav class="navbar navbar-expand-sm bg-light">
		<a href="index.php" class="navbar-brand"><img src="./image/home_icon.jpg" class="float-left" width="35px" height="35px"></a>
	  <a class="navbar-brand" href="class_index.php"><?= $_SESSION["className"] ?></a>
	  <button class="navbar-toggler navbar-toggler-right collapsed" type="button" data-toggle="collapse" data-target="#navb" aria-expanded="false">
		<span class="navbar-toggler-icon"></span>
	  </button>

	  <div class="navbar-collapse collapse" id="navb" style="">
		<ul class="nav nav-tabs nav-justified mx-auto">
			<li class="nav-item">
			  <a class="nav-link active" href="class_index.php">Stream</a>
			</li>
			<li class="nav-item">
			  <a class="nav-link" href="class_work.php">Classwork</a>
			</li>
			<li class="nav-item">
			  <a class="nav-link" href="class_member.php">People</a>
			</li>
		</ul>
		<?php
			if($_SESSION['type'] == 1){
				?>
		<form method="post" class="float-right my-auto mr-1">
			<button name="edit" class="btn-sm btn btn-secondary">Sửa lớp</button>
		</form>
		<button class=" btn-sm btn btn-danger" data-toggle="modal" data-target="#confirm-delete">Xóa lớp</button>
				<?php
			}
		?>	
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
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5 mt-3">
            <form method="post" action="" class="border rounded w-100 mb-5 mx-auto px-3 pt-3">
				 <h3 class="text-center mt-3 mb-3">Sửa thông tin</h3>
				<div class="form-group">
                    <label for="content">Nội dung</label>
                    <textarea  
					<?php
						if($check){
							?>
							readonly
						<?php
						}
					?>
					name="content" id="content" value = "<?= $content ?>" type="text" class="form-control textarea" oninput="auto_grow(this)"><?= $content ?></textarea>
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
							<a href="class_index.php">Quay lại</a>
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


