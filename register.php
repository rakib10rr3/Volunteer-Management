<?php
/**
 * Register Page
 */


if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	include 'func.php';

	/**
	 * Result values
	 */
	$_isSuccess = false;
	$_title = "Error!";
	$_message = "Something Wrong!";

	function registerNow()
	{
		$name = validateInput(isset($_POST['uname']) ? $_POST['uname'] : '');
		$email = strtolower(validateInput(isset($_POST['email']) ? $_POST['email'] : ''));
		$pword = isset($_POST['pword']) ? $_POST['pword'] : '';
		$re_pword = isset($_POST['pwordagain']) ? $_POST['pwordagain'] : '';

		if ($name == '' || $email == '' || $pword == '' || $re_pword == '') {

			$GLOBALS['_isSuccess'] = false;
            $GLOBALS['_title'] = "Error!";
            $GLOBALS['_message'] = "Fill all fields!";
			         
		} elseif ($pword != $re_pword) {

			$GLOBALS['_isSuccess'] = false;
            $GLOBALS['_title'] = "Error!";
            $GLOBALS['_message'] = "Password Mismatch!";

		} else {

			$user = new User();

			if($user->isUserExistByEmail($email) === false)
			{
				$pass_hash = password_hash($pword, PASSWORD_BCRYPT, ['cost' => 10]);

				$user->setEmail($email);
				$user->setName($name);
				$user->setPassword($pass_hash);

				$result = $user->add();

				if($result!== false)
				{
					$GLOBALS['_isSuccess'] = true;
		            $GLOBALS['_title'] = "Success!";
		            $GLOBALS['_message'] = "You are successfully registered!";
				}
			}
			else
			{
				$GLOBALS['_isSuccess'] = false;
	            $GLOBALS['_title'] = "Error!";
	            $GLOBALS['_message'] = "User already exist!";
			}
		}
	}

	registerNow();

	$data = array(
		"isSuccess" => $_isSuccess,
		"title" => $_title,
		"message" => $_message
		);

	echo json_encode($data);

	exit();

}

?>

<?php

include "basic_structure/header.php";
include "basic_structure/navbar.php";

?>
<div class="w3-panel w3-red w3-display-container ts-alert ts-alert-hide">
	<span onclick="this.parentElement.style.display='none'"
  class="w3-button w3-large w3-display-topright">&times;</span>
  	<p></p>
</div>

<form class="w3-container w3-card-4 ts-form ts-form-box" method="post" action="<?=htmlspecialchars($_SERVER['PHP_SELF']);?>">
	<p>
	<label for="uname">Name</label>
	<input class="w3-input w3-border w3-light-grey" id="uname" type="text" name="uname" required>
	</p>
	<p>
	<label for="email">E-mail</label>
	<input class="w3-input w3-border w3-light-grey" id="email" type="email" name="email" required>
	</p>
	<p>
	<label for="pword1">Password</label>
	<input class="w3-input w3-border w3-light-grey" id="pword1" type="password" name="pword" required>
	</p>
	<p>
	<label for="pword2">Password (Again)</label>
	<input class="w3-input w3-border w3-light-grey" id="pword2" type="password" name="pwordagain" required>
	</p>
	<p>
	<input class="w3-btn w3-blue-grey" type="submit" value="Submit">
	</p>
</form>

<script type="text/javascript">

	$(function(){


		$("form").submit(function (event) {
			event.preventDefault();

            // Disable inputs
            $('input').prop("disabled", true);
            $('input[type="submit"]').prop("disabled", true);

            $uname = $("#uname").val();
            $email = $("#email").val();
            $pword1 = $("#pword1").val();
            $pword2 = $("#pword2").val();

            console.log("Email: "+$email);

            if ($uname == "" || $email == "" || $pword1 == "" || $pword2 == "") {
            	$(".ts-alert").addClass("w3-red");
            	$(".ts-alert p").html('<strong>Error!</strong> Fill all fields!');
            	$(".ts-alert").fadeIn();

                // Enable inputs
                $('input').prop("disabled", false);
                $('input[type="submit"]').prop("disabled", false);
                return false;
            }

            if ($pword1 != $pword2) {
            	$(".ts-alert").addClass("w3-red");
            	$(".ts-alert p").html('<strong>Error!</strong> Password mismatch!');
            	$(".ts-alert").fadeIn();

                // Enable inputs
                $('input').prop("disabled", false);
                $('input[type="submit"]').prop("disabled", false);
                return false;
            }

            $options = {
            	uname: $uname,
            	email: $email,
            	pword: $pword1,
            	pwordagain: $pword2
            };


            $.post($(this).attr('action'), $options, function (data) {

            	console.log(data);

            	$obj = jQuery.parseJSON(data);

            	if ($obj.isSuccess == true) {
					$(".ts-alert").removeClass("w3-red");
            		$(".ts-alert").addClass("w3-green");
            		$(".ts-alert p").html($obj.message + 'You will auto redirect to login page. Otherwise you can click <a href="login.php">here</a> to login.');

            		$(".ts-form").fadeOut();
            		$(".ts-alert").fadeIn();

                    // JS function to redirect
                    setTimeout(function () {
                    	window.location = "login.php";
                    }, 5000);
                }
                else {
                	$(".ts-alert").addClass("w3-red");
                	$(".ts-alert p").html('<strong>' + $obj.title + '</strong> ' + $obj.message);
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