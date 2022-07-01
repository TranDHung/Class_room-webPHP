<?php
    session_start();
    if (!isset($_SESSION['user'])) {
        header('Location: login.php');
        exit();
    }
	require_once('database.php');
	
	$root = "./admin";
      if(!file_exists($root)){
        mkdir($root);
    }

?>

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
<body>
<?php
	$conn = open_database();
	$eachId = $_SESSION["classId"];
	$sql = "select * from class where classId = '$eachId'";
	$result = $conn->query($sql);
	$row = $result->fetch_assoc();

	$_SESSION["className"] = $row['className'];
	$_SESSION["creator"] = $row['creatorname'];
	$_SESSION["pictureClass"] = $row['picture'];
	$pathPicture = $root."/".$row['picture'];
	
	if(isset($_POST['edit'])){
		header('Location: edit_class.php');
		exit();
	}
	if(isset($_POST['delete'])){
		$sql = "DELETE FROM class WHERE classId='$eachId'";
		$result = $conn->query($sql);
		if($result === true){
			echo "<div class='alert alert-success'>Đã xóa một lớp học</div>";
			header('Location: index.php');
		}
		
	}
	if(isset($_POST["submit"])){
		if(isset($_FILES["fFile"]) && $_FILES["fFile"]["error"] == 0){
			$filename = $_FILES["fFile"]["name"];
			$filetype = $_FILES["fFile"]["type"];
			$filesize = $_FILES["fFile"]["size"];
			
			$ext = pathinfo($filename, PATHINFO_EXTENSION);
			if(file_exists("$root/" . $_FILES["fFile"]["name"])){
				echo $_FILES["fFile"]["name"] . " đã tồn tại";
			} else{
				move_uploaded_file($_FILES["fFile"]["tmp_name"], "$root/" . $_FILES["fFile"]["name"]);
				echo "Upload file thành công";
			} 
		} else{
			
		}
	}
	
	$object ='';
	$error = '';
	$file = '';
	if(isset($_POST['object'])){
		$objectId = random_Id();
		$object = $_POST['object'];
		$file = $_FILES["fFile"]["name"];
		$name = $_SESSION['name'];
		if(empty($object)){
			$error = 'Không có nội dung';
		}
		else{
			$sql = "insert into object(objectId,content,creator, file, classId) values('$objectId','$object','$name','$file','$eachId')";
			$result = $conn->query($sql);
			if(!$result){
				$error = 'Không thực thi được';
			}
		}
	}
	
	
	
	$comment = '';
	if(isset($_POST['comment'])){
		$commentId = random_Id();
		$comment = $_POST['comment'];
		$name = $_SESSION['name'];
		$ojId = $_POST['idOj'];
		if(empty($comment)){
			
		}else{
			$sql = "insert into comment(commentId,creatorname,content,objectId) values('$commentId','$name','$comment','$ojId')";
			$result = $conn->query($sql);
			if($result){
			}
		}
	}
	
	if(isset($_POST['editOj'])){
		$_SESSION['objectId'] = $_POST['editOj'];
		$oId = $_POST['editOj'];
		$sql = "select * from object where objectId = '$oId'";
		$result = $conn->query($sql);
		$row = $result->fetch_assoc();
		$_SESSION['content'] = $row['content'];
		header('Location: edit_object.php');
		exit();
	}
	if(isset($_POST['deleteOj'])){
		$oId = $_POST['deleteOj'];
		$sql = "delete from object where objectId = '$oId'";
		$result = $conn->query($sql);
		if($result){
		}
	}
	$check = false;
	if(isset($_POST['editCom'])){
		$check = true;
		$_SESSION['commentId'] = $_POST['editCom'];
		$comId = $_POST['editCom'];
		$sql = "select * from comment where commentId = '$comId'";
		$result = $conn->query($sql);
		$row = $result->fetch_assoc();
		$_SESSION['objId'] = $row['objectId'];
		$_SESSION['contentComment'] = $row['content'];
	}
	if(isset($_POST['deleteCom'])){
		$comId = $_POST['deleteCom'];
		$sql = "delete from comment where commentId = '$comId'";
		$result = $conn->query($sql);
		if($result){
		}
	}
	
	if(isset($_POST['recomment'])){
		$check = false;
		$content=$_POST['recomment'];
		$id = $_SESSION['commentId'];
		if(empty($content)){
			
		}else{
			$conn = open_database();
			$sql = "UPDATE comment SET content='$content' WHERE commentId='$id'";
			$result = $conn->query($sql);
			if($result){
				
			}
		}
	}
	
	$conn->close();
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
			<?php
				if($_SESSION['type']===1){
				?>
				<li class="nav-item">
				  <a class="nav-link" href="class_work.php">Assignment</a>
				</li>
				<?php
				}else{
				?>
				<li class="nav-item">
				  <a class="nav-link" href="class_work.php">Classwork</a>
				</li>
				<?php
				}
			?>
			<li class="nav-item">
			  <a class="nav-link" href="class_member.php">People</a>
			</li>
		</ul>
		<?php
			if($_SESSION['type'] == 1 || $_SESSION['type'] == 0){
				?>
				<div class="dropdown dropleft">
					<button type="button" class="btn btn-sm dropdown-toggler float-right" data-toggle="dropdown">
					Tùy chọn
					</button>
					<div class="dropdown-menu">
					  <form method="post"">
						<button name="edit" class="dropdown-item btn-sm">Sửa lớp</button>
					  </form>
					  <button class="dropdown-item btn-sm btn btn-danger" data-toggle="modal" data-target="#confirm-delete">Xóa lớp</button>
					</div>
				</div>
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
		<div class="col-lg-11 mt-4">
			<img class="card-img-top" src="<?= $pathPicture ?>" height="240px" width="100%">
			<div class="card-img-overlay">
			<h3 class="card-title mt-3 ml-4 text-light"><?= $_SESSION["className"] ?></h3>
			</div>
		</div>
	</div>
	<div class="row mt-4 justify-content-center">
		<div class="col-lg-3 mb-4">
		  <div id="assig">
			
		  </div>
		</div>
		<div class="col-lg-8">
		  <form class="bg-light mb-4" method="post" enctype="multipart/form-data">
			<div>
			<textarea name="object" value="<?= $object ?>" class="form-control textarea" placeholder="Share somethings with your class" oninput="auto_grow(this)"></textarea>
			</div>
			<div class="form-group">
				<?php
					if (!empty($error)) {
						echo "<div class='alert alert-danger'>$error</div>";
					}
                ?>
				<input class="mt-2" type="file" id="customFile" name="fFile">
				<a href="class_index.php" class="btn btn-secondary btn-sm text-dark float-right mt-1 mr-2">Hủy</a>
				<button class="btn btn-primary btn-sm mt-1 mr-2 float-right" type="submit" name="submit">Đăng</button>
				
			</div>
		  </form>
		  <?php
		    $conn = open_database();
			$sql = "select * from object";
			$result = $conn->query($sql);
			while($row=$result->fetch_assoc()){
				$creator = $row['creator'];
				if(!empty($row['file'])){
					$path = $root."/".$row['file'];
				}else{
					$path ='';
				}
				if($row['classId'] === $eachId){
			?>
				<table class="table table-bordered table-striped">
					<tbody>
						<tr></tr>
					  <tr>
						<td>
						<?php
							if($_SESSION['name'] === $creator || $_SESSION['type'] === 1){
								?>
						<form method="post">
						<div class="dropdown">
							<button type="button" class="btn btn-sm dropdown-toggler float-right" data-toggle="dropdown">
							  <strong>:</strong>
							</button>
							<div class="dropdown-menu">
								<?php
									if($_SESSION['type'] === 1 && $_SESSION['name'] != $creator){
									?>
									<button class="dropdown-item btn" name = "deleteOj" value = "<?= $row['objectId'] ?>">Xóa</button>
									<?php
									}else{
										?>
								  <button class="dropdown-item btn" name = "editOj" value = "<?= $row['objectId'] ?>">Sửa</button>
								  <button class="dropdown-item btn" name = "deleteOj" value = "<?= $row['objectId'] ?>">Xóa</button>
								<?php
									}
								?>
							</div>
						 </div>
						</form>
							<?php
							}
						?>
						<div class="mb-4">
						<h5><?= $row["creator"] ?></h5>
						<div>
						<?= $row["content"] ?>
						</div>
						<a href="<?= $path ?>" download><?= $row['file'] ?></a>
						</div>
						</td>
					  </tr>
					  <tr>
						<td>
					<?php
						
						$conn = open_database();
						$sql1 = "select * from comment";
						$result1 = $conn->query($sql1);
						while($row1=$result1->fetch_assoc()){
							$creatorC = $row1['creatorname'];
							if($row['objectId'] === $row1['objectId']){
							if($_SESSION['name'] === $creatorC || $_SESSION['type'] === 1){
							?>
							<form method="post">
							<div class="dropdown">
								<button type="button" class="btn btn-sm dropdown-toggler float-right" data-toggle="dropdown">
								  <strong>:</strong>
								</button>
								<div class="dropdown-menu">
									<?php
										if($_SESSION['type'] === 1 && $_SESSION['name'] != $creatorC){
										?>
										<button class="dropdown-item btn" name = "deleteCom" value = "<?= $row1['commentId'] ?>">Xóa</button>
										<?php
										}else{
											?>
											<button class="dropdown-item btn" name = "editCom" value = "<?= $row1['commentId'] ?>">Sửa</button>
											<button class="dropdown-item btn" name = "deleteCom" value = "<?= $row1['commentId'] ?>">Xóa</button>
										<?php
										}
									?>
								</div>
							 </div>
							</form>
							<?php
							}
							?>
							<div class="mb-3">
								<strong><?= $row1['creatorname'] ?></strong>
								<?php
									if(!$check){
									?>
								<div>
									<?= $row1['content'] ?>
								</div>
									<?php
									}else{
										if($_SESSION['objId'] === $row1['objectId'] && $row1['commentId']===$_SESSION['commentId']){
									?>
								<form method="post">
									<div class="input-group">
										<input type="text" name="recomment" class="form-control" value="<?= $_SESSION['contentComment'] ?>">
										<div class="input-group-append">
										  <button class="btn btn-success" type="submit">Gửi</button>
										</div>
									</div>
								</form>
									<?php
										}else{
											?>
											<div>
												<?= $row1['content'] ?>
											</div>
											<?php
										}
									}
								?>
							</div>
							<?php
							}
						}
					?>
						<form method="post">
							<div class="input-group">
								<input type="text" name="comment" class="form-control" placeholder="Add class comment">
								<div class="input-group-append">
								  <button class="btn btn-success" name = "idOj" value = "<?= $row['objectId'] ?>" type="submit">Gửi</button>  
								</div>
							</div>
						</form>
						</td>
					</tbody>
				 </table>
			  <?php
				}
			}
			?>
		  
		  
		</div>
	</div>
	
</body>
</html>