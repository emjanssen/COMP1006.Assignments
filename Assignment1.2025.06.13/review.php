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
        $query = "SELECT * FROM assignment_one";
        $result = $crud->getData($query); ?>

        <tr id="review-table-tr">
            <th>Employee ID</th>
            <th>Employee Name</th>
            <th>Day Worked</th>
            <th>Hours Worked</th>
        </tr>

        <?php foreach ($result as $key => $res) {
            echo "<tr>";
            echo "<td>" . $res['employee_id'] . "</td>";
            echo "<td>" . $res['employee_name'] . "</td>";
            echo "<td>" . $res['date_worked'] . "</td>";
            echo "<td>" . $res['hours_worked'] . "</td>";
            echo "</tr>";
        } ?>
    </table>

</main>

<footer id="footer-global"></footer>

</body>

</html>