<?php
/**
 * Created by PhpStorm.
 * User: Me
 * Date: 7/5/2017
 * Time: 7:04 PM
 */
include "basic_structure/header.php";
include "basic_structure/navbar.php";
if(isUserLoggedIn()==false)
{?>
    <p>You are not logged in pls login from <a href="login.php">here</a> </p>
    <?php
    exit();
}

    if(isset($_GET['show_member_of'])) {
    $v_group_id=$_GET['show_member_of'];
    show_member_list($v_group_id);

}
else
{
    echo "go away -_- ";
}
?>

<div class="w3-panel w3-blue w3-round-xlarge">

    <h3>International Islamic University,Chittagong (Volunteer_group)[Hard_coded for Development ] </h3>
</div>
<div class="w3-sidebar w3-bar-block w3-card-2 w3-animate-right" style="display:none;right:0;" id="rightMenu">
    <button onclick="closeRightMenu()" class="w3-bar-item w3-button w3-large">Close &times;</button>


    <a href="show_member.php?show_member_of=1" class="w3-bar-item w3-button" id="show_member">View All Member</a>
    <a href="show_group_info.php?group_id=1" class="w3-bar-item w3-button" id="show_group_info">View Group Info </a>

    <a href="#" class="w3-bar-item w3-button" id="view_join_request">View Any join Request</a>
    <a href="#" class="w3-bar-item w3-button">Call For Help</a>

    <a href="#" class="w3-bar-item w3-button">Add Donation Poll</a>
    <a href="#" class="w3-bar-item w3-button">Distance Travel Poll</a>
    <a href="#" class="w3-bar-item w3-button">Available Poll</a>
</div>

<div class="w3-blue-gray">
    <button class="w3-button w3-teal w3-xlarge w3-right" onclick="openRightMenu()">&#9776;</button>
</div>


<div class="w3-container" id="show_content">



</div>

<script>
    function openLeftMenu() {
        document.getElementById("leftMenu").style.display = "block";
    }
    function closeLeftMenu() {
        document.getElementById("leftMenu").style.display = "none";
    }

    function openRightMenu() {
        document.getElementById("rightMenu").style.display = "block";
    }
    function closeRightMenu() {
        document.getElementById("rightMenu").style.display = "none";
    }


    /**
     *  here i have manually passed the parameter as the id
     *
     */


    /*
     $('#show_member').click(function(){
     $("#show_content").load("my_group_pages/show_member.php?show_member_of=1");
     return false;
     });

     $('#show_group_info').click(function(){
     $("#show_content").load("my_group_pages/show_group_info.php?group_id=1");
     return false;
     });*/

</script>
<?php











if((isset($_GET['del_member_id'])) && (isset($_GET['group_id'])))
{
    $member_id=$_GET['del_member_id'];
    $group_id=$_GET['group_id'];

    $member_obj=new Member();
    $result=$member_obj->remove_member_from_group($member_id,$group_id);
    if($result)
    {
        echo" successfully deleted the id ";
        header("Location: my_group.php?group_id=$group_id");
    }
    else
    {
        echo '<h3>Couldnt delete this member sorry</h3>';
    }
}

function show_member_list($v_group_id)
{

    //echo $v_group_id;
    $result = get_group_member_list($v_group_id);

    ?>
    <table class="w3-table w3-striped">
        <thead>
        <tr>
            <th> Name</th>
            <th> Member Type</th>
            <th> Action </th>
        </tr>
        </thead>
        <tbody>

    <?php

    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $vm_member_id = $row['vm_member_list_id'];
            $vm_member_name = $row['vm_member_name'];
            $vm_member_email = $row['vm_member_email'];
            $vm_member_phone = $row['vm_member_phone'];
            $vm_member_type = $row['vm_member_type'];
            echo "<tr>";
            echo "<td> <a href='profile.php?id=$vm_member_id'>$vm_member_name </a></td> ";
            echo "<td> $vm_member_type </td>";
            echo "<td>  <a href='show_member.php?del_member_id=$vm_member_id&group_id=$v_group_id'>Remove </a> </td>";
            echo "</tr>";
        }
    } else {
        echo "Sorry couldnt find this group_member list ";
    }
}
function get_group_member_list($grp_id)
{
    $db=new db_util();
    $query_string="SELECT * FROM vm_member_list WHERE vm_group_id=$grp_id";
    $result=$db->query($query_string);
    return $result;
}

function get_this_group($grp_id)
{
    $db=new db_util();
    $query_string="SELECT * FROM vm_group WHERE v_group_id=$grp_id";
    $result=$db->query($query_string);
    return $result;
}

?>

    <?php
    include "basic_structure/footer.php";
    ?>

