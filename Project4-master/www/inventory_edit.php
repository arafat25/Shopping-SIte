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
include ("dbconnect.php");
// Parse the form data and add inventory item to the system
if (isset($_POST['product_name'])) {
	$filetmp = $_FILES["image"]["tmp_name"];
	$filename = $_FILES["image"]["name"];
	$filetype = $_FILES["image"]["type"];
	$filepath = "image/".$filename;
	
	move_uploaded_file($filetmp,$filepath);
	
	$id = mysqli_real_escape_string($db,$_POST['thisID']);
    $product_name = mysqli_real_escape_string($db,$_POST['product_name']);
	$price = mysqli_real_escape_string($db,$_POST['price']);
	$category = mysqli_real_escape_string($db,$_POST['category']);
	$details = mysqli_real_escape_string($db,$_POST['details']);
	// See if that product name is an identical match to another product in the system
	$sql = mysqli_query($db,"UPDATE PRODUCT SET image='$filename', name='$product_name', price='$price', details='$details', category='$category' WHERE id='$id'");
	
	header("location: manage.php"); 
    exit();
}
?>

<?php 
include ("dbconnect.php");
// Gather this product's full information for inserting automatically into the edit form below on page
if (isset($_GET['pid'])) {
	$targetID = $_GET['pid'];
    $sql = mysqli_query($db,"SELECT * FROM PRODUCT WHERE id='$targetID' LIMIT 1");
    $productCount = mysqli_num_rows($sql); // count the output amount
    if ($productCount > 0) {
	    while($row = mysqli_fetch_array($sql)){
			 $filename = $row["image"];
			 $product_name = $row["name"];
			 $price = $row["price"];
			 $category = $row["category"];
			 $details = $row["details"];
        }
    } else {
	    echo "Sorry dude that crap dont exist.";
		exit();
    }
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
    Update Inventory
    </h1>
    <form action="inventory_edit.php" enctype="multipart/form-data" name="myForm" id="myform" method="post">
		Product Image: <input type="file" name="image" id="fileField" /><br /><br />
		Product Name: <input name="product_name" type="text" id="product_name" size="64" value="<?php echo $product_name; ?>" /><br /><br />
		Product Price: $<input name="price" type="text" id="price" size="12" value="<?php echo $price; ?>" /><br /><br />
		Category: <select name="category" id="category">
		  <option value="<?php echo $category; ?>"><?php echo $category; ?></option>
		  <option value="All Category">All Category</option>
		  <option value="Books">Books</option>
          <option value="Clothing">Clothing</option>
		  <option value="Electronics">Electronics</option>
		  <option value="Everything Else">Everything Else</option>
          </select><br /><br />
		Product Details: <br /><textarea name="details" id="details" cols="64" rows="5"><?php echo $details; ?></textarea><br /><br />
          <input name="thisID" type="hidden" value="<?php echo $targetID; ?>" />
          <input type="submit" name="button" id="button" value="Make Changes" />
    </form>
</div>
</body>
</html>