<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Record of employee hours">
    <meta name="keywords" content="employment, work, hours">
    <title>Employee Hours</title>
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/review.css">
    <script src="js/main.js" defer></script>
</head>

<body>

<header id="header-global"></header>

<main id="review-page-container">

    <table id="review-table">

        <?php include 'crud.php';
        $crud = new crud();
        // create new crud object; allows us to access crud and database functions

        $query = "SELECT * FROM assignment_one";
        // run query to select all date from assignment_one table in database
        $result = $crud->getData($query);
        // use the getData() function in crud class; pass in $query value, and assign outcome to $result
        ?>

        <tr id="review-table-tr">
            <!--creates our table headings -->
            <th>Employee ID</th>
            <th>Employee Name</th>
            <th>Day Worked</th>
            <th>Hours Worked</th>
        </tr>

        <?php
        foreach ($result as $res) {
            // iterate over each value in $results array

            echo "<tr>";
            // start a new table row
            echo "<td>" . htmlspecialchars($res['employee_id']) . "</td>";
            // add current $res value to table: employee_id, with special characters escaped
            echo "<td>" . htmlspecialchars($res['employee_name']) . "</td>";
            // add current $res value to table: employee_name, with special characters escaped
            echo "<td>" . htmlspecialchars($res['date_worked']) . "</td>";
            // add current $res value to table: date_worked, with special characters escaped
            echo "<td>" . htmlspecialchars($res['hours_worked']) . "</td>";
            // add current $res value to table: hours_worked, with special characters escaped
            echo "</tr>";
            // end of the table row
        } ?>
    </table>
</main>

<footer id="footer-global"></footer>

</body>

</html>