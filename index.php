<?php

include "basic_structure/header.php";
include "basic_structure/navbar.php";

?>

<p class="w3-xlarge w3-center">Welcome!</p>
<p class="w3-large w3-center">Let's work togather to build a awesome Bangladesh!</p>



<div class="w3-row">
	<div class="w3-col m3 w3-container"></div>
	<div class="w3-col m6 w3-card-2">
		<div class="w3-container w3-center w3-white w3-xlarge w3-border-bottom ts-disaster-box-title"> <!-- 1 start -->
			<p>Call For Help</p>
		</div> 

		<?php

/**
 * IDEA:
 * - If user logged in then hilight the disesters which happend users location
 * - If user click on a locatin form Call-for-help s/he will get the search result of that page
 */

$db = new db_util();

$now_date = date("Y-m-d");

/**
 * Only Show NOT EXPIRED disasters.
 */

$sql = "SELECT * 
FROM vm_disaster 
WHERE vm_disaster_expire >= '$now_date'
ORDER BY vm_disaster_start DESC";
$result = $db->query($sql);

if ($result !== false) {
// if there any error in sql then it will false
	if ($result->num_rows > 0) {

		echo '<ul class="w3-ul w3-white">';

		while($row = $result->fetch_assoc()) {

			?>

			<li>

				<p class="ts-disaster-title"><?=$row['vm_disaster_name']?></p>
				
				<div class="w3-row">
					<div class="w3-half">
						<p class="ts-disaster-type"><i class="fa fa-life-bouy"></i> <?=Disaster::getDisasterNameById($row['vm_disaster_type'])?></p>
					</div>
					<div class="w3-half">
						<p class="ts-disaster-loc"><i class="fa fa-map-marker"></i> <?=getDistrictNameById($row['vm_disaster_locations'])?></p>
					</div>
				</div>
				
				
				

				<p class="ts-disaster-start"><i class="fa fa-calendar"></i> <?=date_format(date_create($row['vm_disaster_start']), "j M")?> to <?=date_format(date_create($row['vm_disaster_expire']), "j M")?></p>

			</li>

			<?php

		}

		echo "</ul>";

	} else {
		?>
		<div class="w3-container w3-center">
			<p>No active Call For Help!</p>
		</div>

		<?php
	}

} else {
	?>

	<p>No Call-For-Help!</p>

	<?php
}


?>

</div> <!-- 1 end -->
<div class="w3-col m3 w3-container"></div>
</div>









<?php

include "basic_structure/footer.php";

?>