<?php

/**
 * All the classes will coded here.
 */
class User
{

    private $id;
    private $name;
    private $email;
    private $password;

    public function __construct()
    {


    }


    public function isUserExistByEmail($user_email)
    {
        // make new db object
        $db = new db_util();

        $sql = "SELECT * 
        FROM vm_users 
        WHERE user_email='" . $user_email . "'";

        $result = $db->query($sql);

        if($result===false)
        {
            return true;
        }

        if ($result->num_rows > 0) {
            return true;
        }

        return false;
    }

    /**
     * Add New User
     *
     * MUST: before call this must check if the user already exist with this email!
     */
    public function add()
    {

        // Check all value exist!
        if ($this->name == "" || $this->email == "" || $this->password == "") {
            return 0; // all value not found!
        }

        // make new db object
        $db = new db_util();


        $stmt = $db->prepare('INSERT INTO vm_users(user_name, user_email, user_password)
            VALUES(?, ?, ?)');

        $_name = $this->name;
        $_email = $this->email;
        $_pass = $this->password;

        echo $db->getError();

        $stmt->bind_param('sss', $_name, $_email, $_pass);

        $result = $stmt->execute();

        if ($result === true) {
            $new_user_id = $stmt->insert_id;
            return $new_user_id;
        }
        
        

        return false; // anything wrong then return 0

    }

    /**
     * Load user using given $email
     */
    public function loadUserByEmail($user_email)
    {

        $sql = "SELECT * FROM vm_user WHERE user_email='$user_email'";
        $result = $this->query($sql);

        if ($result !== false) {
            // if there any error in sql then it will false
            if ($result->num_rows > 0) {

                $row = $result->fetch_assoc();

                $this->setId($row['user_id']);
                $this->setName($row['user_name']);
                $this->setEmail($row['user_email']);
                $this->setPassword($row['user_password']);

                return true;

            }
        }

        return false;
    }

    /**
     * Update User Information
     */
    public function update()
    {

    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     *
     * @return self
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     *
     * @return self
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     *
     * @return self
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     *
     * @return self
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }
    public function get_name_by_id($id)
    {
        $sql_string="SELECT * FROM vm_member_list WHERE vm_member_id= $id";
        $db=new db_util();
        $result=$db->query($sql_string);
        if($result)
        {
            $row=mysqli_fetch_assoc($result);
            $name=$row['vm_member_name'];
            return $name;
        }
        else
        {
            return false;
        }
    }
    public function get_email_by_id($id)
    {
        $sql_string="SELECT * FROM vm_users WHERE user_email= $id";
        $db=new db_util();
        $result=$db->query($sql_string);
        if($result)
        {
            $row=mysqli_fetch_assoc($result);
            $name=$row['user_email'];
            return $name;
        }
        else
        {
            return false;
        }
    }

}


class Group
{
    private $grpName;
    private $grpPlace;
    private $grpDescription;
    private $grpServices;
    private $grpLeader;



    public function __construct()
    {

    }

    /**
     * Add New User
     */
    public function add()
    {

        // Check all value exist!
        if ($this->grpName == "" || $this->grpPlace == "" || $this->grpDescription == "" || $this->grpServices == "" ||
            $this->grpLeader == "") {
            return 0; // all value not found!
        }

        // make new db object
        $db = new db_util();


        // Step 1: Check if the group already exist!
        $sql = "SELECT * 
        FROM vm_group 
        WHERE v_group_name ='" . $this->grpName . "'";


        $result = $db->query($sql);

        // Step 2: Add the user
        if ($result === false) {
            return false; // something wrong! canno execute the sql!
        } else {
            if ($result->num_rows > 0) {
                return false; // already have user with the $email
            } else {

                $stmt = $db->prepare('INSERT INTO vm_group(v_group_name, v_group_place, v_group_description, v_group_services,
                    v_group_leader_id)
                    VALUES(?, ?, ?, ?, ?)');

                $_grpName = $this->grpName;
                $_grpPlace = $this->grpPlace;
                $_grpDescription = $this->grpDescription;
                $_grpServices = $this->grpServices;
                $_grpLeader = $this->grpLeader;

                echo $db->getError();

                $stmt->bind_param('ssssi', $_grpName, $_grpPlace, $_grpDescription, $_grpServices, $_grpLeader);

                $result = $stmt->execute();

                if ($result === true) {
                    $new_user_id = $stmt->insert_id;
                    return $new_user_id;
                }
            }
        }

        return false; // anything wrong then return 0

    }

    /**
     * Update User Information
     */
    public function update()
    {

    }


    /**
     * @return mixed
     */
    public function getGrpLeader()
    {
        return $this->grpLeader;
    }

    /**
     * @param mixed $grpLeader
     *
     * @return self
     */
    public function setGrpLeader($grpLeader)
    {
        $this->grpLeader = $grpLeader;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     *
     * @return self
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getGrpName()
    {
        return $this->grpName;
    }

    /**
     * @param mixed $name
     *
     * @return self
     */
    public function setGrpName($name)
    {
        $this->grpName = $name;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getGrpPlace()
    {
        return $this->grpPlace;
    }

    /**
     * @param mixed $place
     *
     * @return self
     */
    public function setGrpPlace($place)
    {
        $this->grpPlace = $place;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getGrpDescription()
    {
        return $this->grpDescription;
    }

    /**
     * @param mixed $description
     *
     * @return self
     */
    public function setGrpDescription($description)
    {
        $this->grpDescription = $description;

        return $this;
    }

    public function getGrpServices()
    {
        return $this->grpServices;
    }

    public function setGrpServices($services)
    {
        $this->grpServices = implode(", ", $services);
        return $this;
    }
    public function get_group_name_by_leader_id($id)
    {
        $sql_string="SELECT * FROM vm_group WHERE v_group_leader_id= $id";
        $db=new db_util();
        $result=$db->query($sql_string);
        if($result)
        {
            $row=mysqli_fetch_assoc($result);
            $name=$row['v_group_name'];
            $group_id=$row['v_group_id'];
            return array($name,$group_id);
        }
        else
        {
            return false;
        }
    }

}


class Member
{
    private $memberID;
    private $memberName;
    private $memberEmail;
    private $memberGrp;
    private $memberPhone;
    private $memberAge;
    private $memberGender;
    private $memberType;
    private $memberInterest;

    public function __construct()
    {

    }

    public  function remove_member_from_group($member_id,$group_id)
    {
        $db = new db_util();

        $sql = "DELETE  
        FROM vm_member_list
        WHERE vm_group_id= $group_id AND vm_member_list_id = $member_id";
        $result = $db->query($sql);
        if($result !=false)
        {
            return $result;
        }
        else
        {
            return false;
        }
    }

    public function update()
    {
        $db = new db_util();


        $memUpdate = $db->prepare('UPDATE vm_member_list SET vm_member_name = ?,  vm_member_phone = ?, vm_member_type = ? , vm_member_age = ?, vm_member_gender = ? WHERE vm_member_id = '.$this->memberID);

        $_memberName = $this->memberName;
        $_memberPhone = $this->memberPhone;
        $_memberType = $this->memberType;
        $_memberAge = $this->memberAge;
        $_memberGender = $this->memberGender;
       // $_memberInterest = $this->memberInterest;
        // echo $db->getError();

        $memUpdate->bind_param('sssis', $_memberName, $_memberPhone, $_memberType, $_memberAge, $_memberGender);
        //echo $_memberPhone;
        $result = $memUpdate->execute();

        if ($result === true) {
           // $new_user_id = $memUpdate->insert_id;
            header("Location:profile.php?id=".$this->memberID);
           // return $new_user_id;
        }

        return false; // anything wrong then return 0
    }

    public function updateGroupIdForAdmin()
    {

        // make new db object
        $db = new db_util();
        
        $memUpdate = $db->prepare('UPDATE vm_member_list 
            SET vm_group_id = ?,  vm_member_type = ?
            WHERE vm_member_id = ?');

        $_memberID = $this->memberID;
        $_memberGrp = $this->memberGrp;
        $_memberType = $this->memberType;

        $memUpdate->bind_param('isi', $_memberGrp, $_memberType, $_memberID);
        //echo $_memberPhone;
        $result = $memUpdate->execute();

        if ($result !== false) {
            return true;
        }

        return false; // anything wrong then return 0
    }

    public function updateGroupId()
    {

        // make new db object
        $db = new db_util();
        
        $memUpdate = $db->prepare('UPDATE vm_member_list 
            SET vm_group_id = ?
            WHERE vm_member_id = ?');

        $_memberID = $this->memberID;
        $_memberGrp = $this->memberGrp;

        $memUpdate->bind_param('ii', $_memberGrp, $_memberID);
        //echo $_memberPhone;
        $result = $memUpdate->execute();

        if ($result !== false) {
            return true;
        }

        return false; // anything wrong then return 0
    }

    /**
     * @return mixed
     */
    public function add()
    {

        $db = new db_util();


        $memjoin = $db->prepare('INSERT INTO vm_member_list(vm_group_id, vm_member_id, vm_member_name, vm_member_email, vm_member_phone, vm_member_type, vm_member_age, vm_member_gender, vm_member_interest)
            		VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?)');

        $_memberId = $this->memberID;
        $_memberName = $this->memberName;
        $_memberEmail = $this->memberEmail;
        $_memberGrp = $this->memberGrp;
        $_memberPhone = $this->memberPhone;
        $_memberAge = $this->memberAge;
        $_memberGender = $this->memberGender;
        $_memberType = $this->memberType;
        $_memberInterest = $this->memberInterest;
        // echo $db->getError();

        $memjoin->bind_param('iisssssss', $_memberGrp, $_memberId, $_memberName, $_memberEmail, $_memberPhone,
            $_memberType, $_memberAge, $_memberGender, $_memberInterest);
        //echo $_memberPhone;
        $result = $memjoin->execute();

        if ($result === true) {
            $new_user_id = $memjoin->insert_id;
            return $new_user_id;
        }

        return false; // anything wrong then return 0

    }
    public function getMemberId()
    {
        return $this->memberID;
    }

    /**
     * @param mixed $id
     *
     * @return self
     */
    public function setMemberID($id)
    {
        $this->memberID = $id;

        return $this;
    }
    public function setGroup_id($id)
    {
        $this->memberID = $id;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getMemberName()
    {
        return $this->memberName;
    }

    /**
     * @param mixed $name
     *
     * @return self
     */
    public function setMemberName($name)
    {
        $this->memberName = $name;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getMemberEmail()
    {
        return $this->memberEmail;
    }

    /**
     * @param mixed $place
     *
     * @return self
     */
    public function setMemberEmail($email)
    {
        $this->memberEmail = $email;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getMemberGrp()
    {
        return $this->memberGrp;
    }

    /**
     * @param mixed
     *
     * @return self
     */
    public function setMemberGrp($memGrp)
    {
        $this->memberGrp = $memGrp;

        return $this;
    }

    public function getMemberPhone()
    {
        return $this->memberPhone;
    }
    public function setMemberPhone($phone)
    {
        $this->memberPhone = $phone;

        return $this;
    }

    public function setMemberType($memType)
    {
        $this->memberType = $memType;
        return $this;
    }

    public function getMemberType()
    {
        return $this->memberType;
    }

    public function setMemberGender($memGender)
    {
        $this->memberGender = $memGender;
        return $this;
    }

    public function getMemberGender()
    {
        return $this->memberGender;
    }

    public function setMemberAge($memAge)
    {
        $this->memberAge = $memAge;
        return $this;
    }

    public function getMemberAge()
    {
        return $this->memberAge;
    }


    // public function setMemberInterest($memint)
    // {
    //     $this->memberInterest = implode(", ",$memint);
    //     return $this;
    // }

    public function setMemberInterest($memInt)
    {
        $this->memberInterest = $memInt;
        return $this;
    }

}


class Disaster {

/*
    vm_disaster_id int not null auto_increment
        primary key,
    vm_disaster_name varchar(256) not null,
    vm_disaster_locations  varchar(256) not null,
    vm_disaster_type int not null,
    vm_disaster_start DATETIME not null,
    vm_disaster_expire  DATETIME not null
    */
   
    const disaster_type = array(
        1 => "Flood", 
        2 => "Cyclone", 
        3 => "Hill", 
        4 => "Donation"
        );

   
    private $id;
    private $name;
    private $location;
    private $type;
    private $start;
    private $expire;

    public function __construct()
    {

    }

    /**
     * Add New User
     *
     * MUST: before call this must check if the user already exist with this email!
     */
    public function add()
    {

        // Check all value exist!
        if ($this->name == "" || $this->location == "" || $this->type == "" || $this->start == "" || $this->expire == "") {
            return false; // all value not found!
        }

        // make new db object
        $db = new db_util();


        $stmt = $db->prepare('INSERT INTO vm_disaster(vm_disaster_name, vm_disaster_locations, vm_disaster_type, vm_disaster_start, vm_disaster_expire)
            VALUES(?, ?, ?, ?, ?)');

        $_name = $this->name;
        $_location = $this->location;
        $_type = $this->type;
        $_start = $this->start;
        $_expire = $this->expire;

        //echo $db->getError();

        $stmt->bind_param('sssss', $_name, $_location, $_type, $_start, $_expire);

        $result = $stmt->execute();

        if ($result === true) {
            $new_user_id = $stmt->insert_id;
            return $new_user_id;
        }

        return false; // anything wrong then return 0

    }

    public function getDisasterNameById($disaster_id)
    {
        return self::disaster_type[$disaster_id];
    }


    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     *
     * @return self
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     *
     * @return self
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * @param mixed $location
     *
     * @return self
     */
    public function setLocation($location)
    {
        $this->location = $location;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     *
     * @return self
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getStart()
    {
        return $this->start;
    }

    /**
     * @param mixed $start
     *
     * @return self
     */
    public function setStart($start)
    {
        $this->start = $start;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getExpire()
    {
        return $this->expire;
    }

    /**
     * @param mixed $expire
     *
     * @return self
     */
    public function setExpire($expire)
    {
        $this->expire = $expire;

        return $this;
    }

    public function disaster_added_for_this_group($group_id)
    {
        $sql_string="SELECT * from vm_disaster WHERE vm_disaster_added_by_group=$group_id";

        $db=new db_util();
        $result=$db->query($sql_string);
        if($result!=false)
        {
            if($result->num_rows>0)
            {
                return $result;
            }
        }
        else
        {
           return false;
        }


    }
}


class Messages
{
    function __construct()
    {

    }
    private $message_text;
    private $message_disaster_id;
    private $message_to_group;
    private $message_from_member_id;

    public function set_message_text($id)
    {
        $this->message_text = $id;
        echo "message_set to ".$this->message_text;
        return $this;
    }
    public function set_message_disaster_id($id)
    {
        $this->message_disaster_id = $id;

        //echo "message_set to ".$this->message_text;
        return $this;
    }
    public function set_message_to_group($id)
    {
        $this->message_to_group = $id;
        return $this;
    }
    public function set_message_from_member_id($id)
    {
        $this->message_from_member_id=$id;
        return $this;
    }

    public function add()
    {

        // Check all value exist!
        if (empty($this->message_text) ||empty($this->message_disaster_id )||empty($this->message_to_group ) ||empty($this->message_from_member_id)) {
            echo "sad -_-";
            return false; // all value not found!
        }

        // make new db object
        $db = new db_util();


        $stmt = $db->prepare("INSERT INTO vm_messages(vm_message_text,vm_message_disaster_id, vm_message_to_group, vm_message_from_member,date) VALUES(?, ?, ?, ?,now())");
        $_message = $this->message_text;
        $_disaster_post_id = $this->message_disaster_id;
        $_group_id = $this->message_to_group;
        $_member_id = $this->message_from_member_id;

        echo $_message ." ",$_disaster_post_id ." ".$_group_id." ".$_member_id."\n";

        //echo $db->getError();

        $stmt->bind_param('siii', $_message, $_disaster_post_id, $_group_id, $_member_id);

        $result = $stmt->execute();


        if ($result === true) {
                /*    $new_user_id = $stmt->insert_id;
                    return $new_user_id;
                */

                    return true;
                }


        return false; // anything wrong then return 0

    }

}
