<?php
/**
* Main Database Class
*/

class db_util {

	/**
	* Main Connection
	*/
	protected static $connection;

	/**
     * Connect to the database.
     */
    public function connect()
    {
        // Try and connect to the database
        if (!isset(self::$connection)) {

            include 'var.php';

            self::$connection = new mysqli($server_name, $user_name, $password, $database_name);
        }


        // If connection was not successful, handle the error
        if (self::$connection === false) {
            // Handle error - notify administrator, log to a file, show an error screen, etc.
            _error_log('Cannot connect to database! Error Message: ' . self::$connection->error);

            return false;
        } else {
            // Must set it.. Otherwise Unicode strings will be broken in query/database.
            self::$connection->set_charset('utf8');

            // USER table
            if (self::$connection->query("SHOW TABLES LIKE 'vm_users'")->num_rows == 0) {

                // don't use ` instead of ' in query string. somethings it give error for unknown reason
                self::$connection->query("CREATE TABLE IF NOT EXISTS `vm_users` (
                    `user_id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
                    `user_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
 					`user_email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
 					`user_password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
 					PRIMARY KEY (`user_id`)
                ) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci") or die('Table 1 Creation failed!' . self::$connection->error);
            }

            return self::$connection;
        }

    }

    /**
	* Query the database.
	*/
	public function query($query)
	{
		// Connect to the database
		$connection = $this->connect();

		// Query the database
		$result = $connection->query($query);

		return $result;
	}

	/**
	* Fetch rows from the database and
	* return as an Array
	*/
	public function select($query)
	{
		$rows = array();
		$result = $this->query($query);
		if ($result === false) {
			return false;
		}
		while ($row = $result->fetch_assoc()) {
			$rows[] = $row;
		}

		return $rows;
	}

	/**
	* Prepare the database.
	*
	* @param $query string The query string
	*
	* @return boolean result of the mysqli::prepare() function
 	*/
    public function prepare($query)
    {
        // Connect to the database
        $connection = $this->connect();

        // Query the database
        $result = $connection->prepare($query);

        return $result;
    }

    public function getError()
    {
        return self::$connection->error;
    }



}