<?php
$servername = "localhost";
$username = "root";
$password = "";
$conn = mysqli_connect($servername, $username, $password);
if (!$conn) {
    die("" . mysqli_connect_error());
} else {
    echo '<div class="alert alert-success fade show" role="alert"><strong>Connected to database</strong></div>';
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {


    $query = 'CREATE DATABASE IF NOT EXISTS user_data ';
    $result = mysqli_query($conn, $query);
    if (!$result) {
        die('' . mysqli_error($conn));
    }
    $query = 'CREATE TABLE IF NOT EXISTS `user_data`.`information` (`username` VARCHAR(50) NOT NULL , `first_name` VARCHAR(50) NOT NULL , `last_name` VARCHAR(50) NOT NULL , `city` VARCHAR(50) NOT NULL , `state` VARCHAR(50) NOT NULL , `zip` INT(10) NOT NULL, `date-time` DATETIME NOT NULL , PRIMARY KEY (`username`)) ENGINE = InnoDB; ';
    $result = mysqli_query($conn, $query);
    if (!$result) {
        die('' . mysqli_error($conn));
    }

    if (isset($_POST['delete'])) {
        $first_name = $_POST["fname"];
        $last_name = $_POST["lname"];
        $user_name = $_POST["username"];
        $city = $_POST["city"];
        $state = $_POST["state"];
        $zip = $_POST["zip"];
        $delete_username = $_POST['delete_username'];
        $delete_sql = "DELETE FROM `user_data`.`information` WHERE `username`='$delete_username'";
        $delete_result = mysqli_query($conn, $delete_sql);
        if (!$delete_result) {
            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>An error occurred while deleting:</strong> ' . mysqli_error($conn) . '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
        } else {
            echo '<div class="alert alert-success fade show" role="alert"><strong>User deleted successfully</strong></div>';
        }
        header("Location: index.php");
    } elseif (isset($_POST['insert'])) {
        $first_name = $_POST["fname"];
        $last_name = $_POST["lname"];
        $user_name = $_POST["username"];
        $city = $_POST["city"];
        $state = $_POST["state"];
        $zip = $_POST["zip"];
        $check_sql = "SELECT * FROM `user_data`.`information` WHERE `username` = '$user_name'";
        $check_result = mysqli_query($conn, $check_sql);
        $numer_row = mysqli_num_rows($check_result);
        if ($numer_row > 0) {
            echo '<div class="alert alert-warning alert-dismissible fade show" role="alert"><strong>Username already exists</strong><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
        } else {
            $insert_sql = "INSERT INTO `user_data`.`information` (`username`, `first_name`,`last_name`,`city`,`state`,`zip`,`date-time`) VALUES ('$user_name', '$first_name', '$last_name', '$city', '$state', '$zip', NOW())";
            $insert_result = mysqli_query($conn, $insert_sql);
            if (!$insert_result) {
                echo '<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>An error occurred:</strong> ' . mysqli_error($conn) . '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
            }
        }
    } 
        
    
    elseif (isset($_POST['edit'])) {
        $edit_username = $_POST['edit_username'];
        $query = "SELECT * FROM `user_data`.`information` WHERE `username`='$edit_username'";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($result);
        echo "<form method='post'>
                <input type='hidden' name='edit_username' value='$edit_username'>
                <input type='text' name='edited_fname' value='{$row['first_name']}' required>
                <input type='text' name='edited_lname' value='{$row['last_name']}' required>
                <input type='text' name='edited_city' value='{$row['city']}' required>
                <select name='edited_state' required>
                    <option selected  value='{$row['city']}'>{$row['state']}</option>
                    <option value='Andra Pradesh'>Andra Pradesh</option>
                    <option value='Arunachal Pradesh'>Arunachal Pradesh</option>
                    <option value='Assam'>Assam</option>
                    <option value='Bihar'>Bihar</option>
                    <option value='Chhattisgarh'>Chhattisgarh</option>
                    <option value='Goa'>Goa</option>
                    <option value='Gujarat'>Gujarat</option>
                    <option value='Haryana'>Haryana</option>
                    <option value='Himachal Pradesh'>Himachal Pradesh</option>
                    <option value='Jammu and Kashmir'>Jammu and Kashmir</option>
                    <option value='Jharkhand'>Jharkhand</option>
                    <option value='Karnataka'>Karnataka</option>
                    <option value='Kerala'>Kerala</option>
                    <option value='Madya Pradesh'>Madya Pradesh</option>
                    <option value='Maharashtra'>Maharashtra</option>
                    <option value='Manipur'>Manipur</option>
                    <option value='Meghalaya'>Meghalaya</option>
                    <option value='Mizoram'>Mizoram</option>
                    <option value='Nagaland'>Nagaland</option>
                    <option value='Orissa'>Orissa</option>
                    <option value='Punjab'>Punjab</option>
                    <option value='Rajasthan'>Rajasthan</option>
                    <option value='Sikkim'>Sikkim</option>
                    <option value='Tamil Nadu'>Tamil Nadu</option>
                    <option value='Telangana'>Telangana</option>
                    <option value='Tripura'>Tripura</option>
                    <option value='Uttaranchal'>Uttaranchal</option>
                    <option value='Uttar Pradesh'>Uttar Pradesh</option>
                    <option value='West Bengal'>West Bengal</option>
                </select>
                <input type='text' name='edited_zip' value='{$row['zip']}' required>
                <button type='submit' name='update'>Update</button>
              </form>";
    }
    if (isset($_POST['update'])) {
        $edited_fname = $_POST['edited_fname'];
        $edited_lname = $_POST['edited_lname'];
        $edited_city = $_POST['edited_city'];
        $edited_state = $_POST['edited_state'];
        $edited_zip = $_POST['edited_zip'];
        $edit_username = $_POST['edit_username'];
        $update_query = "UPDATE `user_data`.`information` SET 
                        `first_name`='$edited_fname', 
                        `last_name`='$edited_lname', 
                        `city`='$edited_city', 
                        `state`='$edited_state', 
                        `zip`='$edited_zip',
                        `date-time`=NOW()
                        WHERE `username`='$edit_username'";
        $update_result = mysqli_query($conn, $update_query);
        if (!$update_result) {
            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>An error occurred while updating:</strong> ' . mysqli_error($conn) . '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
        } else {
            echo '<div class="alert alert-success fade show" role="alert"><strong>User updated successfully</strong></div>';
        }
        header("Location: index.php");
    }
}

?>






<!DOCTYPE html>

<head>
    <title>CRUD</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        body {
            background-color: beige;
        }
    </style>

</head>

<body>
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    ...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>
    <form class="row g-3" action='index.php' method='post'>
        <legend>Fill out the form:</legend>
        <div class="col-md-4">
            <label for="validationDefault01" class="form-label">First name</label>
            <input type="text" class="form-control" id="validationDefault01" name="fname" required>
        </div>
        <div class="col-md-4">
            <label for="validationDefault02" class="form-label">Last name</label>
            <input type="text" class="form-control" id="validationDefault02" name="lname" required>
        </div>
        <div class="col-md-4">
            <label for="validationDefaultUsername" class="form-label">Username</label>
            <div class="input-group">
                <span class="input-group-text" id="inputGroupPrepend2">@</span>
                <input type="text" class="form-control" id="validationDefaultUsername" aria-describedby="inputGroupPrepend2" name="username" required>
            </div>
        </div>
        <div class="col-md-6">
            <label for="validationDefault03" class="form-label">City</label>
            <input type="text" class="form-control" id="validationDefault03" name="city" required>
        </div>
        <div class="col-md-3">
            <label for="validationDefault04" class="form-label">State</label>
            <select class="form-select" id="validationDefault04" name="state" required>
                <option selected disabled value="">Choose...</option>
                <option value="Andra Pradesh">Andra Pradesh</option>
                <option value="Arunachal Pradesh">Arunachal Pradesh</option>
                <option value="Assam">Assam</option>
                <option value="Bihar">Bihar</option>
                <option value="Chhattisgarh">Chhattisgarh</option>
                <option value="Goa">Goa</option>
                <option value="Gujarat">Gujarat</option>
                <option value="Haryana">Haryana</option>
                <option value="Himachal Pradesh">Himachal Pradesh</option>
                <option value="Jammu and Kashmir">Jammu and Kashmir</option>
                <option value="Jharkhand">Jharkhand</option>
                <option value="Karnataka">Karnataka</option>
                <option value="Kerala">Kerala</option>
                <option value="Madya Pradesh">Madya Pradesh</option>
                <option value="Maharashtra">Maharashtra</option>
                <option value="Manipur">Manipur</option>
                <option value="Meghalaya">Meghalaya</option>
                <option value="Mizoram">Mizoram</option>
                <option value="Nagaland">Nagaland</option>
                <option value="Orissa">Orissa</option>
                <option value="Punjab">Punjab</option>
                <option value="Rajasthan">Rajasthan</option>
                <option value="Sikkim">Sikkim</option>
                <option value="Tamil Nadu">Tamil Nadu</option>
                <option value="Telangana">Telangana</option>
                <option value="Tripura">Tripura</option>
                <option value="Uttaranchal">Uttaranchal</option>
                <option value="Uttar Pradesh">Uttar Pradesh</option>
                <option value="West Bengal">West Bengal</option>
            </select>

        </div>
        <div class="col-md-3">
            <label for="validationDefault05" class="form-label">Zip</label>
            <input type="text" class="form-control" id="validationDefault05" name="zip" required>
        </div>
        <div class="col-12">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="" id="invalidCheck2" required>
                <label class="form-check-label" for="invalidCheck2">
                    Submit data to database?
                </label>
            </div>
        </div>
        <div class="col-12">
            <button class="btn btn-primary" name='insert' type="submit">Submit form</button>
        </div>
    </form>
    <?php
    echo "<table class='table'><thead><tr><th scope='col'>Username</th><th scope='col'>First_name</th><th scope='col'>Last_name</th><th scope='col'>City</th><th scope='col'>State</th><th scope='col'>Zip</th><th scope='col'>date-time</th><th scope='col'>Action</th></tr></thead>";
    $sql = 'SELECT * FROM `user_data`.`information`';
    $result = mysqli_query($conn, $sql);

    $num = mysqli_num_rows($result);
    if ($num > 0) {

        while ($row = mysqli_fetch_assoc($result)) {
            $u = $row["username"];
            $f = $row["first_name"];
            $l = $row["last_name"];
            $c = $row["city"];
            $s = $row["state"];
            $z = $row["zip"];
            $d = $row["date-time"];
            echo "<tbody><tr><td>$u</td><td>$f</td><td>$l</td><td>$c</td><td>$s</td><td>$z</td><td>$d</td><td><form method='post' style='display: inline;'><input type='hidden' name='edit_username' value='$u'><button type='submit' name='edit'>Edit</button></form> <form method='post' style='display: inline;'><input type='hidden' name='delete_username' value='$u'><button type='submit' name='delete' >Del</button></form></td></tr>";
        }
    }

    ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>