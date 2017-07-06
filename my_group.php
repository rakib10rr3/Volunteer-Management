<?php
/**
 * Created by PhpStorm.
 * User: Me
 * Date: 7/5/2017
 * Time: 7:04 PM
 */
include "basic_structure/header.php";
include "basic_structure/navbar.php";
if(isset($_GET['group_id']))
{
    $my_grp = $_GET['group_id'];
}

function get_this_group($grp_id)
{
    $db=new db_util();
    $query_string="SELECT * FROM vm_group WHERE v_group_id=$grp_id";
    $result=$db->query($query_string);
    return $result;
}

?>



<div class="w3-panel w3-blue w3-round-xlarge">

    <h3>International Islamic University,Chittagong (Volunteer_group)[Hard_coded for Development ] </h3>
</div>



<div class="w3-sidebar w3-bar-block w3-card-2 w3-animate-right" style="display:none;right:0;" id="rightMenu">
    <button onclick="closeRightMenu()" class="w3-bar-item w3-button w3-large">Close &times;</button>

    <!--    <a href="show_member.php?show_member_of=1" class="w3-bar-item w3-button" id="show_member">View All Member</a>
    <a href="show_group_info.php?group_id=1" class="w3-bar-item w3-button" id="show_group_info">View Group Info </a>

    <a href="#" class="w3-bar-item w3-button" id="view_join_request">View Any join Request</a>
    <a href="#" class="w3-bar-item w3-button">Call For Help</a>

    <a href="#" class="w3-bar-item w3-button">Add Donation Poll</a>
    <a href="#" class="w3-bar-item w3-button">Distance Travel Poll</a>
    <a href="#" class="w3-bar-item w3-button">Available Poll</a>
    <a href="group_inbox.php" class="w3-bar-item w3-button" id="view_join_request"> Inbox </a>
    -->

    <a  class="show w3-bar-item w3-button" target="_show_member">View All Member</a>
    <a  class="show w3-bar-item w3-button" target="_show_group_info">View Group Info</a>
    <a href="#" class="w3-bar-item w3-button">Call For Help</a>
    <a  class="show w3-bar-item w3-button" target="_Show_inbox">View Inbox</a>
    <!--
    <a  class="hide" target="1">Close 1</a>-->

</div>

<div class="w3-blue-gray">
    <button class="w3-button w3-teal w3-xlarge w3-right" onclick="openRightMenu()">&#9776;</button>
</div>




<div class="panel-danger" id="div_show_feed">

    ekhane se group leader kina check korte hobe

            Default Information

<?php
$disaster_obj=new Disaster();
$result=$disaster_obj->disaster_added_for_this_group($my_grp);
if($result != false)
{
    while ($row = $result->fetch_assoc()) {

        ?>

        <li>
            <p class="ts-disaster-title"><?= $row['vm_disaster_name'] ?></p>

            <div class="w3-panel w3-border-left w3-border-blue w3-hover-pale-blue">
                <p class="">Added By:  <?php
                    $user_obj=new User();
                    $name=$user_obj->get_name_by_id($row['vm_disaster_created_by']);
                    echo $name;
                    echo ' <a href="profile.php?id='.$row['vm_disaster_created_by'].'">'.$name.'</a>';
                    ?></p>
            </div>

            <div class="w3-panel w3-border-left w3-border-blue w3-hover-pale-blue">
                <p class="">Volunteer_Group:  <?php
                    $grp_obj=new Group();
                    $array_name=$grp_obj->get_group_name_by_leader_id($row['vm_disaster_created_by']);
                    $group_name=$array_name[0];
                    $group_id=$array_name[1];
                    if($name !=false)
                    {
                        echo  '<a href="group_details.php?group_id='.$group_id.'">'.$group_name.'</a>';
                    }

                    ?></p>
            </div>

            <div class="w3-row">
                <div class="w3-half">
                    <p class="ts-disaster-type"><i
                                class="fa fa-life-bouy"></i> <?= Disaster::getDisasterNameById($row['vm_disaster_type']) ?>
                    </p>
                </div>
                <div class="w3-half">
                    <p class="ts-disaster-loc"><i
                                class="fa fa-map-marker"></i> <?= getDistrictNameById($row['vm_disaster_locations']) ?>
                    </p>
                </div>
            </div>


            <p class="ts-disaster-start"><i
                        class="fa fa-calendar"></i> <?= date_format(date_create($row['vm_disaster_start']), "j M") ?>
                to <?= date_format(date_create($row['vm_disaster_expire']), "j M") ?></p>

            <!--here some filtering should be done
            -->
            <form action="index.php" method="post" id="usrform">
                <input class="w3-input w3-animate-input" placeholder="Respond by message " type="text"  name="message" style="width:30%">
                <input class="w3-btn w3-blue-grey" type="submit" value="Send" name="send">
                <input type="hidden" value="<?php echo $row['vm_disaster_id'] ?>" name="disaster_number" >
                <input type="hidden" value="<?php echo $row['vm_disaster_created_by'] ?>" name="vm_disaster_created_by" >
                <input type="hidden" value="<?php echo $row['vm_disaster_added_by_group'] ?>" name="vm_disaster_added_by_group" >
            </form>

        </li>

        <?php

    }
}
else
{
    echo "Something went horribly wrong !";
}


?>







</div>


<!-- Member info show er div -->
<div id="div_show_member" class="targetDiv">



    <?php
    function show_member_list($v_group_id)
    {

        $db=new db_util();
        $query_string="SELECT * FROM vm_member_list WHERE vm_group_id=$v_group_id";
        $result=$db->query($query_string);

          echo ' <table class="w3-table w3-striped">
                <thead>
                <tr>
                    <th> Name</th>
                    <th> Member Type</th>
                    <th> Action </th>
                </tr>
                </thead>
                <tbody>';



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
                echo "<td>  <a href='my_group.php?del_member_id=$vm_member_id&group_id=$v_group_id'>Remove </a> </td>";
                echo "</tr>";
            }
            echo '</tbody>
        </table>';
        } else {
            echo "Sorry couldnt find this group_member list ";
        }
        }

    show_member_list($my_grp);
    if((isset($_GET['del_member_id'])) && (isset($_GET['group_id'])))
    {
        $member_id=$_GET['del_member_id'];
        $group_id=$_GET['group_id'];

        $member_obj=new Member();
        $result=$member_obj->remove_member_from_group($member_id,$group_id);
        if($result)
        {
            echo" successfully deleted the id ";
            header("Location: show_member.php?show_member_of=$group_id");
        }
        else
        {
            echo '<h3>Couldnt delete this member sorry</h3>';
        }
    }
    //this function runs the first in this div
        ?>

</div>


<!-- group info show er div -->
<div id="div_show_group_info" class="targetDiv">

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
    $result=get_this_group($my_grp);
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

    /*  else
      {
          echo "<h3 class='text-danger'>What are You doing in this page :/ </h3> ";
      }*/
    ?>

</div>



<!-- Inbox message show er div -->
<div id="div_Show_inbox" class="targetDiv">Lorum Ipsum 3

    <?php
    $db=new db_util();
    $query_string="SELECT * FROM vm_messages WHERE vm_message_to_group=$v_group_id";

    $result=$db->query($query_string);
    if($result!=false)
    {
        //echo "bhai tui seera";
        if($result->num_rows>0)
        {
            while($row=mysqli_fetch_assoc($result))
            {
                $date=$row['date'];
                $by=$row['vm_message_from_member'];
                $msg=$row['vm_message_text'];
                $user_obj=new User();
                $user_name=$user_obj->get_name_by_id($by);
                echo $user_name ."<br>";
                echo $msg ."<br>";
                echo $date. "<br>";
            }
        }
       /* else
        {
            echo "You Have No messages ";
        }*/
    }


    ?>
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

    $('.targetDiv').hide();

    $('.show').click(function () {
        $('.targetDiv').hide();
        //$('.default').hide();
        $('#div' + $(this).attr('target')).toggle('').siblings('.targetDiv').hide('');show();
    });


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
