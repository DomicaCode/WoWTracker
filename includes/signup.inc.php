<?php 

if (isset($_POST['submit'])) 
{
	include_once 'dbh.inc.php';

	$first = mysqli_real_escape_string($conn, $_POST['first'] );
	$last = mysqli_real_escape_string($conn, $_POST['last'] );
	$email = mysqli_real_escape_string($conn, $_POST['email'] );
	$uid = mysqli_real_escape_string($conn, $_POST['uid'] );
	$pwd = mysqli_real_escape_string($conn, $_POST['pwd'] );

	//Error handleri
	//Check for empty fields
	if (empty($first) || empty($last) || empty($email) || empty($uid) || empty($pwd)) 
	{
		header("Location: ../signup.php?signup=empty");
		exit();
	} 
	else 
	{
		//Provjeri jesu input characteri valid
		if (!preg_match("/^[a-zA-Z]*$/", $first) || !preg_match("/^[a-zA-Z]*$/", $last) ) 
		{
			header("Location: ../signup.php?signup=invalidchar");
			exit();
		}
		else 
		{
			//Provjeri jel valja email
			if (!filter_var($email, FILTER_VALIDATE_EMAIL)) 
			{
				header("Location: ../signup.php?signup=invalidemail");
				exit();
			}
			else
			{
				$sql = "SELECT * FROM user WHERE user_uid = '$uid'";
				$result	 = mysqli_query($conn, $sql);
				$resultCheck = mysqli_num_rows($result);

				if ($resultCheck != 0) 
				{
					header("Location: ../signup.php?signup=usertaken");
					exit();
				}
				else
				{
					//Hasham pass
					$hashedPwd = password_hash($pwd, PASSWORD_ARGON2I);
					//Insertiraj usera u DB
					$sql = "INSERT INTO users (user_first, user_last, user_email, user_uid, user_pwd) VALUES ('$first', '$last', '$email', '$uid', '$hashedPwd')";
					mysqli_query($conn, $sql);
					header("Location: ../signup.php?signup=success");
					exit();
				}
			}
		}
	}


} 
else 
{
	header("Location: ../signup.php");
	exit();
}

 ?>