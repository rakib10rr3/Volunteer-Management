<?php
/**
 * Group Create Page
 */

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    include_once 'func.php';


    /**
     * Result values
     */
    $_isSuccess = false;
    $_title = "Error!";
    $_message = "Something Wrong!";


    function createGroup()
    {

        $grpName = validateInput(isset($_POST['grp_name']) ? $_POST['grp_name'] : '');
        $grpPlace = validateInput(isset($_POST['grp_place']) ? $_POST['grp_place'] : '');
        $grpDescription = validateInput(isset($_POST['grp_desc']) ? $_POST['grp_desc'] : '');
        $grpService = isset($_POST['grp_services']) ? $_POST['grp_services'] : '';
        $grpLeader = validateInput(isset($_POST['grp_leader']) ? $_POST['grp_leader'] : '');

// echo $grpService;

        if ($grpName == '' || $grpPlace == '' || $grpDescription == '' || $grpService == '') {

            $GLOBALS['_isSuccess'] = false;
            $GLOBALS['_title'] = "Error!";
            $GLOBALS['_message'] = "Fill all fields!";

        } else {
            $grp = new Group();

            $grp->setGrpName($grpName);
            $grp->setGrpPlace($grpPlace);
            $grp->setGrpDescription($grpDescription);
            $grp->setGrpServices($grpService);
            $grp->setGrpLeader($grpLeader);


            $result = $grp->add();

            if ($result !== false) {

                $member = new Member();

                $member->setMemberID($grpLeader);
                $member->setMemberGrp($result);
                $member->setMemberType("permanent");

                $result2 = $member->updateGroupIdForAdmin();

                if($result2 !== false)
                {
                    $GLOBALS['_isSuccess'] = true;
                    $GLOBALS['_title'] = "Success!";
                    $GLOBALS['_message'] = "The Group successfully registered!";
                }
            }

        }

    }

    createGroup();

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
        <p>You are not logged in! Please login from <a href="login.php">here</a>.</p>
    </div>
    
    <?php

    exit();
}


?>

<div class="w3-panel w3-red w3-display-container ts-alert ts-alert-hide">
    <span onclick="this.parentElement.style.display='none'"
    class="w3-button w3-large w3-display-topright">&times;</span>
    <p></p>
</div>

<form class="w3-container w3-card-4 ts-form ts-form-box" method="post" action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>">
    <p>
        <label for="grp_name">Group Name</label>
        <input class="w3-input w3-border w3-light-grey" id="grp_name" type="text" name="grp_name">
    </p>

    <!-- <p>
    <label for="grp_place">Group Place</label>
    <input class="w3-input w3-border w3-light-grey" id="grp_place" type="text" name="grp_place">
</p> -->

<p>
    <label for="division">Group Place</label>
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
    <select id="district" class="w3-select w3-border" name="grp_place" disabled required>
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
    <label for="grp_desc">Group Description</label>
    <textarea class="w3-input w3-border w3-light-grey" id="grp_desc" name="grp_desc" cols="30" rows="10"></textarea>
</p>

<p>
    <label>Group Services:</label>
</p>

<?php

$db = new db_util();

$sql = "SELECT * FROM vm_services";

$result = $db->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc())  { 
        ?>
        <p>
            <input class="w3-check grp_services" type="checkbox" name="grp_services[]" value="<?php echo $row['vm_service_name'];?>">
            <label><?php echo $row['vm_service_name'];?></label>
        </p>
        <?php 

    } 
}

$u_id = $_COOKIE[$GLOBALS['c_id']];

?>

<input type="hidden" id="grp_leader" name="grp_leader" value="<?=$u_id?>">

<p>
    <input class="w3-btn w3-blue-grey" type="submit" value="Create">
</p>

</form>

<script type="text/javascript">

    $(function(){


        $("form").submit(function (event) {
            event.preventDefault();

            // Disable inputs
            $('input').prop("disabled", true);
            $('input[type="submit"]').prop("disabled", true);

            $grp_name = $("#grp_name").val();
            $grp_place = $("#district").val();
            $grp_desc = $("#grp_desc").val();
            $grp_leader = $("#grp_leader").val();

            // $grp_services = $(".grp_services").val();

            var checked = [];
            $("input[name='grp_services[]']:checked").each(function ()
            {
                checked.push($(this).val());
            });

             console.log($grp_name);
             console.log($grp_place);
             console.log($grp_desc);
             console.log($grp_leader);

            // return false;

            if ($grp_name == "" || $grp_place == "" || $grp_desc == "") {

                $(".ts-alert").addClass("w3-red");
                $(".ts-alert p").html('<strong>Error!</strong> Fill all fields!');
                $(".ts-alert").fadeIn();

                // Enable inputs
                $('input').prop("disabled", false);
                $('input[type="submit"]').prop("disabled", false);
                return false;
            }

            /*
                    $grpName = validateInput(isset($_POST['grp_name']) ? $_POST['grp_name'] : '');
        $grpPlace = validateInput(isset($_POST['grp_place']) ? $_POST['grp_place'] : '');
        $grpDescription = validateInput(isset($_POST['grp_desc']) ? $_POST['grp_desc'] : '');
        $grpService = validateInput(isset($_POST['grp_services']) ? $_POST['grp_services'] : '');
        $grpLeader = validateInput(isset($_POST['grp_leader']) ? $_POST['grp_leader'] : '');


             */

            $options = {
                grp_name: $grp_name,
                grp_place: $grp_place,
                grp_desc: $grp_desc,
                grp_services: checked,
                grp_leader: $grp_leader
            };


            $.post($(this).attr('action'), $options, function (data) {

                console.log(data);

                $obj = jQuery.parseJSON(data);

                if ($obj.isSuccess == true) {
                    $(".ts-alert").removeClass("w3-red");
                    $(".ts-alert").addClass("w3-green");
                    $(".ts-alert p").html($obj.message + 'You will auto redirect to Home page. Otherwise you can click <a href="index.php">here</a>.');

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