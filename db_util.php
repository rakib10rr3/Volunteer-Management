<?php

/**
 * Main Database Class
 */
class db_util
{

    /**
     * Main Connection
     */
    protected static $connection;

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
                    `user_name` varchar(255)  NOT NULL,
 					`user_email` varchar(255)  NOT NULL,
 					`user_password` varchar(255)  NOT NULL,
 					PRIMARY KEY (`user_id`)
                ) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci") or die('vm_users Creation failed!' . self::$connection->error);
            }

            if (self::$connection->query("SHOW TABLES LIKE 'vm_group'")->num_rows == 0) {

                // don't use ` instead of ' in query string. somethings it give error for unknown reason
                self::$connection->query("CREATE TABLE IF NOT EXISTS vm_group
(
                    v_group_id int not null AUTO_INCREMENT
                        primary key,
                    v_group_name varchar(256) default '' null,
                    v_group_place  varchar(256) null,
                    v_group_description  text null,
                    v_group_services  text null,
                    v_group_member_number int null,
                    v_group_leader_id int null
) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci") or die('vm_group Creation failed!' . self::$connection->error);
            }

            if (self::$connection->query("SHOW TABLES LIKE 'vm_member_list'")->num_rows == 0) {

                // don't use ` instead of ' in query string. somethings it give error for unknown reason
                self::$connection->query("CREATE TABLE IF NOT EXISTS vm_member_list
(
	vm_member_list_id int not null AUTO_INCREMENT
		primary key,
	vm_group_id int null,
	vm_member_id int null,
	vm_member_name  varchar(256) null,
	vm_member_email varchar(256) null,
	vm_member_phone  varchar(256) null,
	vm_member_type varchar(256) null,
	vm_member_age int null,
	vm_member_gender varchar(256) null,
	vm_member_picture varchar(256) null,
	vm_member_interest text null
) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci") or die('vm_member_list Creation failed!' . self::$connection->error);
            }

            /// service table
            if (self::$connection->query("SHOW TABLES LIKE 'vm_services'")->num_rows == 0) {

                // don't use ` instead of ' in query string. somethings it give error for unknown reason
                self::$connection->query("CREATE TABLE IF NOT EXISTS vm_services
(
	vm_service_id int not null auto_increment primary key,
	vm_service_name  varchar(256) null
  
) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci") or die('vm_services Creation failed!' . self::$connection->error);
            }

            /**
             * Digester Table
             */
            if (self::$connection->query("SHOW TABLES LIKE 'vm_disaster'")->num_rows == 0) {

                // don't use ` instead of ' in query string. somethings it give error for unknown reason
                self::$connection->query("CREATE TABLE IF NOT EXISTS vm_disaster
(
   vm_disaster_id int not null auto_increment
		primary key,
	vm_disaster_name varchar(256) not null,
	vm_disaster_locations varchar(256) not null,
	vm_disaster_type int not null,
	vm_disaster_start date not null,
	vm_disaster_expire date not null,
	vm_disaster_created_by int null,
	vm_disaster_added_by_group int null
) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci") or die('vm_disaster Creation failed!' . self::$connection->error);
            }
            /***
             * Message_Table
             */
            if (self::$connection->query("SHOW TABLES LIKE 'vm_messages'")->num_rows == 0) {

                // don't use ` instead of ' in query string. somethings it give error for unknown reason
                self::$connection->query("CREATE TABLE IF NOT EXISTS vm_messages
(
	vm_messages_id int not null auto_increment
		primary key,
	vm_message_text text null,
	vm_message_disaster_id int null,
	vm_message_to_group int null,
	vm_message_from_member int null,
	date datetime null
) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci") or die('vm_messages Creation failed!' . self::$connection->error);
            }


            /**
             * Division
             */
            if (self::$connection->query("SHOW TABLES LIKE 'vm_division'")->num_rows == 0) {

                // don't use ` instead of ' in query string. somethings it give error for unknown reason
                self::$connection->query("CREATE TABLE IF NOT EXISTS vm_division
(
    vm_division_id int not null AUTO_INCREMENT primary key,
    vm_division_name varchar(256) not null
) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci") or die('vm_division Creation failed!' . self::$connection->error);
            }

            /**
             * District
             */
            if (self::$connection->query("SHOW TABLES LIKE 'vm_district'")->num_rows == 0) {

                // don't use ` instead of ' in query string. somethings it give error for unknown reason
                self::$connection->query("CREATE TABLE IF NOT EXISTS vm_district
(
    vm_district_id int not null AUTO_INCREMENT primary key,
    vm_district_division_id int not null,
    vm_district_name varchar(256) not null
) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci") or die('vm_district Creation failed!' . self::$connection->error);
            }
            if (self::$connection->query("SHOW TABLES LIKE 'vm_response'")->num_rows == 0) {

                // don't use ` instead of ' in query string. somethings it give error for unknown reason
                self::$connection->query("CREATE TABLE IF NOT EXISTS vm_response
(
	vm_response_id int not null auto_increment
		primary key,
	vm_response_of_group int null,
	vm_response_of_disaster int null,
	vm_response_user_id int null

) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci") or die('vm_district Creation failed!' . self::$connection->error);
            }


            return self::$connection;
        }

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