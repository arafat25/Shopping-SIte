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
include("dbconnect.php");
// Delete Item Question to Admin, and Delete Product if they choose
if (isset($_GET['deleteid'])) {
	echo 'Do you really want to delete product with ID of ' . $_GET['deleteid'] . '? <a href="manage.php?yesdelete=' . $_GET['deleteid'] . '">Yes</a> | <a href="manage.php">No</a>';
	exit();
}
if (isset($_GET['yesdelete'])) {
	// remove item from system and delete its picture
	// delete from database
	$id_to_delete = $_GET['yesdelete'];
	$sql = mysqli_query($db,"DELETE FROM PRODUCT WHERE id='$id_to_delete' LIMIT 1") or die (mysqli_error());
	// unlink the image from server
	// Remove The Pic -------------------------------------------
    $pictodelete = ("../inventory_images/$id_to_delete.jpg");
    if (file_exists($pictodelete)) {
       		    unlink($pictodelete);
    }
	header("location: manage.php"); 
    exit();
}
?>

<?php 
// This block grabs the whole list for viewing
$product_list = "";
$sql = mysqli_query($db,"SELECT * FROM PRODUCT ORDER BY date_created DESC");
$productCount = mysqli_num_rows($sql); // count the output amount
if ($productCount > 0) {
	while($row = mysqli_fetch_array($sql)){ 
             $id = $row["id"];
			 $product_name = $row["name"];
			 $price = $row["price"];
			 $category = $row["category"];
			 $details = $row["details"];
			 $product_list .= "<tr><td>$id</td><td>$product_name</td><td>$$price</td><td>$category</td><td>$details</td><td><a href='inventory_edit.php?pid=$id'>Edit</a>&nbsp&nbsp<a href='manage.php?deleteid=$id'>Delete</a></td></tr>";
    }
} else {
	$product_list = "There are no products listed.";
}
error_reporting(E_ALL ^ E_NOTICE);
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
table {
    width:100%;
}
table, th, td {
    border: 1px solid black;
    border-collapse: collapse;
}
th, td {
    padding: 5px;
    text-align: left;
}

a{
	text-decoration:none;
}
</style>
</head>

<body>
<div align="center">
  <ul>
	<li style="float:left"><a href="inventory.php#inventoryForm">+ Add</a></li>
	<li style="float:right"><a href="logout_admin.php?logout">Logout</a></li>
  </ul>
  <br />
	<div align="left" style="margin-left:24px;">
      <h2>Inventory list</h2>
	  <table>
		<tr>
			<th>ID</th>
			<th>Name</th>
			<th>Price</th>
			<th>Category</th>
			<th>Details</th>
			<th>Action</th>
		</tr>
		<?php echo $product_list; ?>
	  </table>
    </div>
</div>
</body>
</html>