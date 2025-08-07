<header class="global-header">
    <div id="header-logo">
        <img id="img-logo" src="css/img/headerLogo.png" alt="Page logo.">
    </div>

    <div id="header-title">
        <h1><?php echo htmlspecialchars($pageTitle ?? 'Default Title'); ?></h1>
    </div>

    <nav id="header-nav">
        <ul id="header-nav-ul">
            <li><a href="index.php">Home</a></li>
            <li><a href="login.php">Login</a></li>
            <li><a href="register.php">Register</a></li>
            <li><a href="profile.php">Profile</a></li>
            <li><a href="about.php">About</a></li>
            <li><a href="dashboard.php">Dashboard</a></li>
        </ul>
    </nav>
</header>