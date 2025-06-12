const headerGlobal = document.querySelector('#header-global');
const footerGlobal = document.querySelector('footerSection')

headerGlobal.innerHTML = `
<header id="header-global">
    <nav class="header-navigation">
        <ul class="header-navigation-ul">
            <li class="header-navigation-li"><a href="/index.html">Input Hours</a></li>
            <li class="header-navigation-li"><a href="/content.html">Review Content</a></li>
        </ul>    
    </nav>
</header> `;

footerGlobal.innerHTML = `
<header id="footer-global">
    <nav class="footer-navigation">
        <ul class="footer-navigation-ul">
            <li class="footer-navigation-li"><a href="/index.html">Input Hours</a></li>
            <li class="footer-navigation-li"><a href="/content.html">Review Content</a></li>
        </ul>    
    </nav>
</header> `;