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
    	if ($this->grpName == "" || $this->grpPlace == "" || $this->grpDescription == "" || $this->grpServices == "" ) {
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

            	$stmt = $db->prepare('INSERT INTO vm_group(v_group_name, v_group_place, v_group_description, v_group_services)
            		VALUES(?, ?, ?, ?)');

            	$_grpName = $this->grpName;
            	$_grpPlace = $this->grpPlace;
            	$_grpDescription = $this->grpDescription;
            	$_grpServices = $this->grpServices;
               // $_grpLeader = $this->grpLeader;

            	echo $db->getError();

            	$stmt->bind_param('ssss', $_grpName, $_grpPlace, $_grpDescription, $_grpServices);

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
    	$this->grpServices = implode(", ",$services);
    	return $this;
    }

}