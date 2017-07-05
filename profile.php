<?php
/**
 * Profile view Page
 */

$id = $_GET['id'];

//if (isset($_POST['update']))
// header("Location:update.php?id=$id");

?>

<?php

include "basic_structure/header.php";
include "basic_structure/navbar.php"

?>

    <form class="w3-container w3-card-4 ts-form ts-form-box" method="post"
          action="<?= htmlspecialchars('profileHelper.php'); ?>">
        <?php

        $db = new db_util();

        $sql = "SELECT * FROM vm_member_list WHERE vm_member_list_id = " . $id;

        $result = $db->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $interests = explode(", ", $row['vm_member_interest']);
                ?>
                <p>
                    <label for="member_name">Name</label>
                    <input class="w3-input w3-border w3-light-grey" id="member_name" type="text" name="member_name"
                           value="<?php echo $row['vm_member_name']; ?>" readonly>
                </p>

                <p>
                    <label for="member_email">Email</label>
                    <input class="w3-input w3-border w3-light-grey" id="member_email" type="email" name="member_email"
                           value="<?php echo $row['vm_member_email']; ?>" readonly>
                </p>

                <p>
                    <label for="member_phone">Phone</label>
                    <input class="w3-input w3-border w3-light-grey" id="member_phone" type="text" name="member_phone"
                           value="<?php echo $row['vm_member_phone']; ?>" readonly>
                </p>

                <p>
                    <label for="member_type">Type</label>
                    <input class="w3-input w3-border w3-light-grey" type="text" name="member_type"
                           value="<?php echo $row['vm_member_type']; ?>" readonly>
                </p>

                <p>
                    <label for="member_age">Age</label>
                    <input class="w3-input w3-border w3-light-grey" id="member_age" type="number" name="member_age"
                           value="<?php echo $row['vm_member_age']; ?>" readonly>
                </p>

                <p>
                    <label for="member_gender">Gender</label>
                    <input class="w3-input w3-border w3-light-grey" type="text" name="member_gender"
                           value="<?php echo $row['vm_member_gender']; ?>" readonly>
                </p>
                <p>
                    <label>Interests</label>
                </p>

                <p>
                    <input type="text" class="w3-input w3-border w3-light-grey" readonly
                           value=" <?php foreach ($interests as $interest) { ?>
<?php echo $interest; ?>
                <?php } ?>">
                </p>
            <?php }
        } ?>

        <p>
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <!-- Sesion id r user id mille update er button ta pawa jabe-->
            <?php //if ($id == sessionID) { ?>
            <input class="w3-btn w3-blue-grey" type="submit" name="update" value="Update">
            <?php //} ?>
        </p>
    </form>

<?php

include "basic_structure/footer.php";

?>