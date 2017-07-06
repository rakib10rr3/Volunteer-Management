<div class="w3-sidebar w3-bar-block w3-card-2 w3-animate-left" style="display:none" id="mySidebar">

    <button class="w3-bar-item w3-button w3-large w3-hover-red"
            onclick="w3_close()">Close &times;
    </button>

    <a href="./index.php" class="w3-bar-item w3-button w3-hover-cyan">Home</a>

<?php

    if (isUserLoggedIn())
    {

?>

    <a href="./logout.php" class="w3-bar-item w3-button w3-hover-cyan">Logout</a>

<?php


    } else {

?>

    <a href="./login.php" class="w3-bar-item w3-button w3-hover-cyan">Login</a>
    <a href="./register.php" class="w3-bar-item w3-button w3-hover-cyan">Sign Up</a>

<?php

    }

?>

    <hr>
    <!-- for testing purpose -->
    <a href="./create_group.php" class="w3-bar-item w3-button w3-hover-cyan">Create Group</a>
    <a href="./group_details.php" class="w3-bar-item w3-button w3-hover-cyan">Group Details</a>
    <a href="./group_search.php" class="w3-bar-item w3-button w3-hover-cyan">Group Search</a>
    <a href="./join_group.php" class="w3-bar-item w3-button w3-hover-cyan">Join Group</a>
    <a href="./add_disaster.php" class="w3-bar-item w3-button w3-hover-cyan">Call for Help</a>
    <a href="./my_group.php" class="w3-bar-item w3-button w3-hover-cyan">My Group</a>
    <a href="./profile.php" class="w3-bar-item w3-button w3-hover-cyan">Profile</a>

</div>


<div zclass="w3-main" id="main">

    <div class="w3-cyan ts-nav-bar">
        <button class="w3-button w3-cyan w3-xlarge ts-main-menu" onclick="w3_open()">&#9776;</button>
        <!-- <div class="w3-container"> -->
            <!-- <h1 style="font-family:Georgia"><?=$GLOBALS['c_site_title']?></h1> -->
            <p class="ts-site-title"><?=$GLOBALS['c_site_title']?></p>
        <!-- </div> -->
    </div>

    <script>
        function w3_open() {
          document.getElementById("main").style.marginLeft = "200px";
          document.getElementById("mySidebar").style.width = "200px";
          document.getElementById("mySidebar").style.display = "block";
          document.getElementById("openNav").style.display = 'none';
        }
        function w3_close() {
          document.getElementById("main").style.marginLeft = "0%";
          document.getElementById("mySidebar").style.display = "none";
          document.getElementById("openNav").style.display = "inline-block";
        }
    </script>

    <div class="w3-container main-container">
        