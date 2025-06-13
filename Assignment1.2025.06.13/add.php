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

    if ($msg == null) {
        $result = $crud->execute("INSERT INTO assignment_one (employee_id, employee_name, date_worked, hours_worked) VALUES ('$employeeID', '$employeeName', '$week', '$hours')");
        if ($result) {
            header("Location: review.php");
            exit();  // always exit after redirect
        } else {
            echo "Error adding record";
        }
    } else {
        echo $msg;
    }
}
?>