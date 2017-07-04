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
include 'db_util.php';
include 'classes.php';

/**
 *******************************************
 *******************************************
 *******************************************
 */

function validateInput($data)
{
    $data = trim($data); //Strip unnecessary characters (extra space, tab, newline)
    $data = stripslashes($data); //Remove backslashes (\)
    $data = htmlspecialchars($data, ENT_NOQUOTES, 'UTF-8');

    return $data;
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
