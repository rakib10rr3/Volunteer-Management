<?php

/**
 * Leader form fill up korlo 

Eita ekta disaster hisebe dhoree index e recent 'call for help '  namee show korabo. Jatee shobai dekhte paree and respond korte paree . Form er j place gula dibe ...oi place er leader der amra mail pathabo respond korar jonne 

Ekhon j leader call for help disee...itar group e oi disaster ta auto fix hoi jabe. ..and onno kun leader Jodi index theke response Kore itar  Tai...taile itar group eo oita fix hoi jabe
 */

/**
 * Flood , ghurnijor, pahar dhosh, eigulai mathai ase
 */

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	include 'func.php';

/*
    vm_disaster_id int not null auto_increment
        primary key,
    vm_disaster_name varchar(256) not null,
    vm_disaster_locations  varchar(256) not null,
    vm_disaster_type int not null,
    vm_disaster_start DATETIME not null,
    vm_disaster_expire  DATETIME not null
*/

 /**
	 * Result values
	 */
 $_isSuccess = false;
 $_title = "Error!";
 $_message = "Something Wrong!";

 function registerNow()
 {
 	$name = validateInput(isset($_POST['name']) ? $_POST['name'] : '');
 	$type = validateInput(isset($_POST['type']) ? $_POST['type'] : '');
 	$location = validateInput(isset($_POST['district']) ? $_POST['district'] : '');
 	$start = validateInput(isset($_POST['start_date']) ? $_POST['start_date'] : '');
 	$expire = validateInput(isset($_POST['expire_date']) ? $_POST['expire_date'] : '');

 	/**
 	 * The date comes this format: YYYY-MM-DD
 	 * It's ISO 8601 Standard.
 	 * This is supported both html, jquery, mysql and php.. :)
 	 */

 	if ($name == '' || $type == '' || $location == '' || $start == '' || $expire == '') {

 		$GLOBALS['_isSuccess'] = false;
 		$GLOBALS['_title'] = "Error!";
 		$GLOBALS['_message'] = "Fill all fields!";

 	} else if ($type == "0") {
 		
 		$GLOBALS['_isSuccess'] = false;
 		$GLOBALS['_title'] = "Error!";
 		$GLOBALS['_message'] = "Select a valid type!";

 	} else if (strtotime($start) > strtotime($expire)){

 		$GLOBALS['_isSuccess'] = false;
 		$GLOBALS['_title'] = "Error!";
 		$GLOBALS['_message'] = "Fix the Dates!";

 	} else {

 		$disaster = new Disaster();

		$disaster->setName($name);
		$disaster->setType($type);
		$disaster->setLocation($location);
		$disaster->setStart($start);
		$disaster->setExpire($expire);

		$result = $disaster->add();

		if($result!== false)
		{
			$GLOBALS['_isSuccess'] = true;
			$GLOBALS['_title'] = "Success!";
			$GLOBALS['_message'] = "You successfully Called for Help!";
		}
 	}
 }

if(isUserLoggedIn()) {
	registerNow();
}

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


if(isUserLoggedIn()==false)
{
	?>

	<div class="w3-panel w3-red w3-display-container ts-alert">
		<p>You are not logged in. Please login from <a href="login.php">here</a>.</p>
	</div>

	<?php

} else {


?>

<div class="w3-panel w3-red w3-display-container ts-alert ts-alert-hide">
	<span onclick="this.parentElement.style.display='none'"
	class="w3-button w3-large w3-display-topright">&times;</span>
	<p></p>
</div>

<!-- 
    vm_digester_id int not null auto_increment
        primary key,
    vm_digester_name varchar(256) not null,
    vm_digester_locations  varchar(256) not null,
    vm_digester_type int not null,
    vm_digester_start DATETIME not null,
    vm_digester_expire  DATETIME not null
-->

<form class="w3-container w3-card-4 ts-form ts-form-box" method="post" action="<?=htmlspecialchars($_SERVER['PHP_SELF']);?>">

	<p>
		<label for="name">Disaster Title</label>
		<input class="w3-input w3-border w3-light-grey" id="name" type="text" name="name" required>
	</p>

	<p>
		<label for="type">Type</label>
		<select id="type" class="w3-select w3-border" name="type" required>
			<option value="0" selected>Choose Type</option>
			<option value="1">Flood</option>
			<option value="2">Cyclone</option>
			<option value="3">Hill collapse</option>
			<option value="4">Donation</option>
		</select>
	</p>

	<p>
		<label for="division">Location</label>
		<select id="division" class="w3-select w3-border" name="division" required>
			<option value="0" selected>Choose Division</option>
			<option value="1">Barisal</option>
			<option value="2">Chittagong</option>
			<option value="3">Dhaka</option>
			<option value="4">Khulna</option>
			<option value="5">Mymensingh</option>
			<option value="6">Rajshahi</option>
			<option value="7">Rangpur</option>
			<option value="8">Sylhet</option>
		</select>
	</p>
	<p>
		<select id="district" class="w3-select w3-border" name="district" disabled required>
		</select>
	</p>

	<script type="text/javascript">
		$(function(){

			$("#division").change(function(){

				var div_id = $("#division").val();

				console.log(div_id);

				if(div_id == "0")
				{
					var sel = $("#district");
					sel.empty();
					sel.prop("disabled", true);
				} else {

					$options = {
						type: "district",
						division_id: div_id
					};


					$.post("data.php", $options, function (data) {

						console.log(data);

						$obj = jQuery.parseJSON(data);

						if($obj.success == true) {

							var sel = $("#district");
							sel.empty();
							for (var i=0; i<$obj.data.length; i++) {
								sel.append('<option value="' + $obj.data[i].id + '">' + $obj.data[i].name + '</option>');
							}

							sel.prop("disabled", false);
						}

					});
				}

			});
			
		});
	</script>

	<p>
		<label for="name">Start</label>
		<input class="w3-input w3-border w3-light-grey" id="start_date" type="date" name="start_date" required>
	</p>

	<script type="text/javascript">
		$(function(){ 

			$("#start_date").change(function(){
				$('#expire_date').attr('value', $("#start_date").val());
			});

		});
	</script>

	<p>
		<label for="name">Expire</label>
		<input class="w3-input w3-border w3-light-grey" id="expire_date" type="date" name="expire_date" required>
	</p>

	<script type="text/javascript">
		$(function(){
			var today = new Date();
			var dd = today.getDate();
			var mm = today.getMonth()+1; //January is 0!

			var yyyy = today.getFullYear();
			if(dd<10){dd='0'+dd;} 
			if(mm<10){mm='0'+mm;} 

			today = yyyy+"-"+mm+"-"+dd;

			$('#start_date').attr('value', today);
			$('#expire_date').attr('value', today);
		});
	</script>

	<p>
		<input class="w3-btn w3-blue-grey" type="submit" value="Call For Help">
	</p>

</form>

<script type="text/javascript">

	$(function(){

		$("form").submit(function (event) {
			event.preventDefault();

            // Disable inputs
            $('input').prop("disabled", true);
            $('input[type="submit"]').prop("disabled", true);

            $name = $("#name").val();
            $type = $("#type").val();
            $district = $("#district").val();
            $start_date = $("#start_date").val();
            $expire_date = $("#expire_date").val();


            if ($name == "" || $type == "0" || $district == "" || $district == "0" || $start_date == "" || $expire_date == "") {
            	$(".ts-alert").addClass("w3-red");
            	$(".ts-alert p").html('<strong>Error!</strong> Fill all fields!');
            	$(".ts-alert").fadeIn();

                // Enable inputs
                $('input').prop("disabled", false);
                $('input[type="submit"]').prop("disabled", false);
                return false;
            }

            $options = {
            	name: $name,
            	type: $type,
            	district: $district,
            	start_date: $start_date,
            	expire_date: $expire_date
            };


            $.post($(this).attr('action'), $options, function (data) {

            	console.log(data);

            	$obj = jQuery.parseJSON(data);

            	if ($obj.isSuccess == true) {
            		$(".ts-alert").removeClass("w3-red");
            		$(".ts-alert").addClass("w3-green");
            		$(".ts-alert p").html($obj.message + ' You will be auto redirected to home page. Otherwise you can click <a href="index.php">here</a> to go home.');

            		$(".ts-form").fadeOut();
            		$(".ts-alert").fadeIn();

                    // JS function to redirect
                    setTimeout(function () {
                    	window.location = "index.php";
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

}

include "basic_structure/footer.php";

?>