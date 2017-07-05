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

	if ($_c_user_id != 0 && isUserLoggedIn($user_id)) {
        
		$db = new db_util();

	    $sql = "SELECT * 
	    FROM vm_member_list 
	    WHERE vm_member_list_id='$_c_user_id' 
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