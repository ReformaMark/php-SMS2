<?php

declare(strict_types=1);


//dashboard
if(basename($_SERVER['PHP_SELF']) === 'dashboard.php'){
    echo '<a href="../layouts/dashboard.php" class="w-full flex items-center gap-x-3 bg-blue-500 translate-x-5 pl-5 rounded-l-full text-white transition-all duration-500 ease-linear font-normal text-lg  border-b p-1">
            <svg class="size-5 " height="32" data-name="Livello 1" id="Livello_1" viewBox="0 0 128 128" xmlns="http://www.w3.org/2000/svg"><title/><path d="M127.12,60.22,115.46,48.56h0L69,2.05a7,7,0,0,0-9.9,0L12.57,48.53h0L.88,60.22a3,3,0,0,0,4.24,4.24l6.57-6.57V121a7,7,0,0,0,7,7H46a7,7,0,0,0,7-7V81a1,1,0,0,1,1-1H74a1,1,0,0,1,1,1v40a7,7,0,0,0,7,7h27.34a7,7,0,0,0,7-7V57.92l6.54,6.54a3,3,0,0,0,4.24-4.24ZM110.34,121a1,1,0,0,1-1,1H82a1,1,0,0,1-1-1V81a7,7,0,0,0-7-7H54a7,7,0,0,0-7,7v40a1,1,0,0,1-1,1H18.69a1,1,0,0,1-1-1V51.9L63.29,6.29a1,1,0,0,1,1.41,0l45.63,45.63Z"/></svg>
            Dashboard
        </a>';
} else {
    echo '<a href="../layouts/dashboard.php" class="w-full flex items-center gap-x-3 pl-3 hover:bg-blue-500 hover:translate-x-5 hover:pl-5 hover:rounded-l-full hover:text-white transition-all duration-500 ease-linear  font-normal text-lg border-b p-1">
        <svg class="size-5 " height="32" id="icon" viewBox="0 0 32 32" width="32" xmlns="http://www.w3.org/2000/svg"><defs><style>.cls-1{fill:none;}</style></defs><title/><path d="M24,30H8a2.0023,2.0023,0,0,1-2-2V4A2.002,2.002,0,0,1,8,2H24a2.0023,2.0023,0,0,1,2,2V20.6182l-5-2.5-5,2.5V4H8V28H24V24h2v4A2.0027,2.0027,0,0,1,24,30ZM21,15.8818l3,1.5V4H18V17.3818Z"/><rect class="cls-1" data-name="&lt;Transparent Rectangle&gt;" height="32" id="_Transparent_Rectangle_" width="32"/></svg>    
            Dashboard
        </a>';
}

//transaction
if(basename($_SERVER['PHP_SELF']) === 'transactions.php'){
    echo '<a href="../layouts/transactions.php" class="w-full flex items-center gap-x-3 bg-blue-500 translate-x-5 pl-5 rounded-l-full text-white transition-all duration-500 ease-linear font-normal text-lg  border-b p-1">
        <svg class="size-5 " height="32" id="icon" viewBox="0 0 32 32" width="32" xmlns="http://www.w3.org/2000/svg"><defs><style>.cls-1{fill:none;}</style></defs><title/><path d="M24,30H8a2.0023,2.0023,0,0,1-2-2V4A2.002,2.002,0,0,1,8,2H24a2.0023,2.0023,0,0,1,2,2V20.6182l-5-2.5-5,2.5V4H8V28H24V24h2v4A2.0027,2.0027,0,0,1,24,30ZM21,15.8818l3,1.5V4H18V17.3818Z"/><rect class="cls-1" data-name="&lt;Transparent Rectangle&gt;" height="32" id="_Transparent_Rectangle_" width="32"/></svg>    
            Transactions
        </a>';
} else {
    echo '<a href="../layouts/transactions.php" class="w-full flex items-center gap-x-3 pl-3 hover:bg-blue-500 hover:translate-x-5 hover:pl-5 hover:rounded-l-full hover:text-white transition-all duration-500 ease-linear  font-normal text-lg border-b p-1">
        <svg class="size-5 " height="32" id="icon" viewBox="0 0 32 32" width="32" xmlns="http://www.w3.org/2000/svg"><defs><style>.cls-1{fill:none;}</style></defs><title/><path d="M24,30H8a2.0023,2.0023,0,0,1-2-2V4A2.002,2.002,0,0,1,8,2H24a2.0023,2.0023,0,0,1,2,2V20.6182l-5-2.5-5,2.5V4H8V28H24V24h2v4A2.0027,2.0027,0,0,1,24,30ZM21,15.8818l3,1.5V4H18V17.3818Z"/><rect class="cls-1" data-name="&lt;Transparent Rectangle&gt;" height="32" id="_Transparent_Rectangle_" width="32"/></svg>    
            Transactions
        </a>';
}

//enrollments
if(basename($_SERVER['PHP_SELF']) === 'enrollments.php'){
    echo 
    '<a href="../layouts/enrollments.php" class="w-full flex items-center gap-x-3 bg-blue-500 translate-x-5 pl-5 rounded-l-full text-white transition-all duration-500 ease-linear font-normal text-lg  border-b p-1">
        <svg class="size-5" viewBox="0 0 256 256" xmlns="http://www.w3.org/2000/svg"><rect fill="none" height="256" width="256"/><path d="M226.5,56.4l-96-32a8.5,8.5,0,0,0-5,0l-95.9,32h-.2l-1,.5h-.1l-1,.6c0,.1-.1.1-.2.2l-.8.7h0l-.7.8c0,.1-.1.1-.1.2l-.6.9c0,.1,0,.1-.1.2l-.4.9h0l-.3,1.1v.3A3.7,3.7,0,0,0,24,64v80a8,8,0,0,0,16,0V75.1L73.6,86.3A63.2,63.2,0,0,0,64,120a64,64,0,0,0,30,54.2,96.1,96.1,0,0,0-46.5,37.4,8.1,8.1,0,0,0,2.4,11.1,7.9,7.9,0,0,0,11-2.3,80,80,0,0,1,134.2,0,8,8,0,0,0,6.7,3.6,7.5,7.5,0,0,0,4.3-1.3,8.1,8.1,0,0,0,2.4-11.1A96.1,96.1,0,0,0,162,174.2,64,64,0,0,0,192,120a63.2,63.2,0,0,0-9.6-33.7l44.1-14.7a8,8,0,0,0,0-15.2ZM128,168a48,48,0,0,1-48-48,48.6,48.6,0,0,1,9.3-28.5l36.2,12.1a8,8,0,0,0,5,0l36.2-12.1A48.6,48.6,0,0,1,176,120,48,48,0,0,1,128,168Z"/></svg>
        Enrollments
    </a>';
} else {
    echo '<a href="../layouts/enrollments.php" class="w-full flex items-center gap-x-3 pl-3 hover:bg-blue-500 hover:translate-x-5 hover:pl-5 hover:rounded-l-full hover:text-white transition-all duration-500 ease-linear font-normal text-lg  border-b p-1">
    <svg class="size-5" viewBox="0 0 256 256" xmlns="http://www.w3.org/2000/svg"><rect fill="none" height="256" width="256"/><path d="M226.5,56.4l-96-32a8.5,8.5,0,0,0-5,0l-95.9,32h-.2l-1,.5h-.1l-1,.6c0,.1-.1.1-.2.2l-.8.7h0l-.7.8c0,.1-.1.1-.1.2l-.6.9c0,.1,0,.1-.1.2l-.4.9h0l-.3,1.1v.3A3.7,3.7,0,0,0,24,64v80a8,8,0,0,0,16,0V75.1L73.6,86.3A63.2,63.2,0,0,0,64,120a64,64,0,0,0,30,54.2,96.1,96.1,0,0,0-46.5,37.4,8.1,8.1,0,0,0,2.4,11.1,7.9,7.9,0,0,0,11-2.3,80,80,0,0,1,134.2,0,8,8,0,0,0,6.7,3.6,7.5,7.5,0,0,0,4.3-1.3,8.1,8.1,0,0,0,2.4-11.1A96.1,96.1,0,0,0,162,174.2,64,64,0,0,0,192,120a63.2,63.2,0,0,0-9.6-33.7l44.1-14.7a8,8,0,0,0,0-15.2ZM128,168a48,48,0,0,1-48-48,48.6,48.6,0,0,1,9.3-28.5l36.2,12.1a8,8,0,0,0,5,0l36.2-12.1A48.6,48.6,0,0,1,176,120,48,48,0,0,1,128,168Z"/></svg>
    Enrollments
    </a>';
}

//bi_reports
if(basename($_SERVER['PHP_SELF']) === 'bi_reports.php'){
    echo 
    '<a href="../layouts/bi_reports.php" class="w-full flex items-center gap-x-3 bg-blue-500 translate-x-5 pl-5 rounded-l-full text-white transition-all duration-500 ease-linear font-normal text-lg  border-b p-1">
        <svg class="size-5" id="bi_reports_icon" style="enable-background:new 0 0 50 50;" version="1.1" viewBox="0 0 50 50" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><g id="Layer_1_1_"><path d="M11,7H5v42h34v-6h6V1H11V7z M37,47H7V9h4h19v7h7v27V47z M32,10.414L35.586,14H32V10.414z M13,3h30v38h-4V14.586L31.414,7   H13V3z"/><path d="M22,14H10v12h12V14z M20,24h-8v-8h8V24z"/><rect height="2" width="9" x="25" y="19"/><rect height="2" width="9" x="25" y="24"/><rect height="2" width="15" x="10" y="29"/><rect height="2" width="6" x="28" y="29"/><rect height="2" width="6" x="10" y="34"/><rect height="2" width="15" x="19" y="34"/><rect height="2" width="14" x="10" y="39"/><rect height="2" width="7" x="27" y="39"/></g></svg>
        BI Reports
    </a>';
    
} else {
    echo 
    '<a href="../layouts/bi_reports.php" class="w-full flex items-center gap-x-3 pl-3 hover:bg-blue-500 hover:translate-x-5 hover:pl-5 hover:rounded-l-full hover:text-white transition-all duration-500 ease-linear font-normal text-lg border-b p-1">
        <svg class="size-5" id="bi_reports_icon" style="enable-background:new 0 0 50 50;" version="1.1" viewBox="0 0 50 50" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><g id="Layer_1_1_"><path d="M11,7H5v42h34v-6h6V1H11V7z M37,47H7V9h4h19v7h7v27V47z M32,10.414L35.586,14H32V10.414z M13,3h30v38h-4V14.586L31.414,7   H13V3z"/><path d="M22,14H10v12h12V14z M20,24h-8v-8h8V24z"/><rect height="2" width="9" x="25" y="19"/><rect height="2" width="9" x="25" y="24"/><rect height="2" width="15" x="10" y="29"/><rect height="2" width="6" x="28" y="29"/><rect height="2" width="6" x="10" y="34"/><rect height="2" width="15" x="19" y="34"/><rect height="2" width="14" x="10" y="39"/><rect height="2" width="7" x="27" y="39"/></g></svg>            BI Reports
    </a>';
}

//Payments
if(basename($_SERVER['PHP_SELF']) === 'payments.php'){
    echo 
    '<a href="../layouts/payments.php" class="w-full flex items-center gap-x-3 bg-blue-500 translate-x-5 pl-5 rounded-l-full text-white transition-all duration-500 ease-linear font-normal text-lg  border-b p-1">
        <svg class="size-5" id="Layer_1" style="enable-background:new 0 0 256 256;" version="1.1" viewBox="0 0 256 256" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><g><path d="M29.4,190.9c2.8,0,5-2.2,5-5v-52.3l30.2-16.2v42.9c0,2.8,2.2,5,5,5c2.8,0,5-2.2,5-5v-59.6l-50.1,26.9v58.3   C24.4,188.6,26.6,190.9,29.4,190.9z"/><path d="M89.6,153c2.8,0,5-2.2,5-5V59.6l30.2-16.2v143.8c0,2.8,2.2,5,5,5c2.8,0,5-2.2,5-5V26.7L84.6,53.6V148   C84.6,150.7,86.8,153,89.6,153z"/><path d="M149.8,185.7c2.8,0,5-2.2,5-5V85.4L185,69.2v86.3c0,2.8,2.2,5,5,5c2.8,0,5-2.2,5-5v-103l-50.1,26.9v101.3   C144.8,183.5,147.1,185.7,149.8,185.7z"/><path d="M250,146.2c-0.9-1.5-2.5-2.5-4.3-2.5h-34.5c-1.8,0-3.4,1-4.3,2.5c-0.9,1.5-0.9,3.4,0,5l6.2,10.7l-27.5,16.7   c-4.2,2.6-8.3,5.1-12.5,7.7c-3,1.9-6,3.7-8.9,5.6c-7.8,5-14.7,9.5-21.1,13.9c-3.3,2.2-6.5,4.5-9.8,6.7l-44.8-43.8L7.7,220.1   c-2.3,1.5-3,4.6-1.5,6.9c1,1.5,2.6,2.3,4.2,2.3c0.9,0,1.7-0.2,2.5-0.7l82.9-51.6l55.6,54.3c0.9,0.9,2.2,1.4,3.4,1.4   c0.9,0,1.9-0.3,2.7-0.8c3.3-2.2,6.6-4.4,9.8-6.7c6.6-4.4,13.4-9,21.3-14.1c3-1.9,6-3.8,9.1-5.7c4.2-2.6,8.5-5.2,12.7-7.9l28-17   l6,10.3c0.9,1.5,2.5,2.5,4.3,2.5c0.9,0,1.7-0.2,2.5-0.7c2.3-1.5,3-4.6,1.5-6.9l-11.3-19.6l11.5-6.9   C250.9,149.6,250.9,147.7,250,146.2z M164.2,226.5c-3.3,2.2-6.5,4.5-9.8,6.7l-55.6-54.3l14.5-9c16.3,15.9,31.6,31.2,32.6,32.1   c1.6,1.5,3.9,1.6,5.7,0.3c4.2-2.8,8.5-5.5,12.7-8.1c3-1.9,6-3.7,9-5.6c6.8-4.4,13.8-9,21.2-13.9l27.5-16.7l2.9,4.9L164.2,226.5z"/></g></svg>    
        Payments
    </a>';
} else {
    echo 
    '<a href="../layouts/payment.php" class="w-full flex items-center gap-x-3 pl-3 hover:bg-blue-500 hover:translate-x-5 hover:pl-5 hover:rounded-l-full hover:text-white transition-all duration-500 ease-linear font-normal text-lg border-b p-1">
        <svg class="size-5" id="Layer_1" style="enable-background:new 0 0 256 256;" version="1.1" viewBox="0 0 256 256" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><g><path d="M29.4,190.9c2.8,0,5-2.2,5-5v-52.3l30.2-16.2v42.9c0,2.8,2.2,5,5,5c2.8,0,5-2.2,5-5v-59.6l-50.1,26.9v58.3   C24.4,188.6,26.6,190.9,29.4,190.9z"/><path d="M89.6,153c2.8,0,5-2.2,5-5V59.6l30.2-16.2v143.8c0,2.8,2.2,5,5,5c2.8,0,5-2.2,5-5V26.7L84.6,53.6V148   C84.6,150.7,86.8,153,89.6,153z"/><path d="M149.8,185.7c2.8,0,5-2.2,5-5V85.4L185,69.2v86.3c0,2.8,2.2,5,5,5c2.8,0,5-2.2,5-5v-103l-50.1,26.9v101.3   C144.8,183.5,147.1,185.7,149.8,185.7z"/><path d="M250,146.2c-0.9-1.5-2.5-2.5-4.3-2.5h-34.5c-1.8,0-3.4,1-4.3,2.5c-0.9,1.5-0.9,3.4,0,5l6.2,10.7l-27.5,16.7   c-4.2,2.6-8.3,5.1-12.5,7.7c-3,1.9-6,3.7-8.9,5.6c-7.8,5-14.7,9.5-21.1,13.9c-3.3,2.2-6.5,4.5-9.8,6.7l-44.8-43.8L7.7,220.1   c-2.3,1.5-3,4.6-1.5,6.9c1,1.5,2.6,2.3,4.2,2.3c0.9,0,1.7-0.2,2.5-0.7l82.9-51.6l55.6,54.3c0.9,0.9,2.2,1.4,3.4,1.4   c0.9,0,1.9-0.3,2.7-0.8c3.3-2.2,6.6-4.4,9.8-6.7c6.6-4.4,13.4-9,21.3-14.1c3-1.9,6-3.8,9.1-5.7c4.2-2.6,8.5-5.2,12.7-7.9l28-17   l6,10.3c0.9,1.5,2.5,2.5,4.3,2.5c0.9,0,1.7-0.2,2.5-0.7c2.3-1.5,3-4.6,1.5-6.9l-11.3-19.6l11.5-6.9   C250.9,149.6,250.9,147.7,250,146.2z M164.2,226.5c-3.3,2.2-6.5,4.5-9.8,6.7l-55.6-54.3l14.5-9c16.3,15.9,31.6,31.2,32.6,32.1   c1.6,1.5,3.9,1.6,5.7,0.3c4.2-2.8,8.5-5.5,12.7-8.1c3-1.9,6-3.7,9-5.6c6.8-4.4,13.8-9,21.2-13.9l27.5-16.7l2.9,4.9L164.2,226.5z"/></g></svg>    
        Payments
    </a>';
}

