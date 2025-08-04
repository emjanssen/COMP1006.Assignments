<header id="global-header">
    <div id="header-logo">
        <img id="img-logo" src="../css/img/headerLogo.png" alt="Page logo.">
    </div>

    <div id="header-title">
        <h1><?php echo htmlspecialchars($pageTitle ?? 'Default Title'); ?></h1>
    </div>

    <nav id="header-nav">
        <ul id="header-nav-ul">
            <!-- Root Folder -->
            <li><a href="../index.php">Home</a></li>

            <!-- Public -->
            <li><a href="../public/about.php">About</a></li>
            <li><a href="../public/login.php">Login</a></li>
            <li><a href="../public/register.php">Register</a></li>

            <!-- Private -->
            <li><a href="../private/profile.php">Profile</a></li>
            <li><a href="../private/dashboard.php">Dashboard</a></li>
        </ul>
    </nav>
</header>
