<?php
/**
 * Register Page
 */

include 'func.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {


    $name = validateInput(isset($_POST['uname']) ? $_POST['uname'] : '');
    $email = strtolower(validateInput(isset($_POST['email']) ? $_POST['email'] : ''));
    $pword = isset($_POST['pword']) ? $_POST['pword'] : '';
    $re_pword = isset($_POST['pwordagain']) ? $_POST['pwordagain'] : '';

	if ($name == '' || $email == '' || $pword == '' || $re_pword == '') {
		echo "Fill All fields!";
		exit();          
	} elseif ($pword != $re_pword) {
		echo "Password mismatch!";
		exit(); 
	} else {

		$pass_hash = password_hash($pword, PASSWORD_BCRYPT, ['cost' => 10]);

		$user = new User();
		$user->setEmail($email);
		$user->setName($name);
		$user->setPassword($pass_hash);

		$result = $user->add();

		if($result!== false)
		{
			echo "User Successfully registered!";
			exit();
		}

	}

	exit("Something Wrong!");

}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Register</title>
</head>
<body>

	<form method="post" action="<?=htmlspecialchars($_SERVER['PHP_SELF']);?>">
		<p>Username: </p>
		<input type="text" name="uname">
		<p>E-mail: </p>
		<input type="email" name="email">
		<p>Password: </p>
		<input type="password" name="pword">
		<p>Password: </p>
		<input type="password" name="pwordagain">
		<br>
		<input type="submit" value="Submit">
	</form>

</body>
</html>