<?php
require_once('crud.php');
require_once('validate.php');

$crud = new crud();
// create new crud object called $crud
$valid = new validate();
// create new validate object called $valid

if (isset($_POST['submit'])) {
    // if submit button is pressed (i.e. submit value in index.html)

    $employeeName = $crud->escape_string($_POST['employeeName']);
    $employeeID = $crud->escape_string($_POST['employeeID']);
    $week = $crud->escape_string($_POST['week']);
    $hours = $crud->escape_string($_POST['hours']);

    $msg = $valid->checkEmpty($_POST, array('employeeName', 'employeeID', 'week', 'hours'));

    if ($msg != null) {
        echo "<p>$msg</p>";
        echo "<a href='javascript:self.history.back();'>Go Back</a>";
    } else {
        $result = $crud->execute("INSERT INTO your_table_name (employeeName, employeeID, week, hours) VALUES ('$employeeName', '$employeeID', '$week', '$hours')");

        if ($result) {
            echo "<p>Record added</p>";
            echo "<a href='review.php'>View Results</a>";
        } else {
            echo "<p>Error adding record</p>";
            echo "<a href='javascript:self.history.back();'>Go Back</a>";
        }
    }
}
?>