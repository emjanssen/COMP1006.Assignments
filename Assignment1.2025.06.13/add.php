<?php
require_once('crud.php');
require_once('validate.php');
// purpose: handle post logic for employee hours form

$crud = new crud();
// create new crud object called $crud
$valid = new validate();
// create new validate object called $valid

if (isset($_POST['submit'])) {
    // if submit button is pressed (i.e. submit value in index.html)

    // output values from form post inputs; escape special characters using function from crud; assign to relevant variables
    $employeeName = $crud->escape_string($_POST['employeeName']);
    $employeeID = $crud->escape_string($_POST['employeeID']);
    $week = $crud->escape_string($_POST['week']);
    $hours = $crud->escape_string($_POST['hours']);

    // call function from validator; pass in arguments for $data parameter and $fields parameter; assign checkEmpty() outcome to variable
    $msg = $valid->checkEmpty($_POST, array('employeeName', 'employeeID', 'week', 'hours'));

    if ($msg == null) {
        // if message returned from checkEmpty() is null, we have no errors

        if (!ctype_digit($employeeID) || !ctype_digit($hours)) {
            // built-in boolean functions to validate id and hours inputs
            // if either input isn't a digit, we echo an error message
            echo "Employee ID and hours worked must both be whole numbers.";
            // link back to index.php
            echo "<p><a href='index.php'>Go Back</a></p>";
            // exit code
            exit();
        }

        $result = $crud->execute("INSERT INTO assignment_one (employee_id, employee_name, week_worked, hours_worked) VALUES ('$employeeID', '$employeeName', '$week', '$hours')");
        // use crud execute() to add data into assignment_one table
        if ($result) {
            // if query is successful (i.e. $result = true), redirect to review.php page, and then exit after redirect
            header("Location: review.php");
            exit();
        } else { // if query is unsuccessfully, send error message
            echo "Error adding record";
            // link back to index.php
            echo "<p><a href='index.php'>Go Back</a></p>";
        }
    } else {
        echo $msg;
        // if message isn't null, we have errors; print message contents ("employeeName field cannot be empty", etc)
        echo "<p><a href='index.php'>Go Back</a></p>";
        // link back to index.php
    }
}
?>