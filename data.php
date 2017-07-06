<?php
/**
 * This file only use for get data.
 *
 * In: POST request
 * Out: json data
 */

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	include_once 'func.php';

	/**
	 * Default Result
	 */
	$_success = false;
	$_data = "Something Wrong!";

/**
 * District List
 */
	if(isset($_POST['type'])) {

		$_type = $_POST['type'];
		
		if($_type == "district") {

			$_division_id = (isset($_POST['division_id'])) ? $_POST['division_id'] : 0 ;

			$db = new db_util();

			$sql = "SELECT vm_district_id, vm_district_name
			FROM vm_district
			WHERE vm_district_division_id='$_division_id'";

			$result = $db->query($sql);

			if ($result !== false) {
            // if there any error in sql then it will false
				if ($result->num_rows > 0) {


					$GLOBALS['_success'] = true;

					$rows = array();

					while($row = $result->fetch_assoc()) {
						$rows[] = array(
							'id' => $row['vm_district_id'],
							'name' => $row['vm_district_name'],
						);
					}

					$GLOBALS['_data'] = $rows;

				}

			}



		}

	}

	$data = array(
		"success" => $_success,
		"data" => $_data
		);

	echo json_encode($data);

} else {
	echo "Error 404! CALL 911!";
}
