<?php

include 'func.php';

$response_obj=new Response();
if(isset($_GET['add_id']))
{
    $group_id=$_GET['add_id'];
    $disaster_id=$_GET['disaster_id'];
    $response_obj->add_user_to_the_response($GLOBALS['__user_id'] ,$group_id,$disaster_id);
    header("Location: my_group.php?group_id=$group_id");
}
if(isset($_GET['remove_id']))
{
    $group_id=$_GET['remove_id'];
    $disaster_id=$_GET['disaster_id'];
    $response_obj->remove_user_from_response($GLOBALS['__user_id'],$disaster_id);
    header("Location: my_group.php?group_id=$group_id");
}

?>