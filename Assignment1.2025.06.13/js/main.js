const headerGlobal = document.querySelector('#header-global');
const footerGlobal = document.querySelector('#footer-global')

headerGlobal.innerHTML = `
    <nav class="header-navigation">
           
        <div class="header-logo">
        <img src="css/images/header_footer_logo.png" alt="Company Logo">
        </div>
        
        <h1 class="company-name">Company Name</h1>
        
        <ul class="header-navigation-ul">
            <li class="header-navigation-li"><a href="/index.php">Input Hours</a></li>
            <li class="header-navigation-li"><a href="/content.php">Review Content</a></li>
        </ul>    
    </nav>`;

footerGlobal.innerHTML = `
    <nav class="footer-navigation">
    
        <div class="footer-logo">
        <img src="css/images/header_footer_logo.png" alt="Company Logo">

        </div>
    
        <ul class="footer-navigation-ul">
            <li class="footer-navigation-li"><a href="/index.php">Input Hours</a></li>
            <li class="footer-navigation-li"><a href="/content.php">Review Content</a></li>
        </ul>    
    </nav>`;