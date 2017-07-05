<?php
include "func.php";

$member = new Member();
$member->setMemberID($_POST['id']);

header("Location:update.php?id=".$_POST['id']);
