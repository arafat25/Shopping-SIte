<?php

 ob_start();
 session_start();
 require_once 'dbconnect.php';
 
 if( !isset($_SESSION['admin']) ) {
    header("Location: admin.php");
    exit;
 }
?>

<?php 
// Parse the form data and add inventory item to the system
if (isset($_POST['button'])) {
	$filetmp = $_FILES["image"]["tmp_name"];
	$filename = $_FILES["image"]["name"];
	$filetype = $_FILES["image"]["type"];
	$filepath = "image/".$filename;
	
	move_uploaded_file($filetmp,$filepath);
	
    $product_name = mysqli_real_escape_string($db,$_POST['product_name']);
	$price = mysqli_real_escape_string($db,$_POST['price']);
	$category = mysqli_real_escape_string($db,$_POST['category']);
	$details = mysqli_real_escape_string($db,$_POST['details']);
	
	// Add this product into the database now
	$sql = mysqli_query($db,"INSERT INTO PRODUCT (image, name, price, details, category, date_created) 
        VALUES('$filename', '$product_name','$price','$details','$category',now())");
	header("location: manage.php");
    exit();
}
?>

<!DOCTYPE>


<html>
<head>
<title>Inventory List</title>
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
</style>
</head>

<body>
<div align="left">
    <a name="inventoryForm" id="inventoryForm"></a>
	<ul>
		<li style="float:right"><a href="manage.php">Go Back</a></li>
	</ul>
    <h1>
    Add New Inventory
    </h1>
    <form action="inventory.php" enctype="multipart/form-data" name="myForm" id="myform" method="post">
		Product Image: <input type="file" name="image" /><br /><br />
		Product Name: <input name="product_name" type="text" id="product_name" size="64" /><br /><br />
		Product Price: $<input name="price" type="text" id="price" size="12" /><br /><br />
		Category: <select name="category" id="category">
		  <option value="All Category">All Category</option>
		  <option value="Books">Books</option>
          <option value="Clothing">Clothing</option>
		  <option value="Electronics">Electronics</option>
		  <option value="Everything Else">Everything Else</option>
          </select><br /><br />
		Product Details: <br /><textarea name="details" id="details" cols="64" rows="5"></textarea><br /><br />
        <input type="submit" name="button" id="button" value="Add This Item Now" />
    </form>
</div>
</body>
</html>