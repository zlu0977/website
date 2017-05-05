<?php
	
	function getDBResults($cmd, $arrayType = PDO::FETCH_BOTH)
	{
		global $conn;
		$result = $conn->prepare($cmd);
		$result->execute();
		
		return $result->fetchAll($arrayType);
	}

	function addImage($TYPE, $IMG, $ID, $PATH = "")
	{
		if (fileCheck($IMG))
		{
			$imgFolder = $TYPE. " imgs";
			
			$fileType = explode(".", $IMG["name"]);
			$fileType = end($fileType);
			
			$newName = $ID.'.'.$fileType;
			$imgPath = $imgFolder.'/'.$newName;
			
			if(is_dir($PATH.$imgFolder))
				move_uploaded_file($IMG['tmp_name'], $PATH.$imgPath);
			else
			{
				mkdir($PATH.$imgFolder);
				move_uploaded_file($IMG['tmp_name'], $PATH.$imgPath);
			}
			return $imgPath;
		}
		else
			return "";
	}
	
	function getAvatar($USER)
	{	
		$cmd = "SELECT * FROM `users0` WHERE `username0` = '$USER'";
		$userData = getDBResults($cmd)[0];
		$userAvatar = $userData['avatar_path'];
		
		if($userAvatar != "" && file_exists($userAvatar))
			return $userAvatar;
		else
			return "imgs/default avatar.png";
	}
	
	function fileCheck($FILE)
	{
		$acceptedFile = array('image/png', 'image/jpeg', 'image/jpg', 'image/gif');
		$fileType = $FILE ['type'];
		
		foreach ($acceptedFile as $type)
			if ($fileType == $type)
				return true;
		
		return false;
	}
?>