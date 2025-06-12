const headerGlobal = document.querySelector('#header-global');
const footerGlobal = document.querySelector('#footer-global')

headerGlobal.innerHTML = `
    <nav class="header-navigation">
        <ul class="header-navigation-ul">
            <li class="header-navigation-li"><a href="/index.php">Input Hours</a></li>
            <li class="header-navigation-li"><a href="/content.php">Review Content</a></li>
        </ul>    
    </nav>`;

footerGlobal.innerHTML = `
    <nav class="footer-navigation">
        <ul class="footer-navigation-ul">
            <li class="footer-navigation-li"><a href="/index.php">Input Hours</a></li>
            <li class="footer-navigation-li"><a href="/content.php">Review Content</a></li>
        </ul>    
    </nav>`;