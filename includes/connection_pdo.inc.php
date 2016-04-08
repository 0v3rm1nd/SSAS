 <?php
 /*** connect to db ***/
$dbh = new PDO("mysql:host=localhost;dbname=ssas", 'root', '');
$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);