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
{
    ?>

    <div class="w3-panel w3-red w3-display-container ts-alert">
        <p>You are not logged in! Please login from <a href="login.php">here</a>.</p>
    </div>

    <script type="text/javascript">
        // JS function to redirect
        setTimeout(function () {
            window.location = "login.php";
        }, 5000);
    </script>

    <?php

} else {


    if(isset($_GET['group_id'])){

        $grpId = validateInput($_GET['group_id']);
        $u_id = $_COOKIE[$GLOBALS['c_id']];

        $member = new Member();

        $member->setMemberID($u_id);
        $member->setMemberGrp($grpId);

        $result2 = $member->updateGroupId();

        if($result2 !== false)
        {
    ?>

    <div class="w3-panel w3-green w3-display-container ts-alert">
        <p>You are now successfully member of that group!</p>
        <p>You will be auto redirected to the group page. 
        Otherwise you can click <a href="group_details.php?group_id=<?=$grpId?>">here</a>.</p>
    </div>

    <script type="text/javascript">
        // JS function to redirect
        setTimeout(function () {
            window.location = "group_details.php?group_id=<?=$grpId?>";
        }, 5000);
    </script>

    <?php
        }
    }
    



}

?>

<?php

include "basic_structure/footer.php";
//echo "<td> <a class='navbar-link' href='join_group.php?group_id=$v_group_id'>Join group </a> </td>";
?>
