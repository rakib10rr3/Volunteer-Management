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
?>

<?php



/***
 * Functions of this page
 *
 * you will find a end tag like this when functions end
 * ----
 */

function get_this_group($grp_id)
{
    $db=new db_util();
    $query_string="SELECT * FROM vm_group WHERE v_group_id=$grp_id";
    $result=$db->query($query_string);
    return $result;
}
function get_group_member_list($grp_id)
{
    $db=new db_util();
    $query_string="SELECT * FROM vm_member_list WHERE vm_group_id=$grp_id";
    $result=$db->query($query_string);
    return $result;
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


function show_group_info($v_group_id,$v_group_name,$v_group_place,$v_group_description,$v_group_services,$v_group_member_number,$v_group_leader_id)
{

    echo '<div class="w3-container"> 
            <div class="w3-card-4" style="width:50%";> 
            <header class="w3-container w3-blue">
               <h1>'. $v_group_name.'</h1>
            </header>
            <div class="w3-container">
                <ul class="list-group">
                    <li class="list-group-item">.Place: '.$v_group_place .'</li>
                    <li class="list-group-item">Description :'.$v_group_description .'</li>
                    <li class="list-group-item">leader_id: '.$v_group_leader_id .'</li>
                    <li class="list-group-item">Total Member :'.$v_group_member_number .'</li>
                    <li class="list-group-item">Offered Services :'.$v_group_services .'</li>
                </ul>
            </div>
        </div>
    </div>';
}
function show_member_list($v_group_id)
{

    echo $v_group_id;
    $result=get_group_member_list($v_group_id);

    if($result)
    {
        while ($row=mysqli_fetch_assoc($result))
        {
            $vm_member_id=$row['vm_member_list_id'];
            $vm_member_name=$row['vm_member_name'];
            $vm_member_email=$row['vm_member_email'];
            $vm_member_phone=$row['vm_member_phone'];
            $vm_member_type=$row['vm_member_type'];

            echo '
                <div class="w3-container">
                    <ul class="list-group">
                        <li class="list-group-item">Member_id:'. $vm_member_id.'</li>
                        <li class="list-group-item">Name : '.$vm_member_name .'</li>
                        <li class="list-group-item">Member_email: '.$vm_member_email.' </li>
                        <li class="list-group-item">Member_email :'. $vm_member_phone .'</li>
                        <li class="list-group-item">Member_type :'. $vm_member_type .'</li>
                    </ul>
                </div>';
        }
    }
    else
    {
        echo "Sorry couldnt find this group_member list ";
    }
}


/***
 * end of function php tags
 */
?>




<?php
if(isset($_GET['group_id'])) {

    $result=get_this_group($_GET['group_id']);

    if($result)
    {
        while ($row=mysqli_fetch_assoc($result))
        {
            $v_group_id=$row['v_group_id'];
            $v_group_name=$row['v_group_name'];
            $v_group_place=$row['v_group_place'];
            $v_group_description=$row['v_group_description'];
            $v_group_services=$row['v_group_services'];
            $v_group_member_number=$row['v_group_member_number'];
            $v_group_leader_id=$row['v_group_leader_id'];
            show_group_info($v_group_id,$v_group_name,$v_group_place,$v_group_description,$v_group_services,$v_group_member_number,$v_group_leader_id);
           // show_member_list($v_group_id);
        }
    }
    else
    {
        echo "Sorry couldnt find this group ";
    }
}
else
{
    echo "<h3 class='text-danger'>What are You doing in this page :/ </h3> ";
}

?>

<?php
include "basic_structure/footer.php";
?>




