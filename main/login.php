<?php
	session_start();
	
	include "php/access.php";
	$msg = "";
	
	if ($_SERVER["REQUEST_METHOD"] == "POST")
	{
		$date = date("Y-m-d");
		$uname = $_POST['uname'];
		$pword = $_POST['pword'];
		$logreg = $_POST['logreg'];
		$conn = new PDO("mysql:host=".$hostName.";dbname=".$dbName, $usernameName, $passwordName);
		
		$cmd = "SELECT * FROM `users1`";
		$result = $conn->prepare($cmd);
		$result->execute();
		$idNum = $result->rowCount();
		
		
		$cmd = "SELECT * FROM `users1` WHERE `username1` = '$uname'";
		$result = $conn->prepare($cmd);
		$result->execute();
		
		if ($logreg == "login")
			$msg = checkLogin($result->rowCount());
		else
			$msg = checkRegister($result->rowCount());
	}
	
	function checkLogin($userCount)
	{
		global $uname, $pword, $hash, $conn, $result;
		
		if ($userCount == 0)
			return "You have entered an incorrect username or password";
		
		$psword = password_hash($pword, PASSWORD_DEFAULT);
		$data = $result->fetch();
		
		if(!password_verify($pword.$uname, $data['password1']))
			return "You have entered an incorrect username or password";
		
		if(isset($_POST['remember']))
			setcookie('uname1', $uname, time() + (86400 * 365), '/');
		
		session_start();
		$_SESSION['username1'] = $uname;
		header("Location: index.php");
	}
	
	function checkRegister($userCount)
	{
		global $idNum, $date, $uname, $pword, $conn;

		if ($userCount > 0)
			return "A user with that name already exists.";
		
		if(strlen($uname) < 4)
			return "Username is too short.";
		
		if(!ctype_alnum($uname))
			return "AlphaNumeric characters only.";
		
		if(strlen($pword) < 8)
			return "Password is too short.";
		
		$hash = password_hash($pword.$uname, PASSWORD_DEFAULT);
		$cmd = "INSERT INTO `users1` VALUES ('$idNum', '$uname', '$hash', '$date', NOW())";
		$result = $conn->prepare($cmd);
		$result->execute();

		setcookie('tutorialEnd', $uname, time() + (86400 * 1), '/');
		return "Congratulations, $uname! You are now registered. Please log in.";
	}
?>

<!DOCTYPE HTML>
<!--Zheng Lu-->
<html>
	<head>
		<title>Login</title>
		<!--<link rel = "stylesheet" href = "index.css" />-->
		<script>
			function initialize()
			{
				
			}
		</script>
	</head>
	<body onload = "initialize();">
		<div id = "background"></div>
		<div id = "header"></div>
		
		<div id = "info"></div>
		<div id = "login">
			<form method = "post" action = "login.php">
				<input id = "username" name ="uname" placeholder = "Username" required/>
				<input id = "password" name = "pword" placeholder = "Password" required/>
				<button id = "loginButton" type = "submit">Login</button>
			</form>
			
			<div id = "switch">
				<div id = "choiceLogin" onclick = "">Login</div>
				<div id = "choiceRegister" onclick = "">Register</div>
			</div>
			
		</div>
	</body>
</html>