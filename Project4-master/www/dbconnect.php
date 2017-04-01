<?php
   $dbhost = "localhost";
   $dbuser = "root";
   $dbpassword = "";
   $dbname = "project4";
   $dberror = "Could not connect to the database!";
   
   $db = mysqli_connect($dbhost, $dbuser, $dbpassword, $dbname) or die ($dberror);
?>