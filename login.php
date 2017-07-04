<?php
/**
 * Login Page
 */

include 'func.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	$email = strtolower(validateInput(isset($_POST['email']) ? $_POST['email'] : ''));
	$pword = isset($_POST['pword']) ? $_POST['pword'] : '';


	if ($email == '' || $pword == '') {
		echo "Fill All fields!";
		exit();          
	} else {

		# make new db object
		$db = new db_util();

		$sql = "SELECT * FROM vm_users WHERE user_email='$email'";
		$result = $db->query($sql);

		if ($result !== false) {
            // if there any error in sql then it will false
			if ($result->num_rows > 0) {

				$row = $result->fetch_assoc();

				if (password_verify($pword, $row["user_password"])) {

					echo "User Logged In!";

					/**
					 * TODO:
					 * Add cookie or something to remember
					 * that user is logged in!
					 */

					exit();
				}

			}
		}


	}

	exit("Something Wrong!");

}

?>

<form method="post" action="<?=htmlspecialchars($_SERVER['PHP_SELF']);?>">
	<p>E-mail:</p>
	<input type="text" name="email">

	<p>Password:</p>
	<input type="password" name="pword">

	<br>

	<input type="submit" value="Login">
</form>