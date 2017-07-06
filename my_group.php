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
include "basic_structure/footer.php";
?>
