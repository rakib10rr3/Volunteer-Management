<?php
/**
 * Created by PhpStorm.
 * User: Rashid Al Shafee
 * Date: 7/5/2017
 * Time: 2:05 AM
 */
/**
 * Group Create Page
 */


if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    include 'func.php';

    $memberName = validateInput(isset($_POST['member_name']) ? $_POST['member_name'] : '');
    $memberEmail = validateInput(isset($_POST['member_email']) ? $_POST['member_email'] : '');
   // $memberGrp = validateInput(isset($_POST['member_grp']) ? $_POST['member_grp'] : '');
    $memberPhone = validateInput( isset($_POST['member_phone']) ? $_POST['member_phone'] : '');
    $memberType = ( isset($_POST['mem_type']) ? $_POST['mem_type'] : '');
    $memberInterest = ( isset($_POST['mem_int']) ? $_POST['mem_int'] : '');



        $mem = new Member();
        $mem->setMemberName($memberName);
        $mem->setMemberEmail($memberEmail);
       // $mem->setMemberGrp($memberGrp);
        $mem->setMemberPhone($memberPhone);
        $mem->setMemberType($memberType);
        $mem->setMemberInterest($memberInterest);
        $result = $mem->add();
        if ($result !== false) {
            echo "Group Successfully created!";
            //echo $memberPhone;
           // echo $memberEmail;
            exit();
        }

    exit("Something Wrong!");

}
?>

<?php

include "basic_structure/header.php";
include "basic_structure/navbar.php";

?>

<form method="post" action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>">
    <p>Name: </p>
    <input type="text" name="member_name">
    <p>Email: </p>
    <input type="text" name="member_email">
    <p>Phone: </p>
    <input type="text" name="member_phone">
    <p>Type: </p>
    <input type="radio" name="mem_type" value="permanent"> Permanent
    <input type="radio" name="mem_type" value="temporary"> Temporary
    <p>Interest: </p>
    <?php

    $db = new db_util();

    $sql = "SELECT * FROM vm_group WHERE v_group_id = 1";

    $result = $db->query($sql);

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc())  {
            ?>
            <p><?php $datam=explode(",",$row['v_group_services']);
                $datam_len=count($datam);
                for($x=0;$x<$datam_len;$x++) {
                    ?>
                    <input class="w3-check" type="checkbox" name="mem_int[]" value="<?php echo $datam[$x]; ?>">
                    <label><?php echo $datam[$x]; ?></label>
                    </p>
                    <?php
                }
        }
    }

    ?>

    <br>
    <input type="submit" value="Submit">
</form>

<?php

include "basic_structure/footer.php";

?>
