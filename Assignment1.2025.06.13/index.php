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
    <link rel="stylesheet" href="css/index.css">
    <script src="js/main.js" defer></script>
</head>

<body>

<header id="header-global"></header>
<!--import with Javascript-->

<main id="main-page-container">

    <!--split main into three containers/boxes for flexbox layout -->

    <div class="main-box-one">
        <img src="css/images/box_one_skyline.png" alt="City Skyline">
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Blanditiis consequatur doloremque dolores,
            laudantium maiores molestias praesentium quibusdam quos veritatis voluptas. A alias autem, distinctio fugit
            officiis repellat sed temporibus tenetur?</p>
    </div>

    <div class="main-box-two">
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Culpa esse illo ipsa ipsum, quam rem repellendus
            saepe tempora! Ab amet debitis laudantium molestiae nemo odio repellendus reprehenderit totam voluptate.
            Possimus!</p>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Atque consectetur cumque esse exercitationem iusto
            minus nostrum possimus repudiandae. Alias cupiditate est magni molestias necessitatibus perspiciatis quidem
            tempore unde vel veniam.</p>
        <img src="css/images/box_two_city.jpg" alt="City Street">
    </div>

    <div class="main-box-three">

        <!--section for employee hours input form
        include labels for screen reader accessibility
        use post for method due to sensitive data
        give action add.php value as add.php handles the form's post logic
        input type text for name, id, and hours worked; date type for week worked, as it provides a calendar to select the week from -->

        <section class="index-form" id="index-form">
            <form method="post" id="index-form-id" action="add.php">
                <h3 id="form-title">Hours Worked</h3>

                <div id="form-box-one">
                    <label for="employeeName">Employee Name:</label>
                    <input type="text" id="employeeName" name="employeeName" placeholder="Please enter your name.">

                    <label for="employeeID">Employee ID:</label>
                    <input type="text" id="employeeID" name="employeeID" placeholder="Please enter your employee ID.">
                </div>

                <div id="form-box-two">
                    <label for="week">Week Worked:</label>
                    <input type="date" id="week" name="week">

                    <label for="hours">Hours Worked:</label>
                    <input type="text" id="hours" name="hours" placeholder="Please enter the hours worked.">
                </div>

                <div id="form-box-three">
                    <input type="submit" name="submit" value="Submit">
                    <!-- submit button to be targeted by add.php -->
                </div>

            </form>
        </section>

        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. A aliquam eaque error harum libero nisi non
            officiis reiciendis sequi, veniam vitae, voluptas voluptate! Aperiam fugiat iure obcaecati repudiandae.
            Animi, pariatur?</p>

    </div> <!-- close main-box-three -->

</main>

<footer id="footer-global"></footer>
<!--import with Javascript-->

</body>

</html>