<?php
/**
 * Group Create Page
 */
$id = $_GET["id"];
echo $id;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    include 'func.php';

    $memberName = validateInput(isset($_POST['member_name']) ? $_POST['member_name'] : '');
    //$memberEmail = validateInput(isset($_POST['member_email']) ? $_POST['member_email'] : '');
    $memberPhone = validateInput(isset($_POST['member_phone']) ? $_POST['member_phone'] : '');
    $memberType = validateInput(isset($_POST['member_type']) ? $_POST['member_type'] : '');
    $memberGender = validateInput(isset($_POST['member_gender']) ? $_POST['member_gender'] : '');
    $memberAge = validateInput(isset($_POST['member_age']) ? $_POST['member_age'] : '');
    //$grpService = isset($_POST['grp_services']) ? $_POST['grp_services'] : '';
    //$grpLeader = validateInput(isset($_POST['grp_leader']) ? $_POST['grp_leader'] : '');

    if ($memberName == '' || $memberPhone == '' || $memberType == '' || $memberGender == '' || $memberAge == '') {
        echo "Fill All fields!";
        exit();
    } else {

        $member = new Member();
        $member->setMemberName($memberName);
        $member->setMemberPhone($memberPhone);
        $member->setMemberType($memberType);
        $member->setMemberGender($memberGender);
        $member->setMemberAge($memberAge);


        echo $member->getMemberAge();

        $result = $member->update();

        if ($result !== false) {
            echo "Profile Successfully Updated!";
            exit();
        }

    }

    exit("Something Wrong!");

}

?>

<?php

include "basic_structure/header.php";
include "basic_structure/navbar.php"

?>

    <form class="w3-container w3-card-4 ts-form ts-form-box" method="post"
          action="<?= htmlspecialchars('updateHelper.php'); ?>">
        <?php

        $db = new db_util();

        $sql = "SELECT * FROM vm_member_list WHERE vm_member_list_id = ".$id;

        $result = $db->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $interests = explode(", ",$row['vm_member_interest']);
                ?>
                <p>
                    <label for="member_name">Name</label>
                    <input class="w3-input w3-border w3-light-grey" id="member_name" type="text" name="member_name" value="<?php echo $row['vm_member_name'];?>">
                </p>

                <p>
                    <label for="member_email">Email</label>
                    <input class="w3-input w3-border w3-light-grey" id="member_email" type="email" name="member_email" value="<?php echo $row['vm_member_email'];?>">
                </p>

                <p>
                    <label for="member_phone">Phone</label>
                    <input class="w3-input w3-border w3-light-grey" id="member_phone" type="text" name="member_phone" value="<?php echo $row['vm_member_phone'];?>">
                </p>

                <p>
                    <label for="member_type">Type</label>
                    <br>
                    <input class="w3-radio" id="member_type" type="radio" name="member_type" value="permanent" <?php if ("permanent" == $row['vm_member_type']) echo "checked"; ?>> Permanent
                    <input class="w3-radio" id="member_type" type="radio" name="member_type" value="temporary" <?php if ("temporary" == $row['vm_member_type']) echo "checked"; ?>> Temporary
                </p>

                <p>
                    <label for="member_age">Age</label>
                    <input class="w3-input w3-border w3-light-grey" id="member_age" type="number" name="member_age" value="<?php echo $row['vm_member_age'];?>">
                </p>

                <p>
                    <label for="member_gender">Gender</label>
                    <br>
                    <input class="w3-radio" id="member_gender" type="radio" name="member_gender" value="male"<?php if ("male" == $row['vm_member_gender']) echo "checked"; ?>> Male
                    <input class="w3-radio" id="member_gender" type="radio" name="member_gender" value="female" <?php  if ("female" == $row['vm_member_gender']) echo "checked"; ?>> Female
                </p>

                <?php } } ?>
        <input type="hidden" name="id" value="<?php echo $id ;?>">

        <p>
            <input class="w3-btn w3-blue-grey" type="submit" value="Submit">
            <input class="w3-btn w3-blue" type="button" value="Group Activities" name="group" id="group">
        </p>
    </form>

<?php

include "basic_structure/footer.php";

?>

<script>
    $(document).ready(function () {
        $("#group").click(function () {
        });
    });
</script>
