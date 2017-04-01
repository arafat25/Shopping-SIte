<?php
 ob_start();
 session_start();
 require_once 'dbconnect.php';
 
 if( !isset($_SESSION['user']) ) {
    header("Location: login.php");
    exit;
 }
?>

<!DOCTYPE html>
<html>
<head>
<title>Confirmation Page</title>
<style>
ul {
    list-style-type: none;
    margin: 0;
    padding: 0;
    overflow: hidden;
    background-color: #333;
}

li a{
    display: inline-block;
    color: white;
    text-align: center;
    padding: 14px 16px;
    text-decoration: none;
}

li a:hover{
    background-color: red;
}

a{
	text-decoration:none;
}
</style>
</head>
<body>
	<ul>
		<li style="float:right"><a href="index.php">Go Back</a></li>
	</ul><br /><br />
	<h1 align="center">THANK YOU FOR YOUR SHOPPING</h1>
	<h3 align="center">Your confirmation# is E1234567890</h3>
	<form align="center">
		<button type="button"><a href="index.php?cmd=emptycart">Continue to Shopping</a></button> or <button type="button"><a href="logout.php?logout">Logout</a></button>
	</form>
</body>
</html>