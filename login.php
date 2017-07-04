<?php
/**
 * Login Page
 */


if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	include 'func.php';

	/**
	 * Result values
	 */
	$_isLogin = false;
	$_title = "Error!";
	$_message = "Something Wrong!";

	function loginNow()
	{
		$email = strtolower(validateInput(isset($_POST['email']) ? $_POST['email'] : ''));
		$pword = isset($_POST['pword']) ? $_POST['pword'] : '';

		if ($email == '' || $pword == '') {

            $GLOBALS['_isLogin'] = false;
            $GLOBALS['_title'] = "Error!";
            $GLOBALS['_message'] = "Fill all fields!";

		} else {

		# make new db object
			$db = new db_util();

			$sql = "SELECT * FROM vm_users WHERE user_email='$email'";
			$result = $db->query($sql);

			if ($result !== false) {
            // if there any error in sql then it will false
				if ($result->num_rows > 0) {

					$row = $result->fetch_assoc();

				//function:-->   password_verify ($passward,hash)

					if (password_verify($pword, $row["user_password"])) {

						/**
						 * Set Cookies
						 */
						# Creating two hashed password
						$twoPassHash = hash('sha512', $row["user_password"]);

						$host = $GLOBALS['c_domain'];

						setcookie($GLOBALS['c_name'], $row['user_name'], time() + __COOKIES_EXPIRE_MAX__, $GLOBALS["c_subname"], $host, false, true);

						setcookie($GLOBALS['c_email'], $email, time() + __COOKIES_EXPIRE_MAX__, $GLOBALS["c_subname"], $host, false, true);

	                    # email+double_hashed_pass
						setcookie($GLOBALS['c_hash'], $email . $twoPassHash, time() + __COOKIES_EXPIRE_MAX__, $GLOBALS["c_subname"], $host, false, true);

						setcookie($GLOBALS['c_id'], $row['user_id'], time() + __COOKIES_EXPIRE_MAX__, $GLOBALS["c_subname"], $host, false, true);

						$GLOBALS['_isLogin'] = true;
			            $GLOBALS['_title'] = "Success!";
			            $GLOBALS['_message'] = "You are successfully logged in!";

					}
					else
					{
						$GLOBALS['_isLogin'] = false;
			            $GLOBALS['_title'] = "Error!";
			            $GLOBALS['_message'] = "E-mail of Password not matched!";

					}

				}
				else
				{
					$GLOBALS['_isLogin'] = false;
            		$GLOBALS['_title'] = "Error!";
            		$GLOBALS['_message'] = "You are not registered yet!";

				}
			}
		}
	}


	loginNow();

	$data = array(
		"isLogin" => $_isLogin,
		"title" => $_title,
		"message" => $_message
		);

	echo json_encode($data);

	exit();

}

?>

<?php

include "basic_structure/header.php";
include "basic_structure/navbar.php"

?>

<div class="alert"></div>

<form class="ts-form" method="post" action="<?=htmlspecialchars($_SERVER['PHP_SELF']);?>">

	<label for="email">E-mail:</label>
	<input id="email" type="email" name="email">

	<label for="pword">Password:</label>
	<input id="pword" type="password" name="pword">

	<br>

	<input type="submit" value="Login">
</form>


<script type="text/javascript">

	$(function(){


		$("form").submit(function (event) {
			event.preventDefault();

            // Disable inputs
            $('input').prop("disabled", true);
            $('input[type="submit"]').prop("disabled", true);

            $uname = $("#email").val();
            $pword = $("#pword").val();

            if ($uname == "" || $pword == "") {
            	$(".alert").fadeIn();
            	$(".alert").html('<strong>Error!</strong> Fill all fields!');
                // Enable inputs
                $('input').prop("disabled", false);
                $('input[type="submit"]').prop("disabled", false);
                return false;
            }

            $options = {
            	email: $uname,
            	pword: $pword
            };


            $.post($(this).attr('action'), $options, function (data) {

            	console.log(data);

            	$obj = jQuery.parseJSON(data);

            	if ($obj.isLogin == true) {

            		$(".alert").html($obj.message + 'You will auto redirect to home page. Otherwise you can click <a href="index.php">here</a> to go home.');

            		$(".ts-form").fadeOut();

                    // JS function to redirect
                    setTimeout(function () {
                    	window.location = "index.php";
                    }, 5000);
                }
                else {
                	$(".alert").fadeIn();
                	$(".alert").html('<strong>' + $obj.title + '</strong> ' + $obj.message);

                    // Enable inputs
                    $('input').prop("disabled", false);
                    $('input[type="submit"]').prop("disabled", false);
                }

            });


        });


	});

</script>

<?php

include "basic_structure/footer.php";

?>