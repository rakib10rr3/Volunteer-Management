<?php
/**
 * Created by PhpStorm.
 * User: Rashid Al Shafee
 * Date: 7/6/2017
 * Time: 4:40 PM
 */
include "basic_structure/header.php";
include "basic_structure/navbar.php";
if(isUserLoggedIn()==false)
{?>
    <p>You are not logged in pls login from <a href="login.php">here</a> </p>
    <?php
    exit();
}
$u_id = $_COOKIE[$GLOBALS['c_id']];
$result = getGrpById($u_id);
if($result->num_rows > 0)
{
    while ($row = $result->fetch_assoc()) {
        $result_grpInfo = getGrpDetailsByGrpId($row['vm_group_id']);
        if($result_grpInfo ->num_rows > 0)
        {
            while ($row = $result_grpInfo ->fetch_assoc())
            {
                $group_name = $row['v_group_name'];
                $group_id = $row['v_group_id'];
                $group_place = $row['v_group_place'];
                $group_desc = $row['v_group_description'];
                $group_leader_name = $row['v_group_leader_id'];
                $group_member_number = $row['v_group_member_number'];
                echo "<tr>";
                echo "<td>{$group_name}</td>";
                echo "<td>{$group_place}</td>";
                echo "<td>{$group_desc}</td>";
                echo "<td>{$group_leader_name} </td>";
                echo "<td>{$group_member_number} </td>";
                echo "<td> <a class='navbar-link' href='group_details.php?group_id=$group_id'>View Details </a> </td>";
                echo "<br><br>";
            }
        }
    }
}
?>


<?php
include "basic_structure/footer.php";
?>
