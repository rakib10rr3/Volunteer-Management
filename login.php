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

<div class="w3-panel w3-red w3-display-container ts-alert ts-alert-hide">
	<span onclick="this.parentElement.style.display='none'"
  class="w3-button w3-large w3-display-topright">&times;</span>
  	<p></p>
</div>

<form class="w3-container w3-card-4 ts-form ts-form-box" method="post" action="<?=htmlspecialchars($_SERVER['PHP_SELF']);?>">

	<p>
	<label for="email">E-mail</label>
	<input class="w3-input w3-border w3-light-grey" id="email" type="email" name="email">
	</p>
	<p>
	<label for="pword">Password</label>
	<input class="w3-input w3-border w3-light-grey" id="pword" type="password" name="pword">
	</p>
	<p>
	<input class="w3-btn w3-blue-grey" type="submit" value="Login">
	</p>
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
            	$(".ts-alert").addClass("w3-red");
            	$(".ts-alert p").html('<strong>Error!</strong> Fill all fields!');
            	$(".ts-alert").fadeIn();

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
					$(".ts-alert").removeClass("w3-red");
            		$(".ts-alert").addClass("w3-green");
            		$(".ts-alert p").html($obj.message + 'You will auto redirect to home page. Otherwise you can click <a href="index.php">here</a> to go home.');

            		$(".ts-form").fadeOut();
            		$(".ts-alert").fadeIn();

                    // JS function to redirect
                    setTimeout(function () {
                    	window.location = "index.php";
                    }, 5000);
                }
                else {
                	$(".ts-alert p").html('<strong>' + $obj.title + '</strong> ' + $obj.message);
                	$(".ts-alert").addClass("w3-red");
                	$(".ts-alert").fadeIn();

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