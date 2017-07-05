<?php
/*
Logout Module

It logged you out and redirect to home page.
 */
include_once 'func.php';

$host = $GLOBALS['c_domain'];

# Resetting all coockies by inserting invalid data
// setcookie($GLOBALS['c_loginType'], "", -1, $GLOBALS["c_subname"], $host, false, true);
setcookie($GLOBALS['c_name'], "", -1, $GLOBALS["c_subname"], $host, false, true);
setcookie($GLOBALS['c_email'], "", -1, $GLOBALS["c_subname"], $host, false, true);
setcookie($GLOBALS['c_id'], "", -1, $GLOBALS["c_subname"], $host, false, true);
setcookie($GLOBALS['c_hash'], "", -1, $GLOBALS["c_subname"], $host, false, true);
// setcookie($GLOBALS['c_isloggedin'], "", -1, $GLOBALS["c_subname"], $host, false, true);


//php function to check if headers sent or not
if (!headers_sent()) {
    header("refresh:5;url=" . $GLOBALS['c_subname']);
}

?>

<?php

include "basic_structure/header.php";
include "basic_structure/navbar.php"

?>

    <div class="w3-panel w3-green w3-display-container ts-alert">
        <p><strong>Success!</strong> You successfully logged out. :)<br><br>
        You will be redirected to home page in few seconds.</p>
    </div>


<?php

include "basic_structure/footer.php";

?>
