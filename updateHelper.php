<?php
include 'func.php';
//var_dump($_POST);

$memberName = validateInput(isset($_POST['member_name']) ? $_POST['member_name'] : '');
//$memberEmail = validateInput(isset($_POST['member_email']) ? $_POST['member_email'] : '');
$memberPhone = validateInput(isset($_POST['member_phone']) ? $_POST['member_phone'] : '');
$memberType = validateInput(isset($_POST['member_type']) ? $_POST['member_type'] : '');
$memberGender = validateInput(isset($_POST['member_gender']) ? $_POST['member_gender'] : '');
$memberAge = validateInput(isset($_POST['member_age']) ? $_POST['member_age'] : '');
//$grpService = isset($_POST['grp_services']) ? $_POST['grp_services'] : '';
//$grpLeader = validateInput(isset($_POST['grp_leader']) ? $_POST['grp_leader'] : '');

if ($memberName == '' || $memberPhone == '' || $memberType == '' || $memberGender == '' || $memberAge == '') {
    echo "Fill All fields!";
    exit();
} else {

    $member = new Member();
    $member->setMemberID($_POST['id']);
    $member->setMemberName($memberName);
    $member->setMemberPhone($memberPhone);
    $member->setMemberType($memberType);
    $member->setMemberGender($memberGender);
    $member->setMemberAge($memberAge);


    $result = $member->update();

    if ($result !== false) {
        echo "Profile Successfully Updated!";
        exit();
    }

}