<?php
/**
 * Created by PhpStorm.
 * User: Rashid Al Shafee
 * Date: 7/5/2017
 * Time: 2:05 AM
 */

include "basic_structure/header.php";
include "basic_structure/navbar.php";
if(isUserLoggedIn()==false)
{?>
    <p>You are not logged in pls login from <a href="login.php">here</a> </p>
    <?php
    exit();
}
if(isset($_GET['group_id'])){
    $grpId = $_GET['group_id'];
    //$u_id = $_GET['u_id'];
}
if (($_SERVER['REQUEST_METHOD'] == 'POST')){

    $memberId = validateInput(isset($_POST['mem_id']) ? $_POST['mem_id'] : '');
    $memberName = validateInput(isset($_POST['member_name']) ? $_POST['member_name'] : '');
    $memberEmail = validateInput(isset($_POST['member_email']) ? $_POST['member_email'] : '');
    $memberGrp = validateInput(isset($_POST['mem_group_id']) ? $_POST['mem_group_id'] : '');
    $memberPhone = validateInput(isset($_POST['member_phone']) ? $_POST['member_phone'] : '');
    $memberType = (isset($_POST['mem_type']) ? $_POST['mem_type'] : '');
    $memberInterest = (isset($_POST['mem_int']) ? $_POST['mem_int'] : '');

    $mem = new Member();
    $mem->setMemberID($memberId);
    $mem->setMemberName($memberName);
    $mem->setMemberEmail($memberEmail);
    $mem->setMemberGrp($memberGrp);
    $mem->setMemberPhone($memberPhone);
    $mem->setMemberType($memberType);
    $mem->setMemberInterest($memberInterest);
    $result = $mem->add();
    if ($result !== false) {
        echo "member added";
        //echo $memberPhone;
         echo $memberGrp;
        exit();
    }

    exit("Something Wrong!");

}
?>

<?php

?>
<form method="post" action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>">
    <p>Name: </p>
    <input type="text" name="member_name">
    <p>Email: </p>
    <?php
    $u_id = $_COOKIE[$GLOBALS['c_id']];
    $db = new db_util();
    $sql = "SELECT * FROM vm_users WHERE user_id=$u_id";
    $result = $db->query($sql);
    if($result->num_rows > 0)
    {
        while ($row = $result->fetch_assoc()) {
            ?>

            <input type="text" value="<?php echo $row['user_email'] ?>" name="member_email">
            <input type="hidden" value="<?php echo $u_id?>" name="mem_id">
            <?php
        }
    }
    ?>
    <p>Phone: </p>
    <input type="text" name="member_phone">
    <input type="hidden" name="mem_group_id" value="<?php echo $grpId?>">
    <br>
    <p>Type: </p>
    <input type="radio" name="mem_type" value="permanent"> Permanent
    <input type="radio" name="mem_type" value="temporary"> Temporary
    <p>Interest: </p>
    <?php
    $db = new db_util();

    $sql = "SELECT * FROM vm_group WHERE v_group_id = $grpId";

    $result = $db->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            ?>
            <p><?php $datam = explode(",", $row['v_group_services']);
            $datam_len = count($datam);
            for ($x = 0; $x < $datam_len; $x++) {
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
//echo "<td> <a class='navbar-link' href='join_group.php?group_id=$v_group_id'>Join group </a> </td>";
?>
