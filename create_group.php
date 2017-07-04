<?php
/**
 * Group Create Page
 */

include 'func.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {


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

<!DOCTYPE html>
<html>
<head>
    <title>Groups</title>
</head>
<body>

<form method="post" action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>">
    <p>Group Name: </p>
    <input type="text" name="grp_name">
    <p>Group Place: </p>
    <input type="text" name="grp_place">
    <p>Group Description: </p>
    <textarea name="grp_desc" cols="30" rows="10"></textarea>
    <p>Group Services: </p>
    <input type="checkbox" name="grp_services[]" value="volunteer"> Volunteer
    <input type="checkbox" name="grp_services[]" value="blood_donation"> Blood Donation
    <input type="checkbox" name="grp_services[]" value="resource_collection"> Resource Collection

    <br>
    <input type="submit" value="Submit">
</form>

</body>
</html>