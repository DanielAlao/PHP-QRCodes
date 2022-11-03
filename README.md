<p align="center"><b>PHP-QRCodes </b></p>
The University of Westminster were interested in further adapting the <em>PHP Dynamic Qr Code</em> application, which allows users to generate static + dynamic to reduce paper consumption across the university. 
This application, PHP-QRCodes is mainly built from the work of Giandonato Inverso, then further adapted by the university of Westminster. This application allows users to generate static + dynamic Qr codes with logos at the centre of the generated Qr codes.
<br><br>

<h1>Main Additions</h1>

<ul>
<li>New functionality to allow users to register an account, allowing them to login and generate the codes</li>
<li>Used Jeroen van den Enden's <em>qrcode</em> to generate the qr code which allows a logo at the centre of the generated qr codes</li>
<li>Dashboard allows users to view statistics of the Qr code they have generated. Only admin accounts will have access to all generated codes</li>
</ul>

<h2>What is needed</h2>
<ul>
<li>Supported PHP version : PHP 7.4 (recommended)</li>
<li>PHP GD: PHP 7.4 GD (recommended)</li>
<li>Mysql</li>
</ul>
<h2>How to use</h2>
<ul>
<li>Clone project from github</li>
<li>Edit config.php (in config folder) file by adding database configuration information</li>
<li>Create mysql database. You can find database tables in <em>qr_codes database table.txt</em></li>
<li>Lauch app in browser to <em>login.php</em></li>
</ul>
<h2>Refrences</h2>
<ul>
<li>Author: Daniel Bidemi - DanielAlao</li>
</ul>
<h2>Credits</h2>
<h3>This project was inspired by the work of:</h3>
<ul>
<li>PHP-Dynamic-Qr-Code: https://github.com/giandonatoinverso/PHP-Dynamic-Qr-code - MIT License </li>
<li>qrcode: https://github.com/endroid/qr-code - MIT License</li> 
</ul>


