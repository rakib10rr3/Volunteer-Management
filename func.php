<?php
/**
 * All Common Functions will coded here!
 */

/**
 * Set Time Zone (IMPORTANT!)
 */
date_default_timezone_set('Asia/Dhaka');

/**
 * Include all common files
 */
include 'globals.php';
include 'db_util.php';
include 'classes.php';


$__user_id = (isset($_COOKIE[$GLOBALS['c_id']])) ? $_COOKIE[$GLOBALS['c_id']] : "0";
$__user_name = (isset($_COOKIE[$GLOBALS['c_name']]))?$_COOKIE[$GLOBALS['c_name']]:"0";
$__user_email = (isset($_COOKIE[$GLOBALS['c_email']]))?$_COOKIE[$GLOBALS['c_email']]:"0";


/**
 * Some settings
 */
# One year validity
define("__COOKIES_EXPIRE_MAX__", 86400 * 365);


/**
 *******************************************
 *******************************************
 *******************************************
 * [ All about Validation ]
 */

function validateInput($data)
{
    $data = trim($data); //Strip unnecessary characters (extra space, tab, newline)
    $data = stripslashes($data); //Remove backslashes (\)
    $data = htmlspecialchars($data, ENT_NOQUOTES, 'UTF-8');
    return $data;
}

/**
 * Check is the email is valid
 * @param  [type]  $emailAddress [description]
 * @return boolean               [description]
 */
function isValidEmailAddress($emailAddress)
{
    return filter_var($emailAddress, FILTER_VALIDATE_EMAIL) !== false;
}


/**
 * Send error log to error log file.
 * @param  string $message
 * @return boolean
 */
function _error_log($message)
{
    error_log("VM: " . $message);
}

/**
 *******************************************
 *******************************************
 *******************************************
 * [ All about User ]
 */

/**
 * Check If user loggedin
 */
function isUserLoggedIn()
{
	static $_is_logged_in = false;

	if(isset($_COOKIE[$GLOBALS['c_email']]) && isset($_COOKIE[$GLOBALS['c_hash']])) {
		
		if ($_is_logged_in === false) {
	        
		    $cookie_uname = validateInput($_COOKIE[$GLOBALS['c_email']]);
		    $cookie_hash = $_COOKIE[$GLOBALS['c_hash']];

		    if (isValidEmailAddress($cookie_uname) === false) {
		        // return false;
		        $_is_logged_in = false;
		    }

		    $db = new db_util();

		    $sql = "SELECT * FROM vm_users WHERE user_email='$cookie_uname'";
		    $result = $db->query($sql);

		    if ($result !== false) {
		        // if there any error in sql then it will false
		        if ($result->num_rows > 0) {
		            // if the sql execute successful then it give "num_ruws"

		            $row = $result->fetch_assoc();
		            $twoPassHash = hash('sha512', $row['user_password']);

		            if ($cookie_uname . $twoPassHash == $cookie_hash) {
		                // return true;
		                $_is_logged_in = true;
		            }
		        }
		    }
	    }
	}

    return $_is_logged_in;
}

/**
 * Check if logged in user is a member of a group
 */
function isMemberOfThisGroup($groupId)
{
	$_c_user_id = (isset($_COOKIE[$GLOBALS['c_id']]) ? $_COOKIE[$GLOBALS['c_id']] : 0);

	if ($_c_user_id != 0 && isUserLoggedIn()) {
        
		$db = new db_util();

	    $sql = "SELECT * 
	    FROM vm_member_list 
	    WHERE vm_member_id='$_c_user_id' 
	    AND vm_group_id = '$groupId'";

	    $result = $db->query($sql);

	    if ($result !== false) {
	        // if there any error in sql then it will false
	        if ($result->num_rows > 0) {
	            // if the sql execute successful then it give 
	            
	            return true;
	        }
	    }
    }
    
    return false;
}

function getTheUsersGroupId($user_id)
{  
	$db = new db_util();

    $sql = "SELECT vm_group_id 
    FROM vm_member_list 
    WHERE vm_member_list_id='$user_id'";

    $result = $db->query($sql);

    if ($result !== false) {
        // if there any error in sql then it will false
        if ($result->num_rows > 0) {
            // if the sql execute successful then it give 
             
            $row = $result->fetch_assoc(); 
            
            return $row['vm_group_id'];
        }
    }
    
    return 0;
}

/**
 * Check if the loggedin user is the creator of the group
 */
function isAdminOfThisGroup($groupId)
{
	$_c_user_id = (isset($_COOKIE[$GLOBALS['c_id']]) ? $_COOKIE[$GLOBALS['c_id']] : 0);

	if ($_c_user_id != 0 && isUserLoggedIn($user_id)) {
        
		$db = new db_util();

	    $sql = "SELECT * 
	    FROM vm_group 
	    WHERE v_group_leader_id='$_c_user_id' 
	    AND v_group_id = '$groupId'";

	    $result = $db->query($sql);

	    if ($result !== false) {
	        // if there any error in sql then it will false
	        if ($result->num_rows > 0) {
	            // if the sql execute successful then it give 
	            
	            return true;
	        }
	    }
    }
    
    return false;
}

/**
 *******************************************
 *******************************************
 *******************************************
 * [ All about Time ]
 */

/**
 * [getTheFormattedDateTime Return formatted date from mysql database Date data].
 *
 * @param [string] $dateTimeString [mySql database Date data]
 * @return false|string [string] [Return the formatted date]
 */
function getTheFormattedDateTime($dateTimeString)
{
    $_date = strtotime($dateTimeString);

    if (intval(date('Y', $_date)) == intval(date('Y', time()))) {
        # If same year
        $timeDifference = floor((time() - $_date) / 60); # Minutes

        if ($timeDifference <= 43200) { # 30 * 24 * 60 = 30 days
            # less then 30 day
            if ($timeDifference <= 1440) { # 24 * 60 = 1 days
                # if same day
                if ($timeDifference <= 60) { # 60 min = 1 hour
                    # same hour
                    return $timeDifference . " min ago";
                } else {
                    return floor($timeDifference / 60) . " hour ago";
                }
            } else {
                return floor($timeDifference / 1440) . " days ago";
            }
        } else {
            return date('j M, g:ia', $_date);
        }
    } else {
        return date('j M Y, g:ia', $_date);
    }
}

/**
 *******************************************
 *******************************************
 *******************************************
 * [ All about Location ]
 */

function getDistrictNameById($district_id)
{
	$db = new db_util();

	$sql = "SELECT vm_district_name
	FROM vm_district
	WHERE vm_district_id='$district_id'";

	$result = $db->query($sql);

	if ($result !== false) {
	// if there any error in sql then it will false
	// 
		if ($result->num_rows > 0) {

			$row = $result->fetch_assoc();

			return $row['vm_district_name'];

		}

	}

	return "Invalid Location";


}
function getGrpById($u_id)
{
 $db= new db_util();
 $sql = "SELECT * FROM vm_member_list WHERE vm_member_id=$u_id";
 $result = $db->query($sql);
 return $result;
}

function getGrpIdByUserId($u_id)
{
    $db= new db_util();
    $sql = "SELECT * FROM vm_member_list WHERE vm_member_id=$u_id";
    $result = $db->query($sql);
    if($result!==false)
    {
        if ($result->num_rows > 0) {

            $row = $result->fetch_assoc();

            return $row['vm_group_id'];

        }
    }

    return 0;
}

function getGrpDetailsByGrpId($g_id)
{
    $db= new db_util();
    $sql = "SELECT * FROM vm_group WHERE v_group_id=$g_id";
    $result = $db->query($sql);
    return $result;
}
function isInAnyGrp($u_id)
{
    $db = new db_util();
    $sql = "SELECT * FROM vm_member_list WHERE vm_member_id=$u_id";
    $result = $db->query($sql);
    if ($result !== false) {
        // if there any error in sql then it will false
        if ($result->num_rows > 0) {
            // if the sql execute successful then it give

            return true;
        }
    }
    return false;
}
function isPermenentInGrp($u_id)
{

    $_c_user_id = (isset($_COOKIE[$GLOBALS['c_id']]) ? $_COOKIE[$GLOBALS['c_id']] : 0);

    if ($_c_user_id != 0 && isUserLoggedIn()) {

        $db = new db_util();

        $sql = "SELECT vm_group_id FROM vm_member_list WHERE vm_member_id=$u_id";

        $result = $db->query($sql);
        if ($result !== false) {
            // if there any error in sql then it will false
            //
            if ($result->num_rows > 0) {

                $row = $result->fetch_assoc();
                if($row['vm_group_id']==NULL)
                {
                    return -99;
                }
                //die();
                return $row['vm_group_id'];

            }

        }
    }
}

//shafee
function isLeaderGrp($grpId)
{
    $u_id = $_COOKIE[$GLOBALS['c_id']];
    // echo $grpId;
    $db = new db_util();
    $sql = "SELECT v_group_leader_id FROM vm_group WHERE v_group_id=$grpId";
    $result = $db->query($sql);

    if ($result !== false) {
        // if there any error in sql then it will false
        //
        if ($result->num_rows > 0) {

            $row = $result->fetch_assoc();
            // echo $row['v_group_leader_id'];
            if ($row['v_group_leader_id'] == $u_id) {
                return true;
            }
            else
            {
                return false;
            }

        }
    }
}

/**
 * Send a e-mail
 * NOTE: If utf-8 error occur, try:
 * http://php.net/manual/en/function.mb-send-mail.php
 * http://stackoverflow.com/questions/7266935/how-to-send-utf-8-email.
 *
 * @param [type] $to      [description]
 * @param [type] $subject [description]
 * @param [type] $message [description]
 *
 * @return bool
 */
function _send_email($to)
{
    $subject = "Volunteer Management - Someone needed Help!";

    $message = "Please comeback! Someone need help!";

    $subject = "=?UTF-8?B?" . base64_encode($subject) . "?=";

    $headers[] = 'From: Team Shunno <no-replay@' . $GLOBALS['c_domain'] . '>';
    $headers[] = 'Content-Type: text/html; charset=UTF-8';

    return mail($to, $subject, $message, implode("\r\n", $headers));
}
