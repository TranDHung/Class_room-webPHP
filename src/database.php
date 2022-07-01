<link rel="stylesheet" href="style.css">
<?php
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;

	require 'PHPMailer/src/Exception.php';
	require 'PHPMailer/src/PHPMailer.php';
	require 'PHPMailer/src/SMTP.php';

	// Load Composer's autoloader
	require 'vendor/autoload.php';

	define('HOST','127.0.0.1');
	define('USER','root');
	define('PASS','');
	define('DB','database');
	
	function open_database(){
		$conn = new mysqli(HOST,USER,PASS,DB);
		if ($conn ->connect_error){
			die('Connect error: '.$conn->connect_error);
		}
		return $conn;
		
	}
	
	function login($user, $pass){
		$sql = "select * from user where username = ?";
		$conn = open_database();
		
		$stm = $conn->prepare($sql);
		$stm -> bind_param('s',$user);
		if (!$stm -> execute()){
			return array('code' => 1, 'error' => 'Can not execute command');
		}
		$result = $stm->get_result();
		
		if($result->num_rows == 0){
			return array('code' => 1, 'error' => 'User does not exist');
		}
		
		$data = $result->fetch_assoc();
		
		$hashed_password = $data['password'];
		if(!password_verify($pass, $hashed_password)){
			return array('code' => 2, 'error' => 'Invalid password');
		// }else if($data['activated'] == 0){
			// return array('code' => 3, 'error' => 'This account is not activated');
		}else
			return array('code' => 0, 'error' => '','data' => $data);
	}
	
	function register($user,$pass,$full_name,$bdate,$email,$phoneN,$type){
		if(is_email_exists($email)){
			return array('code' => 1, 'error' =>'Email đã tồn tại');
		}
		if(is_username_exists($user)){
			return array('code' => 3, 'error' =>'Tên đăng nhập đã tồn tại');
		}
		$hash = password_hash($pass, PASSWORD_DEFAULT);
		$sql = "insert into user(username,password,fullname,birthdate,email,phonenumber,type) value(?,?,?,?,?,?,?)";
		$conn = open_database();
		$stm = $conn->prepare($sql);
		$stm->bind_param('ssssssi', $user,$hash,$full_name,$bdate,$email,$phoneN,$type);
		if(!$stm->execute()){
			return array('code' => 2, 'error' => 'Can not execute command');
		}
		return array('code' => 0, 'error' => 'Create account successful');
		
	}
	
	function is_email_exists($email){
		$sql = "select fullname from user where email = ?";
		$conn = open_database();
		
		$stm = $conn->prepare($sql);
		$stm->bind_param('s',$email);
		
		if (!$stm ->execute()){
			die('Query error: '.$stm->error);
		}
		
		$result = $stm->get_result();
		if($result->num_rows >0){
			return true;
		}
	}
	
	function is_username_exists($user){
		$sql = "select fullname from user where username = ?";
		$conn = open_database();
		
		$stm = $conn->prepare($sql);
		$stm->bind_param('s',$user);
		
		if (!$stm ->execute()){
			die('Query error: '.$stm->error);
		}
		
		$result = $stm->get_result();
		if($result->num_rows >0){
			return true;
		}
	}
	
	function random_string(){
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randstring = '';
		$i = 0;
        while($i<9) {
            $randstring .= $characters[rand(0, strlen($characters)-1)];
			$i++;
        }
        return $randstring;
    }
	
	function random_Id(){
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randstring = '';
		$i = 0;
        while($i<8) {
            $randstring .= $characters[rand(0, strlen($characters)-1)];
			$i++;
        }
        return $randstring;
    }

	function sendResetPassword($email){

		// Instantiation and passing `true` enables exceptions
		$mail = new PHPMailer(true);

		try {
			//Server settings
			//$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
			$mail->isSMTP();                                            // Send using SMTP
			$mail->CharSet = 'UTF-8';
			$mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
			$mail->SMTPAuth   = true;                                   // Enable SMTP authentication
			$mail->Username   = 'tranduchung0610@gmail.com';                     // SMTP username
			$mail->Password   = 'cvuyrkqmieyxkzjx';                               // SMTP password
			$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
			$mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

			//Recipients
			$mail->setFrom('tranduchung0610@gmail.com', 'Admin');
			$mail->addAddress($email, 'Nhan');     // Add a recipient
			/*$mail->addAddress('ellen@example.com');               // Name is optional
			$mail->addReplyTo('info@example.com', 'Information');
			$mail->addCC('cc@example.com');
			$mail->addBCC('bcc@example.com');*/

			// Attachments
			//$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
			//$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

			// Content
			$mail->isHTML(true);                                  // Set email format to HTML
			$mail->Subject = 'Khoi phuc mat khau cua ban';
			$mail->Body    = "Click <a href ='http://localhost:8888/reset_password.php?email=$email'>vao day</a> de khoi phuc mat khau";
			//$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

			$mail->send();
			return true;
		} catch (Exception $e) {
			return false;
		}
	}
	
	function sendActivationEmail($email){

		// Instantiation and passing `true` enables exceptions
		$mail = new PHPMailer(true);

		try {
			//Server settings
			//$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
			$mail->isSMTP();                                            // Send using SMTP
			$mail->CharSet = 'UTF-8';
			$mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
			$mail->SMTPAuth   = true;                                   // Enable SMTP authentication
			$mail->Username   = 'tranduchung0610@gmail.com';            // SMTP username
			$mail->Password   = 'cvuyrkqmieyxkzjx';                       // SMTP password
			$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
			$mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

			//Recipients
			$mail->setFrom('tranduchung0610@gmail.com', 'Admin');
			$mail->addAddress($email, 'Người dùng');     // Add a recipient
			/*$mail->addAddress('ellen@example.com');               // Name is optional
			$mail->addReplyTo('info@example.com', 'Information');
			$mail->addCC('cc@example.com');
			$mail->addBCC('bcc@example.com');*/

			// Attachments
			//$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
			//$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

			// Content
			$mail->isHTML(true);                                  // Set email format to HTML
			$mail->Subject = 'Cập nhật tài khoản';
			$mail->Body    = "Click <a href ='http://localhost:8888/check_Active.php?email=$email'>vao day</a> de xac minh";
			//$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

			$mail->send();
			return true;
		} catch (Exception $e) {
			return false;
		}
	}
	
	function sendAdminActivationEmail($email, $adminEmail){

		// Instantiation and passing `true` enables exceptions
		$mail = new PHPMailer(true);

		try {
			//Server settings
			//$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
			$mail->isSMTP();                                            // Send using SMTP
			$mail->CharSet = 'UTF-8';
			$mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
			$mail->SMTPAuth   = true;                                   // Enable SMTP authentication
			$mail->Username   = 'tranduchung0610@gmail.com';            // SMTP username
			$mail->Password   = 'cvuyrkqmieyxkzjx';                       // SMTP password
			$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
			$mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

			//Recipients
			$mail->setFrom('tranduchung0610@gmail.com', 'Admin');
			$mail->addAddress($adminEmail, 'Admin');     // Add a recipient
			/*$mail->addAddress('ellen@example.com');               // Name is optional
			$mail->addReplyTo('info@example.com', 'Information');
			$mail->addCC('cc@example.com');
			$mail->addBCC('bcc@example.com');*/

			// Attachments
			//$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
			//$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

			// Content
			$mail->isHTML(true);                                  // Set email format to HTML
			$mail->Subject = 'Xét làm admin cho tài khoản';
			$mail->Body    = "Click <a href ='http://localhost:8081/check_ActiveAdmin.php?email=$email'>vao day</a> de xac minh cho '$email'";
			//$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

			$mail->send();
			return true;
		} catch (Exception $e) {
			return false;
		}
	}
	
	function activeAdminAccount($email){
		$sql = 'update user set type = 0 where email =?';
		$conn = open_database();
		$stm = $conn->prepare($sql);
		$stm->bind_param('s',$email);
		if (!$stm->execute()){
			return array('code' => 1, 'error' => 'Can not execute command');
		}
		$result = $stm->get_result();
		return array('code' => 0,'message' => 'Account activated');
	}
	
	function edit_account($username, $type, $email){
		$conn = open_database();
		$sql = "update user set type = '$type',email='$email' where username = '$username'";
		
		$stm = $conn->prepare($sql);
		if(!$stm->execute()){
			return array('code' => 1, 'error' => 'Can not execute command');
		}
		return array('code' => 0, 'error' => 'Update class successful');

		$conn->close();
	}
	
	function resetPassword($email){
		if (!is_email_exists($email)){
			return array('code'=>1,'error'=>'Email does not exist');
		}
		$sql = 'select password from user where email = ?';
		
		$conn = open_database();
		$stm = $conn ->prepare($sql);
		$stm -> bind_param('s',$email);
		
		if(!$stm -> execute()){
			return array('code'=>2,'error'=>'Can not execute command');
		}
		if($stm->affected_rows == 0){
			$exp = time() +3600;
			$sql = 'insert into user  values(?,?)';
			$stm = $conn->prepare($sql);
			$stm->bind_param('si',$email,$exp);
			if(!$stm->execute()){
				return array('code'=>1,'error'=>'Can not execute command');
			}
		}
		$success = sendResetPassword($email);
		return array('code'=>0,'success'=>$success);
	}
	function updatePassword($pass, $email){
		$hash = password_hash($pass, PASSWORD_DEFAULT);
		$sql = "UPDATE user SET password='$hash' WHERE email='$email'";
		$conn = open_database();
		if ($conn->query($sql) === TRUE) {
		  echo "Cap nhat mat khau thanh cong";
		} else {
		  echo "Cap nhat that bai: " . $conn->error;
		}

		$conn->close();
	}
	
	function activeAccount($email){
		$sql = 'update user set type = 1 where email =?';
		$conn = open_database();
		$stm = $conn->prepare($sql);
		$stm->bind_param('s',$email);
		if (!$stm->execute()){
			return array('code' => 1, 'error' => 'Can not execute command');
		}
		$result = $stm->get_result();
		return array('code' => 0,'message' => 'Account activated');
	}
	function is_classId_exists($classId){
		$sql = "select className from class where classId = ?";
		$conn = open_database();
		
		$stm = $conn->prepare($sql);
		$stm->bind_param('s',$classId);
		
		if (!$stm ->execute()){
			die('Query error: '.$stm->error);
		}
		
		$result = $stm->get_result();
		if($result->num_rows >0){
			return true;
		}
	}
	function create_class($classId, $className, $creatorName, $courseName, $room, $picture){
		if(is_classId_exists($classId)){
			return array('code' => 1, 'error' => 'Class ID exist');
		}
		$sql = "insert into class(classId, className, creatorName, courseName, room, picture) value(?,?,?,?,?,?)";
		$conn = open_database();
		$stm = $conn->prepare($sql);
		$stm->bind_param('ssssss',$classId,$className,$creatorName,$courseName,$room,$picture);
		if(!$stm->execute()){
			return array('code' => 2, 'error' => 'Can not execute command');
		}
		return array('code' => 0, 'error' => 'Create class successful');

		$conn->close();
	}
	function check_class_of_user($classId,$email){
		$sql = "SELECT class FROM user where email = '$email'";
		$conn = open_database();
		$result = $conn->query($sql);
		$data = $result->fetch_assoc();
		
		if ($result->num_rows > 0) {
			$arr = explode(",",$data['class']);
			$x = 0;
		  while($x<count($arr)) {
			if($classId === $arr[$x]){
				return true;
			}
			$x++;
		  }
		}
		return false;
	}		
	function add_class($classId,$email){
		
		$sql = "SELECT class FROM user where email = '$email'";
		$conn = open_database();
		$result = $conn->query($sql);
		$data = $result->fetch_assoc();
		
		$a = array($classId,$data['class']);
		$full_data = implode(",",$a);
		
		$sql = "UPDATE user set class = '$full_data' where email = '$email'";
		
		if(!$conn->query($sql)){
			return array('code' => 2, 'error' => 'Can not execute command');
		}
		return array('code' => 0, 'error' => 'Create class successful');
		
		$conn->close();
	}
	
	function edit_class($classId, $className, $name, $courseName, $room){
		$conn = open_database();
		$sql = "update class set className = '$className',courseName='$courseName', room='$room' where classId = '$classId'";
		
		$stm = $conn->prepare($sql);
		if(!$stm->execute()){
			return array('code' => 1, 'error' => 'Can not execute command');
		}
		return array('code' => 0, 'error' => 'Update class successful');

		$conn->close();
	}
	
	function find_Creator($classId, $email, $name){
		if(!is_classId_exists($classId)){
			return array('code' => 1, 'error' => 'Mã lớp không tồn tại');
		}
		$sql = "select creatorname from class where classId = '$classId'";
		$conn = open_database();
		$result = $conn->query($sql);
		$row = $result->fetch_assoc();
		$creator = $row["creatorname"];
		
		$sql = "select email from user where fullname = '$creator'";
		$result = $conn->query($sql);
		$row = $result->fetch_assoc();
		$emailT = $row["email"];
		send_require_add_class($emailT,$email,$name,$classId);
		return array('code' => 0, 'error' => 'Đã gửi yêu cầu');
		
	}
	
	function send_require_add_class($emailT,$email,$name,$classId){

		// Instantiation and passing `true` enables exceptions
		$mail = new PHPMailer(true);

		try {
			//Server settings
			//$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
			$mail->isSMTP();                                            // Send using SMTP
			$mail->CharSet = 'UTF-8';
			$mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
			$mail->SMTPAuth   = true;                                   // Enable SMTP authentication
			$mail->Username   = 'tranduchung0610@gmail.com';            // SMTP username
			$mail->Password   = 'cvuyrkqmieyxkzjx';                       // SMTP password
			$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
			$mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

			//Recipients
			$mail->setFrom($email, $name);
			$mail->addAddress($emailT, 'Giáo viên');     // Add a recipient
			/*$mail->addAddress('ellen@example.com');               // Name is optional
			$mail->addReplyTo('info@example.com', 'Information');
			$mail->addCC('cc@example.com');
			$mail->addBCC('bcc@example.com');*/

			// Attachments
			//$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
			//$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

			// Content
			$mail->isHTML(true);                                  // Set email format to HTML
			$mail->Subject = 'Yêu cầu tham gia lớp học';
			$mail->Body    = "<div style='background:lightgray; width:60%'><p style='font-size:20px'>Tên người yêu cầu: $name</p><a href ='http://localhost:8888/accept.php?classId=$classId&&email=$email'><button style='font-size:20px;float:right'>Accept</button></a>";
			//$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

			$mail->send();
			return true;
		} catch (Exception $e) {
			return false;
		}
	}
	
	function add_student($studentE,$classId,$nameCre){
		$conn = open_database();
		$sql ="select * from class where classId = '$classId'";
		$result = $conn->query($sql);
		$row = $result->fetch_assoc();
		$className = $row['className'];
		$arr = explode("\n",$studentE);
		$x=0;
		while($x<count($arr)){
			send_add_student($arr[$x],$classId,$className,$nameCre);
			$x++;
		}
	}
	
	function send_add_student($email,$classId,$className,$nameCre){

		// Instantiation and passing `true` enables exceptions
		$mail = new PHPMailer(true);

		try {
			//Server settings
			//$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
			$mail->isSMTP();                                            // Send using SMTP
			$mail->CharSet = 'UTF-8';
			$mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
			$mail->SMTPAuth   = true;                                   // Enable SMTP authentication
			$mail->Username   = 'tranduchung0610@gmail.com';            // SMTP username
			$mail->Password   = 'cvuyrkqmieyxkzjx';                       // SMTP password
			$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
			$mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

			//Recipients
			$mail->setFrom('tranduchung0610@gmail.com', $nameCre);
			$mail->addAddress($email, '');     // Add a recipient
			/*$mail->addAddress('ellen@example.com');               // Name is optional
			$mail->addReplyTo('info@example.com', 'Information');
			$mail->addCC('cc@example.com');
			$mail->addBCC('bcc@example.com');*/

			// Attachments
			//$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
			//$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

			// Content
			$mail->isHTML(true);                                  // Set email format to HTML
			$mail->Subject = 'Lời mời tham gia lớp học';
			$mail->Body    = "<div style='background:lightgray; width:60%'><p style='font-size:20px'>Tên GV: $nameCre</p><p style='font-size:25px'>Môn: $className</p><a href ='http://localhost:8888/student_accept.php?classId=$classId&&email=$email'><button style='font-size:20px;float:right'>Accept</button></a>";
			//$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

			$mail->send();
			return true;
		} catch (Exception $e) {
			return false;
		}
	}
	
?>