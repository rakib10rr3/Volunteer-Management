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

		$member_phone = validateInput(isset($_POST['member_phone']) ? $_POST['member_phone'] : '');
		$member_type = validateInput(isset($_POST['member_type']) ? $_POST['member_type'] : '');
		$member_age = validateInput(isset($_POST['member_age']) ? $_POST['member_age'] : '');
		$gender = validateInput(isset($_POST['gender']) ? $_POST['gender'] : '');
		$member_interest = validateInput(isset($_POST['member_interest']) ? $_POST['member_interest'] : '');

		if ($name == '' || $email == '' || $pword == '' || $re_pword == ''
			 || $re_pword == '' || $re_pword == '' || $re_pword == '' || $re_pword == '' || $re_pword == '') {

			$GLOBALS['_isSuccess'] = false;
			$GLOBALS['_title'] = "Error!";
			$GLOBALS['_message'] = "Fill all fields!";

		} else if ($pword != $re_pword) {

			$GLOBALS['_isSuccess'] = false;
			$GLOBALS['_title'] = "Error!";
			$GLOBALS['_message'] = "Password Mismatch!";

		} else if (intval($member_age) < 13) {

			$GLOBALS['_isSuccess'] = false;
			$GLOBALS['_title'] = "Error!";
			$GLOBALS['_message'] = "Minimum age is 13!";

		} else {

			$user = new User();

			if($user->isUserExistByEmail($email) === false)
			{
				$pass_hash = password_hash($pword, PASSWORD_BCRYPT, ['cost' => 10]);

				$user->setEmail($email);
				$user->setName($name);
				$user->setPassword($pass_hash);

				$result = $user->add();

				if($result !== false)
				{

					$new_user_id = $result;

					$member = new Member();

					$member->setMemberId($new_user_id);
			        $member->setMemberName($name);
			        $member->setMemberEmail($email);
			        $member->setMemberGrp(null);
			        $member->setMemberPhone($member_phone);
			        $member->setMemberType($member_type);
			        $member->setMemberAge($member_age);
			        $member->setMemberGender($gender);
			        $member->setMemberInterest($member_interest);

			        $result2 = $member->add();

			        if ($result2 !== false) {

						$GLOBALS['_isSuccess'] = true;
						$GLOBALS['_title'] = "Success!";
						$GLOBALS['_message'] = "You are successfully registered!";

			        } else {

			        	$GLOBALS['_isSuccess'] = true;
						$GLOBALS['_title'] = "Success!";
						$GLOBALS['_message'] = "You are registered with an error! Contact with Team Shunno!";

			        }

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

	<hr>

	<p>
		<label for="member_phone">Phone</label>
		<input class="w3-input w3-border w3-light-grey" id="member_phone" type="text" name="member_phone">
	</p>

	<p>
		<label for="member_type">Type</label>
		<input class="w3-radio" type="radio" name="member_type" value="permanent" required>
		<label>Permanent</label>

		<input class="w3-radio" type="radio" name="member_type" value="temporary" required>
		<label>Temporary</label>
	</p>

	<p>
		<label for="member_age">Age</label>
		<input class="w3-input w3-border w3-light-grey" id="member_age" type="number" name="member_age" required>
	</p>

	<p>
		<label for="member_gender">Gender</label>
		<input class="w3-radio" type="radio" name="gender" value="male" required>
		<label>Male</label>

		<input class="w3-radio" type="radio" name="gender" value="female" required>
		<label>Female</label>
	</p>

	<p>
		<label for="member_interest">Interests</label>
		<input class="w3-input w3-border w3-light-grey" id="member_interest" type="text" name="member_interest" required>
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

            $member_phone = $("#member_phone").val();
            $member_type = $("input[name='member_type']:checked").val();
            $member_age = $("#member_age").val();
            $gender = $("input[name='gender']:checked").val();
            $member_interest = $("#member_interest").val();

            // console.log($member_phone);
            // console.log($member_type);
            // console.log($member_age);
            // console.log($gender);
            // console.log($member_interest);

            // return false;

            if ($uname == "" || $email == "" || $pword1 == "" || $pword2 == ""
            	|| $member_phone == "" || $member_type == "" || $member_age == "" || $gender == "" || $member_interest == "") {

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

            if (parseInt($member_age) < 13) {
            	$(".ts-alert").addClass("w3-red");
            	$(".ts-alert p").html('<strong>Error!</strong> Minimum registration age is 13!');
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
            	pwordagain: $pword2,

            	member_phone: $member_phone,
            	member_type: $member_type,
            	member_age: $member_age,
            	gender: $gender,
            	member_interest: $member_interest
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

            	    $('html, body').animate({
					        scrollTop: $(".ts-alert").offset().top
					    }, 2000);

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