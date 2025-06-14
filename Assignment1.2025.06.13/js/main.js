const headerGlobal = document.querySelector('#header-global');
const footerGlobal = document.querySelector('#footer-global')

headerGlobal.innerHTML = `
    <nav class="header-navigation">
    
        <div id="header-box-one">
            <div class="header-logo">
            <img src="css/images/header_logo.png" alt="Company Logo">
            </div>
            <h1 class="company-name">Urban Greenery and Garden Planning</h1>
        </div>
    
        <div id="header-box-two">
            <ul class="header-navigation-ul">
                <li class="header-navigation-li"><a href="index.php">Input Hours</a></li>
                <li class="header-navigation-li"><a href="review.php">Review Hours</a></li>
            </ul>
        </div>    
    </nav>`;

footerGlobal.innerHTML = `
    <nav class="footer-navigation">
    
    <div id="footer-box-one">
    
        <div class="footer-logo">
        <img src="css/images/footer_logo.png" alt="Company Logo">
        </div>
   
        <ul class="footer-navigation-ul">
            <li class="footer-navigation-li"><a href="index.php">Input Hours</a></li>
            <li class="footer-navigation-li"><a href="review.php">Review Hours</a></li>
        </ul>    

        </div>
        
    </nav>`;