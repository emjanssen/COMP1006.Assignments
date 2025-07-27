<header id="global-header">

    <div id="header-global-grid">

        <div id="header-global-grid-col-one">
            <div id="header-logo">
                <img id="img-logo" src="css/img/headerLogo.png" alt="Page logo.">
            </div>
        </div>

        <div id="header-global-grid-col-two">
            <div id="header-title">
                <h1><?php echo htmlspecialchars($pageTitle ?? 'Default Title'); ?></h1>
            </div>
        </div>

        <div id="header-global-grid-col-three">
            <nav id="header-nav">
                <ul id="header-navigation-ul">
                    <li><a href="index.php">Home</a></li>
                    <li><a href="register.php">Register</a></li>
                    <li><a href="login.php">Login</a></li>
                </ul>
            </nav>
        </div>
    </div>
</header>
