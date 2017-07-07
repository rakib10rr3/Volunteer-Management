<?php

include "basic_structure/header.php";
include "basic_structure/navbar.php";
//include "db_util.php";-->included in the header file


?>

<?php
/**
 * Created by PhpStorm.
 * User: Me
 * Date: 7/4/2017
 * Time: 7:04 PM
 * ----
 */
if(isUserLoggedIn()==false)
{?>
    <p>You are not logged in pls login from <a href="login.php">here</a> </p>
    <?php
    exit();
}
//error variable
$place_error = "";

if (isset($_POST['Search'])) {
    $place = $_POST['place'];

    if (empty($place)) {
        $place_error = "Field Cannot be empty ! ";

    }
    //echo "user is searching for the place ".$place;
    if (empty($place_error)) {
        search_the_place($place);

    }

}
?>



<?php

/***
 * ei page er function gula ekhane likhtesi
 */
function search_the_place($place)
{
    $value = "";
    $db = new db_util();
    $query_string = "SELECT * FROM vm_group where v_group_place = '$place' ";
    $result = $db->query($query_string);
    if (mysqli_num_rows($result) > 0) {
        echo "<h2 class='alert-success '>Total " . mysqli_num_rows($result) . " Results found !</h2>";
        show_all_the_group($result);
    } else {
        echo "<h2 class='text-center text-danger '>Sorry ! Couldnt find any group </h2>";
        echo "<a href=''>Create a Group </a>";
    }


}
function show_all_the_group($result)
{

?>

<div class="col-md-12">
    <table class=" table table-bordered table-responsive table-hover">
        <thead>
        <tr>
            <th> Name</th>
            <th> Place</th>
            <th> description</th>
            <th> Member_number</th>
            <th> Leader</th>
            <th> </th>
        </tr>
        </thead>
        <tbody>
        <?php
        while ($row = mysqli_fetch_assoc($result)) {

            $group_name = $row['v_group_name'];
            $group_id = $row['v_group_id'];
            $group_place = $row['v_group_place'];
            $group_desc = $row['v_group_description'];
            $group_leader_name = $row['v_group_leader_id'];
            $group_member_number = $row['v_group_member_number'];
            echo "<tr>";
            echo "<td>{$group_name}</td>";
            echo "<td>{$group_place}</td>";
            echo "<td>{$group_desc}</td>";
            echo "<td>{$group_leader_name} </td>";
            echo "<td>{$group_member_number} </td>";
            echo "<td> <a class='navbar-link' href='group_details.php?group_id=$group_id'>View Details </a> </td>";
            echo "</tr>";
        }
        // exit();
        ?>
        </tbody>
    </table>

    <?php
    }
    ?>


    <form method="post" action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>">

        <?php if (!empty($place_error)) {
            echo "<h3  class='text-center text-danger'>$place_error</h3>";
        }
        ?>
<!--        <label for="place"> Search With a Place </label>-->
<!--        <input type="text" name="place">-->
        <p>
            <label for="division">Group Place</label>
            <select id="division" class="w3-select w3-border" name="division" required>
                <option value="0" selected>Choose Division</option>
                <option value="1">Barisal</option>
                <option value="2">Chittagong</option>
                <option value="3">Dhaka</option>
                <option value="4">Khulna</option>
                <option value="5">Mymensingh</option>
                <option value="6">Rajshahi</option>
                <option value="7">Rangpur</option>
                <option value="8">Sylhet</option>
            </select>
        </p>
        <p>
            <select id="district" class="w3-select w3-border" name="place" disabled required>
            </select>
        </p>

        <script type="text/javascript">
            $(function(){

                $("#division").change(function(){

                    var div_id = $("#division").val();

                    console.log(div_id);

                    if(div_id == "0")
                    {
                        var sel = $("#district");
                        sel.empty();
                        sel.prop("disabled", true);
                    } else {

                        $options = {
                            type: "district",
                            division_id: div_id
                        };


                        $.post("data.php", $options, function (data) {

                            console.log(data);

                            $obj = jQuery.parseJSON(data);

                            if($obj.success == true) {

                                var sel = $("#district");
                                sel.empty();
                                for (var i=0; i<$obj.data.length; i++) {
                                    sel.append('<option value="' + $obj.data[i].id + '">' + $obj.data[i].name + '</option>');
                                }

                                sel.prop("disabled", false);
                            }

                        });
                    }

                });

            });
        </script>


        <br>

        <input type="submit" value="Search" name="Search">
    </form>
<?php
include "basic_structure/footer.php";
?>