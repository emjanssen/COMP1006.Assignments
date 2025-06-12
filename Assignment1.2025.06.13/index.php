<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Record of employee hours">
    <meta name="keywords" content="employment, work, hours">
    <title>Employee Hours</title>
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/main.css">
    <script src="js/main.js" type="text/javascript" defer></script>
</head>

<body>

<header id="header-global"></header>

<div id="page-container">
    <main>
        <section class="index-form-class">
            <form method="post" id="index-form-id">
                <p>
                    <label for="name">Name:</label><br>
                    <input type="text" id="name" name="name" placeholder="Please enter your name.">
                </p>
                <p>
                    <label for="employeeID">Employee ID:</label><br>
                    <input type="text" id="employeeID" name="employeeID" placeholder="Please enter your employee ID".>
                </p>
                <p>
                    <label for="hours">Hours:</label><br>
                    <input type="text" id="hours" name="hours" placeholder="Please enter your hours worked.">
                </p>
                <p>
                    <input type="submit" value="Submit">
                </p>
            </form>
        </section>
    </main>
</div>

<footer id="footer-global"></footer>

</body>

</html>