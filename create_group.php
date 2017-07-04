<?php
/**
 * Group Create Page
 */


if ($_SERVER['REQUEST_METHOD'] == 'POST') {

include 'func.php';

    $grpName = validateInput(isset($_POST['grp_name']) ? $_POST['grp_name'] : '');
    $grpPlace = validateInput(isset($_POST['grp_place']) ? $_POST['grp_place'] : '');
    $grpDescription = validateInput(isset($_POST['grp_desc']) ? $_POST['grp_desc'] : '');
    $grpService = isset($_POST['grp_services']) ? $_POST['grp_services'] : '';
    //$grpLeader = validateInput(isset($_POST['grp_leader']) ? $_POST['grp_leader'] : '');

    if ($grpName == '' || $grpPlace == '' || $grpDescription == '' || $grpService == '') {
        echo "Fill All fields!";
        exit();
    } else {
        $grp = new Group();
        $grp->setGrpName($grpName);
        $grp->setGrpPlace($grpPlace);
        $grp->setGrpDescription($grpDescription);
        $grp->setGrpServices($grpService);
        //$grp->setGrpLeader($grpLeader);

        /*echo $grp->getGrpName()."<br>";
        echo $grp->getGrpPlace()."<br>";
        echo $grp->getGrpDescription()."<br>";
        echo $grp->getGrpServices()."<br>";
*/

        $result = $grp->add();

        if ($result !== false) {
            echo "Group Successfully created!";
            exit();
        }

    }

    exit("Something Wrong!");

}

?>

<?php

include "basic_structure/header.php";
include "basic_structure/navbar.php"

?>

<form class="w3-container w3-card-4 ts-form ts-form-box" method="post" action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>">
    <p>
    <label for="grp_name">Group Name</label>
    <input class="w3-input w3-border w3-light-grey" id="grp_name" type="text" name="grp_name">
    </p>

    <p>
    <label for="grp_place">Group Place</label>
    <input class="w3-input w3-border w3-light-grey" id="grp_place" type="text" name="grp_place">
    </p>

    <p>
    <label for="grp_desc">Group Description</label>
    <textarea class="w3-input w3-border w3-light-grey" id="grp_desc" name="grp_desc" cols="30" rows="10"></textarea>
    </p>

    <p>
    <label>Group Services:</label>
    </p>
    
    <?php

    $db = new db_util();
    
    $sql = "SELECT * FROM vm_services";

    $result = $db->query($sql);

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc())  { 
    ?>
        <p>
        <input class="w3-check" type="checkbox" name="grp_services[]" value="<?php echo $row['vm_service_name'];?>">
        <label><?php echo $row['vm_service_name'];?></label>
        </p>
    <?php 

        } 
    }

    ?>

    <p>
    <input class="w3-btn w3-blue-grey" type="submit" value="Submit">
    </p>
</form>

<?php

include "basic_structure/footer.php";

?>