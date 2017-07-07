<?php

include "basic_structure/header.php";
include "basic_structure/navbar.php";

?>


<?php
if (isset($_POST['send'])) {
    $message_error = " ";
    $message = validateInput(isset($_POST['message']) ? $_POST['message'] : '');
    if (empty($message)) {
        $message_error = "Empty field !";
    } else {
        $disaster_number = $_POST['disaster_number'];
        $message_from_the_member = $_COOKIE[$GLOBALS['c_id']];
        $message_to_group = $_POST['vm_disaster_added_by_group'];

        $msg_obj = new Messages();
        $msg_obj->set_message_disaster_id($disaster_number);
        $msg_obj->set_message_from_member_id($message_from_the_member);
        $msg_obj->set_message_to_group($message_to_group);
        $msg_obj->set_message_text($message);
        $check = $msg_obj->add();

        if ($check) {
            ?>
            <div class="w3-panel w3-green w3-display-container ts-alert">
	            <span onclick="this.parentElement.style.display='none'"
                      class="w3-button w3-large w3-display-topright">&times;</span>
                <p>Message Push was Successful!</p>
            </div>
            <?php
        } else {
            ?>
            <div class="w3-panel w3-green w3-display-container ts-alert">
	            <span onclick="this.parentElement.style.display='none'"
                      class="w3-button w3-large w3-display-topright">&times;</span>
                <p>Message Push was Successful!</p>
            </div>
            <?php
        }
    }
}
?>

    <p class="w3-xlarge w3-center ts-text-bold">
        Welcome<?php echo (isset($_COOKIE[$GLOBALS['c_name']])) ? " ".$_COOKIE[$GLOBALS['c_name']] : ""; ?>!
    </p>
    <p class="w3-large w3-center">Let's work together to build an awesome Bangladesh!</p>


    <div class="w3-row">
        <div class="w3-col m3 w3-container"></div>
        <div class="w3-col m6 w3-card-2">
            <div class="w3-container w3-center w3-white w3-xlarge w3-border-bottom ts-disaster-box-title">
                <!-- 1 start -->
                <p>Call For Help</p>
            </div>

            <?php

            /**
             * IDEA:
             * - If user logged in then hilight the disesters which happend users location
             * - If user click on a locatin form Call-for-help s/he will get the search result of that page
             */

            $db = new db_util();

            $now_date = date("Y-m-d");

            /**
             * Only Show NOT EXPIRED disasters.
             */

            $sql = "SELECT * 
FROM vm_disaster 
WHERE vm_disaster_expire >= '$now_date'
ORDER BY vm_disaster_start DESC ";
            $result = $db->query($sql);

            if ($result !== false) {
// if there any error in sql then it will false
                if ($result->num_rows > 0) {

                    echo '<ul class="w3-ul w3-white">';

                    while ($row = $result->fetch_assoc()) {

                        ?>

                        <li>
                            <p class="ts-disaster-title"><?= $row['vm_disaster_name'] ?></p>

                            <p class="ts-disaster-subtitle">
                                Added By <?php
                                $user_obj = new User();
                                $name = $user_obj->get_name_by_id($row['vm_disaster_created_by']);
                                //                                    echo $name;
                                echo ' <a href="profile.php?id=' . $row['vm_disaster_created_by'] . '">' . $name . '</a>';
                                ?>
                                from <?php
                                $grp_obj = new Group();
                                $array_name = $grp_obj->get_group_name_by_leader_id($row['vm_disaster_created_by']);
                                //                                    var_dump($array_name);
                                $group_name = $array_name[0];
                                $group_id = $array_name[1];
                                if ($name != false) {
                                    echo '<a href="group_details.php?group_id=' . $group_id . '">' . $group_name . '</a>';
                                }

                                ?>
                            </p>

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
                                <p><input class="w3-input w3-border" placeholder="Respond by message " type="text"
                                          name="message""></p>
                                <p><input class="w3-btn w3-blue-grey" type="submit" value="Send" name="send"></p>
                                <input type="hidden" value="<?php echo $row['vm_disaster_id'] ?>"
                                       name="disaster_number">
                                <input type="hidden" value="<?php echo $row['vm_disaster_created_by'] ?>"
                                       name="vm_disaster_created_by">
                                <input type="hidden" value="<?php echo $row['vm_disaster_added_by_group'] ?>"
                                       name="vm_disaster_added_by_group">
                            </form>

                        </li>

                        <?php

                    }

                    echo "</ul>";

                } else {
                    ?>
                    <div class="w3-container w3-center">
                        <p>No active Call For Help!</p>
                    </div>

                    <?php
                }

            } else {
                ?>

                <p>No Call-For-Help!</p>

                <?php
            }


            ?>

        </div> <!-- 1 end -->
        <div class="w3-col m3 w3-container"></div>
    </div>


<?php

include "basic_structure/footer.php";

?>